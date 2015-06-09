<?php

use \Library\Phalcon\Constants\Services as PhalconServices;

class ExportController extends \PhalconRest\Mvc\Controller {

	public function onConstruct()
	{
		parent::onConstruct();

		$collections = [
			'ProductCollection',
			'UserCollection'
		];
		
		$this->generator = new \PhalconRest\Documentation\Generator($collections);
	}

	public function documentation()
	{
		$resources = $this->generator->generate();

		return $this->createCollection($resources, new \PhalconRest\Documentation\ResourceTransformer, 'resources');
	}

	public function postman()
	{
		$config = $this->di->get(PhalconServices::CONFIG);
		$collection = $this->generator->generatePostmanCollection($config->hostName);
		
		return $this->createItem($collection, new \PhalconRest\Documentation\PostmanCollectionTransformer, 'parent');
	}
}