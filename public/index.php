<?php

/**
 * PhalconRest - a library focused on simplifying the creation of RESTful API's
 *
 * @package  redound/phalcon-rest
 * @author   Bart Blok <bart@wittig.nl>
 * @author   Olivier Andriessen <olivierandriessen@gmail.com>
 */

try {

    // Autoload dependencies
    require_once __DIR__ . '/../app/bootstrap/autoload.php';

    // Set environment
    require_once __DIR__ . '/../app/bootstrap/environment.php';

    // Create config
    $config = require_once __DIR__ . '/../app/bootstrap/config.php';

    // Instantiate application
    $app = require_once __DIR__ . '/../app/bootstrap/app.php';

    // Bootstrap components
    $bootstrap = new \App\Bootstrap(
        new \App\Bootstrap\ServiceBootstrap,
        new \App\Bootstrap\MiddlewareBootstrap,
        new \App\Bootstrap\ResourceBootstrap,
        new \App\Bootstrap\CollectionBootstrap,
        new \App\Bootstrap\RouteBootstrap,
        new \App\Bootstrap\AclBootstrap
    );

    $bootstrap->run($app, $app->di, $config);

    // Start application
    $app->handle();

    // Set appropriate response value
    /** @var \PhalconRest\Http\Response $response */
    $response = $app->di->getShared(\App\Constants\Services::RESPONSE);

    $returnedValue = $app->getReturnedValue();

    if (is_string($returnedValue)) {
        $response->setContent($returnedValue);
    } else {
        $response->setJsonContent($returnedValue);
    }

} catch(\Exception $e) {

    // Handle exceptions
    /** @var \PhalconRest\Http\Response $response */
    $response = $app->di->getShared(\App\Constants\Services::RESPONSE);
    $debugMode = isset($config) ? $config->debug : (APPLICATION_ENV == APPLICATION_ENV_DEVELOPMENT);
    $response->setErrorContent($e, $debugMode);

} finally {

    // Send response
    $response = $app->di->getShared(\PhalconRest\Constants\Services::RESPONSE);
    $response->send();
}

