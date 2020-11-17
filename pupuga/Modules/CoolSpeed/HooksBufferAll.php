<?php

namespace Pupuga\Modules\CoolSpeed;


final class HooksBufferAll
{
    private $postTypes;

    public function __construct()
    {
        $this->postTypes = Config::app()->get('post-type');
        add_action( 'wp_head', array($this, 'additionIntoHead'), 0);
        add_action( 'get_header', array($this, 'start'), 0);
        add_action( 'shutdown', array($this, 'output'), 0);
    }

    public function additionIntoHead()
    {
        if(in_array(get_post_type(), $this->postTypes)) {
            echo (new TagHeader)
                ->sources(Config::app()->get('header')['resources'])
                ->fonts(Config::app()->get('header')['fonts'])
                ->get();
        }
    }

    public function start()
    {
        if(in_array(get_post_type(), $this->postTypes)) {
            ob_start();
        }
    }

    public function output()
    {
        if(in_array(get_post_type(), $this->postTypes)) {
            $buffer = ob_get_clean();
            (new HtmlSources($buffer))
                ->script()
                ->style()
                //->parseImg()
                ->getSources();
            echo $buffer;
        }
    }
}