<?php

namespace Pupuga\Modules\Woocommerce;

class Redirect
{
    private static $instance;

    static public function app(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
        add_filter('woocommerce_login_redirect', array($this, 'login'), 77777, 2);
    }

    public function login($redirect, $user)
    {
        return AccountPage::app()->get()->startUrl;
    }

}