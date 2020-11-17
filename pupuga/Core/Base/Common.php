<?php

namespace Pupuga\Core\Base;

class Common
{
    public $config;
    public $common;
    public $js = array();
	public $separateJs = array();
    private static $instance;

    private function __construct()
    {
    }

    /**
     * @return $this
     */
    public static function app()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function set($param, $value)
    {
        $this->common[$param] = $value;
    }

    public function get($param = '')
    {
        return (!empty($param) && isset($this->common[$param])) ? $this->common[$param] : $this->common;
    }

    /**
     * @param $js array
     *
     * @return $this
     */
    public function setJs($js)
    {
        $this->js = array_merge($this->js, $js);

        return $this;
    }

    public function setSeparateJs($key, $js)
    {
    	$this->separateJs[$key] = $js;
    }

    public function getJs()
    {
        return json_encode($this->js);
    }

	public function getSeparateJs($key)
	{
		return json_encode($this->separateJs[$key]);
	}
}