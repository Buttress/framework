<?php
namespace Buttress\Support\Traits\Promise;

use Buttress\Atlas\Promise\PromiseMap;

trait PromiseTrait
{

    /**
     * @type array
     */
    protected $promise_callbacks = array();

    /**
     * @type bool
     */
    protected $promise_fulfilled = false;

    /**
     * @type array|null
     */
    protected $promise_result;

    /**
     * @param \Buttress\Atlas\Promise\PromiseMap $callback
     * @param int $priority
     */
    protected function addPromiseCallback(PromiseMap $callback, int $priority=0)
    {
        if (!isset($this->promise_callbacks[$priority])) {
            $this->promise_callbacks[$priority] = [];
        }

        $this->promise_callbacks[$priority][] = $callback;
    }

    /**
     * Fulfill the promise
     * @param int $result
     * @param array $results
     * @return mixed
     */
    public function fulfillPromise(int $result, array $results=array())
    {
        $this->promise_fulfilled = true;
        $this->promise_result = $results;

        $this->fulfill($result, $results);

        /** @type PromiseTrait[][] $callbacks */
        $callbacks = (array)$this->promise_callbacks;

        // Higher priority first
        rsort($callbacks);

        foreach ($callbacks as $priority_list) {
            foreach ($priority_list as $callback) {
                $callback->fulfillPromise($result, $results);
            }
        }
    }

    /**
     * Get the result of the promise
     * @return array|null
     */
    public function getPromiseResult()
    {
        return $this->promise_result;
    }

    /**
     * Has this promise been fulfilled
     * @return bool
     */
    public function isFulfilled(): bool
    {
        return !!$this->promise_fulfilled;
    }

    /**
     * Override to provide your own fulfillment routine
     *
     * @param int $result
     * @return void
     */
    abstract protected function fulfill(int $result, array $params);

}
