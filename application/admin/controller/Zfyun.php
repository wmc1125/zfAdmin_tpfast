<?php
namespace app\admin\controller;
use think\facade\Session;
use think\facade\Cache;
use think\facade\Request;
use think\Db;
use Wmc1125\TpFast\Database as dbOper;
use app\admin\controller\Common;
use Wmc1125\TpFast\Download;
use zf\PclZip;
use think\Controller;
class Zfyun extends Controller
{
    public function __construct (){
        parent::__construct();
        //站点key
        // $this->email = '287851074@qq.com';//删除
        // $this->key = md5($this->email).mt_rand(100,999);
        $this->key = '459c2e61062d15b8e79cfd8700545bb7174';
        $this->key = substr($this->key,0,32);
        $this->pro = '测试板块';
        echo "key:".$this->key.'<br>';
        ####创建sc####
        // $this->create_sc();
       
        ####验证sc####
        $sc_file = './config/zf_auth.php';
        if(!file_exists($sc_file)){
            echo '授权文件不存在'; die;
        }
        $this->sc = file_get_contents($sc_file);
        // $this->sc = 'roOmm9eVmJ2hzpiZ0VieUnFoxdGllJijpoiShteh2ZiSyqNUnVJqa2KPbmiRZ51jZmqWnFqSV5ery8fYyZfZnKDGVWyUZXFtaJFwYJxmkFKoqtGIcoiRqW/KmsbArZ2Vl5aPp5lncJ+O1mxnmG2GXFqdz8eh0lduW5iem5xtlmNqlXOj1F6cqJ+DtA==';//伪sc
        $this->check_sc();//验证sc
        



    }
    //检查key是否正确
    private function check_sc(){
        if($this->sc==''){
            echo '请提供sc'; die;
        }
        //解密
        $json_data = $this->zf_decrypt($this->sc,$this->key);
        $data = json_decode($json_data);
        if($data){
            //判断email
            if(md5($data->email)!=$this->key){
                echo 'key值错误 '; die;
            }
            //判断产品
            if($data->pro!=$this->pro){
                echo '未授权该产品'; die;
            }  
        }else{
                echo '未授权产品,sc/key错误'; die;
        }
        
    }
    // 发送错误信息
    private function send_err1($err_data = ''){
        $data['site_domain'] = '90ckm.com';
        $data['site_ip'] = gethostbyname($_SERVER['SERVER_NAME']);
        $data['create_time'] = time();
        $data['pro'] = '测试板块';
        $data['msg'] = $err_data;
        @https_post('http://www.baidu.com',json_encode($data));
    }
    #############生成sc(删除ing)#############
    private function create_sc(){
        echo "---生成sc---<br>";
        $data['site_domain'] = '90ckm.com';
        $data['site_ip'] = gethostbyname($_SERVER['SERVER_NAME']);
        $data['create_time'] = time();
        $data['pro'] = '测试板块';
        $data['email'] = $this->email;
        $ret_str =  $this->zf_encrypt(json_encode($data),$this->key);
        echo "生成sc:".$ret_str."<br>";
        echo "---生成结束---<br>";
    }
   

    public function index()
    {
        // echo $this->key;
        //加解密
        // echo "str:".$this->key;
        // echo "<br>";
        // echo "加密_str:".$this->zf_encrypt($this->key);
        // echo "<br>";
        // echo "解密_str:".$this->zf_decrypt($this->zf_encrypt($this->key));
        // echo "<br>";
        //域名/ip授权
        // echo $_SERVER['SERVER_NAME']; //域名
        // echo gethostbyname($_SERVER['SERVER_NAME']);//ip
        // $this->check_sc(); //验证sc
        echo 'ok';

    }




    //加密
    private function zf_encrypt($data, $key='***********'){
        $key    =    md5($key);
        $x        =    0;
        $len    =    strlen($data);
        $l        =    strlen($key);
        $char = '';
        $str = '';
        for ($i = 0; $i < $len; $i++){
            if ($x == $l){
                $x = 0;
            }
            $char .= $key{$x};
            $x++;
        }
        for ($i = 0; $i < $len; $i++){
            $str .= chr(ord($data{$i}) + (ord($char{$i})) % 256);
        }
        return base64_encode($str);
    }
    //解密
    private function zf_decrypt($data, $key='***********'){
        $key = md5($key);
        $x = 0;
        $data = base64_decode($data);
        $len = strlen($data);
        $l = strlen($key);
        $char = '';
        $str = '';
        for ($i = 0; $i < $len; $i++){
            if ($x == $l){
                $x = 0;
            }
            $char .= substr($key, $x, 1);
            $x++;
        }
        for ($i = 0; $i < $len; $i++){
            if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1))){
                $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
            }
            else{
                $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
            }
        }
        return $str;
    }
    /*
    * 发起POST网络提交
    * @params string $url : 网络地址
    * @params json $data ： 发送的json格式数据
    */
    private function https_post($url,$data)
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
     /*
    * 发起GET网络提交
    * @params string $url : 网络地址
    */
    private function https_get($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE); 
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); 
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); 
        curl_setopt($curl, CURLOPT_HEADER, FALSE) ; 
        curl_setopt($curl, CURLOPT_TIMEOUT,60);
        if (curl_errno($curl)) {
            return 'Errno'.curl_error($curl);
        }
        else{$result=curl_exec($curl);}
        curl_close($curl);
        return $result;
    }

    //成功之后返回json
    private function jssuccess($msg, $url = 'back') {
        echo json_encode(array("msg" => $msg, "url" => $url, "result" => '1'));exit;
    }
    //失败之后返回json
    private function jserror($msg, $url = 'back') {
        echo json_encode(array("msg" => $msg, "url" => $url, "result" => '0'));exit;
    }

}
