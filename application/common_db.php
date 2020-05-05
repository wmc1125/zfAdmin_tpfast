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
 * @Author: Eric-枫
 * @Date:   2019-09-18 13:28:30
 * @Last Modified by:   Eric-枫
 * @Last Modified time: 2019-09-25 11:02:05
 */
// ------------数据库操作-----------------

function get_cate_list($id){
    $menu_r =Db::name('category')->where(['pid'=>$id,'status'=>1,'menu'=>1])->order("sort asc")->select();
    return $menu_r;
}
//查询文章名称
function post_info($id){
    $res =Db::name('post')->where(['status'=>1,'id'=>$id])->order("id desc")->find();
    return $res;
}
function product_cate_name($cid){
   $res =Db::name('product_cate')->where(['status'=>1,'cid'=>$cid])->value('name');
    return $res;
}
//查询用户名字
function  user_name($id){
  $name =Db::name('user')->where('id',$id)->value('name');
  if($name){
    return $name;
  }else{
    return false;
  }
}
function get_order_goods_list($oid,$limit='4'){
    $list =Db::name('order_goods')->where('oid',$oid)->limit($limit)->order("id asc")->select();
    return $list;
}
function get_post_res($id){
    $list =Db::name('post')->field("title,append,pic,id,price")->where('id',$id)->find();
    return $list;
}
function get_sku_info($data,$gid,$type=1){
    foreach ($data as $k => $vo) {
      $whereor[] = ['sku_id','=',$vo];
    }
    $r_parm =Db::name('product_sku_info_parm')->field('info_id,id,sku_id ,count(id) as sumii')->whereor($whereor)->group('info_id')->where(function ($query)  use($gid) {
      $query->where(['uid'=>session('admin')['id'],'gid'=>$gid,'status'=>1]);
    })->order("sumii desc,id desc")->find();
    $info_id = $r_parm['info_id'];
    if($info_id){
      $res = Db::name('product_sku_info')->where(['id'=>$info_id,'status'=>1])->find();
      if($res){
        return $res;
      }else{
        return false;
      }
    }else{
      return false;
    }
}
// function get_category_list($id){
//     $menu_r =Db::name('post')->field("title,append")->where('cid',$id)->where('status','1')->order("sort asc")->select();
//     return $menu_r;
// }

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

function get_cate_name($cate_tb,$id){
  $res =Db::name($cate_tb)->where('id',$id)->find();
  if($res){
    return $res['name'];
  }else{
    return false;
  }
}
function get_post_number($cate_tb,$id){
  $res =Db::name($cate_tb)->where([['cid','=',$id],['status','=',1]])->count();
  if($res){
    return $res;
  }else{
    return 0;
  }
}
function get_caiji_log_sum($cid){
    $sum =  Db::name("caiji_list_log")-> where(["cid"=>$cid] )->count();
    if($sum){
        return $sum;
    }else{
        return 0;
    }
}