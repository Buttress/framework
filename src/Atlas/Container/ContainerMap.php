<?php
namespace Buttress\Atlas\Container;

interface ContainerMap extends \ArrayAccess, \Iterator
{

    /**
     * Retrieve a value named `$item` from the container
     * @param $name
     * @return mixed
     */
    public function get($item)/*: mixed */;

    /**
     * Returns `true` if container contains item `$name`
     * @param $name
     * @return bool
     */
    public function has($item): bool;

}
