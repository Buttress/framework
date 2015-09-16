<?php

namespace Buttress\Atlas\Http\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface MiddlewareMap
{

    public function __invoke(RequestInterface $request, ResponseInterface $response, Callable $next);

}
