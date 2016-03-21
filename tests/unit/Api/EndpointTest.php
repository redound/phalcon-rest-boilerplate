<?php

namespace PhalconRest\Test\Unit\Api;

use PhalconRest\Api\Endpoint;
use PhalconRest\Constants\HttpMethods;
use PhalconRest\Constants\PostedDataMethods;

class EndpointTest extends \Codeception\TestCase\Test {

    const EXAMPLE_RESPONSE = '{"item":{"title": "A Sunny Holiday"}}';

    /** @var Endpoint */
    protected $endpoint;

    protected function _before() {

        $this->endpoint = Endpoint::get('/all', 'all')
            ->name('All')
            ->description('a short description')
            ->exampleResponse(self::EXAMPLE_RESPONSE);
    }

    public function testIdentifier() {

        $this->assertEquals($this->endpoint->getIdentifier(), 'GET /all');
    }

    public function testHttpMethod() {

        $this->assertEquals($this->endpoint->getHttpMethod(), HttpMethods::GET);
    }

    public function testHandlerMethod() {

        $this->assertEquals($this->endpoint->getHandlerMethod(), 'all');
    }

    public function testName() {

        $this->assertEquals($this->endpoint->getName(), 'All');
    }

    public function testDescription() {

        $this->assertEquals($this->endpoint->getDescription(), 'a short description');
    }

    public function testExampleResponse() {

        $this->assertEquals($this->endpoint->getExampleResponse(), self::EXAMPLE_RESPONSE);
    }

    public function testPath() {

        $this->assertEquals($this->endpoint->getPath(), '/all');
    }

    public function testGetDefaultPostedDataMethod() {

        $this->assertEquals($this->endpoint->getPostedDataMethod(), PostedDataMethods::AUTO);
    }

    public function testExpectsJsonData() {

        $this->endpoint->expectsJsonData();
        $this->assertEquals($this->endpoint->getPostedDataMethod(), PostedDataMethods::JSON_BODY);
    }

    public function testExpectsPostData() {

        $this->endpoint->expectsPostData();
        $this->assertEquals($this->endpoint->getPostedDataMethod(), PostedDataMethods::POST);
    }
}