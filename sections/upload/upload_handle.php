<?
//******************************************************************************//
//--------------- Take upload --------------------------------------------------//
// This pages handles the backend of the torrent upload function. It checks	 //
// the data, and if it all validates, it builds the torrent file, then writes   //
// the data to the database and the torrent to the disk.						//
//******************************************************************************//

ini_set('upload_max_filesize', 2097152);
ini_set('max_file_uploads', 100);
require(SERVER_ROOT . '/classes/class_torrent.php');
include(SERVER_ROOT . '/classes/class_validate.php');
include(SERVER_ROOT . '/classes/class_feed.php');
include(SERVER_ROOT . '/classes/class_text.php');
include(SERVER_ROOT . '/sections/torrents/functions.php');

enforce_login();
authorize();


$Validate = new VALIDATE;
$Feed = new FEED;
$Text = new TEXT;

define('QUERY_EXCEPTION', true); // Shut up debugging
//******************************************************************************//
//--------------- Set $Properties array ----------------------------------------//
// This is used if the form doesn't validate, and when the time comes to enter  //
// it into the database.														//

// trim whitespace before setting/evaluating these fields
$_POST['image'] = trim($_POST['image']);
$_POST['desc'] = trim($_POST['desc']);
$_POST['title'] = trim($_POST['title']);

$Properties = array();
$NewCategory = $_POST['category'];
$Properties['Title'] = $_POST['title'];
$Properties['Remastered'] = (isset($_POST['remaster'])) ? 1 : 0;
if ($Properties['Remastered'] || isset($_POST['unknown'])) {
    $Properties['UnknownRelease'] = (isset($_POST['unknown'])) ? 1 : 0;
    $Properties['RemasterYear'] = $_POST['remaster_year'];
    $Properties['RemasterTitle'] = $_POST['remaster_title'];
    $Properties['RemasterRecordLabel'] = $_POST['remaster_record_label'];
    $Properties['RemasterCatalogueNumber'] = $_POST['remaster_catalogue_number'];
}
if (!$Properties['Remastered'] || $Properties['UnknownRelease']) {
    $Properties['UnknownRelease'] = 1;
    $Properties['RemasterYear'] = '';
    $Properties['RemasterTitle'] = '';
    $Properties['RemasterRecordLabel'] = '';
    $Properties['RemasterCatalogueNumber'] = '';
}
$Properties['Year'] = $_POST['year'];
$Properties['RecordLabel'] = $_POST['record_label'];
$Properties['CatalogueNumber'] = $_POST['catalogue_number'];
$Properties['ReleaseType'] = $_POST['releasetype'];
$Properties['Scene'] = (isset($_POST['scene'])) ? 1 : 0;
$Properties['Format'] = $_POST['format'];
$Properties['Media'] = $_POST['media'];
$Properties['TagList'] = $_POST['tags'];
$Properties['Image'] = $_POST['image'];
$Properties['GroupDescription'] = $_POST['album_desc'];
if ($_POST['vanity_house'] && check_perms('torrents_edit_vanityhouse')) {
    $Properties['VanityHouse'] = 1;
} else {
    $Properties['VanityHouse'] = 0;
}
$Properties['TorrentDescription'] = $_POST['release_desc'];
if ($_POST['album_desc']) {
    $Properties['GroupDescription'] = $_POST['album_desc'];
} elseif ($_POST['desc']) {
    $Properties['GroupDescription'] = $_POST['desc'];
}
$Properties['GroupID'] = $_POST['groupid'];
if (empty($_POST['artists'])) {
    $Err = "You didn't enter any artists";
} else {
    $Artists = $_POST['artists'];
    $Importance = $_POST['importance'];
}
$RequestID = $_POST['requestid'];
//******************************************************************************//
//--------------- Validate data in upload form ---------------------------------//
//** note: if the same field is set to be validated more than once then each time it is set it overwrites the previous test
//** ie.. one test per field max, last one set for a specific field is what is used
$Validate->SetFields('title', '1', 'string', 'Title must be between 2 and 200 characters.', array('maxlength' => 200, 'minlength' => 2));

$Validate->SetFields('tags', '1', 'string', 'You must enter at least one tag. Maximum length is 200 characters.', array('maxlength' => 200, 'minlength' => 2));

//$Validate->SetFields('release_desc', '0', 'string', 'The release description has a minimum length of 10 characters.', array('maxlength' => 1000000, 'minlength' => 10));

