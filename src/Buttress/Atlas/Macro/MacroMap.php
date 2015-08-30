<?php
namespace Buttress\Atlas\Macro;

/**
 * Interface MacroMap
 * @package Buttress\Atlas\Macro
 */
interface MacroMap
{

    /**
     * Add a macro to this class
     *
     * @param string $name
     * @param callable|null $callable
     * @return mixed
     */
    public static function macro(string $name, callable $callable);

    /**
     * Returns `true` if macro named `$name` exists
     *
     * @param \Buttress\Atlas\Macro\string $name
     * @return \Buttress\Atlas\Macro\bool
     */
    public static function macroExists(string $name): bool;

    /**
     * Calls the macro named `$named` with the parameters `$parameters` in instance scope
     * @param string $name
     * @param array $parameters
     * @return mixed
     */
    public function __call(string $name, array $parameters);

    /**
     * Calls the macro named `$named` with the parameters `$parameters` in static scope
     * @param \Buttress\Atlas\Macro\string $name
     * @param array $parameters
     * @return mixed
     */
    public function __callStatic(string $name, array $parameters);

}
