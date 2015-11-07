<?php

class ExportController extends \App\Mvc\Controller
{
    /** @var  \PhalconRest\Documentation\Generator */
    protected $generator;

    public function onConstruct()
    {
        parent::onConstruct();

        $collections = [
            'ProductCollection',
            'UserCollection',
        ];

        $this->generator = new \PhalconRest\Documentation\Generator($collections);
    }

    public function documentation()
    {
        $resources = $this->generator->generate();

        return $this->respondCollection($resources, new \PhalconRest\Documentation\ResourceTransformer, 'resources');
    }

    public function postman()
    {
        $collection = $this->generator->generatePostmanCollection($this->config->hostName);

        return $this->respondItem($collection, new \PhalconRest\Documentation\PostmanCollectionTransformer, 'parent');
    }
}
