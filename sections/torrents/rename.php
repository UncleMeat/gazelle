<?
authorize();

include(SERVER_ROOT.'/classes/class_text.php');

$GroupID = $_POST['groupid'];
$OldGroupID = $GroupID;
$NewName = db_string( trim( $_POST['name']) );

if(!$GroupID || !is_number($GroupID)) { error(404); }

if(empty($NewName)) {
	error("Torrents cannot have a blank name");
}

$DB->query("SELECT UserID FROM torrents WHERE GroupID='$GroupID'");
if($DB->record_count() > 0) {
    list($AuthorID) = $DB->next_record();
} else {
    $AuthorID = null;
}
$CanEdit = check_perms('torrents_edit') || ($AuthorID == $LoggedUser['ID']);

if(!$CanEdit) { error(403); }

$Text = new TEXT;

$DB->query("SELECT Name, Body FROM torrents_group WHERE ID = ".$GroupID);
list($OldName, $Body) = $DB->next_record();
//$SearchText = db_string($NewName . ' ' . $Text->db_clean_search($Body));
$SearchText = $NewName . ' ' . db_string($Text->db_clean_search(trim($Body)));

$DB->query("UPDATE torrents_group SET Name='$NewName', SearchText='$SearchText' WHERE ID='$GroupID'");
$Cache->delete_value('torrents_details_'.$GroupID);

update_hash($GroupID);

write_log("Torrent Group ".$GroupID." (".$OldName.")  was renamed to '".$NewName."' by ".$LoggedUser['Username']);
write_group_log($GroupID, 0, $LoggedUser['ID'], "renamed to ".$NewName." from ".$OldName, 0);

header('Location: torrents.php?id='.$GroupID."&did=2");
