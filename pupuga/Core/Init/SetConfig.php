<?php

namespace Pupuga\Core\Init;

use Pupuga;
use Pupuga\Core\Base;
use Pupuga\Core\Posts;

class SetConfig extends Pupuga\Config
{
    use Base\VerifyVar;
    private $customPostType = array();

    public function __construct()
    {
        parent::__construct();

        if ($this->verifyConfigVar('removeRestApi')) {
            add_filter('rest_authentication_errors', array($this, 'removeRestApi'));
        }

        if ($this->verifyConfigVar('removeAdminMenuItems')) {
            add_action('custom_menu_order', array($this, 'removeAdminMenuItems'));
        }

        if ($this->verifyConfigVar('removeAdminPluginItems')) {
            add_action('pre_current_active_plugins', array($this, 'removeAdminPluginItems'));
        }

        if ($this->verifyConfigVar('registerHeaderImage')) {
            add_action('after_setup_theme', array($this, 'registerHeaderImage'));
        }

        if ($this->verifyConfigVar('registerWidgets')) {
            add_action('after_setup_theme', array($this, 'registerWidgets'));
        }

        if ($this->verifyConfigVar('registerThumbnails')) {
            add_action('after_setup_theme', array($this, 'registerThumbnails'));
        }

        if ($this->verifyConfigVar('registerPostTypesTaxonomies')) {
            add_action('after_setup_theme', array($this, 'registerPostTypesTaxonomies'));
        }

    }

    public function removeRestApi()
    {
        /* if (empty( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] ) && strtolower( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ]) != 'xmlhttprequest') {
            return new \WP_Error( 'rest_disabled', __( 'Page not found' ), array( 'status' => rest_authorization_required_code() ) );
        }*/
        /*if (!current_user_can('edit_theme_options')) {
            die('404 error');
        }*/
    }

    public function removeAdminMenuItems()
    {
        if (count($this->config['removeAdminMenuItems']['menu'])) {
            foreach ($this->config['removeAdminMenuItems']['menu'] as $menu) {
                remove_menu_page($menu);
            }
        }
        if (count($this->config['removeAdminMenuItems']['submenu'])) {
            foreach ($this->config['removeAdminMenuItems']['submenu'] as $menu => $submenus) {
                if (count($submenus)) {
                    foreach ($submenus as $submenu){
                        remove_submenu_page($menu, $submenu);
                    }
                }
            }
        }
    }

    public function removeAdminPluginItems()
    {
        global $wp_list_table;
        if (count($wp_list_table->items)) {
            foreach ($wp_list_table->items as $key => $val) {
                if (in_array($key, $this->config['removePluginItems'])) {
                    unset($wp_list_table->items[$key]);
                }
            }
        }
    }

    public function registerHeaderImage()
    {
        $args = array(
            'default-image' => '',
            'random-default' => false,
            'width' => 0,
            'height' => 0,
            'flex-height' => false,
            'flex-width' => false,
            'default-text-color' => '',
            'header-text' => true,
            'uploads' => true,
            'wp-head-callback' => '',
            'admin-head-callback' => '',
            'admin-preview-callback' => '',
        );
        add_theme_support('custom-header', $args);
    }

    public function registerWidgets()
    {
        $widgets = array();
        if (is_array($this->config['registerWidgets'])) {
            $widgets = array_merge($widgets, $this->config['registerWidgets']);
        }
        if (count($widgets)) {
            foreach ($widgets as $widget) {
                register_sidebar(array(
                    'name' => __($widget),
                    'id' => sanitize_title($widget),
                    'before_widget' => '<div id="%1$s" class="widget %2$s">',
                    'after_widget' => '</div>',
                    'before_title' => '<h3 class="widget-title">',
                    'after_title' => '</h3>',
                ));
            }
        }
    }

    public function registerThumbnails()
    {
        // support thumbnail
        add_theme_support('post-thumbnails');
        //add thumbnail sizes
        if (is_array($this->config['registerThumbnails'])) {
            foreach ($this->config['registerThumbnails'] as $thumbnail => $crop) {
                $thumbnailSizes = explode('x', $thumbnail);
                if ($crop !== true) {
                    $crop = false;
                }
                add_image_size($thumbnail, $thumbnailSizes[0], $thumbnailSizes[1], $crop);
            };
        }
    }

    public function registerPostTypesTaxonomies()
    {
        foreach ($this->config['registerPostTypesTaxonomies'] as $customPostType => $customPostTypeConfig) {
            $postType = str_replace(' ', '-', strtolower($customPostType));
            $this->customPostType[] = $postType;

            // add custom taxonomies
            if (isset($customPostTypeConfig['addTaxonomies']) && is_array($customPostTypeConfig['addTaxonomies']) && count($customPostTypeConfig['addTaxonomies']) > 0) {
                foreach ($customPostTypeConfig['addTaxonomies'] as $addTaxonomies) {
                    $postTypeSingle = str_replace(' ', '_', strtolower($addTaxonomies['single']));
                    $customPostTypeConfig['taxonomies'][] = $postTypeSingle;
                    Posts\Taxonomy::app($addTaxonomies, array($postType))->addAction();
                }
            }

            // add custom post type
            Posts\PostType::add(array('single' => $postType, 'many' => $customPostTypeConfig['many']), $customPostTypeConfig['parameters'])
                ->setMenuIcon($customPostTypeConfig['icon'])
                ->setSupports($customPostTypeConfig['supports'])
                ->setTaxonomies($customPostTypeConfig['taxonomies'])
                ->action();
        };

        add_action('pre_get_posts', array($this, 'removeSlugFromLink') );
    }

    public function removeSlugFromLink( $query ) {
        if (!$query->is_main_query() || (2 != count($query->query) || !isset($query->query['page'])))
            return;

        if (2 != count($query->query) || !isset($query->query['page'])) {
            return;
        }

        if (!empty($query->query['name'])) {
            $query->set('post_type', array_merge(array('post', 'page'), $this->customPostType));
        }
    }


}