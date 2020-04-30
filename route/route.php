<?php
// +----------------------------------------------------------------------
// | 子枫后台管理系统(TpFast系列)[基于ThinkPHP5.1开发]
// +----------------------------------------------------------------------
// | Copyright (c)  http://v1.fast.zf.90ckm.com/
// | 子枫后台管理系统提供免费使用,可使用此框架进行二次开发
// +----------------------------------------------------------------------
// | Author: 子枫 <287851074@qq.com>
// +----------------------------------------------------------------------
// | github:https://github.com/wmc1125/zfAdmin_tpfast
// | 码云:  https://gitee.com/wmc1125/zfAdmin_tpfast
// | Mc技术论坛: http://bbs.wangmingchang.com/forum.php?mod=forumdisplay&fid=77
// +----------------------------------------------------------------------

include 'web.php';


// Route::get('think', function () {
//     return 'hello,ThinkPHP5!';
// });

// Route::get('hello/:name', 'index/index/hello');

// //增加版本控制
// Route::get('demo/:version/:controller/:function','demo/:version.:controller/:function');
// Route::get('api/:version/:controller/:function','api/:version.:controller/:function');

// http://v1.fast.zf.90ckm.com/api/v1/wxgzh/server?gid=11


Route::get('wechat/gzh/server/:gid', 'api/wxgzh/server');
