<?php
namespace gazelle;

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

$master = new \gazelle\core\Master($superglobals);
$master->handle_request();

if ($master->legacy_handler_needed) {
    require_once(SERVER_ROOT .'/common/main_includes.php');
    $legacy_handler = new \gazelle\core\LegacyHandler($master);
    # We have to do this here since the section includes won't work inside a class/function context
    if ($master->active_section) {
        $legacy_handler->script_start();
        require(SERVER_ROOT . '/sections/' . $master->active_section . '/index.php');
        $legacy_handler->script_finish();
    } else {
        error(404);
    }
}
