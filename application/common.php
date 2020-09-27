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

// 应用公共文件
use think\Controller;
use think\Db;
use Qiniu\Auth as QAuth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;
include_once './application/common_db.php';
// 应用公共文件
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * @Notes: 后台权限  0 get ajax 全部验证  1 只验证ajax
 * @Interface admin_role_check
 * @param array $z_role_list
 * @param string $mca
 * @param int $type
 * @author: 子枫
 * @Time: 2019/11/13   11:05 下午
 */
if(!function_exists('admin_role_check')){
  function admin_role_check($z_role_list=[],$mca='',$type=0){
    if(request()->isAjax()){
        if(!session('admin')){
          return jserror('请登录后操作');
        }
        if(session("admin.gid")!=3){
            if (!in_array($mca, $z_role_list)) {
                if (request()->isAjax()) {
                    header('Content-Type:application/json');
                    return jserror('管理组无此权限');
                }
                if($type==1){
                    return jserror('没有保存权限');
                }
            }
        }
    } elseif(request()->isPost()){
        if(!session('admin')){
          return jserror('请登录后操作');
        }
        if(session("admin.gid")!=3){
            if (!in_array($mca, $z_role_list)) {
                if (request()->isAjax()) {
                    header('Content-Type:application/json');
                    echo "<script>alert('管理组无此权限');</script>";die;
                }
                if($type==1){
                    echo "<script>alert('没有保存权限');</script>";die;

                }
            }
        }
    }else{
        if(!session('admin')){
            echo "<script>alert('请先登录后台,在进行操作');location.href='/admin';</script>";die;
        }
        if(session("admin.gid")!=3){
            if (!in_array($mca, $z_role_list)) {
                if (request()->isAjax()) {
                    header('Content-Type:application/json');
                    echo "<script>alert('管理组无此权限');</script>";die;
                }
                if($type==0){
                    echo "<script>alert('没有保存权限');</script>";die;
                }

            }
        }


    }
  }

}



/**
 * @Notes:读取权限,并组成数组
 * @Interface get_admin_role
 * @param $gid
 * @return mixed
 * @throws \think\db\exception\DataNotFoundException
 * @throws \think\db\exception\ModelNotFoundException
 * @throws \think\exception\DbException
 * @author: 子枫
 * @Time: 2019/11/13   11:07 下午
 */
if(!function_exists('get_admin_role')){
  function get_admin_role($gid){
    $info =ZFTB('admin_group')->where('id',$gid)->find();
    $role = explode(',',$info['role']);
    foreach($role as $k=>$vo){
      $role_list[$k] = get_role_value($vo);
    }
    return $role_list;
  }
}
/**
 * @Notes:通过id,获取权限value(控制器/方法)
 * @Interface get_role_value
 * @param $id
 * @return mixed
 * @throws \think\db\exception\DataNotFoundException
 * @throws \think\db\exception\ModelNotFoundException
 * @throws \think\exception\DbException
 * @author: 子枫
 * @Time: 2019/11/13   11:07 下午
 */
if(!function_exists('get_role_value')){
  function get_role_value($id){
    $info =ZFTB('admin_role')->where('id',$id)->find();
    return $info['value'];
  }
}

/**
 * 循环删除目录和文件
 * @param string $dir_name
 * @return bool
 */
if(!function_exists('delete_dir_file')){
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
}
/**
 * 返回文件格式
 * @param  string $str 文件名
 * @return string      文件格式
 */
if(!function_exists('file_format')){
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
}

/**
* 解析sql语句
* @param  string $content sql内容
* @param  int $limit  如果为1，则只返回一条sql语句，默认返回所有
* @param  array $prefix 替换表前缀
* @return array|string 除去注释之后的sql语句数组或一条语句
*/
if(!function_exists('parse_sql')){
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
}




