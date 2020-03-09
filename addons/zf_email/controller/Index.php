<?php
namespace addons\zf_email\controller;
use PHPMailer\PHPMailer\PHPMailer;
use think\Controller;
use addons\zf_email\controller\Plugin;

class Index extends Controller
{
//     public function __construct ( Request $request = null )
//     {
////         parent::__construct();
//
//
//     }
    /**
     * @Notes:email设置
     * @Interface email
     * @return \think\response\View|void
     * @author: 子枫
     * @Time: 2019/11/13   10:53 下午
     */
    public function index()
    {
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
    public function setting()
    {
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
    public function help(){
        return view();
    }

    /**
     * @Notes:测试邮箱
     * @Interface test_email
     * @author: 子枫
     * @Time: 2019/11/13   10:53 下午
     */
    public function test_email()
    {
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



}