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
if (!function_exists('ZFTB')) {
	function ZFTB($tb){
		$lang = session('zf_lang','');
		if($lang==''){
			return Db::name($tb);
		}else{
			return Db::name($lang.$tb);
		}
	}
}
if (!function_exists('ZFJoinStrLang')) {
	function ZFJoinStrLang($str=''){
		$lang = session('zf_lang','');
	    return 'zf_'.$lang.$str;
	}
}

function get_cate_list($id){
    $menu_r =ZFTB('category')->where(['pid'=>$id,'status'=>1,'menu'=>1])->order("sort asc")->select();
    return $menu_r;
}
//查询文章名称
function post_info($id){
    $res =ZFTB('post')->where(['status'=>1,'id'=>$id])->order("id desc")->find();
    return $res;
}
function product_cate_name($cid){
   $res =ZFTB('product_cate')->where(['status'=>1,'cid'=>$cid])->value('name');
    return $res;
}
//查询用户名字
function  user_name($id){
  $name =ZFTB('user')->where('id',$id)->value('name');
  if($name){
    return $name;
  }else{
    return false;
  }
}
function get_order_goods_list($oid,$limit='4'){
    $list =ZFTB('order_goods')->where('oid',$oid)->limit($limit)->order("id asc")->select();
    return $list;
}
function get_post_res($id){
    $list =ZFTB('post')->field("title,append,pic,id,price")->where('id',$id)->find();
    return $list;
}
function get_sku_info($data,$gid,$type=1){
    foreach ($data as $k => $vo) {
      $whereor[] = ['sku_id','=',$vo];
    }
    $r_parm =ZFTB('product_sku_info_parm')->field('info_id,id,sku_id ,count(id) as sumii')->whereor($whereor)->group('info_id')->where(function ($query)  use($gid) {
      $query->where(['uid'=>session('admin')['id'],'gid'=>$gid,'status'=>1]);
    })->order("sumii desc,id desc")->find();
    $info_id = $r_parm['info_id'];
    if($info_id){
      $res = ZFTB('product_sku_info')->where(['id'=>$info_id,'status'=>1])->find();
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
//     $menu_r =ZFTB('post')->field("title,append")->where('cid',$id)->where('status','1')->order("sort asc")->select();
//     return $menu_r;
// }

//通过父类id查询父类名称
function  p_name($id){
  $res =ZFTB('category')->where('cid',$id)->find();
  if($res){
    return $res['name'];
  }else{
    return false;
  }
}

//通过模型id查询模型名称
function  m_name($id){
  $res =ZFTB('category_model')->where('id',$id)->find();
  if($res){
    return $res['name'];
  }else{
    return false;
  }
}
//通过权限id查询权限名称
function  r_name($id){
  $res =ZFTB('admin_role')->where('id',$id)->find();
  if($res){
    return $res['name'];
  }else{
    return false;
  }
}
//通过用户组id查询用户组名称
function  user_group_name($id){
  $res =ZFTB('user_group')->where('id',$id)->find();
  if($res){
    return $res['name'];
  }else{
    return false;
  }
}

function get_cate_name($cate_tb,$id){
  $res =ZFTB($cate_tb)->where('id',$id)->find();
  if($res){
    return $res['name'];
  }else{
    return false;
  }
}
function get_post_number($cate_tb,$id,$t_cid='cid'){
  if($t_cid=='cid'){
    $res =ZFTB($cate_tb)->where([['cid','=',$id],['status','<>',9]])->count();
  }else{
    $res =ZFTB($cate_tb)->where([['id','=',$id],['status','<>',9]])->count();
  }
  if($res){
    return $res;
  }else{
    return 0;
  }
}
function get_caiji_log_sum($cid,$tb='caiji_list_log'){
    $sum =  ZFTB($tb)-> where(["cid"=>$cid] )->count();
    if($sum){
        return $sum;
    }else{
        return 0;
    }
}




// ------------后台数据库操作-----------------

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
    $menu_r =ZFTB('admin_role')->where([['pid','=',$id],['menu','=',1],['status','<>','9']])->order("sort asc")->select();
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
    $list =ZFTB('post')->where(['status'=>1])->order("id desc")->select();
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
    $res =ZFTB('post')->where(['status'=>1,'id'=>$id])->order("id desc")->value('title');
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
  $info =ZFTB('admin_group')->where('id',$id)->find();
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
  $res =ZFTB('category')->where([['pid','=',$cid],['status','<>',9]])->find();
  if($res){
    return true;
  }else{
    return false;
  }
}
