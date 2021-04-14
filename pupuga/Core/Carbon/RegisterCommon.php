<?php

namespace Pupuga\Core\Carbon;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class RegisterCommon
{
    private $prefix = 'common_pupuga_';

    public function register($config) {
	    $object = Container::make('theme_options', __('Common'))->set_page_parent('options-general.php');
	    foreach ($config as $tabName => $tabFields) {
		    $args = array();
		    foreach ($tabFields as $key => $field) {
                $slug = $this->prefix . str_replace('-', '_', sanitize_title($tabName) . '_' . sanitize_title($key));
                $title = (isset($field['title'])) ? $field['title'] : $key;
                switch ($field['type']) {
                    case 'complex':
                        $args[] = $this->complex($field, $slug, $title);
                        break;
                    case 'config':
                        $slug = $slug . '_xml_object';
                        $args[] = $this->default($field, $slug, $title);
                        break;
                    default:
                        $args[] = $this->default($field, $slug, $title);
                        break;
                }
		    }
		    $object->add_tab(__($tabName), $args);
	    }
    }

    private function default($field, $slug, $title)
    {
        return ExtendsCarbonFields::app()->make($field['type'], $slug, $title, $field['class']);
    }

    private function complex($complex, $slug, $title)
    {
        $fieldObject = ExtendsCarbonFields::app()->make($complex['type'], $slug, $title, $complex['class']);
        if (is_array($complex['add_fields']) && count($complex['add_fields'])) {
            $fields = array();
            foreach ($complex['add_fields'] as $title => $field) {
                $slug = $this->prefix . str_replace('-', '_', sanitize_title($title));
                $fields[] = ExtendsCarbonFields::app()->make($field['type'], $slug, $title, $field['class']);
            }
            if ($fields) {
                $fieldObject->add_fields($fields);
            }
        }

        return $fieldObject;
    }
}