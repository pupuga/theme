<?php

namespace Pupuga\Core\Carbon;

use Carbon_Fields\Block;
use Pupuga\Libs\Files\Files;

abstract class AbstractBlock
{

    protected $title;
    protected $prefix;
    protected $icon;
    protected $templateType;
    protected $template;
    protected $data = array();

    abstract protected function addFields(): array;

    public function __construct()
    {
        add_action('carbon_fields_register_fields', array($this, 'addBlock'));
    }

    public function addBlock()
    {
        Block::make($this->title)
            ->add_fields($this->addFields())
            ->set_icon($this->icon)
            ->set_render_callback(function ($fields, $attributes) {
                if (!is_admin()) {
                    $this->customCallback($fields, $attributes);
                    $this->renderCallback($fields, $attributes);
                }
            });
    }

    protected function customCallback($fields, $attributes): void
    {
    }

    protected function renderCallback($fields, $attributes)
    {
        Files::getTemplate($this->template, true,
            array('fields' => $fields, 'attributes' => $attributes, 'data' => $this->data, 'templateType' => $this->templateType));
    }
}