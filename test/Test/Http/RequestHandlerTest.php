<?php

namespace Test\Http;

use Buttress\Http\Kernel;
use Buttress\Http\RequestHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;

class RequestHandlerTest extends \PHPUnit_Framework_TestCase
{

    public function testKernelOrder()
    {
        $onion = [];
        $pipes = [
            function (ServerRequestInterface $request, ResponseInterface $response, \Closure $next) use (&$onion) {
                $onion[] = 'Middleware 1';

                if ($request->getAttribute('buttress.dispatched')) {
                    // This should be called sixth
                    $this->assertEquals(5, $request->getAttribute('test'));
                    return $next($request->withAttribute('test', 6), $response);
                }
                // This should be called first
                $this->assertNull($request->getAttribute('test'));
                return $next($request->withAttribute('test', 1), $response);
            },
            function (ServerRequestInterface $request, ResponseInterface $response, \Closure $next) use (&$onion) {
                $onion[] = 'Middleware 2';

                if ($request->getAttribute('buttress.dispatched')) {
                    // This should be called fifth
                    $this->assertEquals(4, $request->getAttribute('test'));
                    return $next($request->withAttribute('test', 5), $response);
                }

                // This should be called second
                $this->assertEquals(1, $request->getAttribute('test'));
                return $next($request->withAttribute('test', 2), $response);
            },
            function (ServerRequestInterface $request, ResponseInterface $response, \Closure $next) use (&$onion) {
                $onion[] = 'Middleware 3';

                if ($request->getAttribute('buttress.dispatched')) {
                    // This should be called fourth
                    $this->assertEquals(3, $request->getAttribute('test'), 'Third layer on the way out is off.');
                    return $next($request->withAttribute('test', 4), $response);
                }

                // This should be called third
                $this->assertEquals(2, $request->getAttribute('test'));
                return $next($request->withAttribute('test', 3), $response);
            },
        ];

        $request_handler = new RequestHandler();
        $request_handler->setKernel(function (ServerRequestInterface $request, ResponseInterface $response, \Closure $next) use (&$onion) {
            // We're in the middle of the onion, make sure that test is true.
            $this->assertEquals(3, $request->getAttribute('test'), 'Kernel is off');

            $onion[] = 'Kernel';

            $kernel = new Kernel();
            return $kernel($request, $response, $next);
        });

        $request_handler->setMiddlewares($pipes);
        list($request, $response) = $this->sendTestRequest($request_handler);

        $this->assertEquals(6, $request->getAttribute('test'));
        $this->assertEquals([
            'Middleware 1',
            "Middleware 2",
            "Middleware 3",
            "Kernel",
            "Middleware 3",
            "Middleware 2",
            "Middleware 1"],
            $onion);
    }

    public function sendTestRequest(RequestHandler $request_handler)
    {
        $request = new ServerRequest();
        $response = new Response();

        return $request_handler->handleRequest($request, $response);
    }

    public function testEmptyExecution()
    {
        list($request, $response) = $this->sendTestRequest(new RequestHandler());
        $this->assertTrue($request->getAttribute('buttress.dispatched'));
        $this->assertEquals(204, $response->getStatusCode());
    }

}
