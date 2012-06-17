 <?
/************************************************************************
//------------// Main friends page //----------------------------------//
This page lists a user's friends. 

There's no real point in caching this page. I doubt users load it that 
much.
************************************************************************/

// Number of users per page 
define('FRIENDS_PER_PAGE', '20');



show_header('Friends','jquery');
 

$UserID = $LoggedUser['ID'];


list($Page,$Limit) = page_limit(FRIENDS_PER_PAGE);

// Main query
$DB->query("SELECT 
	SQL_CALC_FOUND_ROWS
	f.FriendID,
	f.Comment,
	m.Username,
	m.Uploaded,
	m.Downloaded,
	m.PermissionID,
	m.Enabled,
	m.Paranoia,
	i.Donor,
	i.Warned,
	m.Title,
	m.LastAccess,
	i.Avatar
	FROM friends AS f
	JOIN users_main AS m ON f.FriendID=m.ID
	JOIN users_info AS i ON f.FriendID=i.UserID
	WHERE f.UserID='$UserID'
	ORDER BY Username LIMIT $Limit");
$Friends = $DB->to_array(false, MYSQLI_BOTH, array(7));

// Number of results (for pagination)
$DB->query('SELECT FOUND_ROWS()');
list($Results) = $DB->next_record();

// Start printing stuff
?>
<div class="thin">
	<div class="linkbox">
<?
// Pagination
$Pages=get_pages($Page,$Results,FRIENDS_PER_PAGE,9);
echo $Pages;

if($Results > 0) {
?>
        <span style="float:right;">&nbsp;&nbsp;[<a href="#" onclick="Toggle_All(false);">hide all</a>]</span>&nbsp;
        <span style="float:right;">&nbsp;&nbsp;[<a href="#" onclick="Toggle_All(true);">show all</a>]</span>&nbsp;
<?
}
?>
	</div>
	<div class="head">Friends list</div>
	<div class="box pad">
<?
if($Results == 0) {
	echo '<p>You have no friends! :(</p>';
} else {
    // Start printing out friends
    foreach($Friends as $Friend) {
          list($FriendID, $Comment, $Username, $Uploaded, $Downloaded, $Class, $Enabled, $Paranoia, $Donor, $Warned, $Title, $LastAccess, $Avatar) = $Friend;
    ?>
    <form action="friends.php" method="post">
          <input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
          <table class="friends_table vertical_margin">
                <tr>
                      <td class="colhead" colspan="3">
                            <span style="float:left;"><?=format_username($FriendID, $Username, $Donor, $Warned, $Enabled == 2 ? false : true, $Class, $Title, true)?>
    <?	if(check_paranoia('ratio', $Paranoia, $Class, $FriendID)) { ?>
                            &nbsp;Ratio: <strong><?=ratio($Uploaded, $Downloaded)?></strong>
    <?	} ?>
    <?	if(check_paranoia('uploaded', $Paranoia, $Class, $FriendID)) { ?>
                            &nbsp;Up: <strong><?=get_size($Uploaded)?></strong>
    <?	} ?>
    <?	if(check_paranoia('downloaded', $Paranoia, $Class, $FriendID)) { ?>
                            &nbsp;Down: <strong><?=get_size($Downloaded)?></strong>
    <?	} ?>
                            </span>

                            <span style="float:right;">&nbsp;&nbsp;<a href="#" class="togglelink" onclick="$('#friend<?=$FriendID?>').toggle(); this.innerHTML=(this.innerHTML=='(Hide)'?'(View)':'(Hide)'); return false;">(View)</a></span>&nbsp;

    <?	if(check_paranoia('lastseen', $Paranoia, $Class, $FriendID)) { ?>
                            <span style="float:right;"><?=time_diff($LastAccess)?></span>
    <?	} ?>
                      </td>
                </tr>
                <tr id="friend<?=$FriendID?>" class="hidden friendinfo">
                      <td width="50px" valign="top">
    <?
          if(empty($HeavyInfo['DisableAvatars'])) {
                if(!empty($Avatar)) {
                      if(check_perms('site_proxy_images')) {
                            $Avatar = 'http'.($SSL?'s':'').'://'.SITE_URL.'/image.php?c=1&i='.urlencode($Avatar);
                      }
          ?> 
                                  <img src="<?=$Avatar?>" alt="<?=$Username?>'s avatar" width="50px" />
          <?	} else { ?> 
                                  <img src="<?=STATIC_SERVER?>common/avatars/default.png" width="50px" alt="Default avatar" />
          <?	} 
          } ?> 
                      </td>
                      <td valign="top">
                                  <input type="hidden" name="friendid" value="<?=$FriendID?>" />

                                  <textarea name="comment" rows="4" class="long"><?=$Comment?></textarea>
                      </td>
                      <td class="left" valign="top" width="100px" >
                                  <input type="submit" name="action" value="Update" /><br />
                                  <input type="submit" name="action" value="Defriend" /><br />
                                  <input type="submit" name="action" value="Contact" /><br />

                      </td>
                </tr>
          </table>
    </form>
    <?
    } // while
?>
<script type="text/javascript">
        function Toggle_All(open){
            if (open) {
                $('.friendinfo').show(); // weirdly the $ selector chokes when trying to set multiple elements innerHTML with a class selector
                jQuery('.togglelink').html('(Hide)');
            } else {
                $('.friendinfo').hide();
                jQuery('.togglelink').html('(View)'); 
            }
            return false;
        }
</script>
<?
} // end else has results
// close <div class="box pad">
?>
	</div>
	<div class="linkbox">
		<?=$Pages?>
	</div>
<? // close <div class="thin">  ?>
</div>
<?
show_footer();
?>
