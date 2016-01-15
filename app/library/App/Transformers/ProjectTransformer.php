<?php

namespace App\Transformers;

use App\Model\Project;
use PhalconRest\Transformers\ModelTransformer;

class ProjectTransformer extends ModelTransformer
{
    protected $modelClass = Project::class;

    protected $defaultIncludes = [
        'items'
    ];

    public function includeItems(Project $project)
    {
        return $this->collection($project->getItems(), new ItemTransformer, 'parent');
    }
}