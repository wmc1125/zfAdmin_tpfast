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

namespace app\api\controller\v1;
use \think\Config;
use think\facade\Request;
use think\Db;
use think\Controller;
use EasyWeChat\Factory;
use Wmc1125\TpFast\GoogleAuthenticator;

class Wxapp extends Controller
{
  
    //验证是否有权限使用
    public function __construct ( Request $request = null )
    {
        // $appkey = Request::instance()->header("appkey");
        // if($appkey!='zf'){
        //     return jserror("no appkey");die;  
        // }
        $this->config = [
            'app_id' => 'wx5ee50f540ed88d4c',
            'secret' => '5eaee25463b70d811bd87b1655ae1579',
        
            // 下面为可选项
            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',
        
            'log' => [
                'level' => 'debug',
                'file' => __DIR__.'/wechat.log',
            ],
        ];
    }
    public function get_openid()
    {
        // $code = input("code");
        // $appid = 'wx5ee50f540ed88d4c';
        // $appsecret = '5eaee25463b70d811bd87b1655ae1579';
        // $weixin =  file_get_contents("https://api.weixin.qq.com/sns/jscode2session?appid=".$appid."&secret=".$appsecret."&js_code=".$code."&grant_type=authorization_code");//通过code换取网页授权access_token
        // $jsondecode = json_decode($weixin); //对JSON格式的字符串进行编码
        // $array = get_object_vars($jsondecode);//转换成数组
        // return  jssuccess($array['openid']);//输出openid
        // dump($array);die;
        
        $code = input("code");
        $miniProgram = Factory::miniProgram($this->config);
        $data = $miniProgram->auth->session($code);
        $data['token'] = '';
        return  jssuccess($data);//输出session
    }
  // 用户登录
    public function login()
    {
      $userinfo = input("post.");
      $data['nickName'] = $userinfo['userinfo']['nickName'];
      $data['name'] = $userinfo['userinfo']['nickName'];
      $data['sex'] = $userinfo['userinfo']['gender'];
      $data['avatarUrl'] = $userinfo['userinfo']['avatarUrl'];
      $data['pic'] = $userinfo['userinfo']['avatarUrl'];
       $data['openid'] = $userinfo['openid'];
       $data['api_key'] = zf_encrypt($userinfo['openid']);
        // $decrypt = zf_decrypt('0ZabjJdln52Kr86Rr31iypuXmKSnZpmam4isow==', $key);//解密
      $data['ctime'] = time();
      if($data['openid']==''){
        return jserror("error");die;
      }
      //判断是否已经存在
        $res_is = Db::name('user')->where("openid='".$data['openid']."'")->find();
      if(!$res_is){
        $res = Db::name('user')->data($data)->insert();
          if(!$res){
          return jserror("写入失败");die;
          }
      }
        return jssuccess("ok");
    }

    //获取模板消息formid
    public function template_get()
    {
      $data['formid'] = input("post.formId");
      $data['openid'] = input("post.openid");
      $data['create_time'] = time();
        $data['status'] = 1;
      $data['end_time'] = time()+ 7*60*60*24;
        if($data['formid']=='the formId is a mock one'){
            return jserror("请在真机上使用");die;
        }
      $res_is = Db::name('xcx_user_tpl')->where("formid='".$data['formid']."'")->find();
      if(!$res_is){
        $res = Db::name('xcx_user_tpl')->data($data)->insert();
          if(!$res){
          return jserror("写入失败");die;
          }
      }
        return jssuccess("ok");
    }
    public function send_subscribe_message()
    {
        $miniProgram = Factory::miniProgram($this->config);

        $data = [
            'template_id' => 'pWDZvXInnz-Ma8L97U2l_9y8rfQR20DZK1J4H1LVn6M', // 所需下发的订阅模板id
            'touser' => 'oefTb4l9ZMmZzG2eg43nn-a9fQxA',     // 接收者（用户）的 openid
            'page' => '/pages/tool/index',       // 点击模板卡片后的跳转页面，仅限本小程序内的页面。支持带参数,（示例index?foo=bar）。该字段不填则模板无跳转。
            'data' => [         // 模板内容，格式形如 { "key1": { "value": any }, "key2": { "value": any } }
                'time2' => [
                    'value' => date("Y-m-d",time()),
                ],
                'thing3' => [
                    'value' => '呜呜呜呜呜呜呜呜',
                ],
            ],
        ];


        $r = $miniProgram->subscribe_message->send($data);
        dd($r);
    }


    // 获取数量
    public function template_num()
    {
      $data['openid'] = input("post.openid");
      $num = Db::name('xcx_user_tpl')->where("status=1 and openid='".$data['openid']."' and end_time > ".time())->count();
      return jssuccess($num);
    } 

    //获取用户key
    public function get_user_key()
    {
        $data['openid'] = input("post.openid");
        $res = Db::name('user')->field("api_key")->where("openid='".$data['openid']."'")->find();
        if($res['api_key']==''){
            //如果不存在,更新
            $data1['api_key'] = zf_encrypt($data['openid']);
            Db::name('user')->where("openid='".$data['openid']."'")->data($data1)->update();
            $res['api_key'] = $data1['api_key'];
        }
        return jssuccess($res);
    } 

