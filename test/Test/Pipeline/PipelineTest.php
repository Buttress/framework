<?php

namespace Buttress\Test\Pipeline;

use Buttress\Pipeline\Pipeline;

class PipelineTest extends \PHPUnit_Framework_TestCase
{

    public function testSingleParameterPipeline()
    {
        $pipes = [
            function($array, $next) {
                $array[] = 1;
                $next($array);
            },
            function($array, $next) {
                $array[] = 2;
                $next($array);
            },
            function($array, $next) {
                $array[] = 3;
                $next($array);
            },
            function($array, $next) {
                $array[] = 4;
                $next($array);
            }
        ];

        (new Pipeline())->pipe([])->through($pipes)->then(function($result) {
            $this->assertEquals([1,2,3,4], $result);
        })->execute();
    }



    public function testMultipleParameterPipeline()
    {
        $pipes = [
            function($first, $second, $next) {
                $first[] = 1;
                $second[] = 'a';
                $next($first, $second);
            },
            function($first, $second, $next) {
                $first[] = 2;
                $second[] = 'b';
                $next($first, $second);
            },
            function($first, $second, $next) {
                $first[] = 3;
                $second[] = 'c';
                $next($first, $second);
            },
            function($first, $second, $next) {
                $first[] = 4;
                $second[] = 'd';
                $next($first, $second);
            }
        ];

        (new Pipeline())->pipe([], [])->through($pipes)->then(function($first, $second) {
            $this->assertEquals([1,2,3,4], $first);
            $this->assertEquals(['a','b','c','d'], $second);
        })->execute();
    }

}
