<?php

namespace Pupuga;

abstract class Classes {
    protected $requireFiles = array(
        'Core'    => array(
            'Init\Init',
            'Carbon\Init'
        ),
        'Modules' => array(
        ),
        'Custom'  => array(
            //'ThemeMethods\Hooks',
            'Blocks\Init',
        )
    );
}