<?php
namespace zf11;
/*

这是个加密的文件
加密项目必须
*/
class ZfAuth{
    public function __construct (){

        
    }
    

    public function vfast_check($auth_info,$type='json'){
        $this->sc = $auth_info['sc'];
        $this->key = $auth_info['key'];
        $this->pro = $auth_info['post_id'];
        if($this->sc==''){
            return $this->retRes($type,['alert'=>'未提供sc,无法提供增值服务 <a href="tencent://message/?uin=34689347&Site=&Menu-=yes" target="_blank">点击联系我</a>','json'=>$this->jserror('未提供sc,无法提供增值服务')]);
        }
        $this->key =substr($this->key,0,32);
        //解密
        $json_data = $this->zf_decrypt($this->sc,$this->key);
        $data = json_decode($json_data);
        // dd($data);
        if($data){
            //判断key
            if(md5($data->email)!=$this->key){
                return $this->retRes($type,['alert'=>'key值错误,无法提供增值服务 <a href="tencent://message/?uin=34689347&Site=&Menu-=yes" target="_blank">点击联系我</a>','json'=>$this->jserror('key值错误,无法提供增值服务')]);
            }
            //判断产品
            if($data->pro!=$this->pro){
                return $this->retRes($type,['alert'=>'未授权该产品,无法提供增值服务 <a href="tencent://message/?uin=34689347&Site=&Menu-=yes" target="_blank">点击联系我</a>','json'=>$this->jserror('未授权该产品,无法提供增值服务')]);
            }  
            //判断域名
            if($data->type=='all' && $data->site_domain!=''){
                //根域名一直即可
                if(strpos($_SERVER['HTTP_HOST'],$data->site_domain) === false){ 
                    return $this->retRes($type,['alert'=>'域名授权失败,无法提供增值服务 <a href="tencent://message/?uin=34689347&Site=&Menu-=yes" target="_blank">点击联系我</a>','json'=>$this->jserror('域名授权失败,无法提供增值服务')]);
                }
            }else{
                if($data->site_domain!= $_SERVER['HTTP_HOST']){
                    return $this->retRes($type,['alert'=>'域名授权失败,无法提供增值服务 <a href="tencent://message/?uin=34689347&Site=&Menu-=yes" target="_blank">点击联系我</a>','json'=>$this->jserror('域名授权失败,无法提供增值服务')]);

                }
            }
            //判断授权时间
            if($data->etime!=0 && $data->etime<=time()){
                $this->retRes($type,['alert'=>'授权已到期,无法提供增值服务 <a href="tencent://message/?uin=34689347&Site=&Menu-=yes" target="_blank">点击联系我</a>','json'=>$this->jserror('授权已到期,无法提供增值服务')]);
                // header("Location: tencent://message/?uin=287851074&Site=&Menu-=yes");die;
            }
        }else{
                return $this->retRes($type,['alert'=>'未授权产品,sc/key错误,无法提供增值服务 <a href="tencent://message/?uin=34689347&Site=&Menu-=yes" target="_blank">点击联系我</a>','json'=>$this->jserror('未授权产品,sc/key错误,无法提供增值服务')]);
        }
    }
    //检查插件权限
    public function plugin_check($auth_info,$type='json'){

    }
    private function retRes($type,$data){
            echo $data[$type];die;
    }
    private function jserror($msg){
        return json_encode(array("msg" => $msg, "result" => '0'));
    }
    private function jssuccess($msg){
        return json_encode(array("msg" => $msg, "result" => '1'));
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
    /**
     * 获取顶级域名
     * @param $url
     * @return string
     */
    private function getDoMain($url){
        if(empty($url)){
            return '';
        }
        if(strpos($url,'http://') !== false){
            $url = str_replace('http://','',$url);
        }
        if(strpos($url,'https://') !== false){
            $url = str_replace('https://','',$url);
        }
        $n = 0;
        for($i = 1;$i <= 3;$i++) {
            $n = strpos($url, '/', $n);
            $i != 3 && $n++;
        }
 
        $nn = strpos($url, '?');
        $mix_num =  min($n,$nn);
        if($mix_num > 0 || !empty($mix_num)){
            //防止链接带有点 （.） 导致出错
            $url = mb_substr($url,0,$mix_num);
        }
        $data = explode('.', $url);
 
        $co_ta = count($data);
        //判断是否是双后缀
        $no_tow = true;
        $host_cn = 'com.cn,net.cn,org.cn,gov.cn';
        $host_cn = explode(',', $host_cn);
        foreach($host_cn as $val){
            if(strpos($url,$val)){
                $no_tow = false;
            }
        }
        //截取域名后的目录
        $del = strpos($data[$co_ta-1], '/');
        if($del > 0 || !empty($del)){
            $data[$co_ta-1] = mb_substr($data[$co_ta-1],0,$del);
        }
        //如果是返回FALSE ，如果不是返回true
        if($no_tow == true){
            $host = $data[$co_ta-2].'.'.$data[$co_ta-1];
        }else{
            $host = $data[$co_ta-3].'.'.$data[$co_ta-2].'.'.$data[$co_ta-1];
        }
 
        return $host;
    }

    public function addons(){

    }

    
}



?>