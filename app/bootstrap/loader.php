<?php

$appPath = __DIR__ . '/../';
$vendorPath = __DIR__ . '/../../vendor/';

// Require Composer autoload
require_once $vendorPath . 'autoload.php';

$loader = new \Phalcon\Loader();

$loader->registerDirs([
    $appPath . 'collections/',
    $appPath . 'controllers/',
    $appPath . 'models/',
    $appPath . 'transformers/',
    $appPath . 'views/'
]);

$loader->registerNamespaces([
    'App' => $appPath . 'library/App'
]);

$loader->register();
