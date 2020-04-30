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
use Wmc1125\TpFast\Category as cat; 

class Cpost extends Admin
{
    public function __construct()
    {
        parent::__construct();
        $_name = $c =  strtolower(request()->controller());
        $this->tpl_config = [
            'cate_tb'=>'pro_'.$_name.'_cate',
            'post_tb'=>'pro_'.$_name.'_post',
            'name'=>'pro_'.$_name,
            'post_add_url'=>'/admin/'.$_name.'/add',
            'post_edit_url'=>'/admin/'.$_name.'/edit',
            'cate_add_url'=>$_name.'/cate_add',
            'cate_edit_url'=>'/admin/'.$_name.'/cate_edit',
            'cate_edit_a_url'=>$_name.'/cate_edit',
            'list_url'=>'/admin/'.$_name.'/index',
        ];
        $this->assign('tpl_config',$this->tpl_config);
    }

    public function index()
    {
        admin_role_check($this->z_role_list,$this->mca);
        $cid = input('cid','');
        if($cid!='' && $cid!='{cid'){
            $where[] = ['cid','=',$cid];
        }
        $where[] = ['status','<>',9];
        $list = Db::name($this->tpl_config['post_tb'])->where($where)->order("sort","desc")->order('id','desc')->paginate(10);
        $page = $list->render();
        $this->assign("page",$page);
        $this->assign('list',$list);
        $this->assign('cid',$cid);
        return view();
    }


     public function add()
     {
         admin_role_check($this->z_role_list,$this->mca,1);
         if(request()->isPost()){
             $data = input('post.');
             $data['ctime'] = time();
             $res = Db::name($this->tpl_config['post_tb'])->insert($data);
             if($res){
                 return jssuccess('新增成功');
             }else{
                 return jserror('新增失败');exit;
             }
         }
         $_list = Db::name($this->tpl_config['cate_tb'])->where([['status','=',1]])->order("id asc")->select();
         $cat = new cat(array('id', 'pid', 'name', 'cname')); //初始化无限分类
         $plist = $cat->getTree($_list); //获取分类数据树结构
         if(!$plist){
             $plist = [];
         }
         $cid = input('cid');
         $this->assign('plist',$plist);
         $this->assign('cid',$cid);
         return view();

     }


    public function edit($id)
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if(request()->isPost()){
            $data = input('post.');
            if($data['pic']==''  && isset($data['content'])){
                $data['pic'] = GetImgSrc::src($data['content'], 1);
            }
            $res = Db::name($this->tpl_config['post_tb'])->where('id',$data['id'])->update($data);
            if($res)
            {
                return jssuccess('修改成功');
            }else{
                return jserror('修改失败');
            }
        }
        $res =  Db::name($this->tpl_config['post_tb'])->where([['id','=',$id]])->find();
//        $plist = Db::name($this->tpl_config['cate_tb'])->where([['status','<>',9]])->order("id asc")->paginate('10');
        $_list = Db::name($this->tpl_config['cate_tb'])->where([['status','=',1]])->order("id asc")->select();
        $cat = new cat(array('id', 'pid', 'name', 'cname')); //初始化无限分类
        $plist = $cat->getTree($_list); //获取分类数据树结构
        if(!$plist){
            $plist = [];
        }
        $this->assign('plist',$plist);
        $this->assign('res',$res);
        $this->assign('data_res',$res);
        $this->assign('cid',$res['cid']);
        return view();

    }
    public function cate()
    {
        admin_role_check($this->z_role_list,$this->mca);
        $res = Db::name($this->tpl_config['cate_tb'])->where([['status','<>',9]])->order("id asc")->select();
        $cat = new cat(array('id', 'pid', 'name', 'cname')); //初始化无限分类
        $list = $cat->getTree($res); //获取分类数据树结构
        if(!$list){
            $list = [];
        }
        $this->assign('list',$list);
        return view();
    }



    public function cate_add()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if(request()->isPost()){
            $data = input("post.");
            if($data['name']=='' ){
                return jserror('请填写信息');exit;
            }
            $res =Db::name($this->tpl_config['cate_tb'])->insert($data);
            if($res){
                return jssuccess('新增成功');
            }else{
                return jserror('新增失败');exit;
            }
        }
        return view();
    }


    public function cate_edit($id)
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if(request()->isPost()){
            $data = input("post.");
            $res =  Db::name($this->tpl_config['cate_tb'])->where(['id'=>$data['id']])->update($data);
            if($res){
                return jssuccess('修改成功');
            }else{
                return jserror('修改失败');
            }
        }
        $res = Db::name($this->tpl_config['cate_tb'])->where(['id'=>$id])->find();
        $_list = Db::name($this->tpl_config['cate_tb'])->where([['status','<>',9]])->order("id asc")->select();
        $cat = new cat(array('id', 'pid', 'name', 'cname')); //初始化无限分类
        $plist = $cat->getTree($_list); //获取分类数据树结构
        if(!$plist){
            $plist = [];
        }
        $this->assign('plist',$plist);
        $this->assign('res',$res);
        return view();
    }
