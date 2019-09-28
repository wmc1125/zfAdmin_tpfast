<?php

/**
 * @Author: Eric-枫
 * @Date:   2019-08-21 17:51:36
 * @Last Modified by:   Eric-枫
 * @Last Modified time: 2019-08-21 18:01:51
 */

namespace app\demo\Controller\v2;
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
    	echo "版本v2   app\demo\v1\Controller";
    }
   
}