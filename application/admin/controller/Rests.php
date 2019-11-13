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

class Rests extends Admin
{
    public function __construct (){
        parent::__construct();
    }
    //广告总列表
    public function advert()
    {
        admin_role_check($this->z_role_list,$this->mca);
        if(input('type')=='child'){
            $pid = input('id');
            $tpl='rests/advert_child';
            $list = Db::name('advert')->where('pid',$pid)->where('status!=9')->order("sort asc")->paginate(999);
            $this->assign("pid",$pid);
        }else{
            $tpl='';
            $list = Db::name('advert')->where('pid',0)->where('status!=9')->order("sort asc")->paginate(999);
        }
        $page = $list->render();
        $this->assign("list",$list);
        $this->assign("page",$page);
        return view($tpl);
    }

    //添加
    public function advert_add()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if(!request()->isPost()){
            if(input('type')=='child'){
                $tpl="rests/advert_add_child";   
                $this->assign("pid",input("pid"));
            }else{
                $tpl='';
            }
            return view($tpl);
        }  
        $data = input("post.");
        if($data['name']==''){
            return jserror('名称不能为空');exit;
        }
        $data = array_merge($data,$this->common_tag);
        $res = Db::name('advert')->insert($data);
        if($res){
            return jssuccess('新增成功');
        }else{
            return jserror('新增失败');exit;
        }  
    }
    //修改
    public function advert_edit()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
    	if(request()->isGet()){
            $res =  Db::name('advert')->where(['id'=>input('id')])->find(); 
            $this->assign("res",$res);
            if(input('type')=='child'){
                $tpl="rests/advert_edit_child";   
                $this->assign("pid",input("pid"));
            }else{
                $tpl='';
            }
            return view($tpl);
        } 
        if(request()->isPost()){
            $data = input('post.');
            if($data['name']==''){
                return jserror('名称不能为空');exit;
            }
            $res = Db::name('advert')->where(['id'=>$data['id']])->update($data);
            if($res)
            {
                return jssuccess('修改成功');
            }else{
                return jserror('修改失败');
            }   
        } 
    } 
    //link
     public function link()
    {
        admin_role_check($this->z_role_list,$this->mca);
        $list = Db::name('link')->where('status!=9')->order("sort asc")->paginate(999);
        $page = $list->render();
        $this->assign("list",$list);
        $this->assign("page",$page);
        return view();
    }

    //添加
    public function link_add()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if(!request()->isPost()){
            return view();
        }  
        $data = input("post.");
        if($data['name']==''){
            return jserror('请填写信息');exit;
        }
        $data = array_merge($data,$this->common_tag);
        $res = Db::name('link')->insert($data);
        if($res){
            return jssuccess('新增成功');
        }else{
            return jserror('新增失败');exit;
        }  
    }
    //修改
    public function link_edit()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if(request()->isGet()){
            $res =  Db::name('link')->where(['id'=>input('id')])->find(); 
            $this->assign("res",$res);
            return view();
        } 
        if(request()->isPost()){
           $data = input('post.');
            $res = Db::name('link')->where(['id'=>$data['id']])->update($data);
            if($res)
            {
                return jssuccess('修改成功');
            }else{
                return jserror('修改失败');
            }   
        } 
    }

    //guessbook
     public function guessbook()
    {   
        admin_role_check($this->z_role_list,$this->mca);
        $list = Db::name('guessbook')->where('status!=9')->order("ctime desc,sort asc")->paginate(999);
        $page = $list->render();
        $this->assign("list",$list);
        $this->assign("page",$page);
        return view();
    }
    //添加
    public function guessbook_add()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if(!request()->isPost()){
            return view();
        }  
        $data = input("post.");
        if($data['name']==''){
            return jserror('请填写信息');exit;
        }
        $data['ctime'] = time();
        $data = array_merge($data,$this->common_tag);
        $res = Db::name('guessbook')->insert($data);
        if($res){
            return jssuccess('新增成功');
        }else{
            return jserror('新增失败');exit;
        }  
    }
    //修改
    public function guessbook_edit()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if(request()->isGet()){
            $res =  Db::name('guessbook')->where(['id'=>input('id')])->find(); 
            $this->assign("res",$res);
            return view();
        } 
        if(request()->isPost()){
            $data = input('post.');
            $res = Db::name('guessbook')->where(['id'=>$data['id']])->update($data);
            if($res)
            {
                return jssuccess('修改成功');
            }else{
                return jserror('修改失败');
            }   
        } 
    }
  


}