//计算整个目录文件大小/文件数量
if(!function_exists('getDirInfo')){
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
}
// 单位自动转换函数
if(!function_exists('getRealSize')){
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
}
//汉字转拼音
if(!function_exists('get_pinyin')){
  function get_pinyin($srt = '') {
      $py = new Pinyin();
      return $py->output($srt); //输出
  }
}
//遍历删除目录和目录下所有文件
if(!function_exists('del_dir')){
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
}


/*
彩虹字符串
 */
if(!function_exists('color_txt')){
  function color_txt($str){
      $len        = mb_strlen($str);
      $colorTxt   = '';
      for($i=0; $i<$len; $i++) {
          $colorTxt .=  '<span style="color:'.rand_color().'">'.mb_substr($str,$i,1,'utf-8').'</span>';
      }
      return $colorTxt;
  }
}
// 随机颜色
if(!function_exists('rand_color')){
  function rand_color(){
      return '#'.sprintf("%02X",mt_rand(0,255)).sprintf("%02X",mt_rand(0,255)).sprintf("%02X",mt_rand(0,255));
  }
}
  /**
 * 功能：是否是移动端
 *
 * User: cyf
 * Time: 2018/7/3 0003 11:01
 * @return bool
 */
if(!function_exists('isMobile')){
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
}
// 验证邮箱
if(!function_exists('check_email')){
  function check_email($email){
      if (preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/",$email,$arr)){
          return $arr;
      }else{
          return false;
      }
  }
}

//判断url地址是否完整,不完整进行拼接
if(!function_exists('zf_joint_url')){
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
}
if(!function_exists('GetfourStr')){
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
}
// 笛卡尔积
/*
$arr = array(
  array(2),
  array(6,7),
  array('a','b','c')
);
 */ 
if(!function_exists('dikaer')){
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
}
//dikaerj  以字符串形式输出
if(!function_exists('dikaer_str')){
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
}




// ------------------------新增--------------------------
// 
/**
 * 获取当前域名
 * @param bool $http true 返回http协议头,false 只返回域名
 * @return string
 */
