<?php
namespace gazelle\core;

use gazelle\errors\CLIError;
use gazelle\errors\InternalError;
use gazelle\services\Profiler;
use gazelle\services\Settings;
use gazelle\services\Cache;
use gazelle\services\ClientIdentifier;
use gazelle\services\OldDB;
use gazelle\services\TPL;
use gazelle\services\Auth;

class Master {

    public $profiler;
    public $application_path;
    public $superglobals;
    public $legacy_handler;
    public $ssl;
    public $mobile;

    public function __construct($application_path, array $superglobals, $start_time = null) {
        $this->profiler = new Profiler($start_time);
        $this->application_path = $application_path;
        $this->base_path = dirname($this->application_path);
        $this->library_path = $this->base_path . '/library';

        $this->superglobals = $superglobals;
        $this->server = $this->superglobals['server'];
        $this->cookie = $this->superglobals['cookie'];
        $this->request = $this->superglobals['request'];

        $this->settings = new Settings($this, $this->application_path . '/settings.ini');
        if (!$this->settings->modes->profiler) {
            $this->profiler->disable();
        }
        $this->ssl = (isset($this->server['SERVER_PORT']) && $this->server['SERVER_PORT'] == 443);
        $this->mobile = ($this->server['HTTP_HOST'] == 'm.' . $this->settings->main->nonssl_site_url);
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
            case 'tpl':
                $this->tpl = new TPL($this);
                return $this->tpl;
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
        $http_host = $this->server['HTTP_HOST'];
        $request_uri = $this->server['REQUEST_URI'];
        $nonssl_url = $this->settings->site->nonssl_site_url;
        $ssl_url = $this->settings->site->ssl_site_url;

        if (!$this->ssl && $http_host == "www.{$nonssl_url}") {
            $this->redirect("http://{$nonssl_url}{$request_uri}");
        }
        if ($this->ssl && $http_host == "www.{$nonssl_url}") {
            $this->redirect("https://{$ssl_url}{$request_uri}");
        }
        if ($ssl_url != $nonssl_url && (
            (!$this->ssl && $http_host == $ssl_url) ||
            ($this->ssl && $http_host == $nonssl_url)
        )) {
            $this->redirect("https://{$ssl_url}{$request_uri}");
        }
        if ($http_host == "www.m.{$nonssl_url}") {
            $this->redirect("http://m.{$nonssl_url}{$request_uri}");
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
                $this->redirect('/torrents.php');
                break;

            case 'collage':
                $this->redirect('/collages.php', $this->request);
                break;

            case 'details':
                $this->redirect('/torrents.php', $this->request);
                break;

            case 'signup':
                $this->redirect('/register.php');
                break;

            case 'whitelist':
                $this->redirect('/articles.php?topic=clients');
                break;
                exit;

            default:
                if (file_exists($this->application_path . '/sections/' . $section . '/index.php')) {
                    define('ERROR_EXCEPTION', true);
                    $this->handle_legacy_request($section);
                } else {
                    $this->handle_legacy_request(null);
                }
        }
    }

    public function redirect($target, $parameters = null, $status = 301) {
        if (is_array($parameters)) {
            $query_string = '?' . http_build_query($parameters);
        } elseif (strlen($parameters)) {
            $query_string = '?' . strval($parameters);
        } else {
            $query_string = '';
        }
        header('Location: ' . $target . $query_string, true, $status);
        exit();
    }

}
