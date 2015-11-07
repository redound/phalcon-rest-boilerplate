<?php

class ExportCollection extends \Phalcon\Mvc\Micro\Collection
{
    public function __construct()
    {
        $this->setHandler('ExportController', true);
        $this->setPrefix('/export');

        $this->get('/documentation.json', 'documentation');
        $this->get('/postman.json', 'postman');
    }
}