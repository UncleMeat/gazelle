<?
/* AJAX Previews, simple stuff. */

include(SERVER_ROOT.'/classes/class_text.php'); // Text formatting class
$Text = new TEXT;

$Content = $_REQUEST['desc']; // Don't use URL decode.
echo $Text->full_format($Content);
 
?>
