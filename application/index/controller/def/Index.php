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

namespace app\index\controller\def;
use think\Db;
use think\facade\Request;
use Wmc1125\TpFast\GetConfig;
use app\common\model\Md5Data;
use think\facade\Db as Ddb;

/**
 * @title 登录注册
 * Class Api
 */
class Index extends Base
{

	public function __construct ( Request $request = null ){
        parent::__construct();
    }
    
    public function index(){
        if(input('tpl_id')){
            if(input('tpl_id')=='-1'){
                session('tpl_id',null);
            }else{
                session('tpl_id',input('tpl_id'));
            }
        }else{
            session('tpl_id',null);
        }
        // echo   11;die;
    	//banner
       	$this->assign('banner',Db::name('advert')->where(['status'=>'1','pid'=>1])->select());
       	//最新文章
       	$this->assign('post_new',Db::name('post')->where(['status'=>1,'relevan_id'=>0,'is_product'=>0])->order('ctime desc,id desc')->paginate(15));
        $seo['title'] = config()['web']['site_title'];
        $seo['keywords'] = config()['web']['site_keywords'];
        $seo['description'] = config()['web']['site_description'];
        $this->assign('seo', $seo);
        return view($this->tpl);
    }
     public function test(){
        dd('test');
        // 数据库配置信息设置（全局有效）
        Ddb::setConfig([
            // 默认数据连接标识
            'default'     => 'mysql',
            // 数据库连接信息
            'connections' => [
                'mysql' => [
                    // 数据库类型
                    'type'     => 'mysql',
                    // 主机地址
                    'hostname' => '127.0.0.1',
                    // 用户名
                    'username' => 'root',
                    // 数据库名
                    'database' => 'demo',
                    // 数据库编码默认采用utf8
                    'charset'  => 'utf8',
                    // 数据库表前缀
                    'prefix'   => 'think_',
                    // 数据库调试模式
                    'debug'    => true,
                ],
            ],
        ]);


     }




     //分表测试
    public function walletSave(){
        $Md5DataModel = new Md5Data();
        for($i = 1; $i < 1000; $i++){
            $str = GetRandStr(10);
            $data = [
                'uid' => 0,
                'status'=>1,
                'ctime' => date("Y-m-d H:i:s", time()),
                'str' => $str,
                'md5_str' => md5($str)
            ];
            if(!$Md5DataModel->find_all( ['str'=>$str])){
                $Md5DataModel->saveData($data, $i);
            }
        }
        echo 'success';die;
    }
    public function getWallet(){
        
        $Md5DataModel = new Md5Data();
        // $res = $Md5DataModel->getAll( ['str'=>'11'],'*', 1);
        // if(isset($res[0])){
        //     echo 1;
        // }else{
        //     echo 0;
        // }
        // 判断是否存在
        // $res = $Md5DataModel->find_all( ['str'=>'DC8OQOIK6K']);
        // dd($res);



        //不存在  执行保存
        $str = 11;
        $data = [
            'uid' => 0,
            'status'=>1,
            'ctime' => date("Y-m-d H:i:s", time()),
            'str' => $str,
            'md5_str' => md5($str)
        ];
        if(!$Md5DataModel->find_all( ['str'=>$str])){
            $Md5DataModel->saveData($data, $i);
        }else{
            echo 'cunzai';
        }


    }



}
function GetRandStr($length){
    $str='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $len=strlen($str)-1;
    $randstr='';
    for($i=0;$i<$length;$i++){
    $num=mt_rand(0,$len);
    $randstr .= $str[$num];
    }
    return $randstr;
}