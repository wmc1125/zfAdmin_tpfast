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

namespace app\demo\controller;

class Mctool extends Base
{
    public function index()
    {
        echo "mctool";
    }
    /**
     * 从当前服务器下载文件到本地
     * @Author   子枫
     * @Email    287851074@qq.com
     * @DateTime 2019-11-13T13:26:41+0800
     * @version  v1.0
     * @return   [type]                   [description]
     */
    public function output_file_download()
    {
        $str = 'http://v1.fast.zf.90ckm.com/public/static/style/layui/css/layui.css';
        $path = '.'.parse_url($str)['path'];
        $file = basename($path);
        $r = \Wmc1125\Mctoolsdk\Download::output_file_download( $path,$file);
    }
    /**
     * 无限级分类
     * @Author   子枫
     * @Email    287851074@qq.com
     * @DateTime 2019-11-13T13:35:50+0800
     * @version  v1.0
     * @return   [type]                   [description]
     */
    public function category(){
          $data[]=array('cid'=>1,'pid'=>0,'name'=>'中国');
          $data[]=array('cid'=>2,'pid'=>0,'name'=>'美国');
          $data[]=array('cid'=>3,'pid'=>0,'name'=>'韩国');
          $data[]=array('cid'=>4,'pid'=>1,'name'=>'北京');
          $data[]=array('cid'=>5,'pid'=>1,'name'=>'上海');
          $data[]=array('cid'=>6,'pid'=>1,'name'=>'广西');
          $data[]=array('cid'=>7,'pid'=>6,'name'=>'桂林');
          $data[]=array('cid'=>8,'pid'=>6,'name'=>'南宁');
          $data[]=array('cid'=>9,'pid'=>6,'name'=>'柳州');
          $data[]=array('cid'=>10,'pid'=>2,'name'=>'纽约');
          $data[]=array('cid'=>11,'pid'=>2,'name'=>'华盛顿');
          $data[]=array('cid'=>12,'pid'=>3,'name'=>'首尔');
          $cat=new \Wmc1125\Mctoolsdk\Category(array('cid','pid','name','cname'));
          $s=$cat->getTree($data);//获取分类数据树结构
          $s=$cat->getTree($data,1);//获取pid=1所有子类数据树结构
          foreach($s as $vo)
          {
          echo $vo['cname'].'<br>';
          }
    }

    /**
     * [获取图片地址]
     * @Author   子枫
     * @Email    287851074@qq.com
     * @DateTime 2019-11-13T13:42:08+0800
     * @version  v1.0
     * @return   [type]                   [description]
     */
    public function get_img_src(){
        $str = '<div>
                    <p>这里是普通文字</p>
                    <p>这里是干扰元素测试"""</p>
                    <img src="src1.png"/>
                    <img src="src2.png"/>
                    <img src="src3.jpg"/>
                </div>';
                /**
                 * 提取HTML文章中的图片地址
                 * @param string $data
                 * @param int $num 第 $num 个图片的src，默认为第一张
                 * @param string $order 顺取倒取； 默认为 asc ，从正方向计数。 desc 从反方向计数
                 * @param string|array $blacklist 图片地址黑名单，排除图片地址中包含该数据的地址；例如 传入 baidu.com  会排除 src="http://www.baidu.com/img/a.png"
                 * @param string $model 默认为字符串模式;可取值 string  preg；string模式处理效率高，PHP版本越高速度越快，可比正则快几倍
                 * @return false | null | src  当data为空时返回 false ， src不存在时返回 null ，反之返回src
                 */
        $src = \Wmc1125\Mctoolsdk\GetImgSrc::src($str, 1);  
        dd($src);
    }
    /**
     * google验证码
     * @Author   子枫
     * @Email    287851074@qq.com
     * @DateTime 2019-11-13T14:03:59+0800
     * @version  v1.0
     * @return   [type]                   [description]
     */
    public function google(){
        $t = input('t','');
        $id = time();//用户ID(自定义)
        if($t=='create'){
            $ga = new \Wmc1125\Mctoolsdk\GoogleAuthenticator;
            $secret = $ga->createSecret();
            //1. 默认生成的二维码(国外服务器,可能会不显示)
            // $qrCodeUrl = $ga->getQRCodeGoogleUrl('zf-'.$id, $secret);
            //otpauth://totp/zf-1?secret=Y67N442CU2G4CIAG
            //2. 使用接口生成的二维码
            $qrCodeUrl = 'http://mctool.wangmingchang.com/api/tool/create_qr_code?t=google&name=zf-'.$id.'&secret='.$secret;
            $oneCode = $ga->getCode($secret);
            echo 'secret:'.$secret.'<br>';
            echo 'code:'.$oneCode;
        }elseif($t=='check'){
            $google_secret = input('google_secret');//传入secret
            $google_code = input('google_code');//传入code
            $ga = new \Wmc1125\Mctoolsdk\GoogleAuthenticator;
            $secret = $userInfo['google_secret'];
            $qrCodeUrl = $ga->getQRCodeGoogleUrl('zf-'.$id, $secret);
            $oneCode = $google_code;
            $checkResult = $ga->verifyCode($secret, $oneCode, 2);    // 2 = 2*30sec clock tolerance
            if (!$checkResult) {
                return '谷歌验证错误';die;
            }
        }
        


        
        

    }
    
   


}
