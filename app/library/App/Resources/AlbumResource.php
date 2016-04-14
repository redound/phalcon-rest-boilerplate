<?php

namespace App\Resources;

use PhalconRest\Api\Endpoint;
use PhalconRest\Api\Resource;
use App\Model\Album;
use App\Transformers\AlbumTransformer;
use App\Constants\AclRoles;

class AlbumResource extends Resource {

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

            ->endpoint(Endpoint::create())
            ->endpoint(Endpoint::find())
            ->endpoint(Endpoint::update())
            ->endpoint(Endpoint::remove());
    }
}