<?php

switch ($application_env) {

    case 'production':
        $serverConfig = require_once __DIR__ . "/../configs/server.production.php";
        break;
    case 'development':
    default:
        $serverConfig = require_once __DIR__ . "/../configs/server.develop.php";
        break;
}

$defaultConfig = require_once __DIR__ . "/../configs/default.php";
$config = array_merge($defaultConfig, $serverConfig);

return new \Phalcon\Config($config);
