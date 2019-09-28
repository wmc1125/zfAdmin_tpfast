<?php
namespace app\demo\controller;
use think\Db;
use dingxiang\CaptchaClient;//test使用
use dingxiang\CtuClient;//test2使用
use dingxiang\model\CtuRequest;

class Dingxiang extends Base
{
    public function index()
    {
    	echo "demo";
    }
   
    public function test(){
        if(request()->isPost()){
          //获取前端的token
            $send_token = input('post.token','0');
            $appId = "discuza01d13cdd5a2b01f2f5e53d14ccbbb5f";
            $appSecret = "3686d7440438c7bdd6efb252586149fa";
            $client = new CaptchaClient($appId,$appSecret);
            $client->setTimeOut(2);      //设置超时时间
            # $client->setCaptchaUrl("http://cap.dingxiang-inc.com/api/tokenVerify");   //特殊情况需要额外指定服务器,可以在这个指定，默认情况下不需要设置
            $response = $client->verifyToken($send_token);
            //确保验证状态是SERVER_SUCCESS，SDK中有容错机制，在网络出现异常的情况会返回通过
            if($response->result){
                echo "token验证通过，继续其他流程";
                /**token验证通过，继续其他流程**/
            }else{
                echo "token验证失败";
                /**token验证失败**/
            }
            die;
        }
        return view();
    }

    public function test2(){
        $url = "http://sec.dingxiang-inc.com/ctu/event.do";
        $appId = "discuza01d13cdd5a2b01f2f5e53d14ccbbb5f";
        $appSecret = "3686d7440438c7bdd6efb252586149fa";
        // 时区
        ini_set('date.timezone','Asia/Shanghai');
        // 构造请求参数
        $request = new CtuClient($url, $appId, $appSecret);
        $reqJsonString =  json_encode($request, JSON_UNESCAPED_UNICODE);
        $ctuRequest = new CtuRequest();
        // $data 具体的业务参数,根据业务实际情况传入
        $data = array (
            "const_id" => "egUbLWXKgiPKBMmcwbZsF1PqoflWOyhKLIhAzw9X1",
            "user_id" => "438699324",
            "phone_number" => "15958004277",
            "source" => 2,
            "activity_id" => 1,
            "ext_prov_name" => "北京市",
            "register_date" => date('Y-m-d H:i:s'),
            "ext_answer_end_date" => date('Y-m-d H:i:s'),
            "ext_answer_start_date" => date('Y-m-d H:i:s'),
            "ext_user_level" => 5,
            "ext_open_id" => "58483ea3174dde1f",
            "ip" => "127.0.0.1");
        // $eventCode 事件code
        $ctuRequest -> eventCode = "event_code";
        $ctuRequest -> flag = "activity_" . time();
        $ctuRequest -> data = $data;

        // 请求超时时间,单位秒
        $timeout = 2;
        //调用风控引擎
        $responseData = $request -> checkRisk($ctuRequest, $timeout);
        echo "风险引擎返回结果:" . $responseData. "\n";
        $jsonResult = json_decode($responseData, true);
        $result = $jsonResult['result']["riskLevel"];
        // dd($result);

        // ... 根据不同风险做出相关处理
        if ($result == "ACCEPT") {
            // 无风险,建议放过
            echo "风险结果:无风险,建议放过" . "\n";
        } else if ($result == "REVIEW") {
            // 不确定,需要进一步审核
            echo "风险结果:不确定,需要进一步审核" . "\n";
        } else if ($result == "REJECT") {
            // 有风险,建议拒绝
            echo "风险结果:有风险,建议拒绝" . "\n";
        }


    }
    
   
    



}
