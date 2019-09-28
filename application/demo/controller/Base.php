<?php
namespace app\demo\Controller;
use think\Controller;
use think\Db;
use think\Url;
use think\Response;
class Base extends Controller
{
    //空方法
    public function _empty()
    {
        return $this->error('空方法！');
    }
    //查询数据库所有表信息
    protected function tables()
    {
        $tables = Db::query('show table status');
        return $tables;
    }
    //查询表信息
    public function table($table){
        $database = config('database.database');
        $res = Db::query("select table_comment from information_schema.tables where table_schema = '$database' and table_name ='$table'");
        return $res[0]['table_comment'];
    }
    //查询表中所有字段信息
    protected function columns($table){
        $columns = Db::query("SHOW FULL COLUMNS FROM ".$table);
        return $columns;
    }
    //获取模型
    public function controller_step2(){
        $mokuai = input('mokuai');
        if(empty($mokuai)){
            return false;
        }
        $dir1 = dirname(dirname(dirname(__FILE__))).'\\'.$mokuai."\\model";
        $files = array();
        if(is_dir($dir1)){
            $child_dirs = scandir($dir1);
            foreach($child_dirs as $child_dir){
                if(strstr($child_dir, '.php')){
                    $files['model'][] = basename($child_dir,".php");
                }
            }
        }
        if(input('auth') == 1){
            $dir2 = dirname(dirname(dirname(__FILE__)))."\\http\\middleware";
            if(is_dir($dir2)){
                $child_dirs = scandir($dir2);
                foreach($child_dirs as $child_dir){
                    if(strstr($child_dir, '.php')){
                        $files['auth'][] = basename($child_dir,".php");
                    }
                }
            }
        }
        return json($files);
    }
    //获取模块
    public function mokuai(){
        $dir = dirname(dirname(dirname(__FILE__)));
        $files = array();
        if(is_dir($dir)){
            $child_dirs = scandir($dir);
            foreach($child_dirs as $child_dir){
                if($child_dir != '.' && $child_dir != '..' && $child_dir != "extra" && !strstr($child_dir, '.')){
                    $files[] = $child_dir;
                }
            }
        }
        foreach( $files as $k=>$v) {
            if('code' == $v || 'http' == $v){
                unset($files[$k]);
            }
        }
        return $files;
    }
    //数据表名转换成符合命名规格的字符串
    public static function parseName($name, $type = 0, $ucfirst = true)
    {
        if ($type) {
            $name = preg_replace_callback('/_([a-zA-Z])/', function ($match) {
                return strtoupper($match[1]);
            }, $name);
            return $ucfirst ? ucfirst($name) : lcfirst($name);
        }

        return strtolower(trim(preg_replace("/[A-Z]/", "_\\0", $name), "_"));
    }
    //生成文件的数据
    public function modelbuild($mokuai,$modelLayer,$table = null){
        $data[$mokuai] = [
            '__dir__' => [$modelLayer],
            "$modelLayer"  => [$table],
        ];
        return $data;
    }
    //生成文件的数据
    public function cbuild($mokuai,$controller,$table){
        $data[$mokuai] = [
            '__dir__' => [$controller],
            "$controller"  => [ucfirst($table)],
        ];
        return $data;
    }
}