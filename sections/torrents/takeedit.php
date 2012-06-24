<?
//******************************************************************************//
//--------------- Take edit ----------------------------------------------------//
// This pages handles the backend of the 'edit torrent' function. It checks     //
// the data, and if it all validates, it edits the values in the database	//
// that correspond to the torrent in question.                                  //
//******************************************************************************//

enforce_login();
authorize();


require(SERVER_ROOT.'/classes/class_validate.php');
$Validate = new VALIDATE;

//******************************************************************************//
//--------------- Set $Properties array ----------------------------------------//
// This is used if the form doesn't validate, and when the time comes to enter  //
// it into the database.                                                        //
//******************************************************************************//

$Properties=array();
$Type = $Categories[$TypeID-1];
$TorrentID = (int)$_POST['torrentid'];
$Properties['BadTags'] = (isset($_POST['bad_tags']))? 1 : 0;
$Properties['BadFolders'] = (isset($_POST['bad_folders']))? 1 : 0;
$Properties['BadFiles'] = (isset($_POST['bad_files'])) ? 1 : 0;
$Properties['Trumpable'] = (isset($_POST['make_trumpable'])) ? 1 : 0;
$Properties['TorrentDescription'] = $_POST['release_desc'];
$Properties['Name'] = $_POST['title'];
if($_POST['album_desc']) {
	$Properties['GroupDescription'] = $_POST['album_desc'];
}
if(check_perms('torrents_freeleech')) {
	$Free = (int)$_POST['freeleech'];
	if(!in_array($Free, array(0,1,2))) {
		error(404);
	}
	$Properties['FreeLeech'] = $Free;
      /*
	if($Free == 0) {
		$FreeType = 0;
	} else {
		$FreeType = (int)$_POST['freeleechtype'];
		if(!in_array($Free, array(0,1,2,3))) {
			error(404);
		}
	}
	$Properties['FreeLeechType'] = $FreeType;
       */
}

//******************************************************************************//
//--------------- Validate data in edit form -----------------------------------//

$DB->query('SELECT UserID, FreeTorrent FROM torrents WHERE ID='.$TorrentID);
list($UserID, $CurFreeLeech) = $DB->next_record(MYSQLI_BOTH, false);

if($LoggedUser['ID']!=$UserID && !check_perms('torrents_edit')) {
	error(403);
}

// TODO: Lanz, this needs to be modified, and some proper handeling of other peoples torrents needs to be implemented.
/*
if($Properties['UnknownRelease'] && !($Remastered == '1' && !$RemasterYear) && !check_perms('edit_unknowns')) {
	//It's Unknown now, and it wasn't before
	$DB->query("SELECT UserID FROM torrents WHERE ID = ".$TorrentID);
	list($UploaderID) = $DB->next_record();
	if($LoggedUser['ID'] != $UploaderID) {
		//Hax
		die();
	}
}
*/

$Err = $Validate->ValidateForm($_POST); // Validate the form

// Lanz: Same here
/*
if($Properties['Remastered'] && !$Properties['RemasterYear']) {
	//Unknown Edit!
	if($LoggedUser['ID'] == $UserID || check_perms('edit_unknowns')) {
		//Fine!
	} else {
		$Err = "You may not edit somebody elses upload to unknown";
	}
}
*/

// Strip out amazon's padding
$AmazonReg = '/(http:\/\/ecx.images-amazon.com\/images\/.+)(\._.*_\.jpg)/i';
$Matches = array();

if (preg_match($RegX, $Properties['Image'], $Matches)) {
	$Properties['Image'] = $Matches[1].'.jpg';
}

if($Err){ // Show the upload form, with the data the user entered
	if(check_perms('site_debug')) {
		die($Err);
	}
	error($Err);
}


//******************************************************************************//
//--------------- Make variables ready for database input ----------------------//

// Shorten and escape $Properties for database input
$T = array();
foreach ($Properties as $Key => $Value) {
	$T[$Key]="'".db_string(trim($Value))."'";
	if(!$T[$Key]){
		$T[$Key] = NULL;
	}
}


