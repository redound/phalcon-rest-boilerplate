<?php

namespace App\Collections;

use App\Controllers\ExportController;
use PhalconRest\Api\ApiCollection;
use PhalconRest\Api\ApiEndpoint;

class ExportCollection extends ApiCollection
{
    protected function initialize()
    {
        $this
            ->name('Export')
            ->handler(ExportController::class)

            ->endpoint(ApiEndpoint::get('/documentation.json', 'documentation'))
            ->endpoint(ApiEndpoint::get('/postman.json', 'postman'));
    }
}
