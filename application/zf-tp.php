<?php
function zf($zz='0'){
	if($zz=='afsvdv123dsa'){
		$data['domain'] = request()->domain();//domain
  		$data['ip'] = request()->ip();//访问ip
  		$data['type'] = 1; //1 单域名  2 根域名  
		$auth_ret = https_post('http://mctool.wangmingchang.com/api/auth/web',['data'=>encrypt(json_encode($data),"web_auth")]);
		//判断是否通讯成功
		if(json_decode($auth_ret)){
			//判断是否认证
			if(json_decode($auth_ret)->code==1){
  				$is_auth_code = true;
			}else{
  				$is_auth_code = false;
			}
		}else{
			// 通讯失败,使用本地文件校验
			error_reporting(0);
			// $myfile = fopen('./auth.text','r') or $is_auth_code = false;
			// $_file = fgets($myfile);
			// fclose($myfile);
			$_file = '3lfH0tLHyqJXblTLqNjRnMCRj2HGyNCmkayfXnJknMzQY8bS0oiNVqmtoshWnpLf';
			$f = json_decode(decrypt($_file,'web_auth'));
      // echo 1;die;
      // dd($f);
			if($f){
				if($f->type==1){
					$is_auth_code = $f->domain!=request()->domain()?false:true;
				}elseif($f->type==2){
					$is_auth_code = $f->domain!=request()->rootDomain()?false:true;
				}else{
  					$is_auth_code = false;
				}
			}else{
  				$is_auth_code = false;
			}
		}
  		if(!$is_auth_code){
	  		// die('error');
  		}
  		return ['code'=>1,'auth'=>encrypt('zfadmin-'.date("Y-m-d",time()))];
	}

  	die('php是最好的语言,不接受反驳!');
}
function zf_test(){
 	var_dump(zf()['auth']);die;
	zf('afsvdv123dsa')['auth']==encrypt('zfadmin-'.date("Y-m-d",time()))? 'ok':die('error'); 
	return  '----';
}

// 网站权限判断
function zf_web_auth(){
	// zf('afsvdv123dsa')['auth']==encrypt('zfadmin-'.date("Y-m-d",time()))? 'ok':die('error'); 
}


function curl_post_https($url,$data){ // 模拟提交数据函数
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
    curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
    $tmpInfo = curl_exec($curl); // 执行操作
    if (curl_errno($curl)) {
        echo 'Errno'.curl_error($curl);//捕抓异常
    }
    curl_close($curl); // 关闭CURL会话
    return $tmpInfo; // 返回数据，json格式
}
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
//加密
function encrypt($data, $key='zf')
{
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

//解密
function decrypt($data, $key='zf')
{
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

//成功之后返回json
function jssuccess($msg, $url = 'back') {
	// zf('afsvdv123dsa')['auth']==encrypt('zfadmin-'.date("Y-m-d",time()))? 'ok':die('error'); 
  	echo json_encode(array("msg" => $msg, "url" => $url, "result" => '1'));exit;
}
//失败之后返回json
function jserror($msg, $url = 'back') {
	// zf('afsvdv123dsa')['auth']==encrypt('zfadmin-'.date("Y-m-d",time()))? 'ok':die('error'); 
  	echo json_encode(array("msg" => $msg, "url" => $url, "result" => '0'));exit;
}

/**
* 数组 转 对象
*
* @param array $arr 数组
* @return object
*/
function array_to_object($arr) {
	  zf('afsvdv123dsa')['auth']==encrypt('zfadmin-'.date("Y-m-d",time()))? 'ok':die('error'); 
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
	  zf('afsvdv123dsa')['auth']==encrypt('zfadmin-'.date("Y-m-d",time()))? 'ok':die('error'); 
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


/**
* 修改扩展配置文件
* @param array  $arr  需要更新或添加的配置
* @param string $file 配置文件名(不需要后辍)
* @return bool
*/
function extraconfig($arr = [], $file = '')
{
	zf('afsvdv123dsa')['auth']==encrypt('zfadmin-'.date("Y-m-d",time()))? 'ok':die('error'); 
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
      $str = "<?php\r\n/**\r\n * 站点信息最后修改于 \r\n * $time\r\n */\r\nreturn [\r\n";
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
	zf('afsvdv123dsa')['auth']==encrypt('zfadmin-'.date("Y-m-d",time()))? 'ok':die('error'); 
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
	zf('afsvdv123dsa')['auth']==encrypt('zfadmin-'.date("Y-m-d",time()))? 'ok':die('error'); 
  $methods = get_class_methods(new $className());//当前控制器方法
  $baseMethods = get_class_methods(new $base());//通用方法
  $res = array_diff($methods, $baseMethods);
  return $res;
}

// 输出日志
function logOutput($data) {
	zf('afsvdv123dsa')['auth']==encrypt('zfadmin-'.date("Y-m-d",time()))? 'ok':die('error'); 
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
	zf('afsvdv123dsa')['auth']==encrypt('zfadmin-'.date("Y-m-d",time()))? 'ok':die('error'); 
    //保存路径
    $d = date('Ymd', time());
    $dirslsitss = './upload/'.$keyword.'/'.$d;//分类是否存在
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
            $saveimgfile = "/upload/$keyword"."/".$d."/".$fileimgname;

            
            $xstr=str_replace($imgurl,$saveimgfile,$xstr);
        }
    }
    return $xstr;
}
function rand_post_first_pic($content){
	zf('afsvdv123dsa')['auth']==encrypt('zfadmin-'.date("Y-m-d",time()))? 'ok':die('error'); 	
    $pattern="/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/"; 
    preg_match_all($pattern,$content,$matchContent); 
    if(isset($matchContent[1][0])){ 
        return $matchContent[1][0]; 
    }else{ 
        return "https://mctool.wangmingchang.com/api/api/sinaimg/t/large/sid/007goYVsgy1g5m2rdby9hj30ku0am74j";//在相应位置放置一张命名为no-image的jpg图片 
    } 
}












?>