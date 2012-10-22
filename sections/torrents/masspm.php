<?
if(!check_perms('site_moderate_requests')) {
	error(403);
}
//if(!isset($_GET['id']) || !is_number($_GET['id']) || !isset($_GET['torrentid']) || !is_number($_GET['torrentid'])) { error(0); }
if( !isset($_GET['torrentid']) || !is_number($_GET['torrentid']) ) { 
    error(0);
}

//$GroupID = $_GET['id'];
$TorrentID = $_GET['torrentid'];
/*
$DB->query("SELECT
		t.FreeTorrent,
		t.Dupable,
		t.DupeReason,
		t.Description AS TorrentDescription,
		tg.Name AS Title,
		t.GroupID,
		t.UserID,
		t.FreeTorrent
		FROM torrents AS t
		JOIN torrents_group AS tg ON tg.ID=t.GroupID
		WHERE t.ID='$TorrentID'"); */

$DB->query("SELECT
		tg.Name AS Title,
		t.GroupID
		FROM torrents AS t
		JOIN torrents_group AS tg ON tg.ID=t.GroupID
		WHERE t.ID='$TorrentID'");

list($Properties) = $DB->to_array(false,MYSQLI_BOTH);

if(!$Properties) { error(404); }

show_header('Send Mass PM', 'upload,bbcode,inbox');


include(SERVER_ROOT.'/classes/class_text.php');
$Text = new TEXT;

?>
<div class="thin">
	<h2>Send PM To All Snatchers Of "<?=$Properties['Title']?>"</h2>
      
        <div id="preview" class="hidden"></div>
        <form action="torrents.php" method="post" id="messageform">
            <div id="quickpost">  
                <br/>
                <div class="box pad">
		<input type="hidden" name="action" value="takemasspm" />
		<input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
		<input type="hidden" name="torrentid" value="<?=$TorrentID?>" />
		<input type="hidden" name="groupid" value="<?=$Properties['GroupID']?>" />
                        <h3>Subject</h3>
                        <input type="text" name="subject" class="long" value="<?=(!empty($Subject) ? $Subject : '')?>"/>
                        <br />
                        <h3>Message</h3>  
                        <? $Text->display_bbcode_assistant("message", get_permissions_advtags($LoggedUser['ID'], $LoggedUser['CustomPermissions'])); ?>
                        <textarea id="message" name="message" class="long" rows="10"><?=(!empty($Body) ? $Body : '')?></textarea>
                </div>
            </div>
		<div class="center">
			 <input type="button" id="previewbtn" value="Preview" onclick="Inbox_Preview();" /> 
			 <input type="submit" value="Send Mass PM" />
		</div>
        </form>
        
      <?  /*  
	<form action="torrents.php" method="post" >
		<input type="hidden" name="action" value="takemasspm" />
		<input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
		<input type="hidden" name="torrentid" value="<?=$TorrentID?>" />
		<input type="hidden" name="groupid" value="<?=$GroupID?>" />
		<table>
			<tr>
				<td class="label">Subject</td>
				<td>
						<input type="text" name="subject" value="" size="60" />
				</td>
			</tr>
			<tr>
				<td class="label">Message</td>
				<td>
			 <? $Text->display_bbcode_assistant("message", get_permissions_advtags($LoggedUser['ID'], $LoggedUser['CustomPermissions'])); ?>
						<textarea name="message" id="message" cols="60" rows="8"></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2" class="center">
						<input type="submit" value="Send Mass PM" />
				</td>
			</tr>
		</table>
	</form>
       
       */ ?>
</div>
<?
show_footer();
?>
