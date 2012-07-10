<?
$UserID = $LoggedUser['ID'];
$TagID = db_string($_GET['tagid']);
$GroupID = db_string($_GET['groupid']);
$Way = db_string($_GET['way']);

if(!is_number($TagID) || !is_number($GroupID)) {
	error(404);
}
if(!in_array($Way, array('up', 'down'))) {
	error(404);
}

$DB->query("SELECT TagID FROM torrents_tags_votes WHERE TagID='$TagID' AND GroupID='$GroupID' AND UserID='$UserID' AND Way='$Way'");
if($DB->record_count() == 0) {
	if($Way == 'down') {
		$Change = 'NegativeVotes=NegativeVotes+1';
	} else {
		$Change = 'PositiveVotes=PositiveVotes+1';
	}
	$DB->query("UPDATE torrents_tags SET $Change WHERE TagID='$TagID' AND GroupID='$GroupID'");
	$DB->query("INSERT INTO torrents_tags_votes (GroupID, TagID, UserID, Way) VALUES ('$GroupID', '$TagID', '$UserID', '$Way')");
	$Cache->delete_value('torrents_details_'.$GroupID); // Delete torrent group cache
}
//header('Location: '.$_SERVER['HTTP_REFERER']);
header("Location: torrents.php?id=$GroupID");
?>
