<?php
namespace Buttress\Atlas\Promise;

/**
 * Basic promise map
 *
 * Interface PromiseMap
 * @package Buttress\Atlas\Promise
 */
interface PromiseMap
{

    const PROMISE_SUCCESS = 1;
    const PROMISE_FAILURE = 0;

    /**
     * Add a callback to this promise
     *
     * @param callable $complete function(int $result)
     * @param int      $prioity
     * @return \Buttress\Atlas\Promise\PromiseMap
     */
    public function then(callable $complete, $priority=0): \Buttress\Atlas\Promise\PromiseMap;

    /**
     * Has this promise been fulfilled
     * @return bool
     */
    public function isFulfilled(): bool;

    /**
     * Get the result of the promise
     * @return array|null
     */
    public function getPromiseResult();

    /**
     * Fulfill the promise
     * @param int $result
     * @param array $results
     * @return mixed
     */
    public function fulfillPromise(int $result, array $results=array());

}
