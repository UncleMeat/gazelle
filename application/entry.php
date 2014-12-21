<?php
namespace gazelle;

$start_time = microtime(true);

function gazelle_autoloader($class_name) {
    $path = explode('\\', $class_name);
    if ($path[0] == 'gazelle') {
        $gazelle_path = array_slice($path, 1);
        spl_autoload(strtolower(implode('/', $gazelle_path)));
    }
}

spl_autoload_register('gazelle\\gazelle_autoloader');

date_default_timezone_set('UTC');

define('SERVER_ROOT', __DIR__);

# Inject superglobals right at the start so we can avoid globals in the rest of the code
$superglobals = [
    'server' => $_SERVER,
    'get' => $_GET,
    'post' => $_POST,
    'files' => $_FILES,
    'cookie' => $_COOKIE,
    'request' => $_REQUEST,
    'env' => $_ENV
];

$master = new \gazelle\core\Master(__DIR__, $superglobals, $start_time);
$master->handle_request();
