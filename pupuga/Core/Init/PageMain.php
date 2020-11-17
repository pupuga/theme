<?php

namespace Pupuga\Core\Init;

use Pupuga\Core\Load;

class PageMain
{

    public function __construct()
    {
        if (!is_admin() && $GLOBALS['pagenow'] != 'wp-login.php') {
            add_action('get_header', function() {
	            $style = (empty(THEME_NAME)) ? 'main.css' : 'main-' . THEME_NAME . '.css';
	            if (is_file(DIR_ASSETS . $style)) {
                    wp_enqueue_style('style-main', URL_ASSETS_DIST . $style, array(), VERSION);
                }
            });
            $this->addCoreStylesScripts();
            $this->addStylesScript();
        }
    }

    public function addStylesScript()
    {
        $enqueues = array(
            'styles' => array(
                'style-bundle' => 'bundle.css',
            ),
            'scripts' => array(
                'script-bundle' => 'bundle.js',
                'script-main' => (empty(THEME_NAME)) ? 'main.js' : 'main-' . THEME_NAME . '.js'
            )
        );

        Load\StylesScripts::app()->requireStylesScriptsIntoFooter($enqueues);
    }

    public function addCoreStylesScripts()
    {
        add_action('wp_enqueue_scripts', array($this, 'jQueryCore'));
        wp_enqueue_style('style', URL_MAIN . 'style.css');
    }

    public function jQueryCore()
    {
        wp_deregister_script( 'jquery-core');
        wp_deregister_script('jquery');
        wp_register_script('jquery-core', 'https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js', false, null, true );
        wp_register_script('jquery', false, array('jquery-core'), null, true );
        wp_enqueue_script('jquery');
        //wp_enqueue_script('jquery-migrate');
        wp_localize_script('jquery', 'globalVars', array(
            'url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('check-nonce')
        ));
    }

}