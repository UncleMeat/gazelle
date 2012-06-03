<?
if (!isset($_REQUEST['authkey']) || !isset($_REQUEST['torrent_pass'])) {
	enforce_login();
	$TorrentPass = $LoggedUser['torrent_pass'];
	$DownloadAlt = $LoggedUser['DownloadAlt'];
} else {
	$UserInfo = $Cache->get_value('user_'.$_REQUEST['torrent_pass']);
	if(!is_array($UserInfo)) {
		$DB->query("SELECT
			ID,
			DownloadAlt
			FROM users_main AS m
			INNER JOIN users_info AS i ON i.UserID=m.ID
			WHERE m.torrent_pass='".db_string($_REQUEST['torrent_pass'])."'
			AND m.Enabled='1'");
		$UserInfo = $DB->next_record();
		$Cache->cache_value('user_'.$_REQUEST['torrent_pass'], $UserInfo, 3600);
	}
	$UserInfo = array($UserInfo);
	list($UserID,$DownloadAlt)=array_shift($UserInfo);
	if(!$UserID) { error(403); }
	$TorrentPass = $_REQUEST['torrent_pass'];
}
require(SERVER_ROOT.'/classes/class_torrent.php');

$TorrentID = $_REQUEST['id'];

if (!is_number($TorrentID)){ error(0); }

$Info = $Cache->get_value('torrent_download_'.$TorrentID);
if(!is_array($Info) || empty($Info[10])) {
	$DB->query("SELECT
		tg.ID AS GroupID,
		tg.Name,
		t.Size,
		t.FreeTorrent,
                t.double_seed,
		t.info_hash
		FROM torrents AS t
		INNER JOIN torrents_group AS tg ON tg.ID=t.GroupID
		WHERE t.ID='".db_string($TorrentID)."'");
	if($DB->record_count() < 1) {
		header('Location: log.php?search='.$TorrentID);
		die();
	}
	$Info = array($DB->next_record(MYSQLI_NUM, array(4,5,6,10)));
	$Cache->cache_value('torrent_download_'.$TorrentID, $Info, 0);
}
if(!is_array($Info[0])) {
	error(404);
}
list($GroupID,$Name, $Size, $FreeTorrent, $DoubleSeed, $InfoHash) = array_shift($Info); // used for generating the filename

$TokenTorrents = $Cache->get_value('users_tokens_'.$UserID);
if (empty($TokenTorrents)) {
        $DB->query("SELECT TorrentID, Type FROM users_freeleeches WHERE UserID=$UserID AND Expired=FALSE");
        $TokenTorrents = $DB->to_array('TorrentID');
}

// If he's trying use a token on this, we need to make sure he has one,
// deduct it, add this to the FLs table, and update his cache key.
if ($_REQUEST['usetoken'] == 1 && $FreeTorrent == '0') {
	if (isset($LoggedUser)) {
		$FLTokens = $LoggedUser['FLTokens'];
		if ($LoggedUser['CanLeech'] != '1') {
			error('You cannot use tokens while leech disabled.');
		}
	}
	else {
		$UInfo = user_heavy_info($UserID);
		if ($UInfo['CanLeech'] != '1') {
			error('You may not use tokens while leech disabled.');
		}
		$FLTokens = $UInfo['FLTokens'];
	}
	
	// First make sure this isn't already FL, and if it is, do nothing
        // if it's currently using a double seed slot, switch to FL.
	if (empty($TokenTorrents[$TorrentID]) || $TokenTorrents[$TorrentID]['Type'] != 'leech') {
		if ($FLTokens <= 0) {
			error("You do not have any tokens left. Please use the regular DL link.");
		}
		
		// Let the tracker know about this
		if (!update_tracker('add_token_leech', array('info_hash' => rawurlencode($InfoHash), 'userid' => $UserID))) {
			error("Sorry! An error occurred while trying to register your token. Most often, this is due to the tracker being down or under heavy load. Please try again later.");
		}
		
		// We need to fetch and check this again here because of people 
		// double-clicking the FL link while waiting for a tracker response.
		$TokenTorrents = $Cache->get_value('users_tokens_'.$UserID);
		if (empty($TokenTorrents)) {
			$DB->query("SELECT TorrentID, Type FROM users_freeleeches WHERE UserID=$UserID AND Expired=FALSE");
			$TokenTorrents = $DB->to_array('TorrentID');
		}
		
		if (empty($TokenTorrents[$TorrentID]) || $TokenTorrents[$TorrentID]['Type'] != 'leech') {
			$DB->query("INSERT INTO users_freeleeches (UserID, TorrentID, Type, Time) VALUES ($UserID, $TorrentID, 'leech', NOW())
							ON DUPLICATE KEY UPDATE Time=VALUES(Time), Type=VALUES(Type), Expired=FALSE, Uses=Uses+1");
			$DB->query("UPDATE users_main SET FLTokens = FLTokens - 1 WHERE ID=$UserID");
			
			// Fix for downloadthemall messing with the cached token count
			$UInfo = user_heavy_info($UserID);
			$FLTokens = $UInfo['FLTokens'];
			
			$Cache->begin_transaction('user_info_heavy_'.$UserID);
			$Cache->update_row(false, array('FLTokens'=>($FLTokens - 1)));
			$Cache->commit_transaction(0);
			
			$TokenTorrents[] = $TorrentID;
			$Cache->cache_value('users_tokens_'.$UserID, $TokenTorrents);
		}
	}
} elseif ($_REQUEST['usetoken'] == 2 && $DoubleSeed == '0') {

	// First make sure this isn't already DS, and if it is, do nothing
	if (empty($TokenTorrents[$TorrentID]) || $TokenTorrents[$TorrentID]['Type'] != 'seed') {
                if (isset($LoggedUser)) {
                        $FLTokens = $LoggedUser['FLTokens'];
                } else {
                        $UInfo = user_heavy_info($UserID);
                        $FLTokens = $UInfo['FLTokens'];
                }

                if ($FLTokens <= 0) {
			error("You do not have any tokens left. Please use the regular DL link.");
		}

		// Let the tracker know about this
		if (!update_tracker('add_token_seed', array('info_hash' => rawurlencode($InfoHash), 'userid' => $UserID))) {
			error("Sorry! An error occurred while trying to register your token. Most often, this is due to the tracker being down or under heavy load. Please try again later.");
		}
		
		// We need to fetch and check this again here because of people 
		// double-clicking the DS link while waiting for a tracker response.
		$TokenTorrents = $Cache->get_value('users_tokens_'.$UserID);
		if (empty($TokenTorrents)) {
			$DB->query("SELECT TorrentID, Type FROM users_freeleeches WHERE UserID=$UserID AND Expired=FALSE");
			$TokenTorrents = $DB->to_array('TorrentID');
		}

		if (empty($TokenTorrents[$TorrentID]) || $TokenTorrents[$TorrentID]['Type'] != 'seed') {
			$DB->query("INSERT INTO users_freeleeches (UserID, TorrentID, Type, Time) VALUES ($UserID, $TorrentID, 'seed', NOW())
							ON DUPLICATE KEY UPDATE Time=VALUES(Time), Type=VALUES(Type), Expired=FALSE, Uses=Uses+1");
			$DB->query("UPDATE users_main SET FLTokens = FLTokens - 1 WHERE ID=$UserID");
			
			// Fix for downloadthemall messing with the cached token count
			$UInfo = user_heavy_info($UserID);
			$FLTokens = $UInfo['FLTokens'];
			
			$Cache->begin_transaction('user_info_heavy_'.$UserID);
			$Cache->update_row(false, array('FLTokens'=>($FLTokens - 1)));
			$Cache->commit_transaction(0);
			
			$TokenTorrents[] = $TorrentID;
			$Cache->cache_value('users_tokens_'.$UserID, $TokenTorrents);
		}
        }
                
}

// TODO: Lanz, unsure about this one, need more investigation, disabled for now.
/*
//Stupid Recent Snatches On User Page
if($CategoryID == '1' && $Image != "") {
	$RecentSnatches = $Cache->get_value('recent_snatches_'.$UserID);
	if(!empty($RecentSnatches)) {
		$Snatch = array('ID'=>$GroupID,'Name'=>$Name,'Artist'=>$Artists,'WikiImage'=>$Image);
		if(!in_array($Snatch, $RecentSnatches)) {
			if(count($RecentSnatches) == 5) {
				array_pop($RecentSnatches);
			}
			array_unshift($RecentSnatches, $Snatch);
		} elseif(!is_array($RecentSnatches)) {
			$RecentSnatches = array($Snatch);
		}
		$Cache->cache_value('recent_snatches_'.$UserID, $RecentSnatches, 0);
	}
}
*/

$DB->query("INSERT INTO users_downloads (UserID, TorrentID, Time) VALUES ('$UserID', '$TorrentID', '".sqltime()."') ON DUPLICATE KEY UPDATE Time=VALUES(Time)");


$DB->query("SELECT File FROM torrents_files WHERE TorrentID='$TorrentID'");

list($Contents) = $DB->next_record(MYSQLI_NUM, array(0));
$Contents = unserialize(base64_decode($Contents));
$Tor = new TORRENT($Contents, true); // New TORRENT object
// Set torrent announce URL
$Tor->set_announce_url(ANNOUNCE_URL.'/'.$TorrentPass.'/announce');

$Tor->set_comment('http://'. SITE_URL."/torrents.php?id=$GroupID");

// Remove multiple trackers from torrent
unset($Tor->Val['announce-list']);
// Remove web seeds (put here for old torrents not caught by previous commit
unset($Tor->Val['url-list']);
// Remove libtorrent resume info
unset($Tor->Val['libtorrent_resume']);
// Torrent name takes the format of Album - YYYY

$TorrentName = $Name;

if (!$TorrentName) { $TorrentName="No Name"; }

$FileName = ($Browser == 'Internet Explorer') ? urlencode(file_string($TorrentName)) : file_string($TorrentName);
$MaxLength = $DownloadAlt ? 192 : 196;
$FileName = cut_string($FileName, $MaxLength, true, false);
$FileName = $DownloadAlt ? $FileName.'.txt' : $FileName.'.torrent';


if($DownloadAlt) {
	header('Content-Type: text/plain; charset=utf-8');
} elseif(!$DownloadAlt || $Failed) {
	header('Content-Type: application/x-bittorrent; charset=utf-8');
}
header('Content-disposition: attachment; filename="'.$FileName.'"');

echo $Tor->enc();
