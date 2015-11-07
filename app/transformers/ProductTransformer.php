<?php

use League\Fractal;

class ProductTransformer extends Fractal\TransformerAbstract
{
    /**
     * Turn this resource object into a generic array
     *
     * @var \Product $product The product to transform
     * @return array
     */
    public function transform(\Product $product)
    {
        return [
            'id' => (int) $product->id,
            'title' => $product->title,
            'brand' => $product->brand,
            'color' => $product->color,
            'createdAt' => (int) strtotime($product->createdAt) * 1000,
            'updatedAt' => (int) strtotime($product->updatedAt) * 1000,
        ];
    }
}
