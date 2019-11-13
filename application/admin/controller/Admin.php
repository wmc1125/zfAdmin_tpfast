<?php
// +----------------------------------------------------------------------
// | HisiPHP框架[基于ThinkPHP5.1开发]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2021 http://www.HisiPHP.com
// +----------------------------------------------------------------------
// | HisiPHP提供个人非商业用途免费使用，商业需授权。
// +----------------------------------------------------------------------
// | Author: 橘子俊 <364666827@qq.com>，开发者QQ群：50304283
// +----------------------------------------------------------------------

namespace app\admin\Controller;
use think\Controller;
use think\facade\Request;
use think\Db;
class Admin extends Controller
{
    public function __construct ( Request $request = null )
    {
        parent::__construct();
        $this->assign('admin',session('admin'));
        $this->assign('web_config',config());

        if(!session('admin'))
        {
            $this->error('请登录','Login/index');die; 
        }
        $this->common_tag = [];
        $this->common_select_tag = [];
        /*
        //demo:
        $this->common_tag = ['wsid'=>11,'wsname'=>'aaa'];//通用的数据
        $this->common_select_tag = [['blog_id','=',$blog['id']]];
        */
        // 读取权限
        $this->z_role_list = get_admin_role(session("admin.gid"));
        // 默认给个权限
        // $role_list[9999] = 'Index/index'; 
        $m = strtolower(request()->module());
        $c = strtolower(request()->controller());
        $a = strtolower(request()->action());
        // $nodeStr =  ucwords($c) . '/' . $a;
        $this->mca =  ucwords($c) . '/' . $a;

        //插入日志
        $log['action'] = $m.'/'.$c.'/'.$a ;
        $log['ctime'] = time() ;
        $log['ip'] = request()->ip();
        $log['uid'] = session('admin')['id'] ;
        $log['post'] = json_encode(input('param.'));
        Db::name('admin_log')->insert($log);
        
    }
    
    public function _empty(){
        echo "没有此方法";
    }
    
    

    



}