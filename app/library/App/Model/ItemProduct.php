<?php

namespace App\Model;

class ItemProduct extends \App\Mvc\DateTrackingModel
{
    public function getSource()
    {
        return 'item_product';
    }

    public function columnMap()
    {
        return [
            'item_id' => 'itemId',
            'product_id' => 'productId',
        ];
    }

    public function initialize()
    {
        $this->belongsTo('itemId', Item::class, 'id', [
            'alias' => 'Item',
        ]);

        $this->belongsTo('productId', Product::class, 'id', [
            'alias' => 'Product',
        ]);
    }
}