<?
authorize();


if(empty($_POST['toid'])) { error(404); }

if(!empty($LoggedUser['DisablePM']) && !isset($StaffIDs[$_POST['toid']])) {
	error(403);
}


if (isset($_POST['convid']) && is_number($_POST['convid'])) {
	$ConvID = $_POST['convid'];
	$Subject='';
	$ToID = explode(',', $_POST['toid']);
	foreach($ToID as $TID) {
		if(!is_number($TID)) {
			$Err = "A recipient does not exist.";
		}
	}
	$DB->query("SELECT UserID FROM pm_conversations_users WHERE UserID='$LoggedUser[ID]' AND ConvID='$ConvID'");
	if($DB->record_count() == 0) {
		error(403);
	}
} else {
	$ConvID='';
	if(!is_number($_POST['toid'])) {
		$Err = "This recipient does not exist.";
	} else {
		$ToID = (int)$_POST['toid'];
            if(!isset($StaffIDs[$LoggedUser[ID]])){ // staff are never blocked
                // check if this user is blocked from sending 
                $DB->query("SELECT Type FROM friends WHERE UserID='$ToID' AND FriendID='$LoggedUser[ID]'");
                list($FType)=$DB->next_record();
                if($FType == 'blocked') $Err = "This user cannot recieve PM's from you.";
                else {
                    $DB->query("SELECT BlockPMs FROM users_info WHERE UserID='$ToID'");
                    list($BlockPMs)=$DB->next_record();
                    if($BlockPMs == 2) $Err = "This user cannot recieve PM's from you.";
                    elseif($BlockPMs == 1 && $FType != 'friends') 
                        $Err = "This user cannot recieve PM's from you.";
                    
                }
            }
	}
	$Subject = trim($_POST['subject']);
	if (!$Err && empty($Subject)) {
		$Err = "You can't send a message without a subject.";
	}
}
$Body = trim($_POST['body']);
if(!$Err && empty($Body)) {
	$Err = "You can't send a message without a body!";
}

if(!empty($Err)) {
	error($Err);
	//header('Location: inbox.php?action=compose&to='.$_POST['toid']);
	$ToID = (int)$_POST['toid'];
	$Return = true;
	include(SERVER_ROOT.'/sections/inbox/compose.php');
	die();
}

$ConvID = send_pm($ToID,$LoggedUser['ID'],db_string($Subject),db_string($Body),$ConvID);

header('Location: inbox.php');
?>