if (!function_exists('get_domain')) {
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



// excel
if (!function_exists('zf_excel_export')) {
  function zf_excel_export($head,$keys,$data,$name){
      ob_end_clean();
      $count = count($head);  //计算表头数量
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      for ($i = 65; $i < $count + 65; $i++) {     //数字转字母从65开始，循环设置表头：
          $sheet->setCellValue(strtoupper(chr($i)) . '1', $head[$i - 65]);
      }
      /*--------------开始从数据库提取信息插入Excel表中------------------*/
      foreach ($data as $key => $item) {             //循环设置单元格：
          //$key+2,因为第一行是表头，所以写到表格时   从第二行开始写 
          for ($i = 65; $i < $count + 65; $i++) {     //数字转字母从65开始：
              $z_value = str_replace(['+','\\','/','='],'*',$item[$keys[$i - 65]]);
              $sheet->setCellValue(strtoupper(chr($i)) . ($key + 2), $z_value);
              $spreadsheet->getActiveSheet()->getColumnDimension(strtoupper(chr($i)))->setWidth(40); //固定列宽
          }
      } 
      // header('Content-Type: application/vnd.ms-excel');
      // header('Content-Disposition: attachment;filename="' . $name . '.xlsx"');
      // header('Cache-Control: max-age=0');
      // $writer = new Xlsx($spreadsheet);
      // $writer->save('php://output');
      // //删除清空：
      // $spreadsheet->disconnectWorksheets();
      // unset($spreadsheet);
      // exit;

      $writer = IOFactory::createWriter($spreadsheet,'Csv');
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename='.$name.'.csv');
      header('Cache-Control: max-age=0');
      $writer->setUseBOM(true);
      $writer->save('php://output');
  }
}

if (!function_exists('ZFRetMsg')) {
  function ZFRetMsg($is,$success_msg,$error_msg){
      if($is){
          return jssuccess($success_msg);
      }else{
          return jserror($error_msg);
      }

  }
}




###########----权限----################
/**
* 修改扩展配置文件
* @param array  $arr  需要更新或添加的配置
* @param string $file 配置文件名(不需要后辍)
* @return bool
*/
if (!function_exists('extraconfig')) {
  function extraconfig($arr = [], $file = ''){
     if (is_array($arr)) {
        $filename = $file . '.php';

        $filepath ='./config/' . $filename;
        if (!file_exists($filepath)) {
            $conf = "<?php return [];";
            file_put_contents($filepath, $conf);
        }

        $conf = include $filepath;
        foreach ($arr as $key => $value) {
            $conf[$key] = $value;
        }

        $time = date('Y/m/d H:i:s');
  //      $str = "<?php\r\n/**\r\n * 站点信息最后修改于 \r\n * $time\r\n */\r\nreturn [\r\n";
         $str = '
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
  // 站点信息最后修改于 '.$time;
         $str .= "  \r\n  \r\n return [\r\n";

         foreach ($conf as $key => $value) {
            $str .= "\t'$key' => '$value',";
            $str .= "\r\n";
        }
        $str .= '];';

        file_put_contents($filepath, $str);
        
        return true;
      } else {
        return false;
      }
  }
}
/**
*获取某个目录下的php文件名的函数
*/
if (!function_exists('getControllers')) {
  function getControllers($dir) {
      $pathList = glob($dir . '/*.php');
      $res = [];
      foreach($pathList as $key => $value) {
        $res[] = basename($value, '.php');
      }
      return $res;
  }
}
/**
*获取某个控制器的方法名的函数
*此方法过滤父级Base控制器的方法，只保留自己的
*/
if (!function_exists('getActions')) {
  function getActions($className, $base='\app\admin\controller\Admin') {
      $methods = get_class_methods(new $className());//当前控制器方法
      $baseMethods = get_class_methods(new $base());//通用方法
      $res = array_diff($methods, $baseMethods);
      return $res;
  }
}


###########----通用----################
/*
* 发起POST网络提交
* @params string $url : 网络地址
* @params json $data ： 发送的json格式数据
*/
if (!function_exists('https_post')) {
  function https_post($url,$data)
  {
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, $url);
      if (!empty($data)){
          curl_setopt($curl, CURLOPT_POST, 1);
          curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
      }
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      $output = curl_exec($curl);
      curl_close($curl);
      return $output;
  }
}
 /*
* 发起GET网络提交
* @params string $url : 网络地址
*/
if (!function_exists('https_get')) {
  function https_get($url)
  {
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE); 
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); 
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); 
      curl_setopt($curl, CURLOPT_HEADER, FALSE) ; 
      curl_setopt($curl, CURLOPT_TIMEOUT,60);
      if (curl_errno($curl)) {
          return 'Errno'.curl_error($curl);
      }
      else{$result=curl_exec($curl);}
      curl_close($curl);
      return $result;
  }
}
//成功之后返回json
if (!function_exists('jssuccess')) {
  function jssuccess($msg, $url = 'back') {
      echo json_encode(array("msg" => $msg, "url" => $url, "result" => '1'));exit;
  }
}
//失败之后返回json
if (!function_exists('jserror')) {
  function jserror($msg, $url = 'back') {
      echo json_encode(array("msg" => $msg, "url" => $url, "result" => '0'));exit;
  }
}
/**
* 数组 转 对象
*
* @param array $arr 数组
* @return object
*/
if (!function_exists('array_to_object')) {
  function array_to_object($arr) {
      if (gettype($arr) != 'array') {
          return;
      }
      foreach ($arr as $k => $v) {
          if (gettype($v) == 'array' || getType($v) == 'object') {
              $arr[$k] = (object)array_to_object($v);
          }
      }

      return (object)$arr;
  }
}
/**
* 对象 转 数组
*
* @param object $obj 对象
* @return array
*/
if (!function_exists('object_to_array')) {
  function object_to_array($obj) {
      $obj = (array)$obj;
      foreach ($obj as $k => $v) {
          if (gettype($v) == 'resource') {
              return;
          }
          if (gettype($v) == 'object' || gettype($v) == 'array') {
              $obj[$k] = (array)object_to_array($v);
          }
      }

      return $obj;
  }
}



