<?

/* * ***************************************************************
  Tools switch center

  This page acts as a switch for the tools pages.

  TODO!
  -Unify all the code standards and file names (tool_list.php,tool_add.php,tool_alter.php)

 * *************************************************************** */

if (isset($argv[1])) {
    if ($argv[1] == "cli_sandbox") {
        include("misc/cli_sandbox.php");
        die();
    }

    $_REQUEST['action'] = $argv[1];
} else {
    if (empty($_REQUEST['action']) || ($_REQUEST['action'] != "public_sandbox" && $_REQUEST['action'] != "ocelot")) {
        enforce_login();
    }
}

if (!isset($_REQUEST['action'])) {
    include(SERVER_ROOT . '/sections/tools/tools.php');
    die();
}

if (substr($_REQUEST['action'], 0, 7) == 'sandbox' && !isset($argv[1])) {
    if (!check_perms('site_debug')) {
        error(403);
    }
}

if (substr($_REQUEST['action'], 0, 12) == 'update_geoip' && !isset($argv[1])) {
    if (!check_perms('site_debug')) {
        error(403);
    }
}

include(SERVER_ROOT . "/classes/class_validate.php");
$Val = NEW VALIDATE;

include(SERVER_ROOT . '/classes/class_feed.php');
$Feed = new FEED;

