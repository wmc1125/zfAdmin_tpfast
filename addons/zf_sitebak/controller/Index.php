<?php
namespace addons\zf_sitebak\controller;
use addons\zf_sitebak\controller\Plugin;
use think\Controller;
use ZipArchive;
class Index extends Controller
{
    
    public function index(){
        if(request()->isPost()){
            set_time_limit(0);   
            header("Content-type:text/html;charset=utf-8"); 
            $button=isset($_POST['button'])?$_POST['button']:'';     
            if($button=="开始打包")     
            {     
                $zip = new ZipArchive();     
                $filename = "./".date("Y-m-d")."_".md5(time())."_zf.zip";     
                if ($zip->open($filename, ZIPARCHIVE::CREATE)!==TRUE) {     
                    exit("无法创建 <$filename>\n");     
                    }     
                $files = listdir();     
                foreach($files as $path)     
                {     
                    $zip->addFile($path,str_replace("./","",str_replace("\\","/",$path)));    
                }    
                echo "打包完成，共打包了: " . $zip->numFiles . "个文件\n";    
                $zip->close();    
            }    
             
        }
        return view();
    }
    public function link()
    {
        echo 'hello link';
        return view();
    }
    public function setting(){
        echo "无需配置,默认保存在 public/backup/site/年月日/";
        // dd($this->plugin_info);
    }
    public function help(){
        echo "帮助文档";
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