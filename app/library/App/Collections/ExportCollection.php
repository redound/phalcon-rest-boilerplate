<?php

namespace App\Collections;

use App\Controllers\ExportController;
use PhalconRest\Api\Collection;
use PhalconRest\Api\Endpoint;

class ExportCollection extends Collection
{
    public static function factory($prefix, $name = null)
    {
        return parent::factory($prefix, $name)
            ->name('Export')
            ->handler(ExportController::class, true)
            ->endpoint(Endpoint::get('/documentation.json', 'documentation'))
            ->endpoint(Endpoint::get('/postman.json', 'postman'));
    }
}