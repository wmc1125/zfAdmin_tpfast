<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------

 return [
       'connector'  => '',		// Redis 驱动
       'expire'     => '',		// 任务的过期时间，默认为60秒; 若要禁用，则设置为 null
       'default'    => '',		// 默认的队列名称
       'host'       => '',	// redis 主机ip
       'port'       => '',		// redis 端口
       'password'   => '',		// redis 密码
       'select'     => '',		// 使用哪一个 db，默认为 db0
       'timeout'    => '',		// redis连接的超时时间
       'persistent' => '',		// 是否是长连接
     
   //    'connector' => 'Database',   // 数据库驱动
   //    'expire'    => 60,           // 任务的过期时间，默认为60秒; 若要禁用，则设置为 null
   //    'default'   => 'default',    // 默认的队列名称
   //    'table'     => 'jobs',       // 存储消息的表名，不带前缀
   //    'dsn'       => [],

   //    'connector'   => 'Topthink',	// ThinkPHP内部的队列通知服务平台 ，本文不作介绍
   //    'token'       => '',
   //    'project_id'  => '',
   //    'protocol'    => 'https',
   //    'host'        => 'qns.topthink.com',
   //    'port'        => 443,
   //    'api_version' => 1,
   //    'max_retries' => 3,
   //    'default'     => 'default',

   //    'connector'   => 'Sync',		// Sync 驱动，该驱动的实际作用是取消消息队列，还原为同步执行
   ];