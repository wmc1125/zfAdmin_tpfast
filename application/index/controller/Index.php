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

namespace app\index\controller;
use think\Db;
use think\facade\Request;
use Wmc1125\TpFast\GetConfig;
class Index extends Base
{
	public function __construct ( Request $request = null ){
        parent::__construct();
    }
    // 首页
    public function index(){
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
   
    
   
   


}