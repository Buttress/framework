<?php
namespace Buttress\Atlas\Logger\Driver;

interface LoggerDriverMap
{

     /**
      * @param string $level
      * @param string $message
      * @param array $context
      * @return null
      */
     public function log(string $level, string $message, array $context = array());

}
