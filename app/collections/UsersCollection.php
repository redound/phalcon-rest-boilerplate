<?php

class UsersCollection extends \Phalcon\Mvc\Micro\Collection
{
	public function __construct()
	{

		$this->setHandler('UsersController', true);
		$this->setPrefix('/users');
		$this->post('/', 'create');
		$this->get('/activate', 'activate');
		$this->get('/me', 'me');
		$this->post('/login', 'login');
		$this->get('/logout', 'logout');
	}
}
