<?php
namespace Buttress\Support\Traits\Macro;
use Buttress\Atlas\Exception\BadMethodCallExceptionMap;

class MacroNotFoundException extends \BadMethodCallException implements BadMethodCallExceptionMap
{

}
