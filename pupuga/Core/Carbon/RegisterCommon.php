<?php

namespace Pupuga\Core\Carbon;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class RegisterCommon
{
    public function register($config) {
	    $object = Container::make('theme_options', __('Common'))->set_page_parent('options-general.php');

	    foreach ($config as $tabName => $tabFields) {
		    $args = array();
		    foreach ($tabFields as $field => $type) {
                $slug = str_replace('-', '_', sanitize_title($tabName) . '_' . sanitize_title($field));
                if (is_array($type)) {
                    $fieldObject = ExtendsCarbonFields::app()->make($type['type'], 'common_pupuga_' . $slug, $field);
                    unset($type['type']);
                    if (count($type) > 0) {
                        foreach ($type as $condition => $params) {
                            if ($condition == 'add_fields' && is_array($params) && count($params) > 0) {
                                $complexFields = array();
                                foreach ($params as $fieldParams) {
                                    $complexFields[] = Field::make($fieldParams[0], $fieldParams[1], $fieldParams[2]);
                                }
                                $params = $complexFields;
                            }
                            $fieldObject->$condition($params);
                        }
                    }
                    $args[] = $fieldObject;
                } else {
                    switch ($type) {
                        case 'config':
                            $additional = '_xml_object';
                            break;
                        default:
                            $additional = '';
                    }
                    $slug = $slug . $additional;
                    $args[] = ExtendsCarbonFields::app()->make($type, 'common_pupuga_' . $slug, $field);
                }
		    }
		    $object->add_tab(__($tabName), $args);
	    };
    }
}