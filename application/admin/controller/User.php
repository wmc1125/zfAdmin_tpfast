<?php
namespace app\admin\controller;
use think\facade\Request;
use think\Db;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use zf\GoogleAuthenticator;

class User extends Admin
{
    public function __construct (){
        parent::__construct();
    }
	// 用户列表
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

    // 添加新用户
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
        if($res)
        {
            return jssuccess('新增成功');
        }else{
            return jserror('新增失败');exit;
        }  
    }

    //用户修改
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
            $is_user =  Db::name('user')->where(['name'=>$data['name']])->find();
            if($is_user){
                if($is_user['id']!=$data['id']){
                    return jserror('用户名已存在');exit;
                }
            }

            $res = Db::name('user')->where(['id'=>$data['id']])->update($data);
              if($res)
              {
                  return jssuccess('修改成功');
              }else{
                  return jserror('修改失败');
              }   
        } 
    } 
   
    //用户分类
    public function group()
    {
        admin_role_check($this->z_role_list,$this->mca);
        $group_list = Db::name('user_group')->where('status!=9')->order("id asc")->paginate(10);
        $page = $group_list->render();
        $this->assign("group_list",$group_list);
        $this->assign("page",$page);
        return view();
    }
    
    //添加分类
    public function group_add()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if(request()->isPost()){ 
            $data = input('post.');
            $data['ctime'] = time();
            $data = array_merge($data,$this->common_tag);
            $res =Db::name('user_group')->insert($data);
            if($res)
            {
                return jssuccess('新增成功');
            }else{
                return jserror('新增失败');exit;
            } 
        }  
            return view();   

         
    }
    //分类修改
    public function group_edit()
    {
        admin_role_check($this->z_role_list,$this->mca,1);   
        if(request()->isPost()){
            $data = input('post.');
            $res = Db::name('user_group')->where(['id'=>$data['id']])->update($data); 
              if($res)
              {
                  return jssuccess('修改成功');
              }else{
                  return jserror('修改失败');
              }   
        } 
        $res =  Db::name('user_group')->where(['id'=>input('id')])->find();
        $this->assign("res",$res);
        return view();
    } 
    // 密码修改
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
    public function admin_info()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if(request()->isPost()){
            $data = input('post.');
            $res = Db::name('admin')->where(['id'=>$data['id']])->update($data);
              if($res){ 
                  return jssuccess('修改成功');
              }else{
                  return jserror('修改失败');
              }   
        } 
        $id = session('admin.id');
        $res = Db::name('admin')->where(['id'=>$id])->find();
        $this->assign('res',$res);
        // dd($res);
        $ga = new GoogleAuthenticator();
        if($res['google_secret']!=''){
            $secret = $res['google_secret'];
        }else{
            $secret = $ga->createSecret();
        }
        // $qrCodeUrl = $ga->getQRCodeGoogleUrl('zf-'.$id, $secret);
        //otpauth://totp/zf-1?secret=Y67N442CU2G4CIAG
        $qrCodeUrl = 'http://mctool.wangmingchang.com/api/tool/create_qr_code?t=google&name=zf-'.$id.'&secret='.$secret;
        // $oneCode = $ga->getCode($secret);
        $this->assign('secret',$secret);
        $this->assign('qrCodeUrl',$qrCodeUrl);
        return view();
    }

    //导出
    public function export(){
        admin_role_check($this->z_role_list,$this->mca);
        $name='用户表'.date("Y-m-d H-i-s",time());
        // $data=[['aa','aa','cc','dd','ee'],['bb','bb','cc','dd','ee']];
        $data = Db::name('user')->where(['status'=>1])->select();
        //设置表头：
        $head = ['用户ID', '用户名', '性别', '地址', '注册日期']; 
        //数据中对应的字段，用于读取相应数据：
        $keys = ['id','name', 'sex', 'address', 'ctime'];     
        $count = count($head);  //计算表头数量
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        for ($i = 65; $i < $count + 65; $i++) {     //数字转字母从65开始，循环设置表头：
            $sheet->setCellValue(strtoupper(chr($i)) . '1', $head[$i - 65]);
        }
        /*--------------开始从数据库提取信息插入Excel表中------------------*/
        foreach ($data as $key => $item) {             //循环设置单元格：
            //$key+2,因为第一行是表头，所以写到表格时   从第二行开始写 
            for ($i = 65; $i < $count + 65; $i++) {     //数字转字母从65开始：
                $sheet->setCellValue(strtoupper(chr($i)) . ($key + 2), $item[$keys[$i - 65]]);
                $spreadsheet->getActiveSheet()->getColumnDimension(strtoupper(chr($i)))->setWidth(20); //固定列宽
            }
        }
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $name . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        //删除清空：
        $spreadsheet->disconnectWorksheets();
        unset($spreadsheet);
        exit;
    }

    


    


  
    


}
