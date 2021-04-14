<?php

namespace Pupuga\Modules\ExitPopup;

final class LanguagesFields
{
    use TraitFields;
    private $repeat;

    private $fields = array(
        'use_lang' => array(
            'type' => 'bool',
            'required' => 1,
            'title' => 'Use lang',
            'default' => 1,
            'value' => '',
            'class' => 'tab',
            'adminOptionClass' => 'display-none'
        ),
        'timer_title' => array(
            'type' => 'text',
            'required' => 1,
            'title' => 'Timer title',
            'default' => 'Congratulations!',
            'value' => '',
        ),
        'timer_description' => array(
            'type' => 'text',
            'required' => 1,
            'title' => 'Timer description',
            'default' => 'Only few seconds left to your gift',
            'value' => '',
        ),
        'code_title' => array(
            'type' => 'text',
            'required' => 1,
            'title' => 'Code title',
            'default' => 'Take your gift!',
            'value' => '',
        ),
        'code_description' => array(
            'type' => 'text',
            'required' => 1,
            'title' => 'Code description',
            'default' => 'This coupon code will apply 15% discount to any item in our shop!',
            'value' => '',
        ),
        'header_text' => array(
            'type' => 'text',
            'required' => 1,
            'title' => 'Header text',
            'default' => 'Close window (I refuse the profit)',
            'value' => '',
        ),
        'footer_text' => array(
            'type' => 'text',
            'required' => 1,
            'title' => 'Footer text',
            'default' => 'Minimize this window',
            'value' => '',
        )
    );

    private function __construct()
    {
        $this->repeat = OptionsConfig::app()->getLanguages();
    }
}