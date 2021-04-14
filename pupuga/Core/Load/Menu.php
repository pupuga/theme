<?php

namespace Pupuga\Core\Load;

class Menu
{

    /**
     * @var Menu
     */
    private static $instance;
    private $args = array();

    /**
     * @return $this
     */
    public static function app()
    {
        self::$instance = new self();
        return self::$instance;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function theme_location($arguments)
    {
        $this->args['theme_location'] = $arguments;
        return $this;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function menu($arguments)
    {
        $this->args['menu'] = $arguments;
        return $this;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function container($arguments)
    {
        $this->args['container'] = $arguments;
        return $this;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function container_class($arguments)
    {
        $this->args['container_class'] = $arguments;
        return $this;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function container_id($arguments)
    {
        $this->args['container_id'] = $arguments;
        return $this;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function menu_class($arguments)
    {
        $this->args['menu_class'] = $arguments;
        return $this;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function menu_id($arguments)
    {
        $this->args['menu_id'] = $arguments;
        return $this;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function wp_echo($arguments)
    {
        $this->args['echo'] = $arguments;
        return $this;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function fallback_cb($arguments)
    {
        $this->args['fallback_cb'] = $arguments;
        return $this;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function before($arguments)
    {
        $this->args['before'] = $arguments;
        return $this;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function after($arguments)
    {
        $this->args['after'] = $arguments;
        return $this;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function link_before($arguments)
    {
        $this->args['link_before'] = $arguments;
        return $this;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function link_after($arguments)
    {
        $this->args['link_after'] = $arguments;
        return $this;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function items_wrap($arguments)
    {
        $this->args['items_wrap'] = $arguments;
        return $this;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function depth($arguments)
    {
        $this->args['depth'] = $arguments;
        return $this;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function walker($arguments)
    {
        $this->args['walker'] = $arguments;
        return $this;
    }

    /**
     * @return $this
     */
    public function menuStandard($menuId)
    {
        $this->container(false)
            ->items_wrap('%3$s')
            ->menu($menuId)
            ->fallback_cb('__return_empty_string');

        return $this;
    }

    /**
     * @return $this
     */
    public function spanReplace($search = array()) : Menu
    {
        if (count($search)) {
            $this->args['span_search'] = $search;
            foreach ($search as $item) {
                $this->args['span_replace'][] = '<span class="' . sanitize_title($item) . '">' . $item . '</span>';
            }
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function replaceShortCodeLink($search = array()) {
        if (count($search)) {
            foreach ($search as $key => $item) {
                $this->args['search'][] = $key;
                $this->args['replace'][] = $item;
            }
        }

        return $this;
    }

    public function action($echo = true)
    {
        $this->wp_echo(false);
        $menu = wp_nav_menu($this->args);
        if (isset($this->args['search']) && isset($this->args['replace'])) {
            $menu = str_replace($this->args['search'], $this->args['replace'], $menu);
        }
        if (isset($this->args['span_search']) && isset($this->args['span_search'])) {
            $menu = str_replace($this->args['span_search'], $this->args['span_replace'], $menu);
        }

        if ($echo) {
            echo $menu;
        }
            
        return wp_nav_menu($this->args);
    }

}