// 输出日志
if (!function_exists('logOutput')) {
  function logOutput($data) {
      //数据类型检测
      if (is_array($data)) {
          $data = json_encode($data);
      }
      $filename = date("Y-m-d").".log";
      $str = date("Y-m-d H:i:s")."   $data"."\n";
      file_put_contents($filename, $str, FILE_APPEND|LOCK_EX);
      return null;
  }
}
/**
 * 获取替换文章中的图片路径
 * @param string $xstr 内容
 * @param string $keyword 创建照片的文件名
 * @param string $oriweb 网址
 * @return string
 * 
 */
if (!function_exists('replaceimg')) {
  function replaceimg($xstr, $oriweb,$param_src='src',$keyword='caiji'){ 
      //保存路径
      $d = date('Ymd', time());
      $dirslsitss = './public/upload/'.$keyword.'/'.$d;//分类是否存在
      if(!is_dir($dirslsitss)) {
          mkdir($dirslsitss, 0755,true);
      }
      //匹配图片的src
      preg_match_all('#<img.*?'.$param_src.'="([^"]*)"[^>]*>#i', $xstr, $match);
      foreach($match[1] as $imgurl){
          $imgurl = $imgurl;
          if(is_int(strpos($imgurl, 'http'))){
              $arcurl = $imgurl;
          } else {
              $arcurl = $oriweb.$imgurl;        
          }
          $img=file_get_contents($arcurl);
          if(!empty($img)) {
              //保存图片到服务器
              $fileimgname = time()."-".rand(1000,9999).".jpg";
              $filecachs=$dirslsitss."/".$fileimgname;
              if (!file_exists($dirslsitss)) {
                mkdir($dirslsitss);
              }
              $fanhuistr = file_put_contents( $filecachs, $img );
              $saveimgfile = "/public/upload/$keyword"."/".$d."/".$fileimgname;

              
              $xstr=str_replace($imgurl,$saveimgfile,$xstr);
          }
      }
      return $xstr;
  }
}
if (!function_exists('rand_post_first_pic')) {
  function rand_post_first_pic($content){
      $pattern="/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/"; 
      preg_match_all($pattern,$content,$matchContent); 
      if(isset($matchContent[1][0])){ 
          return $matchContent[1][0]; 
      }else{ 
          return "https://mctool.wangmingchang.com/api/api/sinaimg/t/large/sid/007goYVsgy1g5m2rdby9hj30ku0am74j";//在相应位置放置一张命名为no-image的jpg图片 
      } 
  }
}

if (!function_exists('dd')) {
    function dd($msg){
        echo "<pre>";
        var_dump($msg);die;
    }
}

// 保存文件到服务器
if (!function_exists('saveFileService')) {
  function saveFileService($url, $save_dir = '', $filename = '', $type = 0) {
      if (trim($url) == '') {
          return false;
      }
      if (trim($save_dir) == '') {
          $save_dir = './';
      }
      if (0 !== strrpos($save_dir, '/')) {
          $save_dir.= '/';
      }
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
    //echo $content;
      $size = strlen($content);
      //文件大小
      $fp2 = @fopen($save_dir . $filename, 'a');
      fwrite($fp2, $content);
      fclose($fp2);
      unset($content, $url);
      return array(
          'file_name' => $filename,
          'save_path' => $save_dir . $filename,
          'file_size' => $size
      );
  }
}

// 判断后台权限
if (!function_exists('admin_auth')) {
  function admin_auth(){
      if(!session('admin'))
      {
          echo "请先登录";die;
      }
  }
}


if (!function_exists('zf_controller_func_fast')) {
  function zf_controller_func_fast($controller,$function,$parm=[]){
    $controller = new $controller;
    $ret = $controller->$function($parm);
    return $ret;
  }
}


