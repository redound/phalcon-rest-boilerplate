<?php

namespace App\Transformers;

use App\Model\User;
use PhalconRest\Transformers\ModelTransformer;

class UserTransformer extends ModelTransformer
{
    protected $modelClass = User::class;

    protected function excludedProperties()
    {
        return ['password'];
    }
}