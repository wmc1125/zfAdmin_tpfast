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

class Wechat extends Admin
{
    public function __construct (){
        parent::__construct();
    }

    
    public function index(){
        // $this->test();die;
        echo '公众号<br>';
        
        //基本设置

        //菜单

        //回复

        //素材×




        // echo '-------------';
        // echo '小程序<br>';
        // echo '-------------';
        // echo '开放平台<br>';
        // echo '-------------';
        // echo '支付<br>';
        // echo '-------------';
    }
    public function gzh_setting(){

        admin_role_check($this->z_role_list,$this->mca,1);
        if(request()->isPost()){
            $data = request()->post();
            $res = Db::name('wx_config')->where(['uid'=>session('admin')['id'],'id'=>$data['id']])->update($data);
            return ZFRetMsg($res,'修改成功','修改失败');
        }
        $data = Db::name('wx_config')->where(['uid'=>session('admin')['id']])->find();
        if(!$data){
            $is = Db::name('wx_config')->insert(['uid'=>session('admin')['id']]);
            $data = Db::name('wx_config')->where(['uid'=>session('admin')['id']])->find();
        }
        $this->assign('data',$data);
        return view();
    }
    public function gzh_menu(){
        die('未开发');
        $data = [];
        return view($this->tpl,compact('data'));
    }

    public function gzh_automsg(Request $request,$cid=''){
        

        admin_role_check($this->z_role_list,$this->mca);
        if($cid!='' && $cid!='{cid'){
            $where[] = ['cid','=',$cid];
        }
        $where[] = ['status','<>',9];
        $where[] = ['cuid','=',session('admin')['id']];
        // $list = Db::name($this->tpl_config['post_tb'])->where($where)->order("sort desc")->order('id desc')->paginate(10);

        // return view($this->c_tpl,compact('list','cid'));
        $list = Db::name('wx_gzh_automsg')->where($where)->order("sort desc,id desc")->paginate(10);
        $this->assign('list',$list);
        $this->assign('cid',$cid);

        return view();


    }
    public function gzh_automsg_add(Request $request)
     {
         admin_role_check($this->z_role_list,$this->mca,1);
         if($request->isPost()){
             $data = $request->post();
             $data['ctime'] = time();
             $data['cuid'] = session('admin')['id'];
             $res = Db::name('wx_gzh_automsg')->insert($data);
            return ZFRetMsg($res,'新增成功','新增失败');
             
         }
         $cid = $request->get('cid');
         return view($this->tpl,compact('cid'));

     }


    public function gzh_automsg_edit(Request $request,$id)
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if($request->post()){
            $data = $request->post();
            $res = Db::name('wx_gzh_automsg')->where('id',$data['id'])->update($data);
            return ZFRetMsg($res,'更新成功','更新失败');
            
        }
        $res =  Db::name('wx_gzh_automsg')->where([['id','=',$id]])->find();
//        $plist = Db::name($this->tpl_config['cate_tb'])->where([['status','<>',9]])->order("id","asc")->paginate('10');
        
        return view($this->tpl,compact('res'));

    }
    public function gzh_media(Request $request){
        admin_role_check($this->z_role_list,$this->mca);
        $this->conf(session('admin')['id']);
        $type = 'image';
        $offset = 0;
        $count = 20;
        $list = $this->app->material->list($type, $offset, $count);
        
        
        // dd($list);
        return view($this->tpl,compact('list','type'));


    }
    public function gzh_media_add(Request $request)
     {
         admin_role_check($this->z_role_list,$this->mca,1);
         if($request->isPost()){
             $data = $request->post();
             $data['ctime'] = time();
             $data['cuid'] = session('admin')['id'];
             $res = Db::name('wx_gzh_media')->insert($data);
            return ZFRetMsg($res,'新增成功','新增失败');
             
         }
         $cid = $request->get('cid');
         return view($this->tpl,compact('cid'));

     }


    public function gzh_media_edit(Request $request,$id)
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if(request()->isPost()){
            $data = $request->post();
            $res = Db::name('wx_gzh_media')->where('id',$data['id'])->update($data);
            return ZFRetMsg($res,'更新成功','更新失败');
            
        }
        $res =  Db::name('wx_gzh_media')->where([['id','=',$id]])->find();
