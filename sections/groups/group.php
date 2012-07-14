 <?
/************************************************************************/
 include(SERVER_ROOT.'/classes/class_text.php');
$Text = new TEXT;

// Number of users per page 
define('USERS_PER_PAGE', '50');

if (isset($_REQUEST['userid']) && $_REQUEST['userid'] >0) $SelectUserID = (int)$_REQUEST['userid'];

$GroupID = (int)$_REQUEST['groupid'];

$DB->query("SELECT Name, Comment, Log
            FROM groups 
            WHERE ID=$GroupID");
if ($DB->record_count()==0) error(0);
list($Name, $Comment, $Log) = $DB->next_record();

show_header("User Group : $Name",'jquery,groups');
 


list($Page,$Limit) = page_limit(USERS_PER_PAGE);

// Main query
$DB->query("SELECT 
	SQL_CALC_FOUND_ROWS
	u.UserID,
	u.Comment,
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
	FROM users_groups AS u
	JOIN users_main AS m ON u.UserID=m.ID
	JOIN users_info AS i ON u.UserID=i.UserID
	WHERE u.GroupID='$GroupID'
	ORDER BY m.Username ASC LIMIT $Limit");
$Users = $DB->to_array(false, MYSQLI_BOTH, array(7));

// Number of results (for pagination)
$DB->query('SELECT FOUND_ROWS()');
list($Results) = $DB->next_record();

?>
<div class="thin">
    <div class="head"><a href="groups.php">Groups</a>  &gt; <?=$Name?></div>
    
    <form action="groups.php" method="post">
          <input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
          <input type="hidden" name="groupid" value="<?=$GroupID?>" />
          <input type="hidden" name="applyto" value="group" />
          <table class="friends_table vertical_margin">
                <tr>
                      <td class="colhead" colspan="2">Testers User Group</td>
                </tr>
                <tr>
                      <td valign="top">
                            <input class="long" type="text" name="name" value="<?=display_str($Name)?>" />
                      </td>
                      <td class="left" valign="top" width="110px" >
                            <input type="submit" name="action" value="change name" title="Update group name" /><br />
                      </td>
                </tr>
          </table>
          <table class="friends_table vertical_margin">
                <tr>
                      <td class="colhead" colspan="2">Comment<span style="float:right;"><a href="#" onclick="$('#gcomment').toggle(); this.innerHTML=(this.innerHTML=='(Hide)'?'(View)':'(Hide)'); return false;">(Hide)</a></span></td>
                </tr>
                <tr id="gcomment" class="pad">
                      <td valign="top">
                            <textarea name="comment" rows="4" class="long"><?=$Comment?></textarea>
                      </td>
                      <td class="left" valign="top" width="110px" >
                            <input type="submit" name="action" value="update" title="Update comment field" /><br />
                      </td>
                </tr>
          </table>
          <table class="friends_table vertical_margin">
                <tr>
                      <td class="colhead" colspan="2">Log<span style="float:right;"><a href="#" onclick="$('#grouplog').toggle(); this.innerHTML=(this.innerHTML=='(Hide)'?'(View)':'(Hide)'); return false;">(View)</a></span></td>
                </tr>
                <tr id="grouplog" class="hidden pad">
                      <td valign="top" colspan="2" >
                          <div id="bonuslog" class="box pad">
                                <?=(!$Log ? 'no group history' :$Text->full_format($Log))?>
                          </div>
                      </td>
                </tr>
          </table>
          <table class="friends_table vertical_margin">
                <tr>
                      <td class="colhead" colspan="2">Add users<span style="float:right;"><a href="#" onclick="$('#showuserrow').toggle(); this.innerHTML=(this.innerHTML=='(Hide)'?'(View)':'(Hide)'); return false;">(Hide)</a></span></td>
                </tr> 
                <tr id="showuserrow" class="pad">
                      <td valign="top">
                            <div id="showuserlist" class="hidden"></div>
                            <textarea id="adduserstext" name="adduserstext" rows="1" class="long" title="Enter names or id numbers of users to add to this group"></textarea>
                      </td>
                      <td class="left" valign="top" width="110px" >
                            <input id="checkusersbutton" type="button" value="check users" onclick="Check_Users()" title="Check and validate the list of users before adding" />
                            <input id="editusersbutton" class="hidden" type="button" value="change input" onclick="Edit_Users()" title="Edit the list of users" />
                            <input id="addusersbutton" class="hidden" disabled="disabled" type="submit" name="action" value="add users" title="Add users to group" />
                      </td>
                </tr>
          </table>
          <table class="friends_table vertical_margin">
                <tr>
                      <td class="colhead" colspan="5">Actions</td>
                </tr>
                <tr>
                      <td width="25%" class="noborder center"></td>
                      <td width="200px" valign="top" class="noborder center">
                            <input type="submit" name="action" value="mass pm" title="Mass PM this group" /><br />
                      </td>
                      <td width="200px" valign="top" class="noborder center">
                            <input type="submit" name="action" value="group award" title="Give Award to all members of this group" /><br />
                      </td>
                      <td width="200px" valign="top" class="noborder center">
                            <input type="submit" name="action" value="remove all" disabled="disabled" title="Remove all members from this group" /><br />
                      </td>
                      <td width="25%" class="noborder center"></td>
                </tr>
          </table>
    </form>
     
    
    <div class="linkbox">
<?
            // Pagination
            $Pages=get_pages($Page,$Results,USERS_PER_PAGE,9);
            echo $Pages;

            if($Results > 0) { ?>
                <span style="float:right;">&nbsp;&nbsp;[<a href="#" onclick="Toggle_All(false);">hide all</a>]</span>&nbsp;
                <span style="float:right;">&nbsp;&nbsp;[<a href="#" onclick="Toggle_All(true);">show all</a>]</span>&nbsp;
<?          }   ?>
    </div>
    
    <div class="colhead">members of <?=$Name?></div>
    <div class="box pad">          
<?
if($Results == 0) {
	echo '<p>There are no users in this group</p>';
} else {
    foreach($Users as $User) {
          list($UserID, $Comment, $Username, $Uploaded, $Downloaded, $Class, $Enabled, $Paranoia, $Donor, $Warned, $Title, $LastAccess, $Avatar) = $User;
    ?>
    <form action="groups.php" method="post">
          <input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
          <input type="hidden" name="groupid" value="<?=$GroupID?>" />
          <input type="hidden" name="userid" value="<?=$UserID?>" />
          <input type="hidden" name="applyto" value="user" />
          <table class="friends_table vertical_margin">
                <tr>
                      <td class="colhead" colspan="3">
                            <span style="float:left;"><?=format_username($UserID, $Username, $Donor, $Warned, $Enabled == 2 ? false : true, $Class, $Title, true)?>
    <?	if(check_paranoia('ratio', $Paranoia, $Class, $UserID)) { ?>
                            &nbsp;Ratio: <strong><?=ratio($Uploaded, $Downloaded)?></strong>
    <?	} ?>
    <?	if(check_paranoia('uploaded', $Paranoia, $Class, $UserID)) { ?>
                            &nbsp;Up: <strong><?=get_size($Uploaded)?></strong>
    <?	} ?>
    <?	if(check_paranoia('downloaded', $Paranoia, $Class, $UserID)) { ?>
                            &nbsp;Down: <strong><?=get_size($Downloaded)?></strong>
    <?	} ?>
                            </span>

                            <span style="float:right;">&nbsp;&nbsp;<a href="#" class="togglelink" onclick="$('#friend<?=$UserID?>').toggle(); this.innerHTML=(this.innerHTML=='(Hide)'?'(View)':'(Hide)'); return false;"><?=($SelectUserID==$UserID?'(Hide)':'(View)')?></a></span>&nbsp;

    <?	if(check_paranoia('lastseen', $Paranoia, $Class, $UserID)) { ?>
                            <span style="float:right;"><?=time_diff($LastAccess)?></span>
    <?	} ?>
                      </td>
                </tr>
                <tr id="friend<?=$UserID?>" class="<?=$SelectUserID==$UserID?'':'hidden '?>friendinfo">
                      <td width="50px" valign="top">
    <?
          if(empty($HeavyInfo['DisableAvatars'])) {
                if(!empty($Avatar)) {
                      if(check_perms('site_proxy_images')) {
                            $Avatar = 'http'.($SSL?'s':'').'://'.SITE_URL.'/image.php?c=1&i='.urlencode($Avatar);
                      }  ?> 
                            <img src="<?=$Avatar?>" alt="<?=$Username?>'s avatar" width="50px" />
          <?	} else { ?> 
                            <img src="<?=STATIC_SERVER?>common/avatars/default.png" width="50px" alt="Default avatar" />
          <?	} 
          } ?> 
                      </td>
                      <td valign="top">
                                  <textarea name="comment" rows="4" class="long"><?=$Comment?></textarea>
                      </td>
                      <td class="left" valign="top" width="100px" >
                                  <input type="submit" name="action" value="update" title="Update comment field" /><br />
                                  <input type="submit" name="action" value="remove" title="Remove <?=$Username?> from group" /><br />
                                  <input type="submit" name="action" value="pm user" title="Send <?=$Username?> a PM" /><br />

                      </td>
                </tr>
          </table>
    </form>
    <?
    }
}
?>
    </div>
    <div class="linkbox">
		<?=$Pages?>
    </div>
    
</div>
<?
show_footer();
?>
