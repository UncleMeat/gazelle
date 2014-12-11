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

$site_root = dirname(__DIR__);
set_include_path(get_include_path() . PATH_SEPARATOR . $site_root);

$document = basename(parse_url($_SERVER['SCRIPT_NAME'], PHP_URL_PATH), '.php');
$target_file = "{$site_root}/{$document}.php";

if (preg_match('/^[a-z0-9]+$/i', $document) && file_exists($target_file)) {
    require($target_file);
} else {
    require($site_root . '/index.php');
}
