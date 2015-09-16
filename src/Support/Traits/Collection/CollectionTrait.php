<?php

namespace Buttress\Support\Traits\Collection;

use Buttress\Atlas\Iterator\IteratorTrait;

trait CollectionTrait
{

    use IteratorTrait;

    protected $collection_list = [];

    /**
     * @inheritdoc
     */
    protected function getIteratorSubject()
    {
        return $this->toArray();
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return $this->collection_list;
    }

    /**
     * Add an item to this collection
     *
     * @param $mixed
     * @return void
     */
    public function add($mixed)
    {
        $this->collection_list[] = $mixed;
    }

    /**
     * Add all items in an array
     *
     * @param mixed[] $mixed_array
     * @return void
     */
    public function addAll(array $mixed_array)
    {
        foreach ($mixed_array as $mixed) {
            $this->add($mixed);
        }
    }

    /**
     * Returns `true` if collection contains `$mixed`
     *
     * @param $mixed
     * @return bool
     */
    public function contains($mixed): bool
    {
        return $this->containsAll([$mixed]);
    }

    /**
     * Returns `true` if collection contains all items in `$mixed_array`
     *
     * @param array $mixed_array
     * @return bool
     */
    public function containsAll(array $mixed_array): bool
    {
        foreach ($mixed_array as $mixed) {
            if (!in_array($mixed, $this->collection_list)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Remove all occurrences of `$mixed`
     *
     * @param $mixed
     * @return void
     */
    public function remove($mixed)
    {
        $this->removeAll([$mixed]);
    }

    /**
     * Remove all occurrences of all items in `$mixed_array`
     *
     * @param array $mixed_array
     * @return void
     */
    public function removeAll(array $mixed_array)
    {
        $this->collection_list = array_filter($this->collection_list, function($mixed) use ($mixed_array): bool {
            return !in_array($mixed, $mixed_array);
        });
    }

    /**
     * Get the size of the collection
     * @return int
     */
    public function count(): int
    {
        return count($this->collection_list);
    }

}
