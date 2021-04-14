<?php

namespace Pupuga\Modules\ExitPopup;

final class Init
{
    public function __construct()
    {
        Options::app();
        AccountExtension::app();
        SaveFields::app();
    }
}