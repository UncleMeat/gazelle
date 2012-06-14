<?

define('FOOTER_FILE', SERVER_ROOT.'/design/privatefooter.php');
$HTTPS = ($_SERVER['SERVER_PORT'] == 443) ? 'ssl_' : '';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title><?=display_str($PageTitle)?></title>
	<meta http-equiv="X-UA-Compatible" content="chrome=1;IE=edge" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="favicon.ico" />
	<link rel="apple-touch-icon" href="/apple-touch-icon.png" />
	<link rel="search" type="application/opensearchdescription+xml" title="<?=SITE_NAME?> Torrents" href="opensearch.php?type=torrents" />
	<link rel="search" type="application/opensearchdescription+xml" title="<?=SITE_NAME?> Requests" href="opensearch.php?type=requests" />
	<link rel="search" type="application/opensearchdescription+xml" title="<?=SITE_NAME?> Forums" href="opensearch.php?type=forums" />
	<link rel="search" type="application/opensearchdescription+xml" title="<?=SITE_NAME?> Log" href="opensearch.php?type=log" />
	<link rel="search" type="application/opensearchdescription+xml" title="<?=SITE_NAME?> Users" href="opensearch.php?type=users" />
	<link rel="alternate" type="application/rss+xml" href="feeds.php?feed=feed_news&amp;user=<?=$LoggedUser['ID']?>&amp;auth=<?=$LoggedUser['RSS_Auth']?>&amp;passkey=<?=$LoggedUser['torrent_pass']?>&amp;authkey=<?=$LoggedUser['AuthKey']?>" title="<?=SITE_NAME?> - News" />
	<link rel="alternate" type="application/rss+xml" href="feeds.php?feed=feed_blog&amp;user=<?=$LoggedUser['ID']?>&amp;auth=<?=$LoggedUser['RSS_Auth']?>&amp;passkey=<?=$LoggedUser['torrent_pass']?>&amp;authkey=<?=$LoggedUser['AuthKey']?>" title="<?=SITE_NAME?> - Blog" />
	<link rel="alternate" type="application/rss+xml" href="feeds.php?feed=torrents_notify_<?=$LoggedUser['torrent_pass']?>&amp;user=<?=$LoggedUser['ID']?>&amp;auth=<?=$LoggedUser['RSS_Auth']?>&amp;passkey=<?=$LoggedUser['torrent_pass']?>&amp;authkey=<?=$LoggedUser['AuthKey']?>" title="<?=SITE_NAME?> - P.T.N." />
<? if(isset($LoggedUser['Notify'])) {
	foreach($LoggedUser['Notify'] as $Filter) {
		list($FilterID, $FilterName) = $Filter;
?>
	<link rel="alternate" type="application/rss+xml" href="feeds.php?feed=torrents_notify_<?=$FilterID?>_<?=$LoggedUser['torrent_pass']?>&amp;user=<?=$LoggedUser['ID']?>&amp;auth=<?=$LoggedUser['RSS_Auth']?>&amp;passkey=<?=$LoggedUser['torrent_pass']?>&amp;authkey=<?=$LoggedUser['AuthKey']?>&amp;name=<?=urlencode($FilterName)?>" title="<?=SITE_NAME?> - <?=display_str($FilterName)?>" />
<? 	}
}?>
	<link rel="alternate" type="application/rss+xml" href="feeds.php?feed=torrents_all&amp;user=<?=$LoggedUser['ID']?>&amp;auth=<?=$LoggedUser['RSS_Auth']?>&amp;passkey=<?=$LoggedUser['torrent_pass']?>&amp;authkey=<?=$LoggedUser['AuthKey']?>" title="<?=SITE_NAME?> - All Torrents" />

	<link href="<?=STATIC_SERVER?>styles/global.css?v=<?=filemtime(SERVER_ROOT.'/static/styles/global.css')?>" rel="stylesheet" type="text/css" />
