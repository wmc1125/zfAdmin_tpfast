<?php
namespace addons\zf_querylist\controller;
use think\facade\Request;
use think\Db;
use QL\QueryList;
use Wmc1125\TpFast\Category as cat; 
use think\Controller;
use Wmc1125\TpFast\GetImgSrc; 

class Index extends Controller
{
    public function __construct (){
        parent::__construct();
    }
    //
    public function index()
    {
        $list = Db::name('caiji')->where('status!=9')->order("sort asc")->paginate(999);
        $page = $list->render();
        $this->assign("list",$list);
        $this->assign("page",$page);
        return view();
    }
    //添加
    public function add()
    {
        if(request()->isPost()){
            $data = input("post.");
            $res = Db::name('caiji')->insert($data);
            if($res){
                return jssuccess('新增成功');
            }else{
                return jserror('新增失败');exit;
            }  
        }  
        return view();

    }
    //修改
    public function edit()
    {
        if(request()->isGet()){
            $res =  Db::name('caiji')->where(['id'=>input('id')])->find(); 
            $this->assign("res",$res);
            $cat_res = Db::name('category')->where(['status'=>1])->select();
            $cat = new cat(array('cid', 'pid', 'name', 'cname')); //初始化无限分类
            $plist = $cat->getTree($cat_res); //获取分类数据树结构
            if(!$plist){
                $plist = [];
            }
            $this->assign("plist",$plist);
            return view();
        } 
        if(request()->isPost()){
           $data = input('post.');
            $res = Db::name('caiji')->where(['id'=>$data['id']])->update($data);
            if($res)
            {
                return jssuccess('修改成功');
            }else{
                return jserror('修改失败');
            }   
        } 
    }
    //采集列表
    public function cj_list()
    {
        $cid = input('id',0);
        $list = Db::name('caiji_list_log l')
                ->field('l.*,c.name as cname')
                ->where(['l.cid'=>$cid])
                ->join('caiji c','c.id = l.cid')
                ->order("l.id desc")->paginate(50);
        $page = $list->render();
        $this->assign("list",$list);
        $this->assign("page",$page);
        return view();
    }
    //采集详情页 
    public function caiji_content(){
        if(request()->isPost()){
            $data = input('post.');
            if(isset($data['album_list']) && is_array($data['album_list'])){
                $data['album'] = implode(",", $data['album_list']);
                unset($data['album_list']);
            }
            if($data['ctime']!=''){
                $data['ctime'] =  strtotime($data['ctime']);
            }else{
                $data['ctime'] =  time();
            }
            // dd($data['content']);
            $res = Db::name('post')->insertGetId($data);
            // $res = 1;
            //修改状态
            if($res){
                Db::name('caiji_list_log')->where(['id'=>$data['cj_id']])->update(['is_push'=>1]);
                //保存图片
                for($i=1;$i<=100;$i++){
                    $parm_list_src[$i]['pid'] = $res;
                    $parm_list_src[$i]['cid'] = '442';
                    $parm_list_src[$i]['ctime'] = time() ;
                    $parm_list_src[$i]['status'] = 1;
                    $parm_list_src[$i]['title'] = $data['title'];
                    $parm_list_src[$i]['pic'] = GetImgSrc::src($data['content'], $i,'src');  
                    if(empty($parm_list_src[$i]['pic'])){
                      unset($parm_list_src[$i]);
                      break;
                    }
                }
                // dd($parm_list_src);
                foreach($parm_list_src as $k=>$vo){
                    $_is = Db::name('post')->where(['pic'=>$vo['pic'],'pid'=>$vo['pid']])->value('id');
                    if(!$_is){
                        Db::name('post')->insert($vo);
                    }
                }
                 return jssuccess('新增成功');
            }else{
                return jserror('新增失败');
            }   
        } 
        $cid = input('cid',0);
        $cj_id = input('cj_id',0);
        $cate_id = input('cate_id',0);
        $this->assign('cj_id',$cj_id);
        $this->assign('cate_id',$cate_id);
        $res = Db::name('caiji')->where(['id'=>$cid])->find(); 
        $cj_res = Db::name('caiji_list_log')->where(['id'=>$cj_id])->find(); 
        $ql = QueryList::html(iconv($res['charact'],'UTF-8',file_get_contents($cj_res['url'])));
        $list = $ql->removeHead()->rules([ 
            'title'=>array($res['cj_content_label_title'],'text'),
            'content'=>array($res['cj_content_label_content'],'html')
        ])->query()->getData();
        // dd($list); //图片的链接地址  类型
        // $res['content'] = @replaceimg($list[0]['content'],$res['oriweb'],$res['param_src']);
        $res['content'] = $list[0]['content'];
        // dd($res['content']);
        $res['title'] = $list[0]['title'];
        $this->assign('res',$res);

        $cat_res = Db::name('category')->where(['status'=>1])->select();
        $cat = new cat(array('cid', 'pid', 'name', 'cname')); //初始化无限分类
        $plist = $cat->getTree($cat_res); //获取分类数据树结构
        if(!$plist){
            $plist = [];
        }
        $this->assign("plist",$plist);
        return view();
    }

