<?php

namespace App\Bootstrap;

use App\Model\Item;
use App\Model\Product;
use App\Model\User;
use App\Transformers\UserTransformer;
use App\Controllers\UserController;
use Phalcon\Acl;
use Phalcon\Config;
use Phalcon\DiInterface;
use PhalconRest\Api;
use PhalconRest\Api\Resource;
use App\Constants\AclRoles;
use PhalconRest\Api\Endpoint;

class ResourceBootstrap extends \App\Bootstrap
{
    public function run(Api $api, DiInterface $di, Config $config)
    {
        $api
            ->resource(Resource::crud('/users')
                ->model(User::class)
                ->transformer(UserTransformer::class)
                ->handler(UserController::class)
                ->singleKey('user')
                ->multipleKey('users')
                ->deny(AclRoles::UNAUTHORIZED, AclRoles::USER)

                ->endpoint(Endpoint::get('/me', 'me')
                    ->allow(AclRoles::USER)
                )
                ->endpoint(Endpoint::post('/authenticate', 'authenticate')
                    ->allow(AclRoles::UNAUTHORIZED)
                    ->deny(AclRoles::AUTHORIZED)
                )
            )

            ->resource(Resource::factory('/items')
                ->model(Item::class)
                ->singleKey('item')
                ->multipleKey('items')
                ->deny(AclRoles::UNAUTHORIZED)

                ->endpoint(Endpoint::all())
                ->endpoint(Endpoint::find())
            )

            ->resource(Resource::crud('/products')
                ->model(Product::class)
                ->singleKey('product')
                ->multipleKey('products')
                ->deny(AclRoles::UNAUTHORIZED)
            );
    }
}