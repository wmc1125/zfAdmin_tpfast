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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Wmc1125\TpFast\GoogleAuthenticator;

class User extends Admin
{
    public function __construct (){
        parent::__construct();
    }

    /**
     * @Notes:用户列表
     * @Interface index
     * @return \think\response\Json|\think\response\View
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author: 子枫
     * @Time: 2019/11/13   11:02 下午
     */
    public function index()
    {
        admin_role_check($this->z_role_list,$this->mca);
        if(request()->isAjax()){
            $page = input('page',1);
            $limit = input('limit',10);
            $key = input('key',[]);
            foreach($key as $k=>$vo){
                $where[] =  ['u.'.$k,'like','%'.$vo.'%'];
            }
            $where[] = ['u.status','<>','9'];
            if(input("get.id")){
                $id = input("get.id");
                $where[] = ['u.id','=',$id];
            }
            $waiterData = Db::name('user u')
                        ->field('u.*,g.name gname,FROM_UNIXTIME(u.ctime, "%Y-%m-%d %H:%i:%s") AS dat, insert(u.tel, 4, 4, "****") as mobile')
                        ->join('zf_user_group g','g.id = u.gid')
                        ->where($where)
                        ->order("u.id desc")
                        ->page($page,$limit)
                        ->select();
            $allcount = Db::name('user u')
                        ->join('zf_user_group g','g.id = u.gid')
                        ->where($where)
                        ->count();
            $res = [
                  'code'=>0,
                  'msg'=>'返回成功',
                  'count'=>$allcount,
                  'data'=>$waiterData
            ];
            return json($res);
        } 
        return view();
    }

    /**
     * @Notes:添加新用户
     * @Interface add
     * @return \think\response\View|void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author: 子枫
     * @Time: 2019/11/13   11:02 下午
     */
    public function add()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if(!request()->isPost()){ 
            $glist = Db::name('user_group')->where(['status'=>1])->select();
            $this->assign("glist",$glist);
            return view();   
        }  
        $data = input('post.');
        $data['ctime'] = time();
        if($data['pwd']!=''){
            $data['pwd'] = md5($data['pwd']);
        }
        $data = array_merge($data,$this->common_tag);
        //判断是否存在
        $is_user =  Db::name('user')->where(['name'=>$data['name']])->find();
        if($is_user){
            return jserror('用户名已存在');exit;
        }

