<?
/* AJAX Previews, simple stuff. */

include(SERVER_ROOT.'/classes/class_text.php'); // Text formatting class
$Text = new TEXT;

$Title = $_REQUEST['title'];  
$Body = $_REQUEST['body']; //  
  
echo '<div class="box vertical_space">
		<div class="head">
			<strong>'. display_str($Title).' </strong> - posted Just now 
			- <a href="#quickreplypreview">[Edit]</a> 
			<a href="#quickreplypreview">[Delete]</a>
		</div>
		<div class="pad">'.$Text->full_format($Body).'</div> 
	</div>
      <br />';
   
?>

