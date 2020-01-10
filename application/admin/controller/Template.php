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
use think\facade\Request;
use think\Db;

class Template extends Admin
{
    public function __construct (){
        parent::__construct();
    }

    /**
     * @Notes:模版列表
     * @Interface tpl_list
     * @return \think\response\View
     * @author: 子枫
     * @Time: 2019/11/13   11:01 下午
     */
     public function tpl_list()
    {
        admin_role_check($this->z_role_list,$this->mca);
        $dir_list = [];
        //查询目录
        $handler = opendir('./application/index/view/');
        $a = 0;
        while( ($filename = readdir($handler)) !== false ) {
            $a++;
            //略过linux目录的名字为'.'和‘..'的文件
            if($filename != '.' && $filename != '..' && is_dir('./application/index/view/'.$filename)){
                $dir_list[$a]['dir_name'] =  $filename;
                $dir_list[$a]['path'] = '/application/index/view/'.$filename;
                //打开文件查询json
                $_file = '.'.$dir_list[$a]['path'].'/config.json';
                if(file_exists($_file)){
                    $fp = fopen($_file,"r");
                    $str = fread($fp,filesize($_file));//指定读取大小，这里把整个文件内容读取出来
                    $str = str_replace("\r\n","<br />",$str);
                    $json = json_decode($str);
                    $dir_list[$a]['name'] = $json->name;
                    $dir_list[$a]['version'] = $json->version;
                    $dir_list[$a]['pic'] = $json->pic;
                    $dir_list[$a]['ctime'] = $json->ctime;
                    $dir_list[$a]['summary'] = $json->summary;
                    $dir_list[$a]['author'] = $json->author;
                    fclose($fp);
                    $dir_list[$a]['ok'] = 1;
                }else{
                    $dir_list[$a]['ok'] = 0;
                }
            }
        }
        closedir($handler);
        $this->assign('list',$dir_list);
        //查询当前的模板
        $this->assign('tpl_name',Db::name('config')->where(['key'=>'zf_tpl_suffix'])->value('value'));
        return view();
    }
    public function plugs(){
        admin_role_check($this->z_role_list,$this->mca);

//        $t = input('t','');
//        if($t=='gf'){
//            #####官方的插件
//            $list = [];
//            $this->assign('list',$list);
//        }else{
            #####用户插件
            $dir_list = [];
            //查询目录
            $handler = opendir('./addons/');
            $a = 0;
            while( ($filename = readdir($handler)) !== false ) {
                $a++;
                //略过linux目录的名字为'.'和‘..'的文件
                if($filename != '.' && $filename != '..' && is_dir('./addons/'.$filename)){
                    $dir_list[$a]['dir_name'] =  $filename;
                    $dir_list[$a]['path'] = '/addons/'.$filename;
                    //打开文件查询json
                    $_file = '.'.$dir_list[$a]['path'].'/config.json';
                    if(file_exists($_file)){
                        $fp = fopen($_file,"r");
                        $str = fread($fp,filesize($_file));//指定读取大小，这里把整个文件内容读取出来
                        $str = str_replace("\r\n","<br />",$str);
                        $json = json_decode($str);
                        $dir_list[$a]['name'] = $json->name;
                        $dir_list[$a]['version'] = $json->version;
                        $dir_list[$a]['pic'] = $json->pic;
                        $dir_list[$a]['ctime'] = $json->ctime;
                        $dir_list[$a]['summary'] = $json->summary;
                        $dir_list[$a]['author'] = $json->author;
                        fclose($fp);
                        $dir_list[$a]['ok'] = 1;
                    }else{
                        $dir_list[$a]['ok'] = 0;
                    }
                }
            }
            closedir($handler);
            $this->assign('list',$dir_list);
//        }
//        dd($dir_list);
         return view();
    }

    public function plug_x_index(){
        $id = '1';
       echo hook('testhook', ['id'=>1]);

    }


    
}
