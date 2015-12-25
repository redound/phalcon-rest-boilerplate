<?php

/*
|--------------------------------------------------------------------------
| Create Dependency Container
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new \PhalconRest\Di\Factory
| instance. This version extends from \Phalcon\Di\FactoryDefault and
| has all of PhalconRest's components registered on it.
|
*/
$di = new PhalconRest\Di\FactoryDefault();

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| We then create a new PhalconRest\App instance. This is an
| extended version of the default \Phalcon\Mvc\Micro application.
|
*/
$app = new PhalconRest\Api($di);

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;