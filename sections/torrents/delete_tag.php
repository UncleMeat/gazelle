<?
$TagID = db_string($_GET['tagid']);
$GroupID = db_string($_GET['groupid']);

if(!is_number($TagID) || !is_number($GroupID)) {
	error(404);
}

$DB->query("SELECT Name, TagType FROM tags WHERE ID='$TagID'");
list($TagName, $TagType) = $DB->next_record();
if (!$TagName) error(403);
        
if(!check_perms('site_delete_tag')) {
    //only need to check this if not already permitted
    $DB->query("SELECT t.UserID, tt.UserID 
                  FROM torrents AS t 
             LEFT JOIN torrents_tags AS tt 
                    ON t.GroupID=tt.GroupID 
                   AND tt.TagID='$TagID'
                 WHERE t.GroupID='$GroupID'");
    list($AuthorID,$OwnerID) = $DB->next_record();
    // must be both torrent owner and tag owner to delete
    if ($AuthorID!=$OwnerID || $AuthorID!=$LoggedUser['ID']) error(403);
}
 
$DB->query("INSERT INTO group_log (GroupID, UserID, Time, Info)
				VALUES ('$GroupID',".$LoggedUser['ID'].",'".sqltime()."','".db_string('Tag "'.$TagName.'" removed from group')."')");
 

$DB->query("DELETE FROM torrents_tags_votes WHERE GroupID='$GroupID' AND TagID='$TagID'");
$DB->query("DELETE FROM torrents_tags WHERE GroupID='$GroupID' AND TagID='$TagID'");

$Cache->delete_value('torrents_details_'.$GroupID); // Delete torrent group cache
update_hash($GroupID);

// Decrease the tag count, if it's not in use any longer and not an official tag, delete it from the list.
$DB->query("SELECT COUNT(GroupID) FROM torrents_tags WHERE TagID=".$TagID);
list($Count) = $DB->next_record();
if ($TagType == 'genre' || $Count > 0) {
    $Count = $Count > 0 ? $Count : 0;
    $DB->query("UPDATE tags SET Uses=$Count WHERE ID=$TagID");
} else {
    $DB->query("DELETE FROM tags WHERE ID=".$TagID." AND TagType='other'");
}
header('Location: '.$_SERVER['HTTP_REFERER']);
?>
