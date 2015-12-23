<?php

namespace App\Transformers;

use PhalconRest\Transformers\ModelTransformer;

class UserTransformer extends ModelTransformer
{
    protected function excludedProperties()
    {
        return ['password'];
    }
}