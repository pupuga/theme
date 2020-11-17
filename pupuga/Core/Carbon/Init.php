<?php

namespace Pupuga\Core\Carbon;

use Pupuga;
use Pupuga\Core\Base;
use Carbon_Fields\Carbon_Fields;

class Init extends Pupuga\Config
{

    private $widgets = array(
        'WidgetVisualEditor'
    );

    use Base\VerifyVar;

    public function __construct()
    {

        parent::__construct();

        add_action('after_setup_theme', array($this, 'loadCarbonFields'));

        if (is_array($this->config['registerCarbonFields']) && count($this->config['registerCarbonFields']) > 0) {
            add_action('carbon_fields_register_fields', array($this, 'registerCarbonFields'));
        }

        if (count($this->widgets) > 0) {
           add_action('carbon_fields_register_fields', array($this, 'loadWidgets'));
        }
    }

    public function loadCarbonFields()
    {
        Carbon_Fields::boot();
    }

    public function registerCarbonFields()
    {
        foreach ($this->config['registerCarbonFields'] as $name => $config) {
            if ($config || (is_array($config) && count($config) > 0)) {
                $class = __NAMESPACE__ . '\Register' . ucfirst($name);
                $object = new $class();
                $object->register($config);
            }
        }
    }

    public function loadWidgets()
    {
        foreach ($this->widgets as $widget) {
            require_once __DIR__ . '/' . $widget . '.php';
        }
    }

}