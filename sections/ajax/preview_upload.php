<?
/* AJAX Previews, simple stuff. */

include(SERVER_ROOT.'/classes/class_text.php'); // Text formatting class
$Text = new TEXT;

$Content = $_REQUEST['desc']; // Don't use URL decode.
 
$Imageurl = $_REQUEST['image']; // Don't use URL decode.
if (!empty($Imageurl)) {
    if ($Text->valid_url($Imageurl)){ 
        $Imageurl = $Text->full_format('[align=center][img]'.$Imageurl.'[/img][/align]');
    } else {
        $Imageurl = "<div style=\"text-align: center;\"><strong class=\"important_text\">Not a valid url</strong></div>";
    }
}  else {
    $Imageurl = "<div style=\"text-align: center;\"><strong class=\"important_text\">No Cover Image</strong></div>";
}
 
 
echo '<table cellpadding="3" cellspacing="1" border="0" class="border slice" width="100%">
    <tr>
        <td class="label">Cover Image</td>
        <td> 
		'.$Imageurl .'    
        </td>
    </tr> 
    <tr>
        <td class="label">Description</td>
        <td>
            '.$Text->full_format($Content, get_permissions_advtags($LoggedUser['ID'], $LoggedUser['CustomPermissions'])).'                              
        </td>
    </tr> 
</table>';
   
?>

