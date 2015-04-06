<?php

use Phalcon\Logger,
    Phalcon\Db\Adapter\Pdo\Mysql as Connection;

// Important: Use PhalconRestDI
$di = new \OA\PhalconRest\DI\PhalconRestDI($config);

$di->set('db', function() use ($config, $di) {

    $connection = new \Phalcon\Db\Adapter\Pdo\Mysql(array(
        "host" => $config->database->host,
        "username" => $config->database->username,
        "password" => $config->database->password,
        "dbname" => $config->database->name
    ));

    //Assign the eventsManager to the db adapter instance
    $connection->setEventsManager($di->get('eventsManager'));

    return $connection;
});

$di->set('url', function() use ($config) {
	$url = new \Phalcon\Mvc\Url();
	$url->setBaseUri($config->application->baseUri);
	return $url;
});

$di->set('view', function() use ($config) {

	$view = new Phalcon\Mvc\View\Simple();
	$view->setViewsDir($config->application->viewsDir);

	return $view;
});
