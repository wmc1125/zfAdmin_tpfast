<?php

/**
 * @Author: Eric-枫
 * @Date:   2019-08-29 10:33:28
 * @Last Modified by:   Eric-枫
 * @Last Modified time: 2019-11-14 09:52:55
 */
namespace Wmc1125\TpFast;
use think\Controller;
use think\facade\Request;
use think\Db;
use think\facade\Config;

final class ZfTool
{
    public function _initialize(){}
    /*
     * ZF权限方法
     */
    static public function web_auth(){
      if (function_exists('zf_web_auth')) {
        if(request()->module()=='admin'){
          zf_web_auth();
        }
      }
    }
    
    /*
     * 更新此类
     */
    // static public function zf_upgrade(){
    //   self::web_auth();
    //   $all_path =str_replace('\\','/', __FILE__);
    //   $web_path = $_SERVER['DOCUMENT_ROOT'];
    //   $temp_path = explode('ZfTool.php',explode($web_path, $all_path)[1])[0];
    //   $temp_file = time().'.php';
    //   $r = curlDownFile('https://raw.githubusercontent.com/wmc1125/zfAdmin_tpfast/master/extend/zf/ZfTool.php','.'.$temp_path,$temp_file);
    //   //覆盖文件
    //   $handle=fopen('.'.$temp_path.'ZfTool.php',"w");
    //   $is_replace=fwrite($handle,file_get_contents('.'.$temp_path.$temp_file));
    //   fclose($handle);
    //   unlink('.'.$temp_path.$temp_file);
    //   if(!$is_replace){
    //     $handle=fopen('.'.$temp_path.'ZfTool.php',"w");
    //     $is_replace=fwrite($handle,file_get_contents('.'.$temp_path.'ZfTool_temp.php'));
    //     fclose($handle);
    //   }
    // }

    /*
     * 获取信息
     */
    static public function get_info(){
      self::web_auth();
//获取系统类型及版本号：    php_uname()           (例：Windows NT COMPUTER 5.1 build 2600)
//只获取系统类型：          php_uname('s')        (或：PHP_OS，例：Windows NT)
//只获取系统版本号：        php_uname('r')        (例：5.1)
//获取PHP运行方式：         php_sapi_name()       (PHP run mode：apache2handler)
//获取前进程用户名：        Get_Current_User()
//获取PHP版本：             PHP_VERSION
//获取Zend版本：            Zend_Version()
//获取PHP安装路径：         DEFAULT_INCLUDE_PATH
//获取当前文件绝对路径：    __FILE__
//获取Http请求中Host值：    $_SERVER["HTTP_HOST"]                  (返回值为域名或IP)
//获取服务器IP：            GetHostByName($_SERVER['SERVER_NAME'])
//接受请求的服务器IP：      $_SERVER["SERVER_ADDR"]                (有时候获取不到，推荐用：GetHostByName($_SERVER['SERVER_NAME']))
//获取客户端IP：            $_SERVER['REMOTE_ADDR']
//获取服务器解译引擎：      $_SERVER['SERVER_SOFTWARE']
//获取服务器CPU数量：       $_SERVER['PROCESSOR_IDENTIFIER']
//获取服务器系统目录：      $_SERVER['SystemRoot']
//获取服务器域名：          $_SERVER['SERVER_NAME']                 (建议使用：$_SERVER["HTTP_HOST"])
//获取用户域名：            $_SERVER['USERDOMAIN']
//获取服务器语言：          $_SERVER['HTTP_ACCEPT_LANGUAGE']
//获取服务器Web端口：       $_SERVER['SERVER_PORT']
      $data['php_uname'] = php_uname();
      $data['php_uname_r'] = php_uname('s');
      $data['php_uname_r'] = php_uname('r') ;
      $data['php_sapi_name'] = php_sapi_name();
      $data['Get_Current_User'] = Get_Current_User();
      // $data['PHP_VERSION'] = PHP_VERSION();
      $data['Zend_Version'] = Zend_Version();
      // $data['DEFAULT_INCLUDE_PATH'] =DEFAULT_INCLUDE_PATH() ;
      $data['__file__'] = __FILE__;
      $data['HTTP_HOST'] =  $_SERVER["HTTP_HOST"];
      $data['GetHostByName'] =GetHostByName($_SERVER['SERVER_NAME']) ;//接受请求的服务器IP：
      $data['REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'];//获取客户端IP
      $data['SERVER_SOFTWARE'] = $_SERVER['SERVER_SOFTWARE'];
      $data['SystemRoot'] =  $_SERVER['SystemRoot'];
      $data['HTTP_ACCEPT_LANGUAGE'] = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
      $data['SERVER_PORT'] = $_SERVER['SERVER_PORT'];
      return $data;
    }


