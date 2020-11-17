<?php

namespace Pupuga\Modules\CoolSpeed;

final class Hooks
{
    public function __construct()
    {
        $this->hooksRemove();
        $this->hooksBuffer();
    }

    private function hooksRemove()
    {
        add_action( 'wp_enqueue_scripts', array($this, 'removeStylesScripts'), 9999 );
        add_action( 'wp_head', array($this, 'removeStylesScripts'), 9999 );
    }

    public function removeStylesScripts()
    {
        wp_deregister_script( 'wp-embed' );
        wp_deregister_style( 'wp-block-library' );
        wp_dequeue_style('jquery-lazyloadxt-spinner-css');
        wp_deregister_style('jquery-lazyloadxt-spinner-css');
    }

    private function hooksBuffer()
    {
        new HooksBufferAll();
    }
}