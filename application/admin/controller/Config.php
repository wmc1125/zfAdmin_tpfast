<?php
namespace app\admin\controller;
use think\facade\Request;
use think\Db;
use think\facade\Config as TConfig;
use zf\Category;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class Config extends Admin
{
    public function __construct (){
        parent::__construct();
    }
    public function index()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if(request()->isPost()){
            $data = input('post.');
            $res = extraconfig(input('post.'),'web');
            if($res){
                return jssuccess('保存成功');die;
            }else{
                return jserror('保存失败');die;
            }   
        }
        $this->assign("config",config()['web']);
        return view();
    }
    //管理员列表
    public function admin_index()
    {
        admin_role_check($this->z_role_list,$this->mca);
        $user_list = Db::name('admin')->where("status!=9")->order("id asc")->paginate(6);
        $page = $user_list->render();
        $this->assign("user_list",$user_list);
        $this->assign("page",$page);
        return view();
    }

    public function admin_add()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if(!request()->isPost()){
            $group_list =  Db::name('admin_group')->where(['status'=>1])->select(); 
            $this->assign("group_list",$group_list);
            return view();   
        }  
        $data = input('post.');
        $data = array_merge($data,$this->common_tag);
        $res =Db::name('admin')->insert($data); 
        if($res){
            return jssuccess("新增成功");
        }else{
            return jserror('新增失败');exit;
        }  
    }
    //管理员修改
    public function admin_edit()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
    	if(request()->isGet()){
            $res = Db::name('admin')->where(['id'=>input('id')])->find();
            $this->assign("res",$res);
            $group_list = Db::name('admin_group')->where(['status'=>1])->select();
            $this->assign("group_list",$group_list);
            return view();
        } 
        if(request()->isPost()){
            $data = input('post.');
            if($data['name']=='admin' && session('admin')['name']!='admin' ){
                  return jserror('admin账号只能由Admin管理员修改');
            }
            if($data['pwd']!=''){
                $data['pwd'] = md5($data['pwd']);
            }else{
                unset($data['pwd']);
            }
            $res = Db::name('admin')->where(['id'=>$data['id']])->update($data);
              if($res){
                  return jssuccess('更新成功');
              }else{
                  return jserror('更新失败');
              }   
        } 
    } 

    //管理员分类
    public function admin_group()
    {
        admin_role_check($this->z_role_list,$this->mca);
        $group_list = Db::name('admin_group')->where("status!=9")->order("id asc")->paginate(10);
        $page = $group_list->render();
        $this->assign("group_list",$group_list);
        $this->assign("page",$page);
        return view();
    }

    //添加分类
    public function admin_group_add()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if(!request()->isPost()){
            return view();   
        } 
        $data = input('post.');
        $data = array_merge($data,$this->common_tag);
        $res =Db::name('admin_group')->insert($data); 
        if($res){
            return jssuccess("新增成功");
        }else{
            return jserror('新增失败');exit;
        }  
    }
    //分类修改
    public function admin_group_edit()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
    	if(request()->isGet()){
            $res = Db::name('admin_group')->where(['id'=>input('id')])->find(); 
            $this->assign("res",$res);
            return view();
        } 
        if(request()->isPost()){
            $data = input('post.');
            $res = Db::name('admin_group')->where(['id'=>$data['id']])->update($data);
              if($res){
                  return jssuccess('更新成功');
              }else{
                  return jserror('更新失败');
              }  
        } 
    } 
    //权限设置
    public function admin_group_role()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
    	if(request()->isGet()){
            $res = Db::name('admin_role')->where(['status'=>1])->select();
            $cat = new category(array('id', 'pid', 'name', 'value')); //初始化无限分类
            $list = $cat->getTree($res); //获取分类数据树结构
            $this->assign("list",$list);
            // dd($list);
            $res = Db::name('admin_group')->where(['id'=>input('id')])->find(); 
            $this->assign("res",$res);
            $role_list = explode(',',$res['role']);
            $this->assign("role_list",$role_list);
            return view();
        } 
        if(request()->isPost()){
            $data = input('post.');
            $data['role'] = implode(',',  $data['role']);
             $res = Db::name('admin_group')->where(['id'=>$data['id']])->update($data);
              if($res){
                  return jssuccess('更新成功');
              }else{
                  return jserror('更新失败');
              }    
        } 
    } 
    public function admin_role()
    {
        admin_role_check($this->z_role_list,$this->mca);
        //读取权限数据
        $res = Db::name('admin_role')->where(['status'=>1])->order('menu desc,sort asc, id asc')->select(); 

        $cat = new category(array('id', 'pid', 'name', 'cname')); //初始化无限分类
        $list = $cat->getTree($res); //获取分类数据树结构
        $this->assign("list",$list);
        // 控制器
        $controllers = getControllers('./application/admin/controller');
        $this->assign("controllers",$controllers);
        return view();
    }
    public function get_action()
    {
        $control = input('get.control');
        //通过控制器查找已存在的方法
        $now_act = db('admin_role')->field("act")->where('control', $control)->select();
        if(!empty($now_act)){
            foreach($now_act as $k=>$vo){
                $now_act_now[$k] = $vo['act'];
            }
            $actions = getActions('app\admin\controller' . '\\' . $control);
            //筛选后的方法(未添加的)
            $fin_act = array_merge(array_diff($actions,$now_act_now));
        }else{
            $fin_act = getActions('app\admin\controller' . '\\' . $control);
        }        
        echo json_encode($fin_act);
    }
    public function admin_role_add()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        //判断是否存在
        $val = input('post.');
        $value = $val['control'].'/'.$val['act'];
        $res1 = Db::name('admin_role')->where(["value"=> $value])->find();
        if($res1 && $val['act']!=''){
            return jserror('已存在该权限');exit;
        }
        $data = input('post.');
        $data['value'] = $value;
        $data = array_merge($data,$this->common_tag);
        $res =Db::name('admin_role')->insert($data); 
        if($res){
            return jssuccess("新增成功");
        }else{
            return jserror('新增失败');exit;
        }   
    }

    public function admin_role_edit()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
    	if(request()->isGet()){
            $res = Db::name('admin_role')->where(['status'=>1])->select();
            $cat = new category(array('id', 'pid', 'name', 'cname')); //初始化无限分类
            $list = $cat->getTree($res); //获取分类数据树结构
            $this->assign("list",$list);           
            $info = Db::name('admin_role')->where(["id"=> input('id')])->find();
            $this->assign("res",$info);
            return view();
        } 
        if(request()->isPost()){
            $data = input('post.');
            $res = Db::name('admin_role')->where(['id'=>$data['id']])->update($data);
              if($res){
                  return jssuccess('更新成功');
              }else{
                  return jserror('更新失败');
              }   
        } 
    } 


    //其他设置
    public function email()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if(request()->isPost()){
            $res = extraconfig(input('post.'),'mail');
            if($res)
            {
                return jssuccess('保存成功');die;
            }else{
                return jserror('保存失败');die;
            }   
        } 
        $this->assign("config",config()['mail']);
        return view();die;
        
    }
    public function test_email()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if(request()->isPost()){
            $ee = input('post.ee');
            date_default_timezone_set("PRC"); 
            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->SMTPDebug = 0;                                       // Enable verbose debug output
                $mail->isSMTP();     
                $mail->Host       = config()['mail']['host'];  // Specify main and backup SMTP servers
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = config()['mail']['send_email'];                     // SMTP username
                $mail->Password   = config()['mail']['password'];                               // SMTP password  tbhgfvutqsylbifa
                $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
                $mail->Port       = config()['mail']['e_number'];                                    // TCP port to connect to
                //Recipients
                $mail->setFrom(config()['mail']['send_email'], config()['mail']['send_nickname']);//发送方
                $mail->addAddress($ee, '测试用户');     // Add a recipient
               
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = '测试邮件';
                $mail->Body    = '这是一封测试邮件';
                $mail->AltBody = '这是一封测试邮件';
                $mail->send();
                return jssuccess('发送成功');die;
            } catch (Exception $e) {
                return jserror($mail->ErrorInfo);die;
            }
        } 
    }
    public function img_config(){
        $this->assign('res',[]);
        // 水印
        // 水印位置
        // 图片水印  文字水印
        // https://www.kancloud.cn/manual/thinkphp5_1/354123
        // 是否生成缩略图,大小尺寸
        // 
        if(request()->isPost()){
            admin_role_check($this->z_role_list,$this->mca);
            $data = input('post.');
            // dd($data);
            $res = extraconfig(input('post.'),'img');
            if($res){
               return jssuccess('保存成功');die;
            }else{
               return jserror('保存失败');die;
            }   
        }
        $this->assign("res",config()['img']);
        return view();
    }
    
   
    // 操作日志
    public function action_log()
    {

        admin_role_check($this->z_role_list,$this->mca);
        $list = Db::name('admin_log')->where("status!=9")->order("id desc")->paginate(10);
        $page = $list->render();
        $this->assign("list",$list);
        $this->assign("page",$page);
        return view();
    }
    

    
}
