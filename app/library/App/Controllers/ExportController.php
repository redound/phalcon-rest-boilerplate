<?php

namespace App\Controllers;

use App\Constants\Services;
use PhalconRest\Export\Documentation;
use PhalconRest\Export\Postman\Collection;
use PhalconRest\Transformers\DocumentationTransformer;
use PhalconRest\Transformers\Postman\CollectionTransformer;

class ExportController extends \PhalconRest\Mvc\Controllers\FractalController
{
    public function documentation()
    {
        /** @var \Phalcon\Config $config */
        $config = $this->di->get(Services::CONFIG);

        $documentation = new Documentation($config->application->title, $config->hostName);
        $documentation->addManyCollections($this->application->getCollections());
        $documentation->addManyRoutes($this->application->getRouter()->getRoutes());

        return $this->createItemResponse($documentation, new DocumentationTransformer(), 'documentation');
    }

    public function postman()
    {
        /** @var \Phalcon\Config $config */
        $config = $this->di->get(Services::CONFIG);

        $postmanCollection = new Collection($config->application->title, $config->hostName);
        $postmanCollection->addManyCollections($this->application->getCollections());
        $postmanCollection->addManyRoutes($this->application->getRouter()->getRoutes());

        return $this->createItemResponse($postmanCollection, new CollectionTransformer());
    }
}
