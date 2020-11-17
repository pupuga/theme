<?php

namespace Pupuga\Core\Init;

use Pupuga\Core\Load;

class PageLogin
{

    public function __construct()
    {
        if ($GLOBALS['pagenow'] == 'wp-login.php') {
            // login style & scripts
            add_action('login_head', array($this, 'addStylesScripts'));
            add_action('login_enqueue_scripts', array($this, 'setLogoImage'));
            add_filter('login_headerurl', array($this, 'setLogoUrl'));
            add_filter('login_headertitle', array($this, 'setLogoTitle'));
        }
    }

    public function addStylesScripts()
    {
        $enqueues = array(
            'styles' => array(
                'style-login' => 'login.css'
            ),
            'scripts' => array(
                'script-login' => 'login.js',
            )
        );

	    Load\StylesScripts::app()->requireStylesScripts($enqueues);
    }

    public function setLogoImage()
    {
        $id = get_theme_mod('custom_logo');
        $image = wp_get_attachment_image_src($id, 'full');
        echo '<style type="text/css">#login h1 a, .login h1 a {background-image: none; content: url(' . $image[0] . '); width: auto; height: auto; max-width: 100%;}</style>';
    }

    public function setLogoUrl()
    {
        return home_url();
    }

    public function setLogoTitle()
    {
        return get_bloginfo();
    }
}
