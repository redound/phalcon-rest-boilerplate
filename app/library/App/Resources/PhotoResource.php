<?php

namespace App\Resources;

use PhalconRest\Api\Resource;
use App\Model\Photo;
use App\Transformers\PhotoTransformer;
use App\Constants\AclRoles;

class PhotoResource extends Resource {

    public function initialize()
    {
        $this
            ->name('Photo')
            ->model(Photo::class)
            ->expectsJsonData()
            ->transformer(PhotoTransformer::class)
            ->itemKey('photo')
            ->collectionKey('photos')
            ->deny(AclRoles::UNAUTHORIZED);
    }
}