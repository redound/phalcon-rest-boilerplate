<?php

namespace PhalconRest\Test\Unit\Api;

use App\Model\Album;
use App\Transformers\AlbumTransformer;
use PhalconRest\Api\Resource;

class ResourceTest extends \Codeception\TestCase\Test {

    /** @var  Resource */
    protected $resource;

    protected function _before() {

        $this->resource = Resource::factory('/albums')
            ->model(Album::class)
            ->transformer(AlbumTransformer::class)
            ->itemKey('album')
            ->collectionKey('albums');
    }

    public function testModel() {

        $this->assertEquals($this->resource->getModel(), Album::class);
    }

    public function testTransformer() {

        $this->assertEquals($this->resource->getTransformer(), AlbumTransformer::class);
    }

    public function testItemKey() {

        $this->assertEquals($this->resource->getItemKey(), 'album');
    }

    public function testCollectionKey() {

        $this->assertEquals($this->resource->getCollectionKey(), 'albums');
    }
}