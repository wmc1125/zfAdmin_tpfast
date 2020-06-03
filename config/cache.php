<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | 缓存设置
// +----------------------------------------------------------------------

// return [
//     // 驱动方式
//     'type'   => 'File',
//     // 缓存保存目录
//     'path'   => '',
//     // 缓存前缀
//     'prefix' => '',
//     // 缓存有效期 0表示永久缓存
//     'expire' => 0,
// ];


return [
    // 使用复合缓存类型
    'type'  =>  'complex',
    // 默认使用的缓存
    'default'   =>  [
        // 驱动方式
        'type'   => 'file',
        // 缓存有效期为永久有效
        'expire'=>  0, 
        //缓存前缀
        'prefix'=>  'zf',
        // 缓存保存目录
        'path'   => './runtime/default',
    ],
    // 文件缓存
    'file'   =>  [
        // 驱动方式
        'type'   => 'file',
        // 缓存有效期为永久有效
        'expire'=>  0, 
        //缓存前缀
        'prefix'=>  'zf',
        // 设置不同的缓存保存目录
        'path'   => './runtime/file/',
    ],  
    // redis缓存
    'redis'   =>  [
        'type'   => 'redis',// 驱动方式
	    'host'	=>	'127.0.0.1', // 服务器地址
	    'port' 	=>	'6379',//端口号
	    'expire'=> 0, // 全局缓存有效期（0为永久有效）
	    'prefix'=>  '',// 缓存前缀
	    'password' =>''//密码
    ],
];

