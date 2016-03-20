<?php

namespace App\Transformers;

use App\Model\Photo;
use PhalconRest\Transformers\ModelTransformer;

class PhotoTransformer extends ModelTransformer
{
    protected $modelClass = Photo::class;

    protected $availableIncludes = [
        'album'
    ];

    public function includeAlbum(Photo $photo)
    {
        return $this->item($photo->getAlbum(), new AlbumTransformer());
    }
}