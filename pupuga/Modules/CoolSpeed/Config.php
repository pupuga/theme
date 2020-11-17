<?php

namespace Pupuga\Modules\CoolSpeed;

final class Config
{
    private static $instance;
    private $config = array(
        'ver' => '1-beta',
        'mode' => array (
            'dev' => true,
            'exclude' => false,
            'encoding' => false
        ),
        'post-type' => array('page'),
        'parse' => array (
            'script' => array(
                'file' => array('tag' => 'script', 'source' => 'src', 'ext' => array('js'), 'path' => true),
                'dev' => array(
                    'themes/sravnizaimclient/pupuga/assets/dist/main.js'
                )
            ),
            'style' => array(
                'file' => array('tag' => 'link', 'source' => 'href', 'ext' => array('css'), 'path' => true),
                'dev' => array(
                    'themes/sravnizaimclient/pupuga/assets/dist/main.css'
                ),
            ),
            'img' => array(
                'file' => array('tag' => 'img', 'source' => 'src', 'ext' => array('jpg', 'png', 'svg'), 'path' => false),
            )
        ),
        'header' => array(
            'fonts' => array(
            ),
            'resources' => array(
            )
        )
    );

    private function __construct()
    {
    }

    /**
     * @return $this
     */
    public static function app()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function get($key = null)
    {
        return (is_null($key)) ? $this->config : $this->config[$key];
    }
}