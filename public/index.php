<?php

use Library\App\Constants\Services as AppServices;
use PhalconRest\Constants\Services as PhalconRestServices;
use PhalconRest\Constants\ErrorCodes;
use PhalconRest\Documentation;

use PhalconRest\Exceptions\UserException;

try {

    // Setup up environment variable
    $application_env = defined('APPLICATION_ENV') ? APPLICATION_ENV : 'development';

    // Read the configuration based on env
    $config = require __DIR__ . "/../app/bootstrap/config.php";

    // Include loader
    require __DIR__ . "/../app/bootstrap/loader.php";

    // Setup all required services (DI)
    require __DIR__ . "/../app/bootstrap/services.php";

    $app = new \Phalcon\Mvc\Micro($di);

    $app->setEventsManager($app->di->get(AppServices::EVENTS_MANAGER));

    $request        = $app->di->get(PhalconRestServices::REQUEST);
    $response       = $app->di->get(PhalconRestServices::RESPONSE);

    // Mount Collections
    $app->mount(new ExportCollection);
    $app->mount(new ProductCollection);
    $app->mount(new UserCollection);

    // OPTIONS have no body, send the headers, exit
    if($request->getMethod() == 'OPTIONS'){
        
        $response->send([
            'result' => 'OK'
        ]);
        exit;
    }

    // Needed for IE
    $app->get('/proxy.html', function() use ($app, $config) {

        echo $app->di->get(AppServices::VIEW)->render('general/proxy', ['client' => $config->clientHostName]);
        exit;
    });

    // Handle not found
    $app->notFound(function() {

        throw new UserException(ErrorCodes::GEN_NOTFOUND);
    });

    $app->before(function() use ($app, $request) {

        $fractal = $app->di->get(PhalconRestServices::FRACTAL_MANAGER);
        $include = $request->getQuery('include');

        if (!is_null($include)) {
            $fractal->parseIncludes($include);
        }
    });

    $app->after(function() use ($app, $response) {

        $response->send($app->getReturnedValue()); // Get return value from controller
    });

    $app->handle();

} catch (PhalconRest\Exceptions\UserException $e){

	$app->di->get(PhalconRestServices::RESPONSE)->sendException($e);

} catch (PhalconRest\CoreException $e){

	$app->di->get(PhalconRestServices::RESPONSE)->sendException($e);

} catch (Phalcon\Exception $e){

	$app->di->get(PhalconRestServices::RESPONSE)->sendException($e);

} catch (PDOException $e){

	$app->di->get(PhalconRestServices::RESPONSE)->sendException($e);

}

// TODO Simplify ^
