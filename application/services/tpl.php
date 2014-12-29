<?php
namespace gazelle\services;

use gazelle\core\Master;

class TPL extends Service {
    # Basically a wrapper around the Twig templating engine

    public function __construct(Master $master) {
        parent::__construct($master);
        require_once($master->library_path . '/Twig/Autoloader.php');
        \Twig_Autoloader::register();
        $loader = new \Twig_Loader_Filesystem($master->application_path . '/templates');
        $this->twig = new \Twig_Environment($loader);
    }

    public function render($template, $values = array()) {
        print($this->twig->render($template, $values));
    }
}
