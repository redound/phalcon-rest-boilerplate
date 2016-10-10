<?php

namespace App\Transformers;

use App\Model\Photo;
use PhalconRest\Transformers\ModelTransformer;

class PhotoTransformer extends ModelTransformer
{
    /**
     * Transforms are automatically handled
     * based on your model when you extend ModelTransformer
     * and assign the modelClass property
     */
    protected $modelClass = Photo::class;

    protected $availableIncludes = [
        'album'
    ];

    public function includeAlbum($photo)
    {
        return $this->item($photo->getAlbum(), new AlbumTransformer());
    }

    /**
     * You can always transform manually by using
     * the following code (below):
     *
    public function transform(Photo $photo)
    {
        return [
            'id' => $this->int($photo->id),
            'title' => $photo->title,
            'albumId' => $this->int($photo->albumId)
        ];
    }
    */
}
