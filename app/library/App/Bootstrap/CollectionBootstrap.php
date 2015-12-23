<?php

namespace App\Bootstrap;

use Phalcon\Config;
use Phalcon\DiInterface;
use PhalconRest\Api;

class CollectionBootstrap extends \App\Bootstrap
{
    public function run(Api $api, DiInterface $di, Config $config)
    {
        $api
            ->mount(new \App\Collections\ExportCollection);
    }
}