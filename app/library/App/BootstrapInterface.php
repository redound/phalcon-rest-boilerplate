<?php

namespace App;

use Phalcon\Config;
use Phalcon\DiInterface;
use PhalconRest\Api;

interface BootstrapInterface {

    public function run(Api $api, DiInterface $di, Config $config);

}