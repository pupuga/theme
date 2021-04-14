<?php

namespace Pupuga;

use Pupuga\Modules\ExitPopup\LanguagesFields;

abstract class Config
{
    protected $config;

    protected function __construct()
    {
        $this->config = array(
            // theme | modules | restapi | array('Correct', 'Media', 'SetConfig', 'PageMain', 'PageLogin', 'PageAdmin')
            'mode' => 'theme',

            /**
             * Register block
             */
            'registerCarbonFields' => array(
                // slug must start with common_pupuga_
                //    'common' => array(
                //        'Configuration' => array(
                //            'Title' => array('type' => 'text', 'class' => 'cf-field--third'),,
                //            'Loop edit' => array(
                //                'type' => 'complex',
                //                'add_fields' => array(
                //                    'Default timer image' => array('type' => 'image', 'class' => 'cf-field--third'),
                //                    'Default code image' => array('type' => 'image', 'class' => 'cf-field--third'),
                //                ),
                //            )
                //        )
                //    )
                // false | array
                //'sidebar' => array('page', 'post')
                'common' => array(
                )
            ),

            // Example - add postType & taxonomy
            //
            // 'Single post type' => array(
            //      'many' => 'Many post types',
            //      'icon' => 'dashicons-calendar-alt',
            //      'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
            //      'taxonomies' => array('post_tag', 'category'),
            //      'addTaxonomies' => array(array('single' => 'Single taxonomy', 'many' => 'Many taxonomies'))
            //      'parameters' => array()
            // )
            'registerPostTypesTaxonomies' => array(
            ),

            // boolean | array '140x50' => boolean,
            'registerThumbnails' => array(
            ),

            // boolean | array
            'registerWidgets' => false,

            // boolean
            'registerHeaderImage' => false,

            /**
             * Remove block
             */
            'removeRestApi' => true,
            'removeAdminMenuItems' =>
                array(
                    'menu' => array(
                        //'edit.php',
                        //'edit.php?post_type=page',
                        'edit-comments.php',
                        //'tools.php',
                        //'plugins.php',
                        //'index.php',
                        //'users.php',
                        //'options-general.php',
                        //'separator1',
                        //'separator2',
                        //'separator-last'
                    ),
                    'submenu' => array(
                        'options-general.php' => array(
                            //'options-reading.php',
                            //'options-writing.php',
                            //'options-discussion.php',
                            //'options-permalink.php',
                            //'options-privacy.php',
                        ),
                    )
                ),
            'removeAdminPluginItems' => array()
        );
    }
}