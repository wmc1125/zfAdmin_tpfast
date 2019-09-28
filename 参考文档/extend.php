<?php

/**
 * @Author: Eric-枫
 * @Date:   2019-08-29 10:43:02
 * @Last Modified by:   Eric-枫
 * @Last Modified time: 2019-08-29 11:01:05
 */

lib
----Category.php
----GetImgSrc.php  
		参考:http://demo.zf.90ckm.com/demo/img/getimgsrc
----GoogleAuthenticator.php






GoogleAuthenticator.php 使用

	简单应用
	public function google(){
		$ga = new GoogleAuthenticator();
	    $secret = 'Y67N442CU2G4CIAG';
	    $qrCodeUrl = $ga->getQRCodeGoogleUrl('zf-1', $secret);
	    $oneCode = $ga->getCode($secret);
	    $getTime = $ga->getTime(2);    // 2 = 2*30sec clock tolerance

	    // $oneCode = $data['google_code'];
	    // echo $oneCode;
	    dd($getTime);
	}

	实战应用
	use lib\GoogleAuthenticator;
	//生成
	$res = Db::name('admin')->where(['id'=>$id])->find();
	$ga = new GoogleAuthenticator();
	if($res['google_secret']!=''){
	    $secret = $res['google_secret'];
	}else{
	    $secret = $ga->createSecret();
	}
	$qrCodeUrl = 'http://mctool.wangmingchang.com/api/tool/create_qr_code?t=google&name=zf-'.$id.'&secret='.$secret;
	// $oneCode = $ga->getCode($secret);
	$this->assign('secret',$secret);
	$this->assign('qrCodeUrl',$qrCodeUrl);
	//验证
	$ga = new GoogleAuthenticator();
	$secret = $userInfo['google_secret'];
	$qrCodeUrl = $ga->getQRCodeGoogleUrl('zf-'.$userInfo['id'], $secret);
	$oneCode = $data['google_code'];
	$checkResult = $ga->verifyCode($secret, $oneCode, 2);    // 2 = 2*30sec clock tolerance
	if (!$checkResult) {
	    return jserror('谷歌验证错误');die;
	}






