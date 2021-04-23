<?php

namespace Pupuga\Core\Init;

use Pupuga\Core\Load;

class PageMain
{
    use InstanceTrait;

    private function __construct()
    {
        if (!is_admin() && $GLOBALS['pagenow'] != 'wp-login.php') {
            $this->addCoreStyles();
            $this->addJqueryAction();
            $this->addVarsAction();
            $this->addStylesScript();
        }
    }

    public function addStylesScript(): void
    {
        $enqueues = array(
            'styles' => array(
                'style-bundle' => 'bundle.css',
            ),
            'scripts' => array(
                'script-bundle' => 'bundle.js',
                'script-main' => (!defined('THEME_NAME') || empty(THEME_NAME))
                    ? 'main.js'
                    : 'main-' . THEME_NAME . '.js'
            )
        );

        Load\StylesScripts::app()->requireStylesScriptsIntoFooter($enqueues);
    }

    private function addCoreStyles(): void
    {
        add_action('get_header', array($this, 'addDefaultMainStyles'));
    }

    public function addDefaultMainStyles(): void
    {
        wp_enqueue_style('style', URL_MAIN . 'style.css');
        $style = (!defined('THEME_NAME') || empty(THEME_NAME))
            ? 'main.css'
            : 'main-' . THEME_NAME . '.css';
        if (is_file(DIR_ASSETS . $style)) {
            wp_enqueue_style('style-main', URL_ASSETS_DIST . $style, array(), VERSION);
        }
    }

    public function addJqueryAction(bool $footer = true): void
    {
        $action = ($footer === true) ? 'get_footer' : 'wp_enqueue_scripts';
        add_action($action, array($this, 'addJquery'));
    }

    public function addJquery(): void
    {
        wp_deregister_script( 'jquery-core');
        wp_deregister_script('jquery');
        wp_register_script('jquery-core', site_url() . '/wp-includes/js/jquery/jquery.min.js', false);
        wp_register_script('jquery', false, array('jquery-core'));
        wp_enqueue_script('jquery');
        //wp_enqueue_script('jquery-migrate');
    }

    public function addVarsAction()
    {
        add_action('wp_enqueue_scripts', array($this, 'addVars'));
    }

    public function addVars()
    {
        wp_localize_script('jquery', 'globalVars', array(
            'url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('check-nonce')
        ));
    }
}