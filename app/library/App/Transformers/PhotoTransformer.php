<?php

namespace App\Transformers;

use App\Model\Photo;
use PhalconRest\Transformers\Transformer;

class PhotoTransformer extends Transformer
{
    protected $availableIncludes = [
        'album'
    ];

    public function includeAlbum(Photo $photo)
    {
        return $this->item($photo->getAlbum(), new AlbumTransformer());
    }

    public function transform(Photo $photo)
    {
        return [
            'id' => $this->int($photo->id),
            'title' => $photo->title,
            'albumId' => $this->int($photo->albumId)
        ];
    }
}
