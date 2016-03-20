<?php

namespace App\Bootstrap;

use App\BootstrapInterface;
use App\Constants\Services;
use Phalcon\Acl;
use Phalcon\Config;
use Phalcon\DiInterface;
use PhalconRest\Api;

class RouteBootstrap implements BootstrapInterface
{
    public function run(Api $api, DiInterface $di, Config $config)
    {
        $api->get('/', function() use ($api) {

            /** @var \Phalcon\Mvc\View\Simple $view */
            $view = $api->di->get(Services::VIEW);

            return $view->render('general/index');
        });

        $api->get('/proxy.html', function() use ($api, $config) {

            /** @var \Phalcon\Mvc\View\Simple $view */
            $view = $api->di->get(Services::VIEW);

            $view->setVar('client', $config->clientHostName);
            return $view->render('general/proxy');
        });

        $api->get('/documentation.html', function() use ($api, $config) {

            /** @var \Phalcon\Mvc\View\Simple $view */
            $view = $api->di->get(Services::VIEW);

            $view->setVar('title', $config->application->title);
            $view->setVar('description', $config->application->description);
            $view->setVar('documentationPath', $config->hostName . '/export/documentation.json');
            return $view->render('general/documentation');
        });
    }
}