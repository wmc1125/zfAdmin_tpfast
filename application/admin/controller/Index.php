<?php
namespace app\admin\controller;
use app\admin\model\roleModel;
use think\facade\Session;
use think\facade\Cache;
use think\facade\Request;
use think\Db;
use zf\Database as dbOper;

use app\admin\controller\Common;

class Index extends Admin
{
    public function __construct (){
        parent::__construct();
    }
    public function index()
    {
        //导航的一级菜单
        $menu = Db::name('admin_role')->order("sort asc")->where("status!=9")->select();
        $this->assign("menu",$menu);
        return view("index");
    }
    public function welcome()
    {
        \zf\ZfTool::test();
        admin_role_check($this->z_role_list,$this->mca);
        //  用户增长曲线
        // $user_nyr_grow = Db::name('user')
        //             ->field("DATE_FORMAT(FROM_UNIXTIME(ctime),'%Y-%m-%d') as date, count(DATE_FORMAT(FROM_UNIXTIME(ctime),'%Y-%m-%d')) as sum")
        //             ->group("DATE_FORMAT(FROM_UNIXTIME(ctime),'%Y-%m-%d')")
        //             ->select();
        // foreach($user_nyr_grow as $k=>$vo){
        //     $user_nyr_grow_chart['nyr'][$k] = $vo['date'];
        //     $user_nyr_grow_chart['sum'][$k] = $vo['sum'];
        // }
        // $this->assign('user_nyr_grow_chart',$user_nyr_grow_chart);
        // $this->assign('user_nyr_grow',$user_nyr_grow);

        // //性别比例
        // $user_sex = Db::name('user')
        //             ->field("sex, count(sex) as sum")
        //             ->group("sex")
        //             ->select();
        // foreach($user_sex as $k=>$vo){
        //     // 0	未知	
        //     // 1	男性	
        //     // 2	女性
        //     if($vo['sex']==1){
        //         $user_sex_chart[$k]['sex'] = '男';
        //     }elseif($vo['sex']==2){
        //         $user_sex_chart[$k]['sex'] = '女';
        //     }else{
        //         $user_sex_chart[$k]['sex'] = '未知';
        //     }
        //     $user_sex_chart[$k]['sum'] = $vo['sum'];
        // }
        // $this->assign('user_sex_chart',$user_sex_chart);
        //用户总数
        $data['user_total'] = Db::name('user')->where([['status','<>','9']])->count();
        //本周用户数 
        $data['user_week'] = Db::name('user')->where([['status','<>','9']])->whereTime('ctime','week')->count();
        //内容总数
        $data['post_total'] = Db::name('post')->where([['status','<>','9']])->count();
        //本周内容
        $data['post_week'] = Db::name('post')->where([['status','<>','9']])->whereTime('ctime','week')->count();
        //留言数
        $data['guessbook_total'] = Db::name('guessbook')->where([['status','<>','9']])->count();
        //本周留言数
        $data['guessbook_week'] = Db::name('guessbook')->where([['status','<>','9']])->whereTime('ctime','week')->count();

        $data['posts'] = Db::name('post')->where([['status','<>','9']])->limit(10)->order('ctime desc')->select();

        $this->assign('data',$data);
        return view();
    }

    // 清除数据库的垃圾箱文件
    public function db_clear(){
        admin_role_check($this->z_role_list,$this->mca);
        $t = input('t','');
        if($t=='log'){
                Db::name('admin_log')->where(['status'=>1])->update(['status'=>9]);
                $this->success('清除完毕');
        }else{
            $config=array(
                'path'     => './db/',//数据库备份路径
            );

            $tables = Db::query("SHOW TABLE STATUS");

            foreach($tables as $k=>$vo){
                Db::table($vo['Name'])->where(['status'=>9])->delete();
            }
            $this->success('清除完毕');
        }
        
    }

    public  function test(){
//     
    }
    



   
    

}
