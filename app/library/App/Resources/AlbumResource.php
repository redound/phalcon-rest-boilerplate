<?php

namespace App\Resources;

use PhalconRest\Api\Resource;
use App\Model\Album;
use App\Transformers\AlbumTransformer;
use App\Constants\AclRoles;

class AlbumResource extends Resource {

    public static function crud($prefix, $name = null)
    {
        return parent::crud($prefix, $name)
            ->name('Album')
            ->model(Album::class)
            ->expectsJsonData()
            ->transformer(AlbumTransformer::class)
            ->itemKey('album')
            ->collectionKey('albums')
            ->deny(AclRoles::UNAUTHORIZED);
    }
}