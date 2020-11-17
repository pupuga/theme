<?php

namespace Pupuga\Modules\ExitPopup;

use Pupuga\Modules\Woocommerce\Account as WoocommerceAccount;
use Pupuga\Libs\Files\Files;

final class Fields
{
    private static $instance;
    private $types;
    private $fields = array();
    private $set = '';

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
            __DIR__ . '/templates/fields',
            true,
            array('fields' => $this->setValue(Account::app()->getMeta())->get(), 'types' => $this->types));
    }

    public function getType()
    {
        return $this->types;
    }

    public function get(): array
    {
        return $this->fields;
    }

    public function setSimple(): self
    {
        if ($this->set != 'simple') {
            $this->loop(function ($class, $type) {
                $this->fields += $class::app()->get();
            });
            $this->set = 'simple';
        }

        return $this;
    }

    public function setValue($values): self
    {
        if ($this->set != 'value') {
            $this->loop(function ($class, $type) use ($values) {
                foreach ($class::app()->get() as $key => $field) {
                    $value = $values['_' . Config::app()->getPrefix() . $key][0];
                    $value = ($value == '' && $field['required']) ? $field['default'] : $value;
                    $class::app()->set($key, 'value', $value);
                }
                $this->fields[$type] = $class::app()->get();
            });

            $this->set = 'value';
        }

        return $this;
    }

    public function setFields(): self
    {
        if ($this->set != 'fields') {
            $this->loop(function ($class, $type) {
                $this->fields[$type] = $class::app()->get();
            });
            $this->set = 'fields';
        }

        return $this;
    }

    private function __construct()
    {
        $this->setTypes();
    }

    private function setTypes()
    {
        $this->types = array_flip(array_map(function ($value) {
            return $value . 'Fields';
        }, WoocommerceAccount::app()->getCustomMenuItems()));
    }

    private function loop($callback): array
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