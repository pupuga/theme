<?php

namespace Pupuga\Custom\MediaData\FieldsPost;

namespace Pupuga\Core\Init;

trait InstanceTrait
{
    public static $instance = null;

    public static function app(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}