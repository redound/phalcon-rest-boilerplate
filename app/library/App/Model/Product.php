<?php

namespace App\Model;

class Product extends \App\Mvc\DateTrackingModel
{
    public $id;
    public $title;
    public $brand;
    public $color;

    public function getSource()
    {
        return 'product';
    }

    public function columnMap()
    {
        return parent::columnMap() + [
            'id' => 'id',
            'title' => 'title',
            'brand' => 'brand',
            'color' => 'color'
        ];
    }

    public function initialize() {

        $this->hasManyToMany('id', ItemProduct::class, 'productId', 'itemId', Item::class, 'id', [
            'alias' => 'Items',
        ]);
    }

    public function whitelist()
    {
        return [
            'title',
            'brand',
            'color',
        ];
    }
}
