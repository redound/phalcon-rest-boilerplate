<?php

use App\Constants\Services as AppServices;

$di = new \PhalconRest\DI\FactoryDefault();

/**
 * @description Phalcon - \Phalcon\Config
 */
$di->setShared(AppServices::CONFIG, function () use ($config) {

    return $config;
});

/**
 * @description Phalcon - \Phalcon\Db\Adapter\Pdo\Mysql
 */
$di->set(AppServices::DB, function () use ($config, $di) {

    $connection = new \Phalcon\Db\Adapter\Pdo\Mysql(array(
        "host" => $config->database->host,
        "username" => $config->database->username,
        "password" => $config->database->password,
        "dbname" => $config->database->name,
    ));

    //Assign the eventsManager to the db adapter instance
    $connection->setEventsManager($di->get(AppServices::EVENTS_MANAGER));

    return $connection;
});

/**
 * @description Phalcon - \Phalcon\Mvc\Url
 */
$di->set(AppServices::URL, function () use ($config) {

    $url = new \Phalcon\Mvc\Url();
    $url->setBaseUri($config->application->baseUri);
    return $url;
});

/**
 * @description Phalcon - \Phalcon\Mvc\View\Simple
 */
$di->set(AppServices::VIEW, function () use ($config) {

    $view = new Phalcon\Mvc\View\Simple();
    $view->setViewsDir($config->application->viewsDir);

    return $view;
});

/**
 * @description Phalcon - \Phalcon\Mvc\Router
 */
$di->set(AppServices::ROUTER, function () {

    return new \Phalcon\Mvc\Router;
});

/**
 * @description Phalcon - EventsManager
 */
$di->setShared(AppServices::EVENTS_MANAGER, function () use ($di, $config) {

    return new \Phalcon\Events\Manager;
});

/**
 * @description Phalcon - TokenParser
 */
$di->setShared(AppServices::TOKEN_PARSER, function () use ($di, $config) {

    return new \PhalconRest\Auth\TokenParser\JWT($config->authentication->secret, \PhalconRest\Auth\TokenParser\JWT::ALGORITHM_HS256);
});

/**
 * @description Phalcon - AuthManager
 */
$di->setShared(AppServices::AUTH_MANAGER, function () use ($di, $config) {

    $authManager = new \PhalconRest\Auth\Manager($config->authentication->expirationTime);
    $authManager->registerAccountType(App\Auth\UsernameAccountType::NAME, new \App\Auth\UsernameAccountType());

    return $authManager;
});


/**
 * @description Phalcon - \Phalcon\Mvc\Model\Manager
 */
$di->setShared(AppServices::MODELS_MANAGER, function () use ($di) {

    $modelsManager = new \Phalcon\Mvc\Model\Manager;
    return $modelsManager->setEventsManager($di->get(AppServices::EVENTS_MANAGER));
});

/**
 * @description PhalconRest - \League\Fractal\Manager
 */
$di->setShared(AppServices::FRACTAL_MANAGER, function () {

    $fractal = new \League\Fractal\Manager;
    $fractal->setSerializer(new \App\Fractal\CustomSerializer());

    return $fractal;
});

/**
 * @description PhalconRest - \PhalconRest\Api\Service
 */
$di->setShared(AppServices::API_SERVICE, function () {

    $apiService = new \PhalconRest\Api\Service;

    $itemResource = new \PhalconRest\Api\Resource();
    $itemResource
        ->setKey('items')
        ->setModel('\Item')
        ->setTransformer('\ItemTransformer');

    $apiService->addResource($itemResource);

    return $apiService;
});

/**
 * @description PhalconRest - \PhalconRest\Data\Query\Query
 */
$di->setShared(AppServices::QUERY, function () {

    return new \PhalconRest\Data\Query\Query;
});

/**
 * @description PhalconRest - \PhalconRest\Data\Query\Parser\Phql
 */
$di->setShared(AppServices::PHQL_QUERY_PARSER, function () {

    return new \PhalconRest\Data\Query\Parser\Phql;
});

/**
 * @description PhalconRest - \PhalconRest\Data\Query\Parser\Url
 */
$di->setShared(AppServices::URL_QUERY_PARSER, function () {

    return new \PhalconRest\Data\Query\Parser\Url;
});

/**
 * @description App - \Library\App\Services\UserService
 */
$di->setShared(AppServices::USER_SERVICE, function () {

    return new \App\Services\UserService;
});

return $di;