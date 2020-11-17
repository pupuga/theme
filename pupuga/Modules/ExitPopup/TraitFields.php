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

    public function set($key, $property, $value): void
    {
        $this->fields[$key][$property] = $value;
    }

    public function get(): array
    {
        return $this->fields;
    }
}