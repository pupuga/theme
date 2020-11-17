<?php

namespace Pupuga\Libs\Files;

class Resource
{
    protected $url;

    public function __construct($url)
    {
        $this->setUrl($url);
    }

    public function getWithoutGetParams()
    {
        return explode('?', $this->url)[0];
    }

    public function getName()
    {
        return array_pop(explode('/', $this->getWithoutGetParams()));
    }

    public function getExt()
    {
        return array_pop(explode('.', $this->getName()));
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getUrlFolder($length = 0)
    {
        $array = $this->getWithoutGetParams();
        $array = explode('/', $array);
        $array = array_slice($array, 0, count($array) - ($length + 1));

        return implode('/', $array) . '/';
    }

    public function getPath()
    {
        $path = urldecode($_SERVER['DOCUMENT_ROOT'] . explode($_SERVER['HTTP_HOST'], str_replace('/', DIRECTORY_SEPARATOR, $this->getWithoutGetParams()))[1]);

        return $path;
    }

    public function isExt($ext)
    {
        return in_array($this->getExt(), $ext);
    }

    protected function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }
}