<? if ($Mobile) { ?>
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0, user-scalable=no;"/>
	<link href="<?=STATIC_SERVER ?>styles/mobile/style.css" rel="stylesheet" type="text/css" />
<? } else { ?>
	<? if (empty($LoggedUser['StyleURL'])) { ?>
	<link href="<?=STATIC_SERVER?>styles/<?=$LoggedUser['StyleName']?>/style.css?v=<?=filemtime(SERVER_ROOT.'/static/styles/'.$LoggedUser['StyleName'].'/style.css')?>" title="<?=$LoggedUser['StyleName']?>" rel="stylesheet" type="text/css" media="screen" />
	<? } else { ?>
	<link href="<?=$LoggedUser['StyleURL']?>" title="External CSS" rel="stylesheet" type="text/css" media="screen" />
	<? } ?>
<? } ?>
       
	<script src="<?=STATIC_SERVER?>functions/sizzle.js" type="text/javascript"></script>
	<script src="<?=STATIC_SERVER?>functions/script_start.js?v=<?=filemtime(SERVER_ROOT.'/static/functions/script_start.js')?>" type="text/javascript"></script>
	<script src="<?=STATIC_SERVER?>functions/class_ajax.js?v=<?=filemtime(SERVER_ROOT.'/static/functions/class_ajax.js')?>" type="text/javascript"></script>
	
      <script type="text/javascript">//<![CDATA[
		var authkey = "<?=$LoggedUser['AuthKey']?>";
		var userid = <?=$LoggedUser['ID']?>;
	//]]></script>
	<script src="<?=STATIC_SERVER?>functions/global.js?v=<?=filemtime(SERVER_ROOT.'/static/functions/global.js')?>" type="text/javascript"></script>
<?

$Scripts=explode(',',$JSIncludes);

foreach ($Scripts as $Script) {
	if (empty($Script)) { continue; }
?>
	<script src="<?=STATIC_SERVER?>functions/<?=$Script?>.js?v=<?=filemtime(SERVER_ROOT.'/static/functions/'.$Script.'.js')?>" type="text/javascript"></script>
<?
 	if ($Script == 'jquery') { ?>
<script type="text/javascript">
        $.noConflict();
</script>
<?
	} ?>
<?
}
if ($Mobile) { ?>
	<script src="<?=STATIC_SERVER?>styles/mobile/style.js" type="text/javascript"></script>
<?
}

?>
</head>
<body id="<?=$Document == 'collages' ? 'collage' : $Document?>" <?= ((!$Mobile && $LoggedUser['Rippy'] == 'On') ? 'onload="say()"' : '') ?>>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<div id="wrapper">
<h1 class="hidden"><?=SITE_NAME?></h1>

<div id="header">
    <div id="header_top">
	<div id="logo"><a href="index.php"></a></div>
	<div id="stats_block">
		<ul id="userinfo_stats">
                <span class="inside_stat">
                      <li id="stats_seeding"><a href="torrents.php?type=seeding&amp;userid=<?=$LoggedUser['ID']?>">Up</a>: <span class="stat"><?=get_size($LoggedUser['BytesUploaded'])?></span></li>
                      <li id="stats_leeching"><a href="torrents.php?type=leeching&amp;userid=<?=$LoggedUser['ID']?>">Down</a>: <span class="stat"><?=get_size($LoggedUser['BytesDownloaded'])?></span></li>
                </span>
                <span class="inside_stat"> 
    <?
        if($LoggedUser['FLTokens'] > 0) { ?>
                      <li id="fl_tokens"><a href="bonus.php">Slots</a>: <span class="stat"><?=$LoggedUser['FLTokens']?></span></li>
    <?	} ?>  
                      <li id="credits"><a href="bonus.php">Credits</a>: <span class="stat"><?=number_format((int)$LoggedUser['Credits'])?></span></li>

                </span>
                <span class="inside_stat">
                      <li id="stats_ratio"><a href="articles.php?topic=ratio">Ratio</a>: <span class="stat"><?=ratio($LoggedUser['BytesUploaded'], $LoggedUser['BytesDownloaded'])?></span></li>
    <?	if(!empty($LoggedUser['RequiredRatio']) && $LoggedUser['RequiredRatio']>0) {?>
                      <li id="stats_required"><a href="articles.php?topic=ratio">Required</a>: <span class="stat"><?=number_format($LoggedUser['RequiredRatio'], 2)?></span></li>
    <?	}  ?> 
                </span>
            </ul>
	</div>
