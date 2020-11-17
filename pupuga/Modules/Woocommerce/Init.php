<?php

namespace Pupuga\Modules\Woocommerce;

final class Init
{
    public function __construct()
    {
        Redirect::app();
        Account::app();
        AccountPage::app();
    }
}