//加密
if (!function_exists('zf_encrypt')) {
  function zf_encrypt($data, $key='zf'){
      $key    =    md5($key);
      $x        =    0;
      $len    =    strlen($data);
      $l        =    strlen($key);
      $char = '';
      $str = '';
      for ($i = 0; $i < $len; $i++)
      {
          if ($x == $l) 
          {
              $x = 0;
          }
          $char .= $key{$x};
          $x++;
      }
      for ($i = 0; $i < $len; $i++)
      {
          $str .= chr(ord($data{$i}) + (ord($char{$i})) % 256);
      }
      return base64_encode($str);
  }
}
//解密
if (!function_exists('zf_decrypt')) {
  function zf_decrypt($data, $key='zf'){
      $key = md5($key);
      $x = 0;
      $data = base64_decode($data);
      $len = strlen($data);
      $l = strlen($key);
      $char = '';
      $str = '';
      for ($i = 0; $i < $len; $i++)
      {
          if ($x == $l) 
          {
              $x = 0;
          }
          $char .= substr($key, $x, 1);
          $x++;
      }
      for ($i = 0; $i < $len; $i++)
      {
          if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1)))
          {
              $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
          }
          else
          {
              $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
          }
      }
      return $str;
  }
}



if (!function_exists('ZFRetMsg')) {
    function ZFRetMsg($is,$success_msg,$error_msg){
        if($is){
            return jssuccess($success_msg);
        }else{
            return jserror($error_msg);
        }

    }
}



/**
 * 返回文件格式(附件类型)
 * @param  string $file 文件名
 * @return string  文件格式(1：文件、2：压缩包、3：图片、4：视频、5：音频、6、其他)
 */
if (!function_exists('file_format_cn')) {
  function file_format_cn($file){
      // 取文件后缀名
      $str = strtolower(pathinfo($file, PATHINFO_EXTENSION));
      //strtolower 将所有字符转换为小写
      //pathinfo 获取文件信息，详细用法见下面我的补充
      // 文档格式
      $text = array('exe','doc','docx','ppt','xls','xlsx','wps','txt','lrc','wfs','torrent','html','htm','java','js','css','less','php','pdf','pps','host','box','word','perfect','dot','dsf','efe','ini','json','lnk','log','msi','ost','pcs','tmp','xlsb');
      // 压缩格式
      $zip = array('rar','zip','tar','cab','uue','jar','iso','z','7-zip','ace','lzh','arj','gzip','bz2','tz');
      // 图片格式
      $image = array('webp','jpg','png','ico','bmp','gif','tif','pcx','tga','bmp','pxc','tiff','jpeg','exif','fpx','svg','psd','cdr','pcd','dxf','ufo','eps','ai','hdri');
      $video = array('mp4','avi','3gp','rmvb','gif','wmv','mkv','mpg','vob','mov','flv','swf','ape','m4a','m4r','ogg','wavpack');
      //音频格式
      $audio = array('wav','aif','au','mp3','ram','wma','mmf','amr','aac','flac');
      // 匹配不同的结果
      if(in_array($str, $text)){
          return '文本';
      }elseif(in_array($str, $zip)){
          return '压缩'; 
      }elseif(in_array($str, $image)){
          return '图片';
      }elseif(in_array($str, $video)){
          return '视频';
      }elseif(in_array($str, $audio)){
          return '音频';
      }else{
          return '其他';
      }
  }
}

//判断是否HTTPS
if (!function_exists('isHTTPS')) {
  function isHTTPS()
  {
      if (defined('HTTPS') && HTTPS) return true;
      if (!isset($_SERVER)) return FALSE;
      if (!isset($_SERVER['HTTPS'])) return FALSE;
      if ($_SERVER['HTTPS'] === 1) {  //Apache
          return TRUE;
      } elseif ($_SERVER['HTTPS'] === 'on') { //IIS
          return TRUE;
      } elseif ($_SERVER['SERVER_PORT'] == 443) { //其他
          return TRUE;
      }
      return FALSE;
  }
}