$whitelist_regex = $Validate->GetWhitelistRegex();

$Validate->SetFields('image', '0', 'image', 'The image URL you entered was not valid.', array('regex' => $whitelist_regex, 'maxlength' => 255, 'minlength' => 12));

//$Validate->SetFields('desc',
//	'1','string','The description has a minimum length of 100 characters.',array('maxlength'=>1000000, 'minlength'=>100));

$Validate->SetFields('desc', '1', 'desc', 'Description', array('regex' => $whitelist_regex, 'maxlength' => 1000000, 'minlength' => 20));


$Validate->SetFields('category', '1', 'inarray', 'Please select a valid format.', array('inarray' => array_keys($NewCategories)));

$Validate->SetFields('rules', '1', 'require', 'Your torrent must abide by the rules.');

$Err = $Validate->ValidateForm($_POST); // Validate the form



$File = $_FILES['file_input']; // This is our torrent file
$TorrentName = $File['tmp_name'];

if (!is_uploaded_file($TorrentName) || !filesize($TorrentName)) {
    $Err = 'No torrent file uploaded, or file is empty.';
} else if (substr(strtolower($File['name']), strlen($File['name']) - strlen(".torrent")) !== ".torrent") {
    $Err = "You seem to have put something other than a torrent file into the upload field. (" . $File['name'] . ").";
}

$LogScoreAverage = 0;
$SendPM = 0;
$LogMessage = "";
$CheckStamp = "";

if (!$Err && $Properties['Format'] == 'FLAC') {
    foreach ($_FILES['logfiles']['name'] as $FileName) {
        if (!empty($FileName) && substr(strtolower($FileName), strlen($FileName) - strlen(".log")) !== ".log") {
            $Err = "You seem to have put something other than an EAC or XLD log file into an upload field. (" . $FileName . ").";
            break;
        }
    }
    //There is absolutely no point in checking the type of the file upload as its interpretation of the type is decided by the client.
    /* 	foreach($_FILES['logfiles']['type'] as $FileType) {
      if(!empty($FileType) && $FileType != "text/plain" && $FileType != "text/x-log" && $FileType != "application/octet-stream" && $FileType != "text/richtext") {
      $Err = "You seem to have put something other than an EAC or XLD log file into an upload field. (".$FileType.")";
      break;
      }
      } */
}

if ($Err) { // Show the upload form, with the data the user entered
    include(SERVER_ROOT . '/sections/upload/upload.php');
    die();
}

//******************************************************************************//
//--------------- Make variables ready for database input ----------------------//
// Shorten and escape $Properties for database input
$T = array();
foreach ($Properties as $Key => $Value) {
    $T[$Key] = "'" . db_string(trim($Value)) . "'";
    if (!$T[$Key]) {
        $T[$Key] = NULL;
    }
}

$SearchText = db_string(trim($Properties['Artist']) . ' ' . trim($Properties['Title']) . ' ' . trim($Properties['Year']));


//******************************************************************************//
//--------------- Generate torrent file ----------------------------------------//


$File = fopen($TorrentName, 'rb'); // open file for reading
$Contents = fread($File, 10000000);
$Tor = new TORRENT($Contents); // New TORRENT object
fclose($File);

// Remove uploader's passkey from the torrent.
// We put the downloader's passkey in on download, so it doesn't matter what's in there now,
// so long as it's not useful to any leet hax0rs looking in an unprotected /torrents/ directory
$Tor->set_announce_url('ANNOUNCE_URL'); // We just use the string "ANNOUNCE_URL"
// $Private is true or false. true means that the uploaded torrent was private, false means that it wasn't.
$Private = $Tor->make_private();
// The torrent is now private.
// File list and size
list($TotalSize, $FileList) = $Tor->file_list();

$TmpFileList = array();
$HasLog = "'0'";
$HasCue = "'0'";

foreach ($FileList as $File) {
    list($Size, $Name) = $File;

    if (preg_match('/INCOMPLETE~\*/i', $Name)) {
        $Err = 'The torrent contained one or more forbidden files (' . $Name . ').';
    }
    if (preg_match('/\?/i', $Name)) {
        $Err = 'The torrent contains one or more files with a ?, which is a forbidden character. Please rename the files as necessary and recreate the .torrent file.';
    }
    if (preg_match('/\:/i', $Name)) {
        $Err = 'The torrent contains one or more files with a :, which is a forbidden character. Please rename the files as necessary and recreate the .torrent file.';
    }
    // Add file and size to array
    $TmpFileList [] = $Name . '{{{' . $Size . '}}}'; // Name {{{Size}}}
}

