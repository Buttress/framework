<?php
namespace Buttress\Atlas\Event\Dispatcher;

use Buttress\Atlas\Promise\PromiseMap;

interface EventDispatcherMap
{

    /**
     * Add a listener to the event dispatcher
     * @param string $event
     * @param callable $callback $callback(string $event, EventDispatcherMap $dispatcher, array $payload);
     * @param int $priority
     * @return mixed
     */
    public function listenToEvent(string $event, callable $callback, int $priority = 0);

    /**
     * add a listener to more than one event
     * @param array $events
     * @param callable $callback
     * @param int $priority
     * @return mixed
     */
    public function listenToEvents(array $events, callable $callback, int $priority = 0);

    /**
     * @param string $event_name
     * @param array $payload
     * @return mixed
     */
    public function publishEvent(string $event_name, array $payload = array());

}
