<?

function compare($X, $Y){
	return($Y['score'] - $X['score']);
}

define(MAX_PERS_COLLAGES, 3); // How many personal collages should be shown by default

include(SERVER_ROOT.'/sections/bookmarks/functions.php'); // has_bookmarked()
include(SERVER_ROOT.'/classes/class_text.php');
$Text = NEW TEXT;

$GroupID=ceil($_GET['id']);

include(SERVER_ROOT.'/sections/torrents/functions.php');
$TorrentCache = get_group_info($GroupID, true);

$TorrentDetails = $TorrentCache[0];
$TorrentList = $TorrentCache[1];

// Group details
list($Body, $Image, $GroupID, $GroupName, $GroupCategoryID,
    $GroupTime, $TorrentTags, $TorrentTagIDs, $TorrentTagUserIDs, $TagPositiveVotes, $TagNegativeVotes) = array_shift($TorrentDetails);

$DisplayName=$GroupName;
$AltName=$GroupName; // Goes in the alt text of the image
$Title=$GroupName; // goes in <title>
//$Body = $Text->full_format($Body);

$Tags = array();
if ($TorrentTags != '') {
	$TorrentTags=explode('|',$TorrentTags);
	$TorrentTagIDs=explode('|',$TorrentTagIDs);
	$TorrentTagUserIDs=explode('|',$TorrentTagUserIDs);
	$TagPositiveVotes=explode('|',$TagPositiveVotes);
	$TagNegativeVotes=explode('|',$TagNegativeVotes);
	
	foreach ($TorrentTags as $TagKey => $TagName) {
		$Tags[$TagKey]['name'] = $TagName;
		$Tags[$TagKey]['score'] = ($TagPositiveVotes[$TagKey] - $TagNegativeVotes[$TagKey]);
		$Tags[$TagKey]['id']=$TorrentTagIDs[$TagKey];
		$Tags[$TagKey]['userid']=$TorrentTagUserIDs[$TagKey];
	}
	uasort($Tags, 'compare');
}

/*if (check_perms('site_debug')) {
	print_r($TorrentTags);
	print_r($Tags);
	print_r($TorrentTagUserIDs);
	die();
}*/

$TokenTorrents = $Cache->get_value('users_tokens_'.$UserID);
if (empty($TokenTorrents)) {
	$DB->query("SELECT TorrentID FROM users_freeleeches WHERE UserID=$UserID AND Expired=FALSE");
	$TokenTorrents = $DB->collect('TorrentID');
	$Cache->cache_value('users_tokens_'.$UserID, $TokenTorrents);
}

// Start output
show_header($Title,'browse,comments,torrent,bbcode,jquery');


	list($TorrentID,
		$FileCount, $Size, $Seeders, $Leechers, $Snatched, $FreeTorrent, $TorrentTime, $Description, 
		$FileList, $FilePath, $UserID, $Username, $LastActive,
		$BadTags, $BadFolders, $BadFiles, $CassetteApproved, $LossymasterApproved, $LastReseedRequest, $LogInDB, $HasFile) = $TorrentList[0];

	$CanEdit = (check_perms('torrents_edit') ||  ($UserID == $LoggedUser['ID']  ) );
      
?>
<div class="thin">
	<h2><?=$DisplayName?></h2>
<?
	if($_GET['did'] == 1) { ?>
			<div id="messagebar" class="messagebar">Successfully Edited Description</div>
                  <script type="text/javascript">
                        function Kill_Message(){ setTimeout("jQuery('#messagebar').fadeOut(400)", 2000); }
                        addDOMLoadEvent(Kill_Message);
                  </script>
<?	} ?>
	<div class="linkbox">
<?	if( $CanEdit) {   ?>
		<a href="torrents.php?action=editgroup&amp;groupid=<?=$GroupID?>">[Edit description]</a>
<?	} ?>
		<a href="torrents.php?action=history&amp;groupid=<?=$GroupID?>">[View history]</a>
