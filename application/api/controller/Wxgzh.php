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

namespace app\api\controller;
use \think\Config;
use think\facade\Request;
use think\Db;
use EasyWeChat\Factory;
class Wxgzh
{
  
    public function __construct (  ){
    }
   // http://v1.fast.zf.90ckm.com/api/v1.wxgzh/server/gid/1
    public function conf($gid){
      if($gid==''){
        // $this->app = app('wechat.official_account');
        // $this->gid = '';
        die;
      }else{
        $this->gid = $gid;
         // $gid;
        $g_res = Db::name('wx_config')->where([['id','=',$gid]])->find();
        $this->g_res = $g_res;
        if(!$g_res){  echo '账号不存在'; die; }
        if($g_res['status']!=1){ echo '账户已被关闭';die; }
        $options = [
            'app_id'    => $g_res['gzh_app_id'],
            'secret'    => $g_res['gzh_secret'],
            'token'     => $g_res['gzh_token'],
            'aes_key' =>$g_res['gzh_aes_key'],
            'log' => [
                'level' => 'debug',
                'file'  => '/tmp/easywechat.log',
            ],
        ];
        $this->app = Factory::officialAccount($options);

      }
    }
    // 配置
      public function server($gid){
        $this->conf($gid);
          ob_clean();
          // Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志
          $this->app->server->push(function ($message) {
             // $message['FromUserName'] // 用户的 openid
            // $message['ToUserName']  //公众号原始ID
            //$message['Content']  //发送的文本消息
            // https://www.easywechat.com/docs/4.1/official-account/server
            // return $message[ 'Event'];
              switch ($message[ 'MsgType']) {
                // 事件
                  case 'event':
                    // 订阅
                    if($message['Event']=='subscribe'){
                        // return '用户订阅关注公众号事件';
                        // EventKey 事件KEY值，
                        $event_key = $message['EventKey'];

                        $event_info = substr($message['EventKey'], 8);
                    $event_arr = explode('@#@', $event_info);
                    if (!empty($event_arr) && $event_arr[0] == 'scanLogin') {
                        // 扫码登陆逻辑
                          return '欢迎关注,uid参数:'.$event_arr[1];

                          // 执行保存数据
                      // $user_info['unionid'] = $message->ToUserName;
                        // $user_info['openid'] = $user_openid;
                        // $userService = $this->app->user;
                        // $user = $userService->get($user_info['openid']);
                        // $user_info['subscribe_time'] = $user['subscribe_time'];
                        // $user_info['nickname'] = $user['nickname'];
                        // $user_info['avatar'] = $user['headimgurl'];
                        // $user_info['sex'] = $user['sex'];
                        // $user_info['province'] = $user['province'];
                        // $user_info['city'] = $user['city'];
                        // $user_info['country'] = $user['country'];
                        // $user_info['is_subscribe'] = 1;
                        // if (::weixin_attention($user_info)) {
                        //     return '欢迎关注';
                        // }else{
                        //     return '您的信息由于某种原因没有保存，请重新关注';
                        // }
                    }else{
                      // 正常点击进入
                          return '欢迎关注';
                    }

                    }elseif($message['Event']=='unsubscribe'){
                        return '取消订阅事件';
                        // 在表中删掉用户,用户并不会收到此消息
                    }elseif($message['Event']=='SCAN'){
                      // 已经关注  使用扫码进入
                      // scanLogin@#@123  类型@#@参数
                      $event_arr = explode('@#@', $message['EventKey']);
                      $key = $event_arr[1];
                        return '参数:'.$key;

                    }
                    // ...

                      break;
                  case 'text':

                    ## 关键词回复  1.在数据库这只关键词 以及回复数据   然后根据查询返回数据
                    return $this->zf_auto_msg($message);
                      // return '收到文字消息'.$message['Content'];
                      break;
                  case 'image':
                      return '收到图片消息';
                      break;
                  case 'voice':
                      return '收到语音消息';
                      break;
                  case 'video':
                      return '收到视频消息';
                      break;
                  case 'location':
                      return '收到坐标消息';
                      break;
                  case 'link':
                      return '收到链接消息';
                      break;
                  case 'file':
                      return '收到文件消息';
                  // ... 其它消息
                  case 'transfer':
                    return "多客服消息转发";
                    // return new Transfer();
                  default:
                      return '收到其它消息';
                      break;
              }
          });

    //  $this->app->server->setMessageHandler(function ($message) {
    //      return "您好！欢迎关注我!";
      // });
          return $this->app->server->serve();
      }


