<?php
namespace app\index\controller;
use think\Db;
use think\facade\Request;
use think\captcha\Captcha;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class Common extends Base
{
	public function __construct ( Request $request = null ){
        parent::__construct();
    }
    // 首页
    public function index()
    {
    	return "common";
    }
    public function verify(){
        $captcha = new Captcha(config()['captcha']);
        return $captcha->entry();
    }
    public function upload_one(){
        $file = request()->file('file');
        //不加
        $info = $file->validate(['ext'=>'pjpeg,jpeg,jpg,gif,bmp,png'])->move( './upload/file');
        $getSaveName = str_replace('\\', '/', $info->getSaveName());//win下反斜杠替换成斜杠
        $msg = 'http://'.$_SERVER['SERVER_NAME'].'/upload/file/'.$getSaveName;
        
        if($msg){
            return jssuccess($msg);
        }else{
            return jserror("error");
        }
    }
    public function meditor_upload_one(){
        
        $file = request()->file('editormd-image-file');
        //不加
        $info = $file->validate(['ext'=>'pjpeg,jpeg,jpg,gif,bmp,png'])->move( './upload/file');
        $getSaveName = str_replace('\\', '/', $info->getSaveName());//win下反斜杠替换成斜杠
        $msg = 'http://'.$_SERVER['SERVER_NAME'].'/upload/file/'.$getSaveName;
        
        if($msg){
            return json_encode(array(
               'success'    => 1, 
               'url'       => $msg,
               'message'    =>  'success',
            ));
        }else{
            return json_encode(array(
               'success'    => 0, 
               'url'       => '',
               'message'    =>  'error',
            ));
        }
    }
    public function upload_pic_liu(){
//目录的upload文件夹下
        $up_dir = "upload/file/".date('Ymd', time()) . "/";  //创建目录
        if(!file_exists($up_dir)){
            mkdir($up_dir,0777,true);
        }
        $base64_img = input('img','');
 
        if(preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_img, $result)){
            $type = $result[2];
            if(in_array($type,array('pjpeg','jpeg','jpg','gif','bmp','png'))){
                $new_file = $up_dir.time().'.'.$type;
                if(file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_img)))){
                    $img_path = str_replace('../../..', '', $new_file);
                    $msg = 'http://'.$_SERVER['SERVER_NAME'].'/'.$new_file;
                    return jssuccess($msg);
                }else{
                    return jserror('图片上传失败');
                }
            }else{
                //文件类型错误
                return jserror('图片上传类型错误');
            }
        }else{
                return jserror('上传错误');
        }
    }
     public function upload_one_file(){
        $file = $_FILES['file'];
        $img_config = config()['img'];
        $file2 = request()->file('file');
        $info = $file2->validate(['ext'=>'txt,pdf,doc,xls,ppt,mp4,flv,avi,MPEG-4'])->move('./upload/file');
        $getSaveName = str_replace('\\', '/', $info->getSaveName());//win下反斜杠替换成斜杠
        $msg = 'http://'.$_SERVER['SERVER_NAME'].'/upload/file/'.$getSaveName;
        
        if($msg){
            return jssuccess($msg);
        }else{
            return jserror("error");
        }
    }
