<?php
namespace Buttress\Logger\Driver;

use Buttress\Atlas\Logger\Driver\LoggerDriverMap;

class ClosureDriver implements LoggerDriverMap
{

    /**
     * @type callable
     */
    protected $closure;

    /**
     * ClosureDriver constructor.
     * @param callable $closure
     */
    public function __construct(callable $closure)
    {
        $this->closure = $closure;
    }

    /**
     * @return callable
     */
    public function getClosure()
    {
        return $this->closure;
    }

    /**
     * @param callable $closure
     */
    public function setClosure(callable $closure)
    {
        $this->closure = $closure;
    }

    /**
     * @inheritdoc
     */
    public function log(string $level, string $message, array $context = array())
    {
        $callable = $this->closure;
        if (is_callable($callable)) {
            $callable($level, $message, $context);
        }
    }

}
