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

    /**
     * @Notes:空方法
     * @Interface _empty
     * @author: 子枫
     * @Time: 2019/11/13   10:38 下午
     */
    public function _empty(){
        echo "没有此方法";
    }
    
    

    



}