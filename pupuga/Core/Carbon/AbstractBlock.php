<?php

namespace Pupuga\Core\Carbon;

use Carbon_Fields\Block;
use Pupuga\Libs\Files\Files;

abstract class AbstractBlock
{
    protected $class = array();
    protected $title;
    protected $prefix;
    protected $icon;
    protected $template;
    protected $data;

    abstract protected function addFields(): array;

    public function __construct()
    {
        add_action('carbon_fields_register_fields', array($this, 'addBlock'));
    }

    public function addBlock(): void
    {
        $this->setClass();
        $this->setPrefix();
        $this->setIcon();
        Block::make($this->title)
            ->add_fields($this->addFields())
            ->set_icon($this->icon)
            ->set_render_callback(function ($fields, $attributes) {
                if (!is_admin()) {
                    $this->setDefault();
                    $this->setTemplate();
                    $this->setFields($fields);
                    $this->setAttributes($attributes);
                    $this->customCallback();
                    $this->render();
                }
            });
    }

    protected function setDefault()
    {
        $this->data = new \stdClass;
    }

    protected function setClass()
    {
        $this->class['parts'] = explode('/', (new \ReflectionClass(get_class($this)))->getFileName());
        $this->class['count'] = count($this->class['parts']);
        $this->class['name'] = lcfirst(explode('.', $this->class['parts'][$this->class['count'] - 1])[0]);
        $this->class['path'] = implode('/', array_slice($this->class['parts'], 0, $this->class['count'] - 1)) . '/';
    }

    protected function setPrefix()
    {
        $this->prefix = ($this->prefix ?? $this->class['name']) . '_block_';
    }

    protected function setIcon()
    {
        $this->icon = $this->icon ?? 'table-row-before';
    }

    protected function setTemplate()
    {
        $this->template = $this->template ?? $this->class['path'] . 'templates/' . $this->class['name'];
    }

    protected function setFields($fields): void
    {
        if ($fields) {
            foreach ($fields as $key => $value) {
                $property = str_replace($this->prefix, '', $key);
                $this->data->$property = $value;
            }
        }
    }

    protected function setAttributes($attributes): void
    {
        $this->data->attributes = $attributes;
    }

    protected function customCallback(): void
    {
    }

    protected function render(): void
    {
        Files::getTemplate($this->template, true, $this->data);
    }
}