<?php
namespace Buttress\Support\Traits\Container;

use Buttress\Support\Traits\Iterator\IteratorTrait;

trait ContainerTrait
{

    use IteratorTrait;

    protected $container_map = [];

    /**
     * Retrieve a value named `$item` from the container
     * @param $item
     * @return mixed
     */
    public function get($item)
    {
        return $this->containerGet($item);
    }

    /**
     * Internal getter
     * @param $item
     */
    protected function containerGet($item)
    {
        return $this->container_map[$item];
    }

    /**
     * Set `$item` to `$value` in the container
     * @param $item
     * @param $value
     */
    public function set($item, $value)
    {
        $this->containerSet($item, $value);
    }

    /**
     * Internal getter
     * @param $item
     * @param $value
     */
    protected function containerSet($item, $value)
    {
        $this->container_map[$item] = $value;
        if (is_null($value)) {
            unset($this->container_map[$item]);
        }
    }

    /**
     * Returns `true` if container contains item `$name`
     * @param $name
     * @return bool
     */
    public function has($item): bool
    {
        return $this->containerHas($item);
    }

    /**
     * Internal Has
     * @param $item
     * @return bool
     */
    protected function containerHas($item): bool
    {
        return isset($this->container_map[$item]);
    }

    /**
     * @inheritdoc
     */
    protected function getIteratorSubject()
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return $this->containerToArray();
    }

    protected function containerToArray(): array
    {
        return (array) $this->container_map;
    }

    /**
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        $this->set($offset, null);
    }

}
