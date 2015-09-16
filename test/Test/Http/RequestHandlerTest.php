<?php

namespace Test\Http;

use Buttress\Http\RequestHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;

class RequestHandlerTest extends \PHPUnit_Framework_TestCase
{

    public function testKernelOrder()
    {
        $counts = [];
        $pipes = [
            function(ServerRequestInterface $request, ResponseInterface $response, \Closure $next) use ($counts) {
                if ($request->getAttribute('test')) {
                    $request = $request->withAttribute('test', 'unset');
                } else {
                    $request = $request->withAttribute('test', 'set');
                }

                return $next($request, $response);
            }
        ];

        $request_handler = new RequestHandler();
        $request_handler->setKernel(function(ServerRequestInterface $request, ResponseInterface $response, \Closure $next) {
            // We're in the middle of the onion, make sure that test is true.
            $this->assertEquals('set', $request->getAttribute('test'));

            return $next($request, $response);
        });

        $request_handler->setMiddlewares($pipes);
        list($request, $response) = $this->sendTestRequest($request_handler);

        $this->assertEquals('unset', $request->getAttribute('test'));
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
