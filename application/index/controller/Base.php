<?php
namespace app\index\Controller;
use think\Controller;
use think\facade\Request;
use think\Db;


class Base extends Controller
{
    public function __construct ( Request $request = null )
    {
        parent::__construct();
        if(config()['web']['site_closed']){
            $this->error('站点已关闭','http://www.wangmingchang.com');
        }
        $this->assign('home',session('home'));
        $this->assign('web_config',config());

       	$zf_tpl_suffix = Db::name('config')->where(['key'=>'zf_tpl_suffix'])->value('value');
        $this->tpl = ($zf_tpl_suffix==''?'':$zf_tpl_suffix.'/').strtolower(Request::controller()).'/'.strtolower(Request::action());
        $this->controller = strtolower(Request::controller());
        $this->action = strtolower(Request::action());
        $this->tpl_suffix = ($zf_tpl_suffix==''?'':$zf_tpl_suffix);
        // dd(Request::controller().'/'.Request::module().'/'.Request::action());
        /*
		    $zf_tpl_suffix==''时,index/test
		    $zf_tpl_suffix=='a1'时,a1/index/test
        */
       if($this->tpl_suffix!=''){
       		 $tpl_static = get_domain()."/template/index/".$zf_tpl_suffix.'/style/';
       }else{
       		 $tpl_static = get_domain()."/template/index/style/";
       }
        $this->assign('tpl_static',$tpl_static);

       //通用导航
       $this->assign('menu',Db::name('category')->where(['status'=>1,'menu'=>1])->order('sort asc,cid asc')->select());
       $this->assign('links',Db::name('link')->where(['status'=>1])->select());
        //推荐文章
        $this->assign('post_sort',Db::name('post')->where(['status'=>1,'relevan_id'=>0])->order('sort desc,id desc')->select());
        //点击排行
        $post_hits = Db::name('post')->where(['status'=>1,'relevan_id'=>0])->order('hits desc,id desc')->select();
        $this->assign('post_hits',$post_hits);
        $this->assign('hot_post',$post_hits);
        $this->assign('cid',0);
        
    }
    

    public function _empty(){
        echo "没有此方法";
    }
    
    

    



}