<?php
namespace app\admin\controller;
use think\facade\Session;
use think\facade\Request;
use think\Db;
use think\facade\Image;
use OSS\OssClient as AliOssClient;


class Common extends Admin
{
    public function __construct(){
        parent::__construct();
    }
    //显示是与否的转换
    //dbname status id 
    public function is_switch(){
        admin_role_check($this->z_role_list,$this->mca);
        $dbname = input('dbname');
        $is_show = input('status');
        $id = input('id');
        //执行转换 
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
    public function is_menu(){
        admin_role_check($this->z_role_list,$this->mca);
        $dbname = input('dbname');
        $is_show = input('menu');
        $id = input('id');
        //执行转换
        if($dbname=='category' || $dbname=='product_cate'){
            $res = db($dbname)->where('cid', $id)->update(['menu' => $is_show]);
        }else{
            $res = db($dbname)->where('id', $id)->update(['menu' => $is_show]);            
        }     
        if($res){
            return jssuccess('更新成功');
        }else{
            return jserror('更新失败');
        }
    }
    public function del_post(){
        admin_role_check($this->z_role_list,$this->mca);
        $dbname = input('db');
        $id = input('id');
        //执行转换
        if($dbname=='category' || $dbname=='product_cate'){
            $res = db($dbname)->where('cid', $id)->update(['status' => 9]);
        }else{
            $res = db($dbname)->where('id', $id)->update(['status' => 9]);            
        }
        if($res){
            return jssuccess('删除成功');
        }else{
            return jserror('删除失败');
        }
    }
    public function more_del(){
        admin_role_check($this->z_role_list,$this->mca);
        $dbname = input('dbname');
        $ids = input('ids');
        // dd($ids);
        $ids_list = explode(',',$ids);
        foreach($ids_list as $k=>$vo){
            if($dbname=='category' || $dbname=='product_cate'){
                db($dbname)->where('cid', $vo)->update(['status' => 9]);                
            }else{
                db($dbname)->where('id', $vo)->update(['status' => 9]);            
            }

        }
        return jssuccess('更新成功');
    }
    public function value_edit(){
        admin_role_check($this->z_role_list,$this->mca);
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

    public function upload_one(){
        admin_role_check($this->z_role_list,$this->mca);
        $file = request()->file('file');
        $file_glo = $_FILES['file'];

        $image = \think\Image::open($file);
        $img_config = config()['img'];
        $img_config['save_path'] = ($img_config['save_path']==''?'/upload/file':$img_config['save_path']);
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
                $img_config['water_font_path'] = ($img_config['water_font_path']==''?'./upload/1.ttf':$img_config['water_font_path']);
                $img_config['water_text_size'] = ($img_config['water_text_size']==''?'20':$img_config['water_text_size']);
                $img_config['water_text_color'] = ($img_config['water_text_color']==''?'#000':$img_config['water_text_color']);
                $image->text($img_config['water_text'],$img_config['water_font_path'],$img_config['water_text_size'],$img_config['water_text_color'])->save('.'.$water_name);
                $msg = 'http://'.$_SERVER['SERVER_NAME'].$water_name;
            }else{
                //不加
                $info = $file->validate(['size'=>15678,'ext'=>'pjpeg,jpeg,jpg,gif,bmp,png'])->move( './upload/file');
                $getSaveName = str_replace('\\', '/', $info->getSaveName());//win下反斜杠替换成斜杠
                $msg = 'http://'.$_SERVER['SERVER_NAME'].'/upload/file/'.$getSaveName;
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
    public function upload_one_file(){
        admin_role_check($this->z_role_list,$this->mca);
        $file = $_FILES['file'];
        $img_config = config()['img'];
        if($img_config['file_save_type']==0){
            $file2 = request()->file('file');
            $info = $file2->validate(['size'=>15678,'ext'=>'txt,pdf,doc,xls,ppt'])->move('./upload/file');
            $getSaveName = str_replace('\\', '/', $info->getSaveName());//win下反斜杠替换成斜杠
            $msg = 'http://'.$_SERVER['SERVER_NAME'].'/upload/file/'.$getSaveName;
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
            $result = $ossClient->uploadFile($ossconfig['Bucket'],'demo_zf_test/upload/simple/'. $file_name, $tmp_name);
            return $result['info']['url'];
        } catch (OssException $e) {
            return $e->getMessage();
        }
    }


    public function config_edit(){
        admin_role_check($this->z_role_list,$this->mca);
        $key = input('key');
        $value = input('value');
        //执行转换
        $res = db('config')->where(['key'=>$key])->update(['value' => $value]);            
        if($res){
            return jssuccess('更新成功');
        }else{
            return jserror('更新失败');
        }
    }

     

    
}
