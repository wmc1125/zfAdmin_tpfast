<?php
namespace addons\demo\controller;
use \think\Addons;
use \think\App;
use \think\Db;
use addons\Base;

//namespace addons\test;	// 注意命名空间规范

/**
 * 插件测试
 * @author byron sampson
 */
class Plugin extends Base	// 需继承think\Addons类
{
    public function __construct(App $app = null)
    {
        parent::__construct();
        $this->plugin_name = 'demo';
        $this->tb_pre = 'demo';

    }

    public function _empty(){
        echo "没有此方法";die;
    }

    // 该插件的基础信息
    /**
     * 插件安装方法
     * @return bool
     */
    public function install()
    {
        //激活
      //mysql
        // $table_name = 'zf_test2';
        // $isTable = Db::query("SHOW TABLES LIKE '".$table_name."'");
        // if(!$isTable){
        //     // 创建表
        //     $r = Db::execute("
        //         CREATE TABLE `zf_test2` (
        //           `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        //           `name` varchar(255) DEFAULT NULL,
        //           PRIMARY KEY (`id`)
        //         ) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
        //     ");
        // }

      //新建文件/目录
        
        return ['code'=>1,'msg'=>'ok'];
        // return ['code'=>0,'msg'=>'error'];
    }

    /**
     * 插件卸载方法
     * @return bool
     */
    public function uninstall()
    {
        dd('uninstall');
        return true;
    }


    















}

?>