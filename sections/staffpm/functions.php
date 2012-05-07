<?
function print_compose_staff_pm($Hidden = true, $Text = false) { 
        global $LoggedUser;  
        if (!$Text){
            include(SERVER_ROOT.'/classes/class_text.php');
            $Text = new TEXT;
        }
        ?>
		<div id="compose" class="<?=($Hidden ? 'hidden' : '')?>">
             <? if ( $LoggedUser['SupportFor'] !="" || $LoggedUser['DisplayStaff'] == 1 ) {  ?>
                    <div class="box pad">
                      <strong class="important_text">Are you sure you want to send a message to staff? You are staff yourself you know...</strong>
                    </div>
             <? }  ?>
                    <div id="preview" class="hidden"></div>
                    <form action="staffpm.php" method="post" id="messageform">
                    <div id="quickpost">  
				<input type="hidden" name="action" value="takepost" />
				<input type="hidden" name="prependtitle" value="Staff PM - " />
                                          
				<label for="subject"><h3>Subject</h3></label>
				<input class="long" type="text" name="subject" id="subject" />
				<br />
				
				<label for="message"><h3>Message</h3></label>
                            <? $Text->display_bbcode_assistant("message"); ?>
				<textarea rows="10" class="long" name="message" id="message"></textarea>
				<br />
				
                    </div>
				<input type="button" value="Hide" onClick="$('#compose').toggle();return false;" />
                        
				<strong>Send to: </strong>
				<select name="level">
					<option value="0" selected="selected">First Line Support</option>
					<option value="500">Mod Pervs</option>
					<option value="600">Admins</option>
				</select>
				<input type="button" id="previewbtn" value="Preview" onclick="Inbox_Preview();" /> 
                        <input type="submit" value="Send message" />
                    
			</form>
		</div>
<? } ?>