<?	if(has_bookmarked('torrent', $GroupID)) {
?>
		<a href="#" id="bookmarklink_torrent_<?=$GroupID?>" onclick="Unbookmark('torrent', <?=$GroupID?>,'[Bookmark]');return false;">[Remove bookmark]</a>
<?	} else { ?>
		<a href="#" id="bookmarklink_torrent_<?=$GroupID?>" onclick="Bookmark('torrent', <?=$GroupID?>,'[Remove bookmark]');return false;">[Bookmark]</a>
<?	} ?>
	<a href="torrents.php?action=grouplog&amp;groupid=<?=$GroupID?>">[View log]</a>
	</div>

	<div class="sidebar">
		<div class="box box_albumart">
			<div class="head"><strong>Cover</strong></div>
<?
if ($Image!="") {
	if(check_perms('site_proxy_images')) {
		$Image = 'http'.($SSL?'s':'').'://'.SITE_URL.'/image.php?i='.urlencode($Image);
	}
?>
			<p align="center"><img style="max-width: 100%;" src="<?=$Image?>" alt="<?=$AltName?>" onclick="lightbox.init(this,220);" /></p>
<?
} else {
?>
			<p align="center"><img src="<?=STATIC_SERVER?>common/noartwork/noimage.png" alt="Click to see full size image" title="Click to see full size image  " width="220" border="0" /></p>
<?
}
?>
		</div>

		<div class="box box_tags">
			<div class="head"><strong>Tags</strong></div>
<?
if(count($Tags) > 0) {
?>
			<ul class="stats nobullet">
<?
	foreach($Tags as $TagKey=>$Tag) {
			
?>
				<li>
					<a href="torrents.php?taglist=<?=$Tag['name']?>" style="float:left; display:block;"><?=display_str($Tag['name'])?></a>
					<div style="float:right; display:block; letter-spacing: -1px;">
					<a href="torrents.php?action=vote_tag&amp;way=down&amp;groupid=<?=$GroupID?>&amp;tagid=<?=$Tag['id']?>&amp;auth=<?=$LoggedUser['AuthKey']?>" style="font-family: monospace;" >[-]</a>
					<?=$Tag['score']?>
					<a href="torrents.php?action=vote_tag&amp;way=up&amp;groupid=<?=$GroupID?>&amp;tagid=<?=$Tag['id']?>&amp;auth=<?=$LoggedUser['AuthKey']?>" style="font-family: monospace;">[+]</a>
<?		if(check_perms('users_warn')){ ?>
					<a href="user.php?id=<?=$Tag['userid']?>" >[U]</a>
<?		} ?>
<?		if(check_perms('site_delete_tag')){ ?>
					<a href="torrents.php?action=delete_tag&amp;groupid=<?=$GroupID?>&amp;tagid=<?=$Tag['id']?>&amp;auth=<?=$LoggedUser['AuthKey']?>" >[X]</a>
<?		} ?>
					</div>
					<br style="clear:both" />
				</li>
<?
	}
?>
			</ul>
<?
} else {
?>
			There are no tags to display.
<?
}
?>
		</div>
		<div class="box">
			<div class="head"><strong>Add tag</strong></div>
			<div class="body">
				<form action="torrents.php" method="post">
					<input type="hidden" name="action" value="add_tag" />
					<input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
					<input type="hidden" name="groupid" value="<?=$GroupID?>" />
					<input type="text" name="tagname" size="20" />
					<input type="submit" value="+" />
				</form>
				<br /><br />
				<strong><a href="articles.php?topic=tag">Tagging rules</a></strong>
			</div>
		</div>
	</div>
	<div class="main_column">
		<table class="torrent_table">
			<tr class="colhead_dark">
				<td width="80%"><strong>Torrent Info</strong></td>
				<td><strong>Size</strong></td>
				<td class="sign"><img src="static/styles/<?=$LoggedUser['StyleName'] ?>/images/snatched.png" alt="Snatches" title="Snatches" /></td>
				<td class="sign"><img src="static/styles/<?=$LoggedUser['StyleName'] ?>/images/seeders.png" alt="Seeders" title="Seeders" /></td>
				<td class="sign"><img src="static/styles/<?=$LoggedUser['StyleName'] ?>/images/leechers.png" alt="Leechers" title="Leechers" /></td>
			</tr>
