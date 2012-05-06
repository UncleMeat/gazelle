<?

include(SERVER_ROOT.'/classes/class_text.php'); // Text formatting class
$Text = new TEXT;

$Subject = $_REQUEST['subject'];
$Body = $_REQUEST['body'];

echo'
			  <h2>'. display_str($Subject).'</h2>
                    <div class="box">
                        <div class="head">
                               '. format_username($LoggedUser['ID'], $LoggedUser['Username'], $LoggedUser['Donor'], $LoggedUser['Warned'], $LoggedUser['Enabled'] == 2 ? false : true, $LoggedUser['PermissionID'], $LoggedUser['Title'], true). '  Just now - [Quote]
                        </div>
                        <div class="body">'.$Text->full_format($Body).'</div>
                    </div>';
   
?>
