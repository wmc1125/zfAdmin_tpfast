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
class Wxapp extends Controller
{
  
    public function login()
    {
      $data1 = input('post.');
      $userinfo = $data1['userinfo'];
      
      $data['nickName'] = $userinfo['nickName'];
      $data['name'] = $userinfo['nickName'];
      $data['sex'] = $userinfo['gender'];
      $data['avatarUrl'] = $userinfo['avatarUrl'];
      $data['pic'] = $userinfo['avatarUrl'];
      $data['openid'] = $data1['openid'];
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
      $suser = Db::name('user')->where("openid='".$data['openid']."'")->find();
      return jssuccess(['user'=>$suser,'rand'=>time()]);
    }
    public function get_openid()
    {
        $code = input("code");
        $appid = 'wxc14c7d03e7bab5f8';
        $appsecret = '886a5beab7b4578ea6a20b3d715f7a4d';
        $weixin =  file_get_contents("https://api.weixin.qq.com/sns/jscode2session?appid=".$appid."&secret=".$appsecret."&js_code=".$code."&grant_type=authorization_code");//通过code换取网页授权access_token
        $jsondecode = json_decode($weixin); //对JSON格式的字符串进行编码
        $array = get_object_vars($jsondecode);//转换成数组
        $data['session_key'] = $array['session_key'];
        $data['openid'] = $array['openid'];
        return  jssuccess($data);//输出openid
    }

    // public function login_pic(){
    //   $str = 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1543122506653&di=49264e19f3abe1da5b5c909824f73e5b&imgtype=0&src=http%3A%2F%2Fws3.sinaimg.cn%2Fbmiddle%2F9150e4e5ly1fczhkcvmn5j20d80hstbw.jpg';
    //     return jssuccess($str);
    // }
    public function index(){
      // $page = input('page',1);
      // $msg['list'] = Db::name('user_pic')->where(['status'=>1])->page($page,8)->order("id desc")->select();
      $cid = input('cid','');
      if($cid!='' && $cid!='{cid'){
          $where[] = ['cid','=',$cid];
      }
      // $where[] = [];
      $where[] = ['status','=',1];
      $list = Db::name('doutu_post')->where($where)->order("sort desc,id desc")->limit(100)->select();
        

      return jssuccess($list);
    }
    public function user_list_img(){
      $page = input('page',1);
      $openid = input('openid',1);

      $msg['list'] = Db::name('user_pic')->where(['status'=>1,'openid'=>$openid])->page($page,8)->order("id desc")->select();
      
      return jssuccess($msg);
    }
    public function img_detail(){
      $id = input('id',1);
      $msg['detail'] = Db::name('user_pic')->where(['id'=>$id,'status'=>1])->find();
      return jssuccess($msg);
    }

    // 图床系统
    public function imgup()
    {
      $file = request()->file('file');
      $openid = input('openid',0);
      $info = $file->rule('date')->validate(['size'=>1048576000,'ext'=>'jpg,png,gif,txt,pdf,doc,mp4,mp3'])->move( './upload/filex');//100m
      if($info){
          $data['title'] = $info->getFilename();
          $data['file_url'] = Request::instance()->domain().'/upload/filex/'. $info->getSaveName();
          $data['path'] = '/upload/filex/'. $info->getSaveName();
          $data['create_time'] = time();
          $data['openid'] = $openid;
          $res =Db::name('file')->insertGetId($data);
          if($res){
            // $img = '.'.$data['path'];
            // $base64_img = base64EncodeImage($img);
              //进行人脸识别
              $file_img_url = $data['file_url'];
              $token = $this->access_token();
              $url = 'https://aip.baidubce.com/rest/2.0/face/v3/detect?access_token=' . $token;
              $bodys = '{"image":"'.$file_img_url.'","image_type":"URL","face_field":"beauty,age,expression,gender,emotion,race"}';
              // $bodys = '{"image":"'.$base64_img.'","image_type":"BASE64","face_field":"beauty,age,expression,gender,emotion,race"}';
              $res = request_post($url, $bodys);
              $data = json_decode($res);
              // echo $file_img_url;
              // dd($data);
              if($data->error_code==0){
                  $ret['beauty'] = $data->result->face_list[0]->beauty;//颜值
                  $ret['age'] = $data->result->face_list[0]->age;//年龄
                  $ret['gender'] = $data->result->face_list[0]->gender->type=='female'?'女性':'男性';//性别
                  $ret['race'] = $data->result->face_list[0]->race->type;//种族
                  $ret['create_time'] = time();
                  $ret['url'] = $file_img_url;
                  $ret['fid'] = $res;
                  $ret['openid'] = $openid;
                  $res_ret =Db::name('user_pic')->insertGetId($ret);
                  if($res_ret){
                    return jssuccess($res_ret);
                  }else{
                    return jserror('写入失败2');
                  }
              }else{
                return jserror('未识别出...');
              }
          }else{
            return jserror('写入失败1');
          }
      }else{
          return jserror($file->getError());
      }
       
    }
  
