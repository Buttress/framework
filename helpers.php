<?php
namespace {

    if (!function_exists('dd')) {
        function dd(...$params)
        {
            var_dump(...$params);
            exit;
        }
    }

    if (!function_exists('new_instance')) {

        /**
         * @param $mixed
         * @return $mixed Returns an instance of $mixed
         */
        function new_instance($mixed, ...$params)
        {
            if (is_callable($mixed)) {
                return new_instance($mixed(), ...$params);
            }

            if (is_array($mixed)) {
                return new_instance(implode("\\", $mixed), ...$params);
            }

            if (is_object($mixed)) {
                return new_instance(get_class($mixed), ...$params);
            }

            $mixed = (string)$mixed;
            return new $mixed(...$params);
        }

    }

}
