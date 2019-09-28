<?php
namespace app\admin\controller;
use think\facade\Request;
use think\Db;


class Template extends Admin
{
    public function __construct (){
        parent::__construct();
    }
    //模版列表
     public function tpl_list()
    {
        admin_role_check($this->z_role_list,$this->mca);
        $dir_list = [];
        //查询目录
        $handler = opendir('./template/index/');
        $a = 0;
        while( ($filename = readdir($handler)) !== false ) {
            $a++;
            //略过linux目录的名字为'.'和‘..'的文件
            if($filename != '.' && $filename != '..' && is_dir('./template/index/'.$filename)){  
                $dir_list[$a]['dir_name'] =  $filename;
                $dir_list[$a]['path'] = '/template/index/'.$filename;
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


    
}