    public function access_token(){
      // access_token
      $url = 'https://aip.baidubce.com/oauth/2.0/token';
      $post_data['grant_type']       = 'client_credentials';
      $post_data['client_id']      = 'Gfs4GPRlY1WXmi0PMag2hYsz';
      $post_data['client_secret'] = 'BXGYa98IbiTGyxa0lwIlyBcuSxj1dtYh';
      $o = "";
      foreach ( $post_data as $k => $v ) {
          $o.= "$k=" . urlencode( $v ). "&" ;
      }
      $post_data = substr($o,0,-1);
      $res = request_post($url, $post_data);
      $refresh_token = json_decode($res)->access_token;
      // refresh_token;
      return  $refresh_token;
  }
  public function category_detail(){
    $cid = input('cid',0);
    $res = Db::name('category')->where(['cid'=>$cid])->find();
    return jssuccess($res);

  }



  
    // public function brand(){
    //  $brand_list = Db::name('category')->where(['pid'=>1])->order("sort asc,cid asc")->select();
    //     return jssuccess($brand_list);
    // }


    // public function post_list_c(){
    //     $cid = input("cid",'0');
        
    //    $r['res'] = Db::name('category')->field("cid,name,icon,summary")->where("cid=".$cid)->find();
    //    $r['child_cate'] = Db::name('category')->field("cid,name,icon")->where(["pid"=>$cid,'status'=>1])->order("sort asc,cid asc")->select();
    //     foreach($r['child_cate'] as $k=>$vo){
    //    $r["child_cate"][$k]['list'] = Db::name('post')->field("id,title,pic,summary")->where(["cid"=>$vo['cid'],'status'=>1])->order("sort asc,cid asc")->select();
    //     }
    //     return jssuccess($r);
    // }
  //详情
    // public function detail($id){
    //  if(!$id){
    //    return jserror();
    //  }
    //   $res = Db::name('post p')
    //           ->field('p.*,c.pid cpid')
    //           ->where(["p.id"=>$id])
    //           ->join('zf_category c','c.cid = p.cid')
    //           ->find();
    //   $top_name = Db::name('category')->field('ccname,name')->where(['cid'=>$res['cpid']])->find();
    //   $res['top_name'] = ($top_name['ccname']==''?$top_name['name']:$top_name['ccname']);
    //   //更新记录
    //   Db::name('post')->where(["id"=>$id])->setInc('hits');

    //   //评论
    //   $res['comment'] = Db::name('user_comment c')
    //                     ->field('c.content,c.ctime,u.name,u.pic')
    //                     ->where(["c.gid"=>$id,'c.status'=>1])
    //                     ->join('zf_user u','u.id = c.uid')
    //                     ->order('c.ctime desc')
    //                     ->select();
    //   foreach($res['comment'] as $k=>$vo){
    //     $res['comment'][$k]['time'] = date("Y-m-d H:i:s",$vo['ctime']);
    //   }



    //   return jssuccess($res);
    // }
    // public function ceping(){
    //   $cid = input("cid",'409');
    //  $list = Db::name('post')->field("id,title,pic,summary")->where(["cid"=>$cid,"status"=>1])->order("sort asc,cid asc")->select();
    //   return jssuccess($list);
    // }
    // public function ajax_comment(){
    //   $data = input();
    //   // dd($data);
    //   $data['ctime'] = time();
    //   $data['status'] = 1;
    //   $res = Db::name('user_comment')->insert($data);
    //   if($res){

    //     $comment = Db::name('user_comment c')
    //                     ->field('c.content,c.ctime,u.name,u.pic')
    //                     ->where(["c.gid"=>$data['gid'],'c.status'=>1])
    //                     ->join('zf_user u','u.id = c.uid')
    //                     ->order('c.ctime desc')
    //                     ->select();
    //     foreach($comment as $k=>$vo){
    //       $comment[$k]['time'] = date("Y-m-d H:i:s",$vo['ctime']);
    //     }
    //     return jssuccess($comment);
    //   }else{
    //     return jserror('error');
    //   }
    // }




    // public function posts(){
   //   if(input("keyword")){
   //        $keyword = input("keyword"); 
   //        $where = "status=1 and cid !=47 and  (title like '%$keyword%'  or content like '%$keyword%') ";
   //   }else{
   //        $where['title'] = '';
   //      }
   //      //分页
   //     if(input("length")){
   //        $length = input("length");
   //        $limit= $length .",20";
   //      }else{
   //       $limit='20';
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
  //  public function banner(){
  //    $list = Db::name('advert')->where("pid=5")->order("sort asc,id asc")->select();
    // $msg['banner'] = $list;
  //      $z_count = Db::name('post')->where("status=1")->count();
      
  //      //$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));  
    // //$endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;  
  //      //$now_count = Db::name('post')->where("status=1 and ".$beginToday."< create_time <".$endToday)->count();
  //      $msg['pmd'] = '全部话术:780  表情包 10w+';
  //       return jssuccess($msg);
  //   }
  // //专题列表
  //  public function post_list_zt(){
  //      $cid = 47;
  //     //分页
  //      if(input("length")){
  //         $length = input("length");
  //         $limit= $length .",20";
  //       }else{
  //        $limit='20';
  //       }
  //    $list = Db::name('post')->field("id,title,create_time,pic,hits")->where("cid=".$cid)->limit($limit)->order("sort desc,id desc")->select();
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
   //   if($k=='contact'){
   //       $cid = 44;
   //      }elseif($k=='cjwt'){
   //       $cid = 45; 
   //      }elseif($k=='ziliao'){
   //       $cid = 46;
   //      }
   //   $res = Db::name('category')->where("cid=".$cid)->find();

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
