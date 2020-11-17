<?php

namespace Pupuga\Modules\CoolSpeed;

final class Init
{
    public function __construct()
    {
        if (strpos($_SERVER['REQUEST_URI'], '/wp-admin') === false && strpos($_SERVER['REQUEST_URI'], '/wp-login') === false && !current_user_can('administrator')) {
            $this->hooks();
        }
    }

    private function hooks()
    {
        new Hooks();
    }
}