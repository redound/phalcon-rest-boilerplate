<?php

namespace App\Bootstrap;

use App\Constant\Resource as ResourceConst;
use App\Controller\ProductController;
use App\Controller\UserController;
use Phalcon\Config;
use Phalcon\DiInterface;
use PhalconRest\Api;
use PhalconRest\Api\Resource;

class ResourceBootstrap extends \PhalconRest\Bootstrap
{
    public function run(Api $api, DiInterface $di, Config $config)
    {

        $api->resource(ResourceConst::USER, Resource::crud()
            ->prefix('/users')
            ->singleKey('user')
            ->multipleKey('users')
            ->model('\App\Model\User')
        );

        $api->resource(ResourceConst::ITEM, Resource::crud()
            ->prefix('/items')
            ->singleKey('item')
            ->multipleKey('items')
            ->model('\App\Model\Item')
        );

        $api->resource(ResourceConst::PRODUCT, Resource::crud()
            ->prefix('/products')
            ->singleKey('product')
            ->multipleKey('products')
            ->model('\App\Model\Product')
            ->controller(ProductController::class)
        );
    }
}