<?php

use Library\App\Constants\Services as AppServices;
use Library\Phalcon\Constants\Services as PhalconServices;
use Library\PhalconRest\Constants\Services as PhalconRestServices;

try {

    // Setup up environment variable
    $application_env = defined('APPLICATION_ENV') ? APPLICATION_ENV : 'development';

    // Read the configuration based on env
    $config = require __DIR__ . "/../app/config/config.php";

    // Include loader
    require __DIR__ . "/../app/config/loader.php";

    // Setup all required services (DI)
    require __DIR__ . "/../app/config/services.php";

    $app = new \Phalcon\Mvc\Micro($di);

    $request        = $app->get(PhalconRestServices::REQUEST);
    $response       = $app->get(PhalconRestServices::RESPONSE);
    $fractal        = $app->get(FractalService::MANAGER);

    // Mount Collections
    $this->mount(new ProductCollection);
    $this->mount(new UserCollection);

    // OPTIONS have no body, send the headers, exit
    if($request->getMethod() == 'OPTIONS'){
        
        $response->send([
            'result' => 'OK'
        ]);
        exit;
    }

    // Handle not found
    $app->notFound(function() {

        throw new Exception(ErrorCodes::GEN_NOTFOUND);
    });

    $app->before(function() use ($fractal) {

        $include = $request->getQuery('include');

        if (!is_null($include)) {
            $fractal->parseIncludes($include);
        }
    });

    $app->after(function() {

        $response->send($this->getReturnedValue()); // Get return value from controller
    });

    $app->handle();

} catch (PhalconRest\Exceptions\UserException $e){

	$app->response->sendException($e);

} catch (PhalconRest\CoreException $e){

	$app->response->sendException($e);

} catch (Phalcon\Exception $e){

	$app->response->sendException($e);

} catch (PDOException $e){

	$app->response->sendException($e);

} catch (Exception $e){

	$app->response->sendException($e);

}

// TODO Simplify ^
