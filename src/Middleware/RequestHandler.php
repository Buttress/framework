<?php
namespace Middleware;

use Atlas\Http\Middleware\MiddlewareMap;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class RequestHandler
{

    /**
     * The middleware instances
     *
     * @type MiddlewareMap[][]
     */
    protected $middleware = [ "before" => [], "after" => [] ];

    public function handle(RequestInterface $request, ResponseInterface $response) : ResponseInterface
    {
        $before_middleware = $this->middleware['before'];

        $result = $this->handleMiddleware($before_middleware);
    }

    /**
     * @param MiddlewareMap[] $stack
     */
    protected function handleMiddleware(array $stack, RequestInterface $request, ResponseInterface $response, $pointer = 0)
    {
        if (isset($stack[$pointer])) {
            $middleware = $stack[$pointer];
        } else {
            $middleware = function(...$arguments) {
                $this->
            };
        }

        return $middleware($request, $response, function($request, $response) use ($stack, $pointer) {
            $this->handleMiddleware($stack, $request, $response, $pointer + 1);
        });
    }

}