    // 测试
    public function list_cj_test(){
        $data = input('post.');
        $ql = QueryList::html(iconv($data['charact'],'UTF-8',file_get_contents($data['cj_list_url'].'1')));
        $list = $ql->removeHead()->rules([ 
            'title'=>array($data['cj_list_label_title'],'text'),
            'url'=>array($data['cj_list_label_url'],'href')
        ])->query()->getData();
        // dd($list);
        if($list){
            $ret = '';
            foreach ($list as $k => $vo) {
                $ret.='<p>'.$k.' 标题:  '.$vo['title'].'   链接:'.zf_joint_url($data['domain'],$vo['url']).'</p>';
            }
            return jssuccess($ret);
        }else{
            return jserror('error');
        }
    }
    // 测试
     public function content_cj_test(){
        $data = input('post.');
        $ql = QueryList::html(iconv($data['charact'],'UTF-8',file_get_contents($data['cj_content_test_url'])));
        // ->find('img')->attrs('src');
        $list = $ql->removeHead()->rules([ 
            'title'=>array($data['cj_content_label_title'],'text'),
            'content'=>array($data['cj_content_label_content'],'html')
        ])->query()->getData();
        $ret = "<div><p>".$list[0]['title']."</p><div>".$list[0]['content']."</div></div>";
        return jssuccess($ret);
    }

    // 一键采集
    public function ajax_cj_list(){
        $id = input('id',8);
        $res = Db::name('caiji')->where(['id'=>$id])->find(); 
        $ajax_ret['suc_sum'] = 0;//成功
        $ajax_ret['rep_sum'] = 0;//重复
        $ajax_ret['sum'] = 0;//总数
        for($i=$res['cj_list_url_num_s'];$i<=$res['cj_list_url_num_e'];$i++){
            $ql = QueryList::html(iconv($res['charact'],'UTF-8',file_get_contents($res['cj_list_url'].$i)));
            $list = $ql->removeHead()->rules([ 
                'title'=>array($res['cj_list_label_title'],'text'),
                'url'=>array($res['cj_list_label_url'],'href')
            ])->query()->getData();
            // dd($list);
            if($list){
                foreach ($list as $k => $vo) {
                    if($vo['url']!=null){
                        //判断链接完整性
                        $ret['title'] = $vo['title'];
                        // $ret['url'] =zf_joint_url($res['domain'],$vo['url']);
                        $ret['url'] = $vo['url'];
                        $ret['cid'] = $id;
                        $ret['create_time'] = time();
                        $ret['is_push'] = 0;
                        $ret['cate_id'] = $res['cate_id'];
                        if(!Db::name('caiji_list_log')->field('id')->where(['cid'=>$ret['cid'],'url'=>$ret['url']])->find()){
                            Db::name('caiji_list_log')->insert($ret);
                            $ajax_ret['suc_sum']++; 
                            $ajax_ret['sum']++; 
                        }else{
                            $ajax_ret['rep_sum']++; 
                            $ajax_ret['sum']++; 
                        }
                    }
                    
                }
            }
        }
        $_ajax_ret = '<p>总数:'.$ajax_ret['sum'].' 成功数:'.$ajax_ret['suc_sum'].' 重复数:'.$ajax_ret['rep_sum'].'</p>';
        return jssuccess($_ajax_ret);
    }
    
    public function tap_post(){
        $cj_id = input('cj_id',0);
        $id = Db::name('post')->where(['cj_id'=>$cj_id])->value('id');
        $this->redirect('index/cate/detail', ['id' => $id]);
    }
   
 

    














    
}
