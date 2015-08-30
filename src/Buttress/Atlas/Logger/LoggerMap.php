<?php
namespace Buttress\Atlas\Logger;

interface LoggerMap
{

    /**
     * Set the driver that this logger will use.
     *
     * @param \Buttress\Atlas\Logger\Driver\LoggerDriverMap $driver
     * @return \Buttress\Atlas\Logger\void
     */
    public function setDriver(\Buttress\Atlas\Logger\Driver\LoggerDriverMap $driver): void;

}
