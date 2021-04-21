<?php

namespace Pupuga\Core\Posts;

class Taxonomy
{
    private $taxonomy;
    private $postTypes;
    private $labelsCustom;
    private $configCustom = array();

    private function __construct()
    {
    }

    public static function app($taxonomy = array(), $postTypes = array(), $labelsCustom = array())
    {
        $object = new self();
        $object->taxonomy = $taxonomy;
        $object->postTypes = $postTypes;
        $object->labelsCustom = $labelsCustom;
	    if (!isset($object->taxonomy['many'])) {
		    $object->taxonomy['many'] = $object->taxonomy['single'];
	    }
	    if (isset($taxonomy['params']) && is_array($taxonomy['params']) && count($taxonomy['params']) > 0) {
            $object->configCustom = $taxonomy['params'];
        };
        return $object;
    }

    public function addAction()
    {
        add_action('init', array($this, 'registerTaxonomy'), 0);
    }

    public function registerTaxonomy()
    {
        $labels = array (
            'name' => _x($this->taxonomy['single'], 'taxonomy general name'),
            'singular_name' => _x($this->taxonomy['single'], 'taxonomy singular name'),
            'search_items' => __('Search '.$this->taxonomy['single']),
            'all_items' => __('All '.$this->taxonomy['many']),
            'parent_item' => __('Parent '.$this->taxonomy['single']),
            'parent_item_colon' => __('Parent '.$this->taxonomy['single'].':'),
            'edit_item' => __('Edit '.$this->taxonomy['single']),
            'update_item' => __('Update '.$this->taxonomy['single']),
            'add_new_item' => __('Add New '.$this->taxonomy['single']),
            'new_item_name' => __('New Genre '.$this->taxonomy['single']),
            'menu_name' => __($this->taxonomy['many']),
        );

        if (count($this->labelsCustom) > 0) {
            foreach($this->labelsCustom as $key => $labelCustom) {
                $labels[$key] = $labelCustom;
            }
        }

        $slug = str_replace(' ', '_' ,strtolower($this->taxonomy['single']));

        $configDefault = array(
            'label'                 => '',
            'labels'                => $labels,
            'public'                => false,
            'show_in_nav_menus'     => true,
            'show_ui'               => true,
            'show_tagcloud'         => true,
            'hierarchical'          => true,
            'update_count_callback' => '',
            'rewrite'               => false,
            'query_var'             => false,
            'capabilities' => array(
                'manage_terms' => 'edit_posts',
                'edit_terms' => 'edit_posts',
                'delete_terms' => 'edit_posts',
                'assign_terms' => 'edit_posts'
            ),
            'meta_box_cb'           => null,
            'show_admin_column'     => true,
            '_builtin'              => false,
            'show_in_quick_edit'    => null,
            'show_in_rest'          => true
        );

        $config = array_merge($configDefault, $this->configCustom);

        register_taxonomy($slug, $this->postTypes, $config);
    }

}