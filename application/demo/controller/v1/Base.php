<?php

/**
 * @Author: Eric-枫
 * @Date:   2019-08-21 17:51:36
 * @Last Modified by:   Eric-枫
 * @Last Modified time: 2019-08-21 17:58:58
 */

namespace app\demo\Controller\v1;
use think\Controller;
use think\Db;
use think\Url;
use think\Response;
class Base extends Controller
{
    //空方法
    public function _empty()
    {
        return $this->error('空方法！');
    }
    public function index(){
    	echo "版本v1   app\demo\v1\Controller";
    }
   
}