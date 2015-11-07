<?php

class Product extends \App\Mvc\Model
{
    public $id;
    public $title;
    public $brand;
    public $color;

    public function getSource()
    {
        return 'products';
    }

    public function columnMap()
    {
        return [
            'id' => 'id',
            'title' => 'title',
            'brand' => 'brand',
            'color' => 'color',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function whitelist()
    {
        return [
            'title',
            'brand',
            'color',
        ];
    }

    public function validateRules()
    {
        return [
            'title' => 'min:2|max:55|required',
            'brand' => 'min:2|max:55',
            'color' => 'min:2|max:6',
        ];
    }
}
