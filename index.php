<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]
namespace think;

// 加载基础文件
require __DIR__ . '/thinkphp/base.php';
// 插件目录
define('ADDON_PATH', __DIR__ . '/addons/');
// 开启系统行为
define('APP_HOOK', true);
// 支持事先使用静态方法设置Request对象和Config对象
//安装程序
if( !is_file('./application/install.lock')) {
    define('BIND_MODULE','install');
   
}
// 执行应用并响应
Container::get('app')->run()->send();
 