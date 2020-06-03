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
    $menu_r =Db::name('admin_role')->where([['pid','=',$id],['menu','=',1],['status','<>','9']])->order("sort asc")->select();
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
  $res =Db::name('category')->where([['pid','=',$cid],['status','<>',9]])->find();
  if($res){
    return true;
  }else{
    return false;
  }
}
