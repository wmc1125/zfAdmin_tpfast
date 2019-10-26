1. 模板使用 
	静态文件的引用{$tpl_static}
	如果当前文件模板文件夹为a1
	<link href="{$tpl_static}css/swiper.min.css" rel="stylesheet">
	等价于  <link rel="stylesheet" href="http://v1.fast.zf.90ckm.com/template/index/a1/style//css/index.css">

2.引入layui文件
  	<link rel="stylesheet" href="__STATIC__/style/layui/css/layui.css">



3. tdk
    <title>{$seo['title']}</title>
    <meta name="keywords" content="{$seo['keywords']}" />
    <meta name="description" content="{$seo['description']}" />

  
4.引入模板
	a1/index/index 引入头部header 
	{include file="a1/public/header"}



5. cate/list
        <?php foreach($list as $k=>$vo){ ?>
	
		<?php } ?>

分页
		    <script src="__STATIC__/style/bootstrap/bootstrap-3.3.4.js"></script>
  			<link rel="stylesheet" href="__STATIC__/style/bootstrap/bootstrap-3.3.4.css">


6.顶级父类
        $top_cid_now = $this->get_top_category($cid);



7. 获取全部子类
        $where[] = ['cid','in',$this->get_child_id($cid)];