// To be stored in the database
$FilePath = $Tor->Val['info']->Val['files'] ? db_string($Tor->Val['info']->Val['name']) : "";

// Name {{{Size}}}|||Name {{{Size}}}|||Name {{{Size}}}|||Name {{{Size}}}
$FileString = "'" . db_string(implode('|||', $TmpFileList)) . "'";

// Number of files described in torrent
$NumFiles = count($FileList);

// The string that will make up the final torrent file
$TorrentText = $Tor->enc();


// Infohash

$InfoHash = pack("H*", sha1($Tor->Val['info']->enc()));
$DB->query("SELECT ID FROM torrents WHERE info_hash='" . db_string($InfoHash) . "'");
if ($DB->record_count() > 0) {
    list($ID) = $DB->next_record();
    $DB->query("SELECT TorrentID FROM torrents_files WHERE TorrentID = " . $ID);
    if ($DB->record_count() > 0) {
        $Err = '<a href="torrents.php?torrentid=' . $ID . '">The exact same torrent file already exists on the site!</a>';
    } else {
        //One of the lost torrents.
        $DB->query("INSERT INTO torrents_files (TorrentID, File) VALUES ($ID, '" . db_string($Tor->dump_data()) . "')");
        $Err = '<a href="torrents.php?torrentid=' . $ID . '">Thankyou for fixing this torrent</a>';
    }
}


if (!empty($Err)) { // Show the upload form, with the data the user entered
    include(SERVER_ROOT . '/sections/upload/upload.php');
    die();
}

//******************************************************************************//
//--------------- Start database stuff -----------------------------------------//

$Body = $Properties['GroupDescription'];
// Trickery
if (!preg_match("/^" . URL_REGEX . "$/i", $Properties['Image'])) {
    $Properties['Image'] = '';
    $T['Image'] = "''";
}


//Needs to be here as it isn't set for add format until now
$LogName .= $Properties['Title'];

//For notifications--take note now whether it's a new group
$IsNewGroup = !$GroupID;

