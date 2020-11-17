<?php

namespace Pupuga\Modules\ExitPopup;

final class StylesFields
{
    use TraitFields;

    protected $fields = array(
        'border_radius' => array(
            'type' => 'number',
            'required' => 1,
            'title' => 'Border radius (integer number)',
            'default' => '11',
            'value' => '',
            'message' => 'The field must be 0 or bigger'
        ),
        'get_font_family' => array(
            'type' => 'bool',
            'required' => 1,
            'title' => 'Use site font',
            'default' => '0',
            'value' => '',
        ),
        'background_color' => array(
            'type' => 'color',
            'required' => 1,
            'title' => 'Background color',
            'default' => '#fff',
            'value' => '',
        ),
        'timer_title_font_color' => array(
            'type' => 'color',
            'required' => 1,
            'title' => 'Timer title font color',
            'default' => '#000',
            'value' => '',
        ),
        'timer_font_color' => array(
            'type' => 'color',
            'required' => 1,
            'title' => 'Timer font color',
            'default' => '#cd171b',
            'value' => '',
        ),
        'timer_digit_color' => array(
            'type' => 'color',
            'required' => 1,
            'title' => 'Timer digit color',
            'default' => '#fff',
            'value' => '',
        ),
        'timer_digit_background_color' => array(
            'type' => 'color',
            'required' => 1,
            'title' => 'Timer digit background color',
            'default' => '#333',
            'value' => '',
        ),
        'timer_analog_point_color' => array(
            'type' => 'color',
            'required' => 1,
            'title' => 'Timer analog point color',
            'default' => '#969696',
            'value' => '',
        ),
        'code_title_font_color' => array(
            'type' => 'color',
            'required' => 1,
            'title' => 'Code title font color',
            'default' => '#000',
            'value' => '',
        ),
        'code_font_color' => array(
            'type' => 'color',
            'required' => 1,
            'title' => 'Code font color',
            'default' => '#000',
            'value' => '',
        ),
        'code_code_font_color' => array(
            'type' => 'color',
            'required' => 1,
            'title' => 'Code code font color',
            'default' => '#cd171b',
            'value' => '',
        ),
        'help_font_color' => array(
            'type' => 'color',
            'required' => 1,
            'title' => 'Help font color',
            'default' => '#979797',
            'value' => '',
        ),
        'close_button_color' => array(
            'type' => 'color',
            'required' => 1,
            'title' => 'Close button color',
            'default' => '#979797',
            'value' => '',
        ),
        'minimize_button_color' => array(
            'type' => 'color',
            'required' => 1,
            'title' => 'Minimize button color',
            'default' => '#fff',
            'value' => '',
        ),
        'minimize_button_background_color' => array(
            'type' => 'color',
            'required' => 1,
            'title' => 'Minimize button background color',
            'default' => '#cd171b',
            'value' => '',
        )
    );
}