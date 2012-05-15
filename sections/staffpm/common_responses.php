<?
if (!($IsFLS)) {
	// Logged in user is not FLS or Staff
	error(403);
}

show_header('Staff PMs', 'bbcode,staffpm,jquery');

include(SERVER_ROOT.'/classes/class_text.php'); // Text formatting class
include(SERVER_ROOT.'/sections/staffpm/functions.php');
$Text = new TEXT;

list($NumMy, $NumUnanswered, $NumOpen) = get_num_staff_pms($LoggedUser['ID'], $LoggedUser['Class']);
?>
<div class="thin">
	<h2>Staff PMs - Manage common responses</h2>
	<div class="linkbox">
<? 	if ($IsStaff) {
?>		[ &nbsp;<a href="staffpm.php?view=my">My unanswered<?=$NumMy>0?" ($NumMy)":''?></a>&nbsp; ] &nbsp; 
<? 	} ?>
		[ &nbsp;<a href="staffpm.php?view=unanswered">All unanswered<?=$NumUnanswered>0?" ($NumUnanswered)":''?></a>&nbsp; ] &nbsp; 
		[ &nbsp;<a href="staffpm.php?view=open">Open<?=$NumOpen>0?" ($NumOpen)":''?></a>&nbsp; ] &nbsp; 
		[ &nbsp;<a href="staffpm.php?view=resolved">Resolved</a>&nbsp; ] &nbsp; 
<?	if ($ConvID = (int)$_GET['convid']) { ?>
		[ &nbsp;<a href="staffpm.php?action=viewconv&id=<?=$ConvID?>">Back to conversation</a>&nbsp; ]
<?	} ?>
		<br />
		<br />
	</div>
	<div id="commonresponses" class="center">
		<br />
		<div class="center">
			<h3>Create new response:</h3>
		</div>
		<div class="messagecontainer" id="container_0"><div id="ajax_message_0" class="hidden center messagebar"></div></div>
		<div id="response_0" class="box">
			<form id="response_form_0" action="" method="post">
				<div class="head">
					<strong>Name:</strong> 
					<input onfocus="if (this.value == 'New name') this.value='';" 
						   onblur="if (this.value == '') this.value='New name';" 
						   type="text" name="name" id="response_name_0" size="87" value="New name" 
					/>
				</div>
				<div class="box pad hidden" id="response_div_0" style="text-align:left;">
				</div>
				<div  class="pad" id="response_editor_0" >
                            <? $Text->display_bbcode_assistant("response_message_0", true); ?>
					<textarea class="long" onfocus="if (this.value == 'New message') this.value='';" 
							  onblur="if (this.value == '') this.value='New message';" 
							  rows="10" name="message" id="response_message_0">New message</textarea>
				</div>
					<br />
					<input type="button" value="Toggle preview" onClick="PreviewResponse(0);" />
					<!--<input type="button" value="Save" id="save_0" onClick="SaveMessage(0);" />-->
					<input type="hidden" name="convid" value="<?=$ConvID?>" />
					<input type="hidden" name="id" value="0" />
					<input type="hidden" name="action" value="edit_response" />
					<input type="submit" name="submit" value="Save" id="save_0" />
			</form>
		</div><a id="old_responses" name="old_responses"></a>
		<br />
		<br />
		<div class="center">
			<h3>Edit old responses:</h3>
		</div>
<?

// List common responses
$DB->query("SELECT ID, Message, Name FROM staff_pm_responses ORDER BY ID DESC");
while(list($ID, $Message, $Name) = $DB->next_record()) {
	
?>
		<div class="messagecontainer" id="container_<?=$ID?>"><div id="ajax_message_<?=$ID?>" class="hidden center messagebar"></div></div>
		<div id="response_<?=$ID?>" class="box">
			<form id="response_form_<?=$ID?>" action="">
				<div class="head">
					<strong>Name:</strong> 
					<input type="hidden" name="id" value="<?=$ID?>" />
					<input type="text" name="name" id="response_name_<?=$ID?>" size="87" value="<?=display_str($Name)?>" />
				</div>
				<div class="box pad" id="response_div_<?=$ID?>" style="text-align:left;">
						<?=$Text->full_format($Message, true)?>
				</div>
				<div class="pad hidden" id="response_editor_<?=$ID?>" >
                            <? $Text->display_bbcode_assistant("response_message_".$ID, true); ?>
					<textarea class="long" onfocus="if (this.value == 'New message') this.value='';" 
						   rows="10" id="response_message_<?=$ID?>" name="message"><?=display_str($Message)?></textarea>
					
				</div>
                        <br />
                        <input type="button" value="Toggle preview" onClick="PreviewResponse(<?=$ID?>);" />
				<input type="button" value="Delete" onClick="DeleteMessage(<?=$ID?>);" />
				<input type="button" value="Save" id="save_<?=$ID?>" onClick="SaveMessage(<?=$ID?>);" />
			</form>
		</div>
<?	
}

if(isset($_GET['added'])) { 
?>
    <script type="text/javascript">
        function Send_Message(){ <?
                $JustAdded = (int)$_GET['added'];
                if ($JustAdded>0) {
                      $Msg = "Response successfully created.";  ?>
                                    $('#ajax_message_<?=$JustAdded?>').remove_class('alert'); <?
                } else  {
                      if ($JustAdded==-1) $Msg='One or more fields were blank.';
                      elseif ($JustAdded==-2) $Msg='Not a valid ID!';
                      else $Msg = "Something unexpected went wrong!";  
                      $JustAdded=0; ?>
                                    $('#ajax_message_<?=$JustAdded?>').add_class('alert'); <?
                }  ?>
                                    $('#ajax_message_<?=$JustAdded?>').show();
                                    $('#ajax_message_<?=$JustAdded?>').raw().innerHTML = '<?=$Msg?>';
                                    setTimeout("jQuery('#ajax_message_<?=$JustAdded?>').fadeOut(400)", 3000); 
        }
        addDOMLoadEvent(Send_Message);
    </script>
<?
}
?>
	</div>
</div>
<?

show_footer();

?>
