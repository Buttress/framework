<?php

namespace Atlas\Http\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface MiddlewareMap
{

    public function __call(RequestInterface $request, ResponseInterface $response, Callable $next): ResponseInterface;

}
