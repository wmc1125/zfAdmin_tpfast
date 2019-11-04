<?php
namespace app\index\controller;
use think\Db;
use think\facade\Request;
use app\common\behavior\Hooks;
use zf\GetConfig;
class Index extends Base
{
	public function __construct ( Request $request = null ){
        parent::__construct();
    }
    // 首页
    public function index()
    {
        if(input('tpl_id')){
            if(input('tpl_id')=='-1'){
                session('tpl_id',null);
            }else{
                session('tpl_id',input('tpl_id'));
            }
        }else{
            session('tpl_id',null);
        }
// echo   11;die;
    	//banner
       	$this->assign('banner',Db::name('advert')->where(['status'=>'1','pid'=>10])->select());
       	//最新文章
       	$this->assign('post_new',Db::name('post')->where(['status'=>1,'relevan_id'=>0,'is_product'=>0])->order('ctime desc,id desc')->paginate(15));
       
        $seo['title'] = config()['web']['site_title'];
        $seo['keywords'] = config()['web']['site_keywords'];
        $seo['description'] = config()['web']['site_description'];
        $this->assign('seo', $seo);
        return view($this->tpl);
    }
   
    public function test()
    {
        // $r = new GetConfig();
        // dd($r->img());
        return view($this->tpl);
    }

    public function test_case(){
        return view($this->tpl);

    }

   
   


}
// https://www.jq22.com/jquery/jquery.html