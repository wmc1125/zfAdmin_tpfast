<?php
namespace app\index\controller;
use think\Db;
use think\facade\Request;
use zf\Category as cat;
class Cate extends Base
{
	public function __construct ( Request $request = null ){
        parent::__construct();
    }
    // 首页
    public function index()
    {
        echo 'index';die;

    }
    //列表
    public function listt()
    {
        $cid = input('cid',1);
        $this->assign('cid',$cid);
        $top_cid_now = $this->get_top_category($cid);
        $this->assign('top_cid_now',$top_cid_now);
        $cate_res = Db::name('category')->where(['status'=>1,'cid'=>$cid])->find();
        $where[] = ['status','=',1];
        $where[] = ['is_product','=',0];
        if($cid==$top_cid_now['cid']){
            $where[] = ['cid','in',$this->get_child_id($cid)];
        }else{
            $where[] = ['cid','=',$cid];
        }
        $list = Db::name('post')->where($where)->order('ctime desc,id desc')->paginate($cate_res['page']);
        if($cate_res['url']!=''){
            return redirect($cate_res['url']);
        }
        $this->assign('list',$list);
        $this->assign('page',$list->render());
        $this->assign('cate_res',$cate_res);
        $tpl = $this->tpl_suffix .'/'.$this->controller.'/'.$cate_res['tpl_category'];
        $seo['title'] = $cate_res['name'].'-'.config()['web']['site_name'];
        $seo['keywords'] = config()['web']['site_keywords'];
        $seo['description'] = config()['web']['site_description'];
        $this->assign('seo', $seo);
        return view($tpl);
    }
    // detail
    public function detail()
    {
        $id = input('id',0);
        $content = Db::name('post')->where(['status'=>1,'id'=>$id])->find();
        $this->assign('content',$content);
        $this->assign('cid',$content['cid']);
        $cate_res = Db::name('category')->field('cid,name,tpl_category,tpl_post')->where(['status'=>1,'cid'=>$content['cid']])->find();
        $this->assign('cate_res',$cate_res);
        //增加浏览次数
        Db::name('post')->where("id=".$id)->setInc('hits');
        $prev = Db::name('post')->where("cid = ".$content['cid'].' and id>'.$id)->order('id asc')->find();
        $next = Db::name('post')->where("cid = ".$content['cid'].' and id<'.$id)->order('id desc')->find();
        $this->assign('prev', empty($prev) ? '<a href="#">【上一篇】：没有了</a>' : ' <a href="' .'content/id/'.$prev['id']. '"  >【上一篇】：' . $prev['title'] . '</a>');
        $this->assign('next', empty($next) ? '<a href="#">【下一篇】：没有了</a>' : '<a href="' .'content/id/'.$next['id'].'"  >【下一篇】：' . $next['title'] . '</a>');

        $tpl = $this->tpl_suffix .'/'.$this->controller.'/'.$cate_res['tpl_post'];

        $seo['title'] = $content['title'].'-'.$cate_res['name'].'-'.config()['web']['site_name'];
        $seo['keywords'] = config()['web']['site_keywords'];
        $seo['description'] = config()['web']['site_description'];
        $this->assign('seo', $seo);
        return view($tpl);
    }
    //search
    public function search()
    {
        $keyword = input('keyword',1);
        $where[] = ['title','like','%'.$keyword.'%'];
        $where[] = ['status','=','1'];

        $this->assign('list',Db::name('post')->where($where)->order('ctime desc,id desc')->paginate(10));
        // dd($)
        $seo['keywords'] = '搜索 "' . $keyword . '" 的结果';
        $seo['title'] = $seo['keywords'] . ' - ' . config()['web']['site_name'];
        $seo['description'] = config()['web']['site_description'];
        $this->assign('seo', $seo);

        return view($this->tpl);
    }
    public function liuyan(){

        if(request()->isPost()){
            $data = input('post.');
            if(!check_email($data['email'])){
                return jserror('邮箱错误');
            }
            if($data['content']==''){
                return jserror('内容不能为空');
            }
            //判断是否已提交
            if(Db::name('guessbook')->where(['email'=>$data['email'],'content'=>$data['content']])->count() >0){
                return jserror('请勿重复提交');
            }
            $data['create_time'] = time();
            // dd($data);
            $res = Db::name('guessbook')->insert($data);
            if($res){            
                return jssuccess('提交成功');
            }else{
                return jserror('提交失败');
            }
        }


        $list = Db::name('guessbook')->where(['status'=>1])->order('id desc')->paginate(10);
        $this->assign('list',$list);
        // dd($list);
        return view($this->tpl);

        
    }
    public function page(){
        $cid = input('cid',0);
        $content = Db::name('category')->where(['status'=>1,'cid'=>$cid])->find();
        // dd($content);
        $this->assign('content',$content);
        $this->assign('cid',$cid);
        $seo['title'] = $content['name'].'-'.config()['web']['site_name'];
        $seo['keywords'] = config()['web']['site_keywords'];
        $seo['description'] = config()['web']['site_description'];
        $this->assign('seo', $seo);
        return view($this->tpl);
    }
     //返回当前最顶层栏目
    protected function get_top_category($cid = 0) {
        $data = Db::name('category')->field('cid,pid,name,cname,icon,tpl_category,tpl_post,mid,sort,menu')->where(['status'=>1])->order("sort asc,cid asc")->select();
        $cat = new cat(array('cid', 'pid', 'name', 'cname')); //初始化无限分类
        $list = $cat->getPath($data, $cid); //获取分类数据树结构
        return $list[0];
    }
    //子栏目所有CID
    protected function get_child_id($pid = 0, $condition = '1=1') {
        //查询分类信息
        $data = Db::name('category')->field('cid,pid,name')->where($condition)->order("sort asc,cid asc")->select();
        $cat = new cat(array('cid', 'pid', 'name', 'cname')); //初始化无限分类
        $child_array = $cat->getTree($data, $pid);//获取分类数据树结构
        if(is_array($child_array) && !empty($child_array)){
            foreach($child_array as $vo){
                $child_cid[] = $vo['cid'];
            }
        }else{
            return $pid;
        }
        return implode(',', $child_cid);//获取所有子分类cid字符串
    }
   

   
   


}
