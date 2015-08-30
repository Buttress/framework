<?php

namespace Buttress\Atlas\Collection;

use Buttress\Atlas\Support\ArrayMap;

interface CollectionMap extends \Iterator, \Countable, ArrayMap
{

    /**
     * Add an item to this collection
     *
     * @param $mixed
     * @return void
     */
    public function add($mixed);

    /**
     * Add all items in an array
     *
     * @param mixed[] $mixed_array
     * @return void
     */
    public function addAll(array $mixed_array);

    /**
     * Returns `true` if collection contains `$mixed`
     *
     * @param $mixed
     * @return bool
     */
    public function contains($mixed): bool;

    /**
     * Returns `true` if collection contains all items in `$mixed_array`
     *
     * @param mixed[] $mixed_array
     * @return bool
     */
    public function containsAll(array $mixed_array): bool;

    /**
     * Remove all occurrences of `$mixed`
     *
     * @param $mixed
     * @return void
     */
    public function remove($mixed);

    /**
     * Remove all occurrences of all items in `$mixed_array`
     *
     * @param mixed[] $mixed_array
     * @return void
     */
    public function removeAll(array $mixed_array);

    /**
     * Get the size of the collection
     * @return int
     */
    public function count(): int;


}
