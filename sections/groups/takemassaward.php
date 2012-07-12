<?

//******************************************************************************//
//
//******************************************************************************//

authorize();

enforce_login();


$GroupID = (int) $_POST['groupid'];
$AddBadges = $_POST['addbadge'];

$DB->query("SELECT Name, Comment from groups WHERE ID=$GroupID");
if ($DB->record_count() == 0)
    error(0);
list($GName, $GDescription) = $DB->next_record();


// FIXME: Still need a better perm name
if (!check_perms('site_moderate_requests')) {
    error(403);
}
 
$DB->query('SELECT UserID 
              FROM users_groups 
             WHERE GroupID=' . $GroupID);
 
if ($DB->record_count() > 0) {
    $Users = $DB->to_array();

    foreach ($Users as $UserID) {

        $UserID = $UserID[0];

        if (is_array($AddBadges)) {
            
            $DB->query("SELECT BadgeID
                          FROM users_badges 
                         WHERE UserID = $UserID");
            $UserBadgeIDs = $DB->collect('BadgeID');

            $SQL = 'INSERT INTO users_badges (UserID, BadgeID, Title) VALUES';
            $Div = '';
            $SQL_IN = '';
            $count = 0;
            foreach ($AddBadges as $AddBadgeID) {
                $AddBadgeID = (int)$AddBadgeID;
                if (!in_array($AddBadgeID, $UserBadgeIDs)) {
                    $Tooltip = db_string(display_str($_POST['addbadge' . $AddBadgeID]));
                    $SQL .= "$Div ('$UserID', '$AddBadgeID', '$Tooltip')";
                    $SQL_IN .= "$Div $AddBadgeID";
                    $Div = ',';
                    $count++;
                }
            }
            if ($count>0) {
                $DB->query($SQL);

                $BadgesAdded = '';
                $Div = '';
                $DB->query("SELECT Name FROM badges WHERE ID IN ( $SQL_IN )");
                while (list($Name) = $DB->next_record()) {
                    $BadgesAdded .= "$Div $Name";
                    $Div = ',';
                }
                $Cache->delete_value('user_badges_ids_' . $UserID);
                $Cache->delete_value('user_badges_' . $UserID);


                $Summary = sqltime() . " - Group Award: $BadgesAdded have been awarded to the $GName group.";
                $DB->query("UPDATE users_info SET AdminComment=CONCAT_WS( '\n', '$Summary', AdminComment) WHERE UserID='$UserID'");

                send_pm($UserID, 0, "Congratulations you have received an award.", "Congratulations you have received the $BadgesAdded award.");
            }
        }
    }
}

            
foreach ($AddBadges as $AddBadgeID) {
    $AddBadgeID = (int)$AddBadgeID;
    $SQL_IN .= "$Div $AddBadgeID";
}
$BadgesAdded = '';
$Div = '';
$DB->query("SELECT Name FROM badges WHERE ID IN ( $SQL_IN )");
while (list($Name) = $DB->next_record()) {
    $BadgesAdded .= "$Div $Name";
    $Div = ',';
}

$Log = sqltime() . " - [color=magenta]Mass Award given[/color] by [user]{$LoggedUser['Username']}[/user] - award: $BadgesAdded";
$DB->query("UPDATE groups SET Log=CONCAT_WS( '\n', '$Log', Log) WHERE ID='$GroupID'");

header("Location: groups.php?groupid=$GroupID");
?>
