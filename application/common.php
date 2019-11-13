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
use think\Db;
use Qiniu\Auth as QAuth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;
include_once './application/zf.php';
include_once './application/common_db.php';
// 应用公共文件
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

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



// excel
function zf_excel_export($head,$keys,$data,$name){
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
            $sheet->setCellValue(strtoupper(chr($i)) . ($key + 2), $item[$keys[$i - 65]]);
            $spreadsheet->getActiveSheet()->getColumnDimension(strtoupper(chr($i)))->setWidth(20); //固定列宽
        }
    } 
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $name . '.xlsx"');
    header('Cache-Control: max-age=0');
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    //删除清空：
    $spreadsheet->disconnectWorksheets();
    unset($spreadsheet);
    exit;
}
// 导入
// function zf_excel_import($head,$keys,$data,$name){

// }

//form插件

function zf_form($type='layui-input',$vo,$data_res){
    switch($type) {
        case "layui-input":
            $_html='
            <div class="layui-card-header">'.$vo['name'].'</div>
            <div class="layui-card-body layui-row layui-col-space12">
            <div class="layui-col-md12">
                <input type="text" name="'.$vo['key'].'" placeholder="请输入" autocomplete="off" class="layui-input" value="'.$data_res[$vo['key']].'">
            </div>
            </div>';
            break;
        case "layui-textarea":
            $_html='
            <div class="layui-card-header">'.$vo["name"].'</div>
            <div class="layui-card-body layui-row layui-col-space12">
              <div class="layui-col-md12">
                <textarea name="'.$vo["key"].'" placeholder="请输入" class="layui-textarea">'.$data_res[$vo['key']].'</textarea>
              </div>
            </div>
            ';
            break;
        case "1":
            break;
        case "2":
            break;
        default:
            break;
    }
    print($_html);

}

