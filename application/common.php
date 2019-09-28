<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
use think\Db;
use Qiniu\Auth as QAuth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;
include_once './application/zf.php';
include_once './application/common_db.php';
// 应用公共文件
/**
* 公共方法
*/
/**
 * 获取插件类的类名
 * @param strng $name 插件名
 * @param string $ext 扩展名
 */
function get_addon_class($name, $ext = 'EXT')
{
    // 初始化命名空间及类名
    $class = "addons\\{$name}\\" . ucfirst($name);
    return $class;
}

/**
 * 处理插件钩子
 * @param string $hook   钩子名称
 * @param mixed $params 传入参数
 * @return void
 */
function hook($hook, $params = [])
{
    // 钩子调用
    \think\facade\Hook::listen($hook, $params);
}


/**
 * 循环删除目录和文件
 * @param string $dir_name
 * @return bool
 */
function delete_dir_file($dir_name) {
    $result = false;
    if(is_dir($dir_name)){
        if ($handle = opendir($dir_name)) {
            while (false !== ($item = readdir($handle))) {
                if ($item != '.' && $item != '..') {
                    if (is_dir($dir_name . DS . $item)) {
                        delete_dir_file($dir_name . DS . $item);
                    } else {
                        unlink($dir_name . DS . $item);
                    }
                }
            }
            closedir($handle);
            if (rmdir($dir_name)) {
                $result = true;
            }
        }
    }

    return $result;
}
/**
 * 返回文件格式
 * @param  string $str 文件名
 * @return string      文件格式
 */
function file_format($str){
    // 取文件后缀名
    $str=strtolower(pathinfo($str, PATHINFO_EXTENSION));
    // 图片格式
    $image=array('webp','jpg','png','ico','bmp','gif','tif','pcx','tga','bmp','pxc','tiff','jpeg','exif','fpx','svg','psd','cdr','pcd','dxf','ufo','eps','ai','hdri');
    // 视频格式
    $video=array('mp4','avi','3gp','rmvb','gif','wmv','mkv','mpg','vob','mov','flv','swf','mp3','ape','wma','aac','mmf','amr','m4a','m4r','ogg','wav','wavpack');
    // 压缩格式
    $zip=array('rar','zip','tar','cab','uue','jar','iso','z','7-zip','ace','lzh','arj','gzip','bz2','tz');
    // 文档格式
    $text=array('exe','doc','ppt','xls','wps','txt','lrc','wfs','torrent','html','htm','java','js','css','less','php','pdf','pps','host','box','docx','word','perfect','dot','dsf','efe','ini','json','lnk','log','msi','ost','pcs','tmp','xlsb');
    // 匹配不同的结果
    switch ($str) {
        case in_array($str, $image):
            return 'image';
            break;
        case in_array($str, $video):
            return 'video';
            break;
        case in_array($str, $zip):
            return 'zip';
            break;
        case in_array($str, $text):
            return 'text';
            break;
        default:
            return 'other';
            break;
    }
}


/**
* 解析sql语句
* @param  string $content sql内容
* @param  int $limit  如果为1，则只返回一条sql语句，默认返回所有
* @param  array $prefix 替换表前缀
* @return array|string 除去注释之后的sql语句数组或一条语句
*/
function parse_sql($sql = '', $limit = 0, $prefix = []) {
  // 被替换的前缀
  $from = '';
  // 要替换的前缀
  $to = '';
  // 替换表前缀
  if (!empty($prefix)) {
      $to   = current($prefix);
      $from = current(array_flip($prefix));
  }
  if ($sql != '') {
      // 纯sql内容
      $pure_sql = [];
      // 多行注释标记
      $comment = false;
      // 按行分割，兼容多个平台
      $sql = str_replace(["\r\n", "\r"], "\n", $sql);
      $sql = explode("\n", trim($sql));
      // 循环处理每一行
      foreach ($sql as $key => $line) {
          // 跳过空行
          if ($line == '') {
              continue;
          }
          // 跳过以#或者--开头的单行注释
          if (preg_match("/^(#|--)/", $line)) {
              continue;
          }
          // 跳过以/**/包裹起来的单行注释
          if (preg_match("/^\/\*(.*?)\*\//", $line)) {
              continue;
          }
          // 多行注释开始
          if (substr($line, 0, 2) == '/*') {
              $comment = true;
              continue;
          }
          // 多行注释结束
          if (substr($line, -2) == '*/') {
              $comment = false;
              continue;
          }
          // 多行注释没有结束，继续跳过
          if ($comment) {
              continue;
          }
          // 替换表前缀
          if ($from != '') {
              $line = str_replace('`'.$from, '`'.$to, $line);
          }
          if ($line == 'BEGIN;' || $line =='COMMIT;') {
              continue;
          }
          // sql语句
          array_push($pure_sql, $line);
      }
      // 只返回一条语句
      if ($limit == 1) {
          return implode($pure_sql, "");
      }
      // 以数组形式返回sql语句
      $pure_sql = implode($pure_sql, "\n");
      $pure_sql = explode(";\n", $pure_sql);
      return $pure_sql;
  } else {
      return $limit == 1 ? '' : [];
  }
}





