<?php

namespace Pupuga\Core\Carbon;

class RegisterCarbonFieldsHelper
{
    private $object;
    private $method;

    public function __construct($object, $method = 'registerCarbonFields')
    {
        $this->object = $object;
        $this->method = $method;
        $this->hook();
    }

    protected function hook()
    {
        add_action('carbon_fields_register_fields', array($this->object, $this->method));
    }
}