<?

function filelist($Str) {
	return "</td><td>".get_size($Str[1])."</td></tr>";
}

$EditionID = 0;

	$Reported = false;
	unset($ReportedTimes);
	$Reports = $Cache->get_value('reports_torrent_'.$TorrentID);
	if($Reports === false) {
		$DB->query("SELECT r.ID,
				r.ReporterID,
				r.Type,
				r.UserComment,
				r.ReportedTime
			FROM reportsv2 AS r
			WHERE TorrentID = $TorrentID
				AND Type != 'edited'
				AND Status != 'Resolved'");
		$Reports = $DB->to_array();
		$Cache->cache_value('reports_torrent_'.$TorrentID, $Reports, 0);
	}	
	if(count($Reports) > 0) {
		$Reported = true;
		include(SERVER_ROOT.'/sections/reportsv2/array.php');
		$ReportInfo = "<table><tr class='colhead_red' style='font-weight: bold;'><td>This torrent has ".count($Reports)." active ".(count($Reports) > 1 ?'reports' : 'report').":</td></tr>";

		foreach($Reports as $Report) {
			list($ReportID, $ReporterID, $ReportType, $ReportReason, $ReportedTime) = $Report;

			$Reporter = user_info($ReporterID);
			$ReporterName = $Reporter['Username'];

			if (array_key_exists($ReportType, $Types)) {
				$ReportType = $Types[$ReportType];
			} else {
				//There was a type but it wasn't an option!
				$ReportType = $Types['master']['other'];
			}
			$ReportInfo .= "<tr><td>".(check_perms('admin_reports') ? "<a href='user.php?id=$ReporterID'>$ReporterName</a> <a href='reportsv2.php?view=report&amp;id=$ReportID'>reported it</a> " : "Someone reported it ").time_diff($ReportedTime,2,true,true)." for the reason '".$ReportType['title']."':";
			$ReportInfo .= "<blockquote>".$Text->full_format($ReportReason)."</blockquote></td></tr>";
		}
		$ReportInfo .= "</table>";
	}
	
	$FileList = str_replace(array('_','-'), ' ', $FileList);
	$FileList = str_replace('|||','<tr><td>',display_str($FileList));
	$FileList = preg_replace_callback('/\{\{\{([^\{]*)\}\}\}/i','filelist',$FileList);
	$FileList = '<table style="overflow-x:auto;"><tr class="colhead_dark"><td><strong><div style="float: left; display: block;">File Name'.(check_perms('users_mod') ? ' [<a href="torrents.php?action=regen_filelist&amp;torrentid='.$TorrentID.'">Regenerate</a>]' : '').'</div></strong><div style="float:right; display:block;">'.(empty($FilePath) ? '' : '/'.$FilePath.'/' ).'</div></td><td><strong>Size</strong></td></tr><tr><td>'.$FileList."</table>";

	$TorrentUploader = $Username; // Save this for "Uploaded by:" below

	// similar to torrent_info()


	$ExtraInfo = $GroupName;
        $AddExtra = ' / ';

	if($FreeTorrent == '1') { $ExtraInfo.=$AddExtra.'<strong>Freeleech!</strong>'; $AddExtra=' / '; }
	if($FreeTorrent == '2') { $ExtraInfo.=$AddExtra.'<strong>Neutral Leech!</strong>'; $AddExtra=' / '; }
	if(in_array($TorrentID, $TokenTorrents)) { $ExtraInfo.=$AddExtra.'<strong>Personal Freeleech!</strong>'; $AddExtra=' / '; }
	if($Reported) { $ExtraInfo.=$AddExtra.'<strong>Reported</strong>'; $AddExtra=' / '; }
	if(!empty($BadTags)) { $ExtraInfo.=$AddExtra.'<strong>Bad Tags</strong>'; $AddExtra=' / '; }
	if(!empty($BadFolders)) { $ExtraInfo.=$AddExtra.'<strong>Bad Folders</strong>'; $AddExtra=' / '; }
	if(!empty($CassetteApproved)) { $ExtraInfo.=$AddExtra.'<strong>Cassette Approved</strong>'; $AddExtra=' / '; }
	if(!empty($LossymasterApproved)) { $ExtraInfo.=$AddExtra.'<strong>Lossy Master Approved</strong>'; $AddExtra=' / '; }
	if(!empty($BadFiles)) { $ExtraInfo.=$AddExtra.'<strong>Bad File Names</strong>'; $AddExtra=' / '; }
	
?>

			<tr class="groupid_<?=$GroupID?> edition_<?=$EditionID?> group_torrent" style="font-weight: normal;" id="torrent<?=$TorrentID?>">
				<td>
					<span>[
                                                <a href="reportsv2.php?action=report&amp;id=<?=$TorrentID?>" title="Report">Report</a>
<?	if($CanEdit) { ?>
						| <a href="torrents.php?action=edit&amp;id=<?=$TorrentID ?>" title="Edit">Edit</a>
<?	} ?>
<?	if(check_perms('torrents_delete') || $UserID == $LoggedUser['ID']) { ?>
						| <a href="torrents.php?action=delete&amp;torrentid=<?=$TorrentID ?>" title="Remove">Remove</a>
<?	} ?>

					]</span>
					<strong><?=$ExtraInfo; ?></strong>
				</td>
				<td class="nobr"><?=get_size($Size)?></td>
				<td><?=number_format($Snatched)?></td>
				<td><?=number_format($Seeders)?></td>
				<td><?=number_format($Leechers)?></td>
			</tr>
			<tr class="groupid_<?=$GroupID?> edition_<?=$EditionID?> torrentdetails pad" id="torrent_<?=$TorrentID; ?>">
				<td colspan="5">
                                        <span id="torrent_buttons">
                                            <a href="torrents.php?action=download&amp;id=<?=$TorrentID ?>&amp;authkey=<?=$LoggedUser['AuthKey']?>&amp;torrent_pass=<?=$LoggedUser['torrent_pass']?>" class="button blueButton" title="Download">DOWNLOAD TORRENT</a>
<?	if (($LoggedUser['FLTokens'] > 0) && $HasFile  && !in_array($TorrentID, $TokenTorrents) && ($FreeTorrent == '0') && ($LoggedUser['CanLeech'] == '1')) { ?>
                                            <a href="torrents.php?action=download&amp;id=<?=$TorrentID ?>&amp;authkey=<?=$LoggedUser['AuthKey']?>&amp;torrent_pass=<?=$LoggedUser['torrent_pass']?>&usetoken=1" class="button greenButton" title="Use a FL Token" onClick="return confirm('Are you sure you want to use a freeleech token here?');">FREELEECH DOWNLOAD</a>
<?	} ?>					
                                            
                                        </span>
					<blockquote>
						Uploaded by <?=format_username($UserID, $TorrentUploader)?> <?=time_diff($TorrentTime);?>
<? if($Seeders == 0){ ?>
						<?
						if ($LastActive != '0000-00-00 00:00:00' && time() - strtotime($LastActive) >= 432000) { ?>
							<br /><strong>Last active: <?=time_diff($LastActive);?></strong>
						<?} else { ?>
						<br />Last active: <?=time_diff($LastActive);?>
						<?} ?>
						<?
						if ($LastActive != '0000-00-00 00:00:00' && time() - strtotime($LastActive) >= 345678 && time()-strtotime($LastReseedRequest)>=864000) { ?>
						<br /><a href="torrents.php?action=reseed&amp;torrentid=<?=$TorrentID?>&amp;groupid=<?=$GroupID?>">[Request re-seed]</a>
						<?} ?>
						
<? } ?>

					</blockquote>
<? if(check_perms('site_moderate_requests')) { ?>
					<div class="linkbox">
						<a href="torrents.php?action=masspm&amp;id=<?=$GroupID?>&amp;torrentid=<?=$TorrentID?>">[Mass PM Snatchers]</a>
					</div>
<? } ?>
					<div class="linkbox">
						<a href="#" onclick="show_peers('<?=$TorrentID?>', 0);return false;">(View Peerlist)</a>
<? if(check_perms('site_view_torrent_snatchlist')) { ?> 
						<a href="#" onclick="show_downloads('<?=$TorrentID?>', 0);return false;">(View Downloadlist)</a>
						<a href="#" onclick="show_snatches('<?=$TorrentID?>', 0);return false;">(View Snatchlist)</a>
<? } ?>
						<a href="#" onclick="show_files('<?=$TorrentID?>');return false;">(View Filelist)</a>
					</div>
					<div id="peers_<?=$TorrentID?>" class="hidden"></div>
					<div id="downloads_<?=$TorrentID?>" class="hidden"></div>
					<div id="snatches_<?=$TorrentID?>" class="hidden"></div>
					<div id="files_<?=$TorrentID?>" class="hidden"><?=$FileList?></div>
<?  if($Reported) { ?> 
					<div id="reported_<?=$TorrentID?>" ><?=$ReportInfo?></div>
<? } ?>
					<? if(!empty($Description)) {
						echo '<blockquote>'.$Text->full_format($Description).'</blockquote>';}
					?>
				</td>
			</tr>
		</table>
<?
$Requests = get_group_requests($GroupID);
if (count($Requests) > 0) {
	$i = 0;
?>
		<div class="box">
			<div class="head"><span style="font-weight: bold;">Requests (<?=count($Requests)?>)</span> <span style="float:right;"><a href="#" onClick="$('#requests').toggle(); this.innerHTML=(this.innerHTML=='(Hide)'?'(Show)':'(Hide)'); return false;">(Show)</a></span></div>
			<table id="requests" class="hidden">
				<tr class="colhead">
					<td>Format / Bitrate / Media</td>
					<td>Votes</td>
					<td>Bounty</td>
				</tr>
<?	foreach($Requests as $Request) {
		$RequestVotes = get_votes_array($Request['ID']);
?>
				<tr class="requestrows <?=(++$i%2?'rowa':'rowb')?>">
					<td><a href="requests.php?action=view&id=<?=$Request['ID']?>">xxx</a></td>
					<td>
						<form id="form_<?=$Request['ID']?>">
							<span id="vote_count_<?=$Request['ID']?>"><?=count($RequestVotes['Voters'])?></span>
							<input type="hidden" id="requestid_<?=$Request['ID']?>" name="requestid" value="<?=$Request['ID']?>" />
							<input type="hidden" id="auth" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
							&nbsp;&nbsp; <a href="javascript:Vote(0, <?=$Request['ID']?>)"><strong>(+)</strong></a>
						</form>
					</td>
					<td><?=get_size($RequestVotes['TotalBounty'])?></td>
				</tr>
<?	} ?>
			</table>
		</div>
<?
}
$Collages = $Cache->get_value('torrent_collages_'.$GroupID);
if(!is_array($Collages)) {
	$DB->query("SELECT c.Name, c.NumTorrents, c.ID FROM collages AS c JOIN collages_torrents AS ct ON ct.CollageID=c.ID WHERE ct.GroupID='$GroupID' AND Deleted='0' AND CategoryID!='0'");
	$Collages = $DB->to_array();
	$Cache->cache_value('torrent_collages_'.$GroupID, $Collages, 3600*6);
}
if(count($Collages)>0) {
?>
		<table id="collages">
			<tr class="colhead">
				<td width="85%">Collage name</td>
				<td># torrents</td>
			</tr>
<?	foreach ($Collages as $Collage) { 
		list($CollageName, $CollageTorrents, $CollageID) = $Collage;
?>
			<tr>
				<td><a href="collages.php?id=<?=$CollageID?>"><?=$CollageName?></a></td>
				<td><?=$CollageTorrents?></td>
			</tr>
<?	} ?>
		</table>
<?
}

$PersonalCollages = $Cache->get_value('torrent_collages_personal_'.$GroupID);
if(!is_array($PersonalCollages)) {
	$DB->query("SELECT c.Name, c.NumTorrents, c.ID FROM collages AS c JOIN collages_torrents AS ct ON ct.CollageID=c.ID WHERE ct.GroupID='$GroupID' AND Deleted='0' AND CategoryID='0'");
	$PersonalCollages = $DB->to_array(false, MYSQL_NUM);
	$Cache->cache_value('torrent_collages_personal_'.$GroupID, $PersonalCollages, 3600*6);
}

if(count($PersonalCollages)>0) { 
	if (count($PersonalCollages) > MAX_PERS_COLLAGES) {
		// Pick 5 at random
		$Range = range(0,count($PersonalCollages) - 1);
		shuffle($Range);
		$Indices = array_slice($Range, 0, MAX_PERS_COLLAGES);
		$SeeAll = ' <a href="#" onClick="$(\'.personal_rows\').toggle(); return false;">(See all)</a>';
	} else {
		$Indices = range(0, count($PersonalCollages)-1);
		$SeeAll = '';
	}
?>
		<table id="personal_collages">
			<tr class="colhead">
				<td width="85%">This album is in <?=count($PersonalCollages)?> personal collage<?=((count($PersonalCollages)>1)?'s':'')?><?=$SeeAll?></td>
				<td># torrents</td>
			</tr>
<?	foreach ($Indices as $i) { 
		list($CollageName, $CollageTorrents, $CollageID) = $PersonalCollages[$i];
		unset($PersonalCollages[$i]);
?>
			<tr>
				<td><a href="collages.php?id=<?=$CollageID?>"><?=$CollageName?></a></td>
				<td><?=$CollageTorrents?></td>
			</tr>
<?	}
	foreach ($PersonalCollages as $Collage) { 
		list($CollageName, $CollageTorrents, $CollageID) = $Collage;
?>
			<tr class="personal_rows hidden">
				<td><a href="collages.php?id=<?=$CollageID?>"><?=$CollageName?></a></td>
				<td><?=$CollageTorrents?></td>
			</tr>
<?	} ?>
		</table>
<?
}

        $PermissionsInfo = get_permissions_for_user($UserID);
        $Body = $Text->full_format($Body, isset($PermissionsInfo['site_advanced_tags']) &&  $PermissionsInfo['site_advanced_tags'] );

?>
		<div class="box">
			<div class="head"><strong>Description</strong></div>
			<div class="body"><? if ($Body!="") { echo $Body; } else { echo "There is no information on this torrent."; } ?></div>
		</div>
<?

$Results = $Cache->get_value('torrent_comments_'.$GroupID);
if($Results === false) {
	$DB->query("SELECT
			COUNT(c.ID)
			FROM torrents_comments as c
			WHERE c.GroupID = '$GroupID'");
	list($Results) = $DB->next_record();
	$Cache->cache_value('torrent_comments_'.$GroupID, $Results, 0);
}

if(isset($_GET['postid']) && is_number($_GET['postid']) && $Results > TORRENT_COMMENTS_PER_PAGE) {
	$DB->query("SELECT COUNT(ID) FROM torrents_comments WHERE GroupID = $GroupID AND ID <= $_GET[postid]");
	list($PostNum) = $DB->next_record();
	list($Page,$Limit) = page_limit(TORRENT_COMMENTS_PER_PAGE,$PostNum);
} else {
	list($Page,$Limit) = page_limit(TORRENT_COMMENTS_PER_PAGE,$Results);
}

//Get the cache catalogue
$CatalogueID = floor((TORRENT_COMMENTS_PER_PAGE*$Page-TORRENT_COMMENTS_PER_PAGE)/THREAD_CATALOGUE);
$CatalogueLimit=$CatalogueID*THREAD_CATALOGUE . ', ' . THREAD_CATALOGUE;

//---------- Get some data to start processing

// Cache catalogue from which the page is selected, allows block caches and future ability to specify posts per page
$Catalogue = $Cache->get_value('torrent_comments_'.$GroupID.'_catalogue_'.$CatalogueID);
if($Catalogue === false) {
	$DB->query("SELECT
			c.ID,
			c.AuthorID,
			c.AddedTime,
			c.Body,
			c.EditedUserID,
			c.EditedTime,
			u.Username,
            a.Signature
			FROM torrents_comments as c
			LEFT JOIN users_main AS u ON u.ID=c.EditedUserID
            LEFT JOIN users_main AS a ON a.ID = c.AuthorID
			WHERE c.GroupID = '$GroupID'
			ORDER BY c.ID
			LIMIT $CatalogueLimit");
	$Catalogue = $DB->to_array(false,MYSQLI_ASSOC);
	$Cache->cache_value('torrent_comments_'.$GroupID.'_catalogue_'.$CatalogueID, $Catalogue, 0);
}

//This is a hybrid to reduce the catalogue down to the page elements: We use the page limit % catalogue
$Thread = array_slice($Catalogue,((TORRENT_COMMENTS_PER_PAGE*$Page-TORRENT_COMMENTS_PER_PAGE)%THREAD_CATALOGUE),TORRENT_COMMENTS_PER_PAGE,true);
?>
	<div class="linkbox"><a name="comments"></a>
<?
$Pages=get_pages($Page,$Results,TORRENT_COMMENTS_PER_PAGE,9,'#comments');
echo $Pages;
?>
	</div>
<?

//---------- Begin printing
foreach($Thread as $Key => $Post){
	list($PostID, $AuthorID, $AddedTime, $Body, $EditedUserID, $EditedTime, $EditedUsername, $Signature) = array_values($Post);
	list($AuthorID, $Username, $PermissionID, $Paranoia, $Donor, $Warned, $Avatar, $Enabled, $UserTitle) = array_values(user_info($AuthorID));
      $AuthorPermissions = get_permissions($PermissionID);
      list($ClassLevel,$PermissionValues,$MaxSigLength,$MaxAvatarWidth,$MaxAvatarHeight)=array_values($AuthorPermissions);
      // we need to get custom permissions for this author
      //$PermissionValues = get_permissions_for_user($AuthorID, false, $AuthorPermissions);
?>
<table class="forum_post box vertical_margin<?=$HeavyInfo['DisableAvatars'] ? ' noavatar' : ''?>" id="post<?=$PostID?>">
	<tr class="colhead_dark">
		<td colspan="2">
			<span style="float:left;"><a class="post_id" href='torrents.php?id=<?=$GroupID?>&amp;postid=<?=$PostID?>#post<?=$PostID?>'>#<?=$PostID?></a>
				<strong><?=format_username($AuthorID, $Username, $Donor, $Warned, $Enabled == 2 ? false : true, $PermissionID, false, true)?></strong> <?=time_diff($AddedTime)?> <a href="reports.php?action=report&amp;type=torrents_comment&amp;id=<?=$PostID?>">[Report]</a>
				- <a href="#quickpost" onclick="Quote('<?=$PostID?>','<?=$Username?>');">[Quote]</a>
<?if ($AuthorID == $LoggedUser['ID'] || check_perms('site_moderate_forums')){ ?>				- <a href="#post<?=$PostID?>" onclick="Edit_Form('<?=$PostID?>','<?=$Key?>');">[Edit]</a><? }
if (check_perms('site_moderate_forums')){ ?>				- <a href="#post<?=$PostID?>" onclick="Delete('<?=$PostID?>');">[Delete]</a> <? } ?>
			</span>
			<span id="bar<?=$PostID?>" style="float:right;">
				<a href="#">&uarr;</a>
			</span>
		</td>
	</tr>
	<tr>
<? if(empty($HeavyInfo['DisableAvatars'])) { ?>
		<td class="avatar" valign="top">
	<? if ($Avatar) { ?>
			<img src="<?=$Avatar?>" class="avatar" style="<?=get_avatar_css($MaxAvatarWidth, $MaxAvatarHeight)?>" alt="<?=$Username ?>'s avatar" />
	<? } else { ?>
			<img src="<?=STATIC_SERVER?>common/avatars/default.png" class="avatar" style="<?=get_avatar_css(100, 120)?>" alt="Default avatar" />
	<?
	}
	?>
		</td>
<?
}
?>
		<td class="body" valign="top">
			<div id="content<?=$PostID?>" class="post_container">
                      <div class="post_content"><?=$Text->full_format($Body, get_permissions_advtags($AuthorID, false, $AuthorPermissions)) ?> </div>
                <?  
           if( empty($HeavyInfo['DisableSignatures']) && ($MaxSigLength>0) && !empty($Signature) ) {
                        
                        echo '<div class="sig post_footer">' . $Text->full_format($Signature) . '</div>';
           }      ?>
                      
<? if($EditedUserID){ ?>  
                        <div class="post_footer">
<?	if(check_perms('site_admin_forums')) { ?>
				<a href="#content<?=$PostID?>" onclick="LoadEdit('forums', <?=$PostID?>, 1); return false;">&laquo;</a> 
<? 	} ?>
				Last edited by
				<?=format_username($EditedUserID, $EditedUsername) ?> <?=time_diff($EditedTime,2,true,true)?>
                        </div>
        <? }   ?>  
			</div>
		</td>
	</tr>
</table>
<?	} ?>
		<div class="linkbox">
		<?=$Pages?>
		</div>
<?
if(!$LoggedUser['DisablePosting']) { ?>
			<br />
			<h3>Post reply</h3>
			<div class="box pad">
				<table id="quickreplypreview" class="forum_post box vertical_margin hidden" style="text-align:left;">
					<tr class="colhead_dark">
						<td colspan="2">
							<span style="float:left;"><a href='#quickreplypreview'>#XXXXXX</a>
								by <strong><?=format_username($LoggedUser['ID'], $LoggedUser['Username'], $LoggedUser['Donor'], $LoggedUser['Warned'], $LoggedUser['Enabled'] == 2 ? false : true, $LoggedUser['PermissionID'], false, true)?></strong>
							Just now
							<a href="#quickreplypreview">[Report Comment]</a>
							</span>
							<span id="barpreview" style="float:right;">
								<a href="#">&uarr;</a>
							</span>
						</td>
					</tr>
					<tr>
						<td class="avatar" valign="top">
                              <? if (!empty($LoggedUser['Avatar'])) {  ?>
                                            <img src="<?=$LoggedUser['Avatar']?>" class="avatar" style="<?=get_avatar_css($LoggedUser['MaxAvatarWidth'], $LoggedUser['MaxAvatarHeight'])?>" alt="<?=$LoggedUser['Username']?>'s avatar" />
                               <? } else { ?>
                                          <img src="<?=STATIC_SERVER?>common/avatars/default.png" class="avatar" style="<?=get_avatar_css(100, 120)?>" alt="Default avatar" />
                              <? } ?>
						</td>
						<td class="body" valign="top">
							<div id="contentpreview" style="text-align:left;"></div>
						</td>
					</tr>
				</table>
				<form id="quickpostform" action="" method="post" style="display: block; text-align: center;">
					<div id="quickreplytext">
						<input type="hidden" name="action" value="reply" />
						<input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
						<input type="hidden" name="groupid" value="<?=$GroupID?>" />
                            <? $Text->display_bbcode_assistant("quickpost", get_permissions_advtags($LoggedUser['ID'], $LoggedUser['CustomPermissions'])); ?>
						<textarea id="quickpost" name="body" class="long"  rows="8"></textarea> <br />
					</div>
					<input id="post_preview" type="button" value="Preview" onclick="if(this.preview){Quick_Edit();}else{Quick_Preview();}" />
					<input type="submit" value="Post reply" />
				</form>
			</div>
<? } ?>
	</div>
</div>
<?

show_footer();
?>
