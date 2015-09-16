<?php

namespace Test\Http;

use Buttress\Http\RequestHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\Server;
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

                $next($request, $response);
            }
        ];

        $request_handler = new RequestHandler();
        $request_handler->setKernel(function(ServerRequestInterface $request, ResponseInterface $response, \Closure $next) {
            // We're in the middle of the onion, make sure that test is true.
            $this->assertEquals('set', $request->getAttribute('test'));
        });

        $request_handler->setMiddlewares($pipes);

        $this->sendTestRequest($request_handler, function(ServerRequest $request, ResponseInterface $response) {
            // We're on the response side of the onion now, make sure test is 'unset'
            $this->assertEquals('unset', $request->getAttribute('test'));
        });
    }

    public function sendTestRequest(RequestHandler $request_handler, \Closure $handler)
    {
        $request = new ServerRequest();
        $response = new Response();

        $request_handler->handleRequest($request, $response, $handler);
    }

    public function testEmptyExecution()
    {
        $this->sendTestRequest(new RequestHandler(), function(ServerRequestInterface $request) {
            $this->assertTrue($request->getAttribute('buttress.dispatched'));
        });
    }

}
