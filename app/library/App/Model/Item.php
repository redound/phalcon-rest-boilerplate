<?php

namespace App\Model;

class Item extends \App\Mvc\Model
{
    use \App\Mvc\Model\DateTrait;

    public $id;
    public $title;

    public function getSource()
    {
        return 'items';
    }

    public function columnMap()
    {
        return [
            'id' => 'id',
            'title' => 'title',
            'likes' => 'likes',
            'author' => 'author',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
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
