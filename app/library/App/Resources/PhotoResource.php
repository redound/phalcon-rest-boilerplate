<?php

namespace App\Resources;

use PhalconRest\Api\Resource;
use App\Model\Photo;
use App\Transformers\PhotoTransformer;
use App\Constants\AclRoles;

class PhotoResource extends Resource {

    public static function crud($prefix, $name = null)
    {
        return parent::crud($prefix, $name)
            ->name('Photo')
            ->model(Photo::class)
            ->expectsJsonData()
            ->transformer(PhotoTransformer::class)
            ->itemKey('photo')
            ->collectionKey('photos')
            ->deny(AclRoles::UNAUTHORIZED);
    }
}