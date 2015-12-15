<?php

class ApiCollection extends \Phalcon\Mvc\Micro\Collection
{
    public function __construct()
    {
        $this->setHandler('ApiController', true);

        $this->get('/{resourceKey}', 'fetchList');
        $this->get('/{resourceKey}/{id}', 'fetchSingle');
        $this->post('/{resourceKey}', 'create');
        $this->put('/{resourceKey}/{id}', 'update');
        $this->delete('/{resourceKey}/{id}', 'remove');
    }
}