//计算整个目录文件大小/文件数量
function getDirInfo($dir, $f = 'size') {
  $result['size'] = '';
  $result['count'] = '';

  $handle = opendir($dir); //打开文件流
  while (($FolderOrFile = readdir($handle)) !== false) {//循环判断文件是否可读
      if ($FolderOrFile != "." && $FolderOrFile != "..") {
          if (is_dir("$dir/$FolderOrFile")) {//判断是否是目录
              $result['size'] += getDirSize("$dir/$FolderOrFile"); //递归调用
          } else {
              $result['size'] += filesize("$dir/$FolderOrFile");
              $result['count']++;
          }
      }
  }
  closedir($handle); //关闭文件流
  $result = ($f == 'size') ? $result['size'] : $result['count']; //返回大小或数量
  return $result;
}
// 单位自动转换函数
function getRealSize($size) {
    $kb = 1024;         // Kilobyte
    $mb = 1024 * $kb;   // Megabyte
    $gb = 1024 * $mb;   // Gigabyte
    $tb = 1024 * $gb;   // Terabyte
    if ($size < $kb) {
        return $size . " B";
    } else if ($size < $mb) {
        return round($size / $kb, 2) . " KB";
    } else if ($size < $gb) {
        return round($size / $mb, 2) . " MB";
    } else if ($size < $tb) {
        return round($size / $gb, 2) . " GB";
    } else {
        return round($size / $tb, 2) . " TB";
    }
}

//汉字转拼音
function get_pinyin($srt = '') {
    $py = new Pinyin();
    return $py->output($srt); //输出
}
//遍历删除目录和目录下所有文件
function del_dir($dir){
  if (!is_dir($dir)){
    return false;
  }
  $handle = opendir($dir);
  while (($file = readdir($handle)) !== false){
    if ($file != "." && $file != ".."){
      is_dir("$dir/$file")? del_dir("$dir/$file"):@unlink("$dir/$file");
    }
  }
  if (readdir($handle) == false){
    closedir($handle);
    @rmdir($dir);
  }
}

/**
 * 七牛云上传
 */
function qny_upload($key, $filePath){
  require_once APP_PATH . '/../vendor/qiniu/autoload.php';
  // 需要填写你的 Access Key 和 Secret Key
  $accessKey = config("qiniu.ACCESSKEY");
  $secretKey = config("qiniu.SECRETKEY");
  // 构建鉴权对象
  $auth = new QAuth($accessKey, $secretKey);
  // 要上传的空间
  $bucket = config("qiniu.BUCKET");
  $domain = config("qiniu.DOMAINImage");
  $token = $auth->uploadToken($bucket);
  // 初始化 UploadManager 对象并进行文件的上传
  $uploadMgr = new UploadManager();
  // 调用 UploadManager 的 putFile 方法进行文件的上传
  list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
  if ($err !== null) {
      return jserror(["err"=>1,"msg"=>$err,"name"=>""]);die;
  } else {
      //返回图片的完整URL
      return  jssuccess(["err"=>0,"msg"=>"上传完成","name"=>$ret['key']]);die;
  }
}
/**
 * 七牛云删除
 */
