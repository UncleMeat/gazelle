<?
enforce_login();
if(!isset($_REQUEST['action'])) {
	error(404);
} else {
	switch($_REQUEST['action']){
		case 'site':
			include(SERVER_ROOT.'/sections/stats/site.php');
			break;
		case 'users':
			include(SERVER_ROOT.'/sections/stats/users.php');
			break;
		case 'torrents':
			include(SERVER_ROOT.'/sections/stats/torrents.php');
			break;
	}
}
?>
