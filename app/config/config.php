<?php

switch ($application_env) {

	case 'production':
		$serverConfig = require_once __DIR__ . "/config.server.production.php";
		break;
	case 'development':
	default:
		$serverConfig = require_once __DIR__ . "/config.server.develop.php";
		break;
}

$defaultConfig 	= require_once __DIR__ . "/config.default.php";
$config 		= array_merge($defaultConfig, $serverConfig);

return new \Phalcon\Config($config);
