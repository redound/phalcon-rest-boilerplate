<?php

namespace App\Controllers;

use App\Constants\Services;

class ExportController extends \PhalconRest\Mvc\Controllers\FractalController
{
    public function documentation()
    {
        /** @var \Phalcon\Config $config */
        $config = $this->di->get(Services::CONFIG);

        $documentation = new \PhalconRest\Export\Documentation($config->application->title, $config->hostName);
        $documentation->addManyResources($this->application->getResources());
        $documentation->addManyRoutes($this->application->getRouter()->getRoutes());

        return $this->createItemResponse($documentation, new \PhalconRest\Transformers\DocumentationTransformer,
            'documentation');
    }

    public function postman()
    {
        /** @var \Phalcon\Config $config */
        $config = $this->di->get(Services::CONFIG);

        $postmanCollection = new \PhalconRest\Export\Postman\Collection($config->application->title, $config->hostName);
        $postmanCollection->addManyResources($this->application->getResources());
        $postmanCollection->addManyRoutes($this->application->getRouter()->getRoutes());

        return $this->createItemResponse($postmanCollection,
            new \PhalconRest\Transformers\Postman\CollectionTransformer, 'parent');
    }
}
