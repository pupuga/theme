<?php

namespace Pupuga\Libs\Files;

class Classes
{
    public static function launchClasses($classes, $namespace, $init = false)
    {
        if (count($classes)) {
            $init = ($init) ? '\\' . $init : '';
            foreach ($classes as $class) {
                $class = $namespace . '\\' . $class . $init;
                new $class;
            }
        }
    }
}