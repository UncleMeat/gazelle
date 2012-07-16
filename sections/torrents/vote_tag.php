<?

header('Content-Type: application/json; charset=utf-8');

$UserID = $LoggedUser['ID'];
$TagID = db_string($_POST['tagid']);
$GroupID = db_string($_POST['groupid']);
$Way = db_string($_POST['way']);


if(!is_number($TagID) || !is_number($GroupID)) {
	error(0,true);
}
if(!in_array($Way, array('up', 'down'))) {
	error(0,true);
}

$DB->query("SELECT TagID FROM torrents_tags_votes WHERE TagID='$TagID' AND GroupID='$GroupID' AND UserID='$UserID' AND Way='$Way'");
if($DB->record_count() == 0) {
	if($Way == 'down') {
          echo -1;
		$Change = 'NegativeVotes=NegativeVotes+1';
	} else {
          echo 1;
		$Change = 'PositiveVotes=PositiveVotes+1';
	}
	$DB->query("UPDATE torrents_tags SET $Change WHERE TagID='$TagID' AND GroupID='$GroupID'");
	$DB->query("INSERT INTO torrents_tags_votes (GroupID, TagID, UserID, Way) VALUES ('$GroupID', '$TagID', '$UserID', '$Way')");
	$Cache->delete_value('torrents_details_'.$GroupID); // Delete torrent group cache
      //echo json_encode(array());
} else 
    echo 0;
//header("Location: torrents.php?id=$GroupID");
?>
