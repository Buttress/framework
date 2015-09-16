<?php

namespace Buttress\Atlas\Test\Promise;

use Buttress\Atlas\Promise\PromiseMap;
use Buttress\Support\Traits\Promise\PromiseTrait;

class PromiseTestObject implements PromiseMap
{

    use PromiseTrait;

    protected $contract;

    protected $fulfill_callback;

    public function __construct($routine)
    {
        if ($routine instanceof \Closure) {
            $routine = $routine->bindTo($this, get_class($this));
        }

        $this->contract = $routine;
    }

    /**
     * @return callable|null
     */
    public function getFulfillCallback()
    {
        return $this->fulfill_callback;
    }

    /**
     * @param mixed $fulfill_callback
     */
    public function setFulfillCallback($fulfill_callback)
    {
        $this->fulfill_callback = $fulfill_callback;
    }

    /**
     * @return \Closure
     */
    public function getContract()
    {
        return $this->contract;
    }

    /**
     * @param \Closure $contract
     */
    public function setContract($contract)
    {
        $this->contract = $contract;
    }

    public function execute()
    {
        $contract = $this->contract;
        $contract(
            $this->getCallback(PromiseMap::PROMISE_SUCCESS),
            $this->getCallback(PromiseMap::PROMISE_FAILURE));
    }

    protected function getCallback($result)
    {
        $obj = $this;
        return function (...$results) use ($result, $obj) {
            $obj->fulfillPromise($result, $results);
        };
    }

    public function then(callable $complete, $priority=0): PromiseMap
    {
        $promise = new PromiseTestObject(null);

        $promise->setFulfillCallback(function($result, $params) use ($complete) {
            $complete($result, $params);
        });

        $this->addPromiseCallback($promise, $priority);
        return $promise;
    }

    protected function fulfill(int $result, array $params)
    {
        if ($contract = $this->getFulfillCallback()) {
            $contract($result, $params);
        }
    }

}
