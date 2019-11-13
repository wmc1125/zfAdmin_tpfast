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
use EasyWeChat\Factory;
class Wxapp
{
  
    public function login()
    {
      $config = [
        'app_id' => 'wxed2e4dbbbacb24d2',
        'secret' => '6061f66****3a224cc7e',
        // 下面为可选项
        'response_type' => 'array',
        'log' => [
            'level' => 'debug',
            'file' => __DIR__.'/wechat.log',
        ],
      ];
      $app = Factory::miniProgram($config);

      //解密
      $session = input('sessionKey');
      $iv = input('iv') ; 
      $encryptData = input('encryptedData'); 
      $decryptedData = $app->encryptor->decryptData($session, $iv, $encryptData);
      // dd($decryptedData);

      $userinfo = $decryptedData;
    	$data['nickName'] = $userinfo['nickName'];
    	$data['name'] = $userinfo['nickName'];
    	$data['sex'] = $userinfo['gender'];
    	$data['avatarUrl'] = $userinfo['avatarUrl'];
    	$data['pic'] = $userinfo['avatarUrl'];
      $data['openid'] = $userinfo['openId'];
    	$data['create_time'] = time();
    	if($data['openid']==''){
    		return jserror("error");die;
      }
      // dd($data);
    	//判断是否已经存在
      $res_is = Db::name('user')->where("openid='".$data['openid']."'")->find();
    	if(!$res_is){
    		$res = Db::name('user')->data($data)->insert();
        if(!$res){
          return jserror("写入失败");die;
        }
      }
      $suser = Db::name('user')->where("openid='".$data['openid']."'")->find();
      return jssuccess(['user'=>$suser,'rand'=>time()]);
    }
    public function get_openid()
    {
        $code = input("code");
        $appid = 'wxed2e4dbbbacb24d2';
        $appsecret = '6061f667156e5f8ed495d993a224cc7e';
        $weixin =  file_get_contents("https://api.weixin.qq.com/sns/jscode2session?appid=".$appid."&secret=".$appsecret."&js_code=".$code."&grant_type=authorization_code");//通过code换取网页授权access_token
        $jsondecode = json_decode($weixin); //对JSON格式的字符串进行编码
        $array = get_object_vars($jsondecode);//转换成数组
        $data['session_key'] = $array['session_key'];
        $data['openid'] = $array['openid'];

        return  jssuccess($data);//输出openid
        // dump($array);die;
    }

    // public function login_pic(){
    //   $str = 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1543122506653&di=49264e19f3abe1da5b5c909824f73e5b&imgtype=0&src=http%3A%2F%2Fws3.sinaimg.cn%2Fbmiddle%2F9150e4e5ly1fczhkcvmn5j20d80hstbw.jpg';
    //     return jssuccess($str);
    // }
    public function index(){
      $msg['brand'] = Db::name('category')->field("cid,name,icon")->where(['pid'=>1,'status'=>1])->limit(5)->order("cid asc,sort desc")->select();
      $msg['brand_list'] = Db::name('category')->field("cid,name,icon,sx,pic")->where(['pid'=>1,'status'=>1])->order("cid asc,sort desc")->select();
      foreach($msg['brand_list'] as $k => $vo){
      	$msg['brand_list']['sx'] = strtoupper($vo['sx']);
      }
      $msg['ceping'] = Db::name('post')->field("id,title,pic")->where(['cid'=>409,'status'=>1])->limit(5)->order("id asc,sort desc")->select();
      return jssuccess($msg);
    }


  
  	public function brand(){
  		$brand_list = Db::name('category')->where(['pid'=>1])->order("sort asc,cid asc")->select();
        return jssuccess($brand_list);
  	}


