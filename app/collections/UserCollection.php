<?php

class UserCollection extends \Phalcon\Mvc\Micro\Collection
{
    public function __construct()
    {

        $this->setHandler('UserController', true);
        $this->setPrefix('/users');
        $this->post('/register/{account}', 'register');
        $this->get('/activate', 'activate');
        $this->get('/me', 'me');
        $this->post('/me/changepassword/{account}', 'changepassword');
        $this->post('/me/update', 'update');
        $this->post('/me/delete', 'delete');
        $this->post('/authenticate/{account}', 'authenticate');
        $this->get('/logout', 'logout');
    }
}
