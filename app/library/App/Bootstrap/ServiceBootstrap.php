<?php

namespace App\Bootstrap;

use App\Constant\Service;
use Phalcon\Config;
use Phalcon\DiInterface;
use PhalconRest\Api;

class ServiceBootstrap extends \PhalconRest\Bootstrap
{
    public function run(Api $api, DiInterface $di, Config $config)
    {

        /**
         * @description Phalcon - \Phalcon\Db\Adapter\Pdo\Mysql
         */
        $di->set(Service::DB, function () use ($config, $di) {

            $connection = new \Phalcon\Db\Adapter\Pdo\Mysql(array(
                "host" => $config->database->host,
                "username" => $config->database->username,
                "password" => $config->database->password,
                "dbname" => $config->database->name,
            ));

            //Assign the eventsManager to the db adapter instance
            $connection->setEventsManager($di->get(Service::EVENTS_MANAGER));

            return $connection;
        });

        /**
         * @description Phalcon - \Phalcon\Mvc\Url
         */
        $di->set(Service::URL, function () use ($config) {

            $url = new \Phalcon\Mvc\Url();
            $url->setBaseUri($config->application->baseUri);
            return $url;
        });

        /**
         * @description Phalcon - \Phalcon\Mvc\View\Simple
         */
        $di->set(Service::VIEW, function () use ($config) {

            $view = new Phalcon\Mvc\View\Simple();
            $view->setViewsDir($config->application->viewsDir);

            return $view;
        });

        /**
         * @description Phalcon - \Phalcon\Mvc\Router
         */
        $di->set(Service::ROUTER, function () {

            return new \Phalcon\Mvc\Router;
        });

        /**
         * @description Phalcon - EventsManager
         */
        $di->setShared(Service::EVENTS_MANAGER, function () use ($di, $config) {

            return new \Phalcon\Events\Manager;
        });

        /**
         * @description Phalcon - TokenParser
         */
        $di->setShared(Service::TOKEN_PARSER, function () use ($di, $config) {

            return new \PhalconRest\Auth\TokenParser\JWT($config->authentication->secret, \PhalconRest\Auth\TokenParser\JWT::ALGORITHM_HS256);
        });

        /**
         * @description Phalcon - AuthManager
         */
        $di->setShared(Service::AUTH_MANAGER, function () use ($di, $config) {

            $authManager = new \PhalconRest\Auth\Manager($config->authentication->expirationTime);
            $authManager->registerAccountType(\App\Auth\UsernameAccountType::NAME, new \App\Auth\UsernameAccountType());

            return $authManager;
        });

        /**
         * @description Phalcon - \Phalcon\Mvc\Model\Manager
         */
        $di->setShared(Service::MODELS_MANAGER, function () use ($di) {

            $modelsManager = new \Phalcon\Mvc\Model\Manager;
            return $modelsManager->setEventsManager($di->get(Service::EVENTS_MANAGER));
        });

        /**
         * @description PhalconRest - \League\Fractal\Manager
         */
        $di->setShared(Service::FRACTAL_MANAGER, function () {

            $fractal = new \League\Fractal\Manager;
            $fractal->setSerializer(new \App\Fractal\CustomSerializer());

            return $fractal;
        });

        /**
         * @description App - \Library\App\Service\UserService
         */
        $di->setShared(Service::USER_SERVICE, function () {

            return new \App\Service\UserService;
        });
    }
}