//******************************************************************************//
//--------------- Start database stuff -----------------------------------------//

$DBTorVals = array();
$DB->query("SELECT Description FROM torrents WHERE ID = ".$TorrentID);
$DBTorVals = $DB->to_array(false, MYSQLI_ASSOC);
$DBTorVals = $DBTorVals[0];
$LogDetails = "";
foreach ($DBTorVals as $Key => $Value) {
	$Value = "'".$Value."'";
	if ($Value != $T[$Key]) {
		if (!isset($T[$Key])) {
			continue;
		}
		if ((empty($Value) && empty($T[$Key])) || ($Value == "'0'" && $T[$Key] == "''")) {
			continue;
		}
		if ($LogDetails == "") {
			$LogDetails = $Key.": ".$Value." -> ".$T[$Key];
		} else {
			$LogDetails = $LogDetails.", ".$Key.": ".$Value." -> ".$T[$Key];
		}
	}
}

// Update info for the torrent
$SQL = "
	UPDATE torrents SET
		Description=$T[TorrentDescription],";

if(check_perms('torrents_freeleech')) {
	$SQL .= "FreeTorrent=$T[FreeLeech],";
	//$SQL .= "FreeLeechType=$T[FreeLeechType],";
}

if(check_perms('users_mod')) {
	$DB->query("SELECT TorrentID FROM torrents_bad_tags WHERE TorrentID='$TorrentID'");
	list($btID) = $DB->next_record();

	if (!$btID && $Properties['BadTags']) {
		$DB->query("INSERT INTO torrents_bad_tags VALUES($TorrentID, $LoggedUser[ID], '".sqltime()."')");
	}
	if ($btID && !$Properties['BadTags']) {
		$DB->query("DELETE FROM torrents_bad_tags WHERE TorrentID='$TorrentID'");
	}

	$DB->query("SELECT TorrentID FROM torrents_bad_folders WHERE TorrentID='$TorrentID'");
	list($bfID) = $DB->next_record();

	if (!$bfID && $Properties['BadFolders']) {
		$DB->query("INSERT INTO torrents_bad_folders VALUES($TorrentID, $LoggedUser[ID], '".sqltime()."')");
	}
	if ($bfID && !$Properties['BadFolders']) {
		$DB->query("DELETE FROM torrents_bad_folders WHERE TorrentID='$TorrentID'");
	}

	$DB->query("SELECT TorrentID FROM torrents_bad_files WHERE TorrentID='$TorrentID'");
	list($bfiID) = $DB->next_record();

	if (!$bfiID && $Properties['BadFiles']) {
		$DB->query("INSERT INTO torrents_bad_files VALUES($TorrentID, $LoggedUser[ID], '".sqltime()."')");
	}
	if ($bfiID && !$Properties['BadFiles']) {
		$DB->query("DELETE FROM torrents_bad_files WHERE TorrentID='$TorrentID'");
	}
}

$SQL .= "
	flags='2'
	WHERE ID=$TorrentID
";
$DB->query($SQL);

if(check_perms('torrents_freeleech') && $Properties['FreeLeech'] != $CurFreeLeech) {
	freeleech_torrents($TorrentID, $Properties['FreeLeech']);     //, $Properties['FreeLeechType']);
}

$DB->query("SELECT GroupID, Time FROM torrents WHERE ID='$TorrentID'");
list($GroupID, $Time) = $DB->next_record();

$DB->query("SELECT Name FROM torrents_group WHERE ID=$GroupID");
list($Name) = $DB->next_record();

write_log("Torrent $TorrentID ($Name) in group $GroupID was edited by ".$LoggedUser['Username']." (".$LogDetails.")"); // TODO: this is probably broken
write_group_log($GroupID, $TorrentID, $LoggedUser['ID'], $LogDetails, 0);
$Cache->delete_value('torrents_details_'.$GroupID);
$Cache->delete_value('torrent_download_'.$TorrentID);

update_hash($GroupID);
// All done!

header("Location: torrents.php?id=$GroupID");
?>
