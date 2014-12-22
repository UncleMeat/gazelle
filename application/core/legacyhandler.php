<?php
namespace gazelle\core;

class LegacyHandler {

    public $master;

    public function __construct(Master $master) {
        $this->master = $master;
    }

    public function handle_legacy_request($section) {
        $this->master->settings->set_legacy_constants();
        $this->script_start();
        if (is_null($section)) {
            error(404);
        } else {
            $this->load_section($section);
        }
        $this->script_finish();
    }

    public function load_section($section) {
        global $SSL, $ScriptStartTime, $Debug, $DB, $Cache, $Enc, $UA, $SS, $Browser, $OperatingSystem,
            $Mobile, $Classes, $ClassLevels, $ClassNames, $NewCategories, $LoginCookie, $SessionID,
            $LoggedUser, $UserID, $UserSessions, $Enabled, $UserStats, $LightInfo, $HeavyInfo, $Permissions,
            $CurIP, $NewIP, $ipcc, $Stylesheets, $Sitewide_Freeleech, $FullLogging, $TorrentUserStatus;

        require(SERVER_ROOT . '/sections/' . $section . '/index.php');
    }

    public function script_start() {
        # This code was originally part of script_start.php

        # First mark a whole lot of vars global since they were previously not inside a class context
        global $SSL, $ScriptStartTime, $Debug, $DB, $Cache, $Enc, $UA, $SS, $Browser, $OperatingSystem,
            $Mobile, $Classes, $ClassLevels, $ClassNames, $NewCategories, $LoginCookie, $SessionID,
            $LoggedUser, $UserID, $UserSessions, $Enabled, $UserStats, $LightInfo, $HeavyInfo, $Permissions,
            $CurIP, $NewIP, $ipcc, $Stylesheets, $Sitewide_Freeleech, $FullLogging, $TorrentUserStatus;

        require_once(SERVER_ROOT . '/common/main_functions.php');
        require_once(SERVER_ROOT . '/classes/class_debug.php'); //Require the debug class
        require_once(SERVER_ROOT . '/classes/class_encrypt.php'); //Require the encryption class
        require_once(SERVER_ROOT . '/classes/class_time.php'); //Require the time class
        require_once(SERVER_ROOT . '/classes/class_search.php'); //Require the searching class
        require_once(SERVER_ROOT . '/classes/class_paranoia.php'); //Require the paranoia check_paranoia function
        require_once(SERVER_ROOT . '/classes/regex.php');


        require(SERVER_ROOT . '/classes/class_proxies.php');
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']) && proxyCheck($_SERVER['REMOTE_ADDR'])) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

        $SSL = (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);

        if (!isset($argv) && !empty($_SERVER['HTTP_HOST'])) { //Skip this block if running from cli or if the browser is old and shitty
            if (!$SSL && $_SERVER['HTTP_HOST'] == 'www.' . NONSSL_SITE_URL) {
                header('Location: http://' . NONSSL_SITE_URL . $_SERVER['REQUEST_URI']);
                die();
            }
            if ($SSL && $_SERVER['HTTP_HOST'] == 'www.' . NONSSL_SITE_URL) {
                header('Location: https://' . SSL_SITE_URL . $_SERVER['REQUEST_URI']);
                die();
            }
            if (SSL_SITE_URL != NONSSL_SITE_URL) {
                if (!$SSL && $_SERVER['HTTP_HOST'] == SSL_SITE_URL) {
                    header('Location: https://' . SSL_SITE_URL . $_SERVER['REQUEST_URI']);
                    die();
                }
                if ($SSL && $_SERVER['HTTP_HOST'] == NONSSL_SITE_URL) {
                    header('Location: https://' . SSL_SITE_URL . $_SERVER['REQUEST_URI']);
                    die();
                }
            }
            if ($_SERVER['HTTP_HOST'] == 'www.m.' . NONSSL_SITE_URL) {
                header('Location: http://m.' . NONSSL_SITE_URL . $_SERVER['REQUEST_URI']);
                die();
            }
        }

        $ScriptStartTime = microtime(true); //To track how long a page takes to create

        ob_start(); //Start a buffer, mainly in case there is a mysql error

        $Debug = new \DEBUG;
        $Debug->handle_errors();
        $Debug->set_flag('Debug constructed');

        $DB = $this->master->olddb;
        $Cache = $this->master->cache;
        $Enc = new \CRYPT;
        $UA = $this->master->clientidentifier;
        $SS = new \SPHINX_SEARCH;

        //Begin browser identification

        $Browser = $UA->browser($_SERVER['HTTP_USER_AGENT']);
        $OperatingSystem = $UA->operating_system($_SERVER['HTTP_USER_AGENT']);
        //$Mobile = $UA->mobile($_SERVER['HTTP_USER_AGENT']);
        $Mobile = in_array($_SERVER['HTTP_HOST'], array('m.' . NONSSL_SITE_URL, 'm.' . NONSSL_SITE_URL));

        $Debug->set_flag('start user handling');

        // Get permissions
        list($Classes, $ClassLevels, $ClassNames) = $Cache->get_value('classes');
        if (!$Classes || !$ClassLevels) {
            $DB->query("SELECT ID, Name, Level, Color, LOWER(REPLACE(Name,' ','')) AS ShortName, IsUserClass FROM permissions ORDER BY IsUserClass, Level"); //WHERE IsUserClass='1'
            $Classes = $DB->to_array('ID');
            $ClassLevels = $DB->to_array('Level');
            $ClassNames = $DB->to_array('ShortName');
            $Cache->cache_value('classes', array($Classes, $ClassLevels, $ClassNames), 0);
        }
        $Debug->set_flag('Loaded permissions');
        $NewCategories = $Cache->get_value('new_categories');
        if (!$NewCategories) {
            $DB->query('SELECT id, name, image, tag FROM categories ORDER BY name ASC');
            $NewCategories = $DB->to_array('id');
            $Cache->cache_value('new_categories', $NewCategories);
        }
        $Debug->set_flag('Loaded new categories');

        //-----------------------------------------------------------------------------------
        /////////////////////////////////////////////////////////////////////////////////////
        //-- Load user information ----------------------------------------------------------
        // User info is broken up into many sections
        // Heavy - Things that the site never has to look at if the user isn't logged in (as opposed to things like the class, donor status, etc)
        // Light - Things that appear in format_user
        // Stats - Uploaded and downloaded - can be updated by a script if you want super speed
        // Session data - Information about the specific session
        // Enabled - if the user's enabled or not
        // Permissions

        $auth = $this->master->auth;
        list($UserID, $SessionID, $UserSessions, $Enabled) = $auth->load_session();
        if ($UserID) {
            $LoggedUser['ID'] = $UserID;

            // Up/Down stats
            $UserStats = $Cache->get_value('user_stats_' . $LoggedUser['ID']);
            if (!is_array($UserStats)) {
                $DB->query("SELECT Uploaded AS BytesUploaded, Downloaded AS BytesDownloaded, RequiredRatio, Credits as TotalCredits FROM users_main WHERE ID='$LoggedUser[ID]'");
                $UserStats = $DB->next_record(MYSQLI_ASSOC);
                $Cache->cache_value('user_stats_' . $LoggedUser['ID'], $UserStats, 3600);
            }

            // Get info such as username
            $LightInfo = user_info($LoggedUser['ID']);
            $HeavyInfo = user_heavy_info($LoggedUser['ID']);

            // Get user permissions
            $Permissions = get_permissions($LightInfo['PermissionID']);
            // Create LoggedUser array
            $LoggedUser = array_merge($HeavyInfo, $LightInfo, $Permissions, $UserStats);

            $LoggedUser['RSS_Auth'] = md5($LoggedUser['ID'] . RSS_HASH . $LoggedUser['torrent_pass']);

            //$LoggedUser['RatioWatch'] as a bool to disable things for users on Ratio Watch
            $LoggedUser['RatioWatch'] = (
                    $LoggedUser['RatioWatchEnds'] != '0000-00-00 00:00:00' &&
                   // time() < strtotime($LoggedUser['RatioWatchEnds']) &&
                    ($LoggedUser['BytesDownloaded'] * $LoggedUser['RequiredRatio']) > $LoggedUser['BytesUploaded']
                    );
            if (!isset($LoggedUser['ID'])) {
                $Debug->log_var($LightInfo, 'LightInfo');
                $Debug->log_var($HeavyInfo, 'HeavyInfo');
                $Debug->log_var($Permissions, 'Permissions');
                $Debug->log_var($UserStats, 'UserStats');
            }

            //Load in the permissions
            $LoggedUser['Permissions'] = get_permissions_for_user($LoggedUser['ID'], $LoggedUser['CustomPermissions']);

            //Change necessary triggers in external components
            $Cache->CanClear = check_perms('admin_clear_cache');

            $RealIP = $_SERVER['REMOTE_ADDR'];
            // Because we <3 our staff
            if (check_perms('site_disable_ip_history')) {
                $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
            }
            
            $auth->session_update($this->master->server['REMOTE_ADDR'], $Browser, $OperatingSystem);

            // Notifications
            if (isset($LoggedUser['Permissions']['site_torrents_notify'])) {
                $LoggedUser['Notify'] = $Cache->get_value('notify_filters_' . $LoggedUser['ID']);
                if (!is_array($LoggedUser['Notify'])) {
                    $DB->query("SELECT ID, Label FROM users_notify_filters WHERE UserID='$LoggedUser[ID]'");
                    $LoggedUser['Notify'] = $DB->to_array('ID');
                    $Cache->cache_value('notify_filters_' . $LoggedUser['ID'], $LoggedUser['Notify'], 2592000);
                }
            }

            // IP changed
            if ($LoggedUser['IP'] != $_SERVER['REMOTE_ADDR'] && !check_perms('site_disable_ip_history')) {
                if (site_ban_ip($_SERVER['REMOTE_ADDR'])) {
                    error('Your IP has been banned.');
                }

                $CurIP = db_string($LoggedUser['IP']);
                $NewIP = db_string($_SERVER['REMOTE_ADDR']);
                $DB->query("UPDATE users_history_ips SET
                        EndTime='" . sqltime() . "'
                        WHERE EndTime IS NULL
                        AND UserID='$LoggedUser[ID]'
                        AND IP='$CurIP'");
                $DB->query("INSERT IGNORE INTO users_history_ips
                        (UserID, IP, StartTime) VALUES
                        ('$LoggedUser[ID]', '$NewIP', '" . sqltime() . "')");

                $ipcc = geoip($NewIP);
                $DB->query("UPDATE users_main SET IP='$NewIP', ipcc='$ipcc' WHERE ID='$LoggedUser[ID]'");
                $Cache->begin_transaction('user_info_heavy_' . $LoggedUser['ID']);
                $Cache->update_row(false, array('IP' => $_SERVER['REMOTE_ADDR']));
                $Cache->commit_transaction(0);
            }

            // Get stylesheets
            $Stylesheets = $Cache->get_value('stylesheets');
            if (!is_array($Stylesheets)) {
                $DB->query('SELECT ID, LOWER(REPLACE(Name," ","_")) AS Name, Name AS ProperName FROM stylesheets');
                $Stylesheets = $DB->to_array('ID', MYSQLI_BOTH);
                $Cache->cache_value('stylesheets', $Stylesheets, 600);
            }

            //A9 TODO: Clean up this messy solution
            $LoggedUser['StyleName'] = $Stylesheets[$LoggedUser['StyleID']]['Name'];

            if (empty($LoggedUser['Username'])) {
                $auth->logout(); // Ghost
            }
        }

        $Debug->set_flag('end user handling');

        // -- may as well set $Global_Freeleech_On here as its tested in private_header & browse etc
        $DB->query('SELECT FreeLeech, FullLogging FROM site_options');
        list($Sitewide_Freeleech, $FullLogging) = $DB->next_record();
        $Sitewide_Freeleech_On = $Sitewide_Freeleech > sqltime();

        // full logging for analysing bots!
        if ($FullLogging!='0') {
            $uri = $_SERVER['REQUEST_URI'];
            if($FullLogging=='3' ||
               ($FullLogging=='2' && !in_array($uri, array( "/torrents.php?action=resort_tags", "/torrents.php?action=update_status"))) ||
               ($FullLogging=='1' && substr($uri, 0, 9)=='/user.php') ) {
                $vars = implode("|", $_REQUEST);
                if ($vars) {
                    $keys = implode("|", array_keys($_REQUEST));
                    $vars = "~$keys~$vars";
                }
                $DB->query("INSERT INTO full_log (userID, time, ip, ipnum, request, variables)
                                 VALUES ( '$LoggedUser[ID]' , '".db_string(sqltime())."', '".db_string($RealIP)."', '" . ip2unsigned($RealIP) . "',
                                          '".db_string($uri)."', '".db_string($_SERVER['REQUEST_METHOD']. $vars )."' )");
            }
        }
        unset($RealIP);
        unset($keys);
        unset($vars);

        $TorrentUserStatus = $Cache->get_value('torrent_user_status_'.$LoggedUser['ID']);
        if ($TorrentUserStatus === false) {
            $DB->query("
                SELECT fid as TorrentID,
                    IF(xbt.remaining >  '0', 'L', 'S') AS PeerStatus
                FROM xbt_files_users AS xbt
                    WHERE active='1' AND uid =  '".$LoggedUser['ID']."'");
            $TorrentUserStatus = $DB->to_array('TorrentID');
            $Cache->cache_value('torrent_user_status_'.$LoggedUser['ID'], $TorrentUserStatus, 600);
        }

        $Debug->set_flag('start function definitions');

        ### FUNCTIONS USED TO BE DEFINED HERE, NOW IN application/common/main_functions.php ###

        $Debug->set_flag('ending function definitions');
    }

    public function script_finish() {
        # This code was originally part of script_start.php
        global $Debug;

        $Debug->set_flag('completed module execution');

        /* Required in the absence of session_start() for providing that pages will change
          upon hit rather than being browser cache'd for changing content. */
        header('Cache-Control: no-cache, must-revalidate, post-check=0, pre-check=0');
        header('Pragma: no-cache');

        //Flush to user
        ob_end_flush();

        $Debug->set_flag('set headers and send to user');

        //Attribute profiling
        $Debug->profile();
    }

}
