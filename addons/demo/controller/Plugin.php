<?php
namespace addons\demo\controller;

use \think\Addons;
use \think\App;
use \think\Db;

//namespace addons\test;	// 注意命名空间规范

/**
 * 插件测试
 * @author byron sampson
 */
class Plugin extends Addons	// 需继承think\Addons类
{
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->plugin_info = [
            'name' => 'test',	// 插件标识
            'title' => '插件测试',	// 插件名称
            'description' => 'thinkph插件测试',	// 插件简介
            'status' => 0,	// 状态
            'author' => 'byron sampson',
            'version' => '0.1'
        ];

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

    /**
     * 实现的testhook钩子方法
     * @return mixed
     */
    public function testhook($param)
    {
        // 调用钩子时候的参数信息
        print_r($param);
        // 当前插件的配置信息，配置信息存在当前目录的config.php文件中，见下方
        print_r($this->getConfig());
        // 可以返回模板，模板文件默认读取的为插件目录中的文件。模板名不能为空！
        return $this->fetch('info');
    }

    // 必要的sql
    public function sql(){
        //查询表是否存在
        // $table_name = 'zf_test2';
        // $isTable = Db::query("SHOW TABLES LIKE '".$table_name."'");
        // if(!$isTable){
        //     echo '表不存在';
        //     // 创建表
        //     $r = Db::execute("
        //         CREATE TABLE `zf_test2` (
        //           `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        //           `name` varchar(255) DEFAULT NULL,
        //           PRIMARY KEY (`id`)
        //         ) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
        //     ");
        // }



        //查询字段是否存在更新/存在


        //链接其他数据库
        // $list = Db::connect([
        //     'type'=>'mysql',
        //     'hostname'=>'localhost',
        //     'database'=>'zf_laravel',
        //     'username'=>'zf_laravel',
        //     'password'=>'ACzMKbG7kfrNtmky',

        // ])->table('zf_user')->select();
        // dd($list);




        // $r = Db::execute("
        //         INSERT INTO `v1_fast_zf_90ckm`.`zf_test`(`name`) VALUES ( 'ad');
        //     ");
        // $r = Db::query("
        //         INSERT INTO `v1_fast_zf_90ckm`.`zf_test`(`name`) VALUES ( 'ad');
        //     ");




        
        
        // 查询所有表（记录数，数据大小，索引大小）
        // $list = Db::query("SHOW TABLE STATUS");
        
        // 查询表sql。
         // $list = Db::query("show create table zf_user");

        // 查询表结构。
        // $list =  Db::query("show columns from zf_user");
        // dd($list);



        


        // dd($list);
        // $r = Db::name('user')->find();
        // dd($r);

        // try{
        //     // 执行循环插入数据之前先清空 数据表中当前角色的权限;  $info['id'] 角色
        //     Db::name('user')->find();
        //     return true;
        // } catch (\Exception $e) {
        //     // 更新失败 回滚事务
        //     return false;
        // }


    }















}

?>