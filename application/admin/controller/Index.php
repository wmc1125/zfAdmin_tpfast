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

namespace app\admin\controller;
use app\admin\model\roleModel;
use think\facade\Session;
use think\facade\Cache;
use think\facade\Request;
use think\Db;
use Wmc1125\TpFast\Database as dbOper;
use app\admin\controller\Common;

class Index extends Admin
{
    public function __construct (){
        parent::__construct();
    }

    /**
     * @Notes:首页
     * @Interface index
     * @return \think\response\View
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author: 子枫
     * @Time: 2019/11/13   10:55 下午
     */
    public function index()
    {
        $menu = ZFTB('admin_role')->order("sort asc")->where("status!=9")->select();
        $role_list =  ZFTB('admin_group')->where(['id'=>session('admin.gid')])->value('role');
        foreach($menu as $k=>$vo){
            if(!in_array($vo['id'], explode(',', $role_list))){
                unset($menu[$k]);
            }
        }
        $this->assign("menu",$menu);
        return view("index");
    }

    /**
     * @Notes:欢迎页
     * @Interface welcome
     * @return \think\response\View
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author: 子枫
     * @Time: 2019/11/13   10:55 下午
     */
    public function welcome()
    {
        admin_role_check($this->z_role_list,$this->mca);
        $sitemap = new \zf\Sitemap;
        $sitemap->index();    
        
        //授权查询
        $ZfAuth = new \zf\ZfAuth;
        $upg_msg = $ZfAuth->get_location_auth_info();
        $site_info = $ZfAuth->get_siteplugin_info();
        // dd($site_info);
        $this->assign('upg_msg',$upg_msg);
        $this->assign('site_info',$site_info['msg']);


        return view();
    }

    /**
     * @Notes:清除数据库的垃圾箱文件
     * @Interface db_clear
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * @author: 子枫
     * @Time: 2019/11/13   10:56 下午
     */
    public function db_clear(){
        admin_role_check($this->z_role_list,$this->mca);
        $t = input('t','');
        if($t=='log'){
                ZFTB('admin_log')->where(['status'=>1])->update(['status'=>9]);
                $this->success('清除完毕');
        }else{
            $config=array(
                'path'     => './db/',//数据库备份路径
            );

            $tables = Db::query("SHOW TABLE STATUS");

            foreach($tables as $k=>$vo){
                Db::table($vo['Name'])->where(['status'=>9])->delete();
            }
            $this->success('清除完毕');
        }
    }
    public function change_lang(){
        admin_role_check($this->z_role_list,$this->mca);
        $lang = input('lang','');
        session('zf_lang',$lang);
        $this->success('切换语言中');
    }


}
