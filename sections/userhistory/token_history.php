<?
/************************************************************************
||------------------|| User token history page ||-----------------------||
This page lists the torrents a user has spent his tokens on. It
gets called if $_GET['action'] == 'token_history'.

Using $_GET['userid'] allows a mod to see any user's token history.
Nonmods and empty userid show $LoggedUser['ID']'s history
************************************************************************/

if (isset($_GET['userid'])) {
	$UserID = $_GET['userid'];
} else {
	$UserID = $LoggedUser['ID'];
}
if (!is_number($UserID)) { error(404); }

$UserInfo = user_info($UserID);
$Perms = get_permissions($UserInfo['PermissionID']);
$UserClass = $Perms['Class'];

if($LoggedUser['ID'] != $UserID && !check_paranoia(false, $User['Paranoia'], $UserClass, $UserID)) {
	error(PARANOIA_MSG);
}

if (isset($_GET['expire'])) {
	if (!check_perms('users_mod')) { error(403); }
	$UserID = $_GET['userid'];
	$TorrentID = $_GET['torrentid'];
	
	if (!is_number($UserID) || !is_number($TorrentID)) { error(403); }
	$DB->query("SELECT info_hash FROM torrents where ID = $TorrentID");
	if (list($InfoHash) = $DB->next_record(MYSQLI_NUM, FALSE)) {
		$DB->query("DELETE FROM users_slots WHERE UserID=$UserID AND TorrentID=$TorrentID");
		$Cache->delete_value('users_tokens_'.$UserID);
		update_tracker('remove_tokens', array('info_hash' => rawurlencode($InfoHash), 'userid' => $UserID));
	}
	header("Location: userhistory.php?action=token_history&userid=$UserID");
}

show_header('Current slots in use');

list($Page,$Limit) = page_limit(25);

$DB->query("SELECT SQL_CALC_FOUND_ROWS
			   us.TorrentID,
			   t.GroupID,
			   us.FreeLeech,
                           us.DoubleSeed,
			   g.Name
			FROM users_slots AS us
			JOIN torrents AS t ON t.ID = us.TorrentID
			JOIN torrents_group AS g ON g.ID = t.GroupID
			WHERE us.UserID = $UserID
			ORDER BY g.Name ASC
			LIMIT $Limit");
$Tokens = $DB->to_array();

$DB->query("SELECT FOUND_ROWS()");
list($NumResults) = $DB->next_record();
$Pages=get_pages($Page, $NumResults, 25);

?>

<div class="linkbox"><?=$Pages?></div>
<div class="head">Slots in use for <?=format_username($UserID, $UserInfo['Username'], $UserInfo['Donor'], $UserInfo['Warned'], $UserInfo['Enabled'])?></div>
<table>
	<tr class="colhead">
		<td>Torrent</td>
		<td>Freeleech</td>
		<td>Doubleseed</td>
	</tr>
<?
foreach ($Tokens as $Token) {
	$GroupIDs[] = $Token['GroupID'];
}

$i = true;
foreach ($Tokens as $Token) {
	$i = !$i;
	list($TorrentID, $GroupID, $FreeLeech, $DoubleSeed, $Name) = $Token; 
	$Name = "<a href=\"torrents.php?torrentid=$TorrentID\">$Name</a>";
        if ($FreeLeech == '0000-00-00 00:00:00') {
            $fl = 'No';
        } else {
            $fl = $FreeLeech > sqltime() ? time_diff($FreeLeech) : 'Expired';
        }

        if ($DoubleSeed == '0000-00-00 00:00:00') {
            $ds = 'No';
        } else {
            $ds = $DoubleSeed > sqltime() ? time_diff($DoubleSeed) : 'Expired';
        }
?>
	<tr class="<?=($i?'rowa':'rowb')?>">
		<td><?=$Name?></td>
		<td><?=$fl?></td>
                <td><?=$ds?></td>
	</tr>
<? }
?>
</table>
<div class="linkbox"><?=$Pages?></div>
<?
show_footer();
?>