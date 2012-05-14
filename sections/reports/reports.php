<?
/************************************************************************

 ************************************************************************/
if(!check_perms('admin_reports') && !check_perms('project_team') && !check_perms('site_moderate_forums')) {
	error(404);
}

// Number of reports per page
define('REPORTS_PER_PAGE', '10');
include(SERVER_ROOT.'/classes/class_text.php');
$Text = NEW TEXT;

list($Page,$Limit) = page_limit(REPORTS_PER_PAGE);

include(SERVER_ROOT.'/sections/reports/array.php');

// Header
show_header('Reports','bbcode');

if($_GET['id'] && is_number($_GET['id'])) {
	$View = "Single report";
	$Where = "r.ID = ".$_GET['id'];
} else if(empty($_GET['view'])) {
	$View = "New";
	$Where = "Status='New'";
} else {
	$View = $_GET['view'];
	switch($_GET['view']) {
		case 'old' :
			$Where = "Status='Resolved'";
			break;
		default : 
			error(404);
			break;
	}
}

if(!check_perms('admin_reports')) {
	if(check_perms('project_team')) {
		$Where .= " AND Type = 'request_update'";
	}
	if(check_perms('site_moderate_forums')) {
		$Where .= " AND Type IN('collages_comment', 'Post', 'requests_comment', 'thread', 'torrents_comment')";
	}

}

