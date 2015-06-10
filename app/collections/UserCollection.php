<?php

class UserCollection extends \Phalcon\Mvc\Micro\Collection
{
    public function __construct()
    {

        $this->setHandler('UserController', true);
        $this->setPrefix('/users');
        $this->post('/', 'create');
        $this->get('/activate', 'activate');
        $this->get('/me', 'me');
        $this->post('/authenticate/{account}', 'authenticate');
        $this->get('/logout', 'logout');
    }
}
