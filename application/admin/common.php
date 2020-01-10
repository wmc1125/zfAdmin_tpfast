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
/**
 * @Notes: 后台权限  0 get ajax 全部验证  1 只验证ajax
 * @Interface admin_role_check
 * @param array $z_role_list
 * @param string $mca
 * @param int $type
 * @author: 子枫
 * @Time: 2019/11/13   11:05 下午
 */
function admin_role_check($z_role_list=[],$mca='',$type=0){
  if(session("admin.gid")!=3){
      if (!in_array($mca, $z_role_list)) {
          if (request()->isAjax()) {
              header('Content-Type:application/json');
              return jserror('没有权限');die;
          }
          if($type==0){
            echo "<script> alert('没有权限')</script>";die;
          }

      }
  }
}


/**
 * @Notes:查询子菜单
 * @Interface get_two_menu
 * @param $id
 * @return array|PDOStatement|string|\think\Collection
 * @throws \think\db\exception\DataNotFoundException
 * @throws \think\db\exception\ModelNotFoundException
 * @throws \think\exception\DbException
 * @author: 子枫
 * @Time: 2019/11/13   11:06 下午
 */
function get_two_menu($id){
    $menu_r =Db::name('admin_role')->where('pid',$id)->where('menu','1')->order("sort asc")->select();
    return $menu_r;
}

/**
 * @Notes:查询所有的文章
 * @Interface post_list_all
 * @return array|PDOStatement|string|\think\Collection
 * @throws \think\db\exception\DataNotFoundException
 * @throws \think\db\exception\ModelNotFoundException
 * @throws \think\exception\DbException
 * @author: 子枫
 * @Time: 2019/11/13   11:06 下午
 */
function post_list_all(){
    $list =Db::name('post')->where(['status'=>1])->order("id desc")->select();
    return $list;
}

/**
 * @Notes:查询文章名称
 * @Interface post_name
 * @param $id
 * @return mixed
 * @author: 子枫
 * @Time: 2019/11/13   11:07 下午
 */
function post_name($id){
    $res =Db::name('post')->where(['status'=>1,'id'=>$id])->order("id desc")->value('title');
    return $res;
}

/**
 * @Notes:通过id查询管理员的分类名
 * @Interface get_admin_group_name
 * @param $id
 * @return mixed
 * @throws \think\db\exception\DataNotFoundException
 * @throws \think\db\exception\ModelNotFoundException
 * @throws \think\exception\DbException
 * @author: 子枫
 * @Time: 2019/11/13   11:07 下午
 */
function get_admin_group_name($id){
  $info =Db::name('admin_group')->where('id',$id)->find();
  return $info['name'];
}

/**
 * @Notes:读取权限,并组成数组
 * @Interface get_admin_role
 * @param $gid
 * @return mixed
 * @throws \think\db\exception\DataNotFoundException
 * @throws \think\db\exception\ModelNotFoundException
 * @throws \think\exception\DbException
 * @author: 子枫
 * @Time: 2019/11/13   11:07 下午
 */
function get_admin_role($gid){
  $info =Db::name('admin_group')->where('id',$gid)->find();
  $role = explode(',',$info['role']);
  foreach($role as $k=>$vo){
    $role_list[$k] = get_role_value($vo);
  }
  return $role_list;
}

/**
 * @Notes:通过id,获取权限value(控制器/方法)
 * @Interface get_role_value
 * @param $id
 * @return mixed
 * @throws \think\db\exception\DataNotFoundException
 * @throws \think\db\exception\ModelNotFoundException
 * @throws \think\exception\DbException
 * @author: 子枫
 * @Time: 2019/11/13   11:07 下午
 */
function get_role_value($id){
  $info =Db::name('admin_role')->where('id',$id)->find();
  return $info['value'];
}

/**
 * @Notes:判断该栏目是否有子类
 * @Interface if_pid
 * @param $cid
 * @return bool
 * @throws \think\db\exception\DataNotFoundException
 * @throws \think\db\exception\ModelNotFoundException
 * @throws \think\exception\DbException
 * @author: 子枫
 * @Time: 2019/11/13   11:07 下午
 */
function  if_pid($cid){
  $res =Db::name('category')->where('pid',$cid)->find();
  if($res){
    return true;
  }else{
    return false;
  }
}
