<?php

namespace App\Model;

class Project extends \App\Mvc\DateTrackingModel
{
    public $id;
    public $title;
    public $color;

    public function getSource()
    {
        return 'project';
    }

    public function columnMap()
    {
        return parent::columnMap() + [
            'id' => 'id',
            'title' => 'title',
            'color' => 'color'
        ];
    }

    public function initialize() {

        $this->hasManyToMany('id', ProjectItem::class, 'projectId', 'itemId', Item::class, 'id', [
            'alias' => 'Items',
        ]);
    }

    public function whitelist()
    {
        return [
            'title',
            'color',
        ];
    }
}
