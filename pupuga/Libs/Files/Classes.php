<?php

namespace Pupuga\Libs\Files;

class Classes
{
    public static function launchClasses($classes, $namespace, $static = false, $init = '')
    {
        if (count($classes)) {
            $init = (empty($init)) ? '' : '\\' . $init;
            foreach ($classes as $class) {
                $class = $namespace . '\\' . $class . $init;
                if ($static) {
                    $class::app();
                } else {
                    new $class;
                }
            }
        }
    }
}