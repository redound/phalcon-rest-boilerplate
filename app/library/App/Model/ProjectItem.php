<?php

namespace App\Model;

class ProjectItem extends \App\Mvc\DateTrackingModel
{
    public function getSource()
    {
        return 'project_item';
    }

    public function columnMap()
    {
        return [
            'project_id' => 'projectId',
            'item_id' => 'itemId',
        ];
    }

    public function initialize()
    {
        $this->belongsTo('projectId', Project::class, 'id', [
            'alias' => 'Project',
        ]);

        $this->belongsTo('itemId', Item::class, 'id', [
            'alias' => 'Item',
        ]);
    }
}