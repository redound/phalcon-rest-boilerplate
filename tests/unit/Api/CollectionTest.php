<?php

namespace PhalconRest\Test\Unit\Api;

use App\Constants\AclRoles;
use Phalcon\Acl;
use PhalconRest\Api\Collection;
use PhalconRest\Api\Endpoint;
use PhalconRest\Constants\PostedDataMethods;

class CollectionTest extends \Codeception\TestCase\Test {

    /** @var  Collection */
    protected $collection;

    protected function _before() {

        $this->collection = Collection::factory('/books')
            ->name('Books')
            ->description('a short description');
    }

    public function testName() {

        $this->assertEquals($this->collection->getName(), 'Books');
    }

    public function testPrefix() {

        $this->assertEquals($this->collection->getPrefix(), '/books');
    }

    public function testIdentifier() {

        $this->assertEquals($this->collection->getIdentifier(), '/books');
    }

    public function testDescription() {

        $this->assertEquals($this->collection->getDescription(), 'a short description');
    }

    public function testGetEndpoints() {

        $endpoints = [
            Endpoint::get('/all', 'all'),
            Endpoint::get('/find/:id', 'find')
        ];

        foreach($endpoints as $endpoint) {
            $this->collection->endpoint($endpoint);
        }

        $this->assertEquals($this->collection->getEndpoints(), $endpoints);
    }

    public function testGetDefaultPostedDataMethod() {

        $this->assertEquals($this->collection->getPostedDataMethod(), PostedDataMethods::AUTO);
    }

    public function testExpectsJsonData() {

        $this->collection->expectsJsonData();
        $this->assertEquals($this->collection->getPostedDataMethod(), PostedDataMethods::JSON_BODY);
    }

    public function testExpectsPostData() {

        $this->collection->expectsPostData();
        $this->assertEquals($this->collection->getPostedDataMethod(), PostedDataMethods::POST);
    }

    public function testAllowedRoles() {

        $this->collection->allow(AclRoles::ADMINISTRATOR, AclRoles::ADMINISTRATOR);

        $this->assertEquals($this->collection->getAllowedRoles(), [AclRoles::ADMINISTRATOR]);
    }

    public function testDeniedRoles() {

        $this->collection->deny(AclRoles::MANAGER, AclRoles::MANAGER, AclRoles::USER);

        $this->assertEquals($this->collection->getDeniedRoles(), [AclRoles::MANAGER, AclRoles::USER]);
    }
}