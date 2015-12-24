<?php

namespace App\Controllers;

use App\Constants\Services;
use PhalconRest\Export\Postman\Collection as PostmanCollection;

class ExportController extends \PhalconRest\Mvc\Controllers\FractalController
{
    public function onConstruct()
    {
        parent::onConstruct();

    }

    public function documentation()
    {
        /** @var \PhalconRest\Api $api */
        $api = $this->di->get(Services::APPLICATION);

        /** @var \Phalcon\Config $config */
        $config = $this->di->get(Services::CONFIG);

        $documentation = new \PhalconRest\Export\Documentation($config->application->title, $config->hostName);
        $documentation->importManyRoutes($api->getRouter()->getRoutes());
        $documentation->importManyResources($api->getResources());

        return $this->createItemResponse($documentation, new \PhalconRest\Transformers\DocumentationTransformer, 'documentation');
    }

    public function postman()
    {
        /** @var \PhalconRest\Api $api */
        $api = $this->di->get(Services::APPLICATION);

        /** @var \Phalcon\Config $config */
        $config = $this->di->get(Services::CONFIG);

        $postmanCollection = new PostmanCollection($config->application->title, $config->hostName);
        $postmanCollection->importManyRoutes($api->getRouter()->getRoutes());
        $postmanCollection->importManyResources($api->getResources());

        return $this->createItemResponse($postmanCollection, new \PhalconRest\Transformers\Postman\CollectionTransformer, 'parent');
    }
}
