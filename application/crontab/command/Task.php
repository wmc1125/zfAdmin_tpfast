<?php
namespace app\crontab\command;
 
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;
use think\Db;
class Task extends Command
{
    protected function configure()
    {
        $this->setName('task')
            ->setDescription('定时计划：每天生成一个日期文件');
    }
 
    protected function execute(Input $input, Output $output)
    {
        // file_put_contents(time().'.txt', '当前日期为：'.date('Y-m-d'));
        $data['name'] = time();
        $data['time'] = date("Y-m-d H:i:s", time());
        // Db::name('test')->insert($data);
    }
 
}
