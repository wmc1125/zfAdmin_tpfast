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

namespace app\admin\controller;
use app\admin\model\roleModel;
use think\facade\Session;
use think\facade\Cache;
use think\facade\Request;
use think\Db;
use Wmc1125\TpFast\Database as dbOper;
use app\admin\controller\Common;
use Wmc1125\TpFast\Download;
use zf\PclZip;
class Zfyun extends Admin
{
    public function __construct (){
        parent::__construct();
    }

    public function index()
    {
        echo 1;
    }
    public function zip(){
        echo "zip";
        $archive = new PclZip('archive.zip');
        //解压
        dd($archive);
    }
    public function save_site(){
        $zip = new PclZip("public/upload/site_bak/archive.zip"); 
        $v_list = $zip->create($_SERVER['DOCUMENT_ROOT'] ,PCLZIP_OPT_REMOVE_PATH,$_SERVER['DOCUMENT_ROOT']); 
        if($v_list == 0){ echo '异常：'.$zip->errorInfo(true); } 
        else { echo '备份成功'; }

    }

    public function update(){
        echo 'update';
         // https_get();
        // saveFileService();

        //$url = "http://www.baidu.com/img/baidu_jgylogo3.gif";
        //$url="http://192.168.1.212/aaa.doc";
        // $url="http://192.168.31.1/".urlencode(iconv("GB2312","UTF-8","测试.doc"));
        $url = 'https://i.loli.net/2019/11/17/6pMNQoyxXL3PufO.jpg';
        $save_dir = "public/upload/pgrade/".time();
        //$filename = "baidu_jgylog1o31.gif";
        $filename ="1.jpg";
        $res = saveFileService($url, $save_dir, $filename,1);//0  1 都是好使的
        var_dump($res);


    }

    


}
