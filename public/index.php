<?php

/** @var \Phalcon\Config $config */
$config = null;

/** @var \PhalconRest\Api $app */
$app = null;

/** @var \PhalconRest\Http\Response $response */
$response = null;

try {

    define("ROOT_DIR", __DIR__ . '/..');
    define("APP_DIR", ROOT_DIR . '/app');
    define("VENDOR_DIR", ROOT_DIR . '/vendor');
    define("CONFIG_DIR", APP_DIR . '/configs');

    define('APPLICATION_ENV', getenv('APPLICATION_ENV') ?: 'development');

    // Autoload dependencies
    require VENDOR_DIR . '/autoload.php';

    $loader = new \Phalcon\Loader();

    $loader->registerNamespaces([
        'App' => APP_DIR . '/library/App'
    ]);

    $loader->registerDirs([
        APP_DIR . '/views/'
    ]);

    $loader->register();

    // Config
    $configPath = CONFIG_DIR . '/default.php';

    if (!is_readable($configPath)) {
        throw new Exception('Unable to read config from ' . $configPath);
    }

    $config = new Phalcon\Config(include_once $configPath);

    $envConfigPath = CONFIG_DIR . '/server.' . APPLICATION_ENV . '.php';

    if (!is_readable($envConfigPath)) {
        throw new Exception('Unable to read config from ' . $envConfigPath);
    }

    $override = new Phalcon\Config(include_once $envConfigPath);

    $config = $config->merge($override);


    // Instantiate application & DI
    $di = new PhalconRest\Di\FactoryDefault();
    $app = new PhalconRest\Api($di);

    // Bootstrap components
    $bootstrap = new App\Bootstrap(
        new App\Bootstrap\ServiceBootstrap,
        new App\Bootstrap\MiddlewareBootstrap,
        new App\Bootstrap\CollectionBootstrap,
        new App\Bootstrap\RouteBootstrap,
        new App\Bootstrap\AclBootstrap
    );

    $bootstrap->run($app, $di, $config);

    // Start application
    $app->handle();

    // Set appropriate response value
    $response = $app->di->getShared(App\Constants\Services::RESPONSE);

    $returnedValue = $app->getReturnedValue();

    if($returnedValue !== null) {

        if (is_string($returnedValue)) {
            $response->setContent($returnedValue);
        } else {
            $response->setJsonContent($returnedValue);
        }
    }

} catch (\Exception $e) {

    // Handle exceptions
    $di = $app && $app->di ? $app->di : new PhalconRest\Di\FactoryDefault();
    $response = $di->getShared(App\Constants\Services::RESPONSE);
    if(!$response || !$response instanceof PhalconRest\Http\Response){
        $response = new PhalconRest\Http\Response();
    }

    $debugMode = isset($config->debug) ? $config->debug : (APPLICATION_ENV == 'development');

    $response->setErrorContent($e, $debugMode);
}
finally {

    // Send response
    if (!$response->isSent()) {
        $response->send();
    }
}