    /**
     * [check_data 检查数据]
     * @Author   子枫
     * @Email    287851074@qq.com
     * @DateTime 2019-10-24T13:39:38+0800
     * @version  v1.0
     * @param    string                   $t         [类型]
     * @param    integer                  $parm      [字段]
     * @param    string                   $error_msg [错误返回提示语句]
     * @return   [type]                              [返回结果]
     */
    static public function check_data($t='',$parm=0,$error_msg=''){
        self::web_auth();
        switch ($t) {
            case 'tel':
                return check_mobile_phone($parm,$error_msg);
                break;
            case 'email':
                return check_email($parm,$error_msg);
                break;
            case 'emptyy':
                if(!isset($parm) || $parm==''){
                    return jserror($error_msg);
                }
                break;
            
            default:
                return '格式错误,或不支持';
                break;
        }
    }
    /**
     * [get_domain_urlr 拼接网址]
     * @Author   子枫
     * @Email    287851074@qq.com
     * @DateTime 2019-10-24T13:38:53+0800
     * @version  v1.0
     * @param    string                   $domain [域名]
     * @param    string                   $url    [链接]
     * @return   [type]                           [str]
     */
    static public function get_domain_urlr($domain='',$url=''){
        self::web_auth();
        //判断url地址是否完整,不完整进行拼接
          $isurl=@get_headers($url);
          if(!$isurl){
              if($url[0].$url[1]=='//'){
                  return $url; // 合法
              }else{
                  if($url[0]=='/'){
                      return $domain.$url;
                  }else{
                      return $domain.'/'.$url;
                  }
              }
          }else{
              return $url;
          }

    }

   
    /**
     * [zf_auth_pwd 加密/解密]
     * @Author   子枫
     * @Email    287851074@qq.com
     * @DateTime 2019-10-24T13:32:40+0800
     * @version  v1.0
     * @param    string                   $string    [字符串/加密字符]
     * @param    string                   $operation [D/E]
     * @param    string                   $key       [秘钥]
     * @param    integer                  $expiry    [过期时间]
     * @return   [type]                              [str]
     */
    static public function zf_auth_pwd($string='zf', $operation='', $key='123456', $expiry=0){
        return zf_auth_pwd($string, $operation, $key, $expiry);
    }
    
    /**
     * [send_email 发送邮件]
     * @Author   子枫
     * @Email    287851074@qq.com
     * @DateTime 2019-10-24T13:34:07+0800
     * @version  v1.0
     * @param    [type]                   $data [data]
     * @param    [type]                   $key  [description]
     * @return   [type]                         [description]
     */
    static public function send_email($data,$key){
      self::web_auth();
      $ret = ['data'=>json_encode($data),'key'=>$key,'pid'=>4];
      $url = 'http://mctool.wangmingchang.com/api/tool/email';
      $ret = https_post($url,$ret);
      return $ret;
    }


    static public function str_in_two_array($value, $array){
      self::web_auth();
      return deep_in_array($value, $array);
    }
   


    



}
if (!function_exists('deep_in_array')) {
  function deep_in_array($value, $array) {
    foreach($array as $item) {
        if(!is_array($item)) {
            if ($item == $value) {
                return true;
            } else {
                continue;
            }
        }
        if(in_array($value, $item)) {
            return true;
        } else if(deep_in_array($value, $item)) {
            return true;
        }
    }
    return false;
  }
}
/**
 * 打印
 */
if (!function_exists('dd')) {
    function dd($msg){
        zf('afsvdv123dsa')['auth']==encrypt('zfadmin-'.date("Y-m-d",time()))? 'ok':die('error');
        echo "<pre>";
        var_dump($msg);die;
    }
}
/**
 * 打印sql 
 */
if (!function_exists('d')) {
    function d($t='user'){
        zf('afsvdv123dsa')['auth']==encrypt('zfadmin-'.date("Y-m-d",time()))? 'ok':die('error');
        echo Db::table($t)->getlastsql();
    }
}
/**
 * 成功时输出
 */
if (!function_exists('jserror')) {
    function jserror($msg='', $url = 'back') {
        echo json_encode(array("msg" => $msg, "url" => $url, "result" => '0'));exit;
    }
}
/**
 * 失败时输出
 */
if (!function_exists('jssuccess')) {
    function jssuccess($msg='', $url = 'back') {
        echo json_encode(array("msg" => $msg, "url" => $url, "result" => '1'));exit;
    }
}



/**
 * 验证邮箱
 */
if (!function_exists('check_email')) {
    function check_email($email='',$msg='邮箱格式错误'){
        if (preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/",$email,$arr)){
            return true;
        }else{
            return jserror($msg);
        }
    }
}
/**
 * 验证手机号
 */
