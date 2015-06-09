<?php

class ExportCollection extends \Phalcon\Mvc\Micro\Collection
{
	public function __construct()
	{

		$this->setHandler('ExportController', true); // true means; LazyLoad
		$this->setPrefix('/export');
		$this->get('/documentation.json', 'documentation');
		$this->get('/postman-collection.json', 'postman');
	}
}
