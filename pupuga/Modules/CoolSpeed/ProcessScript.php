<?php

namespace Pupuga\Modules\CoolSpeed;

class ProcessScript  implements IProcess
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
        $this->dev = (isset(Config::app()->get('parse')['script']['dev']) && is_array(Config::app()->get('parse')['script']['dev']) && count(Config::app()->get('parse')['script']['dev']))
            ? Config::app()->get('parse')['script']['dev'] : array();
        $this->path = (isset(Config::app()->get('parse')['script']['path']) && is_array(Config::app()->get('parse')['script']['path']) && count(Config::app()->get('parse')['script']['path']))
            ? Config::app()->get('parse')['script']['path'] : array();
    }

    public function getData()
    {
        if (count($this->dev)) {
            $this->actionDevMode();
        } else {
            $this
                ->loadFile()
                ->minimize();
        }

        return $this->data;
    }

    private function actionDevMode()
    {
        foreach ($this->dev as $path) {
            if (strpos($this->source->getWithoutGetParams(), $path) === false) {
                $this
                    ->loadFile()
                    ->minimize();
                break;
            } elseif (!Config::app()->get('mode')['dev']) {
                $this->loadFile();
            }
        }
    }

    private function loadFile()
    {
        $this->data = file_get_contents($this->file);

        return $this;
    }

    private function minimize()
    {
/*        $this->data = (new JSqueeze())->squeeze(
            $this->data,
            true,
            true,
            false
        );*/

        return $this;
    }
}