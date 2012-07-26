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
// it into the database.								//

// trim whitespace before setting/evaluating these fields
$_POST['image'] = trim($_POST['image']);
$_POST['desc'] = trim($_POST['desc']);
$_POST['title'] = trim($_POST['title']);

$Properties = array();
//$NewCategory = db_string($_POST['category']);
$Properties['Category'] = $_POST['category'];
$Properties['Title'] = $_POST['title'];
$Properties['TagList'] = $_POST['tags'];
$Properties['Image'] = $_POST['image'];
$Properties['GroupDescription'] = $_POST['album_desc'];
$Properties['TorrentDescription'] = $_POST['release_desc'];
if ($_POST['album_desc']) {
    $Properties['GroupDescription'] = $_POST['album_desc'];
} elseif ($_POST['desc']) {
    $Properties['GroupDescription'] = $_POST['desc'];
}
$Properties['GroupID'] = $_POST['groupid'];
$RequestID = $_POST['requestid'];

//******************************************************************************//
//--------------- Validate data in upload form ---------------------------------//
//** note: if the same field is set to be validated more than once then each time it is set it overwrites the previous test
//** ie.. one test per field max, last one set for a specific field is what is used
$Validate->SetFields('title', '1', 'string', 'Title must be between 2 and 200 characters.', array('maxlength' => 200, 'minlength' => 2));
$Validate->SetFields('tags', '1', 'string', 'You must enter at least one tag. Maximum length is 10000 characters.', array('maxlength' => 10000, 'minlength' => 2));
$whitelist_regex = GetWhitelistRegex();
$Validate->SetFields('image', '0', 'image', 'The image URL you entered was not valid.', array('regex' => $whitelist_regex, 'maxlength' => 255, 'minlength' => 12));
$Validate->SetFields('desc', '1', 'desc', 'Description', array('regex' => $whitelist_regex, 'minimages'=>1, 'maxlength' => 1000000, 'minlength' => 20));
$Validate->SetFields('category', '1', 'inarray', 'Please select a category.', array('inarray' => array_keys($NewCategories)));
$Validate->SetFields('rules', '1', 'require', 'Your torrent must abide by the rules.');

$Err = $Validate->ValidateForm($_POST, $Text); // Validate the form


$File = $_FILES['file_input']; // This is our torrent file
$TorrentName = $File['tmp_name'];

if(!$Err ){ // if we already have an error lets report what we have (much friendlier for fixing your presentation in the upload page as the fileinfo does not carry back)
    if (!is_uploaded_file($TorrentName) || !filesize($TorrentName)) {
        $Err = 'No torrent file uploaded, or file is empty.';
    } else if (substr(strtolower($File['name']), strlen($File['name']) - strlen(".torrent")) !== ".torrent") {
        $Err = "You seem to have put something other than a torrent file into the upload field. (" . $File['name'] . ").";
    }
}

$LogScoreAverage = 0;
$SendPM = 0;
$LogMessage = "";
$CheckStamp = "";
    
$HideDNU = true;
$HideWL = true;

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

$SearchText = db_string(trim($Properties['Title'] . ' ' . $Text->db_clean_search($Properties['GroupDescription'])));


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
		(NewCategoryID, Name, Time, Body, Image, SearchText) VALUES
		(" . $T['Category'] . ", " . $T['Title'] . ", '" . sqltime() . "', '" . db_string($Body) . "', $T[Image], '$SearchText')");
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

// lanz: insert the category tag here.
$Tags = explode(' ', strtolower($NewCategories[$T['Category']]['tag']." ".$Properties['TagList']));
$Tags = array_unique($Tags);
if (!$Properties['GroupID']) {
    $TagsAdded=array();
    foreach ($Tags as $Tag) {
        //$Tag = sanitize_tag($Tag);
        $Tag = trim($Tag,'.'); // trim dots from the beginning and end
        $Tag = get_tag_synonym($Tag);
        if (!empty($Tag)) { // mifune: modified this to not add duplicates in the same input string
            if (!in_array($Tag, $TagsAdded)){ // and to create new tags as Uses=1 which seems more correct
                $TagsAdded[] = $Tag;
                $DB->query("INSERT INTO tags
                            (Name, UserID, Uses) VALUES
                            ('" . $Tag . "', $LoggedUser[ID], 1)
                            ON DUPLICATE KEY UPDATE Uses=Uses+1;
                      ");

                $TagID = $DB->inserted_id();

                $DB->query("INSERT INTO torrents_tags
                            (TagID, GroupID, UserID, PositiveVotes) VALUES
                            ($TagID, $GroupID, $LoggedUser[ID], 9)
                            ON DUPLICATE KEY UPDATE PositiveVotes=PositiveVotes+1;
                      ");
            }
        }
    }
    // replace the original tag array with corrected tags
    $Tags = $TagsAdded;
}

// Use this section to control freeleeches
if ($TotalSize < (20*1024*1024*1024)){
    $Properties['FreeTorrent']=0;
} else {
    $Properties['FreeTorrent']=1;
}

// Torrent
$DB->query("
	INSERT INTO torrents
		(GroupID, UserID,
		info_hash, FileCount, FileList, FilePath, Size, 
		Time, FreeTorrent) 
	VALUES
		(" . $GroupID . ", " . $LoggedUser['ID'] . ",
		'" . db_string($InfoHash) . "', " . $NumFiles . ", " . $FileString . ", '" . $FilePath . "', " . $TotalSize . ", 
		'" . sqltime() . "', '" . $Properties['FreeTorrent'] . "')");

$Cache->increment('stats_torrent_count');
$TorrentID = $DB->inserted_id();

update_tracker('add_torrent', array('id' => $TorrentID, 'info_hash' => rawurlencode($InfoHash), 'freetorrent' => (int) $Properties['FreeLeech']));



//******************************************************************************//
//--------------- Write torrent file -------------------------------------------//

$DB->query("INSERT INTO torrents_files (TorrentID, File) VALUES ($TorrentID, '" . db_string($Tor->dump_data()) . "')");

write_log("Torrent $TorrentID ($LogName) (" . get_size($TotalSize) . ") was uploaded by " . $LoggedUser['Username']);
write_group_log($GroupID, $TorrentID, $LoggedUser['ID'], "Uploaded $LogName (" . get_size($TotalSize) . ")", 0);

update_hash($GroupID);

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
            array_unshift($RecentUploads, array('ID' => $GroupID, 'Name' => trim($Properties['Title']), 'Image' => trim($Properties['Image'])));
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

reset($Tags);
$TagSQL = array();
$NotTagSQL = array();
foreach ($Tags as $Tag) {
    $TagSQL[] = " Tags LIKE '%|" . db_string(trim($Tag)) . "|%' ";
    $NotTagSQL[] = " NotTags LIKE '%|" . db_string(trim($Tag)) . "|%' ";
}

$SQL .= " AND ((";

$TagSQL[] = "Tags=''";
$SQL.=implode(' OR ', $TagSQL);

$SQL.= ") AND !(" . implode(' OR ', $NotTagSQL) . ")";
$SQL.=" AND (Categories LIKE '%|" . db_string($NewCategories[$T['Category']]['name']) . "|%' OR Categories='') ";
$SQL .= ") AND UserID != '" . $LoggedUser['ID'] . "' ";

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

// TODO: Lanz for reference only if we decide to expand with more feeds.
//$Feed->populate('torrents_apps', $Item);

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
