<?php

/**
 * @Author: Eric-枫
 * @Date:   2019-08-29 10:33:28
 * @Last Modified by:   Eric-枫
 * @Last Modified time: 2019-09-27 17:04:10
 */
namespace zf;
use think\Controller;
use think\facade\Request;
use think\Db;
use think\facade\Config;

class GetConfig
{
    public function img(){
        $r = Db::name('admin')->select();

        var_dump($r);die;
//        return config('app.');
//        return Config::get('app.');
    }



}




?>