function qny_del($name){
  $delFileName = input("name");
  if( $delFileName ==null){
      return jserror("参数不正确"); die;
  }
  require_once APP_PATH . '/../vendor/qiniu/autoload.php';
  // 构建鉴权对象
  $auth = new QAuth(config("qiniu.ACCESSKEY"),config("qiniu.SECRETKEY"));
  // 配置
  $config = new \Qiniu\Config();
  // 管理资源
  $bucketManager = new \Qiniu\Storage\BucketManager($auth, $config);
  // 删除文件操作
  $res = $bucketManager->delete(config("qiniu.BUCKET"), $delFileName);
  if (is_null($res)) {
      return jssuccess("删除成功");
  }else{
      return jserror("删除失败");
  }
}


/*
彩虹字符串
 */
function color_txt($str){
    $len        = mb_strlen($str);
    $colorTxt   = '';
    for($i=0; $i<$len; $i++) {
        $colorTxt .=  '<span style="color:'.rand_color().'">'.mb_substr($str,$i,1,'utf-8').'</span>';
    }
    return $colorTxt;
}
// 随机颜色
function rand_color(){
    return '#'.sprintf("%02X",mt_rand(0,255)).sprintf("%02X",mt_rand(0,255)).sprintf("%02X",mt_rand(0,255));
}
  /**
 * 功能：是否是移动端
 *
 * User: cyf
 * Time: 2018/7/3 0003 11:01
 * @return bool
 */
function isMobile()
{
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
    {
        return true;
    }
    if (isset ($_SERVER['HTTP_VIA']))
    {
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array ('nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile');
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))){
            return true;
        }
    }
    if (isset ($_SERVER['HTTP_ACCEPT']))
    {
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
        {
            return true;
        }
    }
    return false;
}

// 验证邮箱
function check_email($email){
    if (preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/",$email,$arr)){
        return $arr;
    }else{
        return false;
    }
}

//判断url地址是否完整,不完整进行拼接
function zf_joint_url($domain='',$url=''){
  $isurl=@get_headers($url);
  if(!$isurl){
      if($url[0].$url[1]=='//'){
          return $url; // 合法
      }else{
          if($url[0]=='/'){
              return $domain.$url;
          }else{
              return $domain.'/'.$url;
          }
      }
  }else{
      return $url;
  }
}

function GetfourStr($len) 
{ 
  $chars_array = array( 
    "0", "1", "2", "3", "4", "5", "6", "7", "8", "9",
    "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", 
    "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", 
    "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G", 
    "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", 
    "S", "T", "U", "V", "W", "X", "Y", "Z", 
  ); 
  $charsLen = count($chars_array) - 1; 
  
  $outputstr = ""; 
  for ($i=0; $i<$len; $i++) 
  { 
    $outputstr .= $chars_array[mt_rand(0, $charsLen)]; 
  } 
  return $outputstr; 
} 

// 笛卡尔积
/*
$arr = array(
  array(2),
  array(6,7),
  array('a','b','c')
);
 */ 
function dikaer($arr){
   $arr1 = array();
   $result = array_shift($arr);
   while($arr2 = array_shift($arr)){
    $arr1 = $result;
    $result = array();
    foreach($arr1 as $v){
     foreach($arr2 as $v2){
      if(!is_array($v))$v = array($v);
      if(!is_array($v2))$v2 = array($v2);
      $result[] = array_merge_recursive($v,$v2);
     }
    }
   }
   return $result;
}
//dikaerj  以字符串形式输出
function dikaer_str($arr){
   $arr1 = array();
   $result = array_shift($arr);
   while($arr2 = array_shift($arr)){
    $arr1 = $result;
    $result = array();
    foreach($arr1 as $v){
     foreach($arr2 as $v2){
      $result[] = $v.','.$v2;
     }
    }
   }
   return $result;
}




// ------------------------新增--------------------------
// 

if (!function_exists('get_domain')) {
    /**
     * 获取当前域名
     * @param bool $http true 返回http协议头,false 只返回域名
     * @return string
     */
    function get_domain($http = true) {
        $host = input('server.http_host');
        $port = input('server.server_port');
        if ($port != 80 && $port != 443 && strpos($host, ':') === false) {
            $host .= ':'.input('server.server_port');
        }

        if ($http) {
            if (input('server.https') && input('server.https') == 'on') {
                return 'https://'.$host;
            }
            return 'http://'.$host;
        }

        return $host;
    }
}


