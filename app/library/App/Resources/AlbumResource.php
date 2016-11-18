<?php

namespace App\Resources;

use PhalconRest\Api\ApiEndpoint;
use PhalconRest\Api\ApiResource;
use App\Model\Album;
use App\Transformers\AlbumTransformer;
use App\Constants\AclRoles;
use PhalconRest\Mvc\Controllers\CrudResourceController;

class AlbumResource extends ApiResource {

    public function initialize()
    {
        $this
            ->name('Album')
            ->model(Album::class)
            ->expectsJsonData()
            ->transformer(AlbumTransformer::class)
            ->itemKey('album')
            ->collectionKey('albums')
            ->deny(AclRoles::UNAUTHORIZED)
            ->handler(CrudResourceController::class)

            ->endpoint(ApiEndpoint::all())
            ->endpoint(ApiEndpoint::create())
            ->endpoint(ApiEndpoint::find())
            ->endpoint(ApiEndpoint::update())
            ->endpoint(ApiEndpoint::remove());
    }
}
