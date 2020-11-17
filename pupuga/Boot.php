<?php

namespace Pupuga;

use Pupuga\Core\Base;

class Boot
{
    private $version = '20200625';
    private $slugPrefix = 'pupuga_';

    private static $instance;

    static public function app()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
    
        return self::$instance;
    }

    private function __construct()
    {
        $this->setConstants();
        $this->autoload();
        $this->requireFiles();
    }

    private function setConstants()
    {
        define('RELEASE_VERSION', $this->version);
    	define('DIR_FRAMEWORK', __DIR__ . '/');
        define('SLUG_PREFIX', $this->slugPrefix);
        define('VERSION', $this->version);
        define('DIR_MAIN', dirname(DIR_FRAMEWORK) . '/');
        define('URL_MAIN', get_stylesheet_directory_uri() . '/');
        define('DIR_ASSETS', DIR_FRAMEWORK . 'assets/dist/');
        define('URL_ASSETS', URL_MAIN . 'pupuga/assets/');
        define('URL_ASSETS_DIST', URL_ASSETS . 'dist/');
        define('DIR_MODULES', DIR_FRAMEWORK . 'Modules/');
        define('URL_MODULES', URL_MAIN . 'pupuga/modules/');
        define('DIR_CUSTOM', DIR_FRAMEWORK . 'custom/');
        define('URL_CUSTOM', URL_MAIN . 'pupuga/custom/');
        define('DIR_TEMPLATES', DIR_FRAMEWORK . 'templates/');
    }

    private function autoload()
    {
    	require DIR_FRAMEWORK . 'vendor/autoload.php';
    }

    private function requireFiles()
    {
    	new Base\RequireClasses();
    }

}

Boot::app();