switch ($_REQUEST['action']) {
    case 'phpinfo':
        if (!check_perms('site_debug'))
            error(403);
        phpinfo();
        break;
    //Services
    case 'get_host':
        include(SERVER_ROOT . '/sections/tools/services/get_host.php');
        break;
    case 'get_cc':
        include(SERVER_ROOT . '/sections/tools/services/get_cc.php');
        break;
    //Managers
    case 'cheats':
        include(SERVER_ROOT . '/sections/tools/managers/speed_reports_list.php');
        break;

    case 'forum':
        include(SERVER_ROOT . '/sections/tools/managers/forum_list.php');
        break;

    case 'forum_alter':
        include(SERVER_ROOT . '/sections/tools/managers/forum_alter.php');
        break;

    case 'client_blacklist':
        include(SERVER_ROOT . '/sections/tools/managers/blacklist_list.php');
        break;

    case 'client_blacklist_alter':
        include(SERVER_ROOT . '/sections/tools/managers/blacklist_alter.php');
        break;

    case 'login_watch':
        include(SERVER_ROOT . '/sections/tools/managers/login_watch.php');
        break;

    case 'email_blacklist':
        include(SERVER_ROOT . '/sections/tools/managers/eb.php');
        break;

    case 'eb_alter':
        include(SERVER_ROOT . '/sections/tools/managers/eb_alter.php');
        break;

    case 'dnu':
        include(SERVER_ROOT . '/sections/tools/managers/dnu_list.php');
        break;

    case 'dnu_alter':
        include(SERVER_ROOT . '/sections/tools/managers/dnu_alter.php');
        break;

    case 'imghost_whitelist':
        include(SERVER_ROOT . '/sections/tools/managers/imagehost_list.php');
        break;

    case 'iw_alter':
        include(SERVER_ROOT . '/sections/tools/managers/imagehost_alter.php');
        break;


    case 'shop_list':
        include(SERVER_ROOT . '/sections/tools/managers/shop_list.php');
        break;

    case 'shop_alter':
        include(SERVER_ROOT . '/sections/tools/managers/shop_alter.php');
        break;

    case 'badges_list':
        include(SERVER_ROOT . '/sections/tools/managers/badges_list.php');
        break;

    case 'badges_alter':
        include(SERVER_ROOT . '/sections/tools/managers/badges_alter.php');
        break;

    case 'awards_auto':
        include(SERVER_ROOT . '/sections/tools/managers/awards_auto_list.php');
        break;

    case 'awards_alter':
        include(SERVER_ROOT . '/sections/tools/managers/awards_auto_alter.php');
        break;

    case 'categories':
        include(SERVER_ROOT . '/sections/tools/managers/categories_list.php');
        break;

    case 'categories_alter':
        include(SERVER_ROOT . '/sections/tools/managers/categories_alter.php');
        break;

    case 'editnews':
    case 'news':
        include(SERVER_ROOT.'/sections/tools/managers/news.php');
        break;

    case 'takeeditnews':
        if (!check_perms('admin_manage_news')) {
            error(403);
        }
        if (is_number($_POST['newsid'])) {
            $DB->query("UPDATE news SET Title='" . db_string($_POST['title']) . "', Body='" . db_string($_POST['body']) . "' WHERE ID='" . db_string($_POST['newsid']) . "'");
            $Cache->delete_value('news');
            $Cache->delete_value('feed_news');
        }
        header('Location: index.php');
        break;

    case 'deletenews':
        if (!check_perms('admin_manage_news')) {
            error(403);
        }
        if (is_number($_GET['id'])) {
            authorize();
            $DB->query("DELETE FROM news WHERE ID='" . db_string($_GET['id']) . "'");
            $Cache->delete_value('news');
            $Cache->delete_value('feed_news');

            // Deleting latest news
            $LatestNews = $Cache->get_value('news_latest_id');
            if ($LatestNews !== FALSE && $LatestNews == $_GET['id']) {
                $Cache->delete_value('news_latest_id');
            }
        }
        header('Location: index.php');
        break;

    case 'takenewnews':
        if (!check_perms('admin_manage_news')) {
            error(403);
        }

        $DB->query("INSERT INTO news (UserID, Title, Body, Time) VALUES ('$LoggedUser[ID]', '" . db_string($_POST['title']) . "', '" . db_string($_POST['body']) . "', '" . sqltime() . "')");
        $Cache->cache_value('news_latest_id', $DB->inserted_id(), 0);
        $Cache->delete_value('news');

        header('Location: index.php');
        break;

    case 'editarticle':
    case 'takeeditarticle':
    case 'articles':
        include(SERVER_ROOT.'/sections/tools/managers/articles.php');
        break;

    case 'takearticle':
        if (!check_perms('admin_manage_articles')) {
            error(403);
        }
        $DB->query("SELECT Count(*) as c FROM articles WHERE TopicID='" . db_string($_POST['topicid']) . "'");
        list($Count) = $DB->next_record();
        if ($Count > 0) {
            error('The topic ID must be unique for the article');
        }
        $DB->query("INSERT INTO articles (Category, SubCat, TopicID, Title, Description, Body, Time, MinClass) 
                    VALUES ('" . (int) $_POST['category'] . "', '" . (int) $_POST['subcat'] . "', '" . db_string($_POST['topicid']) . "', '" . db_string($_POST['title']) . "', '" . db_string($_POST['description']) . "', '" . db_string($_POST['body']) . "', '" . sqltime() . "','". db_string($_POST['level']) . "')");
        $NewID = $DB->inserted_id();
        $Cache->delete_value("articles_$_POST[category]");
        //header("Location: tools.php?action=editarticle&amp;id=$NewID");
	  header('Location: tools.php?action=articles');
        break;

    case 'deletearticle':
        if (!check_perms('admin_manage_articles')) {
            error(403);
        }
        if (is_number($_GET['id'])) {
            authorize();
            $DB->query("SELECT TopicID, Category FROM articles WHERE ID='" . db_string($_GET['id']) . "'");
            list($TopicID,$CatID) = $DB->next_record();
            $DB->query("DELETE FROM articles WHERE ID='" . db_string($_GET['id']) . "'");
            $Cache->delete_value('article_' . $TopicID);
            $Cache->delete_value("articles_$CatID");
        }

        header('Location: tools.php?action=articles');
        break;

    case 'tokens':
        include(SERVER_ROOT.'/sections/tools/managers/tokens.php');
        break;
    case 'ocelot':
        include(SERVER_ROOT.'/sections/tools/managers/ocelot.php');
        break;
    case 'official_tags':
        include(SERVER_ROOT.'/sections/tools/managers/official_tags.php');
        break;





    case 'official_tags_alter':
        include(SERVER_ROOT.'/sections/tools/managers/official_tags_alter.php');
        break;




    case 'marked_for_deletion':
        include(SERVER_ROOT.'/sections/tools/managers/mfd_functions.php');
        include(SERVER_ROOT.'/sections/tools/managers/mfd_manager.php');
        break;

    case 'save_mfd_options':
        enforce_login();
        authorize();

        if (!check_perms('torrents_review_manage'))
            error(403);

        if (isset($_POST['hours']) && is_number($_POST['hours']) &&
                isset($_POST['autodelete']) && is_number($_POST['autodelete'])) {

            $Hours = (int) $_POST['hours'];
            $AutoDelete = (int) $_POST['autodelete'] == 1 ? 1 : 0;
            $DB->query("UPDATE review_options 
                                   SET Hours=$Hours, AutoDelete=$AutoDelete");
        }
        include(SERVER_ROOT.'/sections/tools/managers/mfd_functions.php');
        include(SERVER_ROOT.'/sections/tools/managers/mfd_manager.php');
        break;

    case 'mfd_delete':
        enforce_login();
        authorize();

        include('managers/mfd_functions.php');

        if (!check_perms('torrents_review'))
            error(403);

        if (isset($_POST['submitdelall'])) {
            $Torrents = get_torrents_under_review('warned', true);
            if (count($Torrents)) {
                //$NumTorrents = count($Torrents); //echo "Num to delete: $NumTorrents";
                $NumDeleted = delete_torrents_list($Torrents);
            }
        } elseif ($_POST['submit'] == 'Delete selected') {
            // if ( !check_perms('torrents_review_manage')) error(403); ??

            $IDs = $_POST['id'];
            $Torrents = get_torrents_under_review('both', true, $IDs);
            if (count($Torrents)) {
                $NumDeleted = delete_torrents_list($Torrents);
            }
        }
        include(SERVER_ROOT.'/sections/tools/managers/mfd_manager.php');
        break;



    case 'permissions':
        if (!check_perms('admin_manage_permissions')) {
            error(403);
        }

        if (!empty($_REQUEST['id'])) {

            $Values = array();
            if (is_numeric($_REQUEST['id'])) {
                $JoinOn = ( $_POST['IsClass'] == 1) ? 'PermissionID' : 'GroupPermissionID';
                $DB->query("SELECT p.ID,p.Name,p.Level,p.Values,p.DisplayStaff,p.IsUserClass,
                                    p.MaxSigLength,p.MaxAvatarWidth,p.MaxAvatarHeight,COUNT(u.ID) 
                                    FROM permissions AS p LEFT JOIN users_main AS u ON u.$JoinOn=p.ID WHERE p.ID='" . db_string($_REQUEST['id']) . "' GROUP BY p.ID");
                list($ID, $Name, $Level, $Values, $DisplayStaff, $IsUserClass, $MaxSigLength, $MaxAvatarWidth, $MaxAvatarHeight, $UserCount) = $DB->next_record(MYSQLI_NUM, array(3));

                if ($IsUserClass == '1' && ($Level > $LoggedUser['Class'] || $_REQUEST['level'] > $LoggedUser['Class'])) {
                    error(403);
                }

                $Values = unserialize($Values);
            } else {
                $IsUserClass = isset($_POST['isclass']) && $_POST['isclass'] == 1 ? '1' : '0';
            }


            if (!empty($_POST['submit'])) {
                $Values = array();
                $Val->SetFields('name', true, 'string', 'You did not enter a valid name for this permission set.');
                if ($IsUserClass) {
                    $Val->SetFields('level', true, 'number', 'You did not enter a valid level for this permission set.');
                    $Val->SetFields('maxsiglength', true, 'number', 'You did not enter a valid number for MaxSigLength.');
                    $Val->SetFields('maxavatarwidth', true, 'number', 'You did not enter a valid number for MaxAvavtarWidth.');
                    $Val->SetFields('maxavatarheight', true, 'number', 'You did not enter a valid number for MaxAvavtarHeight.');
                    $Val->SetFields('maxcollages', true, 'number', 'You did not enter a valid number of personal collages.');

                    if (!is_numeric($_REQUEST['id'])) {
                        $DB->query("SELECT ID FROM permissions WHERE Level='" . db_string($_REQUEST['level']) . "'");
                        list($DupeCheck) = $DB->next_record();
                        if ($DupeCheck)
                            $Err = "There is already a user class with that level.";
                    }
                    $Level = $_REQUEST['level'];
                    $DisplayStaff = $_REQUEST['displaystaff'];
                    $MaxSigLength = $_REQUEST['maxsiglength'];
                    $MaxAvatarWidth = $_REQUEST['maxavatarwidth'];
                    $MaxAvatarHeight = $_REQUEST['maxavatarheight'];
                    $Values['MaxCollages'] = $_REQUEST['maxcollages'];
                } else {
                    if (!is_numeric($_REQUEST['id'])) { // new record
                        $DB->query("SELECT ID FROM permissions WHERE Name='" . db_string($_REQUEST['name']) . "'");
                        list($DupeCheck) = $DB->next_record();
                        if ($DupeCheck)
                            $Err = "There is already a permission class with that name.";
                    }
                    $Level = 202;
                    $DisplayStaff = '0';
                }
                if (!$Err)
                    $Err = $Val->ValidateForm($_POST);


                foreach ($_REQUEST as $Key => $Perms) {
                    if (substr($Key, 0, 5) == "perm_") {
                        $Values[substr($Key, 5)] = (int) $Perms;
                    }
                }

                $Name = $_REQUEST['name'];

                if (!$Err) {
                    if (!is_numeric($_REQUEST['id'])) {
                        $DB->query("INSERT INTO permissions 
                                            (Level,Name,`Values`,DisplayStaff,IsUserClass,MaxSigLength,MaxAvatarWidth,MaxAvatarHeight) 
                                     VALUES ('" . db_string($Level) . "','" . db_string($Name) . "','" . db_string(serialize($Values)) . "','" . db_string($DisplayStaff) . "','" . db_string($IsUserClass) . "','" . db_string($MaxSigLength) . "','" . db_string($MaxAvatarWidth) . "','" . db_string($MaxAvatarHeight) . "')");
                    } else {
                        $DB->query("UPDATE permissions SET Level='" . db_string($Level) . "',Name='" . db_string($Name) . "',`Values`='" . db_string(serialize($Values)) . "',DisplayStaff='" . db_string($DisplayStaff) . "',MaxSigLength='" . db_string($MaxSigLength) . "',MaxAvatarWidth='" . db_string($MaxAvatarWidth) . "',MaxAvatarHeight='" . db_string($MaxAvatarHeight) . "' WHERE ID='" . db_string($_REQUEST['id']) . "'");
                        $Cache->delete_value('perm_' . $_REQUEST['id']);
                    }
                    if ($IsUserClass)
                        $Cache->delete_value('classes');
                    else
                        $Cache->delete_value('group_permissions');
                } else {
                    error($Err);
                }
            }

            include('managers/permissions_alter.php');
        } else {
            if (!empty($_REQUEST['removeid']) && is_numeric($_REQUEST['removeid'])) {

                $DB->query("SELECT ID, IsUserClass FROM permissions WHERE ID='" . db_string($_REQUEST['removeid']) . "'");
                list($pID, $IsUserClass) = $DB->next_record(MYSQLI_NUM);
                if ($pID) {
                    $DB->query("DELETE FROM permissions WHERE ID='" . db_string($_REQUEST['removeid']) . "'");
                    $DB->query("UPDATE users_main SET PermissionID='" . APPRENTICE . "' WHERE PermissionID='" . db_string($_REQUEST['removeid']) . "'");
                    $DB->query("UPDATE users_main SET GroupPermissionID='0' WHERE GroupPermissionID='" . db_string($_REQUEST['removeid']) . "'");

                    $Cache->delete_value('classes');
                    $Cache->delete_value('group_permissions');
                }
            }

            include(SERVER_ROOT.'/sections/tools/managers/permissions_list.php');
        }

        break;

    case 'ip_ban':
        //TODO: Clean up db table ip_bans.
        include(SERVER_ROOT.'/sections/tools/managers/bans.php');
        break;

    //Data
    case 'registration_log':
        include(SERVER_ROOT.'/sections/tools/data/registration_log.php');
        break;

    case 'donation_log':
        include(SERVER_ROOT.'/sections/tools/data/donation_log.php');
        break;


    case 'upscale_pool':
        include(SERVER_ROOT.'/sections/tools/data/upscale_pool.php');
        break;

    case 'invite_pool':
        include(SERVER_ROOT.'/sections/tools/data/invite_pool.php');
        break;

    case 'torrent_stats':
        include(SERVER_ROOT.'/sections/tools/data/torrent_stats.php');
        break;

    case 'user_flow':
        include(SERVER_ROOT.'/sections/tools/data/user_flow.php');
        break;

    case 'economic_stats':
        include(SERVER_ROOT.'/sections/tools/data/economic_stats.php');
        break;

    case 'opcode_stats':
        include(SERVER_ROOT.'/sections/tools/data/opcode_stats.php');
        break;

    case 'service_stats':
        include(SERVER_ROOT.'/sections/tools/data/service_stats.php');
        break;

    case 'database_specifics':
        include(SERVER_ROOT.'/sections/tools/data/database_specifics.php');
        break;

    case 'special_users':
        include(SERVER_ROOT.'/sections/tools/data/special_users.php');
        break;


    case 'browser_support':
        include(SERVER_ROOT.'/sections/tools/data/browser_support.php');
        break;
    //END Data
    //Misc
    case 'update_geoip':
        include(SERVER_ROOT.'/sections/tools/misc/update_geoip.php');
        break;

    case 'dupe_ips':
        include(SERVER_ROOT.'/sections/tools/misc/dupe_ip.php');
        break;

    case 'clear_cache':
        include(SERVER_ROOT.'/sections/tools/misc/clear_cache.php');
        break;

    case 'create_user':
        include(SERVER_ROOT.'/sections/tools/misc/create_user.php');
        break;

    case 'manipulate_tree':
        include(SERVER_ROOT.'/sections/tools/misc/manipulate_tree.php');
        break;

    case 'recommendations':
        include(SERVER_ROOT.'/sections/tools/misc/recommendations.php');
        break;

    case 'analysis':
        include(SERVER_ROOT.'/sections/tools/misc/analysis.php');
        break;

    case 'sandbox1':
        include(SERVER_ROOT.'/sections/tools/misc/sandbox1.php');
        break;

    case 'sandbox2':
        include(SERVER_ROOT.'/sections/tools/misc/sandbox2.php');
        break;

    case 'sandbox3':
        include(SERVER_ROOT.'/sections/tools/misc/sandbox3.php');
        break;

    case 'sandbox4':
        include(SERVER_ROOT.'/sections/tools/misc/sandbox4.php');
        break;

    case 'sandbox5':
        include(SERVER_ROOT.'/sections/tools/misc/sandbox5.php');
        break;

    case 'sandbox6':
        include(SERVER_ROOT.'/sections/tools/misc/sandbox6.php');
        break;

    case 'sandbox7':
        include(SERVER_ROOT.'/sections/tools/misc/sandbox7.php');
        break;

    case 'sandbox8':
        include(SERVER_ROOT.'/sections/tools/misc/sandbox8.php');
        break;

    case 'public_sandbox':
        include(SERVER_ROOT.'/sections/tools/misc/public_sandbox.php');
        break;

    case 'mod_sandbox':
        if (check_perms('users_mod')) {
            include(SERVER_ROOT.'/sections/tools/misc/mod_sandbox.php');
        } else {
            error(403);
        }
        break;

    default:
        include(SERVER_ROOT . '/sections/tools/tools.php');
}
?>
