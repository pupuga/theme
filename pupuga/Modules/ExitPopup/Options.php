<?php

namespace Pupuga\Modules\ExitPopup;

use Carbon_Fields\{Container, Field};

final class Options
{
    private static $instance = null;

    public static function app(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
        add_action( 'carbon_fields_register_fields', array( $this, 'addConfig' ) );
        add_action( 'carbon_fields_register_fields', array( $this, 'addLanguages' ) );
    }

    public function addConfig()
    {
        OptionsConfig::app();
    }

    public function addLanguages()
    {
        OptionsLanguagesFields::app();
    }
}