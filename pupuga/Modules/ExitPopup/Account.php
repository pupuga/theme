<?php

namespace Pupuga\Modules\ExitPopup;

use Pupuga\Modules\ExitPopup\Fields;

class Account
{
    private $user;

    private static $instance;

    public static function app(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function get()
    {
        return $this->user;
    }

    public function getMeta()
    {
        return (isset($this->user->ID)) ? get_user_meta($this->user->ID) : array();
    }

    private function __construct()
    {
        $this->set();
    }

    private function set(): void
    {
        $this->user = wp_get_current_user();
    }
}