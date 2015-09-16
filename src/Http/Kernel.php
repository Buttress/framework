<?php

namespace Buttress\Http;

use Buttress\Atlas\Http\Middleware\MiddlewareMap;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Kernel implements MiddlewareMap
{

    /**
     * This is the kernel, so in here we can do things like
     * @param \Psr\Http\Message\RequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param callable $next
     * @return mixed
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response, Callable $next)
    {
        return $next($request->withAttribute('buttress.dispatched', true), $response);
    }

}