/**
 * 绑定用户的一些相关信息
 * @Author   子枫
 * @Email    287851074@qq.com
 * @DateTime 2019-11-04T13:49:31+0800
 * @version  v1.0
 * @return   [type]                   [description]
 */
    public function bind_userinfo(){
        $t = input('t','');
        $data = input('post.');
        if($t=='email'){
            // dd($data['email']);
            //发送邮箱验证码
            \Wmc1125\Mctoolsdk\ZfTool::check_data('emptyy',$data['email'],'邮箱不能为空');
            \Wmc1125\Mctoolsdk\ZfTool::check_data('email',$data['email'],'邮箱格式不正确');
            $save['code'] = mt_rand(1000,9999);
            $save['email'] = $data['email'];
            session('home_email_code',$save);
            
            date_default_timezone_set("PRC"); 
            $mail = new PHPMailer(true);
            try {
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
                $mail->addAddress($data['email'], '芯译平台绑定邮箱验证码');     // Add a recipient
               
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = '芯译平台绑定邮箱验证码';
                $mail->Body    = '您的验证码是'.$save['code'];
                $mail->AltBody = '您的验证码是'.$save['code'];
                $mail->send();
                return jssuccess('发送成功');die;
            } catch (Exception $e) {
                return jserror($mail->ErrorInfo);die;
            }
        }elseif($t=='email_save'){
            if(session('home_email_code')==null){ return jserror('请先获取验证码');  }
            if(session('home_email_code')['email']!=$data['email'] || session('home_email_code')['code']!=$data['code']){
                return jserror('验证码错误');
            }
            $is_user = Db::name('user')->where(['email'=>$data['email']])->find();
            if($is_user){ return jserror('该邮箱已注册,请使用其他邮箱'); }
            $res = Db::name('user')->where(['id'=>session('home')['id']])->update(['email'=>$data['email']]);
            if($res){
                return jssuccess('绑定成功');
            }else{
                return jserror('绑定失败');
            }
        }elseif($t=='tel'){
             // dd($data['email']);
            //发送邮箱验证码
            \Wmc1125\Mctoolsdk\ZfTool::check_data('emptyy',$data['tel'],'邮箱不能为空');
            // $save['code'] = mt_rand(1000,9999);
            $save['code'] = mt_rand(1000,9999);
            $save['tel'] = $data['tel'];
            ###########执行发送验证码###########
            $send_res = send_aliyun_sms($save['tel'],['code'=> $save['code']],'绑定手机');
            if($send_res=='ok'){
                session('home_tel_code',$save);
                if(session('home_tel_code')!=null){ 
                    return jssuccess('发送成功');  
                }else{
                    return jserror('发送失败');  
                }
            }else{
                    return jserror($send_res);  
            }

        }elseif($t=='tel_save'){
            if(session('home_tel_code')==null){ return jserror('请先获取验证码');  }
            if(session('home_tel_code')['tel']!=$data['tel'] || session('home_tel_code')['code']!=$data['code']){
                return jserror('验证码错误');
            }
            $is_user = Db::name('user')->where(['tel'=>$data['tel']])->find();
            if($is_user){ return jserror('该邮箱已注册,请使用其他邮箱'); }
            $res = Db::name('user')->where(['id'=>session('home')['id']])->update(['tel'=>$data['tel']]);
            if($res){
                return jssuccess('绑定成功');
            }else{
                return jserror('绑定失败');
            }
        }


    }




    public function ajax_like(){
        $data['post_id'] = input('post.post_id',0);
        $data['tb'] = input('post.tb','post');
        $data['cid'] = input('post.cid','0');
        $data['by_uid'] = input('post.by_uid',0);
        if(session('home')==null){
            return jserror('请先登录');
        }
        $data['uid'] = session('home')['id'];

        //判断是否已点赞
        $is_like = Db::name('like')->where(['uid'=>$data['uid'],'tb'=>$data['tb'],'by_uid'=>$data['by_uid'],'post_id'=>$data['post_id']])->order('id desc')->value('status');
        if($is_like){
            // return jserror('已点赞');
            if($is_like==1){
                //执行取消点赞
                $res = Db::name('like')->where(['uid'=>$data['uid'],'tb'=>$data['tb'],'by_uid'=>$data['by_uid'],'post_id'=>$data['post_id']])->order('id desc')->update(['status'=>0]);
                if($res){
                    return jssuccess('取消点赞');
                }else{
                    return jserror('取消点赞失败');
                }
            }else{
                $res = Db::name('like')->where(['uid'=>$data['uid'],'tb'=>$data['tb'],'by_uid'=>$data['by_uid'],'post_id'=>$data['post_id']])->order('id desc')->update(['status'=>1]);
            }
            
        }else{
            $data['ctime'] = time();    
            $data['status'] = 1;   
            $res = Db::name('like')->insert($data);
        }
        if($res){
            return jssuccess('点赞成功');
        }else{
            return jserror('点赞失败');
        }

    }

    public function ajax_collect(){
        $data['post_id'] = input('post.post_id',0);
        $data['tb'] = input('post.tb','post');
        $data['cid'] = input('post.cid',0);
        $data['by_uid'] = input('post.by_uid',0);
        if(session('home')==null){
            return jserror('请先登录');
        }
        $data['uid'] = session('home')['id'];

        //判断是否已收藏
        $is_collect = Db::name('collect')->where(['uid'=>$data['uid'],'tb'=>$data['tb'],'by_uid'=>$data['by_uid'],'post_id'=>$data['post_id']])->order('id desc')->value('status');
        if($is_collect){
            if($is_collect==1){
                $res = Db::name('collect')->where(['uid'=>$data['uid'],'tb'=>$data['tb'],'by_uid'=>$data['by_uid'],'post_id'=>$data['post_id']])->order('id desc')->update(['status'=>0]);
                if($res){
                    return jssuccess('取消收藏');
                }else{
                    return jserror('取消收藏失败');
                }
            }else{
                $res = Db::name('collect')->where(['uid'=>$data['uid'],'tb'=>$data['tb'],'by_uid'=>$data['by_uid'],'post_id'=>$data['post_id']])->order('id desc')->update(['status'=>1]);
            }
        }else{
            $data['ctime'] = time();    
            $data['status'] = 1;   
            $res = Db::name('collect')->insert($data); 
        }
        // dd($data);
        if($res){
            return jssuccess('收藏成功');
        }else{
            return jserror('收藏失败');
        }

    }
