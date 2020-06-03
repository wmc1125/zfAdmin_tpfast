<?php
namespace addons\demo\controller;
use addons\demo\controller\Plugin;
use think\Controller;

class Index extends Plugin
{
    // http://tpfast:8888/addons/demo.index/index.html
    public function index(){
        $url = input('url','');
        $this->assign('url',$url);
        $url_list =[
            ['name'=>'分类','url'=>'/addons/demo.index/index?url=/addons/demo.cpost/cate'],
            ['name'=>'列表','url'=>'/addons/demo.index/index?url=/addons/demo.cpost/index'],
            ['name'=>'采集分类','url'=>'/addons/demo.index/index?url=/addons/demo.cquerylist/cate'],
            ['name'=>'采集列表','url'=>'/addons/demo.index/index?url=/addons/demo.cquerylist/index']

        ] ;
        $this->assign('url_list',$url_list);

        return view();
    }
    
    public function setting(){
        echo "进入setting";
    }
    public function help(){
        echo "帮助文档";
    }


    public function test($parm){
        return $parm;
    }


}

?>