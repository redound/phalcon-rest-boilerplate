<?php

namespace App\Bootstrap;

use Phalcon\Config;
use Phalcon\DiInterface;
use PhalconRest\Api;
use PhalconRest\Middleware\AuthenticationMiddleware;
use PhalconRest\Middleware\AuthorizationMiddleware;
use PhalconRest\Middleware\CorsMiddleware;
use PhalconRest\Middleware\FractalMiddleware;
use PhalconRest\Middleware\NotFoundMiddleware;
use PhalconRest\Middleware\OptionsResponseMiddleware;
use PhalconRest\Middleware\UrlQueryMiddleware;

class MiddlewareBootstrap extends \App\Bootstrap
{
    public function run(Api $api, DiInterface $di, Config $config)
    {
        $api
            ->attach(new NotFoundMiddleware)
            ->attach(new AuthenticationMiddleware)
            ->attach(new AuthorizationMiddleware)
            ->attach(new FractalMiddleware)
            ->attach(new CorsMiddleware($config->cors->allowedOrigins->toArray()))
            ->attach(new OptionsResponseMiddleware)
            ->attach(new UrlQueryMiddleware);
    }
}