//----- Start inserts
if (!$GroupID) {
    // Create torrent group
    $DB->query("
		INSERT INTO torrents_group
		(ArtistID, NewCategoryID, Name, Year, RecordLabel, CatalogueNumber, Time, WikiBody, WikiImage, SearchText, ReleaseType, VanityHouse) VALUES
		(0, " . $NewCategory . ", " . $T['Title'] . ", $T[Year], $T[RecordLabel], $T[CatalogueNumber], '" . sqltime() . "', '" . db_string($Body) . "', $T[Image], '$SearchText', $T[ReleaseType], $T[VanityHouse])");
    $GroupID = $DB->inserted_id();
    $Cache->increment('stats_group_count');
} else {
    $DB->query("UPDATE torrents_group SET
		Time='" . sqltime() . "'
		WHERE ID=$GroupID");
    $Cache->delete_value('torrent_group_' . $GroupID);
    $Cache->delete_value('torrents_details_' . $GroupID);
    $Cache->delete_value('detail_files_' . $GroupID);
}

// Description
if (!$NoRevision) {
    $DB->query("
		INSERT INTO wiki_torrents
		(PageID, Body, UserID, Summary, Time, Image) VALUES
		($GroupID, $T[GroupDescription], $LoggedUser[ID], 'Uploaded new torrent', '" . sqltime() . "', $T[Image])
		");
    $RevisionID = $DB->inserted_id();

    // Revision ID
    $DB->query("UPDATE torrents_group SET RevisionID='$RevisionID' WHERE ID=$GroupID");
}

// Tags
$Tags = explode(',', $Properties['TagList']);
if (!$Properties['GroupID']) {
    foreach ($Tags as $Tag) {
        $Tag = sanitize_tag($Tag);
        if (!empty($Tag)) {
            $DB->query("INSERT INTO tags
				(Name, UserID) VALUES
				('" . $Tag . "', $LoggedUser[ID])
				ON DUPLICATE KEY UPDATE Uses=Uses+1;
			");
            $TagID = $DB->inserted_id();

            $DB->query("INSERT INTO torrents_tags
				(TagID, GroupID, UserID, PositiveVotes) VALUES
				($TagID, $GroupID, $LoggedUser[ID], 10)
				ON DUPLICATE KEY UPDATE PositiveVotes=PositiveVotes+1;
			");
        }
    }
}

// Use this section to control freeleeches

/* if($HasLog == "'4'" && $LogScoreAverage== 100){

  $T['FreeLeech']="'1'";
  $T['FreeLeechType']="'1'";
  $DB->query("INSERT IGNORE INTO users_points (UserID, GroupID, Points) VALUES ('$LoggedUser[ID]', '$GroupID', '1')");
 */

/* if($T['Format'] == "'FLAC'") {
  $T['FreeLeech'] = "'1'";
  $T['FreeLeechType'] = "'1'";
  } else {
  $T['FreeLeech']="'0'";
  $T['FreeLeechType']="'0'";
  } */

$T['FreeLeech'] = "'0'";
$T['FreeLeechType'] = "'0'";

// Torrent
$DB->query("
	INSERT INTO torrents
		(GroupID, UserID, Media, Format, 
		Remastered, RemasterYear, RemasterTitle, RemasterRecordLabel, RemasterCatalogueNumber, 
		Scene, HasLog, HasCue, info_hash, FileCount, FileList, FilePath, Size, Time, 
		Description, LogScore, FreeTorrent, FreeLeechType) 
	VALUES
		(" . $GroupID . ", " . $LoggedUser['ID'] . ", " . $T['Media'] . ", " . $T['Format'] . ", 
		" . $T['Remastered'] . ", " . $T['RemasterYear'] . ", " . $T['RemasterTitle'] . ", " . $T['RemasterRecordLabel'] . ", " . $T['RemasterCatalogueNumber'] . ", 
		" . $T['Scene'] . ", " . $HasLog . ", " . $HasCue . ", '" . db_string($InfoHash) . "', " . $NumFiles . ", " . $FileString . ", '" . $FilePath . "', " . $TotalSize . ", '" . sqltime() . "',
		" . $T['TorrentDescription'] . ", '" . (($HasLog == "'1'") ? $LogScoreAverage : 0) . "', " . $T['FreeLeech'] . ", " . $T['FreeLeechType'] . ")");

$Cache->increment('stats_torrent_count');
$TorrentID = $DB->inserted_id();

update_tracker('add_torrent', array('id' => $TorrentID, 'info_hash' => rawurlencode($InfoHash), 'freetorrent' => (int) $Properties['FreeLeech']));



//******************************************************************************//
//--------------- Write torrent file -------------------------------------------//

$DB->query("INSERT INTO torrents_files (TorrentID, File) VALUES ($TorrentID, '" . db_string($Tor->dump_data()) . "')");

write_log("Torrent $TorrentID ($LogName) (" . number_format($TotalSize / (1024 * 1024), 2) . " MB) was uploaded by " . $LoggedUser['Username']);
write_group_log($GroupID, $TorrentID, $LoggedUser['ID'], "uploaded (" . number_format($TotalSize / (1024 * 1024), 2) . " MB)", 0);

update_hash($GroupID);




//******************************************************************************//
//--------------- Add the log scores to the DB ---------------------------------//

if (!empty($LogScores) && $HasLog) {
    $LogQuery = 'INSERT INTO torrents_logs_new (TorrentID,Log,Details,NotEnglish,Score,Revision,Adjusted,AdjustedBy,AdjustmentReason) VALUES (';
    foreach ($LogScores as $LogKey => $LogScore) {
        $LogScores[$LogKey] = "$TorrentID,$LogScore,1,0,0,NULL";
    }
    $LogQuery .= implode('),(', $LogScores) . ')';
    $DB->query($LogQuery);
    $LogInDB = true;
}

//******************************************************************************//
//--------------- Stupid Recent Uploads ----------------------------------------//

if (trim($Properties['Image']) != "") {
    $RecentUploads = $Cache->get_value('recent_uploads_' . $UserID);
    if (is_array($RecentUploads)) {
        do {
            foreach ($RecentUploads as $Item) {
                if ($Item['ID'] == $GroupID) {
                    break 2;
                }
            }

            // Only reached if no matching GroupIDs in the cache already.
            if (count($RecentUploads) == 5) {
                array_pop($RecentUploads);
            }
            array_unshift($RecentUploads, array('ID' => $GroupID, 'Name' => trim($Properties['Title']), 'Artist' => display_artists($ArtistForm, false, true), 'WikiImage' => trim($Properties['Image'])));
            $Cache->cache_value('recent_uploads_' . $UserID, $RecentUploads, 0);
        } while (0);
    }
}

//******************************************************************************//
//--------------- IRC announce and feeds ---------------------------------------//
$Announce = "";

$Announce .= trim($Properties['Title']) . " ";
$Title = $Announce;

$AnnounceSSL = $Announce . " - https://" . SSL_SITE_URL . "/torrents.php?id=$GroupID / https://" . SSL_SITE_URL . "/torrents.php?action=download&id=$TorrentID";
$Announce .= " - http://" . NONSSL_SITE_URL . "/torrents.php?id=$GroupID / http://" . NONSSL_SITE_URL . "/torrents.php?action=download&id=$TorrentID";

$AnnounceSSL .= " - " . trim($Properties['TagList']);
$Announce .= " - " . trim($Properties['TagList']);

send_irc('PRIVMSG #' . NONSSL_SITE_URL . '-announce :' . html_entity_decode($Announce));
send_irc('PRIVMSG #' . NONSSL_SITE_URL . '-announce-ssl :' . $AnnounceSSL);
//send_irc('PRIVMSG #'.NONSSL_SITE_URL.'-announce :'.html_entity_decode($Announce));
// Manage notifications

// For RSS
$Item = $Feed->item($Title, $Text->strip_bbcode($Body), 'torrents.php?action=download&amp;authkey=[[AUTHKEY]]&amp;torrent_pass=[[PASSKEY]]&amp;id=' . $TorrentID, $LoggedUser['Username'], 'torrents.php?id=' . $GroupID, trim($Properties['TagList']));


//Notifications
$SQL = "SELECT unf.ID, unf.UserID, torrent_pass
	FROM users_notify_filters AS unf
	JOIN users_main AS um ON um.ID=unf.UserID
	WHERE um.Enabled='1'";
if (empty($ArtistsUnescaped)) {
    $ArtistsUnescaped = $ArtistForm;
}
if (!empty($ArtistsUnescaped)) {
    $ArtistNameList = array();
    $GuestArtistNameList = array();
    foreach ($ArtistsUnescaped as $Importance => $Artists) {
        foreach ($Artists as $Artist) {
            if ($Importance == 1 || $Importance == 4 || $Importance == 5 || $Importance == 6) {
                $ArtistNameList[] = "Artists LIKE '%|" . db_string($Artist['name']) . "|%'";
            } else {
                $GuestArtistNameList[] = "Artists LIKE '%|" . db_string($Artist['name']) . "|%'";
            }
        }
    }
    // Don't add notification if >2 main artists or if tracked artist isn't a main artist
    if (count($ArtistNameList) > 2 || $Artist['name'] == 'Various Artists') {
        $SQL.= " AND (ExcludeVA='0' AND (";
        $SQL.= implode(" OR ", array_merge($ArtistNameList, $GuestArtistNameList));
        $SQL.= " OR Artists='')) AND (";
    } else {
        $SQL.= " AND (";
        if (!empty($GuestArtistNameList)) {
            $SQL.= "(ExcludeVA='0' AND (";
            $SQL.= implode(" OR ", $GuestArtistNameList);
            $SQL.= ")) OR ";
        }
        $SQL.= implode(" OR ", $ArtistNameList);
        $SQL.= " OR Artists='') AND (";
    }
} else {
    $SQL.="AND (Artists='') AND (";
}


reset($Tags);
$TagSQL = array();
$NotTagSQL = array();
foreach ($Tags as $Tag) {
    $TagSQL[] = " Tags LIKE '%|" . db_string(trim($Tag)) . "|%' ";
    $NotTagSQL[] = " NotTags LIKE '%|" . db_string(trim($Tag)) . "|%' ";
}
$TagSQL[] = "Tags=''";
$SQL.=implode(' OR ', $TagSQL);

$SQL.= ") AND !(" . implode(' OR ', $NotTagSQL) . ")";

// TODO: Lanz: fix this! $Type was the old category id
//$SQL.=" AND (Categories LIKE '%|" . db_string(trim($Type)) . "|%' OR Categories='') ";

if ($Properties['ReleaseType']) {
    $SQL.=" AND (ReleaseTypes LIKE '%|" . db_string(trim($ReleaseTypes[$Properties['ReleaseType']])) . "|%' OR ReleaseTypes='') ";
} else {
    $SQL.=" AND (ReleaseTypes='') ";
}

/*
  Notify based on the following:
  1. The torrent must match the formatbitrate filter on the notification
  2. If they set NewGroupsOnly to 1, it must also be the first torrent in the group to match the formatbitrate filter on the notification
 */


if ($Properties['Format']) {
    $SQL.=" AND (Formats LIKE '%|" . db_string(trim($Properties['Format'])) . "|%' OR Formats='') ";
} else {
    $SQL.=" AND (Formats='') ";
}

if ($Properties['Media']) {
    $SQL.=" AND (Media LIKE '%|" . db_string(trim($Properties['Media'])) . "|%' OR Media='') ";
} else {
    $SQL.=" AND (Media='') ";
}

// Either they aren't using NewGroupsOnly
$SQL .= "AND ((NewGroupsOnly = '0' ";
// Or this is the first torrent in the group to match the formatbitrate filter
$SQL .= ") OR ( NewGroupsOnly = '1' ";

$SQL .= "))";


if ($Properties['Year'] && $Properties['RemasterYear']) {
    $SQL.=" AND (('" . db_string(trim($Properties['Year'])) . "' BETWEEN FromYear AND ToYear)
			OR ('" . db_string(trim($Properties['RemasterYear'])) . "' BETWEEN FromYear AND ToYear)
			OR (FromYear=0 AND ToYear=0)) ";
} elseif ($Properties['Year'] || $Properties['RemasterYear']) {
    $SQL.=" AND (('" . db_string(trim(Max($Properties['Year'], $Properties['RemasterYear']))) . "' BETWEEN FromYear AND ToYear)
			OR (FromYear=0 AND ToYear=0)) ";
} else {
    $SQL.=" AND (FromYear=0 AND ToYear=0) ";
}

$SQL.=" AND UserID != '" . $LoggedUser['ID'] . "' ";

$DB->query($SQL);


if ($DB->record_count() > 0) {
    $UserArray = $DB->to_array('UserID');
    $FilterArray = $DB->to_array('ID');

    $InsertSQL = "INSERT IGNORE INTO users_notify_torrents (UserID, GroupID, TorrentID, FilterID) VALUES ";
    $Rows = array();
    foreach ($UserArray as $User) {
        list($FilterID, $UserID, $Passkey) = $User;
        $Rows[] = "('$UserID', '$GroupID', '$TorrentID', '$FilterID')";
        $Feed->populate('torrents_notify_' . $Passkey, $Item);
        $Cache->delete_value('notifications_new_' . $UserID);
    }
    $InsertSQL.=implode(',', $Rows);
    $DB->query($InsertSQL);


    foreach ($FilterArray as $Filter) {
        list($FilterID, $UserID, $Passkey) = $Filter;
        $Feed->populate('torrents_notify_' . $FilterID . '_' . $Passkey, $Item);
    }
}

// RSS for bookmarks
$DB->query("SELECT u.ID, u.torrent_pass
			FROM users_main AS u
			JOIN bookmarks_torrents AS b ON b.UserID = u.ID
			WHERE b.GroupID = $GroupID");
while (list($UserID, $Passkey) = $DB->next_record()) {
    $Feed->populate('torrents_bookmarks_t_' . $Passkey, $Item);
}

$Feed->populate('torrents_all', $Item);

// TODO: Lanz this needs to be looked in to more. The code had one for each of the old categories here, look over and clean up!
$Feed->populate('torrents_apps', $Item);

// Clear Cache
$Cache->delete('torrents_details_' . $GroupID);
foreach ($ArtistForm as $Importance => $Artists) {
    foreach ($Artists as $Num => $Artist) {
        if (!empty($Artist['id'])) {
            $Cache->delete('artist_' . $Artist['id']);
        }
    }
}

if (!$Private) {
    show_header("Warning");
    ?>
    <h1>Warning</h1>
    <p><strong>Your torrent has been uploaded however, you must download your torrent from <a href="torrents.php?id=<?= $GroupID ?>">here</a> because you didn't choose the private option.</strong></p>
    <?
    show_footer();
    die();
} elseif ($RequestID) {
    header("Location: requests.php?action=takefill&requestid=" . $RequestID . "&torrentid=" . $TorrentID . "&auth=" . $LoggedUser['AuthKey']);
} else {
    header("Location: torrents.php?id=$GroupID");
}
?>
