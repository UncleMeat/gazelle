<?
authorize();

$UserID = $LoggedUser['ID'];
$GroupID = db_string($_POST['groupid']);

if(!is_number($GroupID) || !$GroupID) {
	error(0);
}

$Tags = explode(',', $_POST['tagname']);
foreach($Tags as $TagName) {
	$TagName = sanitize_tag($TagName);
	if(!empty($TagName)) {
                $DB->query("INSERT INTO tags (Name, UserID) VALUES ('".$TagName."', ".$UserID.") ON DUPLICATE KEY UPDATE Uses=Uses+1");
                $TagID = $DB->inserted_id();
                $DB->query("SELECT TagID FROM torrents_tags_votes WHERE GroupID='$GroupID' AND TagID='$TagID' AND UserID='$UserID'");
                if($DB->record_count()!=0) { // User has already voted on this tag, and is trying hax to make the rating go up
                        header('Location: '.$_SERVER['HTTP_REFERER']);
                        die();
                }
	
		$DB->query("INSERT INTO torrents_tags 
			(TagID, GroupID, PositiveVotes, UserID) VALUES 
			('$TagID', '$GroupID', '3', '$UserID') 
			ON DUPLICATE KEY UPDATE PositiveVotes=PositiveVotes+2");
	
		$DB->query("INSERT INTO torrents_tags_votes (GroupID, TagID, UserID, Way) VALUES ('$GroupID', '$TagID', '$UserID', 'up')");
		
		$DB->query("INSERT INTO group_log (GroupID, UserID, Time, Info)
					VALUES ('$GroupID',".$LoggedUser['ID'].",'".sqltime()."','".db_string('Tag "'.$TagName.'" added to group')."')");
	}
}

update_hash($GroupID); // Delete torrent group cache
header('Location: '.$_SERVER['HTTP_REFERER']);
?>
