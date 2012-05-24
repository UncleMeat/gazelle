<?php

/*
 * Possibly this should not be hardcoded... and should be changeable in the toolbox somewhere
 * while it is hardcoded it can go here
 */

// how long they get to fix their upload before autodeletion is set here
function get_warning_time(){
    return time() + (12 * 60 * 60); // 12 hours...   ?
}


// message is in two parts so we can grab the bits around the reason for display etc.
function get_warning_message($FirstPart = true, $LastPart = false, $GroupID=0, $TorrentName='', $Reason = null, $KillTime = '', $Rejected = false){
    $Message = '';
    if ($FirstPart){
        if ($Rejected) $Message .= "[br]Unfortunately the fix you made for your upload is not good enough.[br]The following message still applies:[br]";
        $Message .= "[br]Your upload [url=http://". SITE_URL ."/torrents.php?id=$GroupID]{$TorrentName}[/url] does not meet our standards for uploading and has been marked for deletion.";
        $Message .= "[br][br][size=3][b]It will be automatically deleted if you do not fix your upload in the next ". time_diff($KillTime, 1, false)." &nbsp;(".date('M d Y, H:i', ($KillTime)).").[/b][/size]";
        $Message .= '[br][br][b]Reason: [/b]&nbsp;';
    }
    if ($Reason) $Message.= "[color=red][b]{$Reason}[/b][/color]";
    if ($LastPart){
        //$Message .= "[br][b]Time left: [/b]&nbsp; ". time_diff($KillTime, 2, false)." &nbsp;(".date('M d Y, H:i', strtotime($KillTime)).")";
        $Message .= '[br][br]Please make sure you read the [url=http://'. SITE_URL .'/articles.php?topic=upload]Upload Rules[/url]';
        $Message .= '[br]You will find useful guides in the [url=http://'. SITE_URL .'/articles.php?topic=tutorials]Tutorials section[/url]';
        $Message .= '[br]If you need further help please post in the [url=http://'. SITE_URL .'/forums.php?action=viewforum&amp;forumid=17]Help & Support Forum[/url]';
    }
    return $Message;
}

// a reply to an existing conversation 
function send_message_reply($ConvID, $ToID, $FromID, $Message, $SetStatus = false, $FromStaff = true){   //, $Unanswered = false){
    global $LoggedUser, $DB, $Cache;
    
    $DB->query("INSERT INTO staff_pm_messages (UserID, SentDate, Message, ConvID)
                       VALUES ($FromID, '".sqltime()."', '".db_string($Message)."', $ConvID)");
    
    if ($SetStatus !== FALSE){
        // Update conversation (if from user 
        if ($SetStatus == 'Resolved') $SQL_insert = "Status='Resolved', ResolverID=$FromID"; 
        elseif ($SetStatus == 'Open') $SQL_insert = "Status='Open'"; 
        else $SQL_insert = "Status='Unanswered'"; 

        $DB->query("UPDATE staff_pm_conversations SET Date='".sqltime()."', Unread=true, $SQL_insert WHERE ID=$ConvID");
    }
    
    if($FromStaff){
        $Cache->delete_value('num_staff_pms_'.$FromID);
        $Cache->delete_value('num_staff_pms_open_'.$FromID);
        $Cache->delete_value('num_staff_pms_my_'.$FromID);
    } 
    elseif($ToID>0)  // Clear cache for user
        $Cache->delete_value('staff_pm_new_'.$ToID);
    
}

// the message the user sends to staff to tell them its fixed
function get_user_okay_message($GroupID, $TorrentName, $KillTime, $Reason){
    
    $Message = "[br]I have fixed my upload [url=http://". SITE_URL ."/torrents.php?id=$GroupID]{$TorrentName}[/url].";
    $Message .= "[br][br]note for staff: deal with this by going to the torrent detail page and using the review tools to mark as 'Accept Fix' or 'Reject Fix'.";
    $Message .= "[br][br][b]Reason it needed fixing:[/b]&nbsp;$Reason";
    $Message .= "[br][b]Time left: [/b]&nbsp; ". time_diff($KillTime, 2, false)." &nbsp;(".date('M d Y, H:i', strtotime($KillTime)).")";
    return $Message;
}

// from staff to user when fixed
function get_fixed_message($GroupID, $TorrentName){
    $Message = "[br]Thank-you for fixing your upload [url=http://". SITE_URL ."/torrents.php?id=$GroupID]{$TorrentName}[/url].";
    return $Message;
}

?>
