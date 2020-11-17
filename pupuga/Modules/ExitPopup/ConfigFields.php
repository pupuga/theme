<?php

namespace Pupuga\Modules\ExitPopup;

final class ConfigFields
{
    use TraitFields;

    private $fields = array(
        'domain' => array(
            'type' => 'text',
            'required' => 1,
            'title' => 'Domain or full path',
            'default' => 'https://domain.com',
            'value' => '',
            'message' => 'The field must be like a https://your-domain.com'
        ),
        'timer_title' => array(
            'type' => 'text',
            'title' => 'Timer title',
            'default' => 'Congratulations!',
            'value' => '',
        ),
        'timer_description' => array(
            'type' => 'text',
            'title' => 'Timer description',
            'default' => 'Only few seconds left to your gift',
            'value' => '',
        ),
        'code_title' => array(
            'type' => 'text',
            'title' => 'Code title',
            'default' => 'Take your gift!',
            'value' => '',
        ),
        'code_description' => array(
            'type' => 'text',
            'title' => 'Code description',
            'default' => 'This coupon code will apply 15% discount to any item in our shop!',
            'value' => '',
        ),
        'header_text' => array(
            'type' => 'text',
            'title' => 'Header text',
            'default' => 'Close window (I refuse the profit)',
            'value' => '',
        ),
        'footer_text' => array(
            'type' => 'text',
            'title' => 'Footer text',
            'default' => 'Minimize this window',
            'value' => '',
        ),
        'code' => array(
            'type' => 'text',
            'required' => 1,
            'title' => 'Code',
            'default' => 'REWARD',
            'value' => '',
            'message' => 'The field can not be empty'
        ),
        'time' => array(
            'type' => 'number',
            'required' => 1,
            'title' => 'Time (sec)',
            'default' => '9',
            'value' => '',
            'message' => 'The field must be 0 or bigger'
        ),
        'memory_days' => array(
            'type' => 'number',
            'required' => 1,
            'title' => 'Memory (days)',
            'default' => '365',
            'value' => '',
            'message' => 'The field must be 0 or bigger'
        ),
        'memory_close_days' => array(
            'type' => 'number',
            'required' => 1,
            'title' => 'Memory close (days)',
            'default' => '30',
            'value' => '',
            'message' => 'The field must be 0 or bigger'
        ),
        'mobile_load_sec' => array(
            'type' => 'number',
            'required' => 1,
            'title' => 'Mobile load (sec)',
            'default' => '2',
            'value' => '',
            'message' => 'The field must be 0 or bigger'
        ),
        'desktop_load_sec' => array(
            'type' => 'number',
            'required' => 1,
            'title' => 'Desktop load (sec)',
            'default' => '90',
            'value' => '',
            'message' => 'The field must be 0 or bigger'
        )
    );
}