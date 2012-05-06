<?
enforce_login();

include(SERVER_ROOT.'/classes/class_text.php');
$Text = new TEXT;

show_header('Sandbox', 'bbcode');
?>
<div class="thin">
	<h2>Sandbox</h2>
      
	<form action="" method="post" id="messageform">
		<div class="box pad">
                  <h3 class="center">Practice your bbCode skills here</h3> 
			<div id="preview" class="hidden"><br/>
                        <h3 class="left">Preview:</h3> 
                        <div id="preview_content" class="box pad"></div> 
                  </div>
                  <? $Text->display_bbcode_assistant("body"); ?>
			<textarea id="body" name="body" class="long" rows="10"></textarea>
			<div class="center">
				<input  id="preview_button" type="button" value="Preview" onclick="Sandbox_Preview();" /> 
			</div>
		</div>
      </form>
</div>

<?
show_footer();
?>