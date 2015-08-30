<?php
namespace Buttress\Atlas\Provider\Manager;

interface ProviderManagerMap
{

    /**
     * Add a provider
     * @param mixed $mixed
     * @return ProviderMap|null
     */
    public function add($mixed);

    /**
     * Register the added providers
     * @param $mixed
     * @return void
     */
    public function register();

}
