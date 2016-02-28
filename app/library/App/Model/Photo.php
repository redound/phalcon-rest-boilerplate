<?php

namespace App\Model;

class Photo extends \App\Mvc\DateTrackingModel
{
    public $id;
    public $title;

    public function getSource()
    {
        return 'photo';
    }

    public function columnMap()
    {
        return parent::columnMap() + [
            'id' => 'id',
            'title' => 'title',
            'album_id' => 'albumId'
        ];
    }

    public function initialize() {

        $this->belongsTo('albumId', Album::class, 'id', [
            'alias' => 'Album',
        ]);
    }

    public function whitelist()
    {
        return [
            'title'
        ];
    }
}
