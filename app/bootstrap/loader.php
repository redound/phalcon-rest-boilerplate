<?php

$appPath 	= __DIR__ . '/../../app/';
$vendorPath = __DIR__ . '/../../vendor/';

// Manual autoloader
require_once $vendorPath . 'google/apiclient/autoload.php';
require_once $vendorPath . 'phpmailer/phpmailer/class.smtp.php';
require_once $vendorPath . 'phpmailer/phpmailer/class.phpmailer.php';

$loader = new \Phalcon\Loader();

$loader->registerDirs([
	$appPath . 'collections/',
	$appPath . 'controllers/',
	$appPath . 'models/',
	$appPath . 'transformers/',
	$appPath . 'views/',
	$vendorPath . 'phpmailer/phpmailer',
	$vendorPath . 'firebase/php-jwt/Firebase/PHP-JWT/Authentication',
	$vendorPath . 'firebase/php-jwt/Firebase/PHP-JWT/Exceptions',
	$vendorPath . 'olivierandriessen/phalcon-rest/src'
]);

$loader->registerNamespaces([
	'Library' 			=> $appPath . 'library/',
	'League\Fractal' 	=> $vendorPath . 'league/fractal/src'
]);

$loader->register();
