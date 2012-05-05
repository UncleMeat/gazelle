<?
//*********************************************************************//
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Edit form ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
// This page relies on the TORRENT_FORM class. All it does is call     //
// the necessary functions.                                            //
//---------------------------------------------------------------------//
// At the bottom, there are grouping functions which are off limits to //
// most members.                                                       //
//*********************************************************************//

require(SERVER_ROOT . '/classes/class_torrent_form.php');

if (!is_number($_GET['id']) || !$_GET['id']) {
    error(0);
}

$TorrentID = $_GET['id'];

$DB->query("SELECT 
	t.Media, 
	t.Format, 
	t.Encoding AS Bitrate, 
	t.RemasterYear, 
	t.Remastered, 
	t.RemasterTitle, 
	t.RemasterCatalogueNumber,
	t.RemasterRecordLabel,
	t.Scene, 
	t.FreeTorrent, 
	t.FreeLeechType, 
	t.Dupable, 
	t.DupeReason, 
	t.Description AS TorrentDescription, 
	tg.NewCategoryID,
	tg.Name AS Title,
	tg.Year,
	tg.ArtistID,
	tg.VanityHouse,
	ag.Name AS ArtistName,
	t.GroupID,
	t.UserID,
	t.HasLog,
	t.HasCue,
	t.LogScore,
	bt.TorrentID AS BadTags,
	bf.TorrentID AS BadFolders,
	bfi.TorrentID AS BadFiles,
	ca.TorrentID AS CassetteApproved,
	lma.TorrentID AS LossymasterApproved
	FROM torrents AS t 
	LEFT JOIN torrents_group AS tg ON tg.ID=t.GroupID
	LEFT JOIN artists_group AS ag ON ag.ArtistID=tg.ArtistID
	LEFT JOIN torrents_bad_tags AS bt ON bt.TorrentID=t.ID
	LEFT JOIN torrents_bad_folders AS bf ON bf.TorrentID=t.ID
	LEFT JOIN torrents_bad_files AS bfi ON bfi.TorrentID=t.ID
	LEFT JOIN torrents_cassette_approved AS ca ON ca.TorrentID=t.ID
	LEFT JOIN torrents_lossymaster_approved AS lma ON lma.TorrentID=t.ID
	WHERE t.ID='$TorrentID'");

list($Properties) = $DB->to_array(false, MYSQLI_BOTH);
if (!$Properties) {
    error(404);
}


if (($LoggedUser['ID'] != $Properties['UserID'] && !check_perms('torrents_edit')) || $LoggedUser['DisableWiki']) {
    error(403);
}


show_header('Edit torrent', 'upload');


if (!($Properties['Remastered'] && !$Properties['RemasterYear']) || check_perms('edit_unknowns')) {
    $TorrentForm = new TORRENT_FORM($Properties, $Err, false);

    $TorrentForm->head();
    $TorrentForm->simple_form();
    $TorrentForm->foot();
}

show_footer();

?>
