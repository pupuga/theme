<?php

namespace Pupuga\Modules\ExitPopup;

final class ConfigFields
{
    use TraitFields;

    private $fields;

    private function __construct()
    {
        $this->fields = array(
            'domain' => array(
                'type' => 'text',
                'required' => 1,
                'title' => 'Domain or full path',
                'default' => 'https://domain.com',
                'value' => '',
                'message' => 'The field must be like a https://your-domain.com'
            ),
            'code' => array(
                'type' => 'text',
                'required' => 1,
                'title' => 'Code',
                'default' => 'REWARD',
                'value' => '',
                'message' => 'The field can not be empty'
            ),
            'lang' => array(
                'type' => 'select',
                'required' => 1,
                'title' => 'Default language',
                'default' => OptionsConfig::app()->getLanguages()[0],
                'value' => '',
                'message' => 'The field can not be empty',
                'options' => OptionsConfig::app()->getLanguages()
            ),
/*            'languages' => array(
                'type' => 'checkbox',
                'required' => 1,
                'title' => 'Languages',
                'default' => 'en',
                'value' => '',
                'message' => 'The field can not be empty',
                'options' => array()
            ),*/
            'minimize_count' => array(
                'type' => 'bool',
                'required' => 1,
                'title' => 'Count in minimize mode',
                'default' => '1',
                'value' => '',
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
            ),
        );
    }
}