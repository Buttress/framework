<?php

namespace Buttress\Atlas\Test\Iterator;

class IteratorTraitTest extends \PHPUnit_Framework_TestCase
{

    public function testIterator()
    {
        $subject = range(10, 100);
        $iterator = new IteratorTestObject($subject);

        $subject_keys = array_keys($subject);

        $iterator_works = true;

        for ($iterator->rewind(); $iterator->valid(); $iterator->next()) {
            $key = $iterator->key();
            $subject_key = array_shift($subject_keys);
            $subject_value = array_shift($subject);

            if ($key !== $subject_key || $iterator->current() !== $subject_value) {
                $iterator_works = false;
                break;
            }
        }

        $this->assertTrue($iterator_works, "Iterator not properly iterating.");

    }

    public function testNext()
    {
        $iterator = new IteratorTestObject(range(0, 10));

        $this->assertEquals(0, $iterator->current());

        $iterator->next();

        $this->assertEquals(1, $iterator->current());
    }

}
