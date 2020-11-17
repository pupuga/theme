<?php

namespace Pupuga\Modules\ExitPopup;

final class Init
{
    public function __construct()
    {
        AccountExtension::app();
        SaveFields::app();
    }
}