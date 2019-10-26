<?php
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