//    保存图片
//     public function get_content_pic_list(){
//         admin_role_check($this->z_role_list,$this->mca);
//         $id = $request->get("id");
//         $data = Db::name($this->tpl_config['post_tb'])->where(['id'=>$id])->find();
//         //查询采集ID
//         $cj_res = Db::name("caiji_list_log")->where(['id'=>$data->cj_id])->find();
//         if($cj_res){
//             $cj_par_res = Db::name("caiji")->where(['id'=>$cj_res->cid])->find();
//         }
//         $content = $data->content;
//         for($i=1;$i<=100;$i++){
//             $parm_list_src[$i]['post_id'] = $id;
//             $parm_list_src[$i]['cid'] = $data->cid;
//             $parm_list_src[$i]['ctime'] = time() ;
//             $parm_list_src[$i]['status'] = 1;
//             $parm_list_src[$i]['title'] = $data->title;
//             $parm_list_src[$i]['pic'] = GetImgSrc::src($content, $i);
//             if(empty($parm_list_src[$i]['pic'])){
//                 unset($parm_list_src[$i]);
//                 break;
//             }
//         }
//         foreach($parm_list_src as $k=>$vo){
//             $_is = Db::name($this->tpl_config['post_tb'])->where(['pic'=>$vo['pic'],'post_id'=>$vo['post_id']])->value('id');
//             if(!$_is){
//                 Db::name($this->tpl_config['post_tb'])->insert($vo);
//             }
//         }
//         return jssuccess('已保存');
//     }


// //    ajax其他图片保存到oss
//     public function ajax_save_oss_ali(){
//         $t = $request->get("t" );
//         if($t && $t=='some'){
//             $where[] = ['pic','<>',''];
//             $where[] = ['status','=',1];
//             $where[] = ['pic','not like','%wangmingchang.com%'];
//             $list = objectToArrayLaravel(Db::name($this->tpl_config['post_tb'])->where($where)->order("sort","desc")->order('id','desc')->paginate(10));
//             $succ_num =0;
//             $err_num =0;
//             foreach($list['data'] as $k=>$vo){
//                 if($vo['pic'] && strpos($vo['pic'],'wangmingchang.com') == false){
//                     $save_res = $this->ajax_save_oss($vo['id']);
//                     if($save_res){
//                         $succ_num++;
//                     }else{
//                         $err_num++;
//                     }
//                 }
//             }
//             return jssuccess("成功数:".$succ_num.'   失败数:'.$err_num );
//         }else{
//             $id = $request->get("id");
//             if($this->ajax_save_oss($id)){
//                 return jssuccess("保存成功");
//             }else {
//                 return error("保存失败");
//             }
//         }
//     }
//     private function ajax_save_oss($id){
//         $res =  Db::name($this->tpl_config['post_tb'])->where([['id','=',$id]])->find();
//         $imgurl = $res->pic;
//         if(is_int(strpos($imgurl, 'http'))){
//             $arcurl = $imgurl;
//         }
//         $parse = parse_url($arcurl);
//         $ext =  pathinfo($parse['path'],PATHINFO_EXTENSION);
//         $img=file_get_contents($arcurl);
//         $dirslsitss = '/uploads/ajx_oss';//分类是否存在
//         if(!empty($img)) {
//             //保存图片到服务器
//             $fileimgname = time()."-".rand(1000,9999).".".$ext;
//             $filecachs=$dirslsitss."/".$fileimgname;
//             //判断保存到oss
//             if(config('zf_web.save_type')=='aliyun_oss'){
//                 $ret = aliyun_oss_picliu($dirslsitss,$fileimgname,$img);
//                 $saveimgfile = $ret['url'];
//                 if($saveimgfile){
//                     $up =  Db::name($this->tpl_config['post_tb'])->where([['id','=',$id]])->update(['pic'=>$saveimgfile]);
//                     if($up){
//                         return true;
//                     }
//                 }
//                 return false;

// //                $xstr=str_replace($imgurl,$saveimgfile,$xstr);
//             }else{
//                 return jserror("请开启阿里云oss存储");
//             }
//         }
//     }
  


}
