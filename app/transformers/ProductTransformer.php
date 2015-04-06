<?php

use League\Fractal;

class ProductTransformer extends Fractal\TransformerAbstract
{
	/**
	 * Turn this resource object into a generic array
	 *
	 * @return array
	 */
	public function transform($product)
	{
		return [
			'id' 			=> (int) $product->id,
			'title'         => $product->title,
			'brand'       	=> $product->brand,
			'color'         => $product->color,
			'createdAt'     => (int) strtotime($product->createdAt) * 1000,
			'updatedAt'     => (int) strtotime($product->updatedAt) * 1000,
		];
	}
}
