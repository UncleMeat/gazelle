<?

authorize();

header('Content-Type: application/json; charset=utf-8');

include(SERVER_ROOT . '/sections/torrents/functions.php');

$UserID = $LoggedUser['ID'];
$GroupID = db_string($_POST['groupid']);

if (!is_number($GroupID) || !$GroupID) {
    error(0, true);
}

$DB->query("SELECT UserID FROM torrents WHERE GroupID='$GroupID'");
list($AuthorID) = $DB->next_record();
$IsAuthor = $AuthorID == $UserID;
 
if (!check_perms('site_add_tag') && !$IsAuthor) error(403,true);

$Tags = explode(' ', $_POST['tagname']);
$VoteValue = $IsAuthor ? 9 : 4;
$Results = array();
$CheckedTags = array();
$AddedTags = array();
$AddedIDs = array();

foreach ($Tags as $Tag) {
    $Tag = trim($Tag, '.'); // trim whitespace & dots from the beginning and end
    if (!check_perms('site_add_multiple_tags') && count($CheckedTags)>0 ){
        $Results[] = array(0, "You cannot enter multiple tags.");
        break;
    }
    if ($Tag && !in_array($Tag, $CheckedTags)) {
        $CheckedTags[]=$Tag;
        
        if ( !is_valid_tag($Tag)){
            $Results[] = array(0, "$Tag is not a valid tag.");
            continue;
        }
        $TagName = get_tag_synonym($Tag);
        
        if ($Tag != $TagName && in_array($TagName, $CheckedTags)) {
            $Results[] = array(0, "$Tag --> $TagName : already added.");
            continue;
        } 
        
        $DB->query("SELECT ID FROM tags WHERE Name='".$TagName."'");
        if ($DB->record_count() > 0) { 
            list($TagID) = $DB->next_record();
        } else {
            $DB->query("INSERT INTO tags (Name, UserID, Uses) VALUES ('$TagName', '$UserID', '0')");
            $TagID = $DB->inserted_id(); 
        }
          
        if ($TagID) {
            
            $DB->query("SELECT TagID FROM torrents_tags_votes 
                                WHERE GroupID='$GroupID' AND TagID='$TagID' AND UserID='$UserID'");
            if ($DB->record_count() != 0) { // User has already added/voted on this tag+torrent so dont count again 
                if ($Tag != $TagName) { // this was a synonym replacement
                    $Results[] = array(0, "$Tag --> $TagName : already added.");
                } else {
                    $Results[] = array(0, "$TagName is already added.");
                }
                continue;
            }

            $AddedTags[] = $TagName;
            $AddedIDs[] = $TagID;
   
            if ($Tag != $TagName) // this was a synonym replacement
                //$Results[] = array(1, "Added tag $TagName as a synonym of $Tag");
                $Results[] = array(1, "Added $Tag --> $TagName");
            else
                $Results[] = array(1, "Added $TagName"); 
            
       }
    }
}

$count =count($AddedIDs);
if ($count>0){
    
    $Values = "('".implode("', '$GroupID', '$VoteValue', '$UserID'), ('", $AddedIDs)."', '$GroupID', '$VoteValue', '$UserID')";

    $DB->query("INSERT INTO torrents_tags 
                              (TagID, GroupID, PositiveVotes, UserID) VALUES 
                              $Values
                              ON DUPLICATE KEY UPDATE PositiveVotes=PositiveVotes+1");
    
    $DB->query("UPDATE tags SET Uses=Uses+1 WHERE ID IN (".implode(',',$AddedIDs).")");
    
    $Values = "('$GroupID', '".implode("', '$UserID', 'up'), ('$GroupID', '", $AddedIDs)."', '$UserID', 'up')";

    $DB->query("INSERT IGNORE INTO torrents_tags_votes (GroupID, TagID, UserID, Way) VALUES $Values");

    $DB->query("INSERT INTO group_log (GroupID, UserID, Time, Info)
                  VALUES ('$GroupID'," . $LoggedUser['ID'] . ",'" . sqltime() . "','" . db_string('Tag'.($count>1?'s':''). " ".implode(', ',$AddedTags)." added to torrent") . "')");
      
    update_hash($GroupID); // Delete torrent group cache
 
    echo json_encode(array($Results, get_taglist_html($GroupID, $_POST['tagsort'])));

    
} else { //none actually added
    
    echo json_encode(array($Results, 0));
}
       

?>
