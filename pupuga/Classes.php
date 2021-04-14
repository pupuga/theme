<?php

namespace Pupuga;

abstract class Classes {
    protected $requireFiles = array(
        'Core'    => array(
            'Init\Init',
            'Carbon\Init'
        ),
        'Modules' => array(
            //'CoolSpeed\Init',
            //'ExitPopup\Init',
            //'Woocommerce\Init',
        ),
        'Custom'  => array(
            //'ThemeMethods\Hooks',
            'Blocks\Init',
        )
    );
}