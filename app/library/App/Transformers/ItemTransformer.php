<?php

namespace App\Transformers;

use App\Model\Item;
use PhalconRest\Transformers\ModelTransformer;

class ItemTransformer extends ModelTransformer
{
    protected $modelClass = Item::class;

    protected $availableIncludes = [
        'products'
    ];

    public function typeMap()
    {
        return [
            'completed' => self::TYPE_BOOLEAN
        ];
    }

    public function includeProducts(Item $item)
    {
        return $this->collection($item->getProducts(), new ProductTransformer, 'parent');
    }
}