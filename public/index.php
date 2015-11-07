<?php

use App\Constants\Services as AppServices;

// Setup up environment variable
$application_env = getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development';

/** @var \PhalconRest\Http\Response $response */
$response = null;

try {

    // Read the configuration based on env
    $config = require __DIR__ . "/../app/bootstrap/config.php";

    // Include loader
    require __DIR__ . "/../app/bootstrap/loader.php";

    // Setup all required services (DI)
    $di = require __DIR__ . "/../app/bootstrap/services.php";


    // Instantiate main application
    $app = new \Phalcon\Mvc\Micro($di);

    // Attach the EventsManager to the main application in order to attach Middleware
    $eventsManager = $app->di->get(AppServices::EVENTS_MANAGER);
    $app->setEventsManager($eventsManager);


    // Attach Middleware to EventsManager
    require __DIR__ . "/../app/bootstrap/middleware.php";


    // Mount Collections
    require __DIR__ . "/../app/bootstrap/collections.php";


    // Other routes
    $app->get('/', function() use ($app) {

        /** @var Phalcon\Mvc\View\Simple $view */
        $view = $app->di->get(AppServices::VIEW);

        return $view->render('general/index');
    });

    $app->get('/proxy.html', function() use ($app, $config) {

        /** @var Phalcon\Mvc\View\Simple $view */
        $view = $app->di->get(AppServices::VIEW);

        $view->setVar('client', $config->clientHostName);
        return $view->render('general/proxy');
    });


    // Start application
    $app->handle();

    // Set content
    $returnedValue = $app->getReturnedValue();

    if($returnedValue !== null){

        if(is_string($returnedValue)){

            $app->response->setContent($returnedValue);
        }
        else {

            $app->response->setJsonContent($returnedValue);
        }
    }

    $response = $app->response;

} catch (Exception $e) {

    $response = $di->get(AppServices::RESPONSE);
    $response->setErrorContent($e, $application_env == 'development');
}

// Send response
if($response){

    $response->sendHeaders();
    $response->send();
}