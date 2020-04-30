<?php
namespace addons\demo\controller;
use addons\demo\controller\Plugin;
use think\Controller;
use addons\demo\controller\Base;

class Index extends Base
{
    // http://tpfast:8888/addons/test.index/index.html
    public function index(){
        return view();
    }
    public function link()
    {
        echo 'hello link';
        return view();
    }
    public function setting(){
        echo "进入setting";
        // dd($this->plugin_info);
    }
    public function help(){
        echo "帮助文档";
    }
    


}

?>