<?php
namespace gazelle\services;

use gazelle\core\Master;

abstract class Service {

    protected $master;

    public function __construct(Master $master) {
        $this->master = $master;
    }

}
