<?php
namespace gazelle\core;

use gazelle\errors\CLIError;
use gazelle\services\Profiler;
use gazelle\services\Settings;

class Master {

    public $superglobals;
    public $legacy_handler;

    public function __construct($application_dir, array $superglobals, $start_time = null) {
        $this->profiler = new Profiler($start_time);
        $this->application_dir = $application_dir;
        $this->superglobals = $superglobals;
        $this->server = $this->superglobals['server'];
        $this->settings = new Settings($this, $this->application_dir . '/settings.ini');
        if (!$this->settings->modes->profiler) {
            $this->profiler->disable();
        }
    }

    public function handle_legacy_request($section) {
        $this->legacy_handler = new LegacyHandler($this);
        $this->legacy_handler->handle_legacy_request($section);
    }

    public function handle_request() {
        if (array_key_exists('argv', $this->server)) {
            $this->handle_cli_request();
        } else {
            $this->handle_http_request();
        }
    }

    public function handle_cli_request() {
        $arguments = array_slice($this->server['argv'], 1);
        if (count($arguments) == 0) {
            throw new CLIError("No section specified.");
        }
        $section = $arguments[0];
        switch ($section) {
            case 'peerupdate':
            case 'schedule':
                define('MEMORY_EXCEPTION', true);
                define('TIME_EXCEPTION', true);
                define('ERROR_EXCEPTION', true);
                $this->handle_legacy_request($section);
                break;
            default:
                throw new CLIError("Invalid section for CLI usage: {$section}");
        }
    }

    public function handle_http_request() {
        $base = basename(parse_url($this->server['SCRIPT_NAME'], PHP_URL_PATH), '.php');
        if (!preg_match('/^[a-z0-9]+$/i', $base)) {
            $this->handle_legacy_request(null);
        }

        switch ($base) {
            case 'announce':
            case 'scrape':
                print("d14:failure reason40:Invalid .torrent, try downloading again.e\n");
                exit;

            case 'browse':
                header('Location: torrents.php');
                exit;

            case 'collage':
                $_SERVER['SCRIPT_FILENAME'] = 'collages.php'; // PHP CLI fix
                define('ERROR_EXCEPTION', true);
                $this->handle_legacy_request('collages');
                break;

            case 'details':
                $this->handle_legacy_request('torrents');
                break;

            case 'irc':
            case 'tools':
                $_SERVER['SCRIPT_FILENAME'] = $base.'.php'; // PHP CLI fix
                $this->handle_legacy_request($base);
                break;

            case 'schedule':
            case 'peerupdate':
                define('MEMORY_EXCEPTION', true);
                define('TIME_EXCEPTION', true);
                define('ERROR_EXCEPTION', true);
                $_SERVER['SCRIPT_FILENAME'] = $base.'.php'; // CLI Fix
                $this->handle_legacy_request($base);
                break;

            case 'signup':
                header('Location: register.php');
                exit;

            case 'whitelist':
                header('Location: articles.php?topic=clients');
                exit;

            case 'artist':
            case 'better':
            case 'bookmarks':
            case 'collages':
            case 'comments':
            case 'delays':
            case 'details':
            case 'forums':
            case 'friends':
            case 'groups':
            case 'staffblog':
            case 'tags':
            case 'torrents':
            case 'upload':
            case 'userhistory':
            case 'user':
            case 'wiki':
                define('ERROR_EXCEPTION', true); # Not sure why this is done only some of the time
                $this->handle_legacy_request($base);
                break;
                
            case 'ajax':
            case 'articles':
            case 'blog':
            case 'bonus':
            case 'captcha':
            case 'chat':
            case 'cheaters':
            case 'donate':
            case 'error':
            case 'inbox':
            case 'index':
            case 'login':
            case 'logout':
            case 'log':
            case 'register':
            case 'reports':
            case 'reportsv2':
            case 'requests':
            case 'rules':
            case 'sandbox':
            case 'staff':
            case 'staffpm':
            case 'stats':
            case 'top10':
            case 'watchlist':
                $this->handle_legacy_request($base);
                break;
            default:
                $this->handle_legacy_request(null);
        }
    }

}
