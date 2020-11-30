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
        $this->temp_plugin = '';
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
                      $data['soft_id'] = $json->soft_id;
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
                    $data['soft_id'] = $json->soft_id;
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
    public function plugin_act(){
      $type = input('type','');
      $this->type = $type;
      $action = input('action','');
      $id = input('id','');
      $res = Db::name('plugin')->where([['status','<>',9],['id','=',$id]])->find();
      if(!$res){
        $this->error('插件不存在');
      }
       
      //升级
      if($action=='upgrade'){
        if($type=='plugin'){
            //插件操作
            $this->temp_plugin = $res['plugin_name'];
            // $this->temp_dir_list = explode(',', $data['temp_dir_list']);
            $this->temp_dir_list = ['addons/'.$this->temp_plugin];
            $_bak_path = [];  
            foreach ($this->temp_dir_list as $k => $vo) {
                $_bak_path  = array_merge( $_bak_path ,listdir('./'.$vo));
            }
            $this->bak_path = array_merge($_bak_path);
            //检测版本
            $url = config()['version']['authorize_url'];
            $data = $res;
            $data['site_key']= config()['zf_auth']['key'];
            $data['site_sc']= config()['zf_auth']['sc'];
            $data['site_email']= config()['zf_auth']['email'];
            $data['domain']= $_SERVER['HTTP_HOST'];
            $ret = https_post($url,$data);
            $rr = json_decode($ret,true);
            if($rr){
              if( $rr['result']==1 ){
                //下载
                $utoken = $rr['msg']['utoken'];
                $xz =  $this->ZfUpgrade('ZFUpgradeDownSaveFileService',$utoken);
                if($xz!='success'){
                    return jserror($xz);
                }
                // 解压
                $jy = $this->ZfUpgrade('ZFUpgradeZip','jy');
                if($jy!='success'){
                    return jserror($jy);
                }
                $back = $this->ZfUpgrade('ZFUpgradeZip','back');
                if($back!='success'){
                    return jserror($back);
                }
                //替换
                $ret = $this->ZfUpgrade('ZFUpgradeListFile');
                $list = $ret['update_file_arr'];
                foreach ($list as $k => $vo) {
                    @copy($vo['path_old'],$vo['path_new']);
                }
                //改变版本号
                $up_db = Db::name('plugin')->where([['id','=',$id]])->update(['version'=>$rr['msg']['version'],'utime'=>time()]);
                if($up_db){
                  return jssuccess('升级成功');
                }else{
                  return jserror('升级失败');
                }
                return jssuccess($rr['msg']);
              }else{
                  return jserror($rr['msg']);
              }
            }else{
                return jserror($rr['msg']);
            }
        }elseif($type=='theme'){
          //模板操作
          $this->temp_plugin = $res['plugin_name'];
            // $this->temp_dir_list = explode(',', $data['temp_dir_list']);
            $this->temp_dir_list = ['application/index/controller/'.$this->temp_plugin,'application/index/view/'.$this->temp_plugin];
            $_bak_path = [];  
            foreach ($this->temp_dir_list as $k => $vo) {
              if(is_array(listdir('./'.$vo))){
                $_bak_path  = array_merge( $_bak_path ,listdir('./'.$vo));
              }
            }
            $this->bak_path = array_merge($_bak_path);
            //检测版本
            $url = config()['version']['authorize_url'];
            $data = $res;
            $data['site_key']= config()['zf_auth']['key'];
            $data['site_sc']= config()['zf_auth']['sc'];
            $data['site_email']= config()['zf_auth']['email'];
            $data['domain']= $_SERVER['HTTP_HOST'];
            $ret = https_post($url,$data);
            $rr = json_decode($ret,true);
            if($rr){
              if( $rr['result']==1 ){
                //下载
                $utoken = $rr['msg']['utoken'];
                $xz =  $this->ZfUpgrade('ZFUpgradeDownSaveFileService',$utoken);
                if($xz!='success'){
                    return jserror($xz);
                }
                // 解压
                $jy = $this->ZfUpgrade('ZFUpgradeZip','jy');
                if($jy!='success'){
                    return jserror($jy);
                }
                $back = $this->ZfUpgrade('ZFUpgradeZip','back');
                if($back!='success'){
                    return jserror($back);
                }
                //替换
                $ret = $this->ZfUpgrade('ZFUpgradeListFile');
                $list = $ret['update_file_arr'];
                foreach ($list as $k => $vo) {
                    @copy($vo['path_old'],$vo['path_new']);
                }
                //改变版本号
                $up_db = Db::name('plugin')->where([['id','=',$id]])->update(['version'=>$rr['msg']['version'],'utime'=>time()]);
                if($up_db){
                  return jssuccess('升级成功');
                }else{
                  return jserror('升级失败');
                }
                return jssuccess($rr['msg']);
              }else{
                  return jserror($rr['msg']);
              }
            }else{
                return jserror($rr['msg']);
            }

        }
      }
    }
    public function ZfUpgrade($func,$param=''){
        switch ($func) {
            case 'ZFUpgradeDownSaveFileService':
                $up_url = $param;
                return $this->ZFUpgradeDownSaveFileService($up_url, './data/plugins/'.$this->temp_plugin, $filename = 'upgrade_up.zip', $type = 0);        
                break;
            case 'ZFUpgradeZip':
                return $this->$func($param);
                break;
            default:
                return $this->$func();
                break;
        }
        
    }
    // 保存文件到服务器
    //链接   保存的路径 名称 类型
    public function ZFUpgradeDownSaveFileService($url, $save_dir = '', $filename = '', $type = 0) {
        if (trim($url) == '') {
            return false;
        }
        if (trim($save_dir) == '') {
            $save_dir = './';
        }
        if (0 !== strrpos($save_dir, '/')) {
            $save_dir.= '/';
        }
        //删除目录内容
        $ff = $save_dir.$filename;
        if(file_exists($ff)){
            unlink($ff);
        }
        #######
        //创建保存目录
        if (!file_exists($save_dir) && !mkdir($save_dir, 0777, true)) {
            return false;
        }
        //获取远程文件所采用的方法
        if ($type) {
            $ch = curl_init();
            $timeout = 5;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $content = curl_exec($ch);
            curl_close($ch);
        } else {
            ob_start();
            readfile($url);
            $content = ob_get_contents();
            ob_end_clean();
        }
        $size = strlen($content);
        //文件大小
        $fp2 = @fopen($save_dir . $filename, 'a');
        fwrite($fp2, $content);
        fclose($fp2);
        unset($content, $url);
        if(is_file($save_dir . $filename)){
            return 'success';
        }else{
            return "下载失败";
        }
    }
    //解压
    public function ZFUpgradeZip($type){
        if($type=='jy'){
            //删除目录
            if(is_dir('./data/plugins/'.$this->temp_plugin.'/new')){
                $r = deldir('./data/plugins/'.$this->temp_plugin.'/new');
                if(!$r){
                 die('删除目录失败,请检查权限$this->pulg_data_path.(/plugins/new)');   
                }
            }
            mkdir('./data/plugins/'.$this->temp_plugin.'/new');
            $zip = new \ZipArchive();//新建一个对象
            if ($zip->open('./data/plugins/'.$this->temp_plugin.'/upgrade_up.zip')=== TRUE){
              if($this->type=='plugin'){
                  $r = $zip->extractTo('./data/plugins/'.$this->temp_plugin.'/new/addons/'.$this->temp_plugin);
              }elseif($this->type=='theme'){
                  $r = $zip->extractTo('./data/plugins/'.$this->temp_plugin.'/new/application/index');
              }
                $zip->close();//关闭处理的zip文件
            }
            if($r){
                return 'success';
            }else{
                return '解压失败';
            }

        }elseif($type=='back'){
            //路径是否存在
            if (!file_exists('./data/plugins/'.$this->temp_plugin.'/old_bak') && !mkdir('./data/plugins/'.$this->temp_plugin.'/old_bak', 0777, true)) {
                return false;
            }
            //压缩
            $file = './data/plugins/'.$this->temp_plugin.'/old_bak/'.date("YmdHis",time()).'_bak.zip';
            // 创建备份
            $zip = new \ZipArchive();                 
            if ($zip->open($file, \ZipArchive::CREATE)!==TRUE) {     
                exit("无法创建 <$filename>\n");     
            }     
            $files = $this->bak_path;
            foreach($files as $path){     
                $zip->addFile($path,str_replace("./","",str_replace("\\","/",$path)));    
            }   
            $zip->close(); 
            if(file_exists($file)){
                return 'success';
            }else{
                return '备份失败';
            }
        }
    }
    //更新文件
    public function ZFUpgradeListFile(){
        $_list = [];
        $update_file_arr = [];

        $_temp_dir_list = $this->temp_dir_list;
        foreach ($_temp_dir_list as $key => $value) {
            // 原有的
            $list['old'][$key] = myScanDir("./".$value,'./'.$value,'./');
            foreach(arrToOne($list['old'][$key]) as $k=>$vo){
                if(strpos($vo,'{"name":"') !== false){ 
                    $_temp = json_decode($vo);
                    $_list['old'][$_temp->key]['name'] = $_temp->name;
                    $_list['old'][$_temp->key]['path'] = $_temp->path;
                    $_list['old'][$_temp->key]['name'] = $_temp->path_temp;
                    $_list['old'][$_temp->key]['md5'] = $_temp->md5;
                }
            }

            // 现在的最新的
            if(is_dir('./data/plugins/'.$this->temp_plugin.'/new/'.$value)){
                $list['new'][$key] = myScanDir('./data/plugins/'.$this->temp_plugin."/new/".$value,'./data/plugins/'.$this->temp_plugin.'/new/'.$value,'./data/plugins/'.$this->temp_plugin.'/new/','');
                foreach(arrToOne($list['new'][$key]) as $k=>$vo){
                  // dd($list['new'][$key]);
                    if(strpos($vo,'{"name":"') !== false){ 
                        $_temp = json_decode($vo);
                        $_list['new'][$_temp->key]['name'] = $_temp;
                        $_list['new'][$_temp->key]['path'] = $_temp->path;
                        $_list['new'][$_temp->key]['name'] = $_temp->path_temp;
                        $_list['new'][$_temp->key]['md5'] = $_temp->md5;
                    }
                }
            }else{
                $_list['new'][$value] = [];
            }
          
        }
        // dd($_list);
        // 重组数据
        foreach ($_list['new'] as $k => $vo) {
            if(count($vo)!=0){
                $ret[1][$k]['name'] = $vo['name'];
                $ret[1][$k]['path_old'] = $vo['path'];
                $ret[1][$k]['md5'] = $vo['md5'];
                if(isset($_list['old'][$k]['path'])){
                    $ret[1][$k]['path_new'] = $_list['old'][$k]['path'];
                    if($vo['md5']==$_list['old'][$k]['md5']){
                        $ret[1][$k]['is_xg'] = '未修改';
                    }else{
                        $ret[1][$k]['is_xg'] = "<span class='layui-bg-green'>已修改</span>";
                        $update_file_arr[] = ['name'=>$vo['name'],'path_old'=>$vo['path'],'md5'=>$vo['md5'],'path_new'=>$_list['old'][$k]['path'],'is_xg'=>'已修改'];
                    }
                }else{
                    $path_new = str_replace('./data/plugins/'.$this->temp_plugin.'/new/', './', $vo['path']);
                    $ret[1][$k]['path_new'] = $path_new;
                    $ret[1][$k]['is_xg'] = "<span class='layui-bg-red'>新增文件</span>";
                    $update_file_arr[] = ['name'=>$vo['name'],'path_old'=>$vo['path'],'md5'=>$vo['md5'],'path_new'=>$path_new,'is_xg'=>'新增文件'];
                }
            }
        }

        foreach ($_list['old'] as $k => $vo) {
            if(!isset($_list['new'][$k])){
                $ret[2][$k]['name'] = $vo['name'];
                $ret[2][$k]['path_old'] = '';
                $ret[2][$k]['path_new'] = $vo['path'];
                $ret[2][$k]['md5'] = $vo['md5'];
                $ret[2][$k]['is_xg'] = '<span class="layui-bg-blue">差异文件(新系统中不含此文件,请酌情删除)</span>';
            }
        }
        if(!isset($ret['1'])){
            $ret['1'] = [];
        }
        if(!isset($ret['2'])){
            $ret['2'] = [];
        }
        if(isset($update_file_arr)){
            $ret['update_file_arr'] = $update_file_arr;
        }else{
            $ret['update_file_arr'] = [];
        }
        return $ret;
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
function myScanDir($dir,$p_path='',$cj_ico)
{
    $file_arr = scandir($dir);
    $new_arr = [];
    $all_file = [];
    foreach($file_arr as $k => $item){
        $_path = $p_path;
        if($item!=".." && $item !="."){
            if(is_dir($dir."/".$item)){
                $_path = $dir."/".$item;
                $new_arr[$item] = myScanDir($dir."/".$item,$_path,$cj_ico);
            }else{
                $md5 = md5_file($_path.'/'.$item);
                $path_temp = isset(explode($cj_ico, $_path)[1])?explode($cj_ico, $_path)[1].'/':$cj_ico;
                $kk = $path_temp.pathinfo($item)['filename'];
                $new_arr[$kk] = array('name'=>$item,'path'=>$_path.'/'.$item ,'path_temp'=>$path_temp.$item  ,'md5'=>$md5);
                $new_arr[$kk]['key'] = $kk;
                $new_arr[$kk]['json'] = json_encode($new_arr[$kk]);
            } 
        }
    }
    return $new_arr;
}

function arrToOne($multi) {

  $arr = array();

  foreach ($multi as $key => $val) {

    if( is_array($val) ) {

      $arr = array_merge($arr, arrToOne($val));

    } else {

      $arr[] = $val;

    }

  }

  return $arr;

}
