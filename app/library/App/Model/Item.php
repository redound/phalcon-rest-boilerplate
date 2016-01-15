<?php

namespace App\Model;

class Item extends \App\Mvc\DateTrackingModel
{
    public $id;
    public $body;
    public $completed;

    public function getSource()
    {
        return 'item';
    }

    public function columnMap()
    {
        return parent::columnMap() + [
            'id' => 'id',
            'body' => 'body',
            'completed' => 'completed'
        ];
    }

    public function initialize() {

        $this->hasManyToMany('id', ProjectItem::class, 'itemId', 'projectId', Project::class, 'id', [
            'alias' => 'Projects',
        ]);
    }

    public function whitelist()
    {
        return [
            'body',
            'completed'
        ];
    }
}
