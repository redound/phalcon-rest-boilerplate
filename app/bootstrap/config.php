<?php

/*
|--------------------------------------------------------------------------
| Load config files
|--------------------------------------------------------------------------
|
| Here we load the default configuration file.
| Based on the application's environment we merge
| additional configuration onto the default configuration.
|
*/

try {

    $defaultConfig = new \Phalcon\Config(require_once  __DIR__ . '/../configs/default.php');

    switch (APPLICATION_ENV) {

        case APPLICATION_ENV_PRODUCTION:
            $serverConfigPath = __DIR__ . '/../configs/server.production.php';
            break;
        case APPLICATION_ENV_DEVELOPMENT:
        default:
            $serverConfigPath = __DIR__ . '/../configs/server.develop.php';
            break;
    }

    if (!file_exists($serverConfigPath)) {
        throw new \Exception('Config file ' . $serverConfigPath . ' doesn\'t exist.');
    }

    $serverConfig = new \Phalcon\Config(require_once $serverConfigPath);

    return $defaultConfig->merge($serverConfig);

} catch (\Exception $e) {

    echo $e->getMessage();
}