//        $plist = Db::name($this->tpl_config['cate_tb'])->where([['status','<>',9]])->order("id","asc")->paginate('10');
        
        return view($this->tpl,compact('res'));

    }

    public function gzh_user(){
        admin_role_check($this->z_role_list,$this->mca,1);


        $this->conf(session('admin')['id']);



        $where[] = ['u.status','<>','9'];
        $where[] = ['u.openid','<>',''];
        $list = Db::name('user as u')
                    ->select('u.*','g.name as gname','u.ctime', 'u.tel as mobile')
                    ->join('user_group as g', function ($join) {
                        $join->on('u.gid', '=', 'g.id')
                             ->where('g.status', '<>', 9);
                    })
                    ->where($where)
                    ->order("u.id desc")
                    ->paginate(10);
        return view($this->tpl,compact('list'));
    }

    public function gzh_automsg_send(Request $request,$openid=''){
        admin_role_check($this->z_role_list,$this->mca,1);
        if(request()->isPost()){
            $data = $request->post();
            $res = Db::name('wx_gzh_media')->where('id',$data['id'])->update($data);
            return ZFRetMsg($res,'发送成功','发送失败');
            
        }
        $list =  Db::name('wx_gzh_automsg_send_log')->where([['openid','=',$openid]])->order('ctime desc')->select();
        return view($this->tpl,compact('openid','list'));

    }
    public function ajax_action(Request $request){
        //获取公众号全部用户openid
        $this->conf(session('admin')['id']);
        $act = $request->get('type','');
        if($act=='ajax_import_gzh_openid'){
            $list = Db::name('user')->where([['openid','<>','']])->order("id desc")->select('openid')->select();
            foreach (objectToArrayLaravel($list) as $key => $value) {
                $_list[] = $value['openid'];
            }
            // 获取用户列表
            $gzh_list = $this->app->user->list();  
            foreach($gzh_list['data']['openid'] as $k=>$vo){
                if(!in_array($vo, $_list)){
                    //新增
                    Db::name('user')->insert(['openid'=>$vo,'ctime'=>time(),'type'=>'导入','name'=>'未激活用户']);

                }
            }
            return jssuccess('已导入');
        }elseif($act=='send_simple_gzhmsg'){
            //发送信息
            $data = $request->post();
            //保存用户搜索记录
            $save_res['openid'] = $data['openid'];
            $save_res['event'] = '管理员主动发送';
            $save_res['keyword'] = '';
            $save_res['status'] = 1;
            $save_res['ctime'] = time();
            $save_res['send_ids'] = '';
            $save_res['send_content'] = $data['content'];
            $save_res['gzh_id'] = '';
            $id = Db::name('wx_gzh_automsg_send_log')->insertGetId($save_res);
            $res = $this->app->customer_service->message($data['content'])->to($data['openid'])->send();
            if($res['errmsg']=='ok'){
                return jssuccess('发送成功');
            }else{
                Db::name('wx_gzh_automsg_send_log')->where(['id'=>$id])->delete();
                return jserror('发送失败'.$res['errmsg']);
            }

        }elseif($act=='get_simple_user'){
            // 获取公众号用户信息
            $openid = $request->get('openid','');
            $user = $this->app->user->get($openid);
            $data['name'] = $user['nickname'];
            $data['nickName'] = $user['nickname'];
            $data['sex'] = $user['sex']==2?0:1;
            $data['pic'] = $user['headimgurl'];
            $r = Db::name('user')->where(['openid'=>$openid])->update($data);
            return ZFRetMsg($r,'获取成功','获取失败');
        }
    }

    
    private function conf($gid){
        if($gid==''){
            $this->app = app('wechat.official_account');
            $this->gid = '';
        }else{
            $this->gid = $gid;
            $g_res = Db::name('wx_config')->where([['uid','=',$gid]])->find();
            $this->g_res = $g_res;
            if(!$g_res){    echo '账号不存在'; die; }
            if($g_res->status!=1){ echo '账户已被关闭';die; }
            $options = [
                'app_id'    => $g_res->gzh_app_id,
                'secret'    => $g_res->gzh_secret,
                'token'     => $g_res->gzh_token,
                'aes_key' =>$g_res->gzh_aes_key
            ];
            $this->app = Factory::officialAccount($options);
        }
    }


    public function test(){
        

    }
    


    
}