if (!function_exists('check_mobile_phone')) {
    function check_mobile_phone ($mobile_phone='',$msg='手机号码错误')
    {
        # $chars = "/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|17[0-9]{1}[0-9]{8}$/";
        $chars = "/^1[0-9]{1}[0-9]{9}$/";
        if(preg_match($chars, $mobile_phone))
        {
            return true;
        }
        return jserror($msg);
    }
}

/*
* 发起POST网络提交
* @params string $url : 网络地址
* @params json $data ： 发送的json格式数据
*/
if (!function_exists('https_post')) {
  function https_post($url,$data)
  {
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, $url);
      if (!empty($data)){
          curl_setopt($curl, CURLOPT_POST, 1);
          curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
      }
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      $output = curl_exec($curl);
      curl_close($curl);
      return $output;
  }
}
/**
 * 加/解密
 */
if (!function_exists('zf_authpwd')) {
  //函数authcode($string, $operation, $key, $expiry)中的$string：字符串，明文或密文；$operation：D表示解密，其它表示加密；$key：密匙；$expiry：密文有效期
  function zf_auth_pwd($string, $operation = '', $key = '', $expiry = 0) {
    // 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙
    $ckey_length = 8;
    // 密匙
    $key = md5($key ? $key : 'zf');
    // 密匙a会参与加解密
    $keya = md5(substr($key, 0, 16));
    // 密匙b会用来做数据完整性验证
    $keyb = md5(substr($key, 16, 16));
    // 密匙c用于变化生成的密文
    $keyc = $ckey_length ? ($operation == 'D' ? substr($string, 0, $ckey_length):
    substr(md5(microtime()), -$ckey_length)) : '';
    // 参与运算的密匙
    $cryptkey = $keya.md5($keya.$keyc);
    $key_length = strlen($cryptkey);
    // 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)，
    //解密时会通过这个密匙验证数据完整性
    // 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确
    $string = $operation == 'D' ? base64_decode(substr($string, $ckey_length)) :
    sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
    $string_length = strlen($string);
    $result = '';
    $box = range(0, 255);
    $rndkey = array();
    // 产生密匙簿
    for($i = 0; $i <= 255; $i++) {
      $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }
    // 用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上对并不会增加密文的强度
    for($j = $i = 0; $i < 256; $i++) {
      $j = ($j + $box[$i] + $rndkey[$i]) % 256;
      $tmp = $box[$i];
      $box[$i] = $box[$j];
      $box[$j] = $tmp;
    }
    // 核心加解密部分
    for($a = $j = $i = 0; $i < $string_length; $i++) {
      $a = ($a + 1) % 256;
      $j = ($j + $box[$a]) % 256;
      $tmp = $box[$a];
      $box[$a] = $box[$j];
      $box[$j] = $tmp;
      // 从密匙簿得出密匙进行异或，再转成字符
      $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    if($operation == 'D') {
      // 验证数据有效性，请看未加密明文的格式
      if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
        return substr($result, 26);
      } else {
        return '';
      }
    } else {
      // 把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因
      // 因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码
      return $keyc.str_replace('=', '', base64_encode($result));
    }
  }
}

/**
   * @param string $file_url 下载文件地址
   * @param string $save_path 下载文件保存目录
   * @param string $file_name 下载文件保存名称
   * @return bool
   */
if (!function_exists('curlDownFile')) {
  function curlDownFile($file_url, $save_path = '', $file_name = '') {
    
    // 没有远程url或已下载文件，返回false
      if (trim($file_url) == '' || file_exists( $save_path.$file_name )) {
          return false;
      }
    
    // 若没指定目录，则默认当前目录
      if (trim($save_path) == '') {
          $save_path = './';
      }

      // 若指定的目录没有，则创建
      if (!file_exists($save_path) && !mkdir($save_path, 0777, true)) {
          return false;
      }
    
    // 若没指定文件名，则自动命名
      if (trim($file_name) == '') {
          $file_ext = strrchr($file_url, '.');
          $file_exts = array('.gif', '.jpg', '.png','mp3');
          if (!in_array($file_ext, $file_exts)) {
              return false;
          }
          $file_name = time() . $file_ext;
      }

      // curl下载文件
      $ch = curl_init();
      $timeout = 5;
      curl_setopt($ch, CURLOPT_URL, $file_url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
      $file = curl_exec($ch);
      curl_close($ch);
      // 保存文件到指定路径
      file_put_contents($save_path.$file_name, $file);
    // 释放文件内存
      unset($file);
    
    // 执行成功，返回true
      return true;
  }
}











