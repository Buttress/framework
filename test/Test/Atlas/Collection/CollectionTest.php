<?php

namespace Buttress\Test\Atlas\Collection;

use Buttress\Support\Traits\Collection\CollectionTrait;

class CollectionTest extends \PHPUnit_Framework_TestCase
{

    /** @type CollectionTrait */
    protected $collection;

    protected function setUp()
    {
        $this->collection = new class {

            use CollectionTrait;

            public function clear()
            {
                $this->collection_list = [];
            }
        };
    }

    protected function tearDown()
    {
        $this->collection->clear();
    }

    public function testCollectionAdd()
    {
        $item = uniqid();
        $this->assertFalse($this->collection->contains($item), 'Collection should be empty!');

        $this->collection->add($item);
        $this->assertTrue($this->collection->contains($item), 'Collection should contain the unqique item!');

        $this->collection->remove($item);
        $this->assertFalse($this->collection->contains($item), 'Collection should be empty!');
    }

    public function testIterator()
    {
        $this->collection->addAll(range(0, 9));
        $i = 0;

        for ($this->collection->rewind(); $this->collection->valid(); $this->collection->next()) {
            $i++;
        }

        $this->assertEquals($this->collection->count(), $i, 'Iterator not iterating properly.');
    }

}
