<?php
global $DB, $Classes;
enforce_login();
authorize();
if ( !check_perms('site_give_specialgift') ) {
    error(404);
}

/* We should validate these.*/
if (empty($_POST['donate']) || !in_array($_POST['donate'], array('600', '3000', '6000'))) {
    $DONATE   = 300;
} else {
    $DONATE   = (int) $_POST['donate'];
}
if (empty($_POST['class']) || !in_array($_POST['class'], array("<= ".$Classes[SMUT_PEDDLER]['Level'], "<= ".$Classes[APPRENTICE]['Level'], "<= ".$Classes[PERV]['Level'], "<= ".$Classes[GOOD_PERV]['Level'], ">= ".$Classes[GOOD_PERV]['Level'], ">= ".$Classes[SEXTREME_PERV]['Level']))) {
    $CLASS    = "<= ".$Classes[SMUT_PEDDLER]['Level'];
} else {
    $CLASS    = (int) $_POST['class'];
}
if (empty($_POST['ratio']) || !in_array($_POST['ratio'], array('> 0.0', '< 0.5', '< 1.0', '> 1.0', '> 5.0'))) {
    $RATIO    = '> 0.0';
} else {
    $RATIO    = $_POST['ratio'];
}
if (empty($_POST['credits']) || !in_array($_POST['credits'], array('>= 0', '< 3000', '< 12000', '> 12000'))) {
    $CREDITS  = '>= 0';
} else {
    $CREDITS  = $_POST['credits'];
}
if (empty($_POST['last_seen']) || !in_array($_POST['last_seen'], array('1', '24', '3*24', '7*24'))) {
    $LASTSEEN = '1';
} else {
    $LASTSEEN = $_POST['last_seen'];
}


$DB->query("SELECT
                um.ID AS UserID
            FROM
                users_main as um
            LEFT JOIN
                permissions AS perm ON um.PermissionID=perm.ID
            WHERE
                perm.Level $CLASS
                AND IFNULL((um.Uploaded / um.Downloaded), ~0) $RATIO
                AND um.Credits $CREDITS
                AND um.LastAccess >= DATE_SUB(NOW(), INTERVAL $LASTSEEN HOUR)
                AND um.Enabled = '1'");
$Eligible_Users = array_column($DB->to_array(), 'UserID');
$Recipient = array_rand($Eligible_Users,1);
$Recipient = $Eligible_Users[$Recipient];
if(empty($Recipient)) {
    error("No users match this criteria");
}

$DB->query("SELECT
                PermissionID as Current_Class,
                IFNULL((Uploaded / Downloaded), '&infin;') AS Current_Ratio,
                Credits AS Current_Credits,
                LastAccess AS Current_LastAccess
            FROM
                users_main
            WHERE
                ID = $Recipient");

list($Current_Class, $Current_Ratio, $Current_Credits, $Current_LastAccess) = $DB->next_record();

$DB->query("UPDATE users_main
            SET
                Credits = Credits+$DONATE
            WHERE
                ID = $Recipient");
$Summary = sqltime().' | +'.ucfirst(number_format($DONATE)." credits | You received a special gift of ".number_format($DONATE)." credits from an anonymous perv");
$DB->query("UPDATE users_info
            SET
                BonusLog = CONCAT_WS('\n', '$Summary', BonusLog)
            WHERE
                UserID = $Recipient");

$DB->query("UPDATE users_main
            SET
                Credits = Credits-$DONATE
            WHERE
                ID = $UserID");
$Summary = sqltime().' | - '.ucfirst(number_format($DONATE)." credits | You gave a special gift of ".number_format($DONATE)." credits to an anonymous perv");
$DB->query("UPDATE users_info
            SET
                BonusLog = CONCAT_WS('\n', '$Summary', BonusLog)
            WHERE
                UserID = $UserID");

$DB->query("INSERT INTO users_special_gifts (UserID, CreditsGiven, Recipient)
                                    VALUES('$UserID', '$DONATE', '$Recipient')");

send_pm($Recipient, 0, "Special Gift - You received an anonymous gift of credits",
                            "[br]You received a gift of ".number_format ($DONATE)." credits from an anonymous user.");

$ResultMessage="Your gift has been given and gratefully received.\n\n".
               "The recipient has the rank of ".$Classes[$Current_Class]['Name']." and a ratio of $Current_Ratio,\n".
               "he had $Current_Credits credits and was last seen at $Current_LastAccess";
header("Location: bonus.php?action=msg&". (!empty($ResultMessage) ? "result=" .urlencode($ResultMessage):"")."&retsg");
