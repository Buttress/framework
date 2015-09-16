<?php

namespace Buttress\Atlas\Test\Iterator;

use Buttress\Atlas\Support\ArrayMap;
use Buttress\Support\Traits\Iterator\IteratorTrait;

class IteratorTestObject implements \Iterator, ArrayMap
{

    use IteratorTrait;

    /**
     * @type IteratorTrait
     */
    protected $iterator_subject = [];

    /**
     * IteratorTestObject constructor.
     * @param $iterator_object
     */
    public function __construct(array $iterator_subject)
    {
        $this->iterator_subject = $iterator_subject;
    }

    /**
     * @inheritdoc
     */
    protected function getIteratorSubject()
    {
        return $this->iterator_subject;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return $this->iterator_subject;
    }

}
