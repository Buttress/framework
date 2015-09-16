<?php

namespace Buttress\Http;

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
     * @return mixed
     */
    public function getKernel()
    {
        return $this->kernel;
    }

    /**
     * @param mixed $kernel
     */
    public function setKernel($kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @return \Closure[]
     */
    public function getMiddlewares()
    {
        return $this->middlewares;
    }

    /**
     * @param \Closure[] $middlewares
     */
    public function setMiddlewares($middlewares)
    {
        $this->middlewares = $middlewares;
    }

    protected function normalizeKernel($kernel)
    {
        return $kernel ?: function (ServerRequestInterface $request, ResponseInterface $response, $next) {
            $next($request->withAttribute('buttress.dispatched', true), $response);
        };
    }

    /**
     * @param $request
     * @param $response
     */
    public function handleRequest(
        ServerRequestInterface $request,
        ResponseInterface $response,
        \Closure $handler)
    {
        $middleware = $this->getMiddlewares();
        $kernel = $this->normalizeKernel($this->getKernel());
        $stack = array_merge(array_values($middleware), [$kernel], array_reverse($middleware));

        (new Pipeline())
            ->pipe($request, $response)
            ->through($stack)
            ->then(function ($request, $response) use ($handler) {
                $handler($request, $response);
            })->execute();
    }

}
