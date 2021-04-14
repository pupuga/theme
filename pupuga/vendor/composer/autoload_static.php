<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit517721245e68e416754d68c18170444c
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Pupuga\\' => 7,
        ),
        'C' => 
        array (
            'Carbon_Fields\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Pupuga\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
        'Carbon_Fields\\' => 
        array (
            0 => __DIR__ . '/..' . '/htmlburger/carbon-fields/core',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit517721245e68e416754d68c18170444c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit517721245e68e416754d68c18170444c::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
