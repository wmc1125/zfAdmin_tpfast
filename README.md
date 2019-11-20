# 子枫CMS后台管理系统-tpfast系列
## 先爆个照
![](https://i.loli.net/2019/11/20/ImLWKz8apSogZGC.jpg)

![](https://i.loli.net/2019/11/20/cWHMdTeRrqiZo41.jpg)
## 系统要求
 + php5.6+ (推荐使用php7.1+)
 + gd2
 + 伪静态（隐藏入口文件index.php）

## 安装：
GitHub仓库:  https://github.com/wmc1125/zfAdmin_tpfast

Gitee仓库:  https://gitee.com/ZF-Box/zfAdmin_tpfast

步骤一(下载文件)
+  宝塔安装(提交中)

+  源文件安装 (从上面的仓库中下载)

+ git下载(从上面的仓库选择git clone)

步骤二(安装扩展)
+ 执行composer update 下载vendor扩展

步骤三(sql安装)
+ 直接将sql文件导入数据库,然后修改数据库文件(config/database.php)
+ 执行安装程序
	1. 将根目录的install.lock 删除,之后打开网址,执行安装程序
	2. 填写数据库名称/密码等执行安装
+ 选择宝塔方式安装此步骤可省略,直接导入
+ 后台账号密码(admin/123456) ## 测试账号秘密(test/111111)

## 可安装扩展
+ Excel的导入导出
  
  "phpoffice/phpspreadsheet": "1.8.0" 需要在大于php7.1版本,如果你要使用,可在composer.json require 中加入"phpoffice/phpspreadsheet": "1.8.0"


## 后台管理模块
 + 内容管理
 + 模板管理
 + 用户管理
 + 其他管理
 + 数据库管理
 + 网站管理
 + 权限管理

## 后台使用手册
编写中...

## 交流
+ 论坛: [MC技术论坛](http://bbs.wangmingchang.com/forum.php?mod=forumdisplay&fid=77 "MC技术论坛")
+ 博客: [王明昌博客](http://www.wangmingchang.com/ "王明昌博客")
+ 微信: wmc1125  (备注加好友目的)

## 测试后台
+ 测试地址: http://v1.fast.zf.90ckm.com/admin
+ 测试账号: test
+ 测试密码:111111

## 感谢
 + ThinkPHP
 + layui
 + bootstrap
 + Light Year Admin

 ## 捐献列表

[![](https://mctool.wangmingchang.com/api/api/rand_pic)](http://mctool.wangmingchang.com/index/jspay/dashang)
 