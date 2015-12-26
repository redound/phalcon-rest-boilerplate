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
            ->resource(Resource::crud('/users', 'User')
                ->model(User::class)
                ->transformer(UserTransformer::class)
                ->handler(UserController::class)
                ->singleKey('user')
                ->multipleKey('users')
                ->deny(AclRoles::UNAUTHORIZED, AclRoles::USER)

                ->endpoint(Endpoint::get('/me', 'me')
                    ->allow(AclRoles::USER)
                    ->description('Returns the currently logged in user')
                )
                ->endpoint(Endpoint::post('/authenticate', 'authenticate')
                    ->allow(AclRoles::UNAUTHORIZED)
                    ->deny(AclRoles::AUTHORIZED)
                    ->description('Authenticates user credentials provided in the authorization header and returns an access token')
                    ->exampleResponse([
                        'token' => 'co126bbm40wqp41i3bo7pj1gfsvt9lp6',
                        'expires' => 1451139067
                    ])
                )
            )

            ->resource(Resource::factory('/items', 'Item')
                ->model(Item::class)
                ->singleKey('item')
                ->multipleKey('items')
                ->deny(AclRoles::UNAUTHORIZED)

                ->endpoint(Endpoint::all())
                ->endpoint(Endpoint::find())
            )

            ->resource(Resource::crud('/products', 'Product')
                ->model(Product::class)
                ->singleKey('product')
                ->multipleKey('products')
                ->deny(AclRoles::UNAUTHORIZED)
            );
    }
}