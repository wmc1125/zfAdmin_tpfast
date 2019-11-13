<?php
namespace app\demo\controller;
use QL\QueryList;
use think\Db;

class Index extends Base
{
    public function index()
    {
        echo "index";
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
    public function version(){
        echo \think\facade\App::version();
    }

    public function test(){
        $mm = encrypt('12345');
        echo $mm;
        echo "<br>";
        $jj = decrypt($mm);
        echo $jj;
    }
   


}
