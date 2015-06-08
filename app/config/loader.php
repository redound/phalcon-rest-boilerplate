<?php

$appPath 	= __DIR__ . '/../../app/';
$vendorPath = __DIR__ . '/../../../../../../vendor/';

// Manual autoloader
require_once $vendorPath . 'google/apiclient/autoload.php';
require_once $vendorPath . 'phpmailer/phpmailer/class.smtp.php';
require_once $vendorPath . 'phpmailer/phpmailer/class.phpmailer.php';

$loader = new \Phalcon\Loader();

$loader->registerDirs([
	$appPath . 'library/',
	$appPath . 'controllers/',
	$appPath . 'models/',
	$appPath . 'collections/',
	$appPath . 'transformers/',
	$appPath . 'views/',
	$vendorPath . 'phpmailer/phpmailer',
	$vendorPath . 'firebase/php-jwt/Firebase/PHP-JWT/Authentication',
	$vendorPath . 'firebase/php-jwt/Firebase/PHP-JWT/Exceptions'
]);

$loader->registerNamespaces([
	'PhalconRest' 		=> __DIR__ . '/../../vendor/olivierandriessen/phalcon-rest',
	'League\Fractal' 	=> $vendorPath . 'league/fractal/src'
]);

$loader->register();
