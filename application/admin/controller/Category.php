<?php
// +----------------------------------------------------------------------
// | 子枫后台管理系统(TpFast系列)[基于ThinkPHP5.1开发]
// +----------------------------------------------------------------------
// | Copyright (c)  http://v1.fast.zf.90ckm.com/
// | 子枫后台管理系统提供免费使用,可使用此框架进行二次开发
// +----------------------------------------------------------------------
// | Author: 子枫 <287851074@qq.com>
// +----------------------------------------------------------------------
// | github:https://github.com/wmc1125/zfAdmin_tpfast
// | 码云:  https://gitee.com/wmc1125/zfAdmin_tpfast
// | Mc技术论坛: http://bbs.wangmingchang.com/forum.php?mod=forumdisplay&fid=77
// +----------------------------------------------------------------------
namespace app\admin\controller;
use Wmc1125\TpFast\Category as cat; 
use think\Db;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Wmc1125\TpFast\GetImgSrc; 
  
class Category extends Admin
{
    public function __construct (){
        parent::__construct();
        $form_widget = new \app\common\widget\Form();
        $this->assign('form_widget',$form_widget);
    }
 
    /**
     * @Notes:栏目列表
     * @Interface index
     * @return \think\response\View
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author: 子枫
     * @Time: 2019/11/13   10:28 下午
     */
    public function index()
    {
        admin_role_check($this->z_role_list,$this->mca);
        $pid =input('pid','0');
        $where[] = ['status','<>',9];
        // if($pid!='0'){
        //     $where[] = ['pid','=' ,$pid];
        // }
        // $pid = 0;
        $res = ZFTB('category')->field('cid,pid,name,cname,icon,tpl_category,tpl_post,mid,sort,status,menu')->where($where)->order("sort asc,cid asc")->select();
        $cat = new cat(array('cid', 'pid', 'name', 'cname')); //初始化无限分类
        $list = $cat->getTree($res,$pid); //获取分类数据树结构
        if(!$list){
            $list = [];
        }
        $this->assign("list",$list);
        $mlist = ZFTB('category_model')->where(['status'=>1])->order("id asc")->select();
        if(!$mlist){
            $mlist = [];
        }
        $this->assign("mlist",$mlist);
        $this->assign("pid",$pid);
    	return view();
    }

