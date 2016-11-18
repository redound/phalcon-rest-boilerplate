<?php

namespace App\Bootstrap;

use App\BootstrapInterface;
use Phalcon\Config;
use Phalcon\DiInterface;
use PhalconRest\Api;
use PhalconApi\Middleware\AuthenticationMiddleware;
use PhalconRest\Middleware\AuthorizationMiddleware;
use PhalconApi\Middleware\CorsMiddleware;
use PhalconRest\Middleware\FractalMiddleware;
use PhalconApi\Middleware\NotFoundMiddleware;
use PhalconApi\Middleware\OptionsResponseMiddleware;
use PhalconApi\Middleware\UrlQueryMiddleware;

class MiddlewareBootstrap implements BootstrapInterface
{
    public function run(Api $api, DiInterface $di, Config $config)
    {
        $api
            ->attach(new CorsMiddleware($config->cors->allowedOrigins->toArray()))
            ->attach(new OptionsResponseMiddleware)
            ->attach(new NotFoundMiddleware)
            ->attach(new AuthenticationMiddleware)
            ->attach(new AuthorizationMiddleware)
            ->attach(new FractalMiddleware)
            ->attach(new UrlQueryMiddleware);
    }
}