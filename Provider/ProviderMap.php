<?php
namespace Buttress\Atlas\Provider;

use Buttress\Atlas\Application\ApplicationMap;

interface ProviderMap
{

    /**
     * @return ApplicationMap|null
     */
    public function getApplication();

    /**
     * Run the methods required to
     * @return void
     */
    public function register();

}
