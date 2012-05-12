<?

if(empty($Return)) {
	$ToID = $_GET['to'];
	if($ToID == $LoggedUser['ID']) {
		error("You cannot start a conversation with yourself!");
		header('Location: inbox.php');
	}
}

if(!$ToID || !is_number($ToID)) { error(404); }

if(!empty($LoggedUser['DisablePM']) && !isset($StaffIDs[$ToID])) {
	error(403);
}

$DB->query("SELECT Username FROM users_main WHERE ID='$ToID'");
list($Username) = $DB->next_record();
if(!$Username) { error(404); }

include(SERVER_ROOT.'/classes/class_text.php');
$Text = new TEXT;

show_header('Compose', 'inbox,bbcode');
?>
<div class="thin">
        <div id="preview" class="hidden"></div>
        <form action="inbox.php" method="post" id="messageform">
            <div id="quickpost">  
                <h2>Send a message to <a href="user.php?id=<?=$ToID?>"><?=$Username?></a></h2>
                <br/>
                <div class="box pad">
                        <input type="hidden" name="action" value="takecompose" />
                        <input type="hidden" name="toid" value="<?=$ToID?>" />
                        <input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
                        <h3>Subject</h3>
                        <input type="text" name="subject" class="long" value="<?=(!empty($Subject) ? $Subject : '')?>"/>
                        <br />
                        <h3>Body</h3>  
                        <? $Text->display_bbcode_assistant("body", get_permissions_advtags($LoggedUser['ID'], $LoggedUser['CustomPermissions'])); ?>
                        <textarea id="body" name="body" class="long" rows="10"><?=(!empty($Body) ? $Body : '')?></textarea>
                </div>
            </div>
		<div class="center">
			 <input type="button" id="previewbtn" value="Preview" onclick="Inbox_Preview();" /> 
			 <input type="submit" value="Send message" />
		</div>
        </form>
</div>

<?
show_footer();
?>
