<?php
namespace gazelle\core;

use gazelle\errors\CLIError;
use gazelle\services\Profiler;
use gazelle\services\Settings;
use gazelle\services\Cache;
use gazelle\services\ClientIdentifier;
use gazelle\services\OldDB;

class Master {

    public $superglobals;
    public $legacy_handler;
    public $cache;

    public function __construct($application_dir, array $superglobals, $start_time = null) {
        $this->profiler = new Profiler($start_time);
        $this->application_dir = $application_dir;
        $this->superglobals = $superglobals;
        $this->server = $this->superglobals['server'];
        $this->settings = new Settings($this, $this->application_dir . '/settings.ini');
        if (!$this->settings->modes->profiler) {
            $this->profiler->disable();
        }
        $this->cache = new Cache($this->settings->memcached->host, $this->settings->memcached->port);
        $this->clientidentifier = new ClientIdentifier();
        $this->olddb = new OldDB($this);
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
        $section = basename(parse_url($this->server['SCRIPT_NAME'], PHP_URL_PATH), '.php');
        if (!preg_match('/^[a-z0-9]+$/i', $section)) {
            $this->handle_legacy_request(null);
        }

        switch ($section) {
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
