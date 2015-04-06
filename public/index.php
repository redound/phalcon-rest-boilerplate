<?php

use OA\PhalconRest\Mvc\Micro as PhalconRestApp;

error_reporting(E_ALL);
ini_set('display_errors', true);

try {

    // Read the configuration
    $config = require __DIR__ . "/../app/config/config.php";

    // Include loader
    require __DIR__ . "/../app/config/loader.php";

    // Instantiates PhalconRestDI and sets up services
    require __DIR__ . "/../app/config/services.php";

    $app = new PhalconRestApp($di);

    $app->handle();

} catch (OA\PhalconRest\UserException $e){

	$app->response->sendException($e);

} catch (OA\PhalconRest\CoreException $e){

	$app->response->sendException($e);

} catch (Phalcon\Exception $e){

	$app->response->sendException($e);

} catch (PDOException $e){

	$app->response->sendException($e);

} catch (Exception $e){

	$app->response->sendException($e);

}

// TODO Simplify ^
