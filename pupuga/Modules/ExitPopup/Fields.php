<?php

namespace Pupuga\Modules\ExitPopup;

use Pupuga\Modules\Woocommerce\Account as WoocommerceAccount;
use Pupuga\Libs\Files\Files;

final class Fields
{
    private static $instance;
    private $types;
    private $fields = array();

    public static function app(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getHtml(): string
    {
        return Files::getTemplate(
            __DIR__ . '/templates/page',
            true,
            array('fields' => $this->get(), 'types' => $this->types));
    }

    public function getType()
    {
        return $this->types;
    }

    public function get(): array
    {
        return $this->fields;
    }

    private function __construct()
    {
        $this->setTypes();
        $this->set();
    }

    private function setTypes()
    {
        $this->types = array_flip(array_map(function ($value) {
            return $value . 'Fields';
        }, WoocommerceAccount::app()->getCustomMenuItems()));
    }

    private function set()
    {
        $values = Account::app()->getMeta();
        $this->loop(function ($class, $type) use ($values) {
            if($class::app()->getRepeat()) {
                $this->repeat($class, $values);
            } else {
                $this->once($class, $values);
            }
            $this->fields[$type] = $class::app()->get();
        });
    }

    private function once($class, $values)
    {
        foreach ($class::app()->get() as $key => $field) {
            $value = (isset($values['_' . Config::app()->getPrefix() . $key][0])) ? $values['_' . Config::app()->getPrefix() . $key][0] : '';
            $value = ($field['type'] == 'image' && $value) ? wp_upload_dir()['baseurl'] . $value : $value;
            $value = ($value == '' && $field['required']) ? $field['default'] : $value;
            $class::app()->set($key, 'value', $value);
        }
    }

    private function repeat($class, $values)
    {
        $fields = array();
        foreach ($class::app()->getRepeat() as $item) {
            foreach ($class::app()->get() as $key => $field) {
                $default = $key . '_default_' . $item;
                $key = $key . '_' . $item;
                $field['default'] = carbon_get_theme_option( Config::app()->getPrefix() . $default);
                $value = isset($values['_' . Config::app()->getPrefix() . $key][0]) ? $values['_' . Config::app()->getPrefix() . $key][0] : '';
                $field['value'] = ($value == '' && $field['required']) ? $field['default'] : $value;
                $field['marker'] = $item;
                $fields[$key] = $field;
            }
        }

        $class::app()->clear();
        $class::app()->set($fields);
    }

    private function loop(\Closure $callback): array
    {
        $this->fields = array();
        if ($this->types) {
            foreach ($this->types as $type => $menu) {
                $class = __NAMESPACE__ . '\\' . ucfirst($type);
                $callback($class, $type);
            }
        }

        return $this->fields;
    }

}