<?
enforce_login();

if(!isset($_REQUEST['action']))
	$_REQUEST['action'] = '';

// get vars from LoggedUser
$SupportFor =  $LoggedUser['SupportFor'];
$DisplayStaff =  $LoggedUser['DisplayStaff'];
// Logged in user is staff
$IsStaff = ($DisplayStaff == 1);
// Logged in user is Staff or FLS
$IsFLS = ($SupportFor != '' || $IsStaff);
       
switch($_REQUEST['action']) {
	case 'viewconv':	
		require('viewconv.php');
		break;
	case 'takepost':
		require('takepost.php');
		break;
	case 'resolve':
		require('resolve.php');
		break;
	case 'unresolve':
		require('unresolve.php');
		break;
	case 'multiresolve':
		require('multiresolve.php');
		break;
	case 'assign':
		require('assign.php');
		break;
	case 'make_donor':
		require('makedonor.php');
		break;
	case 'responses':
		require('common_responses.php');
		break;
	case 'get_response':
		require('ajax_get_response.php');
		break;
	case 'delete_response':
		require('ajax_delete_response.php');
		break;
	case 'edit_response':
		require('ajax_edit_response.php');
		break;
	case 'preview':
		require('ajax_preview_response.php');
		break;
        
	case 'user_inbox': // so staff can access the user interface too
		require('user_inbox.php');
		break;
	case 'staff_inbox': //  
	default:
		if ($IsStaff || $IsFLS) {
			require('staff_inbox.php');
		} else {
			require('user_inbox.php');
		}
		break;
}

?>
