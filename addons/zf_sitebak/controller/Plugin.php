<?php
namespace addons\zf_sitebak\controller;

use think\Addons;
use think\App;

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
        echo 1;die;
        return true;
    }

    /**
     * 插件卸载方法
     * @return bool
     */
    public function uninstall()
    {
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

}