$Reports = $DB->query("SELECT SQL_CALC_FOUND_ROWS 
		r.ID, 
		r.UserID,
		um.Username, 
		r.ThingID, 
		r.Type, 
		r.ReportedTime, 
		r.Reason, 
		r.Status
	FROM reports AS r 
		JOIN users_main AS um ON r.UserID=um.ID 
	WHERE ".$Where." 
	ORDER BY ReportedTime 
	DESC LIMIT ".$Limit);

// Number of results (for pagination)
$DB->query('SELECT FOUND_ROWS()');
list($Results) = $DB->next_record();

// Done with the number of results. Move $DB back to the result set for the reports
$DB->set_query_id($Reports);

// Start printing stuff
?>
<div class="thin">
<h2>Active Reports</h2>
<div class="linkbox">
	<a href="reports.php">New</a> |
	<a href="reports.php?view=old">Old</a> |
	<a href="reports.php?action=stats">Stats</a>
</div>
<div class="linkbox">
<?
	// pagination
	$Pages = get_pages($Page,$Results,REPORTS_PER_PAGE,11);
	echo $Pages;
?>
</div>
<?  
while(list($ReportID, $SnitchID, $SnitchName, $ThingID, $Short, $ReportedTime, $Reason, $Status) = $DB->next_record()) {
	$Type = $Types[$Short];
	$Reference = "reports.php?id=".$ReportID."#report".$ReportID;
?>
<div id="report<?=$ReportID?>">
<form action="reports.php" method="post">
	<div>
		<input type="hidden" name="reportid" value="<?=$ReportID?>" />
		<input type="hidden" name="action" value="takeresolve" />
		<input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
	</div>
	<table cellpadding="5" id="report_<?=$ReportID?>">
            <tr class="colhead_dark">
			<td width="16%"><strong><a href="<?=$Reference?>">Report</a></strong></td>
			<td><strong><?=$Type['title']?></strong> was reported by <strong><a href="user.php?id=<?=$SnitchID?>"><?=$SnitchName?></a></strong> <?=time_diff($ReportedTime)?></td>
		</tr>
            <tr class="rowa"> 
			<td class="center" colspan="2">
				<strong>
<?
	switch($Short) {
		case "user" :
			$DB->query("SELECT Username FROM users_main WHERE ID=".$ThingID);
			if($DB->record_count() < 1) {
				echo "No user with the reported ID found";
			} else {
				list($Username) = $DB->next_record();
				echo "<a href='user.php?id=".$ThingID."'>".display_str($Username)."</a>";
			}
			break;
		case "request" :
		case "request_update" :
			$DB->query("SELECT r.Title,
                                     u.Username 
                                     FROM requests AS r
                                     LEFT JOIN users_main AS u ON u.ID = r.UserID WHERE r.ID=".$ThingID);
			if($DB->record_count() < 1) {
				echo "No request with the reported ID found";
			} else {
				list($Name,$Username) = $DB->next_record();
				echo "<a href='requests.php?action=view&amp;id=".$ThingID."'>Request '".display_str($Name)."' by ".display_str($Username)."</a>";
			}
			break;
		case "collage" :
			$DB->query("SELECT c.Name,
                                     u.Username 
                                     FROM collages AS c
                                     LEFT JOIN users_main AS u ON u.ID = c.UserID WHERE c.ID=".$ThingID);
			if($DB->record_count() < 1) {
				echo "No collage with the reported ID found";
			} else {
				list($Name,$Username) = $DB->next_record();
				echo "<a href='collages.php?id=".$ThingID."'>Collage '".display_str($Name)."' by ".display_str($Username)."</a>";
			}
			break;
		case "thread" :
			$DB->query("SELECT f.Title,
                                     u.Username
                                     FROM forums_topics AS f
                                     LEFT JOIN users_main AS u ON u.ID = f.AuthorID WHERE f.ID=".$ThingID);
			if($DB->record_count() < 1) {
				echo "No thread with the reported ID found";
			} else {
				list($Title,$Username) = $DB->next_record();
				echo "<a href='forums.php?action=viewthread&amp;threadid=".$ThingID."'>Thread '".display_str($Title)."' by ".display_str($Username)."</a>";
			}
			break;
		case "post" :
			if (isset($LoggedUser['PostsPerPage'])) {
				$PerPage = $LoggedUser['PostsPerPage'];
			} else {
				$PerPage = POSTS_PER_PAGE;
			}
			//$DB->query("SELECT p.ID, p.Body, p.TopicID, (SELECT COUNT(ID) FROM forums_posts WHERE forums_posts.TopicID = p.TopicID AND forums_posts.ID<=p.ID) AS PostNum FROM forums_posts AS p WHERE ID=".$ThingID);
			$DB->query("SELECT p.ID, 
                                     p.Body, 
                                     p.TopicID, 
                                     (SELECT COUNT(ID) FROM forums_posts 
                                                       WHERE forums_posts.TopicID = p.TopicID 
                                                       AND forums_posts.ID<=p.ID) AS PostNum, 
                                     f.Title,
                                     u.Username FROM forums_posts AS p 
                                                LEFT JOIN forums_topics AS f ON f.ID = p.TopicID 
                                                LEFT JOIN users_main AS u ON u.ID = p.AuthorID WHERE p.ID=".$ThingID);
			if($DB->record_count() < 1) {
				echo "No post with the reported ID found";
			} else {
				list($PostID,$Body,$TopicID,$PostNum,$Title,$Username) = $DB->next_record();
				echo "<a href='forums.php?action=viewthread&amp;threadid=".$TopicID."&post=".$PostNum."#post".$PostID."'>Post#$PostID by ".display_str($Username)." in thread '".display_str($Title)."'</a>";
			}
			break;
		case "requests_comment" :
			$DB->query("SELECT rc.RequestID, 
                                     rc.Body, 
                                     (SELECT COUNT(ID) FROM requests_comments 
                                                       WHERE ID <= ".$ThingID." 
                                                       AND requests_comments.RequestID = rc.RequestID) AS CommentNum ,
                                     r.Title,
                                     u.Username
                                     FROM requests_comments AS rc
                                     LEFT JOIN requests AS r ON r.ID = rc.RequestID 
                                     LEFT JOIN users_main AS u ON u.ID = rc.AuthorID WHERE rc.ID=".$ThingID);
			if($DB->record_count() < 1) {
				echo "No comment with the reported ID found";
			} else {
				list($RequestID, $Body, $PostNum,$Title,$Username) = $DB->next_record();
				$PageNum = ceil($PostNum / TORRENT_COMMENTS_PER_PAGE);
				echo "<a href='requests.php?action=view&amp;id=".$RequestID."&page=".$PageNum."#post".$ThingID."'>Comment#$ThingID by ".display_str($Username)." in request '".display_str($Title)."'</a>";
			}
			break;
		case "torrents_comment" :
			$DB->query("SELECT tc.GroupID, 
                                     tc.Body, 
                                     (SELECT COUNT(ID) FROM torrents_comments 
                                                       WHERE ID <= ".$ThingID." 
                                                       AND torrents_comments.GroupID = tc.GroupID) AS CommentNum,
                                     tg.Name,
                                     u.Username
                                     FROM torrents_comments AS tc
                                     LEFT JOIN torrents_group AS tg ON tg.ID = tc.GroupID 
                                     LEFT JOIN users_main AS u ON u.ID = tc.AuthorID WHERE tc.ID=".$ThingID);
			if($DB->record_count() < 1) {
				echo "No comment with the reported ID found";
			} else {
				list($GroupID, $Body, $PostNum,$Title,$Username) = $DB->next_record();
				$PageNum = ceil($PostNum / TORRENT_COMMENTS_PER_PAGE);
				echo "<a href='torrents.php?id=".$GroupID."&page=".$PageNum."#post".$ThingID."'>Comment#$ThingID by ".display_str($Username)." in torrent '".display_str($Title)."'</a>";
			}
			break;
		case "collages_comment" :
			$DB->query("SELECT cc.CollageID, 
                                     cc.Body, 
                                     (SELECT COUNT(ID) FROM collages_comments 
                                                       WHERE ID <= ".$ThingID." 
                                                       AND collages_comments.CollageID = cc.CollageID) AS CommentNum,
                                     c.Name,
                                     u.Username
                                     FROM collages_comments AS cc
                                     LEFT JOIN collages AS c ON c.ID = cc.CollageID 
                                     LEFT JOIN users_main AS u ON u.ID = tc.UserID WHERE cc.ID=".$ThingID);
			if($DB->record_count() < 1) {
				echo "No comment with the reported ID found";
			} else {
				list($CollageID, $Body, $PostNum,$Title,$Username) = $DB->next_record();
				$PerPage = POSTS_PER_PAGE;
				$PageNum = ceil($PostNum / $PerPage);
				echo "<a href='collage.php?action=comments&amp;collageid=".$CollageID."&page=".$PageNum."#post".$ThingID."'>Comment#$ThingID by ".display_str($Username)." in collage '".display_str($Title)."'</a>";
			}
			break;
	}
?>
				</strong>
			</td>
		</tr>
            <tr class="rowb">
                <td colspan="2"><?=$Text->full_format($Reason, get_permissions_advtags($SnitchID))?></td>
		</tr>
<? if($Status != "Resolved") { ?>
            <tr class="rowa">
			<td class="center" colspan="2">
				<input type="submit" name="submit" value="Resolved" />
			</td>
		</tr>
<? } ?>
	</table>
</form>
</div>
<br />
<?
	$DB->set_query_id($Reports);
}
?>
</div>
<div class="linkbox">
<?
	echo $Pages;
?>
</div>
<?
show_footer();
?>
