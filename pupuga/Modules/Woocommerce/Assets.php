<?php

namespace Pupuga\Modules\Woocommerce;

use Pupuga\Core\Load\StylesScripts;

class Assets
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
        $this->add();
    }

    public function add(): void
    {
        $enqueues = array(
            'scripts' => array(
                'script-account' => 'account.js',
            ),
            'styles' => array(
                'style-account' => 'account.css',
            )
        );
        StylesScripts::app()->requireStylesScripts($enqueues);
    }

}