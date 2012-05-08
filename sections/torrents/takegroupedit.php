<?

authorize();

include(SERVER_ROOT.'/classes/class_text.php');
$Text = new TEXT;

// Quick SQL injection check
if(!$_REQUEST['groupid'] || !is_number($_REQUEST['groupid'])) {
	error(404);
}
// End injection check

if(!check_perms('site_edit_wiki')) { error(403); }

// Variables for database input
$UserID = $LoggedUser['ID'];
$GroupID = $_REQUEST['groupid'];

 // with edit, the variables are passed with POST
$Body = $_POST['body'];
$Image = $_POST['image'];

// Trickery
if(!preg_match("/^".URL_REGEX."$/i", $Image)) {
        $Image = '';
}
$Summary = db_string($_POST['summary']);

$Body = db_string($Body);
$Image = db_string($Image);

// Update torrents table
$DB->query("UPDATE torrents_group SET 
	Body='$Body',
	Image='$Image'
	WHERE ID='$GroupID'");
// Log VH changes

// There we go, all done!
$Cache->delete_value('torrents_details_'.$GroupID);
$DB->query("SELECT CollageID FROM collages_torrents WHERE GroupID='$GroupID'");
if($DB->record_count()>0) {
	while(list($CollageID) = $DB->next_record()) {
		$Cache->delete_value('collage_'.$CollageID);
	}
}

//Fix Recent Uploads/Downloads for image change
$DB->query("SELECT DISTINCT UserID
			FROM torrents AS t
			LEFT JOIN torrents_group AS tg ON t.GroupID=tg.ID
			WHERE tg.ID = $GroupID");

$UserIDs = $DB->collect('UserID');
foreach($UserIDs as $UserID) {
	$RecentUploads = $Cache->get_value('recent_uploads_'.$UserID);
	if(is_array($RecentUploads)) {
		foreach($RecentUploads as $Key => $Recent) {
			if($Recent['ID'] == $GroupID) {
				if($Recent['Image'] != $Image) {
					$Recent['Image'] = $Image;
					$Cache->begin_transaction('recent_uploads_'.$UserID);
					$Cache->update_row($Key, $Recent);
					$Cache->commit_transaction(0);
				}
			}
		}
	}
}

$DB->query("SELECT ID FROM torrents WHERE GroupID = ".$GroupID);
$TorrentIDs = implode(",", $DB->collect('ID'));
$DB->query("SELECT DISTINCT uid FROM xbt_snatched WHERE fid IN (".$TorrentIDs.")");
$Snatchers = $DB->collect('uid');
foreach($Snatchers as $UserID) {
	$RecentSnatches = $Cache->get_value('recent_snatches_'.$UserID);
	if(is_array($RecentSnatches)) {
		foreach($RecentSnatches as $Key => $Recent) {
			if($Recent['ID'] == $GroupID) {
				if($Recent['Image'] != $Image) {
					$Recent['Image'] = $Image;
					$Cache->begin_transaction('recent_snatches_'.$UserID);
					$Cache->update_row($Key, $Recent);
					$Cache->commit_transaction(0);
				}
			}
		}
	}
}

header("Location: torrents.php?id=".$GroupID);
?>
