<?php
namespace app\admin\controller;

class Zfyun
{
    public function __construct (){
    }

    //保存授权信息(新增/更新)
    public function save_authentication_sys(){
        // if(!isset(config()['zf_auth']['key']) || !isset(config()['zf_auth']['sc']) || !isset(config()['zf_auth']['email']) ||  config()['zf_auth']['key']=='' ||  config()['zf_auth']['sc']=='' ||  config()['zf_auth']['email']=='' ){
            $t = input('tt','');
            if($t=='save_tp5_auth'){
                $data = input('post.');
                if($data['email']!='' && $data['key']!=''  && $data['sc']!='' )
                $res = extraconfig($data,'zf_auth');
                if($res){
                    return jssuccess('保存成功');die;
                }else{
                    return jserror('保存失败');die;
                }  
            }
                
        // }
    }

























    private  function _https_post($url,$data){
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
    private  function _https_get($url){
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


    

    

}
