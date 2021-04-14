<?php

namespace Pupuga\Modules\ExitPopup;

use Carbon_Fields\{Container, Field};

final class OptionsConfig
{
    private static $instance = null;
    private $languagesSlug;
    private $languages = array();

    public static function app(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getLanguages(): array
    {
        return $this->languages;
    }

    private function __construct()
    {
        $this->setLanguagesSlug();
        $this->setLanguages();
        $this->setCarbonFields();
    }

    private function setLanguagesSlug()
    {
        $this->languagesSlug = Config::app()->getPrefix() . 'languages';
    }

    private function setLanguages()
    {
        $this->languages = explode(',', strtolower(str_replace(' ', '', get_option("_{$this->languagesSlug}"))));
    }

    private function setCarbonFields()
    {
        Container::make( 'theme_options', Config::app()->getMain(), __( 'PopUp' ))
            ->set_icon( 'dashicons-clock' )
            ->add_tab('Config', array(
                Field::make( 'text', Config::app()->getPrefix() . 'popup_server', 'Popup server'),
                Field::make( 'text', $this->languagesSlug, 'Languages' )
            ))
            ->add_tab('Styles', array(
                Field::make( 'image', Config::app()->getPrefix() . 'default_timer_image', 'Default timer image')
                    ->set_classes('cf-field--half'),
                Field::make( 'image', Config::app()->getPrefix() . 'default_code_image', 'Default code image' )
                    ->set_classes('cf-field--half')
            ))
            ->add_fields( array(
                Field::make( 'text', 'crb_text', 'Text Field' ),
            ));
    }
}