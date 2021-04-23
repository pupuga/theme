<?php

namespace Pupuga\Core\Init;

class Correct
{
    use InstanceTrait;

    private function __construct()
    {
        // init theme config
        add_action('after_setup_theme', array($this, 'removeAdminBar'));
        add_action('after_setup_theme', array($this, 'themeSetupRemove'));
        add_action('after_setup_theme', array($this, 'themeSetupSupport'));
	    add_filter('http_request_args', array($this, 'themeAllowHttp'), 10, 1);
        add_filter('pre_get_posts', array($this, 'orderItemsOnAdminPanel'));
    }

    public function removeAdminBar()
    {
        if (current_user_can('subscriber') && !is_admin()) {
            show_admin_bar(false);
        }
    }

    public function themeSetupRemove()
    {
        remove_action('wp_head', 'wp_generator');
        remove_action('wp_head', 'feed_links_extra', 3);
        remove_action('wp_head', 'feed_links', 2);
        remove_action('wp_head', 'rsd_link');
        remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'index_rel_link');
        remove_action('wp_head', 'start_post_rel_link', 10);
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
        remove_action('wp_head', 'parent_post_rel_link', 10);
        remove_action('wp_head', 'wp_shortlink_wp_head', 10);
        remove_action('template_redirect', 'rest_output_link_header', 11);
        remove_action('wp_head', 'rest_output_link_wp_head', 10);
        remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('rest_api_init', 'wp_oembed_register_route');
        remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
        remove_action('wp_head', 'wp_oembed_add_discovery_links');
        remove_action('wp_head', 'wp_oembed_add_host_js');
    }

    public function themeSetupSupport()
    {
        // supports a variety of post formats.
        add_theme_support('post-formats', array('aside', 'image', 'link', 'quote', 'status'));
        // supports custom logo
        add_theme_support('custom-logo');
        // actions short code in widgets
        add_filter('widget_text', 'do_shortcode');
        // add menus
        add_theme_support('menus');
    }

    public function themeAllowHttp($args)
    {
	    $args['reject_unsafe_urls'] = false;

	    return $args;
    }

    public function orderItemsOnAdminPanel( $query ) {
        if (is_admin()) {
            if (!empty($query->query['post_type'])) {
                $query->set('orderby', 'date');
                $query->set('order', 'desc');
            }
        }
    }
}