    /**
     * @Notes:增加栏目
     * @Interface category_add
     * @author: 子枫
     * @Time: 2019/11/13   10:32 下午
     */
    public function category_add()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        $data = input('post.');
        $data['ctime'] = time();
        if($data['name']==''){
            return jserror('栏目名不能为空');exit;
        }
        $data = array_merge($data,$this->common_tag);
        $res = ZFTB('category')->insert($data);
        return ZFRetMsg($res,'新增成功','新增失败');
    }

    /**
     * @Notes:修改栏目
     * @Interface category_edit
     * @return \think\response\View|void
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     * @author: 子枫
     * @Time: 2019/11/13   10:32 下午
     */
    public function category_edit()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if(request()->isGet()){
            $res =ZFTB('category')->where(['cid'=>input('cid')])->find();
            $this->assign("t",0);
            $this->assign("res",$res);
            $res = ZFTB('category')->where([['status','<>',9]])->select();
            $cat = new cat(array('cid', 'pid', 'name', 'cname')); //初始化无限分类
            $plist = $cat->getTree($res); //获取分类数据树结构
            if(!$plist){
                $plist = [];
            }
            $this->assign("plist",$plist);
            $mlist = ZFTB('category_model')->where(['status'=>1])->select();
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
            $res = ZFTB('category')->where(['cid'=>$data['cid']])->update($data);
            return ZFRetMsg($res,['msg'=>'修改成功'],['msg'=>'修改失败']);

        }
    }

    /**
     * @Notes:模型列表
     * @Interface category_model
     * @return \think\response\View
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author: 子枫
     * @Time: 2019/11/13   10:33 下午
     */
    public function category_model()
    {
        admin_role_check($this->z_role_list,$this->mca);
         //读取
        $list = ZFTB('category_model')->where([['status','<>',9]])->order("id asc")->select();
        $this->assign("list",$list);
        return view();

    }


    /**
     * @Notes:模型列表-增加
     * @Interface category_model_add
     * @return \think\response\View|void
     * @author: 子枫
     * @Time: 2019/11/13   10:33 下午
     */
    public function category_model_add()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if(request()->isPost()){ 
            $data = input('post.');
            if($data['name']=='' || $data['model']==''){
                return jserror('请填写信息');exit;
            }
            $data = array_merge($data,$this->common_tag);
            $res =ZFTB('category_model')->insert($data);
            return ZFRetMsg($res,'新增成功','新增失败');
        }  
        return view();   
    }

    /**
     * @Notes:模型列表-修改
     * @Interface category_model_edit
     * @return \think\response\View|void
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     * @author: 子枫
     * @Time: 2019/11/13   10:33 下午
     */
    public function category_model_edit()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if(request()->isPost()){
            $data = input('post.');
            $res =  ZFTB('category_model')->where(['id'=>$data['id']])->update($data);
            return ZFRetMsg($res,'修改成功','修改失败');
              
        } 
        $res = ZFTB('category_model')->where(['id'=>input('id')])->find();
        $this->assign("res",$res);
        return view();
    }

    /**
     * @Notes:根据mid跳转相应页面
     * @Interface post_list
     * @return \think\response\View
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author: 子枫
     * @Time: 2019/11/13   10:34 下午
     */
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
        $m_res =  ZFTB('category_model')->where(['id'=>$mid])->find();
        $this->assign("cid",$cid);

        if(!$m_res || $m_res['status']==0){
            die("该模型未找到或该模型未开启");
        }
        //如果是单页,加载编辑页面
        if($mid==1){
            $this->assign("m_res",$m_res);
            $pres =ZFTB('category')->where(['status'=>1])->select();
            $cat = new cat(array('cid', 'pid', 'name', 'cname')); //初始化无限分类
            $plist = $cat->getTree($pres); //获取分类数据树结构
            if(!$plist){
                $plist = [];
            }
            $this->assign("plist",$plist);
            $mlist =  ZFTB('category_model')->where(['status'=>1])->select();
            if(!$mlist){
                $mlist = [];
            }
            $this->assign("mlist",$mlist);
            $res = ZFTB('category')->where(['cid'=>$cid])->find();
            $this->assign("res",$res);
            return view('category/category_edit');
        }else{
            //如果是内容页,加载列表页
            $where = "status!=9 and cid=".$cid;
            if(input("get.title")){
                $title = input("get.title");
                $where .= " and title like '%$title%' ";
            }
            $list = ZFTB('post')->where($where)->order("id desc")->paginate(6);
            if(!$list){
                $list = [];
            }
            $page = $list->render();
            $this->assign("list",$list);
            $this->assign("page",$page);
            $res =  ZFTB('category')->where(['cid'=>$cid])->find();
            $this->assign("res",$res);
            $this->assign("mid",$mid);

            if($m_res['is_parm']==1){
                $tpl = 'category/zf_tpl/list_'.$m_res['model'];
            }else{
                $tpl = 'category/'.$m_res['model'].'/index';
            }
            return view($tpl);
        }
    }

    /**
     * @Notes:内容列表(主页面)
     * @Interface post_all_list
     * @return \think\response\View
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author: 子枫
     * @Time: 2019/11/13   10:34 下午
     */
    public function post_all_list()
    {
        admin_role_check($this->z_role_list,$this->mca);
         if(!request()->isPost()){ 
            $data =ZFTB('category')->where(['status'=>1])->select();
            $cat = new cat(array('cid', 'pid', 'name', 'cname','mid')); //初始化无限分类
            $pro_menu_list = $cat->getTree($data); //获取分类数据树结构
            $this->assign('pro_menu_list', $pro_menu_list);
            return view();   
        }  

    }

    /**
     * @Notes:内容增加
     * @Interface post_add
     * @return \think\response\View|void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author: 子枫
     * @Time: 2019/11/13   10:35 下午
     */
    public function post_add()
    {
        admin_role_check($this->z_role_list,$this->mca,1);
            
        if(request()->isPost()){
            $data = input('post.');
            if($data['id']!=''){
                //编辑
                if(isset($data['ctime']) && $data['ctime']!=''){
                    $data['ctime'] =  strtotime($data['ctime']);
                }else{
                    $data['ctime'] =  time();
                }
                if(isset($data['pic']) && $data['pic']=='' && isset($data['content'])){
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
                    $mid = ZFTB('post p')
                        ->where(['p.id'=>$data['id']])
                        ->join(ZFJoinStrLang('category c'),'c.cid = p.cid')
                        ->value('c.mid');
                    $tb_parm_list = ZFTB('category_model_parm')->where([['status','<>',9],['is_multi','=',1],['mid','=',$mid]])->order("position asc,sort asc, id asc")->select();
                    // 判断是否含有该字段,没有则为空
                    foreach($tb_parm_list as $k=>$vo){
                        if(!isset($data[$vo['key']])){
                            $data[$vo['key']] = '';
                        }
                    }
                }
                $res =  ZFTB('post')->where(['id'=>$data['id']])->update($data);
                return ZFRetMsg($res,'修改成功','修改失败');  
            }else{
                $data = array_merge($data,$this->common_tag);
                if(isset($data['ctime']) && $data['ctime']!=''){
                    $data['ctime'] =  strtotime($data['ctime']);
                }else{
                    $data['ctime'] =  time();
                }
                if(isset($data['pic']) && $data['pic']=='' && isset($data['content'])){
                    $data['pic'] = GetImgSrc::src($data['content'], 1);
                }
                // 关联
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
                }elseif(count($_temp_list)==0){
                    //数组为空,不做操作
                }else{
                    //查询字段
                    $mid = ZFTB('post p')
                        ->where(['p.id'=>$data['id']])
                        ->join(ZFJoinStrLang('category c'),'c.cid = p.cid')
                        ->value('c.mid');
                    $tb_parm_list = ZFTB('category_model_parm')->where([['status','<>',9],['is_multi','=',1],['mid','=',$mid]])->order("position asc,sort asc, id asc")->select();
                    // 判断是否含有该字段,没有则为空
                    foreach($tb_parm_list as $k=>$vo){
                        if(!$data[$vo['name']]){
                            $data[$vo['key']] = '';
                        }
                    }
                }
                $res = ZFTB('post')->insertGetId($data);
                return ZFRetMsg($res,'新增成功','新增失败'); 

            }
            
        } 



        $cid = input("cid",'');
        $mid = ZFTB('category')->where(['cid'=>$cid])->value('mid');
        $id = input("id",'');
        if($id!=''){
            //编辑
            $data_res = ZFTB('post')->where(['id'=>input('id')])->find();
            $this->assign("data_res",$data_res);
            $cid = input("cid",$data_res['cid']);
            $mid = input("mid",'14');
            $this->assign("act",'edit');
        }else{
            $this->assign("act",'add');
            $this->assign("data_res",[]);
        }
        $m_res =ZFTB('category_model')->field('model,is_two,is_parm')->where(['id'=>$mid])->find();
        if($m_res['is_parm']==1){
            $tpl = 'category/zf_tpl/add';
            $this->assign('cid',$cid);
            $this->assign('mid',$mid);
            $m_list =ZFTB('category_model_parm')->where(['mid'=>$mid,'status'=>1])->order('sort asc,id asc')->select();
            $this->assign('m_list',$m_list);
            $this->assign('m_res',$m_res);
        }else{
            $tpl = 'category/'.$m_res['model'].'/add';
            $this->assign('cid',$cid);
            $this->assign('mid',$mid);
            $this->assign('m_res',$m_res);
        }

        
        // if($mid==0){
        //     $mid = ZFTB('category')->where(['cid'=>$cid])->value('mid');
        // }
        // $this->assign("cid",$cid);
        // $m_res =  ZFTB('category_model')->where(['id'=>$mid])->find();;
        // $tpl = 'category/'.$m_res['model'].'/edit';
       


        return view($tpl);



    }

    /**
     * @Notes:内容修改
     * @Interface post_edit
     * @return \think\response\View|void
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     * @author: 子枫
     * @Time: 2019/11/13   10:35 下午
     */
    // public function post_edit()
    // {
    //     admin_role_check($this->z_role_list,$this->mca,1);
    //     if(request()->isGet()){
    //         $data_res = ZFTB('post')->where(['id'=>input('id')])->find();
    //         $this->assign("data_res",$data_res);
    //         $cid = input("cid",$data_res['cid']);
    //         $mid = input("mid",'14');
    //         // if($mid==0){
    //         //     $mid = ZFTB('category')->where(['cid'=>$cid])->value('mid');
    //         // }
    //         // $this->assign("cid",$cid);
    //         // $m_res =  ZFTB('category_model')->where(['id'=>$mid])->find();;
    //         // $tpl = 'category/'.$m_res['model'].'/edit';
    //         $m_res =ZFTB('category_model')->field('model,is_two,is_parm')->where(['id'=>$mid])->find();
    //         if($m_res['is_parm']==1){
    //             $tpl = 'category/zf_tpl/add';
    //             $this->assign('cid',$cid);
    //             $this->assign('mid',$mid);
    //             $m_list =ZFTB('category_model_parm')->where(['mid'=>$mid,'status'=>1])->order('sort asc,id asc')->select();
    //             $this->assign('m_list',$m_list);
    //             $this->assign('m_res',$m_res);
    //         }else{
    //             $tpl = 'category/'.$m_res['model'].'/edit';
    //             $this->assign('cid',$cid);
    //             $this->assign('mid',$mid);
    //             $this->assign('m_res',$m_res);
    //         }

    //         return view($tpl);
    //     } 
    //     if(request()->isPost()){
    //         $data = input('post.');
    //         if(isset($data['ctime']) && $data['ctime']!=''){
    //             $data['ctime'] =  strtotime($data['ctime']);
    //         }else{
    //             $data['ctime'] =  time();
    //         }
    //         if(isset($data['pic']) && $data['pic']=='' && isset($data['content'])){
    //             $data['pic'] = GetImgSrc::src($data['content'], 1);
    //         }
            
    //         if(isset($data['relevan_id'])){
    //             unset($data['keyword']);
    //         }
    //         $key_list = array_keys($data);
    //         $_temp_list = [];
    //         foreach($key_list as $k=>$vo){
    //             if(strpos($vo,'zf_list_') === 0){
    //                 $_temp_list[] = $vo;  
    //             }
    //         }
    //         if($_temp_list){
    //             foreach($_temp_list as $k=>$vo){
    //                 if(isset($data[$vo]) && is_array($data[$vo])){
    //                     $data[explode('zf_list_',$vo)[1]] = implode(",", $data[$vo]);
    //                     unset($data[$vo]);
    //                 }
    //             }
    //         }else{
    //             //查询字段
    //             $mid = ZFTB('post p')
    //                 ->where(['p.id'=>$data['id']])
    //                 ->join(ZFJoinStrLang('category c'),'c.cid = p.cid')
    //                 ->value('c.mid');
    //             $tb_parm_list = ZFTB('category_model_parm')->where([['status','<>',9],['is_multi','=',1],['mid','=',$mid]])->order("position asc,sort asc, id asc")->select();
    //             // 判断是否含有该字段,没有则为空
    //             foreach($tb_parm_list as $k=>$vo){
    //                 if(!isset($data[$vo['key']])){
    //                     $data[$vo['key']] = '';
    //                 }
    //             }

    //         }
            
    //         $res =  ZFTB('post')->where(['id'=>$data['id']])->update($data);
    //         return ZFRetMsg($res,'修改成功','修改失败');  
    //     } 
    // }

    /**
     * @Notes:导入内容
     * @Interface import
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author: 子枫
     * @Time: 2019/11/13   10:35 下午
     */
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

    /**
     * @Notes:根据关键字搜索内容
     * @Interface search_post
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author: 子枫
     * @Time: 2019/11/13   10:36 下午
     */
    public function search_post(){
        admin_role_check($this->z_role_list,$this->mca);
        $kwd = input('key','');
        $where[] = ['status','=',1];
        $where[] = ['relevan_id','=',0];
        if($kwd!='all'){
            $where[] = ['title','like','%'.$kwd.'%'];
        }
        $list =  ZFTB('post')->where($where)->order('id desc')->select();
        return ZFRetMsg($list,$list,'error');

    }

    /**
     * @Notes:获取内容中的图片并保存到 post_parm_pic
     * @Interface get_content_pic_list
     * @param $id
     * @author: 子枫
     * @Time: 2019/11/13   10:36 下午
     */
    public function get_content_pic_list($id){
        admin_role_check($this->z_role_list,$this->mca);
        $id = input('id',$id);
        $content = ZFTB('post')->where(['id'=>$id])->value('content');
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
            $_is = ZFTB('post_parm_pic')->where(['pic'=>$vo['pic'],'pid'=>$vo['pid']])->value('id');
            if(!$_is){
                ZFTB('post_parm_pic')->insert($vo);
            }
        }
        return jssuccess('已保存');

    }

    /**
     * @Notes:模型的参数列表
     * @Interface category_model_parm
     * @return \think\response\View
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author: 子枫
     * @Time: 2019/11/13   10:37 下午
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
        $list = ZFTB('category_model_parm')->where($where)->order("position asc,sort asc, id asc")->select();
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

    /**
     * @Notes:模型的参数-增加
     * @Interface category_model_parm_add
     * @return \think\response\View|void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author: 子枫
     * @Time: 2019/11/13   10:37 下午
     */
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
             $is_res =ZFTB('category_model_parm')->where($where)->find();
             if($is_res){
                return jserror('该字段已存在');exit;
             }

             $data = array_merge($data,$this->common_tag);
             $res =ZFTB('category_model_parm')->insert($data);
            return ZFRetMsg($res,'新增成功','新增失败');
             
         }  
         return view();   
     }

    /**
     * @Notes:模型的参数-修改
     * @Interface category_model_parm_edit
     * @return \think\response\View|void
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     * @author: 子枫
     * @Time: 2019/11/13   10:38 下午
     */
     public function category_model_parm_edit()
     {
         admin_role_check($this->z_role_list,$this->mca,1);
         if(request()->isPost()){
            $data = input('post.');
            $res =  ZFTB('category_model_parm')->where(['id'=>$data['id']])->update($data);
            return ZFRetMsg($res,'修改成功','修改失败');
         } 
         $res = ZFTB('category_model_parm')->where(['id'=>input('id')])->find();
         $this->assign("res",$res);
         return view();
     }
    
    
}