      public function zf_auto_msg($message){
        //发送相关内容
        // $mm = '我接受到的消息:'.$message['Content'];
        // // return $message['FromUserName'];
        // $res = $this->app->customer_service->message($mm)->to($message['FromUserName'])->send();
        // $mm2 = '我要发送的数据';
        // $res = $this->app->customer_service->message($mm2)->to($message['FromUserName'])->send();

        //查询相关搜索
          $list = Db::name('wx_gzh_automsg')->where([['keyword','like','%'.$message['Content'].'%'],['cuid','=',$this->g_res->uid],['status','=',1]])->orderBy("sort","desc")->limit(5)->select();
          foreach ($list as $k => $vo) {
          $res = $this->app->customer_service->message($vo->reply_content)->to($message['FromUserName'])->send();
          }
        
        //保存用户搜索记录
        $save_res['openid'] = $message['FromUserName'];
        $save_res['event'] = $message['MsgType'];
        $save_res['keyword'] = $message['Content'];
        $save_res['status'] = 1;
        $save_res['ctime'] = time();
        $save_res['send_ids'] = '1,2,4,2';
        $save_res['gzh_id'] = $message['ToUserName'];
          Db::name('wx_gzh_automsg_send_log')->insert($save_res);

          return '--发送完毕ZF--';

      }
      public function test(){
        // $list = Db::name('wx_gzh_automsg')->where([['keyword','like','%a%']])->orderBy("sort","desc")->limit(5)->select();
       //    foreach ($list as $k => $vo) {
       //     echo $vo->reply_content;
        //  // $res = $this->app->customer_service->message($vo->reply_content)->to($message['FromUserName'])->send();
       //    }
      }
  //基础接口
      public function base($gid=''){
  //      清理接口调用次数
  // 此接口官方有每月调用限制，不可随意调用
      // $r = $this->app->base->clearQuota();
      // dd($r);
      // array:2 [▼
      //   "errcode" => 0
      //   "errmsg" => "ok"
      // ]

  // 获取微信服务器 IP (或IP段)
      // $r = $this->app->base->getValidIps();
      // dd($r);
      // array:1 [▼
      //   "ip_list" => array:45 [▼
      //     0 => "223.166.222.100"
      //     1 => "223.166.222.101"
      //     ...
      //   ]
      // ]
      }


      
  // 消息
  // 多客服消息转发
  // 消息群发
      public function qunfa($gid=''){
        $this->conf($gid);

        // 标签ID   数组openid  全部
        // $app->broadcasting->sendMessage(Message $message, array | int $to = null);

      // 删除群发消息
      // $app->broadcasting->delete($msgId);
      // 查询群发消息发送状态
      // $app->broadcasting->status($msgId);
  ##群发
        // 文字
        // $r = $this->app->broadcasting->sendText("大家好！欢迎使用 EasyWeChat。");
    //    dd($r);
    //    array:3 [▼
      //   "errcode" => 0
      //   "errmsg" => "send job submission success"
      //   "msg_id" => 1000000001
      // ]
      // // 指定目标用户
      // // 至少两个用户的 openid，必须是数组。
      // $this->app->broadcasting->sendText("大家好！欢迎使用 EasyWeChat。", [$openid1, $openid2]);
      // // 指定标签组用户
      // $this->app->broadcasting->sendText("大家好！欢迎使用 EasyWeChat。", $tagId); // $tagId 必须是整型数字


      // 图片
      // $this->app->broadcasting->sendNews($mediaId);
      
      // 图片消息
      // $app->broadcasting->sendImage($mediaId);


      // 语音消息
      // $app->broadcasting->sendVoice($mediaId);


      // 视频消息
      // 用于群发的视频消息，需要先创建消息对象，
      // // 1. 先上传视频素材用于群发：
      // $video = '/path/to/video.mp4';
      // $videoMedia = $app->media->uploadVideoForBroadcasting($video, '视频标题', '视频描述');
      // // 2. 使用上面得到的 media_id 群发视频消息
      // $app->broadcasting->sendVideo($videoMedia['media_id']);

        //卡券消息
      // $app->broadcasting->sendCard($cardId);

  ##指定发送
      // 发送预览群发消息给指定的 openId 用户
      // $r = $this->app->broadcasting->previewText('测试openid发送', 'ofWHn1EU2HWvsU1tPEJlsXGzkJe8');
      // 发送预览群发消息给指定的微信号用户
      // $wxanme 是用户的微信号，比如：notovertrue
      // $r = $this->app->broadcasting->previewTextByName('测试微信号发送', 'wmc1125');
      // dd($r);

      // $r = $this->app->broadcasting->previewImageByName('gLCcKu0upsbFqKqhqILqqDLePTe6Q_7TdkbLM-kscUaFt_vs4_7NOr4AQxa7c1xn', 'wmc1125');
      // dd($r);

      
      }

