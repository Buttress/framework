<?php

namespace Buttress\Support\Traits\Manager;

use Buttress\Atlas\Container\ContainerTrait;

trait ManagerTrait
{

    use ContainerTrait;

    protected $manager_default_key;

    /**
     * @return mixed
     */
    public function getManagerDefaultKey()
    {
        return $this->manager_default_key;
    }

    /**
     * @param mixed $manager_default_key
     */
    public function setManagerDefaultKey($manager_default_key)
    {
        $this->manager_default_key = $manager_default_key;
    }

    /**
     * Get the default key for this manager
     * @return mixed
     */
    public function getDefaultKey()
    {
        return $this->getManagerDefaultKey();
    }

    /**
     * Get the default value for this manager
     * @return mixed
     */
    public function getDefault()
    {
        return $this->get($this->getDefaultKey());
    }

}
