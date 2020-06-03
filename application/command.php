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

return [
	'app\crontab\command\Task',
];




//  单命令
// * * * * * cd /www/wwwroot/v1.fast.zf.90ckm.com && /www/server/php/72/bin/php ./think task >> /dev/null 2>&1

// sh模式 
// */1 * * * * sh /www/wwwroot/v1.fast.zf.90ckm.com/crontab.sh 2 >>/data/zfv1_log/log.txt   # 结果输出到/data/zfv1_log/log.txt    



//宝塔模式
// 1.宝塔计划任务   
// /bin/bash /www/wwwroot/v1.fast.zf.90ckm.com/crontab.sh 
// 2. crontab.sh 
/*
		#!/bin/bash
		cd /www/wwwroot/v1.fast.zf.90ckm.com
		/www/server/php/72/bin/php ./think task
*/