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
use think\Db;
use lib\GetImgSrc;
class Img extends Base
{
    public function index()
    {
    	echo "demo";
    }
    //图片的基本操作
   public function img(){
    $image = \think\Image::open('./a.jpg');
    // $image->crop(300, 300)->save('./crop.png');//裁剪
    // $width = $image->width(); 
    // dd($width);
    // 图像处理
    // https://www.kancloud.cn/manual/thinkphp5_1/354123
   }

   //选择随机的图
   public function rand_pic(){
        $arr = ['http://pic37.nipic.com/20140113/8800276_184927469000_2.png','http://pic225.nipic.com/file/20190628/12304177_174147435000_2.jpg','http://pic225.nipic.com/file/20190701/26588582_151929062263_2.jpg'];

        $count = count($arr)-1;
        return $arr[mt_rand(0,$count)];
   }


   //302重定向显示图片
    public function html_pic(){
        return view();
    }
    public function r302(){

        $arr = ['http://pic37.nipic.com/20140113/8800276_184927469000_2.png','http://pic225.nipic.com/file/20190628/12304177_174147435000_2.jpg','http://pic225.nipic.com/file/20190701/26588582_151929062263_2.jpg'];
        $count = count($arr)-1;
        $this->redirect($arr[mt_rand(0,$count)],302);
    }
    public function getimgsrc(){
      $str = '<p>
    <img src="https://zf-demo-test.oss-cn-beijing.aliyuncs.com/demo_zf_test/public/upload/image/20190910/1568093436298085.jpg" title="1568093436298085.jpg" alt="3.jpg"/>
</p>
<p>
    <img src="https://zf-demo-test.oss-cn-beijing.aliyuncs.com/demo_zf_test/public/upload/image/20190910/1568093445931333.jpg" style="" title="1568093445931333.jpg"/>
</p>
<p>
    <img src="https://zf-demo-test.oss-cn-beijing.aliyuncs.com/demo_zf_test/public/upload/image/20190910/1568093446176696.jpg" style="" title="1568093446176696.jpg"/>
</p>
<p>
    <br/>
</p>';
    
      // $src = GetImgSrc::src($str, 1);  
      for($i=1;$i<=15;$i++){
        $src[$i] = GetImgSrc::src($str, $i);  
        if(empty($src[$i])){
          unset($src[$i]);
          break;
        }
       
      }
      dd($src);
    }
    



}
