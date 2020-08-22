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
    /**
     * @Notes:显示是与否的转换 (dbname status id )
     * @Interface is_switch
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * @author: 子枫
     * @Time: 2019/11/13   10:39 下午
     */
    public function is_switch(){
        admin_role_check($this->z_role_list,$this->mca);
        $dbname = input('dbname');
        $is_show = input('status');
        $id = input('id');
        if($dbname=='category' || $dbname=='product_cate'){
            $res = db($dbname)->where('cid', $id)->update(['status' => $is_show]);
        }else{
            $res = db($dbname)->where('id', $id)->update(['status' => $is_show]);            
        }
        return ZFRetMsg($res,'更新成功','更新失败');
        
    }

    /**
     * @Notes:菜单的转换
     * @Interface is_menu
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * @author: 子枫
     * @Time: 2019/11/13   10:41 下午
     */
    public function is_menu(){
        admin_role_check($this->z_role_list,$this->mca);
        $dbname = input('dbname');
        $is_show = input('menu');
        $id = input('id');
        if($dbname=='category' || $dbname=='product_cate'){
            $res = db($dbname)->where('cid', $id)->update(['menu' => $is_show]);
        }else{
            $res = db($dbname)->where('id', $id)->update(['menu' => $is_show]);            
        }     
        return ZFRetMsg($res,'更新成功','更新失败');
        
    }
    /**
     * @Notes:删除内容
     * @Interface del_post
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * @author: 子枫
     * @Time: 2019/11/13   10:41 下午
     */
    public function del_post(){
        admin_role_check($this->z_role_list,$this->mca);
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
        return ZFRetMsg($res,'删除成功','删除失败');

    }

    /**
     * @Notes:批量删除
     * @Interface more_del
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * @author: 子枫
     * @Time: 2019/11/13   10:43 下午
     */
    public function more_del(){
        admin_role_check($this->z_role_list,$this->mca);
        $dbname = input('dbname');
        $ids = input('ids');
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

    /**
     * @Notes:修改值
     * @Interface value_edit
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * @author: 子枫
     * @Time: 2019/11/13   10:42 下午
     */
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
        return ZFRetMsg($res,'更新成功','更新失败');
        
    }

    /**
     * @Notes:上传图片
     * @Interface upload_one
     * @author: 子枫
     * @Time: 2019/11/13   10:43 下午
     */
    public function upload_one(){
        admin_role_check($this->z_role_list,$this->mca);
        $file = request()->file('file');
        $info = $file->validate(['ext'=>config()['web']['pic_ext']])->move( './public/upload/admin/image');
        $getSaveName = str_replace('\\', '/', $info->getSaveName());//win下反斜杠替换成斜杠
        $msg = 'http://'.$_SERVER['SERVER_NAME'].'/public/upload/admin/image/'.$getSaveName;
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
        admin_role_check($this->z_role_list,$this->mca);
        $file2 = request()->file('file');
        $info = $file2->validate(['ext'=>config()['web']['file_ext']])->move('./public/upload/admin/file');
        $getSaveName = str_replace('\\', '/', $info->getSaveName());//win下反斜杠替换成斜杠
        $msg = 'http://'.$_SERVER['SERVER_NAME'].'/public/upload/admin/file/'.$getSaveName;
        return ZFRetMsg($msg,$msg,'error');

    }

    

    /**
     * @Notes:config配置修改
     * @Interface config_edit
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * @author: 子枫
     * @Time: 2019/11/13   10:44 下午
     */
    public function config_edit(){
        admin_role_check($this->z_role_list,$this->mca);
        $key = input('key');
        $value = input('value');
        //执行转换
        $res = db('config')->where(['key'=>$key])->update(['value' => $value]);            
        return ZFRetMsg($res,'更新成功','更新失败');
        
    }

     

    
}
