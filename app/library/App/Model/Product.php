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
        return 'products';
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

    public function whitelist()
    {
        return [
            'title',
            'brand',
            'color',
        ];
    }
}
