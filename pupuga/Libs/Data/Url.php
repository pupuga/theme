<?php

namespace Pupuga\Libs\Data;

class Url
{
	private $url;
	private $parse;

    public function __construct($url = null)
    {
    	$this->url = $url ?: $_SERVER['REQUEST_URI'];
    	$this->setParse();
    }

    public function getParse()
	{
		return $this->parse;
	}

    public function getHost()
    {
        return $this->parse['path'];
    }

    public function getQuery()
    {
	parse_str($this->parse['query'] ?? '', $query);

        return $query;
    }

    public function getPath()
    {
	    return explode('/',trim($this->parse['path'], '/'));
    }

    private function setParse()
    {
	    $this->parse = parse_url($this->url);
    }
}