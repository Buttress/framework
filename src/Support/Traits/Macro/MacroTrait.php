<?php
namespace Buttress\Support\Traits\Macro;

trait MacroTrait
{

    protected static $macro_map = [];

    /**
     * Add a macro to this class
     *
     * @param string $name
     * @param callable|null $callable
     * @return mixed
     */
    public static function macro(string $name, $callable)
    {
        static::$macro_map[$name] = $callable;
    }

    /**
     * Returns `true` if macro named `$name` exists
     *
     * @param \Buttress\Atlas\Macro\string $name
     * @return bool
     */
    public static function macroExists(string $name): bool
    {
        return isset(static::$macro_map[$name]);
    }

    /**
     * Calls the macro named `$named` with the parameters `$parameters` in instance scope
     * @param string $name
     * @param array $parameters
     * @return mixed
     */
    public function __call(string $name, array $parameters)
    {
        if (static::macroExists($name)) {
            $macro = static::$macro_map[$name];
            $callable = $macro;
            if ($macro instanceof \Closure) {
                $callable = $macro->bindTo(null, get_called_class());
            }

            return $callable(...$parameters);
        }

        $class = get_class($this);
        throw new MacroNotFoundException("Macro \"{$name}\" not found on class \"{$class}\".");
    }

    /**
     * Calls the macro named `$named` with the parameters `$parameters` in static scope
     * @param \Buttress\Atlas\Macro\string $name
     * @param array $parameters
     * @return mixed
     */
    public static function __callStatic(string $name, array $parameters)
    {
        if (static::macroExists($name)) {
            $macro = static::$macro_map[$name];
            $callable = $macro;
            if ($macro instanceof \Closure) {
                $callable = $macro->bindTo(null, get_called_class());
            }

            return $callable(...$parameters);
        }

        $class = get_called_class();
        throw new MacroNotFoundException("Macro \"{$name}\" not found on class \"{$class}\".");
    }

}
