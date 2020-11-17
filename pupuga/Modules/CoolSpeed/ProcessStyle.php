<?php

namespace Pupuga\Modules\CoolSpeed;

class ProcessStyle implements IProcess
{
    private $source;
    private $data = false;
    private $dev;
    private $path;
    private $file;

    public function __construct($source, $file)
    {
        $this->source = $source;
        $this->file = $file;
        $this->dev = (isset(Config::app()->get('parse')['style']['dev']) && is_array(Config::app()->get('parse')['style']['dev']) && count(Config::app()->get('parse')['style']['dev']))
            ? Config::app()->get('parse')['style']['dev'] : array();
        $this->path = (isset(Config::app()->get('parse')['style']['path']) && is_array(Config::app()->get('parse')['style']['path']) && count(Config::app()->get('parse')['style']['path']))
            ? Config::app()->get('parse')['style']['path'] : array();
    }

    public function getData()
    {
        if (count($this->dev)) {
            $this->actionDevMode();
        } else {
            $this->minimize();
        }

        if (count($this->path)) {
            $this->actionChangingPathByPart();
        }

        return $this->data;
    }

    private function actionDevMode()
    {
        foreach ($this->dev as $path) {
            if (strpos($this->source->getWithoutGetParams(), $path) === false) {
                $this->data = file_get_contents($this->file);
                $this->minimize();
                break;
            } elseif (!Config::app()->get('mode')['dev']) {
                $this->data = file_get_contents($this->file);
            }
        }
    }

    private function minimize()
    {
        $this->data = preg_replace('/[\r\n]+(?![^(]*\))/', '', $this->data);
        $this->data = preg_replace('/\s*([:;{}])\s*/', '$1', $this->data);
        $this->data = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $this->data);
    }

    private function actionChangingPathByPart()
    {
        if (count($this->path)) {
            foreach ($this->path as $path => $changing) {
                if (strpos($this->source->getUrlFolder(), $path) !== false) {
                    $this->changingPath($changing);
                }
            }
        }
    }

    private function changingPath($changing)
    {
        if (count($changing)) {
            foreach ($changing as $path => $number) {
                $this->data = str_replace($path, $this->source->getUrlFolder($number), $this->data);
            }
        }
    }
}