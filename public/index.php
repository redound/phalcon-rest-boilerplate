<?php

/**
 * PhalconRest - a library focused on simplifying the creation of RESTful API's
 *
 * @package  redound/phalcon-rest
 * @author   Bart Blok <bart@wittig.nl>
 * @author   Olivier Andriessen <olivierandriessen@gmail.com>
 */

/** @var \Phalcon\Config $config */
$config = null;

/** @var \PhalconRest\Api $app */
$app = null;

/** @var \PhalconRest\Http\Response $response */
$response = null;

try {

    // Set environment
    define('APPLICATION_ENV_DEVELOPMENT', 'development');
    define('APPLICATION_ENV_PRODUCTION', 'production');

    define('APPLICATION_ENV', getenv('APPLICATION_ENV') ?: APPLICATION_ENV_DEVELOPMENT);

    // Autoload dependencies
    require __DIR__ . '/../vendor/autoload.php';

    $loader = new \Phalcon\Loader();

    $loader->registerDirs([
        __DIR__ . '/../app/views/'
    ]);

    $loader->registerNamespaces([
        'App' => __DIR__ . '/../app/library/App'
    ]);

    $loader->register();

    // Create config
    $defaultConfig = new \Phalcon\Config(require_once __DIR__ . '/../app/configs/default.php');

    switch (APPLICATION_ENV) {

        case APPLICATION_ENV_PRODUCTION:
            $serverConfigPath = __DIR__ . '/../app/configs/server.production.php';
            break;
        case APPLICATION_ENV_DEVELOPMENT:
        default:
            $serverConfigPath = __DIR__ . '/../app/configs/server.develop.php';
            break;
    }

    if (!file_exists($serverConfigPath)) {
        throw new \Exception('Config file ' . $serverConfigPath . ' doesn\'t exist.');
    }

    $serverConfig = new \Phalcon\Config(require_once $serverConfigPath);
    $config = $defaultConfig->merge($serverConfig);

    // Instantiate application & DI
    $di = new PhalconRest\Di\FactoryDefault();
    $app = new PhalconRest\Api($di);

    // Bootstrap components
    $bootstrap = new \App\Bootstrap(
        new \App\Bootstrap\ServiceBootstrap,
        new \App\Bootstrap\MiddlewareBootstrap,
        new \App\Bootstrap\ResourceBootstrap,
        new \App\Bootstrap\RouteBootstrap,
        new \App\Bootstrap\AclBootstrap
    );

    $bootstrap->run($app, $app->di, $config);

    // Start application
    $app->handle();

    // Set appropriate response value
    $response = $app->di->getShared(\App\Constants\Services::RESPONSE);

    $returnedValue = $app->getReturnedValue();

    if (is_string($returnedValue)) {
        $response->setContent($returnedValue);
    } else {
        $response->setJsonContent($returnedValue);
    }
} catch (\Exception $e) {

    // Handle exceptions
    $response = $app ? $app->di->getShared(\App\Constants\Services::RESPONSE) : new \PhalconRest\Http\Response();
    $debugMode = $config ? $config->debug : (APPLICATION_ENV == APPLICATION_ENV_DEVELOPMENT);

    $response->setErrorContent($e, $debugMode);
}
finally {

    // Send response
    $response->send();
}

