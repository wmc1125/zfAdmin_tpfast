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

namespace app\demo\controller;
use think\Db;

class Test extends Base
{
    public function index()
    {
        echo "index";
    }
    public function md(){
        return view();
    }
    public function c_view(){

    	// $editor = new \Wmc1125\Mctoolsdk\Editor;
    	// dd($editor->test(0));
    	// 
    	// echo __ZF__;
        // define("GREETING", "Welcome to W3School.com.cn!");
// echo GREETING;
        return view();
    }

  
   


}
