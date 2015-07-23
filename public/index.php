<?php

use Library\App\Constants\Services as AppServices;
use PhalconRest\Constants\Services as PhalconRestServices;

try {

    // Setup up environment variable
    $application_env = defined('APPLICATION_ENV') ? APPLICATION_ENV : 'development';

    // Read the configuration based on env
    $config = require __DIR__ . "/../app/bootstrap/config.php";

    // Include loader
    require __DIR__ . "/../app/bootstrap/loader.php";

    // Setup all required services (DI)
    require __DIR__ . "/../app/bootstrap/services.php";

    // Instantiate main application
    $app = new \Phalcon\Mvc\Micro($di);

    /**
     * We need to attach the EventsManager to the main application
     * in order to attach Middleware.
     */
    $eventsManager = $app->di->get(AppServices::EVENTS_MANAGER);
    $app->setEventsManager($eventsManager);

    // Attach Middleware to EventsManager
    require __DIR__ . "/../app/bootstrap/middleware.php";

    // Mount Collections
    require __DIR__ . "/../app/bootstrap/collections.php";

    // It's working message
    $app->get('/', function() use ($app) {

        $view = $app->di->get(AppServices::VIEW);
        echo $view->render('general/index');
        exit;
    });

    // Start application
    $app->handle();

} catch (Exception $e) {

    $di->get(PhalconRestServices::RESPONSE)->sendException($e);

}
