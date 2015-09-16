<?php

namespace Buttress\Test\Atlas\Container;

use Buttress\Atlas\Container\ContainerMap;
use Buttress\Support\Traits\Container\ContainerTrait;

class ContainerTraitTest extends \PHPUnit_Framework_TestCase
{

    /** @type ContainerTrait */
    protected $container;

    protected function setUp()
    {
        $this->container = new class implements ContainerMap {
            use ContainerTrait;
        };
    }

    protected function tearDown()
    {
        $this->container = null;
    }

    public function testContainerIterator()
    {
        $test = [
            ['test', 'value'],
            ['test2', 'value2'],
            ['test3', 'value3']
        ];

        foreach ($test as $set) {
            list($key, $value) = $set;
            $this->container->set($key, $value);
        }

        $worked = true;
        foreach ($this->container as $key => $value) {
            list($test_key, $test_value) = array_shift($test);

            if ($test_key !== $key || $test_value !== $value) {
                $worked = false;
                break;
            }
        }

        $this->assertTrue($worked && !$test, "Iterator failed.");
    }


    public function testContainerArrayAccess()
    {
        $test = [
            ['test', 'value'],
            ['test2', 'value2'],
            ['test3', 'value3']
        ];

        foreach ($test as $set) {
            list($key, $value) = $set;
            $this->container[$key] = $value;
        }

        $worked = true;
        foreach ($test as $set) {
            list($key, $value) = $set;

            if (!isset($this->container[$key])) {
                $worked = false;
                break;
            }

            $array_access_value = $this->container[$key];
            if ($array_access_value !== $value) {
                $worked = false;
                break;
            }
        }

        $this->assertTrue($worked, "Array Access failed.");

        foreach ($test as $set) {
            list($key,) = $set;

            unset($this->container[$key]);
            $worked = $worked && !$this->container->has($key);
        }
    }

    public function testContainerUnset()
    {
        $test = uniqid();
        $this->assertFalse($this->container->has($test), 'Container should be empty!');

        $this->container->set($test, 'test');

        $this->assertTrue($this->container->has($test), 'Container should contain test key!');

        $this->container->set($test, null);

        $this->assertFalse($this->container->has($test), 'Container unset failed.');
    }

}
