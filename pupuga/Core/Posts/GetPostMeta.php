<?php

namespace Pupuga\Core\Posts;

class GetPostMeta
{
    /**
     * @var $this
     */
    private static $instance;
    public $post;
    public $postMeta;

    public function __construct()
    {
    }

    /**
     * @return $this
     */
    public static function app()
    {
        global $post;
        if (!isset(self::$instance->post->ID) || self::$instance->post->ID != $post->ID) {
            self::$instance = new self;
            self::$instance->post = $post;
            self::$instance->postMeta = get_post_meta($post->ID);
        }

        return self::$instance;
    }

    public function getPostId()
    {
        return $this->post->ID;
    }

    public function getPost()
    {
        return $this->post;
    }

    public function getPostMetaAll()
    {
        return $this->postMeta;
    }

    public function getPostMeta($postMeta)
    {
        $result = '';
        if (isset($this->postMeta[$postMeta][0]) && $this->postMeta[$postMeta][0] != '') {
            $result = $this->postMeta[$postMeta][0];
        }
        return $result;
    }

    public function getPostMetaFlex($postMeta)
    {
        if (isset($this->postMeta[$postMeta][0])) {
            $postMetaFlex = $this->postMeta[$postMeta][0];
        } else {
            $postMetaFlex = $this->postMeta['_' . $postMeta][0];
        }

        return $postMetaFlex;
    }
}