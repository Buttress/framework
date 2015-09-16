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
     * @type \Closure The "then" closure, it will receive the parameters you pipe through
     */
    protected $thenClosure;

    /**
     * @inheritdoc
     */
    public function send(...$parameters) : PipelineMap
    {
        $this->parameters = $parameters;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function through($pipes) : PipelineMap
    {
        $this->pipes = is_array($pipes) ? $pipes : func_get_args();
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function then(callable $then) : PipelineMap
    {
        $this->then = $then;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        $pipes = array_reverse($this->pipes);

        /** @type \Closure $linked_closure */
        $linked_closure = array_reduce($pipes, $this->getIterator(), $this->getInitial($then));

        return $linked_closure(...$this->parameters);
    }

    /**
     * Get the iterator closure, this wraps every item in the list and injects the
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

    /**
     * The initial closure,
     */
    protected function getInitial(\Closure $then)
    {
        return function(...$parameters) use ($then) {
            return $then(...$parameters);
        };
    }

}