    //扫描登陆(ing)
    public function scan()
    {
        $data1['openid'] = input("post.openid");
        $scene = input("post.scene");// $scene = "pages/index/index?scene=xcx5471543204811";

        //查找是否有该用户
        $res = Db::name('user')->where("openid='".$data1['openid']."'")->find();
        if(!$res){
            return jserror("用户未授权");die;
        }

        //通过url 点击确认扫描成功
        $act_code = trim(strrchr($scene, '='),'=');
        // 更新小程序登陆信息
        $data['openid'] = $data1['openid'];
        $data['check_code'] =  $act_code ;
        $data['check_time'] = time();


        $update_is = Db::name('xcx_login')->where("act_code='".$act_code."'")->data($data)->update();
        // echo $update_is;
        if($update_is){
            return jssuccess("ok");
        }else{
            return jserror("登陆失败");
        }

    }
    //google auth
    public function get_googleauth()
    {
        $data1['openid'] = input("post.openid");
        $scene = input("post.scene");// 
        // $data1['openid'] = 'oefTb4l9ZMmZzG2eg43nn-a9fQxA';
        // $scene='otpauth://totp/zf-1?secret=Y67N442CU2G4CIAG';
        //查找是否有该用户
        $res = Db::name('user')->where("openid='".$data1['openid']."'")->find();
        if(!$res){
            return jserror("用户未授权");die;
        }

        $r = explode('otpauth://totp/',$scene)[1];
        // 更新google信息
        $data['openid'] = $data1['openid'];
        $data['secret'] =  explode('=',$r)[1] ;
        $data['ctime'] = time();
        $data['append'] = explode('?',$r)[0];
        $data['name'] = explode('?',$r)[0];
        $data['url'] = $scene;

        $update_is = Db::name('google_auth')->insert($data);
        // echo $update_is;
        if($update_is){
            return jssuccess("ok");
        }else{
            return jserror("error");
        }

    }
    public function googleauth()
    {
        $openid = input("post.openid");
        $list = Db::name('google_auth')->field("*,DATE_FORMAT(FROM_UNIXTIME(ctime),'%Y-%m-%d %H:%i:%s') as date")->where(['openid'=>$openid])->select();
        // echo $update_is;
        $ga = new GoogleAuthenticator();
        foreach($list as $k=>$vo){
            $secret = $vo['secret'];
            $qrCodeUrl = $ga->getQRCodeGoogleUrl($vo['name'], $secret);
            $list[$k]['oneCode'] = $ga->getCode($secret);
        }
        $getTime = $ga->getTime(2);    // 2 = 2*30sec clock tolerance
        $r['list'] = $list;
        $r['djs'] = $getTime;

        if($list){
            return jssuccess($r);
        }else{
            return jserror("error");
        }

    }
    public function google_del(){
        $id = input('id');
        $res = Db::name('google_auth')->where(['id'=>$id])->delete();
        if($res){
            return jssuccess("ok");
        }else{
            return jserror("error");
        }
    }
    public function google_edit(){
        $id = input('post.id','');
        $append = input('post.append','');
        $res = Db::name('google_auth')->where(['id'=>$id])->update(['append'=>$append]);
        if($res){
            return jssuccess("ok");
        }else{
            return jserror("error");
        }
    }

    
    // 图床系统
    public function imgup()
    {
        // $upload_file = $_FILES["file"]["tmp_name"];
        // $json = mc_sinaupload('13170384230','13170384230..','multipart',$upload_file);
        // // $json = '{"code":"200","width":500,"height":454,"size":15633,"pid":"007goYVsgy1fvflw4foa8j30dw0cm74g","url":"http:\/\/ws3.sinaimg.cn\/thumb150\/007goYVsgy1fvflw4foa8j30dw0cm74g.jpg"}';
        // $r = json_decode($json,true);
        // $data['sina_id'] = $r['pid'];
        // $res = Db::name('file')->insert($data);
        // if($res)
        // {
        //     return "http://ws3.sinaimg.cn/large/".$data['sina_id'].".jpg";
        // }else{
        //     return "上传失败";
        // }  
        $img_config = config()['img'];
        $file = $_FILES['file'];
        $msg = $this->aliyunoss($img_config,$file,$file['tmp_name']);
        if($msg){
            return jssuccess($msg);
        }else{
            return jserror("error");
        }
       
    }
    public function aliyunoss($img_config,$file,$tmp_name){
        $ossconfig = [
            'KeyId'      => $img_config['ali_ACCESSKEY'],  //您的Access Key ID
            'KeySecret'  => $img_config['ali_SECRETKEY'],  //您的Access Key Secret
            'Endpoint'   => $img_config['ali_DOMAIN'],  //阿里云oss 外网地址endpoint
            'Bucket'     => $img_config['ali_BUCKET'],  
        ];
        //获取文件后缀
        $file_name = $file['name'];
        $today = date('Ymd', time());
        //得到文件名
        $file_name = 'image/'.$today.'/'.time().'_'.$file_name;
        //实例化OSS
        $ossClient = new AliOssClient($ossconfig['KeyId'], $ossconfig['KeySecret'], $ossconfig['Endpoint']);
        try {
            //执行阿里云上传
            $result = $ossClient->uploadFile($ossconfig['Bucket'],'demo_zf_test/public/upload/simple/'. $file_name, $tmp_name);
            return $result['info']['url'];
        } catch (OssException $e) {
            return $e->getMessage();
        }
    }
    public function category_detail(){
        $cid = input('cid');
        $res = Db::name('category')->where("cid=".$cid)->find();
        return jssuccess($res);

    }
    //小程序推荐
    public function xcxtuijian()
    {
      //echo input("length");die;
        $cid=35;
        if(input("length")){
          $length = input("length");
            $limit= $length .",8";

        }else{
            $limit='8';
        }
//      echo $limit;die;
        $list = Db::name('post')->field("id,title,pic,summary,url,append")->where("cid=".$cid)->limit($limit)->order("id desc")->select();
        return jssuccess($list);
    }
    //收款多码
    public function make_pay()
    {

        $data['wxpay'] = input('post.wx');
        $data['alipay'] = input('post.zfb');
        $data['openid'] = input('post.openid');

        $data['status'] = 1;
        $data['create_time'] = time();
        //查询是否已经生成
        $see = Db::name('pay_code')->field("id,wxpay,alipay,create_time,code")->where("alipay='".$data['alipay'] ."' and wxpay = '".$data['wxpay']."'")->find();
        if($see){
            return jserror("应经申请过");die;
        }
        
        $id = Db::name('pay_code')->insertGetId($data);
        $updata['code'] =  qrcode_msg_js('https://tool.wangmingchang.com/api/tool/pay_code.html?id='. $id);
        $update_is = Db::name('pay_code')->where("id='".$id."'")->data($updata)->update();
        if($update_is){
            return jssuccess("已生成");die;
        }else{
            return jserror("生成失败");die;
        }
    } 
    public function yhq(){
        $this->appKey = '5d5b93fcac103';//应用的key
        $this->appSecret = 'd7fa1e55d2410a4e7e22c799fc0a6015';//应用的Secret
        //默认必传参数
        $data = [
            'appKey' => $this->appKey
        ];
        $keyword = input('keyword','');
        $page = input('page',1);
        if($keyword==''){
            //商品列表
            $this->host = 'https://openapi.dataoke.com/api/goods/get-goods-list';
            $data['sort'] = 3;
            $data['version'] = '1';
            $data['pageSize'] = 100;
            if($page){
                $data['pageId'] = $page;
            }
        }else{
            //搜索
            $this->host = 'https://openapi.dataoke.com/api/goods/list-super-goods';
            $data['sort'] = 'total_sales';//排序字段信息 销量（total_sales） 价格（price），排序_des（降序），排序_asc（升序）
            $data['type'] = 0; //0-综合结果，1-大淘客商品，2-联盟商品
            $data['keyWords'] = $keyword;
            $data['version'] = 'v1.1.0';
            if($page){
                $data['pageId'] = $page;
            }
        }
        //加密的参数
        $data['sign'] = dtk_makeSign($data,$this->appSecret);
        //拼接请求地址
        $url = $this->host .'?'. http_build_query($data);
        //执行请求获取数据
        $output = https_get($url);
        dd(json_decode($output));
        return $output;die; 

    }
    public function yhq_change_url(){
        $this->appKey = '5d5b93fcac103';//应用的key
        $this->appSecret = 'd7fa1e55d2410a4e7e22c799fc0a6015';//应用的Secret
        //默认必传参数
        $data = [
            'appKey' => $this->appKey,
            'version'=>'v1.0.5'
        ];
        $data['goodsId'] = input('goods_id');
        $this->host = 'https://openapi.dataoke.com/api/goods/get-privilege-link';

        //加密的参数
        $data['sign'] = dtk_makeSign($data,$this->appSecret);
        //拼接请求地址
        $url = $this->host .'?'. http_build_query($data);
        //执行请求获取数据
        $output = https_get($url);
        dd(json_decode($output));
        return $output;die; 
    }


    public function create_sq(){
        $scene = input('post.scene','site_domain@-v1.fast.zf.90ckm.com---email@-287851074@qq.com---pro@-30');
        $_arr = explode('---', $scene);
        foreach ($_arr as $key => $value) {
            $_str = explode('@-', $value);
            $arr[$_str[0]] = $_str[1];
        }
        if(!isset($arr['site_domain']) || !isset($arr['email']) || !isset($arr['pro']) || $arr['pro']=='' || $arr['site_domain']=='' || $arr['email']==''){
            return jserror('参数不完整');
        }
        $data['email'] = $arr['email'];
        $data['site_domain'] = $arr['site_domain'];
        $data['pro'] = $arr['pro'];//产品ID
        $url='http://v1.fast.zf.90ckm.com/addons/zf_soft_plugins.api/vfast_create';
        $ret_json = https_post($url,$data);
        $ret = object_to_array(json_decode($ret_json));
        return jssuccess($ret) ;


    }


}
