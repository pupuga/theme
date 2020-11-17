<?php

namespace Pupuga\Core\Carbon;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class RegisterSidebar
{

    public function register($config)
    {
	    $postTypes = $config;
        $object = Container::make('post_meta', 'Page Sidebar', 'Add');
        $object
            ->show_on_template('page-templates/page-with-sidebar.php')
            ->show_on_post_type($postTypes)
            ->set_context('side')
            ->set_priority('high')
            ->add_fields(
                array(
                    Field::make('sidebar', 'custom_sidebar', __('Select a Sidebar'))
                )
            );
    }

}