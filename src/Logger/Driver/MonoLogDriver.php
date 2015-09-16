<?php
namespace Buttress\Logger\Driver;

use Buttress\Atlas\Logger\Driver\LoggerDriverMap;
use Monolog\Logger;

class MonoLogDriver implements LoggerDriverMap
{

    /**
     * @type Logger
     */
    protected $logger;

    /**
     * @type array
     */
    protected $levels;

    /**
     * @return Logger
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param Logger $logger
     */
    public function setLogger(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     */
    public function log(string $level, string $message, array $context = array())
    {
        $this->logger->log($level, $message, $context);
    }

}
