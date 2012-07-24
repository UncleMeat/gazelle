<?

authorize();

include(SERVER_ROOT . '/sections/torrents/functions.php');

$UserID = $LoggedUser['ID'];
$GroupID = db_string($_POST['groupid']);

if (!is_number($GroupID) || !$GroupID) {
    error(0);
}

$DB->query("SELECT UserID FROM torrents WHERE GroupID='$GroupID'");
list($AuthorID) = $DB->next_record();
$VoteValue = $AuthorID == $UserID ? 9 : 4;

$Tags = explode(',', $_POST['tagname']);
foreach ($Tags as $Tag) {
    $Tag = trim($Tag, '.'); // trim dots from the beginning and end
    $Tag = sanitize_tag($Tag);
    $TagName = get_tag_synomyn($Tag);
    if (!empty($TagName)) {
        /*
          $DB->query("INSERT INTO tags (Name, UserID) VALUES ('".$TagName."', ".$UserID.") ON DUPLICATE KEY UPDATE Uses=Uses+1");
          $TagID = $DB->inserted_id(); */

        $DB->query("SELECT ID FROM tags WHERE Name LIKE '" . $TagName . "'");
        list($TagID) = $DB->next_record();
        if ($TagID) {
            $DB->query("SELECT TagID FROM torrents_tags_votes 
                                WHERE GroupID='$GroupID' AND TagID='$TagID' AND UserID='$UserID'");
            if ($DB->record_count() != 0) { // User has already added/voted on this tag+torrent so dont count again 
                if ($Tag != $TagName) // this was a synomyn replacement
                    $Get = "&did=5&synomyn=" . $Tag;
                else
                    $Get = "&did=4";
                $Get .= "&addedtag=" . $TagName;
                //header('Location: '.$_SERVER['HTTP_REFERER'].$Get);
                header("Location: torrents.php?id=" . $GroupID . $Get);
                die();
            }
        } else {
            // if it gets to here then its a new tag for this torrent, try adding/inc uses for tags
            $DB->query("INSERT INTO tags (Name, UserID) VALUES ('" . $TagName . "', " . $UserID . ") ON DUPLICATE KEY UPDATE Uses=Uses+1");
            $TagID = $DB->inserted_id();
        }

        $DB->query("INSERT INTO torrents_tags 
                      (TagID, GroupID, PositiveVotes, UserID) VALUES 
                      ('$TagID', '$GroupID', '$VoteValue', '$UserID') 
                      ON DUPLICATE KEY UPDATE PositiveVotes=PositiveVotes+1");

        $DB->query("INSERT IGNORE INTO torrents_tags_votes (GroupID, TagID, UserID, Way) VALUES ('$GroupID', '$TagID', '$UserID', 'up')");

        $DB->query("INSERT INTO group_log (GroupID, UserID, Time, Info)
					VALUES ('$GroupID'," . $LoggedUser['ID'] . ",'" . sqltime() . "','" . db_string('Tag "' . $TagName . '" added to group') . "')");
    }
}

update_hash($GroupID); // Delete torrent group cache
if ($Tag != $TagName) // this was a synomyn replacement
    $Get = "&did=3&synomyn=" . $Tag;
else
    $Get = "&did=3";
$Get .= "&addedtag=" . $TagName;
//header('Location: '.$_SERVER['HTTP_REFERER'].$Get); 
header("Location: torrents.php?id=" . $GroupID . $Get);
?>
