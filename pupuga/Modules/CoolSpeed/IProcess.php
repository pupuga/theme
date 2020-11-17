<?php

namespace Pupuga\Modules\CoolSpeed;

interface IProcess
{
    public function __construct($source, $file);

    public function getData();
}