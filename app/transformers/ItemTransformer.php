<?php

use League\Fractal;

class ItemTransformer extends Fractal\TransformerAbstract
{
    public function transform(\Item $item)
    {
        $updatedTime = strtotime($item->updatedAt);

        return [
            'id' => (int)$item->id,
            'title' => $item->title,
            'likes' => $item->likes,
            'author' => $item->author,
            'createdAt' => (int) strtotime($item->createdAt),
            'updatedAt' => $updatedTime ? (int)$updatedTime : null
        ];
    }
}