<?php

/**
 * @Author: Eric-枫
 * @Date:   2019-08-16 09:58:45
 * @Last Modified by:   Eric-枫
 * @Last Modified time: 2019-08-19 17:18:01
 */
namespace app\admin\controller;
use lib\Category as cat;
use think\Db;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Products extends Admin
{
    public function __construct (){
        parent::__construct();
    }
    public function product()
    {
        // 栏目id
        $cid = input('cid',0);
        $where[] = ['status','<>',9];
        $where[] = ['is_product','=',1];

        if($cid!=0){
            $where[] = ['cid','=',$cid];
        }
        if(input("get.title")){
            $title = input("get.title");
            $where[] = ['title','like','%'.$title.'%'];
        }
        $where = array_merge($where,$this->common_select_tag);

        $list = Db::name('post')->where($where)->order("id desc")->paginate(6);
        if(!$list){
            $List = [];
        }
        $page = $list->render();
        $this->assign("list",$list);
        $this->assign("page",$page);
        $res =  Db::name('product_cate')->where(['cid'=>$cid])->find();
        $this->assign("res",$res);
        return view();
        
    }

    // 内容增加
    public function product_add()
    {
        if(request()->isGet()){
            if(!session('_gid')){
                session('_gid',mt_rand(10000,99999));
            }
            $where[] = ['status','=',1];
            $where = array_merge($where,$this->common_select_tag);
            $mlist = Db::name('product_cate')->where($where)->order("cid asc")->select();
            // d('category');
            // dd($mlist);
            $this->assign("mlist",$mlist);
            return view();
        } 
        if(request()->isPost()){
            $data = input('post.');
            $data = array_merge($data,$this->common_tag);
            if(isset($data['album_list']) && is_array($data['album_list'])){
                $data['album'] = implode(",", $data['album_list']);
                unset($data['album_list']);
            }
            if($data['ctime']!=''){
                $data['ctime'] =  strtotime($data['ctime']);
            }else{
                $data['ctime'] =  time();
            }
            $res = Db::name('post')->insert($data);
            if($res)
            {
                 return jssuccess('新增成功');
            }else{
                return jserror('新增失败');
            }   
        } 
    }
    public function product_sku_edit(){
                // $arr = array(
        //   array('6s','6sp'),
        //   array('黑色','白色'),
        //   array('68G','128G'),
        //   // array('a','b','c')
        // );
        // $sku = dikaer($arr);
        $id = input('id',0);
        $res = Db::name('post')->field('id,title')->where(['id'=>input('id')])->find();
        $this->assign("res",$res);      
        $sku = Db::name('product_sku')->field("id,sku_name as k,GROUP_CONCAT(sku_value) as v")->where(['gid'=>$id,'status'=>1])->group('sku_name')->select();
        $_arr = [];
        $sku_parm = [];
        foreach($sku as $k=>$vo){
            $sku_parm[$k] = $vo['k'];
            foreach(explode(',',$vo['v']) as $k2=>$vo2){
                $_arr[$k][$k2]['title'] = $vo2;
                $_arr[$k][$k2]['id'] = Db::name('product_sku')->where(['gid'=>$id,'status'=>1,'sku_name'=>$vo['k'],'sku_value'=>$vo2])->value('id');
            }
        }
        $sku = dikaer($_arr);
        // dd($sku_parm);
        $this->assign('sku_parm',$sku_parm);
        $this->assign('sku_parm_value',$_arr);
        $this->assign('sku',$sku);
        //查询常用的sku名
        $sku_default = $sku_parm;
        $this->assign('sku_default',$sku_default);        
        return view();
    }
    public function sku_list_value(){
        return view();
    }
    public function sku_add(){
        $data = input('post.');
        $data['_gid'] = 0;
        $data['uid'] = session('admin')['id'];
        if($data['sku_name']=='' || $data['sku_value']==''){
            return jserror('不能为空');
        }
        //判断是否重复提交
        if(Db::name('product_sku')->field('id')->where(['gid'=>$data['gid'],'uid'=>$data['uid'],'sku_name'=>$data['sku_name'],'sku_value'=>$data['sku_value']])->find()){
            return jserror('请勿重复提交');
        }
        $res = Db::name('product_sku')->insert($data);
        if($res){            
            return jssuccess('ok');
        }else{
            return jserror('保存失败');
        }
    }
    public function sku_del(){
        $data = input('post.');
        $data['uid'] = session('admin')['id'];
        
        //判断是否重复提交
        if(!Db::name('product_sku')->field('id')->where(['gid'=>$data['gid'],'uid'=>$data['uid'],'sku_value'=>$data['sku_value']])->find()){
            return jserror('不存在');
        }
        $res = Db::name('product_sku')->where($data)->update(['status'=>9]);
        if($res){            
            return jssuccess('ok');
        }else{
            return jserror('删除失败');
        }
    }
    //提交商品规格详情
    public function product_sku_parm_edit(){
        $data = input('post.');
        $_parm = $data['parm'];
        //提交主要信息
        $num = count($data['pic']);
        $parm_num = count($_parm);
        try {
            Db::startTrans();
            //判断是否存在,存在则删除
            if(Db::name('product_sku_info')->where(['gid'=>$data['gid']])->find()){
                Db::name('product_sku_info')->where(['gid'=>$data['gid']])->update(['status'=>9]);
            }
            if(Db::name('product_sku_info_parm')->where(['gid'=>$data['gid']])->find()){
                Db::name('product_sku_info_parm')->where(['gid'=>$data['gid']])->update(['status'=>9]);
            }
            for($i=0;$i<$num;$i++){
                $_info['gid'] = $data['gid'];
                $_info['pic'] = $data['pic'][$i];
                $_info['code'] = $data['code'][$i];
                $_info['price'] = $data['price'][$i];
                $_info['price_line'] = $data['price_line'][$i];
                $_info['stock'] = $data['stock'][$i];
                $_info['kg'] = $data['kg'][$i];
                $_info['uid'] = session('admin')['id'];
                //插入数据库,获得info_id
                $info_id = Db::name('product_sku_info')->insertGetId($_info);
                for($t=0;$t<$parm_num;$t++){
                    $_parm_data['info_id'] = $info_id;
                    $_parm_data['sku_id'] = $data['parm'][$t][$i];
                    $_parm_data['gid'] = $data['gid'];
                    $_parm_data['uid'] = session('admin')['id'];
                    //插入数据库
                    Db::name('product_sku_info_parm')->insert($_parm_data);
                }
            }
            Db::commit();               
           return jssuccess('提交成功');
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return jserror('失败');
        }

    }
    // 内容修改
    public function product_edit()
    {
        if(request()->isGet()){
            $res = Db::name('post')->where(['id'=>input('id')])->find();
            $this->assign("res",$res);

            $cate_where[] = ['status','=',1];
            $cate_where = array_merge($cate_where,$this->common_select_tag);
            $mlist = Db::name('product_cate')->where($cate_where)->order("cid asc")->select();
            $this->assign("mlist",$mlist);

            return view();
        } 
        if(request()->isPost()){
            $data = input('post.');
            if(isset($data['relevan_id'])){
                unset($data['keyword']);
            }
            if(isset($data['album_list']) && is_array($data['album_list'])){
                $data['album'] = implode(",", $data['album_list']);
                unset($data['album_list']);
            }
            if($data['ctime']!=''){
                $data['ctime'] =  strtotime($data['ctime']);
            }else{
                $data['ctime'] =  time();
            }
            $res =  Db::name('post')->where(['id'=>$data['id']])->update($data); 
            if($res)
            {
                 return jssuccess('修改成功');
            }else{
                  return jserror('修改失败');
            }   
        } 
    }
    public function cate(){
        $where[] = ['status','<>',9];
        $where = array_merge($where,$this->common_select_tag);
        $list = Db::name('product_cate')->where($where)->order("cid asc")->select();
        $this->assign("list",$list);
        return view();
    }
    public function cate_add()
    {
        if(request()->isPost()){ 
            $data = input('post.');
            if($data['name']==''){
                return jserror('请填写信息');exit;
            }
            $data = array_merge($data,$this->common_tag);
            $res =Db::name('product_cate')->insert($data);
            if($res){
                return jssuccess('新增成功');
            }else{
                return jserror('新增失败');exit;
            } 
        }  
        return view();   
    }
    //修改
    public function cate_edit()
    {
        if(request()->isPost()){
            $data = input('post.');
            $res =  Db::name('product_cate')->where(['cid'=>$data['cid']])->update($data);
            if($res){
                return jssuccess('修改成功');
            }else{
                return jserror('修改失败');
            }   
        } 
        $res = Db::name('product_cate')->where(['cid'=>input('cid')])->find();
        $this->assign("res",$res);
        return view();
    }

    public function order()
    {
        $where = "status!=9 ";
        if(input("get.order_sn")){
            $order_sn = input("get.order_sn");
            $where .= " and order_sn like '%$order_sn%' ";
        }
        $list = Db::name('order')->where($where)->order("id desc")->paginate(10);
        $this->assign('list',$list);
        $this->assign('page', $list->render());
        return view();
    }
    public function chanage_switch()
    {
        $data = input("");
        $is_show = input('status');
        $id = input('id');
        
        $res = db('order')->where('id', $id)->update([$data['field'] => $is_show]);      
        if($data['field']=='pay_status'){
            db('order_goods')->where('oid', $id)->update([$data['field'] => $is_show]);      
        }      
        if($res){
            return jssuccess('更新成功');
        }else{
            return jserror('更新失败');
        }
    }
    //订单详情
    public function order_detail(){
        if(request()->isPost()){
            $data = input('post.');
            //改变发货状态
            if($data['kd_company']!='' && $data['kd_code']!='' ){
                $data['fh_status'] = 1;
            }
            
            $res =  Db::name('order')->where(['id'=>$data['id']])->update($data);;

            if($res)
            {
              return jssuccess('更新');
            }else{
              return jserror('失败');
            }   
        } 

        $id = input("id");
        $res = db('order')->where('id', $id)->find();            
        $this->assign('res',$res);
        return view();        
    }
    // public function category_model_add()
    // {
    //     if(!request()->isPost()){ 
    //         return view();   
    //     }  
    //     $res = (new categoryModModel())->add(input('post.'));
    //     if($res['valid'])
    //     {
    //         return jssuccess($res['msg']);
    //     }else{
    //         return jserror($res['msg']);exit;
    //     } 
    // }
    //修改
    public function order_edit()
    {
        if(request()->isPost()){
            $res = Db::name('category_model')->where('id='.input('post.id'))->update(input('post.'));
            if($res){
                return jssuccess('ok');
            }else{
                return jserror('error');
            }   
        } 
        $id = input("id");
        $res = Db::name('category_model')->where('id='.$id)->find();
        $this->assign("res",$res);
        return view();
    }

    
    
}
