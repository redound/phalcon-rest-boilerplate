<?php

namespace App\Bootstrap;

use App\Constants\Resources;
use Phalcon\Config;
use Phalcon\DiInterface;
use PhalconRest\Api;
use PhalconRest\Api\Resource;
use PhalconRest\Constants\HttpMethods;

class ResourceBootstrap extends \App\Bootstrap
{
    public function run(Api $api, DiInterface $di, Config $config)
    {
        $api
            ->resource(Resource::crud(Resources::USER)
                ->prefix('/users')
                ->singleKey('user')
                ->multipleKey('users')
                ->model('App\Model\User')
                ->endpoint(Api\Endpoint::factory()
                    ->httpMethod(HttpMethods::GET)
                    ->handlerMethod('me')
                )
                ->endpoint(Api\Endpoint::factory()
                    ->httpMethod(HttpMethods::POST)
                    ->handlerMethod('authenticate')
                )
            )
            ->resource(Resource::crud(Resources::ITEM)
                ->prefix('/items')
                ->singleKey('item')
                ->multipleKey('items')
                ->model('App\Model\Item')
            )
            ->resource(Resource::crud(Resources::PRODUCT)
                ->prefix('/products')
                ->singleKey('product')
                ->multipleKey('products')
                ->model('App\Model\Product')
            );
    }
}