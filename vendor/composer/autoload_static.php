<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0cfbf6093c314c7b51eb2b952d023ea3
{
    public static $files = array (
        '1cfd2761b63b0a29ed23657ea394cb2d' => __DIR__ . '/..' . '/topthink/think-captcha/src/helper.php',
        '9b552a3cc426e3287cc811caefa3cf53' => __DIR__ . '/..' . '/topthink/think-helper/src/helper.php',
        '59c398227b77686e21aecda72dc811e6' => __DIR__ . '/..' . '/zz-studio/think-addons/src/helper.php',
    );

    public static $prefixLengthsPsr4 = array (
        't' => 
        array (
            'think\\helper\\' => 13,
            'think\\composer\\' => 15,
            'think\\captcha\\' => 14,
            'think\\' => 6,
        ),
        'a' => 
        array (
            'app\\' => 4,
        ),
        'W' => 
        array (
            'Wmc1125\\TpFast\\' => 15,
        ),
        'O' => 
        array (
            'OSS\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'think\\helper\\' => 
        array (
            0 => __DIR__ . '/..' . '/topthink/think-helper/src',
        ),
        'think\\composer\\' => 
        array (
            0 => __DIR__ . '/..' . '/topthink/think-installer/src',
        ),
        'think\\captcha\\' => 
        array (
            0 => __DIR__ . '/..' . '/topthink/think-captcha/src',
        ),
        'think\\' => 
        array (
            0 => __DIR__ . '/..' . '/topthink/think-image/src',
            1 => __DIR__ . '/..' . '/zz-studio/think-addons/src',
        ),
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/application',
        ),
        'Wmc1125\\TpFast\\' => 
        array (
            0 => __DIR__ . '/..' . '/wmc1125/tpfast-public/src',
        ),
        'OSS\\' => 
        array (
            0 => __DIR__ . '/..' . '/aliyuncs/oss-sdk-php/src/OSS',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0cfbf6093c314c7b51eb2b952d023ea3::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0cfbf6093c314c7b51eb2b952d023ea3::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
