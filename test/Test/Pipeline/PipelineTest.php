<?php

namespace Buttress\Test\Pipeline;

use Buttress\Pipeline\Pipeline;

class PipelineTest extends \PHPUnit_Framework_TestCase
{

    public function testSingleParameterPipeline()
    {
        $pipeline = [];

        $pipes = [
            function($array, $next) use (&$pipeline) {
                $pipeline[] = 'Pipe 1';

                $array[] = 1;
                return $next($array);
            },
            function($array, $next) use (&$pipeline) {
                $pipeline[] = 'Pipe 2';

                $array[] = 2;
                return $next($array);
            },
            function($array, $next) use (&$pipeline) {
                $pipeline[] = 'Pipe 3';

                $array[] = 3;
                return $next($array);
            },
            function($array, $next) use (&$pipeline) {
                $pipeline[] = 'Pipe 4';

                $array[] = 4;
                return $next($array);
            }
        ];

        (new Pipeline())->send([])->through($pipes)->then(function($result) use (&$pipeline) {
            $pipeline[] = 'Then';
            $this->assertEquals([1,2,3,4], $result);
        })->execute();

        $this->assertEquals([
            'Pipe 1',
            'Pipe 2',
            'Pipe 3',
            'Pipe 4',
            'Then'
        ], $pipeline);
    }

    public function testMultipleParameterPipeline()
    {
        $pipes = [
            function($first, $second, $next) {
                $first[] = 1;
                $second[] = 'a';
                return $next($first, $second);
            },
            function($first, $second, $next) {
                $first[] = 2;
                $second[] = 'b';
                return $next($first, $second);
            },
            function($first, $second, $next) {
                $first[] = 3;
                $second[] = 'c';
                return $next($first, $second);
            },
            function($first, $second, $next) {
                $first[] = 4;
                $second[] = 'd';
                return $next($first, $second);
            }
        ];

        (new Pipeline())->send([], [])->through($pipes)->then(function($first, $second) {
            $this->assertEquals([1,2,3,4], $first);
            $this->assertEquals(['a','b','c','d'], $second);
        })->execute();
    }

    public function testReturnPath()
    {
        $pipes = [
            function($next) {
                return $next();
            },
            function($next) {
                return $next();
            },
            function($next) {
                return "breakout";
            },
            function($next) {
                return "This shouldn't be triggered.";
            }
        ];

        $triggered = false;
        $result = (new Pipeline())->through($pipes)->then(function() use (&$triggered) {
            $triggered = true;

            return false;
        })->execute();

        $this->assertFalse($triggered, 'The then function fired.');
        $this->assertEquals($result, 'breakout');
    }

}
