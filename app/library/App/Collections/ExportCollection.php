<?php

namespace App\Collections;

use App\Controllers\ExportController;
use PhalconRest\Api\Collection;
use PhalconRest\Api\Endpoint;

class ExportCollection extends Collection
{
    protected function initialize()
    {
        $this
            ->name('Export')
            ->handler(ExportController::class)

            ->endpoint(Endpoint::get('/documentation.json', 'documentation'))
            ->endpoint(Endpoint::get('/postman.json', 'postman'));
    }
}
