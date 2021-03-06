<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3ae55469a36b56f8667bfcafb0e05d9b
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Models\\' => 7,
        ),
        'C' => 
        array (
            'Controllers\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Models\\' => 
        array (
            0 => __DIR__ . '/../..' . '/models',
        ),
        'Controllers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/controllers',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3ae55469a36b56f8667bfcafb0e05d9b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3ae55469a36b56f8667bfcafb0e05d9b::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
