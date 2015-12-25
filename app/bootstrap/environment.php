<?php

/*
|--------------------------------------------------------------------------
| Defining the environment
|--------------------------------------------------------------------------
|
| Here we define the applications environment.
| This constant can be used to invoke specific application
| behaviour based on which environment the application is running.
|
*/

define('APPLICATION_ENV_DEVELOPMENT', 'development');
define('APPLICATION_ENV_PRODUCTION', 'production');

define('APPLICATION_ENV', getenv('APPLICATION_ENV') ?: APPLICATION_ENV_DEVELOPMENT);