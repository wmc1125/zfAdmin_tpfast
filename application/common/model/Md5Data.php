<?php
namespace app\common\model;

use think\Model;
use app\common\model\Md5Data;

class Md5Data extends Model
{
    protected $table = 'zf_md5_data';
    protected $pk = 'id';
    
    private function getRule(){
        return [
            'type' => 'mod', // 分表方式
            'num'  => 2     // 分表数量
        ];
    }
    
    public function saveData($data, $str){
        return $this->partition(['str' => $str], "str", $this->getRule())->insert($data);
    }
    
    public function getAll($where, $field = "*", $str){
        return $this->partition(['str' => $str], "str", $this->getRule())->where($where)->field($field)->select();
    }
    public function find_all($where, $field = "*"){
        // dd($this->getRule()['num']);
        for ($i=1; $i <=$this->getRule()['num'] ; $i++) { 
            $res = $this->getAll( $where ,'*', $i);
            if(isset($res[0])){
                return $res;
                break;
            }
        }
        return false;
    }

}