if (!function_exists('editor')) {
    /**
     * 富文本编辑器
     * @param array $obj 编辑器的容器id或class
     * @param string $name [为了方便大家能在系统设置里面灵活选择编辑器，建议不要指定此参数]，目前支持的编辑器[ueditor,umeditor,ckeditor,kindeditor]
     * @param string $url [选填]附件上传地址，建议保持默认
     * @return html
     */
    function editor($obj = [], $name = '', $url = '') {
        $jsPath = '/static/js/editor/';
        if (empty($name)) {
            $name = config('sys.editor');
        }

        if (empty($url)) {
            $url = url("system/annex/upload?full_path=yes&thumb=no&from=".$name);
        }

        switch (strtolower($name)) {
            case 'ueditor':
                $html = '<script src="'.$jsPath.'ueditor/ueditor.config.js"></script>';
                $html .= '<script src="'.$jsPath.'ueditor/ueditor.all.min.js"></script>';
                $html .= '<script>';
                foreach ($obj as $k =>$v) {
                    $html .= 'var ue'.$k.' = UE.ui.Editor({serverUrl:"'.$url.'",initialFrameHeight:500,initialFrameWidth:"100%",autoHeightEnabled:false});ue'.$k.'.render("'.$v.'");';
                }
                $html .= '</script>';
                break;
            case 'kindeditor':
                if (is_array($obj)) {
                    $obj = implode(',#', $obj);
                }
                $html = '<script src="'.$jsPath.'kindeditor/kindeditor-min.js"></script>
                        <script>
                            var editor;
                            KindEditor.ready(function(K) {
                                editor = K.create(\'#'.$obj.'\', {uploadJson: "'.$url.'",allowFileManager : false,minHeight:500, width:"100%",autoHeightEnabled:false, afterBlur:function(){this.sync();}});
                            });
                        </script>';
                break;
            case 'ckeditor':
                $html = '<script src="'.$jsPath.'ckeditor/ckeditor.js"></script>';
                $html .= '<script>';
                foreach ($obj as  $v) {
                    $html .= 'CKEDITOR.replace("'.$v.'",{filebrowserImageUploadUrl:"'.$url.'"});';
                }
                $html .= '</script>';
                break;
            
            default:
                $html = '<link href="'.$jsPath.'umeditor/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">';
                $html .= '<script src="'.$jsPath.'umeditor/third-party/jquery.min.js"></script>';
                $html .= '<script src="'.$jsPath.'umeditor/third-party/template.min.js"></script>';
                $html .= '<script src="'.$jsPath.'umeditor/umeditor.config.js"></script>';
                $html .= '<script src="'.$jsPath.'umeditor/umeditor.min.js"></script>';
                $html .= '<script>';
                foreach ($obj as  $k => $v) {
                    $html .= 'var um'.$k.' = UM.getEditor("'.$v.'", {
                                initialFrameWidth:"100%"
                                ,initialFrameHeight:"500"
                                ,autoHeightEnabled:false
                                ,imageUrl:"'.$url.'"
                                ,imageFieldName:"upfile"});';
                }
                $html .= '</script>';
                break;
        }

        return $html;
    }
}



// +----------------------------------------------------------------------
// | 插件相关函数 start
// +----------------------------------------------------------------------

if (!function_exists('runhook')) {
    /**
     * 监听钩子的行为
     * @param string $name 钩子名称
     * @param array $params 参数
     * @param  bool   $return   是否需要返回结果
     * @param  bool   $once   只获取一个有效返回值
     */
    function runhook($name = '', $params = null, $return = false, $once = false) {
        $result = \Hook::listen($name, $params, $once);
        if ($return) {
            return $result;
        }
    }
}

if (!function_exists('get_plugins_class')) {
    /**
     * 获取插件类名
     * @param  string $name 插件名
     * @return string
     */
    function get_plugins_class($name)
    {
        return "plugins\\{$name}\\{$name}";
    }
}

