<?php

namespace App\Transformers;

use App\Model\Album;
use PhalconRest\Transformers\Transformer;

class AlbumTransformer extends Transformer
{
    protected $availableIncludes = [
        'photos'
    ];

    public function includePhotos($album)
    {
        return $this->collection($album->getPhotos(), new PhotoTransformer);
    }

    public function transform(Album $album)
    {
        return [
            'id' => $this->int($album->id),
            'title' => $album->title,
            'updated_at' => $album->updatedAt,
            'created_at' => $album->createdAt
        ];
    }
}
