<?
/* AJAX Previews, simple stuff. */

include(SERVER_ROOT.'/classes/class_text.php'); // Text formatting class
$Text = new TEXT;

$Imageurl = $_REQUEST['image']; // Don't use URL decode.
if (!empty($Imageurl)) {
    if ($Text->valid_url($Imageurl)){ 
        echo $Text->full_format('[align=center][img]'.$Imageurl.'[/img][/align]');
    } else {
        echo "<strong class=\"important_text\">Not a valid url</strong>";
    }
}  else {
    echo "<strong class=\"important_text\">No Cover Image</strong>";
}
?>
