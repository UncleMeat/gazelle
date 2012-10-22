<?
if (!check_perms('users_manage_cheats')) error(403);

if (!isset($_GET['userid']) || !is_number($_GET['userid'])) error(0);
$UserID = (int)$_GET['userid'];

if ($_GET['action']=='watchlist_add') {
    
    $DB->query("INSERT IGNORE INTO users_watch_list ( UserID, StaffID, Time, KeepTorrents)
                                        VALUES ( '$UserID', '$LoggedUser[ID]', '".sqltime()."', '1' ) ");
    echo json_encode(array(true, 'added user to watchlist'));
    
} elseif ($_GET['action']=='watchlist_remove') {
    
    $DB->query("DELETE FROM users_watch_list WHERE UserID='$UserID'");
    echo json_encode(array(true, 'removed user from watchlist'));
}
?>
