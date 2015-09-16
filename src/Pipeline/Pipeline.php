<?php
namespace Buttress\Pipeline;

use \Buttress\Atlas\Pipeline\PipelineMap;

class Pipeline implements PipelineMap
{

    /**
     * @var array The parameters to pass through
     */
    protected $parameters = [];

    /**
     * @var \Closure[] The list of pipes that the parameters will fall through
     *                 Pipe should match function($parameter..., \Closure $next) {}
     */
    protected $pipes = [];

    /**
     * @type \Closure The reduced closure
     */
    protected $linkedClosure;

    public function pipe(...$parameters) : PipelineMap
    {
        $this->parameters = $parameters;
        return $this;
    }

    public function through($pipes) : PipelineMap
    {
        $this->pipes = is_array($pipes) ? $pipes : func_get_args();
        return $this;
    }

    public function then(callable $then) : PipelineMap
    {
        $pipes = array_reverse($this->pipes);
        $this->linkedClosure = array_reduce($pipes, $this->getIterator(), $this->getInitial($then));

        return $this;
    }

    public function execute()
    {
        $linked_closure = $this->linkedClosure;

        return $linked_closure(...$this->parameters);
    }

    /**
     * @return \Closure
     */
    protected function getIterator() : \Closure
    {
        return function ($next, $pipe) {
            return function (...$parameters) use ($next, $pipe) {
                $parameters[] = $next;
                return $pipe(...$parameters);
            };
        };
    }

    protected function getInitial(\Closure $then)
    {
        return function(...$parameters) use ($then) {
            return $then(...$parameters);
        };
    }

}
