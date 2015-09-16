<?php

namespace Buttress\Http;

use Buttress\Pipeline\Pipeline;
use Buttress\Http\Kernel;
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

    /**
     * Add a middleware closure to the stack,
     * The request will pass through each middleware in order, then through the kernel, then back through
     * the middleware in reverse order.
     *
     * This MUST either return $next($request, $response) or [ $request, $response ]
     * @param \Closure $middleware
     */
    public function addMiddleware(\Closure $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    protected function normalizeKernel($kernel)
    {
        return $kernel ?: new Kernel;
    }

    /**
     * Handle a request, returns the request and response array.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return array [\Psr\Http\Message\ServerRequestInterface, \Psr\Http\Message\ResponseInterface]
     */
    public function handleRequest(ServerRequestInterface $request, ResponseInterface $response)
    {
        $middleware = $this->getMiddlewares();
        $kernel = $this->normalizeKernel($this->getKernel());
        $stack = array_merge(array_values($middleware), [$kernel], array_reverse($middleware));

        return (new Pipeline())
            ->pipe($request, $response)
            ->through($stack)
            ->then(function ($request, ResponseInterface $response) {
                if ($response->getBody()->getSize() == 0 && $response->getStatusCode() == 200) {
                    $response = $response->withStatus(204, 'No Content');
                }

                return array($request, $response);
            })->execute();
    }

}
