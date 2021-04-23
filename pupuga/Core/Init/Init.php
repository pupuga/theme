<?php

namespace Pupuga\Core\Init;

use Pupuga\Config;
use Pupuga\Core\Base\Common;
use Pupuga\Libs\Files;

class Init extends Config
{
    public function __construct()
    {
        parent::__construct();
        Common::app()->config = $this->config;
        Files\Classes::launchClasses($this->getInitClasses(), __NAMESPACE__, true);
    }

    private function getInitClasses()
    {
        switch ($this->config['mode']) {
            case 'theme':
                $classes = array('SetCommon', 'Correct', 'Media', 'SetConfig', 'PageMain', 'PageLogin', 'PageAdmin');
                break;
            case 'modules':
                $classes = array('SetCommon', 'Media', 'SetConfig', 'PageMain', 'PageAdmin');
                break;
            case 'restapi':
                $classes = array('SetCommon', 'Correct', 'Media', 'SetConfig', 'PageLogin', 'PageAdmin');
                break;
            default:
                $classes = $this->config['mode'];
                break;
        }

        return $classes;
    }
}