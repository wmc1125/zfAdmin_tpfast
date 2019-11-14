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
use think\Controller;
use think\facade\Request;
use think\Db;
use Wmc1125\TpFast\GoogleAuthenticator;

class Login extends Controller
{
    public function __construct (){
        parent::__construct();
        $this->assign('web_config',config());
    }

    /**
     * @Notes:登录页
     * @Interface index
     * @return \think\response\View
     * @author: 子枫
     * @Time: 2019/11/13   10:56 下午
     */
    public function index()
    {
        if(session('admin')){
            $this->error('你已登录,不需要重复登录','index/index'); 
        }else{
            return view();
        }
    }

    /**
     * @Notes:后台登录
     * @Interface login
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author: 子枫
     * @Time: 2019/11/13   10:56 下午
     */
    public function login()
    {
        if(request()->isPost()){
            if(request()->isPost()){
                $data = input('post.');
                $userInfo = Db::name('admin')->where('name', $data['name'])->where('pwd', md5($data['pwd']))->where('status', 1)->where('status', 1)->find();
                if (!$userInfo) {
                    //说明在数据库未匹配到相关数据
                    return jserror('用户名或者密码不正确 或没有权限');
                }
                if($userInfo['google_is']==1 && $userInfo['google_secret']!=''){
                    if($data['google_code']==''){
                        return jserror('你已开启谷歌验证,请输入验证码');
                    }
                    $ga = new GoogleAuthenticator();
                    $secret = $userInfo['google_secret'];
                    $qrCodeUrl = $ga->getQRCodeGoogleUrl('zf-'.$userInfo['id'], $secret);
                    $oneCode = $data['google_code'];

                    $checkResult = $ga->verifyCode($secret, $oneCode, 2);    // 2 = 2*30sec clock tolerance
                    if (!$checkResult) {
                        return jserror('谷歌验证错误');die;
                    }
                }
                //3.将用户信息存入到session中
                $admin  = $userInfo;
                session('admin', $admin);
                return jssuccess('登陆成功');
            }else{
                return jserror('异常访问');
            }
        }
        
    }

    /**
     * @Notes:后台管理员退出
     * @Interface loginout
     * @author: 子枫
     * @Time: 2019/11/13   10:57 下午
     */
    public function loginout(){
        session('admin',null);
        $url_tmp = Request::instance()->domain().'/admin/login/loginout';
        $url_login = Request::instance()->domain().'/admin/login/index';
        if(session('admin')){
            $this->redirect($url_tmp,302);
        }else{
            $this->redirect($url_login,302);
        }
    }

}
