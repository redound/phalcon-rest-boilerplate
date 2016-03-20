<?php

namespace App\Transformers;

use App\Model\Album;
use PhalconRest\Transformers\ModelTransformer;

class AlbumTransformer extends ModelTransformer
{
    protected $modelClass = Album::class;

    protected $availableIncludes = [
        'photos'
    ];

    public function includePhotos(Album $album)
    {
        return $this->collection($album->getPhotos(), new PhotoTransformer);
    }
}