  // 模板消息
      public function template_msg($gid=''){
        // https://www.easywechat.com/docs/4.1/official-account/template_message
      }
  // 用户
      public function user($gid=''){
        //获取用户信息
        // $user = $this->app->user->get('ofWHn1EU2HWvsU1tPEJlsXGzkJe8');
        // dd($user);
        //获取多个用户信息
        // $users = $this->app->user->select([$openId1, $openId2, ...]);
        //用户列表
        // $users = $this->app->user->list($nextOpenId = null);  // $nextOpenId 可选
        // dd($users);

        // 修改用户备注
      // $r = $this->app->user->remark('ofWHn1EU2HWvsU1tPEJlsXGzkJe8', '修改备注'); // 成功返回boolean
      // dd($r);

      // 拉黑用户
      // $this->app->user->block('ofWHn1EU2HWvsU1tPEJlsXGzkJe8');
      // 或者多个用户
      // $app->user->block(['openid1', 'openid2', 'openid3', ...]);
      
      // 取消拉黑用户
      // $this->app->user->unblock('ofWHn1EU2HWvsU1tPEJlsXGzkJe8');
      // 或者多个用户
      // $app->user->unblock(['openid1', 'openid2', 'openid3', ...]);

      // 获取黑名单
      // $list = $this->app->user->blacklist($beginOpenid = null); // $beginOpenid 可选
      // dd($list);

      // 账号迁移 openid 转换
      // $app->user->changeOpenid($oldAppId, $openidList);

      }
  // 用户标签
      public function user_tag($gid=''){
  dd("根据实际情况使用");
        // 获取所有标签
      $app->user_tag->list();
      // {
      //     "tags": [
      //         {
      //             "id": 0,
      //             "name": "标签1",
      //             "count": 72596
      //         },
      //         {
      //             "id": 1,
      //             "name": "标签2",
      //             "count": 36
      //         },
      //         ...
      //     ]
      // }
      // 创建标签
      $app->user_tag->create($name);
      
      // 修改标签信息
      $app->user_tag->update($tagId, $name);
      
      // 删除标签
      $app->user_tag->delete($tagId);

      // 获取指定 openid 用户所属的标签
      $userTags = $app->user_tag->userTags($openId);
      //
      // {
      //     "tagid_list":["标签1","标签2"]
      // }

      // 获取标签下用户列表
      $app->user_tag->usersOfTag($tagId, $nextOpenId = '');
      // $nextOpenId：第一个拉取的OPENID，不填默认从头开始拉取

      // {
      //   "count":2, // 这次获取的粉丝数量
      //   "data":{ // 粉丝列表
      //      "openid":[
      //          "ocYxcuAEy30bX0NXmGn4ypqx3tI0",
      //          "ocYxcuBt0mRugKZ7tGAHPnUaOW7Y"
      //      ]
      //   },
      //   "next_openid":"ocYxcuBt0mRugKZ7tGAHPnUaOW7Y"//拉取列表最后一个用户的openid
      // }

      // 批量为用户添加标签
      // $openIds = [$openId1, $openId2, ...];
      $app->user_tag->tagUsers($openIds, $tagId);
      
      // 批量为用户移除标签
      // $openIds = [$openId1, $openId2, ...];
      $app->user_tag->untagUsers($openIds, $tagId);
      }
  // 网页授权
  // JSSDK
      // https://www.easywechat.com/docs/4.1/basic-services/jssdk


