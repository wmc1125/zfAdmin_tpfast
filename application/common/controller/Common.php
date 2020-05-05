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

namespace app\common\controller;
use think\facade\Session;
use think\facade\Request;
use think\Db;
use think\Controller;
use think\facade\Image;
use OSS\OssClient as AliOssClient;

class Common extends controller
{
    public function __construct(){
        parent::__construct();
    }

    /**
     * @Notes:显示是与否的转换 (dbname status id )
     * @Interface is_switch
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * @author: 子枫
     * @Time: 2019/11/13   10:39 下午
     */
    public function is_switch(){
        $dbname = input('dbname');
        $is_show = input('status');
        $id = input('id');
        if($dbname=='category' || $dbname=='product_cate'){
            $res = db($dbname)->where('cid', $id)->update(['status' => $is_show]);
        }else{
            $res = db($dbname)->where('id', $id)->update(['status' => $is_show]);            
        }
        if($res){
            return jssuccess('更新成功');
        }else{
            return jserror('更新失败');
        }
    }
    


    /**
     * @Notes:上传图片
     * @Interface upload_one
     * @author: 子枫
     * @Time: 2019/11/13   10:43 下午
     */
    public function upload_one(){
        $file = request()->file('file');
        $file_glo = $_FILES['file'];

        $image = \think\Image::open($file);
        $img_config = config()['img'];
        $img_config['save_path'] = ($img_config['save_path']==''?'/public/upload/common/file':$img_config['save_path']);
        $water_name =  $img_config['save_path'].'/water/'.date("YmdHis",time()).'_'.mt_rand(1000,9999).'.png';
        if($img_config['pic_save_type']==0){
            // 给原图左上角添加水印并保存water_image.png
            if($img_config['is_water']==1){
                //图片水印
                $img_config['water_position'] = ($img_config['water_position']==''?'1':$img_config['water_position']);
                $img_config['water_clarity'] = ($img_config['water_clarity']==''?'100':$img_config['water_clarity']);
                $image->water(config()['img']['water_path'], $img_config['water_position'])->save('.'.$water_name); 
                $msg = 'http://'.$_SERVER['SERVER_NAME'].$water_name;
            }elseif($img_config['is_water']==2){
                //文字水印
                $img_config['water_text'] = ($img_config['water_text']==''?'未设置默认文字水印':$img_config['water_text']);
                $img_config['water_font_path'] = ($img_config['water_font_path']==''?'./public/upload/1.ttf':$img_config['water_font_path']);
                $img_config['water_text_size'] = ($img_config['water_text_size']==''?'20':$img_config['water_text_size']);
                $img_config['water_text_color'] = ($img_config['water_text_color']==''?'#000':$img_config['water_text_color']);
                $image->text($img_config['water_text'],$img_config['water_font_path'],$img_config['water_text_size'],$img_config['water_text_color'])->save('.'.$water_name);
                $msg = 'http://'.$_SERVER['SERVER_NAME'].$water_name;
            }else{
                //不加
                $info = $file->validate(['ext'=>config()['web']['pic_ext']])->move( './public/upload/common/image');
                $getSaveName = str_replace('\\', '/', $info->getSaveName());//win下反斜杠替换成斜杠
                $msg = 'http://'.$_SERVER['SERVER_NAME'].'/public/upload/common/image/'.$getSaveName;
            }
        }else{
            //上传到第三方
            if($img_config['pic_save_type']==3){
                $msg = $this->aliyunoss($img_config,$file_glo,$file_glo['tmp_name']);
            }
        }
        if($msg){
            return jssuccess($msg);
        }else{
            return jserror("error");
        }

    }

    /**
     * @Notes:上传文件
     * @Interface upload_one_file
     * @author: 子枫
     * @Time: 2019/11/13   10:43 下午
     */
    public function upload_one_file(){
        $file = $_FILES['file'];
        $img_config = config()['img'];
        if($img_config['file_save_type']==0){
            $file2 = request()->file('file');
            $info = $file2->validate(['ext'=>config()['web']['file_ext']])->move('./public/upload/common/file');
            $getSaveName = str_replace('\\', '/', $info->getSaveName());//win下反斜杠替换成斜杠
            $msg = 'http://'.$_SERVER['SERVER_NAME'].'/public/upload/common/file/'.$getSaveName;
        }else{
            //上传到第三方
            if($img_config['file_save_type']==3){
                $msg = $this->aliyunoss($img_config,$file,$file['tmp_name']);
            }
        }
        if($msg){
            return jssuccess($msg);
        }else{
            return jserror("error");
        }
    }

    /**
     * @Notes:阿里云oss
     * @Interface aliyunoss
     * @param $img_config
     * @param $file
     * @param $tmp_name
     * @return string
     * @throws \OSS\Core\OssException
     * @author: 子枫
     * @Time: 2019/11/13   10:44 下午
     */
    public function aliyunoss($img_config,$file,$tmp_name){
        $ossconfig = [
            'KeyId'      => $img_config['ali_ACCESSKEY'],  //您的Access Key ID
            'KeySecret'  => $img_config['ali_SECRETKEY'],  //您的Access Key Secret
            'Endpoint'   => $img_config['ali_DOMAIN'],  //阿里云oss 外网地址endpoint
            'Bucket'     => $img_config['ali_BUCKET'],  
        ];
        //获取文件后缀
        $file_name = $file['name'];
        $today = date('Ymd', time());
        //得到文件名
        $file_name = 'image/'.$today.'/'.time().'_'.$file_name;
        //实例化OSS
        $ossClient = new AliOssClient($ossconfig['KeyId'], $ossconfig['KeySecret'], $ossconfig['Endpoint']);
        try {
            //执行阿里云上传
            $result = $ossClient->uploadFile($ossconfig['Bucket'],'demo_zf_test/public/upload/simple/'. $file_name, $tmp_name);
            return $result['info']['url'];
        } catch (OssException $e) {
            return $e->getMessage();
        }
    }
    public function value_edit(){
        $dbname = input('dbname');
        $id = input('id');
        $field = input('field');
        $value = input('value');
        if($dbname=='category' || $dbname=='product_cate'){
            $res = db($dbname)->where('cid', $id)->update([$field => $value]);
        }else{
            $res = db($dbname)->where('id', $id)->update([$field => $value]);
        }
        if($res){
            return jssuccess('更新成功');

        }else{
            return jserror('更新失败');
        }
    }
    public function del_post(){
        $dbname = input('db');
        $id = input('id');
        if($dbname=='category' || $dbname=='product_cate'){
            $res = db($dbname)->where('cid', $id)->update(['status' => 9]);
            if($dbname=='category'){
                db('post')->where('cid', $id)->update(['status' => 9]);
            }
        }else{
            $res = db($dbname)->where('id', $id)->update(['status' => 9]);
        }
        if($res){
            return jssuccess('删除成功');
        }else{
            return jserror('删除失败');
        }
    }

    

     

    
}
