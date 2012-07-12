<?
//******************************************************************************//
//--------------- Take mass pm -------------------------------------------------//
// This pages handles the backend of the 'send mass pm' function. It checks	 //
// the data, and if it all validates, it sends a pm to everyone who snatched	//
// the torrent.																 //
//******************************************************************************//

authorize();

enforce_login();

require(SERVER_ROOT.'/classes/class_validate.php');
$Validate = new VALIDATE;

$GroupID = (int)$_POST['groupid'];
$SenderID = isset($_POST['showsender']) ? $LoggedUser['ID'] : 0;
$Subject = db_string($_POST['subject']);
$Message = db_string($_POST['message']);

//******************************************************************************//
//--------------- Validate data in edit form -----------------------------------//

// FIXME: Still need a better perm name
if(!check_perms('site_moderate_requests')) {
	error(403);
}

$Validate->SetFields('groupid','1','number','Invalid group ID.',array('maxlength'=>1000000000, 'minlength'=>1)); // we shouldn't have group IDs higher than a billion either
$Validate->SetFields('subject','1','string','Invalid subject.',array('maxlength'=>1000, 'minlength'=>1));
$Validate->SetFields('message','1','string','Invalid message.',array('maxlength'=>10000, 'minlength'=>1));
$Err = $Validate->ValidateForm($_POST); // Validate the form

if($Err){
	error($Err);
	header('Location: '.$_SERVER['HTTP_REFERER']);
	die();
}

//******************************************************************************//
//--------------- Send PMs to users --------------------------------------------//

$DB->query('SELECT UserID FROM users_groups WHERE GroupID='.$GroupID);

if ($DB->record_count()>0) {
	$Users = $DB->to_array();
	foreach ($Users as $UserID) { 
		send_pm($UserID[0],($SenderID==$UserID[0]?0:$SenderID),$Subject,$Message); 
	}
}
$Log = isset($_POST['showsender']) ? "[user]{$LoggedUser['Username']}[/user]" : "System ([user]{$LoggedUser['Username']}[/user])";
$Log = sqltime()." - [color=purple]Mass PM sent[/color] by $Log - subject: $Subject";
$DB->query("UPDATE groups SET Log=CONCAT_WS( '\n', '$Log', Log) WHERE ID='$GroupID'");

//write_log("Mass PM sent to usergroup $GroupID by {$LoggedUser['Username']}");

header("Location: groups.php?groupid=$GroupID");

?>
