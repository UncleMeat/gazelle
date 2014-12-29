<?php
namespace gazelle\core;

use gazelle\errors\CLIError;
use gazelle\errors\InternalError;
use gazelle\services\Profiler;
use gazelle\services\Settings;
use gazelle\services\Cache;
use gazelle\services\ClientIdentifier;
use gazelle\services\OldDB;
use gazelle\services\Auth;

class Master {

    public $profiler;
    public $application_dir;
    public $superglobals;
    public $legacy_handler;

    public function __construct($application_dir, array $superglobals, $start_time = null) {
        $this->profiler = new Profiler($start_time);
        $this->application_dir = $application_dir;

        $this->superglobals = $superglobals;
        $this->server = $this->superglobals['server'];
        $this->cookie = $this->superglobals['cookie'];
        $this->request = $this->superglobals['request'];

        $this->settings = new Settings($this, $this->application_dir . '/settings.ini');
        if (!$this->settings->modes->profiler) {
            $this->profiler->disable();
        }
    }

    public function __get($name) {
        # Cheap way to get lazy loading Services
        switch ($name) {
            case 'cache':
                $this->cache = new Cache($this->settings->memcached->host, $this->settings->memcached->port);
                return $this->cache;
            case 'olddb':
                $this->olddb = new OldDB($this);
                return $this->olddb;
            case 'auth':
                $this->auth = new Auth($this);
                return $this->auth;
            case 'clientidentifier':
                $this->clientidentifier = new ClientIdentifier();
                return $this->clientidentifier;
            default:
                throw new InternalError("Attempt to access undefined \$master->{$name}");
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

    public function handle_trivial_cases() {
        //Deal with dumbasses
        if (isset($this->request['info_hash']) && isset($this->request['peer_id'])) {
            die('d14:failure reason40:Invalid .torrent, try downloading again.e');
        }
        $url_path = basename(parse_url($this->server['SCRIPT_NAME'], PHP_URL_PATH));
        if ($url_path == 'announce.php' || $url_path == 'scrape.php') {
            print("d14:failure reason40:Invalid .torrent, try downloading again.e\n");
            exit;
        }
    }

    public function handle_http_request() {
        $this->handle_trivial_cases();
        $section = basename(parse_url($this->server['SCRIPT_NAME'], PHP_URL_PATH), '.php');
        if (!preg_match('/^[a-z0-9]+$/i', $section)) {
            $this->handle_legacy_request(null);
        }

        switch ($section) {
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

            case 'signup':
                header('Location: register.php');
                exit;

            case 'whitelist':
                header('Location: articles.php?topic=clients');
                exit;

            default:
                if (file_exists($this->application_dir . '/sections/' . $section . '/index.php')) {
                    define('ERROR_EXCEPTION', true);
                    $this->handle_legacy_request($section);
                } else {
                    $this->handle_legacy_request(null);
                }
        }
    }

}
