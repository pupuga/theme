<?php

namespace Pupuga\Libs\Data;

class Transform
{
    static function makeSlug(string $string): string
    {
        $string = preg_replace('/\s+/', ' ', $string);

        return str_replace(array('-', ' ', '/'), '_', strtolower($string));
    }
}