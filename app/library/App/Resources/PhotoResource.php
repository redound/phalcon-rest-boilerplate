<?php

namespace App\Resources;

use PhalconRest\Api\ApiEndpoint;
use PhalconRest\Api\ApiResource;
use App\Model\Photo;
use App\Transformers\PhotoTransformer;
use App\Constants\AclRoles;
use PhalconRest\Mvc\Controllers\CrudResourceController;

class PhotoResource extends ApiResource {

    public function initialize()
    {
        $this
            ->name('Photo')
            ->model(Photo::class)
            ->expectsJsonData()
            ->transformer(PhotoTransformer::class)
            ->itemKey('photo')
            ->collectionKey('photos')
            ->deny(AclRoles::UNAUTHORIZED)
            ->handler(CrudResourceController::class)

            ->endpoint(ApiEndpoint::all())
            ->endpoint(ApiEndpoint::create())
            ->endpoint(ApiEndpoint::find())
            ->endpoint(ApiEndpoint::update())
            ->endpoint(ApiEndpoint::remove());
    }
}