    public function post_list_c(){
        $cid = input("cid",'0');
      	
      	$r['res'] = Db::name('category')->field("cid,name,icon,summary")->where("cid=".$cid)->find();
      	$r['child_cate'] = Db::name('category')->field("cid,name,icon")->where(["pid"=>$cid,'status'=>1])->order("sort asc,cid asc")->select();
        foreach($r['child_cate'] as $k=>$vo){
    		$r["child_cate"][$k]['list'] = Db::name('post')->field("id,title,pic,summary")->where(["cid"=>$vo['cid'],'status'=>1])->order("sort asc,cid asc")->select();
        }
        return jssuccess($r);
    }
  //详情
    public function detail($id){
    	if(!$id){
    		return jserror();
    	}
      $res = Db::name('post p')
              ->field('p.*,c.pid cpid')
              ->where(["p.id"=>$id])
              ->join('zf_category c','c.cid = p.cid')
              ->find();
      $top_name = Db::name('category')->field('ccname,name')->where(['cid'=>$res['cpid']])->find();
      $res['top_name'] = ($top_name['ccname']==''?$top_name['name']:$top_name['ccname']);
      //更新记录
      Db::name('post')->where(["id"=>$id])->setInc('hits');

      //评论
      $res['comment'] = Db::name('user_comment c')
                        ->field('c.content,c.ctime,u.name,u.pic')
                        ->where(["c.gid"=>$id,'c.status'=>1])
                        ->join('zf_user u','u.id = c.uid')
                        ->order('c.ctime desc')
                        ->select();
      foreach($res['comment'] as $k=>$vo){
        $res['comment'][$k]['time'] = date("Y-m-d H:i:s",$vo['ctime']);
      }



      return jssuccess($res);
    }
  	public function ceping(){
      $cid = input("cid",'409');
    	$list = Db::name('post')->field("id,title,pic,summary")->where(["cid"=>$cid,"status"=>1])->order("sort asc,cid asc")->select();
      return jssuccess($list);
    }
    public function ajax_comment(){
      $data = input();
      // dd($data);
      $data['ctime'] = time();
      $data['status'] = 1;
      $res = Db::name('user_comment')->insert($data);
      if($res){

        $comment = Db::name('user_comment c')
                        ->field('c.content,c.ctime,u.name,u.pic')
                        ->where(["c.gid"=>$data['gid'],'c.status'=>1])
                        ->join('zf_user u','u.id = c.uid')
                        ->order('c.ctime desc')
                        ->select();
        foreach($comment as $k=>$vo){
          $comment[$k]['time'] = date("Y-m-d H:i:s",$vo['ctime']);
        }
        return jssuccess($comment);
      }else{
        return jserror('error');
      }
    }




  	// public function posts(){
   //  	if(input("keyword")){
   //        $keyword = input("keyword"); 
   //        $where = "status=1 and cid !=47 and  (title like '%$keyword%'  or content like '%$keyword%') ";
   //  	}else{
   //        $where['title'] = '';
   //      }
   //      //分页
   //    	if(input("length")){
   //        $length = input("length");
   //        $limit= $length .",20";
   //      }else{
   //      	$limit='20';
   //      }

   //      if(input('tb')){
   //        $list = Db::name(input('tb'))->field("id,title,hits,pic")->where($where)->limit($limit)->order("id desc")->select();
   //      }else{
   //        $list = Db::name('post')->field("id,title,hits")->where($where)->limit($limit)->order("sort desc,id desc")->select();
   //      }
   //  // echo DB('biaoqingbao')->getlastsql();
   //      return jssuccess($list);
   //  }
  
  //banner
  // 	public function banner(){
  //   	$list = Db::name('advert')->where("pid=5")->order("sort asc,id asc")->select();
		// $msg['banner'] = $list;
  //     	$z_count = Db::name('post')->where("status=1")->count();
      
  //     	//$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));  
		// //$endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;  
  //     	//$now_count = Db::name('post')->where("status=1 and ".$beginToday."< create_time <".$endToday)->count();
  //     	$msg['pmd'] = '全部话术:780  表情包 10w+';
  //       return jssuccess($msg);
  //   }
  // //专题列表
  // 	public function post_list_zt(){
  //      $cid = 47;
  //     //分页
  //     	if(input("length")){
  //         $length = input("length");
  //         $limit= $length .",20";
  //       }else{
  //       	$limit='20';
  //       }
  //   	$list = Db::name('post')->field("id,title,create_time,pic,hits")->where("cid=".$cid)->limit($limit)->order("sort desc,id desc")->select();
  //     if(is_array($list)){
  //       foreach($list as $k=>$vo){
  //         $list[$k]['create_time'] = date("Y/m/d",$vo['create_time']);
  //         $list[$k]['author'] ="土味君";
  //         $list[$k]['author_pic'] = 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1546696291&di=e9fc4f57ea969267f20fb0c0e05af41c&imgtype=jpg&er=1&src=http%3A%2F%2Fimg3.duitang.com%2Fuploads%2Fitem%2F201504%2F18%2F20150418H0058_xX2fE.thumb.700_0.jpeg';

  //         $list[$k]['pic'] =  ($vo['pic']==''?'https://image.weilanwl.com/img/4x3-1.jpg':$vo['pic']);
  //       }
  //     }
  //       return jssuccess($list);
  //   }
  

  	// public function sys_page($k){
   //  	if($k=='contact'){
   //      	$cid = 44;
   //      }elseif($k=='cjwt'){
   //      	$cid = 45; 
   //      }elseif($k=='ziliao'){
   //      	$cid = 46;
   //      }
   //  	$res = Db::name('category')->where("cid=".$cid)->find();

   //      return jssuccess($res);
   //  }

    //小程序推荐
//     public function xcxtuijian()
//     {
//       //echo input("length");die;
//         $cid=49;
//         if(input("length")){
//           $length = input("length");
//             $limit= $length .",8";

//         }else{
//             $limit='8';
//         }
// //      echo $limit;die;
//         $list = Db::name('post')->field("id,title,pic,summary,url,append")->where("cid=".$cid)->limit($limit)->order("id desc")->select();
//         return jssuccess($list);
//     }


   
    
}
