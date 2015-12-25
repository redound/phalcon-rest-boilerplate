<?php

define('PHALCON_REST_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Register The Composer Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader
| for our application.
|
*/

require __DIR__ . '/../../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Phalcon Loader
|--------------------------------------------------------------------------
|
| This component helps to load your project classes automatically
| based on some conventions
|
*/

$loader = new \Phalcon\Loader();

$loader->registerDirs([
    __DIR__ . '/../views/'
]);

$loader->registerNamespaces([
    'App' => __DIR__ . '/../library/App'
]);

$loader->register();