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
use think\facade\Request;
use think\Db;
use think\facade\Config as TConfig;
use Wmc1125\TpFast\Category;
class Config extends Admin
{
    public function __construct (){
        parent::__construct();
    }

    /**
     * @Notes:网站设置
     * @Interface index
     * @return \think\response\View|void
     * @author: 子枫
     * @Time: 2019/11/13   10:47 下午
     */
    public function index()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if(request()->isPost()){
            $data = input('post.');
            $res = extraconfig(input('post.'),'web');
            return ZFRetMsg($res,'保存成功','保存失败');
        }
        $type = input('type','网站设置');
        $this->assign("type",$type);
        $this->assign("config",config()['web']);
        return view();
    }

    /**
     * @Notes:管理员列表
     * @Interface admin_index
     * @return \think\response\View
     * @throws \think\exception\DbException
     * @author: 子枫
     * @Time: 2019/11/13   10:48 下午
     */
    public function admin_index()
    {
        admin_role_check($this->z_role_list,$this->mca);
        $user_list = ZFTB('admin')->where([['status','<>',9]])->order("id asc")->paginate(6);
        $page = $user_list->render();
        $this->assign("user_list",$user_list);
        $this->assign("page",$page);
        return view();
    }

    /**
     * @Notes:管理员增加
     * @Interface admin_add
     * @return \think\response\View|void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author: 子枫
     * @Time: 2019/11/13   10:48 下午
     */
    public function admin_add()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if(!request()->isPost()){
            $group_list =  ZFTB('admin_group')->where(['status'=>1])->select(); 
            $this->assign("group_list",$group_list);
            return view();   
        }  
        $data = input('post.');
        $data = array_merge($data,$this->common_tag);
        $data['pwd'] = md5($data['pwd']);
        $data['ctime'] = time();
        //判断是否存在
        $is_user =  ZFTB('admin')->where(['name'=>$data['name']])->find();
        if($is_user){
            return jserror('用户名已存在');exit;
        }
        $res =ZFTB('admin')->insert($data); 
        return ZFRetMsg($res,'新增成功','新增失败');
        
    }

    /**
     * @Notes:管理员修改
     * @Interface admin_edit
     * @return \think\response\View|void
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     * @author: 子枫
     * @Time: 2019/11/13   10:48 下午
     */
    public function admin_edit()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
    	if(request()->isGet()){
            $res = ZFTB('admin')->where(['id'=>input('id')])->find();
            $this->assign("res",$res);
            $group_list = ZFTB('admin_group')->where(['status'=>1])->select();
            $this->assign("group_list",$group_list);
            return view();
        } 
        if(request()->isPost()){
            $data = input('post.');
            if($data['name']=='admin' && session('admin')['name']!='admin' ){
                  return jserror('admin账号只能由Admin管理员修改');
            }
            if($data['pwd']!=''){
                $data['pwd'] = md5($data['pwd']);
            }else{
                unset($data['pwd']);
            }
            $is_user =  ZFTB('admin')->where(['name'=>$data['name']])->find();
            if($is_user){
                if($is_user['id']!=$data['id']){
                    return jserror('用户名已存在');exit;
                }
            }
            $res = ZFTB('admin')->where(['id'=>$data['id']])->update($data);
            return ZFRetMsg($res,'更新成功','更新失败');
            
        } 
    }

    /**
     * @Notes:管理员分类
     * @Interface admin_group
     * @return \think\response\View
     * @throws \think\exception\DbException
     * @author: 子枫
     * @Time: 2019/11/13   10:48 下午
     */
    public function admin_group()
    {
        admin_role_check($this->z_role_list,$this->mca);
        $group_list = ZFTB('admin_group')->where([['status','<>',9]])->order("id asc")->paginate(10);
        $page = $group_list->render();
        $this->assign("group_list",$group_list);
        $this->assign("page",$page);
        return view();
    }

    /**
     * @Notes:添加分类
     * @Interface admin_group_add
     * @return \think\response\View|void
     * @author: 子枫
     * @Time: 2019/11/13   10:48 下午
     */
    public function admin_group_add()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if(!request()->isPost()){
            return view();   
        } 
        $data = input('post.');
        $data = array_merge($data,$this->common_tag);
        $data['ctime'] = time();
        $res =ZFTB('admin_group')->insert($data);
        return ZFRetMsg($res,'新增成功','新增失败');
        
    }

    /**
     * @Notes:分类修改
     * @Interface admin_group_edit
     * @return \think\response\View|void
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     * @author: 子枫
     * @Time: 2019/11/13   10:49 下午
     */
    public function admin_group_edit()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
    	if(request()->isGet()){
            $res = ZFTB('admin_group')->where(['id'=>input('id')])->find(); 
            $this->assign("res",$res);
            return view();
        } 
        if(request()->isPost()){
            $data = input('post.');
            $res = ZFTB('admin_group')->where(['id'=>$data['id']])->update($data);
            return ZFRetMsg($res,'更新成功','更新失败');
            
        } 
    }

    /**
     * @Notes:权限设置
     * @Interface admin_group_role
     * @return \think\response\View|void
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     * @author: 子枫
     * @Time: 2019/11/13   10:49 下午
     */
    public function admin_group_role()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
    	if(request()->isGet()){
            $res = ZFTB('admin_role')->where(['status'=>1])->order('sort asc,id asc')->select();
            $cat = new category(array('id', 'pid', 'name', 'value')); //初始化无限分类
            $list = $cat->getTree($res); //获取分类数据树结构
            $this->assign("list",$list);
            $res = ZFTB('admin_group')->where(['id'=>input('id')])->find();
            $this->assign("res",$res);
            $role_list = explode(',',$res['role']);
            $this->assign("role_list",$role_list);
            return view();
        } 
        if(request()->isPost()){
            $data = input('post.');
            $data['role'] = implode(',',  $data['role']);
             $res = ZFTB('admin_group')->where(['id'=>$data['id']])->update($data);
            return ZFRetMsg($res,'更新成功','更新失败');
                
        } 
    }

    /**
     * @Notes:权限列表
     * @Interface admin_role
     * @return \think\response\View
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author: 子枫
     * @Time: 2019/11/13   10:50 下午
     */
    public function admin_role()
    {
        admin_role_check($this->z_role_list,$this->mca);
        //读取权限数据
        $res = ZFTB('admin_role')->where(['status'=>1])->order('menu desc,sort asc, id asc')->select(); 
        $cat = new category(array('id', 'pid', 'name', 'cname')); //初始化无限分类
        $list = $cat->getTree($res); //获取分类数据树结构
        $this->assign("list",$list);
        $controllers = getControllers('./application/admin/controller');// 控制器
        $this->assign("controllers",$controllers);
        return view();
    }

    /**
     * @Notes:获取方法
     * @Interface get_action
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author: 子枫
     * @Time: 2019/11/13   10:51 下午
     */
    public function get_action()
    {
        $control = input('get.control');
        //通过控制器查找已存在的方法
        $now_act = db('admin_role')->field("act")->where('control', $control)->select();
        if(!empty($now_act)){
            foreach($now_act as $k=>$vo){
                $now_act_now[$k] = $vo['act'];
            }
            $actions = getActions('app\admin\controller' . '\\' . $control);
            //筛选后的方法(未添加的)
            $fin_act = array_merge(array_diff($actions,$now_act_now));
        }else{
            $fin_act = getActions('app\admin\controller' . '\\' . $control);
        }        
        echo json_encode(array_values($fin_act));
    }

    /**
     * @Notes:权限增加
     * @Interface admin_role_add
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author: 子枫
     * @Time: 2019/11/13   10:52 下午
     */
    public function admin_role_add()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        //判断是否存在
        $val = input('post.');
        if($val['_control']!=''){
            $val['control'] = $val['_control'];
        }
        if($val['_act']!=''){
            $val['act'] = $val['_act'];
        }
        unset($val['_control']);
        unset($val['_act']);

        $value = $val['module'].'/'.$val['control'].'/'.$val['act'];
        $res1 = ZFTB('admin_role')->where(["value"=> $value,'parm'=>$val['parm']])->find();
        if($res1){
            if(in_array($val['act'], ['','0/0','/0','0/','/'])){
                return jserror('已存在该权限');exit;
            }
        }
        $data = $val;
        $data['value'] = $value;
        $data = array_merge($data,$this->common_tag);
        $res =ZFTB('admin_role')->insert($data); 
        return ZFRetMsg($res,'新增成功','新增失败');
         
    }

    /**
     * @Notes:权限修改
     * @Interface admin_role_edit
     * @return \think\response\View|void
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     * @author: 子枫
     * @Time: 2019/11/13   10:52 下午
     */
    public function admin_role_edit()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
    	if(request()->isGet()){
            $res = ZFTB('admin_role')->where(['status'=>1])->select();
            $cat = new category(array('id', 'pid', 'name', 'cname')); //初始化无限分类
            $list = $cat->getTree($res); //获取分类数据树结构
            $this->assign("list",$list);           
            $info = ZFTB('admin_role')->where(["id"=> input('id')])->find();
            $this->assign("res",$info);
            return view();
        } 
        if(request()->isPost()){
            $data = input('post.');
            $res = ZFTB('admin_role')->where(['id'=>$data['id']])->update($data);
            return ZFRetMsg($res,'更新成功','更新失败');  
        } 
    }

    
    

    /**
     * @Notes:操作日志
     * @Interface action_log
     * @return \think\response\View
     * @throws \think\exception\DbException
     * @author: 子枫
     * @Time: 2019/11/13   10:54 下午
     */
    public function action_log()
    {
        admin_role_check($this->z_role_list,$this->mca);
        $list = ZFTB('admin_log')->where(['status'=>1])->order("id desc")->paginate(10);
        $page = $list->render();
        $this->assign("list",$list);
        $this->assign("page",$page);
        return view();
    }


//自定义参数
    public function custom_config()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if(request()->isPost()){
            $data = input("post.");
            if($data['key']=='' ){
                return jserror('key不能为空');exit;
            }
            //判断键是否存在
            $is = ZFTB('config')->where([['key','=',$data['key']],['status','<>','9']])->find();
            if($is){
                return jserror('该键已存在');exit;
            }
            $res =ZFTB('config')->insert($data);
            return ZFRetMsg($res,'新增成功','新增失败');
        }

        $list = ZFTB('config')->where([['status','<>',9]])->order("sort desc,id asc")->select();
        $this->assign('list',$list);
        return view();
    }

    public function custom_config_edit($id)
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if(request()->isPost()){
            $data = input("post.");
            $res =  ZFTB('config')->where(['id'=>$data['id']])->update($data);
            return ZFRetMsg($res,'修改成功','修改失败'); 
        }
        $res = ZFTB('config')->where(['id'=>$id])->find();
        $this->assign('res',$res);
        return view();
    }



    
}
