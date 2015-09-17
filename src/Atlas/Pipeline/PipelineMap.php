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
    public function send(...$parameters): \Buttress\Atlas\Pipeline\PipelineMap;

    /**
     * The list of pipes that the parameters will fall through
     * Pipe should match function($parameter..., \Closure $next) {}: $next($parameter...)
     *
     * @param \Closure[] $pipes
     * @return \Buttress\Atlas\Pipeline\PipelineMap
     */
    public function through($pipes): \Buttress\Atlas\Pipeline\PipelineMap;

    /**
     * The method to call last, the return of this method will be the return of $next() within the stack.
     *
     * @param callable $then
     * @return \Buttress\Atlas\Pipeline\PipelineMap
     */
    public function then(callable $then): \Buttress\Atlas\Pipeline\PipelineMap;

    /**
     * Send the parameters through the pipeline and return the results
     * @return mixed
     */
    public function execute();
}
