<?php

namespace App\Collections;

class ExportCollection extends \Phalcon\Mvc\Micro\Collection
{
    public function __construct()
    {
        $this->setHandler(\App\Controllers\ExportController::class, true);
        $this->setPrefix('/export');

        $this->get('/documentation.json', 'documentation');
        $this->get('/postman.json', 'postman');
    }
}