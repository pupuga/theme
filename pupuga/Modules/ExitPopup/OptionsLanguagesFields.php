<?php

namespace Pupuga\Modules\ExitPopup;

use Carbon_Fields\{Container, Field};

final class OptionsLanguagesFields
{
    private static $instance = null;
    private $container;

    public static function app(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
        $this->setContainer();
        $this->setFields();
    }


    private function setContainer(): void
    {
        $this->container = Container::make( 'theme_options', __( 'Languages' ) )
            ->set_page_parent('crb_carbon_fields_container_' . Config::app()->getMain() . '.php');
    }

    private function setFields(): void
    {
        if (OptionsConfig::app()->getLanguages()) {
            $fields = LanguagesFields::app()->get();
            if ($fields) {
                foreach (OptionsConfig::app()->getLanguages() as $lang) {
                    $this->container->add_tab(strtoupper($lang), $this->getCarbonFields($lang, $fields));
                }
            }
        }
    }

    private function getCarbonFields($lang, $fields): array
    {
        $langFields = array();
        foreach ($fields as $key => $field) {
            $object = Field::make('text', Config::app()->getPrefix() . $key . '_default_' . $lang, $field['title']);
            if (isset($field['adminOptionClass']) && !empty($field['adminOptionClass'])) {
                $object->set_classes($field['adminOptionClass']);
            }
            $langFields[] = $object->set_default_value($field['default']);
        }

        return $langFields;
    }

}