<?php

namespace App\Bootstrap;

use App\Constants\Resources;
use App\Model\Item;
use App\Model\Product;
use App\Model\User;
use Phalcon\Acl;
use Phalcon\Config;
use Phalcon\DiInterface;
use PhalconRest\Api;
use PhalconRest\Api\Resource;
use PhalconRest\Constants\AclRoles;
use PhalconRest\Constants\HttpMethods;

class ResourceBootstrap extends \App\Bootstrap
{
    public function run(Api $api, DiInterface $di, Config $config)
    {
        $api
            ->resource(Resource::crud('/users')
                ->allow(AclRoles::ADMINISTRATOR)
                ->allow(AclRoles::MANAGER)
                ->deny(AclRoles::NONE)
                ->deny(AclRoles::USER)
                ->name(Resources::USER)
                ->singleKey('user')
                ->multipleKey('users')
                ->model(User::class)
                ->endpoint(Api\Endpoint::factory('/me', HttpMethods::GET, 'me')
                    ->allow(AclRoles::USER)
                )
                ->endpoint(Api\Endpoint::factory('/authenticate', HttpMethods::POST, 'authenticate')
                    ->deny(AclRoles::AUTHORIZED)
                )
            )
            ->resource(Resource::factory('/items')
//                ->allow(AclRoles::ADMINISTRATOR)
                ->endpoint(Api\Endpoint::all()
//                    ->deny(AclRoles::ADMINISTRATOR)
                )
                ->endpoint(Api\Endpoint::find()
                    ->allow(AclRoles::ADMINISTRATOR)
                )
                ->name(Resources::ITEM)
                ->singleKey('item')
                ->multipleKey('items')
                ->model(Item::class)
            )
            ->resource(Resource::crud('/products')
                ->name(Resources::PRODUCT)
                ->singleKey('product')
                ->multipleKey('products')
                ->model(Product::class)
            );
    }
}