<?
$NewSubscriptions = $Cache->get_value('subscriptions_user_new_'.$LoggedUser['ID']);
if($NewSubscriptions === FALSE) {
        if($LoggedUser['CustomForums']) {
			unset($LoggedUser['CustomForums']['']);
			$RestrictedForums = implode("','", array_keys($LoggedUser['CustomForums'], 0));
			$PermittedForums = implode("','", array_keys($LoggedUser['CustomForums'], 1));
        }
        $DB->query("SELECT COUNT(s.TopicID)
                FROM users_subscriptions AS s
                        JOIN forums_last_read_topics AS l ON s.UserID = l.UserID AND s.TopicID = l.TopicID
                        JOIN forums_topics AS t ON l.TopicID = t.ID
                        JOIN forums AS f ON t.ForumID = f.ID
                WHERE (f.MinClassRead <= ".$LoggedUser['Class']." OR f.ID IN ('$PermittedForums'))
                        AND l.PostID < t.LastPostID
                        AND s.UserID = ".$LoggedUser['ID'].
                (!empty($RestrictedForums) ? "
                        AND f.ID NOT IN ('".$RestrictedForums."')" : ""));
        list($NewSubscriptions) = $DB->next_record();
        $Cache->cache_value('subscriptions_user_new_'.$LoggedUser['ID'], $NewSubscriptions, 0);
} 

// Moved alert bar handling to before we draw minor stats to allow showing alert status in links too

//Start handling alert bars
$Alerts = array();
$ModBar = array();

// News
$MyNews = $LoggedUser['LastReadNews']+0;
$CurrentNews = $Cache->get_value('news_latest_id');
if ($CurrentNews === false) {
	$DB->query("SELECT ID FROM news ORDER BY Time DESC LIMIT 1");
	if ($DB->record_count() == 1) {
		list($CurrentNews) = $DB->next_record();
	} else {
		$CurrentNews = -1;
	}
	$Cache->cache_value('news_latest_id', $CurrentNews, 0);
}

if ($MyNews < $CurrentNews) {
	$Alerts[] = '<a href="index.php">New Announcement!</a>';
}

//Staff PM
$NewStaffPMs = $Cache->get_value('staff_pm_new_'.$LoggedUser['ID']);
if ($NewStaffPMs === false) {
	$DB->query("SELECT COUNT(ID) FROM staff_pm_conversations WHERE UserID='".$LoggedUser['ID']."' AND Unread = '1'");
	list($NewStaffPMs) = $DB->next_record();
	$Cache->cache_value('staff_pm_new_'.$LoggedUser['ID'], $NewStaffPMs, 0);
}  

if ($NewStaffPMs > 0) {
	$Alerts[] = '<a href="staffpm.php?action=user_inbox">You have '.$NewStaffPMs.(($NewStaffPMs > 1) ? ' new staff messages' : ' new staff message').'</a>';
}

//Inbox
$NewMessages = $Cache->get_value('inbox_new_'.$LoggedUser['ID']);
if ($NewMessages === false) {
	$DB->query("SELECT COUNT(UnRead) FROM pm_conversations_users WHERE UserID='".$LoggedUser['ID']."' AND UnRead = '1' AND InInbox = '1'");
	list($NewMessages) = $DB->next_record();
	$Cache->cache_value('inbox_new_'.$LoggedUser['ID'], $NewMessages, 0);
}

if ($NewMessages > 0) {
	$Alerts[] = '<a href="inbox.php">You have '.$NewMessages.(($NewMessages > 1) ? ' new messages' : ' new message').'</a>';
}

if($LoggedUser['RatioWatch']) {
	$Alerts[] = '<a href="articles.php?topic=ratio">'.'Ratio Watch'.'</a>: '.'You have '.time_diff($LoggedUser['RatioWatchEnds'], 3).' to get your ratio over your required ratio or your leeching abilities will be disabled.';
} else if($LoggedUser['CanLeech'] != 1) {
	$Alerts[] = '<a href="articles.php?topic=ratio">'.'Ratio Watch'.'</a>: '.'Your downloading privileges are disabled until you meet your required ratio.';
}

if (check_perms('site_torrents_notify')) {
	$NewNotifications = $Cache->get_value('notifications_new_'.$LoggedUser['ID']);
	if ($NewNotifications === false) {
		$DB->query("SELECT COUNT(UserID) FROM users_notify_torrents WHERE UserID='$LoggedUser[ID]' AND UnRead='1'");
		list($NewNotifications) = $DB->next_record();
		//  if($NewNotifications && !check_perms('site_torrents_notify')) {
		//	$DB->query("DELETE FROM users_notify_torrents WHERE UserID='$LoggedUser[ID]'");
		//	$DB->query("DELETE FROM users_notify_filters WHERE UserID='$LoggedUser[ID]'");
		//} 
		$Cache->cache_value('notifications_new_'.$LoggedUser['ID'], $NewNotifications, 0);
	}
	if ($NewNotifications > 0) {
		$Alerts[] = '<a href="torrents.php?action=notify">'.'You have '.$NewNotifications.(($NewNotifications > 1) ? ' new torrent notifications' : ' new torrent notification').'</a>';
	}
}

// Collage subscriptions
if(check_perms('site_collages_subscribe')) { 
	$NewCollages = $Cache->get_value('collage_subs_user_new_'.$LoggedUser['ID']);
	if($NewCollages === FALSE) {
			$DB->query("SELECT COUNT(DISTINCT s.CollageID)
					FROM users_collage_subs as s
					JOIN collages as c ON s.CollageID = c.ID
					JOIN collages_torrents as ct on ct.CollageID = c.ID
					WHERE s.UserID = ".$LoggedUser['ID']." AND ct.AddedOn > s.LastVisit AND c.Deleted = '0'");
			list($NewCollages) = $DB->next_record();
			$Cache->cache_value('collage_subs_user_new_'.$LoggedUser['ID'], $NewCollages, 0);
	}
	if ($NewCollages > 0) {
		$Alerts[] = '<a href="userhistory.php?action=subscribed_collages">You have '.$NewCollages.(($NewCollages > 1) ? ' new collage updates' : ' new collage update').'</a>';
	}
}

if (check_perms('users_mod')) {
	$ModBar[] = '<a href="tools.php">Toolbox</a>';
}
//changed check so that FLS as well as staff can see PM's (always restricted by userclass anyway so its just a nicety for FLS)
if ( $LoggedUser['SupportFor'] !="" || $LoggedUser['DisplayStaff'] == 1 ) {
	$NumStaffPMs = $Cache->get_value('num_staff_pms_'.$LoggedUser['ID']);
	if ($NumStaffPMs === false) {
		//$DB->query("SELECT COUNT(ID) FROM staff_pm_conversations WHERE Status='Unanswered' AND (AssignedToUser=".$LoggedUser['ID']." OR (Level >= 500 AND Level <=".$LoggedUser['Class']."))");
		//removed Level>=500 clause so staff see num of all unanswered pm's they can answer
            $DB->query("SELECT COUNT(ID) FROM staff_pm_conversations 
                               WHERE Status='Unanswered' 
                                 AND (AssignedToUser=".$LoggedUser['ID']." OR Level <={$LoggedUser['Class']})");
		list($NumStaffPMs) = $DB->next_record();
		$Cache->cache_value('num_staff_pms_'.$LoggedUser['ID'], $NumStaffPMs , 1000);
	}
	if ($NumStaffPMs > 0) $ModBar[] = '<a href="staffpm.php">'.$NumStaffPMs.' Staff PMs</a>';
}

if(check_perms('admin_reports')) {
	$NumTorrentReports = $Cache->get_value('num_torrent_reportsv2');
	if ($NumTorrentReports === false) {
		$DB->query("SELECT COUNT(ID) FROM reportsv2 WHERE Status='New'");
		list($NumTorrentReports) = $DB->next_record();
		$Cache->cache_value('num_torrent_reportsv2', $NumTorrentReports, 0);
	}
	
	$ModBar[] = '<a href="reportsv2.php">'.$NumTorrentReports.(($NumTorrentReports == 1) ? ' Report' : ' Reports').'</a>';
}

if(check_perms('admin_reports')) {
	$NumOtherReports = $Cache->get_value('num_other_reports');
	if ($NumOtherReports === false) {
		$DB->query("SELECT COUNT(ID) FROM reports WHERE Status='New'");
		list($NumOtherReports) = $DB->next_record();
		$Cache->cache_value('num_other_reports', $NumOtherReports, 0);
	}
	
	if ($NumOtherReports > 0) {
		$ModBar[] = '<a href="reports.php">'.$NumOtherReports.(($NumTorrentReports == 1) ? ' Other Report' : ' Other Reports').'</a>';
	}
} else if(check_perms('project_team')) {
	$NumUpdateReports = $Cache->get_value('num_update_reports');
	if ($NumUpdateReports === false) {
		$DB->query("SELECT COUNT(ID) FROM reports WHERE Status='New' AND Type = 'request_update'");
		list($NumUpdateReports) = $DB->next_record();
		$Cache->cache_value('num_update_reports', $NumUpdateReports, 0);
	}
	
	if ($NumUpdateReports > 0) {
		$ModBar[] = '<a href="reports.php">'.'Request update reports'.'</a>';
	}
} else if(check_perms('site_moderate_forums')) {
	$NumForumReports = $Cache->get_value('num_forum_reports');
	if ($NumForumReports === false) {
		$DB->query("SELECT COUNT(ID) FROM reports WHERE Status='New' AND Type IN('collages_comment', 'Post', 'requests_comment', 'thread', 'torrents_comment')");
		list($NumForumReports) = $DB->next_record();
		$Cache->cache_value('num_forum_reports', $NumForumReports, 0);
	}
	
	if ($NumForumReports > 0) {
		$ModBar[] = '<a href="reports.php">'.'Forum reports'.'</a>';
	}
}
		// <ul id="userinfo_minor"<?=$NewSubscriptions ? ' class="highlite"' : '' ? >> // why is thsi like this? seems like an unused and useable css... i hate deleting stuff i dont understand though...
      ?>
 
	<div id="menu">
		<h4 class="hidden">Site Menu</h4>
		<ul>
			<li id="nav_index"><a href="index.php">Home</a></li>
			<li id="nav_torrents"><a href="torrents.php">Torrents</a></li>
			<li id="nav_collages"><a href="collages.php">Collages</a></li>
			<li id="nav_requests"><a href="requests.php">Requests</a></li>
			<li id="nav_forums"><a href="forums.php">Forums</a></li>
			<li id="nav_irc"><a href="chat.php">IRC</a></li>
			<li id="nav_top10"><a href="top10.php">Top 10</a></li>
			<li id="nav_rules"><a href="articles.php?topic=rules">Rules</a></li>
                        <li id="nav_rules"><a href="articles.php?topic=tutorials">Tutorials</a></li>
			<li id="nav_staff"><a href="staff.php">Staff</a></li>
		</ul>
	</div>
<?

// draw the alert bars (arrays set already^^)
if (!empty($Alerts) || !empty($ModBar)) {
?>
	<div id="alerts">
	<? foreach ($Alerts as $Alert) { ?>
		<div class="alertbar"><?=$Alert?></div>
	<? }
	if (!empty($ModBar)) { ?>
		<div id="modbar" class="alertbar blend"><?=implode(' | ',$ModBar)?></div>
	<? } ?>
	</div>
<?
}
//Done handling alertbars

if(!$Mobile && $LoggedUser['Rippy'] != 'Off') {
	switch($LoggedUser['Rippy']) {
		case 'PM' :
			$Says = $Cache->get_value('rippy_message_'.$LoggedUser['ID']);
			if($Says === false) {
				$Says = $Cache->get_value('global_rippy_message');
			}
			$Show = ($Says !== false);
			$Cache->delete_value('rippy_message_'.$LoggedUser['ID']);
			break;
		case 'On' :
			$Show = true;
			$Says = '';
			break;
		/* Uncomment to always show globals
		case 'Off' :
			$Says = $Cache->get_value('global_rippy_message');
			$Show = ($Says !== false);
			break;
		*/
	}

	if($Show) {
?>
	<div class="rippywrap">
		<div id="bubble" style="display: <?=($Says ? 'block' : 'none')?>">
			<span class="rbt"></span>
			<span id="rippy-says" class="rbm"><?=$Says?></span>
			<span class="rbb"></span>
		</div>
		<div class="rippy" onclick="rippyclick();"></div>
	</div>
<?
	}
}
?>

	<div id="searchbars">
		<ul>
			<li id="searchbar_torrents">
				<span class="hidden">Torrents: </span>
				<form action="torrents.php" method="get">
<? if(isset($LoggedUser['SearchType']) && $LoggedUser['SearchType']) { // Advanced search ?> 
					<input type="hidden" name="action" value="advanced" />
<? } ?>
					<input
						accesskey="t"
						spellcheck="false"
						onfocus="if (this.value == 'Torrents') this.value='';"
						onblur="if (this.value == '') this.value='Torrents';"
<? if(isset($LoggedUser['SearchType']) && $LoggedUser['SearchType']) { // Advanced search ?> 
						value="Torrents" type="text" name="groupname" size="17" title="Search Torrents"
<? } else { ?>
						value="Torrents" type="text" name="searchstr" size="17" title="Search Torrents"
<? } ?>
					/>
				</form>
			</li>
			<li id="searchbar_requests">
				<span class="hidden">Requests: </span>
				<form action="requests.php" method="get">
					<input
						spellcheck="false"
						onfocus="if (this.value == 'Requests') this.value='';"
						onblur="if (this.value == '') this.value='Requests';"
						value="Requests" type="text" name="search" size="17" title="Search Requests"
					/>
				</form>
			</li>
			<li id="searchbar_forums">
				<span class="hidden">Forums: </span>
				<form action="forums.php" method="get">
					<input value="search" type="hidden" name="action" />
					<input
						onfocus="if (this.value == 'Forums') this.value='';"
						onblur="if (this.value == '') this.value='Forums';"
						value="Forums" type="text" name="search" size="17" title="Search Forums"
					/>
				</form>
			</li>
			<li id="searchbar_log">
				<span class="hidden">Log: </span>
				<form action="log.php" method="get">
					<input
						onfocus="if (this.value == 'Log') this.value='';"
						onblur="if (this.value == '') this.value='Log';"
						value="Log" type="text" name="search" size="17" title="Search Logs"
					/>
				</form>
			</li>
			<li id="searchbar_users">
				<span class="hidden">Users: </span>
				<form action="user.php" method="get">
					<input type="hidden" name="action" value="search" />
					<input
						onfocus="if (this.value == 'Users') this.value='';"
						onblur="if (this.value == '') this.value='Users';"
						value="Users" type="text" name="search" size="20" title="Search Users"
					/>
				</form>
			</li>
		</ul>
	</div>
    </div>
    
    <div id="header_bottom">

            <div id="minor_stats">
                <ul id="userinfo_minor">
                      <li id="nav_inbox"<?=$NewMessages ? ' class="highlight"' : ''?>><a onmousedown="Stats('inbox');" href="inbox.php">Inbox<?=$NewMessages ? "($NewMessages)" : ''?></a></li>
                      <li id="nav_staffmessages"<?=$NewStaffPMs ? ' class="highlight"' : ''?>><a onmousedown="Stats('staffpm');" href="staffpm.php?action=user_inbox">Staff Messages<?=$NewStaffPMs ? "($NewStaffPMs)" : ''?></a></li>
    <? if ( $LoggedUser['SupportFor'] !="" || $LoggedUser['DisplayStaff'] == 1 ) {  ?>
                      <li id="nav_staffinbox"<?=$NumStaffPMs ? ' class="highlight"' : ''?>><a onmousedown="Stats('staffinbox');" href="staffpm.php?action=staff_inbox">Staff Inbox<?=$NumStaffPMs ? "($NumStaffPMs)" : ''?></a></li>
    <? }  ?>
                      <li id="nav_uploaded"><a onmousedown="Stats('uploads');" href="torrents.php?type=uploaded&amp;userid=<?=$LoggedUser['ID']?>">Uploads</a></li>
                      <li id="nav_bookmarks"><a onmousedown="Stats('bookmarks');" href="bookmarks.php?type=torrents">Bookmarks</a></li>
    <? if (check_perms('site_torrents_notify')) { ?>
                      <li id="nav_notifications"<?=($NewNotifications ? ' class="highlight"' : '')?>><a onmousedown="Stats('notifications');" href="user.php?action=notify">Notifications<?=$NewNotifications ? "($NewNotifications)" : ''?></a></li>
    <? }  ?>
                      <li id="nav_subscriptions"<?=($NewSubscriptions ? ' class="highlight"' : '')?>><a onmousedown="Stats('subscriptions');" href="userhistory.php?action=subscriptions"<?=($NewSubscriptions ? ' class="new-subscriptions"' : '')?>>Subscriptions<?=$NewSubscriptions ? "($NewSubscriptions)" : ''?></a></li>
                      <li id="nav_comments"><a onmousedown="Stats('comments');" href="comments.php">Comments</a></li>
                      <li id="nav_friends"><a onmousedown="Stats('friends');" href="friends.php">Friends</a></li>
                      <li id="nav_logs"><a onmousedown="Stats('logs');" href="log.php">Logs</a></li>
                      <li id="nav_bonus"><a onmousedown="Stats('bonus');" href="bonus.php">Bonus</a></li>
                      <li id="nav_bonus"><a onmousedown="Stats('sandbox');" href="sandbox.php">Sandbox</a></li>
                      <li id="nav_bonus"><a onmousedown="Stats('conncheck');" href="user.php?action=connchecker">Conn-Checker</a></li>
                </ul>
            </div>
            <div id="major_stats">
                <ul id="userinfo_major">
                      <li id="nav_upload" class="brackets"><a href="upload.php">Upload</a></li>
    <?
    if(check_perms('site_send_unlimited_invites')) {
          $Invites = ' (∞)';
    } elseif ($LoggedUser['Invites']>0) {
          $Invites = ' ('.$LoggedUser['Invites'].')';
    } else {
          $Invites = '';
    }
    ?>
                      <li id="nav_invite" class="brackets"><a href="user.php?action=invite">Invite<?=$Invites?></a></li>
                      <li id="nav_donate" class="brackets"><a href="donate.php">Donate</a></li>
                </ul>
                <ul id="userinfo_username">
                      <li id="nav_userinfo"><a href="user.php?id=<?=$LoggedUser['ID']?>" class="username"><?=$LoggedUser['Username']?></a></li>
                      <li id="nav_useredit" class="brackets"><a href="user.php?action=edit&amp;userid=<?=$LoggedUser['ID']?>">Edit</a></li>
                      <li id="nav_logout" class="brackets"><a href="logout.php?auth=<?=$LoggedUser['AuthKey']?>">Logout</a></li>
                </ul>
            </div>
    </div>
</div>

<div id="content">
