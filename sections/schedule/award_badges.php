<?

/*
 * To be run from the scheduler to award badges
 *  forumwhore,Masterwhore,legendaryMasterwhore
 * 
 * requests
 * 
 * 
 */


$DB->query("SELECT BadgeID, Name, Action, SendPM, Value, CategoryID, Description, Image 
              FROM badges_auto AS ba 
              JOIN badges AS b ON b.ID=ba.BadgeID
             WHERE ba.Active=1");
$AutoActions = $DB->to_array();

foreach($AutoActions as $AutoAction) {
    list($BadgeID, $Name, $Action, $SendPM, $Value, $CategoryID, $Description, $Image) = $AutoAction;
    
    $WHERE = false;
    
    switch($Action){ // count things done by user
        case 'NumComments':
            $WHERE = "(SELECT Count(*) FROM torrents_comments WHERE AuthorID=users_main.ID)>=$Value";
            break;
        
        case 'NumPosts':
            $WHERE = "(SELECT Count(*) FROM forums_posts WHERE AuthorID=users_main.ID)>=$Value";
            break;
        
        case 'RequestsFilled':
            $WHERE = "(SELECT Count(*) FROM requests WHERE FillerID=users_main.ID)>=$Value";
            break;
        
        case 'AmountUploaded':
            $Value *= 1099511627776;    // = 1024 * 1024 * 1024 * 1024; // value is in TB
            $WHERE = "Uploaded>=$Value";
            break;
        
        case 'AmountDownloaded':
            $Value *= 1099511627776;    // = 1024 * 1024 * 1024 * 1024; // value is in TB
            $WHERE = "Downloaded>=$Value";
            break;
        
        case 'NumUploaded':
            if($CategoryID >0) // category specific awards
                $WHERE = "(SELECT Count(*) FROM torrents AS t JOIN torrents_group AS tg ON tg.ID = t.GroupID
                                    WHERE tg.NewCategoryID=$CategoryID AND UserID=users_main.ID)>=$Value";
            else               // count all torrents
                $WHERE = "(SELECT Count(*) FROM torrents WHERE UserID=users_main.ID)>=$Value";
            break;
        
        case 'NumNewTags': // unique tags
            $WHERE = "(SELECT Count(*) FROM tags WHERE UserID=users_main.ID)>=$Value";
            break;
        
        case 'NumTags': // tags added to torrents
            $WHERE = "(SELECT Count(*) FROM torrents_tags WHERE UserID=users_main.ID)>=$Value";
            break;
        
        case 'NumTagVotes':
            $WHERE = "(SELECT Count(*) FROM torrents_tags_votes WHERE UserID=users_main.ID)>=$Value";
            break; 
       
        
        case 'MaxSnatches': // of a torrent this user uploaded
            $WHERE = "(SELECT Max(Snatched) FROM torrents WHERE UserID=users_main.ID)>=$Value";
            break;
    }
    
    
    if ($WHERE){
        
        $DB->query("SELECT ID FROM users_main 
                     WHERE Enabled=1
                       AND $WHERE
                       AND ID NOT IN (SELECT DISTINCT u.ID 
                                        FROM users_main AS u 
                                        JOIN users_badges AS ub ON u.ID = ub.UserID
                                       WHERE ub.BadgeID = $BadgeID)");

        $UserIDs = $DB->collect('ID');

        if (count($UserIDs) > 0) {
 
            $SQL_IN = implode(',',$UserIDs);

            $DB->query("UPDATE users_info SET AdminComment = CONCAT('".sqltime()." - ". db_string($Name)." ". db_string($Description)."\n', AdminComment) WHERE UserID IN ($SQL_IN)");

		$Values = "('".implode("', '".$BadgeID."', '".db_string($Description)."'), ('", $UserIDs)."', '".$BadgeID."', '".db_string($Description)."')";
            
            $DB->query("INSERT INTO users_badges (UserID, BadgeID, Title) VALUES $Values");

            // IF we want to send users pm's when they get an award we should do it here, 
            // BUT it means looping through each user and sending the pm 
            // (no way to shortcut afaics because you need the inserted conv_id to link message and conversation) 
            if ($SendPM){
                foreach($UserIDs as $UserID) {
                    send_pm($UserID, 0, "Congratulations you have been awarded the $Name", 
                            "[center][br][br][img]http://".SITE_NAME.'/'.STATIC_SERVER."common/badges/{$Image}[/img][br][br][size=5][color=white][bg=#0261a3][br]{$Description}[br][br][/bg][/color][/size][/center]");
                }
            }
        }
    }
                
}  // end while auto actions


?>
