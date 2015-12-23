<?php

try {

    // Define application environment
    define('APPLICATION_ENV', getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development');

    // Define application path
    define('APP_PATH', __DIR__ . '/../app/');

    // Load vendor libraries
    require_once APP_PATH . '../vendor/autoload.php';

    $defaultConfig = new \Phalcon\Config(require_once APP_PATH . 'configs/default.php');

    switch (APPLICATION_ENV) {

        case 'production':
            $serverConfig = new \Phalcon\Config(require_once APP_PATH . 'configs/server.production.php');
            break;
        case 'staging':
            $serverConfig = new \Phalcon\Config(require_once APP_PATH . 'configs/server.staging.php');
            break;
        case 'development':
        default:
            $serverConfig = new \Phalcon\Config(require_once APP_PATH . 'configs/server.develop.php');
            break;
    }

    $config = $defaultConfig->merge($serverConfig);

    // Load classes
    $loader = new \Phalcon\Loader();
    $loader
        ->registerDirs([
            APP_PATH . 'views/'
        ])
        ->registerNamespaces([
            'App' => APP_PATH . 'library/App'
        ])
        ->register();

    $di = new PhalconRest\Di\FactoryDefault();

    $di->setShared(\App\Constants\Services::CONFIG, function() use ($config) {
        return $config;
    });

    $api = new PhalconRest\Api($di);

    // Bootstrap application
    $bootstrap = new \App\Bootstrap(
        new \App\Bootstrap\ServiceBootstrap,
        new \App\Bootstrap\MiddlewareBootstrap,
        new \App\Bootstrap\CollectionBootstrap,
        new \App\Bootstrap\ResourceBootstrap,
        new \App\Bootstrap\AclBootstrap
    );

    $bootstrap->run($api, $di, $config);

    $api->handle();

    $returnedValue = $api->getReturnedValue();

    if ($returnedValue !== null) {

        if (is_string($returnedValue)) {
            $api->response->setContent($returnedValue);
        } else {
            $api->response->setJsonContent($returnedValue);
        }
    }

} catch (\Exception $e) {

    /** @var \PhalconRest\Http\Response $response */
    $response = $di->get(\App\Constants\Services::RESPONSE);
    $debugMode = (APPLICATION_ENV == 'development');

    $response->setErrorContent($e, $debugMode);
}

if ($api->response) {
    $api->response->sendHeaders();
    $api->response->send();
}