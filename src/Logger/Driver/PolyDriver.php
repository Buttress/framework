<?php

namespace Buttress\Logger\Driver;

use Buttress\Atlas\Container\ContainerMap;
use Buttress\Atlas\Logger\Driver\LoggerDriverMap;
use Buttress\Atlas\Logger\Driver\string;
use Buttress\Atlas\Logger\Exception\InvalidDriverException;
use Buttress\Support\Traits\Container\ContainerTrait;
use Buttress\Support\Traits\Manager\ManagerTrait;
use Psr\Log\LoggerTrait;

class PolyDriver implements LoggerDriverMap, ContainerMap
{

    use ContainerTrait;

    /**
     * @param string $handle
     * @param mixed $driver
     * return LoggerDriverMap
     */
    public function add(string $handle, $driver)
    {
        if (!($driver instanceof LoggerDriverMap)) {
            $driver = new_instance($driver);
        }
        if (!($driver instanceof LoggerDriverMap)) {
            throw new InvalidDriverException("Passed driver must resolve to `LoggerDriverMap` instance.");
        }

        $this->containerSet($handle, $driver);
    }

    public function set($item, $value)
    {

    }

    public function log(string $level, string $message, array $context = array())
    {
        foreach ($this as $handle => $driver) {
            $driver->log($level, $message, $context);
        }
    }

}
