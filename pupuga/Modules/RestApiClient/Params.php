<?php

namespace Pupuga\Modules\RestApiClient;

class Params
{
    public static $instance;
    private $config;

    private function __construct()
    {
        $this->config = new ParamsStdClass;
	    $this->config->title = 'Rest Client';
	    $this->config->slug = SLUG_PREFIX . strtolower(str_replace(' ', '-', $this->config->title));
	    $this->config->serverPoint = 'rest-api';
	    $this->config->serverVersion = 'v1';
	    $this->config->namespace = __NAMESPACE__;
    }

    public function __set($name, $value)
    {
        $this->config->$name = $value;

        return $this->config;
    }

    static public function app() : self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getConfig()
    {
        return $this->config;
    }
}
