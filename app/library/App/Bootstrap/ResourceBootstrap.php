<?php

namespace App\Bootstrap;

use App\Model\Album;
use App\Model\Photo;
use App\Model\User;
use App\Transformers\AlbumTransformer;
use App\Transformers\PhotoTransformer;
use App\Transformers\UserTransformer;
use App\Controllers\UserController;
use Phalcon\Acl;
use Phalcon\Config;
use Phalcon\DiInterface;
use PhalconRest\Api;
use PhalconRest\Api\Resource;
use App\Constants\AclRoles;
use PhalconRest\Api\Endpoint;
use PhalconRest\Constants\PostedDataMethods;

class ResourceBootstrap extends \App\Bootstrap
{
    public function run(Api $api, DiInterface $di, Config $config)
    {
        $api
            ->resource(Resource::factory('/users', 'User')
                ->model(User::class)
                ->expectsJsonData()
                ->transformer(UserTransformer::class)
                ->handler(UserController::class)
                ->singleKey('user')
                ->multipleKey('users')
                ->deny(AclRoles::UNAUTHORIZED, AclRoles::USER)

                ->endpoint(Endpoint::all()
                    ->allow(AclRoles::USER)
                    ->description('Returns all registered users')
                )
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

            ->resource(Resource::crud('/albums', 'Album')
                ->model(Album::class)
                ->expectsJsonData()
                ->transformer(AlbumTransformer::class)
                ->singleKey('album')
                ->multipleKey('albums')
                ->deny(AclRoles::UNAUTHORIZED)
            )

            ->resource(Resource::crud('/photos', 'Photo')
                ->model(Photo::class)
                ->expectsJsonData()
                ->transformer(PhotoTransformer::class)
                ->singleKey('photo')
                ->multipleKey('photos')
                ->deny(AclRoles::UNAUTHORIZED)
            );
    }
}