<?php

namespace Pupuga\Core\Load;

class StylesScripts
{
    public static $instance;
    protected $enqueues;
    protected $dir = DIR_ASSETS;
    protected $url = URL_ASSETS_DIST;

    /**
     * @return $this
     */
    static function app()
    {
        self::$instance = new self();
        return self::$instance;
    }

    /**
     * @return $this
     */
    public function setDir($dir)
    {
        $this->dir = $dir;

        return $this;
    }

    /**
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }


    public function requireFiles()
    {
        $dir = $this->dir;
        $url = $this->url;
        if (is_array($this->enqueues) && count($this->enqueues) > 0) {
            foreach ($this->enqueues as $type => $enqueue) {
                foreach ($enqueue as $name => $file) {
                    if (is_file($dir . $file)) {
                        switch ($type) {
                            case 'styles':
                                wp_enqueue_style($name, $url . $file, array(), VERSION);
                                break;
                            case 'scripts':
                                wp_enqueue_script($name, $url . $file, array(), VERSION, true);
                                break;
                        }
                    }
                }
            }
        }
    }

    public function requireStylesScripts($enqueues)
    {
        $this->enqueues = $enqueues;
        add_action( 'wp_enqueue_scripts', array($this, 'requireFiles'), 10, 1);
    }

    public function requireStylesScriptsIntoFooter($enqueues)
    {
        $this->enqueues = $enqueues;
        $priority = array();
        if (isset($enqueues['priority'])) {
            $priority['priority'] = $enqueues['priority'][0];
            $priority['accepted'] = $enqueues['priority'][1];
            unset($enqueues['priority']);
        } else {
            $priority['priority'] = 10;
            $priority['accepted'] = 1;
        }
        add_action('get_footer', array($this, 'requireFiles'), $priority['priority'], $priority['accepted']);
    }
}
