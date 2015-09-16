<?php
namespace Buttress\Atlas\Pipeline;

interface PipelineMap
{
    /**
     * The parameters to pipe through
     *
     * @param ...$parameters
     * @return \Buttress\Atlas\Pipeline\PipelineMap
     */
    public function pipe(...$parameters): \Buttress\Atlas\Pipeline\PipelineMap;

    /**
     * The list of pipes that the parameters will fall through
     * Pipe should match function($parameter..., \Closure $next) {}
     *
     * @param \Closure[] $pipes
     * @return \Buttress\Atlas\Pipeline\PipelineMap
     */
    public function through($pipes): \Buttress\Atlas\Pipeline\PipelineMap;

    public function then(callable $then): \Buttress\Atlas\Pipeline\PipelineMap;

    public function execute();
}
