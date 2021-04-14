<?php

namespace Pupuga\Modules\ExitPopup;

trait TraitFields
{
    private static $instance;

    public static function app(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function set($key, $property = '', $value = ''): void
    {
        if ((is_array($key)) ) {
            $this->fields = $key;
        } elseif (is_array($property)) {
            $this->fields[$key] = $property;
        } else {
            $this->fields[$key][$property] = $value;
        }
    }

    public function get(): array
    {
        return $this->fields;
    }

    public function clear(): void
    {
        $this->fields = array();
    }

    public function getRepeat(): array
    {
        return ($this->repeat) ?? array();
    }
}