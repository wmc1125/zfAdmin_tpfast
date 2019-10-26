<?php

/**
 * @Author: Eric-枫
 * @Date:   2019-08-29 10:33:28
 * @Last Modified by:   Eric-枫
 * @Last Modified time: 2019-10-21 10:33:15
 */
namespace zf;
use think\Controller;
use think\facade\Request;
use think\Db;
use think\facade\Config;

final class ZfTool
{
    public function __construct(){

    }
    /*
     * ZF权限方法
     */
    public function auth(){}
    /*
     * ZF加密解密方法
     */
    public function 加密(){}

    /*
     * 更新此类
     */
    public function upload(){}

    /*
     * 获取信息
     */
    public function get_info(){}

    /*
     * 压缩
     */
    public function 压缩(){}

    /*
     * 定位
     */
    public function 定位(){}

    static public function test(){
        dd(2222222223232);
    }



}

if (!function_exists('dd')) {
    function dd($msg){
        zf('afsvdv123dsa')['auth']==encrypt('zfadmin-'.date("Y-m-d",time()))? 'ok':die('error');
        echo "<pre>";
        var_dump($msg);die;
    }
}
if (!function_exists('d')) {
    function d($t='user'){
        zf('afsvdv123dsa')['auth']==encrypt('zfadmin-'.date("Y-m-d",time()))? 'ok':die('error');
        echo DB::table($t)->getlastsql();
    }
}







