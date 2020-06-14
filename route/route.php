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
use think\Db;


if (!is_file('./public/install.lock')) {
	//安装系统
	Route::any('install', 'index/install/index');
	if(strpos(request()->server()['REQUEST_URI'],'/install') === false){ 
		header('Location: /install'); exit();
	}
	
}else{
	
//web前端
	if(strpos($_SERVER['REQUEST_URI'],'/?theme=') !==false){
	    $theme = input('theme');
	    if($theme){
	        cookie('theme',$theme,300*1000);
	    }
	    $val = cookie('theme');
	}else{
	    if(cookie('theme')){
		    $val = cookie('theme');
	    }else{
		    $val = Db::name('config')->where(['key'=>'zf_tpl_suffix'])->value('value');
	    }
	}
	if($val!=''){
	    $_file = './application/index/view/'.$val.'/route.php';
	    if(file_exists($_file)){
	        include $_file;
	    }
	}else{
	    $_file = './application/index/view/def/route.php';
		if(file_exists($_file)){
	        include $_file;
	    }
	}

	//公众号服务
	Route::get('wechat/gzh/server/:gid', 'api/wxgzh/server');
	Route::get('api/:version/:controller/:function','api/:version.:controller/:function');

}
