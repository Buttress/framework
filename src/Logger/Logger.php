<?php
namespace Buttress\Logger;

use Buttress\Atlas\Logger\Driver\LoggerDriverMap;
use Buttress\Atlas\Logger\Exception\InvalidLevelException;
use Buttress\Atlas\Logger\LoggerMap;
use Buttress\Support\Traits\Macro\MacroTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

class Logger implements LoggerMap, LoggerInterface
{

    use LoggerTrait, MacroTrait;

    /** @type LoggerDriverMap */
    protected $driver;

    protected $levels = ["emergency", "alert", "critical", "error", "warning", "notice", "info", "debug"];

    /**
     * @return string[]
     */
    public function getLevels(): array
    {
        return $this->levels;
    }

    public function setDriver($driver)
    {
        $instance = null;
        if ($driver && !is_object($driver) || is_callable($driver)) {
            $instance = new_instance($driver);
        }

        $this->setDriver($instance);
    }

    public function getDriver()
    {
        return $this->driver;
    }

    public function log($level, $message, array $context = array())
    {
        if (!in_array(strtolower($level), $level)) {
            throw new InvalidLevelException("Level \"{$level}\" doesn't exist!");
        }

        $this->driver->log($level, $message, $context);
    }

}
