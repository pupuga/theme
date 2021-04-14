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
        foreach (Fields::app()->get() as $type => $typeFields) {
            foreach ($typeFields as $key => $field) {
                $fields[] = Field::make( 'text', $this->prefix . $key, $field['title'] . ((isset($field['marker'])) ? ' - ' . $field['marker'] : ''))
                    ->set_default_value($field['value']);
            }
        }

        return $fields;
    }
}