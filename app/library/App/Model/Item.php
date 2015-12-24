<?php

namespace App\Model;

class Item extends \App\Mvc\DateTrackingModel
{
    public $id;
    public $title;
    public $author;
    public $likes;

    public function getSource()
    {
        return 'items';
    }

    public function columnMap()
    {
        return parent::columnMap() + [
            'id' => 'id',
            'title' => 'title',
            'author' => 'author',
            'likes' => 'likes'
        ];
    }

    public function whitelist()
    {
        return [
            'title',
            'likes',
            'author'
        ];
    }
}
