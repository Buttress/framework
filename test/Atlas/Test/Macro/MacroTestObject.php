<?php

namespace Buttress\Atlas\Test\Macro;

use Buttress\Support\Traits\Macro\MacroTrait;

class MacroTestObject
{

    use MacroTrait;

    public static function clearMacros()
    {
        static::$macro_map = array();
    }

}
