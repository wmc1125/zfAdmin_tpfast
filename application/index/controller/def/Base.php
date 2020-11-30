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

namespace app\index\Controller\def;
use think\Controller;
use think\facade\Request;
use think\Db;

class Base extends Controller
{
    public function __construct ( Request $request = null )
    {
        parent::__construct();
        $this->sys = [
          'lang'=>'',//使用:Db::name($this->>sys['lang].'config')
        ];
        if(config()['web']['site_closed']){
            $this->error('站点已关闭','http://www.wangmingchang.com');
        }
        $this->assign('home',session('home'));
        $this->assign('web_config',config()['web']);
        $this->zf_tpl_suffix = Db::name('config')->where(['key'=>'zf_tpl_suffix'])->value('value');
        if($this->zf_tpl_suffix==''){
          $this->zf_tpl_suffix = 'def';
        }
        if(cookie('theme')){
          $this->zf_tpl_suffix = cookie('theme');
        }

        
        $this->tpl = ($this->zf_tpl_suffix==''?'':$this->zf_tpl_suffix.'/').explode($this->zf_tpl_suffix.'.', strtolower(Request::controller()))[1].'/'.strtolower(Request::action());
        $this->controller = strtolower(Request::controller());
        $this->action = strtolower(Request::action());
        $this->tpl_suffix = ($this->zf_tpl_suffix==''?'':$this->zf_tpl_suffix);
        /*
		    $this->zf_tpl_suffix==''时,index/test
		    $this->zf_tpl_suffix=='a1'时,a1/index/test
        */
       if($this->tpl_suffix!=''){
       		 $tpl_static = get_domain()."/application/index/view/".$this->zf_tpl_suffix.'/style/';
       }else{
       		 $tpl_static = get_domain()."/application/index/view/style/";
       }
        $this->assign('tpl_static',$tpl_static);
        $this->assign('zf_tpl_suffix',$this->zf_tpl_suffix);

       //通用导航
       $this->assign('menu',Db::name('category')->where(['status'=>1,'menu'=>1])->order('sort asc,cid asc')->select());
       $this->assign('link',Db::name('link')->where(['status'=>1])->select());
        //推荐文章
        // $this->assign('post_sort',Db::name('post')->where(['status'=>1,'relevan_id'=>0])->order('sort desc,id desc')->select());
        //点击排行
        // $post_hits = Db::name('post')->where(['status'=>1,'relevan_id'=>0])->order('hits desc,id desc')->select();
        // $this->assign('post_hits',$post_hits);
        // $this->assign('hot_post',$post_hits);
        $this->assign('cid',0);
        
    }
    

    public function _empty(){
        echo "没有此方法";
    }
    
    

    



}