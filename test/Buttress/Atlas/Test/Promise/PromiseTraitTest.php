<?php

namespace Buttress\Atlas\Test\Promise;

use Buttress\Atlas\Promise\PromiseMap;

class PromiseTraitTest extends \PHPUnit_Framework_TestCase
{

    public function testPromiseFlow()
    {
        $main_promise = new PromiseTestObject(null);

        $main_promise->setContract(function () use ($main_promise) {
            $main_promise->fulfillPromise(PromiseMap::PROMISE_SUCCESS);
        });

        $this->assertFalse($main_promise->isFulfilled());

        $hit = false;
        $promise = $main_promise->then(function () use (&$hit) {
            $hit = true;
        });

        $this->assertFalse($hit);

        $main_promise->execute();

        $this->assertTrue($main_promise->isFulfilled(), 'isFulfilled');
        $this->assertTrue($hit, 'isHit');
    }

    public function testPromiseResult()
    {
        $main_promise = new PromiseTestObject(null);
        $result_array = null;
        $test_array = array(
            'testing', 'that', 'this', 'works'
        );

        $main_promise->setContract(function () use ($main_promise, $test_array) {
            $main_promise->fulfillPromise(PromiseMap::PROMISE_SUCCESS, $test_array);
        });

        $main_promise->then(function ($result, array $results) use (&$result_array) {
            $result_array = $results;
        });

        $main_promise->execute();

        $this->assertEquals($test_array, $result_array);

        $this->assertEquals($main_promise->getPromiseResult(), $result_array);

    }

}
