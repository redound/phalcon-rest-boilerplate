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

try {

    define('APPLICATION_ENV', getenv('APPLICATION_ENV') ?: 'development');

    require __DIR__ . '/../vendor/autoload.php';

    $loader = new Phalcon\Loader();

    $loader->registerDirs([
        __DIR__ . '/../app/views/'
    ]);

    $loader->registerNamespaces([
        'App' => __DIR__ . '/../app/library/App'
    ]);

    $loader->register();

    $configsPath = __DIR__ . '/../app/configs/';
    $configPath = $configsPath . 'default.php';

    if (!is_readable($configPath)) {
        throw new Exception('Unable to read config from ' . $configPath);
    }

    $config = new Phalcon\Config(include_once $configPath);

    $overridePath = __DIR__ . '/../app/configs/server.' . APPLICATION_ENV . '.php';

    if (!is_readable($overridePath)) {
        throw new Exception('Unable to read config from ' . $overridePath);
    }

    $override = new Phalcon\Config(include_once $overridePath);

    $config = $config->merge($override);

    $di = new PhalconRest\Di\FactoryDefault();
    $app = new PhalconRest\Api($di);

    $bootstrap = new App\Bootstrap(
        new App\Bootstrap\ServiceBootstrap,
        new App\Bootstrap\MiddlewareBootstrap,
        new App\Bootstrap\CollectionBootstrap,
        new App\Bootstrap\RouteBootstrap,
        new App\Bootstrap\AclBootstrap
    );

    $bootstrap->run($app, $app->di, $config);

    $app->handle();

    $response = $app->di->getShared(App\Constants\Services::RESPONSE);

    $returnedValue = $app->getReturnedValue();

    if (is_string($returnedValue)) {
        $response->setContent($returnedValue);
    } else {
        $response->setJsonContent($returnedValue);
    }

} catch (\Exception $e) {

    $di = new PhalconRest\Di\FactoryDefault();
    $app = new \PhalconRest\Api($di);

    $response = $app->di->getShared(App\Constants\Services::RESPONSE);

    $debugMode = $config && $config->offsetExists('debug') ? $config->debug : (APPLICATION_ENV == 'development');

    $response->setErrorContent($e, $debugMode);

} finally {

    $response = $app->di->getShared(App\Constants\Services::RESPONSE);

    if (!$response->isSent()) {
        $response->send();
    }
}

