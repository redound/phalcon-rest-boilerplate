<?php

$loader = new Phalcon\Loader;

$loader->registerNamespaces([
    'App' => __DIR__ . '/../../app/library/App'
]);

$loader->register();

require_once TESTS_PATH . '../vendor/autoload.php';

$di = new \PhalconRest\Di\FactoryDefault();

/**
 * Config
 */
$di->setShared(
    'config',
    function () {
        $configFile  = require(TESTS_PATH . '_config/global.php');
        return new Config($configFile);
    }
);

return new \PhalconRest\Api($di);