<?php

namespace Pupuga\Modules\ExitPopup;

use Carbon_Fields\{Container, Field};

final class AccountExtension {

    private $title;
    private $prefix;
    private static $instance = null;

    private function __construct()
    {
        $this->title = Config::app()->getTitle();
        $this->prefix = Config::app()->getPrefix();
        add_action( 'carbon_fields_register_fields', array( $this, 'addContainer' ) );
    }

    public static function app(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function addContainer(): void
    {
        Container::make( 'user_meta', $this->title )
            ->add_fields($this->getFields());
    }

    private function getFields(): array
    {
        $fields = array();
        foreach (Fields::app()->setSimple()->get() as $key => $field) {
            $type = ($field['type'] == 'number' || $field['type'] == 'color' || $field['type'] == 'bool') ? 'text' : $field['type'];
            $fields[] = Field::make( $type, $this->prefix . $key, $field['title'] )
                ->set_default_value($field['value']);
        }

        return $fields;
    }
}