        $res = Db::name('user')->insert($data);
        return ZFRetMsg($res,'新增成功','新增失败');
         
    }

    /**
     * @Notes:用户修改
     * @Interface edit
     * @return \think\response\View|void
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     * @author: 子枫
     * @Time: 2019/11/13   11:02 下午
     */
    public function edit()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
    	if(request()->isGet()){
            $res =  Db::name('user')->where(['id'=>input('id')])->find();
            $this->assign("res",$res);
            $glist =  Db::name('user_group')->where(['status'=>1])->select();
            $this->assign("glist",$glist);
            return view();
        } 
        if(request()->isPost()){
            $data = input('post.');
            if($data['pwd']!= ''){
                $data['pwd'] = md5($data['pwd']);
            }else{
                unset($data["pwd"]);
            }
            $data['ctime'] = time();
            $is_user =  Db::name('user')->where(['name'=>$data['name']])->find();
            if($is_user){
                if($is_user['id']!=$data['id']){
                    return jserror('用户名已存在');exit;
                }
            }

            $res = Db::name('user')->where(['id'=>$data['id']])->update($data);
            return ZFRetMsg($res,'修改成功','修改失败');
              
        } 
    }

    /**
     * @Notes:用户分类
     * @Interface group
     * @return \think\response\View
     * @throws \think\exception\DbException
     * @author: 子枫
     * @Time: 2019/11/13   11:03 下午
     */
    public function group()
    {
        admin_role_check($this->z_role_list,$this->mca);
        $group_list = Db::name('user_group')->where('status!=9')->order("id asc")->paginate(10);
        $page = $group_list->render();
        $this->assign("group_list",$group_list);
        $this->assign("page",$page);
        return view();
    }

    /**
     * @Notes:添加分类
     * @Interface group_add
     * @return \think\response\View|void
     * @author: 子枫
     * @Time: 2019/11/13   11:03 下午
     */
    public function group_add()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if(request()->isPost()){ 
            $data = input('post.');
            $data['ctime'] = time();
            $data = array_merge($data,$this->common_tag);
            $res =Db::name('user_group')->insert($data);
            return ZFRetMsg($res,'新增成功','新增失败');
           
        }  
            return view();   

         
    }

    /**
     * @Notes:分类修改
     * @Interface group_edit
     * @return \think\response\View|void
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     * @author: 子枫
     * @Time: 2019/11/13   11:03 下午
     */
    public function group_edit()
    {
        admin_role_check($this->z_role_list,$this->mca,1);   
        if(request()->isPost()){
            $data = input('post.');
            $res = Db::name('user_group')->where(['id'=>$data['id']])->update($data); 
            return ZFRetMsg($res,'修改成功','修改失败');
             
        } 
        $res =  Db::name('user_group')->where(['id'=>input('id')])->find();
        $this->assign("res",$res);
        return view();
    }

    /**
     * @Notes:密码修改
     * @Interface pwd_edit
     * @return \think\response\View|void
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * @author: 子枫
     * @Time: 2019/11/13   11:03 下午
     */
    public function pwd_edit()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if(request()->isPost()){
            $data = input('post.');
            $data['pwd'] = md5($data['pwd']);
            $res = Db::name('admin')->where(['id'=>$data['id']])->update($data);
              if($res){ 
                  session('admin',null);
                  return jssuccess('修改成功');
              }else{
                  return jserror('修改失败');
              }   
        } else{
            return view();
        }
    }

    /**
     * @Notes:后台用户信息
     * @Interface admin_info
     * @return \think\response\View|void
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     * @author: 子枫
     * @Time: 2019/11/13   11:04 下午
     */
    public function admin_info()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if(request()->isPost()){
            $data = input('post.');
            $res = Db::name('admin')->where(['id'=>$data['id']])->update($data);
            return ZFRetMsg($res,'修改成功','修改失败');
            
        } 
        $id = session('admin.id');
        $res = Db::name('admin')->where(['id'=>$id])->find();
        $this->assign('res',$res);
        $ga = new GoogleAuthenticator();
        if($res['google_secret']!=''){
            $secret = $res['google_secret'];
        }else{
            $secret = $ga->createSecret();
        }
        $qrCodeUrl = 'http://mctool.wangmingchang.com/api/tool/create_qr_code?t=google&name=zf-'.$id.'&secret='.$secret;
        $this->assign('secret',$secret);
        $this->assign('qrCodeUrl',$qrCodeUrl);
        return view();
    }

    /**
     * @Notes:导出
     * @Interface export
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author: 子枫
     * @Time: 2019/11/13   11:04 下午
     */
    public function export(){
        admin_role_check($this->z_role_list,$this->mca);
        if (!is_dir('./vendor/phpoffice/phpspreadsheet')) {
            $this->error('PhpSpreadsheet扩展(phpoffice/phpspreadsheet)未安装,请先安装后使用');
        }
        $name='用户表'.date("Y-m-d H-i-s",time());
        // $data=[['aa','aa','cc','dd','ee'],['bb','bb','cc','dd','ee']];
        $data = Db::name('user')->where(['status'=>1])->select();
        //设置表头：
        $head = ['用户ID', '用户名', '性别', '地址', '注册日期']; 
        //数据中对应的字段，用于读取相应数据：
        $keys = ['id','name', 'sex', 'address', 'ctime'];     
        zf_excel_export($head,$keys,$data,$name) ;
    }


}
