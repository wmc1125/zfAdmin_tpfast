<?php
use think\Db;
//后台权限  0 get ajax 全部验证  1 只验证ajax
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



// 查询子菜单
function get_two_menu($id){
    $menu_r =Db::name('admin_role')->where('pid',$id)->where('menu','1')->order("sort asc")->select();
    return $menu_r;
}
//查询所有的文章
function post_list_all(){
    $list =Db::name('post')->where(['status'=>1])->order("id desc")->select();
    return $list;
}
//查询文章名称
function post_name($id){
    $res =Db::name('post')->where(['status'=>1,'id'=>$id])->order("id desc")->value('title');
    return $res;
}

// 通过id查询管理员的分类名
function get_admin_group_name($id){
  $info =Db::name('admin_group')->where('id',$id)->find();
  return $info['name'];
}
//读取权限,并组成数组
function get_admin_role($gid){
  $info =Db::name('admin_group')->where('id',$gid)->find();
  $role = explode(',',$info['role']);
  foreach($role as $k=>$vo){
    $role_list[$k] = get_role_value($vo);
  }
  return $role_list;
}
//通过id,获取权限value(控制器/方法)
function get_role_value($id){
  $info =Db::name('admin_role')->where('id',$id)->find();
  return $info['value'];
}

// 判断该栏目是否有子类
function  if_pid($cid){
  $res =Db::name('category')->where('pid',$cid)->find();
  if($res){
    return true;
  }else{
    return false;
  }
}
//通过父类id查询父类名称
function  p_name($id){
  $res =Db::name('category')->where('cid',$id)->find();
  if($res){
    return $res['name'];
  }else{
    return false;
  }
}
//通过模型id查询模型名称
function  m_name($id){
  $res =Db::name('category_model')->where('id',$id)->find();
  if($res){
    return $res['name'];
  }else{
    return false;
  }
}
//通过权限id查询权限名称
function  r_name($id){
  $res =Db::name('admin_role')->where('id',$id)->find();
  if($res){
    return $res['name'];
  }else{
    return false;
  }
}
//通过用户组id查询用户组名称
function  user_group_name($id){
  $res =Db::name('user_group')->where('id',$id)->find();
  if($res){
    return $res['name'];
  }else{
    return false;
  }
}