// 采纳
    public function ajax_caina(){
        $data['post_id'] = input('post.post_id',0);
        $common_id = input('post.common_id',0);
        $data['tb'] = input('post.tb','post');
        $data['cid'] = input('post.cid','0');
        $data['by_uid'] = input('post.by_uid',0);
        if(session('home')==null){
            return jserror('请先登录');
        }
        $data['uid'] = session('home')['id'];
        $data['ctime'] = time();    
        $data['status'] = 1;   
        $res = Db::name('caina')->insert($data);
        //修改订单日志
        //查询
        $is_order = Db::name('order')->where(['pid'=>$data['post_id']])->find();
        if(!$is_order){
            return jserror('订单不存在');
        }
        Db::startTrans();
        try{
            Db::name('order')->where(['pid'=>$data['post_id']])->update(['by_uid'=>$data['by_uid'],'status'=>1]);
            Db::name('post')->where(['id'=>$data['post_id']])->update(['is_cn'=>$common_id]);
            //给被采纳人转账
            Db::name('user')->where(['id'=>$data['by_uid']])->setInc('coin',$is_order['price']);
            Db::commit();
            return jssuccess('采纳成功');
        } catch (\Exception $e) {
            // 更新失败 回滚事务
            Db::rollback();
            return jserror('采纳失败');
        }

    }
 
    //评论
    //
    public function ajax_comment(){
        $data['post_id'] = input('post.post_id',0);
        $data['tb'] = input('post.tb','post');
        $data['by_uid'] = input('post.by_uid',0);
        $data['content'] = input('post.content','');
        if(session('home')==null){
            return jserror('请先登录');
        }
        if( $data['content'] ==''){
            return jserror('内容不能为空');
        }
        $data['uid'] = session('home')['id'];

        //判断是否已回复
        if(Db::name('comment')->where(['uid'=>$data['uid'],'tb'=>$data['tb'],'by_uid'=>$data['by_uid'],'content'=>$data['content'],'post_id'=>$data['post_id']])->find()){
            return jserror('请勿评论相同内容');
        }
        $data['ctime'] = time();    
        $data['status'] = 1;    
        if(Db::name('comment')->insert($data)){
            return jssuccess('评论成功');
            return jssuccess('评论成功');
        }else{
            return jserror('评论失败');
        }
    }

    //删除
    public function del_item(){
        $db = input('db','');
        $id = input('id','');
        $uid =session('home')['id'];
        $res = Db::name($db)->where(['id'=>$id,'uid'=>$uid])->update(['status'=>9]);
        if($res){
            return jssuccess('删除成功');
        }else{
            return jserror('删除失败');
        }
    }
    // 下载
    public function file_down(){
        if(session('home')==null){
            return jserror('请先登录');
        }
        $t = input('t','');
        if($t=='down'){
            //执行下载
            $id = input('id');
            $str = Db::name('down_log')->where(['uid'=>session('home')['id'],'post_id'=>$id])->value('file');
            $str = 'http://xinyipt.cgonet.com/upload/file/20191112/fe3d953b7406d05bcd0753e29f87df26.txt';
            $path = '.'.parse_url($str)['path'];
            $file = basename($path);
            $r = \zf\Download::output_for_download( $path,$file);
            die;
        }

        $data = Db::name('post')->field('id,file,coin,uid')->where(['id'=>input('post.id')])->find();
        Db::startTrans();
        try{
            //判断是否已经购买
            $is_gou = Db::name('down_log')->where(['uid'=>session('home')['id'],'post_id'=>$data['id']])->find();
            if($is_gou){
                // return jssuccess('已购买过'); 返回下载链接
                $ret['url'] = url('common/file_down',['t'=>'down','id'=>$is_gou['id']]);
            }else{
                //扣除悬赏币
                $order_data['type'] = 5;//下载
                $order_data['order_sn'] = 'ZF-'.time().mt_rand(10000,99999);
                $order_data['uid'] = session('home')['id'];
                $order_data['price'] = $data['coin'];
                $order_data['ctime'] = time();
                $order_data['pid'] = $data['id'];
                Db::name('order')->insert($order_data);
                Db::name('user')->where(['id'=>session('home')['id']])->setDec('coin',$data['coin']);
                Db::name('user')->where(['id'=>$data['uid']])->setInc('coin',$data['coin']);

                //写入
                $data_down['post_id'] = $data['id'];
                $data_down['uid'] =  session('home')['id'];
                $data_down['ctime'] = time();
                $data_down['file'] = $data['file'];
                $data_down['coin'] = $data['coin'];
                $r = Db::name('down_log')->insert($data_down);
                // 返回下载链接
                $ret['url'] = url('common/file_down',['t'=>'down','id'=>$data['id']]);

            }
            $ret['msg'] = '请求成功';
            Db::commit();
            return jssuccess($ret);
        } catch (\Exception $e) {
            // 更新失败 回滚事务
            Db::rollback();
            $ret['msg'] = '请求失败';
            return jserror($ret);
        }

    }
   


}
