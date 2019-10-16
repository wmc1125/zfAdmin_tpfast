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

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});

Route::get('hello/:name', 'index/hello');

//增加版本控制
Route::get('demo/:version/:controller/:function','demo/:version.:controller/:function');
Route::get('api/:version/:controller/:function','api/:version.:controller/:function');




//demo
// Route::get('Dtest1', 'demo/test/test1');
Route::get('Dtest2', 'demo/test/test2');

return [

];