if (!function_exists('plugins_action_exist')) {
    /**
     * 检查插件操作是否存在
     * @param string $path 插件操作路径：插件名/控制器/[操作]
     * @param string $group 控制器分组[admin,home]
     * @return bool
     */
    function plugins_action_exist($path = '', $group = 'admin')
    {
        if (strpos($path, '/')) {
            list($name, $controller, $action) = explode('/', $path);
        }
        $controller = empty($controller) ? 'Index' : ucfirst($controller);
        $action = empty($action) ? 'index' : $action;

        return method_exists("plugins\\{$name}\\{$group}\\{$controller}", $action);
    }
}

if (!function_exists('plugins_run')) {
    /**
     * 运行插件操作
     * @param string $path  执行操作路径：插件名/控制器/[操作]
     * @param mixed $params 参数
     * @param string $group 控制器分组[admin,home]
     * @return mixed
     */
    function plugins_run($path = '', $params = [], $group = 'admin')
    {
        !defined('IS_PLUGINS') && define('IS_PLUGINS', true);
        if (strpos($path, '/')) {
            list($name, $controller, $action) = explode('/', $path);
        } else {
            $name = $path;
        }
        $controller = empty($controller) ? 'index' : ucfirst($controller);
        $action = empty($action) ? 'index' : $action;
        if (!is_array($params)) {
            $params = (array)$params;
        }
        $class = "plugins\\{$name}\\{$group}\\{$controller}";
        $obj = new $class;
        $_GET['_p'] = $name;
        $_GET['_c'] = $controller;
        $_GET['_a'] = $action;
        return call_user_func_array([$obj, $action], [$params]);
    }
}

if (!function_exists('plugins_info')) {
    /**
     * 获取插件信息
     * @param string $name 插件名
     * @return bool
     */
    function plugins_info($name = '')
    {
        $path = \Env::get('root_path').'plugins/'.$name.'/info.php';
        if (!file_exists($path)) {
            return false;
        }
        return include_once $path;
    }
}

if (!function_exists('plugins_url')) {
    /**
     * 生成插件URL
     * @param string $url 链接：插件名称/控制器/操作
     * @param array $param 参数
     * @param string $group 控制器分组[admin,home]
     * @param integer $urlmode URL模式
     * URL模式1 [/plugins/插件名/控制器/[方法]?参数1=参数值&参数2=参数值]
     * URL模式2 [/plugins.php?_p=插件名&_c=控制器&_a=方法&参数1=参数值&参数2=参数值] 推荐
     * @return string
     */
    function plugins_url($url = '', $param = [], $group = '', $urlmode = 2)
    {
        $params = [];
        $params['_p'] = input('param._p');
        $params['_c'] = input('param._c', 'Index');
        $params['_a'] = input('param._a', 'index');
        if ($url) {
            $url = explode('/', $url);
            $count = count($url);
            if ($count == 3) {
                $params['_p'] = isset($url[0]) ? $url[0] : '';
                $params['_c'] =  isset($url[1]) ? ucfirst($url[1]) : 'Index';
                $params['_a'] = isset($url[2]) ? $url[2] : 'index';
            } else if ($count == 2) {
                $params['_c'] =  isset($url[0]) ? ucfirst($url[0]) : 'Index';
                $params['_a'] = isset($url[1]) ? $url[1] : 'index';
            } else {
                $params['_a'] = $url[0];
            }
        }

        if (!$params['_p']) {
            return '#链接错误';
        }

        $params = array_merge($params, $param);
        if (empty($group)) {
            if (defined('ENTRANCE')) {
                return url('system/plugins/run', $params);
            } else {
                if ($urlmode == 2) {
                    return '/plugins.php?'.http_build_query($params);
                }
                return '/plugins/'.$params['_p'].'/'.$params['_c'].'/'.$params['_a'].'?'.http_build_query($param);
            }
        } elseif ($group == 'admin') {
            return url('system/plugins/run', $params);
        } else {
            if ($urlmode == 2) {
                return '/plugins.php?'.http_build_query($params);
            }
            return '/plugins/'.$params['_p'].'/'.$params['_c'].'/'.$params['_a'].'?'.http_build_query($param);
        }
    }
}

// +----------------------------------------------------------------------
// | 插件相关函数 end
// +----------------------------------------------------------------------