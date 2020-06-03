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

namespace app\api\controller\v1;
use \think\Config;
use think\Db;

// 版本1  v1
class App
{
    public function index()
    {
        echo "app-api首页";
    }
    public function news_cate(){
        $pid = input('pid',0);
    	$_list =  Db::name('pro_cpost_cate')->where([['pid','=',$pid],['status','=',1]])->order("id asc")->select();
    	foreach($_list as $k=>$vo){
    		$list[$k]['txt'] = $vo['name'];
    		$list[$k]['id'] = $vo['id'];
    	}
    	return jssuccess($list);
        

    }
    public function news_list(){
    	$cid = input('cid');
    	$page = input('page');
    	$where[] = ['cid','=',$cid];
    	$where[] = ['status','=',1];
        $_list = Db::name('pro_cpost_post')->where($where)->order("sort","desc")->order('id','desc')->select();
        if($_list){
            foreach($_list as $k=>$vo){
                $list[$k]['title'] = $vo['title'];
                $list[$k]['imgs'] = [];
                $list[$k]['desc'] = '';
                $list[$k]['viewnum'] = '';
                $list[$k]['like'] = '';
                $list[$k]['author'] = '';
                $list[$k]['cateid'] = $vo['cid'];
                $list[$k]['id'] = $vo['id'];
                $list[$k]['catename'] = 'catename';
            }
        }else{
            return jserror('empty');
        }
        
        return jssuccess($list); 
        
    }
    public function news_detail(){
    	$id = input('id');
    	$where[] = ['id','=',$id];
    	$where[] = ['status','=',1];
        $res = Db::name('pro_cpost_post')->where($where)->order("sort","desc")->order('id','desc')->find();
        $res["title"] =  "小米9 战斗天使 | 好看又能打";
        $res["authorFace"] = "https://ss0.baidu.com/6ONWsjip0QIZ8tyhnq/it/u=3692509845,157238280&fm=58&bpow=1024&bpoh=1024";
        $res["authorName"] = "小米";
        $res["viewNumber"] = "1.5w";
        $res["date"] =  "2019-09-10";
        return jssuccess($res);
        
    }


   
    
}
