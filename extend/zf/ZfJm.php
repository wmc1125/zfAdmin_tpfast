<?php
namespace zf;
/*
* 字符串加解密类；
* 一次一密；且定时解密有效
* 可用于加密&动态key生成
* demo：	
        echo "demo 1<br>";
        echo "加密：";
        $jm1 =  \zf\ZfJm::encrypt('abc','123');
        echo $jm1;
        echo "解密：";
        // $jm2 = \zf\ZfJm::decrypt('0746rR5Aew2yuWncskbF0swTxn7XZwzuU4ySLdvb1rk','123');
        $jm2 = \zf\ZfJm::decrypt($jm1,'123');
        echo $jm2;
        echo "<br>";

        echo "demo 2<br>";
        echo "加密：";
        $jm1 =  \zf\ZfJm::zf_encrypt('abc','123');
        echo $jm1;
        echo "解密：";
        // $jm2 = \zf\ZfJm::decrypt('0746rR5Aew2yuWncskbF0swTxn7XZwzuU4ySLdvb1rk','123');
        $jm2 = \zf\ZfJm::zf_decrypt($jm1,'123');
        echo $jm2;
        echo "<br>";
        
        echo "demo 3<br>";
        echo "加密：";
        $jm1 =  \zf\ZfJm::zz_encrypt('abc','123');
        echo $jm1;
        echo "解密：";
        $jm2 = \zf\ZfJm::zz_decrypt('9dc9vMRp79icTkiiYRdVMy7sAdXdst8eIGMAxNg13nRJ','123');
        // $jm2 = \zf\ZfJm::zz_decrypt($jm1,'123');
        echo $jm2;
        echo "<br>";

*/
class ZfJm{
	private static $default_key = 'a!takA:dlmcldEv,e';
	/**
	 * 字符加密，一次一密,可定时解密有效
	 * 
	 * @param string $string 原文
	 * @param string $key 密钥
	 * @param int $expiry 密文有效期,单位s,0 为永久有效
	 * @return string 加密后的内容
	 */
	public static function encrypt($string,$key = '', $expiry = 0){
		$ckeyLength = 4;
		$key = md5($key ? $key : self::$default_key); //解密密匙
		$keya = md5(substr($key, 0, 16));		 //做数据完整性验证  
		$keyb = md5(substr($key, 16, 16));		 //用于变化生成的密文 (初始化向量IV)
		$keyc = substr(md5(microtime()), - $ckeyLength);
		$cryptkey = $keya . md5($keya . $keyc);  
		$keyLength = strlen($cryptkey);
		$string = sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string . $keyb), 0, 16) . $string;
		$stringLength = strlen($string);
 
		$rndkey = array();	
		for($i = 0; $i <= 255; $i++) {	
			$rndkey[$i] = ord($cryptkey[$i % $keyLength]);
		}
 
		$box = range(0, 255);	
		// 打乱密匙簿，增加随机性
		for($j = $i = 0; $i < 256; $i++) {
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}	
		// 加解密，从密匙簿得出密匙进行异或，再转成字符
		$result = '';
		for($a = $j = $i = 0; $i < $stringLength; $i++) {
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp; 
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		}
		$result = $keyc . str_replace('=', '', base64_encode($result));
		$result = str_replace(array('+', '/', '='),array('-', '_', '.'), $result);
		return $result;
	}
 
	/**
	 * 字符解密，一次一密,可定时解密有效
	 * 
	 * @param string $string 密文
	 * @param string $key 解密密钥
	 * @return string 解密后的内容
	 */
	public static function decrypt($string,$key = '')
	{
		$string = str_replace(array('-', '_', '.'),array('+', '/', '='), $string);
		$ckeyLength = 4;
		$key = md5($key ? $key : self::$default_key); //解密密匙
		$keya = md5(substr($key, 0, 16));		 //做数据完整性验证  
		$keyb = md5(substr($key, 16, 16));		 //用于变化生成的密文 (初始化向量IV)
		$keyc = substr($string, 0, $ckeyLength);
		$cryptkey = $keya . md5($keya . $keyc);  
		$keyLength = strlen($cryptkey);
		$string = base64_decode(substr($string, $ckeyLength));
		$stringLength = strlen($string);
 
		$rndkey = array();	
		for($i = 0; $i <= 255; $i++) {	
			$rndkey[$i] = ord($cryptkey[$i % $keyLength]);
		}
 
		$box = range(0, 255);
		// 打乱密匙簿，增加随机性
		for($j = $i = 0; $i < 256; $i++) {
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}
		// 加解密，从密匙簿得出密匙进行异或，再转成字符
		$result = '';
		for($a = $j = $i = 0; $i < $stringLength; $i++) {
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp; 
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		}
		if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0)
		&& substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)
		) {
			return substr($result, 26);
		} else {
			return '';
		} 
	}

	//加密 
	public static  function zf_encrypt($data, $key='zf'){
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
	public static function zf_decrypt($data, $key='zf'){
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
	  //连着结合款 加密
	public static function zz_encrypt($string,$key = '', $expiry = 0){
	  	$string = self::zf_encrypt($string,$key);
	  	$ret = self::encrypt($string,$key,$expiry);
	  	return $ret;
	}
	  //解密
	public static function zz_decrypt($string,$key = ''){
	  	$string = self::decrypt($string,$key);
	  	$ret = self::zf_decrypt($string,$key);
	  	return $ret;
	}


}
