<?php
namespace app\admin\controller;
use Wmc1125\Mctoolsdk\Category as cat; 
use think\Db;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Wmc1125\Mctoolsdk\GetImgSrc; 
 
class Category extends Admin
{
    public function __construct (){
        parent::__construct();
    }
    public function index()
    {
        admin_role_check($this->z_role_list,$this->mca);
        $res = Db::name('category')->field('cid,pid,name,cname,icon,tpl_category,tpl_post,mid,sort,status,menu')->where('status!=9')->order("sort asc,cid asc")->select();
        $cat = new cat(array('cid', 'pid', 'name', 'cname')); //初始化无限分类
        $list = $cat->getTree($res); //获取分类数据树结构
        if(!$list){
            $list = [];
        }
        $this->assign("list",$list);
        $mlist = Db::name('category_model')->where(['status'=>1])->order("id asc")->select();
        if(!$mlist){
            $mlist = [];
        }
        $this->assign("mlist",$mlist);
    	return view();
    }
    //增加栏目
    public function category_add()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        $data = input('post.');
        $data['ctime'] = time();
        if($data['name']==''){
            return jserror('栏目名不能为空');exit;
        }
        $data = array_merge($data,$this->common_tag);
        $res = Db::name('category')->insert($data);
        if($res){
            return jssuccess('新增成功');
        }else{
            return jserror('新增失败');exit;
        } 
    }
    //修改栏目
    public function category_edit()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if(request()->isGet()){
            $res =Db::name('category')->where(['cid'=>input('cid')])->find();
            $this->assign("t",0);
            $this->assign("res",$res);
            $res = Db::name('category')->where('status!=9')->select();
            $cat = new cat(array('cid', 'pid', 'name', 'cname')); //初始化无限分类
            $plist = $cat->getTree($res); //获取分类数据树结构
            if(!$plist){
                $plist = [];
            }
            $this->assign("plist",$plist);
            $mlist = Db::name('category_model')->where(['status'=>1])->select();
            if(!$mlist){
                $mlist = [];
            }
            $this->assign("mlist",$mlist);
            return view();
        }
        if(request()->isAjax()){
            $data = input('post.');
            if($data['t']==1){
                $msg['code'] = 1;
            }else{
                $msg['code']=0;
            }
            unset($data['t']);
            // dd($data);
            $res = Db::name('category')->where(['cid'=>$data['cid']])->update($data);
            if($res){
                $msg['msg'] = '修改成功';
                return jssuccess($msg);
            }else{
                $msg['msg'] = '修改成功';
                return jserror($msg);
            }   
        }
    }

    //模型列表
    public function category_model()
    {
        admin_role_check($this->z_role_list,$this->mca);
         //读取
        $list = Db::name('category_model')->where('status!=9')->order("id asc")->select();
        $this->assign("list",$list);
        return view();

    }
    
    
     //增加
    public function category_model_add()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if(request()->isPost()){ 
            $data = input('post.');
            if($data['name']=='' || $data['model']==''){
                return jserror('请填写信息');exit;
            }
            $data = array_merge($data,$this->common_tag);
            $res =Db::name('category_model')->insert($data);
            if($res){
                return jssuccess('新增成功');
            }else{
                return jserror('新增失败');exit;
            } 
        }  
        return view();   
    }
    //修改
    public function category_model_edit()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if(request()->isPost()){
            $data = input('post.');
            $res =  Db::name('category_model')->where(['id'=>$data['id']])->update($data);
            if($res){
                return jssuccess('修改成功');
            }else{
                return jserror('修改失败');
            }   
        } 
        $res = Db::name('category_model')->where(['id'=>input('id')])->find();
        $this->assign("res",$res);
        return view();
    }

    // 根据mid跳转相应页面
    public function post_list()
    {
        admin_role_check($this->z_role_list,$this->mca);
        // 栏目id
        $cid = input('cid');
        $mid = input('mid');
        $t = input('t',0);
        $this->assign('t',$t);

        if(!$mid){
            die("模型未选择");
        }
        //查询该模型是否开启
        $m_res =  Db::name('category_model')->where(['id'=>$mid])->find();
        $this->assign("cid",$cid);

        if(!$m_res || $m_res['status']==0){
            die("该模型未找到或该模型未开启");
        }
        //如果是单页,加载编辑页面
        if($mid==1){
            $this->assign("m_res",$m_res);

            $pres =Db::name('category')->where(['status'=>1])->select();
            $cat = new cat(array('cid', 'pid', 'name', 'cname')); //初始化无限分类
            $plist = $cat->getTree($pres); //获取分类数据树结构
            if(!$plist){
                $plist = [];
            }
            $this->assign("plist",$plist);
            $mlist =  Db::name('category_model')->where(['status'=>1])->select();
            if(!$mlist){
                $mlist = [];
            }
            $this->assign("mlist",$mlist);
            $res = Db::name('category')->where(['cid'=>$cid])->find();
            $this->assign("res",$res);
            return view('category/category_edit');
        }else{
            //如果是内容页,加载列表页
            $tpl = 'category/'.$m_res['model'].'/index';
            $where = "status!=9 and cid=".$cid;
            if(input("get.title")){
                $title = input("get.title");
                $where .= " and title like '%$title%' ";
            }
            $list = Db::name('post')->where($where)->order("id desc")->paginate(6);
            if(!$list){
                $List = [];
            }
            $page = $list->render();
            $this->assign("list",$list);
            $this->assign("page",$page);
            $res =  Db::name('category')->where(['cid'=>$cid])->find();
            $this->assign("res",$res);
            $this->assign("mid",$mid);
            return view($tpl);
        }
    }
    // 内容列表(主页面)
    public function post_all_list()
    {
        admin_role_check($this->z_role_list,$this->mca);
         if(!request()->isPost()){ 
            $data =Db::name('category')->where(['status'=>1])->select();
            $cat = new cat(array('cid', 'pid', 'name', 'cname','mid')); //初始化无限分类
            $pro_menu_list = $cat->getTree($data); //获取分类数据树结构
            $this->assign('pro_menu_list', $pro_menu_list);
            return view();   
        }  

    }
    // 内容增加
    public function post_add()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if(request()->isGet()){
            $cid = input("cid");
            $mid = input("mid");
            $m_res =Db::name('category_model')->field('model,is_two')->where(['id'=>$mid])->find();
            $tpl = 'category/zf_tpl/add';
            $this->assign('cid',$cid);
            $this->assign('mid',$mid);
            $m_list =Db::name('category_model_parm')->where(['mid'=>$mid,'status'=>1])->order('sort asc,id asc')->select();
            $this->assign('m_list',$m_list);
            $this->assign('m_res',$m_res);
            return view($tpl);
        } 
        if(request()->isPost()){
            $data = input('post.');
            $data = array_merge($data,$this->common_tag);
            if($data['ctime']!=''){
                $data['ctime'] =  strtotime($data['ctime']);
            }else{
                $data['ctime'] =  time();
            }
            if($data['pic']==''){
                $data['pic'] = GetImgSrc::src($data['content'], 1);
            }
            
            if(isset($data['relevan_id'])){
                unset($data['keyword']);
            }
            $key_list = array_keys($data);
            $_temp_list = [];
            foreach($key_list as $k=>$vo){
                if(strpos($vo,'zf_list_') === 0){
                    $_temp_list[] = $vo;  
                }
            }
            if($_temp_list){
                foreach($_temp_list as $k=>$vo){
                    if(isset($data[$vo]) && is_array($data[$vo])){
                        $data[explode('zf_list_',$vo)[1]] = implode(",", $data[$vo]);
                        unset($data[$vo]);
                    }
                }
            }else{
                //查询字段
                $mid = Db::name('post p')
                    ->where(['p.id'=>$data['id']])
                    ->join('zf_category c','c.cid = p.cid')
                    ->value('c.mid');
                $tb_parm_list = Db::name('category_model_parm')->where([['status','<>',9],['is_multi','=',1],['mid','=',$mid]])->order("position asc,sort asc, id asc")->select();
                // 判断是否含有该字段,没有则为空
                foreach($tb_parm_list as $k=>$vo){
                    if(!$data[$vo['name']]){
                        $data[$vo['key']] = '';
                    }
                }

            }
            $res = Db::name('post')->insertGetId($data);
            // $this->get_content_pic_list($res);
            if($res){
                 return jssuccess('新增成功');
            }else{
                return jserror('新增失败');
            }   
        } 
    }
    // 内容修改
    public function post_edit()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if(request()->isGet()){
            $data_res = Db::name('post')->where(['id'=>input('id')])->find();
            $this->assign("data_res",$data_res);
            $cid = input("cid",$data_res['cid']);
            $mid = input("mid",'14');
            // if($mid==0){
            //     $mid = Db::name('category')->where(['cid'=>$cid])->value('mid');
            // }
            // $this->assign("cid",$cid);
            // $m_res =  Db::name('category_model')->where(['id'=>$mid])->find();;
            // $tpl = 'category/'.$m_res['model'].'/edit';
            $m_res =Db::name('category_model')->field('model,is_two')->where(['id'=>$mid])->find();
            $tpl = 'category/zf_tpl/add';
            $this->assign('cid',$cid);
            $this->assign('mid',$mid);
            $m_list =Db::name('category_model_parm')->where(['mid'=>$mid,'status'=>1])->order('sort asc,id asc')->select();
            $this->assign('m_list',$m_list);
            $this->assign('m_res',$m_res);
            return view($tpl);
        } 
        if(request()->isPost()){
            $data = input('post.');
            if($data['ctime']!=''){
                $data['ctime'] =  strtotime($data['ctime']);
            }else{
                $data['ctime'] =  time();
            }
            if($data['pic']==''){
                $data['pic'] = GetImgSrc::src($data['content'], 1);
            }
            
            if(isset($data['relevan_id'])){
                unset($data['keyword']);
            }
            $key_list = array_keys($data);
            $_temp_list = [];
            foreach($key_list as $k=>$vo){
                if(strpos($vo,'zf_list_') === 0){
                    $_temp_list[] = $vo;  
                }
            }
            if($_temp_list){
                foreach($_temp_list as $k=>$vo){
                    if(isset($data[$vo]) && is_array($data[$vo])){
                        $data[explode('zf_list_',$vo)[1]] = implode(",", $data[$vo]);
                        unset($data[$vo]);
                    }
                }
            }else{
                //查询字段
                $mid = Db::name('post p')
                    ->where(['p.id'=>$data['id']])
                    ->join('zf_category c','c.cid = p.cid')
                    ->value('c.mid');
                $tb_parm_list = Db::name('category_model_parm')->where([['status','<>',9],['is_multi','=',1],['mid','=',$mid]])->order("position asc,sort asc, id asc")->select();
                // 判断是否含有该字段,没有则为空
                foreach($tb_parm_list as $k=>$vo){
                    if(!$data[$vo['name']]){
                        $data[$vo['key']] = '';
                    }
                }

            }
            
            // dd($data);
            $res =  Db::name('post')->where(['id'=>$data['id']])->update($data); 
            if($res)
            {
                 return jssuccess('修改成功');
            }else{
                  return jserror('修改失败');
            }   
        } 
    }
    // 导入内容
    public function import(){
        admin_role_check($this->z_role_list,$this->mca);
        $cid = input("cid");
        //获取表格的大小，限制上传表格的大小5M
        $file_size = $_FILES['file']['size'];
        if ($file_size > 5 * 1024 * 1024) {
            $this->error('文件大小不能超过5M');
            exit();
        }
        //限制上传表格类型
        $fileExtendName = substr(strrchr($_FILES['file']["name"], '.'), 1);
        //application/vnd.ms-excel  为xls文件类型
        if ($fileExtendName == 'csv') {
            $this->error('须为xls或xlsx格式,不能是csv格式！');
            exit();
        }
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {
            if ($fileExtendName =='xlsx') {
                $objReader = IOFactory::createReader('Xlsx');
                $filename = $_FILES['file']['tmp_name'];
            }elseif ($fileExtendName =='xls') {
                $objReader = IOFactory::createReader('Xls');
                $filename = $_FILES['file']['tmp_name'];
            }elseif ($fileExtendName=='csv') {
                $objReader = IOFactory::createReader('Csv');
                $filename = $_FILES['file']['tmp_name'];
            }
            $objPHPExcel = $objReader->load($filename,$encode = 'utf-8');  //$filename可以是上传的表格，或者是指定的表格
            $sheet = $objPHPExcel->getSheet(0);   //excel中的第一张sheet
            $highestRow = $sheet->getHighestRow();       // 取得总行数
            //定义$usersExits，循环表格的时候，找出已存在的。
            $usersExits = [];
            //循环读取excel表格，整合成数组。如果是不指定key的二维，就用$data[i][j]表示。
            for ($j = 2; $j <= $highestRow; $j++) {
                $data[$j - 2] = [
                    'title' => $objPHPExcel->getActiveSheet()->getCell("A" . $j)->getValue(),
                    'append' => $objPHPExcel->getActiveSheet()->getCell("B" . $j)->getValue(),
                    'cid' => $cid,
                    'ctime' => time()
                ];
                // 看下用户名是否存在。将存在的用户名保存在数组里。
                $userExist = db('post')->where(['title'=>$data[$j - 2]['title'],'append'=>$data[$j-2]['append']])->find();
                if ($userExist) {
                    unset($data[$j-2]);
                }
            }
            //如果有已存在的用户名，就不插入数据库了。
            // if ($usersExits != []) {
            //     //把数组变成字符串，向前端输出。
            //     $c = implode(" / ", $usersExits);
            // }else{
            //     $c = "无";
            // }
            //插入数据库
            $res = db('post')->insertAll($data);
            if ($res) {
                return jssuccess("导入成功!!");
            }else{
                  return jserror("error");
            }
        }

    }
    public function search_post(){
        admin_role_check($this->z_role_list,$this->mca);
        $kwd = input('key','');
        // dd($kwd);
        $where[] = ['status','=',1];
        $where[] = ['relevan_id','=',0];
        if($kwd!='all'){
            $where[] = ['title','like','%'.$kwd.'%'];
        }
        $list =  Db::name('post')->where($where)->order('id desc')->select();
        if($list){
            return jssuccess($list);
        }else{
            return jserror('error');
        }
    }
    public function get_content_pic_list($id){
        admin_role_check($this->z_role_list,$this->mca);
        $id = input('id',$id);
        $content = Db::name('post')->where(['id'=>$id])->value('content');
        for($i=1;$i<=100;$i++){
            $parm_list_src[$i]['pid'] = $id;
            $parm_list_src[$i]['ctime'] = time() ;
            $parm_list_src[$i]['status'] = 1;
            $parm_list_src[$i]['pic'] = GetImgSrc::src($content, $i);  
            if(empty($parm_list_src[$i]['pic'])){
              unset($parm_list_src[$i]);
              break;
            }
        }
        foreach($parm_list_src as $k=>$vo){
            $_is = Db::name('post_parm_pic')->where(['pic'=>$vo['pic'],'pid'=>$vo['pid']])->value('id');
            if(!$_is){
                Db::name('post_parm_pic')->insert($vo);
            }
        }
        return jssuccess('已保存');

    }
    /**
     *模型的参数列表
     */
    public function category_model_parm()
    {
        admin_role_check($this->z_role_list,$this->mca);
        $all_list = Db::query("SHOW FULL COLUMNS FROM zf_post");
        $this->assign("all_list",$all_list);
        
         //读取
        $mid = input('mid',0);
        $where[] = ['status','<>',9];
        $where[] = ['mid','=',$mid];
        $list = Db::name('category_model_parm')->where($where)->order("position asc,sort asc, id asc")->select();
        $this->assign("list",$list);
        $this->assign("mid",$mid);
        $key_list = $all_list;
        foreach($key_list as $k1=>$vo1){
            foreach($list as $k2=>$vo2){
                if($vo2['key']==$vo1['Field'] || $vo1['Field']=='id'){
                    unset($key_list[$k1]);
                }
            }
        }
        $this->assign("key_list",$key_list);

        return view();

    }
     //增加
     public function category_model_parm_add()
     {
         admin_role_check($this->z_role_list,$this->mca,1);
         if(request()->isPost()){ 
             $data = input('post.');
             if($data['name']==''){
                 return jserror('请填写信息');exit;
             }
             //判断是否存在
             $where[] = ['status','<>',9];
             $where[] = ['mid','=',$data['mid']];
             $where[] = ['key','=',$data['key']];
             $is_res =Db::name('category_model_parm')->where($where)->find();
             if($is_res){
                return jserror('该字段已存在');exit;
             }

             $data = array_merge($data,$this->common_tag);
             $res =Db::name('category_model_parm')->insert($data);
             if($res){
                 return jssuccess('新增成功');
             }else{
                 return jserror('新增失败');exit;
             } 
         }  
         return view();   
     }
     //修改
     public function category_model_parm_edit()
     {
         admin_role_check($this->z_role_list,$this->mca,1);
         if(request()->isPost()){
            $data = input('post.');
            $res =  Db::name('category_model_parm')->where(['id'=>$data['id']])->update($data);
            if($res){
                return jssuccess('修改成功');
            }else{
                return jserror('修改失败');
            }   
         } 
         $res = Db::name('category_model_parm')->where(['id'=>input('id')])->find();
         $this->assign("res",$res);
         return view();
     }
    
    
}
