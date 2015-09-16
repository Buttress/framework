<?php

namespace Http;

use Buttress\Pipeline\Pipeline;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RequestHandler
{

    protected $kernel;

    /**
     * The middlewares, the requests will pass through each of these in order, then in reverse order.
     * @type \Closure[]
     */
    protected $middlewares = [];

    /**
     * @param $request
     * @param $response
     */
    public function handleRequest(
        ServerRequestInterface $request,
        ResponseInterface $response,
        \Closure $handler): ResponseInterface
    {
        $middleware = $this->middlewares;
        $stack = array_merge(array_values($middleware), array_reverse($middleware));

        (new Pipeline())->pipe($request, $response)->through($stack)->then(function($request, $response) use ($handler) {
            $handler($request, $response);
        });
    }

}
