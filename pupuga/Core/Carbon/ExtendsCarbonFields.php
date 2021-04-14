<?php

namespace Pupuga\Core\Carbon;

use Carbon_Fields\Field;

class ExtendsCarbonFields
{

    private static $instance;

    private function __construct()
    {
    }

    /**
     * @return $this
     */
    public static function app()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param string $type
     * @param string $name
     * @param string | null $label
     * @param string $class
     *
     * @return mixed
     */
    public function make($type, $name, $label = null, $class = '')
    {
        $method = (method_exists($this, $type)) ? $type : 'default';
        $field = $this->$method($type, $name, $label);
        $class = "pupuga-field--{$type} {$class}";
        $field->set_classes($class);

        return $field;
    }

    private function default($type, $name, $label)
    {
        switch ($type) {
            case 'config' :
                $type = 'textarea';
                break;
        }
        $field = Field::make($type, $name, $label);

        return $field;
    }
}