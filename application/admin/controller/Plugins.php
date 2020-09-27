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

class Plugins extends Admin
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
     public function themes()
    {
        admin_role_check($this->z_role_list,$this->mca);
        $list = Db::name('plugin')->where([['status','<>',9],['type','=','theme']])->select();
        foreach ($list as $k => $vo) {
          $_file = './application/index/view/'.$vo['plugin_name'];
          if(file_exists($_file.'/config.php')){
              $list[$k]['ok'] = 1;
              $list[$k]['path'] = $_file;
          }else{
              $list[$k]['ok'] = 0;
              $list[$k]['path'] = $_file;
          }
        }
        $this->assign('list',$list);
        //查询当前的模板
        $this->assign('tpl_name',Db::name('config')->where(['key'=>'zf_tpl_suffix'])->value('value'));
        return view();
    }
    public function themes_upload(){
        if(request()->isPost()){
            $file = $_FILES['file'];
            $file2 = request()->file('file');
            $save_path = './data/themes/zip';
            $info = $file2->validate(['ext'=>'zip'])->move($save_path);
            $getSaveName = str_replace('\\', '/', $info->getSaveName());//win下反斜杠替换成斜杠
            //清空缓存目录
            if(is_dir('./data/themes/temp')){
                $r = deldir('./data/themes/temp');
                if(!$r){
                 die('删除目录失败,请检查权限(./data/themes/temp)');   
                }
            }
            mkdir('./data/themes/temp');
            if($getSaveName){
                $y_path = $save_path.'/'.$getSaveName;
                //解压
                $zip = new \ZipArchive();//新建一个对象
                if ($zip->open($y_path)=== TRUE){
                    $r = $zip->extractTo('./data/themes/temp');// 假设解压缩到在当前路径下images文件夹的子文件夹php
                    $zip->close();//关闭处理的zip文件
                }
                if(!$r){
                    return jserror('解压失败');
                }
                $dir = './data/themes/temp';
                $_file = $dir.'/view/config.php';
                if(file_exists($_file)){
                  include $_file;
                  // 当前模板控制器路径  ./application/index/controller/$_config['theme_name']
                  // 当前模板模板路径  ./application/index/view/$_config['theme_name']
                  if(file_exists('./application/index/controller/'.$config['theme_name']) || file_exists('./application/index/view/'.$config['theme_name']) ){
                        return jserror('模板已存在,请手动上传安装 控制器路径 ./application/index/controller/'.$config['theme_name'] .' 模板路径 ./application/index/view/'.$config['theme_name']);
                  }
                  mkdir('./application/index/controller/'.$config['theme_name']);
                  mkdir('./application/index/view/'.$config['theme_name']);

                  copydir('./data/themes/temp/controller','./application/index/controller/'.$config['theme_name']); //拷贝到新目录
                  copydir('./data/themes/temp/view','./application/index/view/'.$config['theme_name']); //拷贝到新目录
                  if(file_exists('./application/index/controller/'.$config['theme_name']) && file_exists('./application/index/view/'.$config['theme_name']) ){

                      //存入数据库
                      $data['plugin_name'] = $config['theme_name'];
                      $data['name'] = $config['name'];
                      $data['version'] =  $config['version'];
                      $data['pic'] = $config['pic'];
                      $data['ctime'] = $config['ctime'];
                      $data['author'] =$config['author'];
                      $data['status'] = 1;
                      $data['type'] = 'theme';
                      //是否存在
                      $is_r = Db::name('plugin')->where(['plugin_name'=>$data['plugin_name'],'author'=>$data['author'],'type'=>'theme'])->find();
                      if(!$is_r){
                          $r = Db::name('plugin')->insert($data);
                          if($r){
                            return jssuccess('安装成功');      
                          }else{
                            return jserror('保存失败');
                          }
                      }else{
                        return jserror('已存在该模板,请手动替换');
                      }              
                  }else{
                      return jserror('移动失败');

                  }
                }else{
                    return "json文件不存在";
                }
            }else{
                return jserror("上传失败");
            }
            die;
        }
    }
    public function plugins(){
        admin_role_check($this->z_role_list,$this->mca);
        $list = Db::name('plugin')->where([['status','<>',9],['type','=','plugin']])->select();
        $this->assign('list',$list);
        return view();
    }
    public function plugin_upload(){
        if(request()->isPost()){
            $file = $_FILES['file'];
            $file2 = request()->file('file');
            $save_path = './data/plugins/zip';
            $info = $file2->validate(['ext'=>'zip'])->move($save_path);
            $getSaveName = str_replace('\\', '/', $info->getSaveName());//win下反斜杠替换成斜杠
            //清空缓存目录
            if(is_dir('./data/plugins/temp')){
                $r = deldir('./data/plugins/temp');
                if(!$r){
                 die('删除目录失败,请检查权限(./data/plugins/temp)');   
                }
            }
            mkdir('./data/plugins/temp');
            if($getSaveName){
                $y_path = $save_path.'/'.$getSaveName;
                //解压
                $zip = new \ZipArchive();//新建一个对象
                if ($zip->open($y_path)=== TRUE){
                    $r = $zip->extractTo('./data/plugins/temp');// 假设解压缩到在当前路径下images文件夹的子文件夹php
                    $zip->close();//关闭处理的zip文件
                }
                if(!$r){
                    return jserror('解压失败');
                }
                $dir = './data/plugins/temp';
                $_file = $dir.'/config.json';
                if(file_exists($_file)){
                    $str = file_get_contents($_file);
                    $json = json_decode($str);
                    //存入数据库
                    $data['plugin_name'] = $json->plugin_name;
                    $data['name'] = $json->name;
                    $data['version'] = $json->version;
                    $data['pic'] = $json->pic;
                    $data['ctime'] = $json->ctime;
                    $data['author'] = $json->author;
                    $data['status'] = 2;
                    $data['type'] = 'plugin';
                    //是否存在
                    $is_r = Db::name('plugin')->where(['plugin_name'=>$data['plugin_name'],'author'=>$data['author'],'type'=>'plugin'])->find();
                    if(!$is_r){
                        $r = Db::name('plugin')->insert($data);
                    }else{
                        if( $data['version'] == $is_r['version'] && $data['pic'] == $is_r['pic'] && $data['ctime'] == $is_r['ctime'] && $data['author'] == $is_r['author']){
                            $r = true;
                        }else{
                            $r = Db::name('plugin')->where(['plugin_name'=>$data['plugin_name'],'author'=>$data['author']])->update($data);
                        }
                    }
                    if(!$r){
                        return jserror('db_error');
                    }

                    if(is_dir('./addons/'.$json->plugin_name)){
                        //先备份后删除
                        //压缩
                        if(!is_dir('./data/plugins/bak')){
                            mkdir('./data/plugins/bak');
                        }

                        $file = './data/plugins/bak/'.$json->plugin_name.'_'.date("YmdHis").'_bak.zip';
                        // 创建备份
                        $zip = new \ZipArchive();     
                        if ($zip->open($file, \ZipArchive::CREATE)!==TRUE) {     
                            return jserror("无法创建 <$filename>\n");     
                        }     
                        $files = listdir('./addons/'.$json->plugin_name);  
                        foreach($files as $path){     
                            $zip->addFile($path,str_replace("./","",str_replace("\\","/",$path)));    
                        }    
                        $zip->close(); 
                        if(!file_exists($file)){
                            return jserror('ys_error');
                        }

                        $r = deldir('./addons/'.$json->plugin_name);
                        if(!$r){
                            return jserror('删除目录失败,请检查权限(./addons/'.$json->plugin_name.')');   
                        }
                    }
                    mkdir('./addons/'.$json->plugin_name);

                    $file=$dir; //旧目录
                    $newFile='./addons/'.$json->plugin_name; //新目录
                    copydir($file,$newFile); //拷贝到新目录
                    if(!is_dir('./addons/'.$json->plugin_name)){
                        return jserror('move_error');
                    }else{
                        return jssuccess('安装成功');
                    }
                }else{
                    return "json文件不存在";
                }
            }else{
                return jserror("上传失败");
            }
            die;
        }
    }

    public function plugin_uninstall(){
      $id = request()->get('id','3');
      $plugin_info = Db::name('plugin')->where([['id','=',$id]])->find();
      $controller_plugin =  '\addons\\'.$plugin_info['plugin_name'].'\\controller\\Plugin';
      $plug = new $controller_plugin();
      //激活方法
      $r = $plug->uninstall();
      if($r['code']==1){
          Db::name('plugin')->where([['id','=',$id]])->delete();
          return jssuccess('卸载成功');
      }else{
          return jserror($r['msg']);
      }


    }
   


    
}
function deldir($dir) {
   //先删除目录下的文件：
   $dh=opendir($dir);
   while ($file=readdir($dh)) {
      if($file!="." && $file!="..") {
         $fullpath=$dir."/".$file;
         if(!is_dir($fullpath)) {
            unlink($fullpath);
         } else {
            deldir($fullpath);
         }
      }
   }
 
   closedir($dh);
   //删除当前文件夹：
   if(rmdir($dir)) {
      return true;
   } else {
      return false;
   }
}

function listdir($start_dir='.') {    
  $files = array();    
  if (is_dir($start_dir)) {    
   $fh = opendir($start_dir);    
   while (($file = readdir($fh)) !== false) {    
     if (strcmp($file, '.')==0 || strcmp($file, '..')==0) continue;    
     $filepath = $start_dir . '/' . $file;    
     if ( is_dir($filepath) )    
       $files = array_merge($files, listdir($filepath));    
     else   
       array_push($files, $filepath);    
   }    
   closedir($fh);    
  } else {    
   $files = false;    
  }    
 return $files;    
}


/**
 * 复制文件夹
 * @param $source
 * @param $dest
 */
function copydir($source, $dest)
{
    if (!file_exists($dest)) mkdir($dest);
    $handle = opendir($source);
    while (($item = readdir($handle)) !== false) {
        if ($item == '.' || $item == '..') continue;
        $_source = $source . '/' . $item;
        $_dest = $dest . '/' . $item;
        if (is_file($_source)) copy($_source, $_dest);
        if (is_dir($_source)) copydir($_source, $_dest);
    }
    closedir($handle);
}
