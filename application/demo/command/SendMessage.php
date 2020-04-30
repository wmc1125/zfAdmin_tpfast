<?php
namespace app\demo\command;
 
use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\Db;
use think\Log;
 
class SendMessage extends Command
{
    protected function configure(){
        $this->setName('SendMessage')->setDescription("计划任务 SendMessage");
    }
 
    //调用SendMessage 这个类时,会自动运行execute方法
    protected function execute(Input $input, Output $output){
        $output->writeln('Date Crontab job start...');
        /*** 这里写计划任务列表集 START ***/
 
        $this->birthday();//发短信
 
        /*** 这里写计划任务列表集 END ***/
        $output->writeln('Date Crontab job end...');
    }
 
    //获取当天生日的员工 发短信
    public function birthday()
    {
        echo '这里写你要实现的逻辑代码';
    }
}