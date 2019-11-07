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
include './vendor/wmc1125/mctoolsdk/src/McTool.php';
//安装程序
!is_file('./install.lock')?define('BIND_MODULE','install'):define('BIND_MODULE','index');
// 执行应用并响应
Container::get('app')->run()->send();
 