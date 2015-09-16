<?php

namespace Buttress\Atlas\Logger;

interface LoggerAwareMap
{

    /**
     * Set the logger
     * @param \Buttress\Atlas\Logger\LoggerMap $logger
     */
    public function setLogger(LoggerMap $logger);

    /**
     * Get the set logger
     * @return \Buttress\Atlas\Logger\LoggerMap|null
     */
    public function getLogger();

}
