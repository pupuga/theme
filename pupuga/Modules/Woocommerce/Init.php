<?php

namespace Pupuga\Modules\Woocommerce;

final class Init
{
    public function __construct()
    {
        Account::app();
        AccountPage::app();
    }
}