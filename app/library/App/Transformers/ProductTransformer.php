<?php

namespace App\Transformers;

use App\Model\Product;
use PhalconRest\Transformers\ModelTransformer;

class ProductTransformer extends ModelTransformer
{
    protected $modelClass = Product::class;

    protected $availableIncludes = [
        'items'
    ];

    public function includeItems(Product $product)
    {
        return $this->collection($product->getItems(), new ItemTransformer, 'parent');
    }
}