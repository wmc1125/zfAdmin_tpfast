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


use think\facade\Hook;

###########----权限----################
/**
* 修改扩展配置文件
* @param array  $arr  需要更新或添加的配置
* @param string $file 配置文件名(不需要后辍)
* @return bool
*/
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

/**
*获取某个目录下的php文件名的函数
*/
function getControllers($dir) {
    $pathList = glob($dir . '/*.php');
    $res = [];
    foreach($pathList as $key => $value) {
      $res[] = basename($value, '.php');
    }
    return $res;
}
/**
*获取某个控制器的方法名的函数
*此方法过滤父级Base控制器的方法，只保留自己的
*/
function getActions($className, $base='\app\admin\controller\Admin') {
    $methods = get_class_methods(new $className());//当前控制器方法
    $baseMethods = get_class_methods(new $base());//通用方法
    $res = array_diff($methods, $baseMethods);
    return $res;
}



###########----通用----################
/*
* 发起POST网络提交
* @params string $url : 网络地址
* @params json $data ： 发送的json格式数据
*/
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
 /*
* 发起GET网络提交
* @params string $url : 网络地址
*/
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

//成功之后返回json
function jssuccess($msg, $url = 'back') {
  	echo json_encode(array("msg" => $msg, "url" => $url, "result" => '1'));exit;
}
//失败之后返回json
function jserror($msg, $url = 'back') {
  	echo json_encode(array("msg" => $msg, "url" => $url, "result" => '0'));exit;
}

/**
* 数组 转 对象
*
* @param array $arr 数组
* @return object
*/
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
/**
* 对象 转 数组
*
* @param object $obj 对象
* @return array
*/
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




// 输出日志
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
/**
 * 获取替换文章中的图片路径
 * @param string $xstr 内容
 * @param string $keyword 创建照片的文件名
 * @param string $oriweb 网址
 * @return string
 * 
 */
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
function rand_post_first_pic($content){
    $pattern="/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/"; 
    preg_match_all($pattern,$content,$matchContent); 
    if(isset($matchContent[1][0])){ 
        return $matchContent[1][0]; 
    }else{ 
        return "https://mctool.wangmingchang.com/api/api/sinaimg/t/large/sid/007goYVsgy1g5m2rdby9hj30ku0am74j";//在相应位置放置一张命名为no-image的jpg图片 
    } 
}

if (!function_exists('dd')) {
    function dd($msg){
        echo "<pre>";
        var_dump($msg);die;
    }
}

// 保存文件到服务器
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

// 判断后台权限
function admin_auth(){
    if(!session('admin'))
    {
        echo "请先登录";die;
    }
}





?>