  // 二维码
      public function qrcode($gid=''){
        // 临时
        $type='scanLogin';
        $uid = '123';
        $result = $this->app->qrcode->temporary($type.'@#@'.$uid, 6 * 24 * 3600);

        $url = $this->app->qrcode->url($result['ticket']);
        dd($url);

        // https://www.easywechat.com/docs/4.1/basic-services/qrcode


      }
  // 短网址
      public function shorten($gid=''){
        $shortUrl = $this->app->url->shorten('https://easywechat.com');
        dd($shortUrl);
      }
  // 临时素材
      public function upload($gid=''){
        $path = './logo.png';
        $r = $this->app->media->uploadImage($path);
        dd($r);
    //    array:4 [▼
      //   "type" => "image"
      //   "media_id" => "gLCcKu0upsbFqKqhqILqqDLePTe6Q_7TdkbLM-kscUaFt_vs4_7NOr4AQxa7c1xn"
      //   "created_at" => 1586249916
      //   "item" => []
      // ]
      }

  // 素材管理
  // 菜单
      public function menu(){
    //    读取（查询）已设置菜单
      // $list = $this->app->menu->list();
      // dd($list);
      // 获取当前菜单(线上菜单)
      // $current = $this->app->menu->current();
      // dd($current);

      //创建菜单
      // https://www.easywechat.com/docs/4.1/official-account/menu

        
      }
  // 卡券
  // 门店
  // 客服
      public function kf($gid=''){
        $this->conf($gid);
        // 获取所有客服
        // $list = $this->app->customer_service->list();
        // dd($list);

      // $list = $this->app->customer_service->online();
        // dd($list);

      // 添加客服
      // $res = $this->app->customer_service->create('wmc1125@jiazhuangbao', '客服1');
      // dd($res);

      // 邀请微信用户绑定客服
      // 以账号 foo@test 邀请 微信号 为 xxxx 的微信用户加入客服。
      // $res = $this->app->customer_service->invite('wmc1125@jiazhuangbao', 'wmc1125');
      // dd($res);


      // 修改客服
      // $this->app->customer_service->update('foo@test', '客服1');
      // 删除账号
      // $this->app->customer_service->delete('foo@test');
      // 设置客服头像
      // $this->app->customer_service->setAvatar('foo@test', $avatarPath); // $avatarPath 为本地图片路径，非 URL
      // 获取客服与客户聊天记录
      // $this->app->customer_service->messages($startTime, $endTime, $msgId = 1, $number = 10000);
      // 示例:

      // $records = $this->app->customer_service->messages('2015-06-07', '2015-06-21', 1, 20000);
      // 主动发送消息给用户
      $res = $this->app->customer_service->message('hello')->to('ofWHn1EU2HWvsU1tPEJlsXGzkJe8')->send();
      dd($res);
      // $message 为消息对象或文本，请参考：消息

      // 示例：

      // $this->app->customer_service->message('hello')
      //                   >  ->to('oV-gpwdOIwSI958m9osAhGBFxxxx')
      //                   >  ->send();
      // 指定客服发送消息
      // $this->app->customer_service->message($message)
      //                       >  ->from('account@test')
      //                       >  ->to($openId)
      //                       >  ->send();
      // $message 为消息对象或文本，请参考：消息

      // 示例：

      // $this->app->customer_service->message('hello')
      //                   >  ->from('kf2001@gh_176331xxxx')
      //                   >  ->to('oV-gpwdOIwSI958m9osAhGBFxxxx')
      //                   >  ->send();
      
      // 客服会话控制
      // 创建会话
      // $this->app->customer_service_session->create('test1@test', 'OPENID');
      // 关闭会话
      // $this->app->customer_service_session->close('test1@test', 'OPENID');
      // 获取客户会话状态
      // $this->app->customer_service_session->get('OPENID');
      // 获取客服会话列表
      // $this->app->customer_service_session->list('test1@test');
      // 获取未接入会话列表
      // $this->app->customer_service_session->waiting();






      }
  // 摇一摇周边
  // 数据统计与分析
  // 语义理解
      public function semantic(){
        $result = $this->app->semantic->query('查一下明天从北京到上海的南航机票', "flight,hotel", array('city' => '北京', 'uid' => '123456'));
        dd($result);
      }
  // 自动回复
      public function auto_reply($gid=''){
        $r = $this->app->auto_reply->current();
        dd($r);
      }
  // 评论数据管理
  // 返佣商品


   
    
}
