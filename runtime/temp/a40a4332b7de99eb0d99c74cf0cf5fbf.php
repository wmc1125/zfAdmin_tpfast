<?php /*a:1:{s:33:"./template/admin/index/index.html";i:1573989254;}*/ ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title><?php echo htmlentities($web_config['version']['ver_name']); ?></title>
<link rel="icon" href="favicon.ico" type="image/ico">
<meta name="keywords" content="子枫后台管理系统">
<meta name="description" content="子枫后台管理系统">
<meta name="author" content="yinqi">
<link href="/vendor/wmc1125/tpfast-public/public/static/system/css/bootstrap.min.css" rel="stylesheet">
<link href="/vendor/wmc1125/tpfast-public/public/static/system/css/materialdesignicons.min.css" rel="stylesheet">
<link rel="stylesheet" href="/vendor/wmc1125/tpfast-public/public/static/system/js/bootstrap-multitabs/multitabs.min.css">
<link href="/vendor/wmc1125/tpfast-public/public/static/system/css/style.min.css" rel="stylesheet">
</head>

<body data-headerbg="color_8"  data-logobg="color_8" data-sidebarbg="color_8">
<div class="lyear-layout-web">
  <div class="lyear-layout-container">
    <!--左侧导航-->
    <aside class="lyear-layout-sidebar">
      
      <!-- logo -->
      <div id="logo" class="sidebar-header">
        <a href="/" target="_blank"><img src="/vendor/wmc1125/tpfast-public/public/static/system/images/logo-sidebar.png" title="子枫后台管理系统" alt="子枫后台管理系统" /></a>
      </div>
      <div class="lyear-layout-sidebar-scroll"> 
        
        <nav class="sidebar-main">
          <ul class="nav nav-drawer">
            <li class="nav-item active"> <a class="multitabs" href="<?php echo url('index/welcome'); ?>"><i class="mdi mdi-home"></i> <span>后台首页</span></a> </li>

            <?php foreach($menu as $k=>$vo){ if($vo['pid']==0 && $vo['menu']==1){  ?>
            <li class="nav-item nav-item-has-subnav">
              <a href="javascript:void(0)"><i class="mdi mdi-menu"></i> <span><?php echo htmlentities($vo['name']); ?></span></a>
              <?php $two_menu = get_two_menu($vo['id']); if(is_array($two_menu)){  ?>
              <ul class="nav nav-subnav">
                <?php foreach($two_menu as $k1=>$vo1){ $three_menu = get_two_menu($vo1['id']); if($three_menu){ ?>
                <li class="nav-item nav-item-has-subnav"> 
                  <a href="#!"><?php echo htmlentities($vo1['name']); ?></a>
                  <ul class="nav nav-subnav">
                    <?php foreach($three_menu as $k2=>$vo2){ ?>
                    <li> <a class="multitabs" href="<?php echo url($vo2['control'].'/'.$vo2['act']); ?>"><?php echo htmlentities($vo2['name']); ?></a> </li>
                    <?php } ?>
                  </ul>
                </li>
                <?php }else{ ?>
                  <li><a class="multitabs" href="<?php echo url($vo1['control'].'/'.$vo1['act']); ?>"><?php echo htmlentities($vo1['name']); ?></a> </li>
                <?php }} ?>
              </ul>
              <?php } ?>
            </li>
            <?php }} ?>
              <li> <a href="http://bbs.wangmingchang.com/forum.php?mod=forumdisplay&fid=77" target="_blank"><i class="mdi mdi-book"></i> <span>开发文档</span></a> </li>

          </ul>
        </nav>
        
        <div class="sidebar-footer">
          <p class="copyright">Copyright &copy; 2019. <a target="_blank" href="http://www.wangmingchang.com">王明昌博客</a> All rights reserved.</p>
        </div>
      </div>
      
    </aside>
    <!--End 左侧导航-->
    
    <!--头部信息-->
    <header class="lyear-layout-header">
      
      <nav class="navbar navbar-default">
        <div class="topbar">
          
          <div class="topbar-left">
            <div class="lyear-aside-toggler">
              <span class="lyear-toggler-bar"></span>
              <span class="lyear-toggler-bar"></span>
              <span class="lyear-toggler-bar"></span>
            </div>
            <span class="zf_admin_refresh">  </span>
          </div>
        
          <ul class="topbar-right">
            <li class="dropdown dropdown-profile">
              <a href="javascript:void(0)" data-toggle="dropdown">
                <img class="img-avatar img-avatar-48 m-r-10" src="<?php echo htmlentities(app('session')->get('admin.pic')); ?>"  />
                <span><?php echo htmlentities(app('session')->get('admin.name')); ?> <span class="caret"></span></span>
              </a>
              <ul class="dropdown-menu dropdown-menu-right">
                <li> <a class="multitabs" data-url="<?php echo url('user/admin_info'); ?>" href="javascript:void(0)"><i class="mdi mdi-account"></i> 个人信息</a> </li>
                <li> <a class="multitabs" data-url="<?php echo url('user/pwd_edit'); ?>" href="javascript:void(0)"><i class="mdi mdi-lock-outline"></i> 修改密码</a> </li>
                <li> <a href="javascript:void(0)"  onclick="clearPhp(this)" data-GetUrl="<?php echo url('index/db_clear'); ?>"><i class="mdi mdi-delete"></i> 清除数据库回收站</a></li>
                <li class="divider"></li>
                <li> <a href="<?php echo url('login/loginout'); ?>"><i class="mdi mdi-logout-variant"></i> 退出登录</a> </li>
              </ul>
            </li>
           
            <!--切换主题配色-->
		        <!-- <li class="dropdown dropdown-skin">
  			      <span data-toggle="dropdown" class="icon-palette"><i class="mdi mdi-palette"></i></span>
      			  <ul class="dropdown-menu dropdown-menu-right" data-stopPropagation="true">
      			    <li class="drop-title"><p>LOGO</p></li>
        				<li class="drop-skin-li clearfix">
                          <span class="inverse">
                            <input type="radio" name="logo_bg" value="default" id="logo_bg_1" checked>
                            <label for="logo_bg_1"></label>
                          </span>
                          <span>
                            <input type="radio" name="logo_bg" value="color_2" id="logo_bg_2">
                            <label for="logo_bg_2"></label>
                          </span>
                          <span>
                            <input type="radio" name="logo_bg" value="color_3" id="logo_bg_3">
                            <label for="logo_bg_3"></label>
                          </span>
                          <span>
                            <input type="radio" name="logo_bg" value="color_4" id="logo_bg_4">
                            <label for="logo_bg_4"></label>
                          </span>
                          <span>
                            <input type="radio" name="logo_bg" value="color_5" id="logo_bg_5">
                            <label for="logo_bg_5"></label>
                          </span>
                          <span>
                            <input type="radio" name="logo_bg" value="color_6" id="logo_bg_6">
                            <label for="logo_bg_6"></label>
                          </span>
                          <span>
                            <input type="radio" name="logo_bg" value="color_7" id="logo_bg_7">
                            <label for="logo_bg_7"></label>
                          </span>
                          <span>
                            <input type="radio" name="logo_bg" value="color_8" id="logo_bg_8">
                            <label for="logo_bg_8"></label>
                          </span>
        				</li>
        				<li class="drop-title"><p>头部</p></li>
        				<li class="drop-skin-li clearfix">
                          <span class="inverse">
                            <input type="radio" name="header_bg" value="default" id="header_bg_1" checked>
                            <label for="header_bg_1"></label>                      
                          </span>                                                    
                          <span>                                                     
                            <input type="radio" name="header_bg" value="color_2" id="header_bg_2">
                            <label for="header_bg_2"></label>                      
                          </span>                                                    
                          <span>                                                     
                            <input type="radio" name="header_bg" value="color_3" id="header_bg_3">
                            <label for="header_bg_3"></label>
                          </span>
                          <span>
                            <input type="radio" name="header_bg" value="color_4" id="header_bg_4">
                            <label for="header_bg_4"></label>                      
                          </span>                                                    
                          <span>                                                     
                            <input type="radio" name="header_bg" value="color_5" id="header_bg_5">
                            <label for="header_bg_5"></label>                      
                          </span>                                                    
                          <span>                                                     
                            <input type="radio" name="header_bg" value="color_6" id="header_bg_6">
                            <label for="header_bg_6"></label>                      
                          </span>                                                    
                          <span>                                                     
                            <input type="radio" name="header_bg" value="color_7" id="header_bg_7">
                            <label for="header_bg_7"></label>
                          </span>
                          <span>
                            <input type="radio" name="header_bg" value="color_8" id="header_bg_8">
                            <label for="header_bg_8"></label>
                          </span>
        				</li>
        				<li class="drop-title"><p>侧边栏</p></li>
        				<li class="drop-skin-li clearfix">
                          <span class="inverse">
                            <input type="radio" name="sidebar_bg" value="default" id="sidebar_bg_1" checked>
                            <label for="sidebar_bg_1"></label>
                          </span>
                          <span>
                            <input type="radio" name="sidebar_bg" value="color_2" id="sidebar_bg_2">
                            <label for="sidebar_bg_2"></label>
                          </span>
                          <span>
                            <input type="radio" name="sidebar_bg" value="color_3" id="sidebar_bg_3">
                            <label for="sidebar_bg_3"></label>
                          </span>
                          <span>
                            <input type="radio" name="sidebar_bg" value="color_4" id="sidebar_bg_4">
                            <label for="sidebar_bg_4"></label>
                          </span>
                          <span>
                            <input type="radio" name="sidebar_bg" value="color_5" id="sidebar_bg_5">
                            <label for="sidebar_bg_5"></label>
                          </span>
                          <span>
                            <input type="radio" name="sidebar_bg" value="color_6" id="sidebar_bg_6">
                            <label for="sidebar_bg_6"></label>
                          </span>
                          <span>
                            <input type="radio" name="sidebar_bg" value="color_7" id="sidebar_bg_7">
                            <label for="sidebar_bg_7"></label>
                          </span>
                          <span>
                            <input type="radio" name="sidebar_bg" value="color_8" id="sidebar_bg_8">
                            <label for="sidebar_bg_8"></label>
                          </span>
        				</li>
    			    </ul>
  			     </li> -->
            <!--切换主题配色-->
            <span class="navbar-page-title" id="zf_mctool" >快捷工具  </span>
            <script src="https://mctool.wangmingchang.com/public/static/api/mc_tool/index.js"></script>
          </ul>
          
        </div>
      </nav>
      
    </header>
    <!--End 头部信息-->
    
    <!--页面主要内容-->
    <main class="lyear-layout-content">
      
      <div id="iframe-content"></div>
      
    </main>
    <!--End 页面主要内容-->
  </div>
</div>

<!--右侧-->
<style type="text/css">
.red-envelope {
    position: fixed;
    left: 0px;
    bottom: 10px;
  /*  width: 150px;
    height: 104px; */
    text-align: center;
    display: inline-block;
    z-index: 999;
}
.red-envelope .content {
    width: 100%;
    height: 100%;
    position: relative;
}
.red-envelope .content .img {
    width: 200px;

}
.red-envelope .content .img-close {
    width: 15px;
    height: 15px;
    position: absolute;
    right: 9px;
    top: 0;
}

@media screen and (max-width:400px){
    .red-envelope .content .img {
        width: 130px;
       /* height: 134px; */
    }
}

</style>

<div class="red-envelope">
    <div class="content">

   <a href="https://m.tb.cn/h.eJG1uWt" rel="noreferrer" target="_blank">
            <img class="img" src="https://i.loli.net/2019/10/30/SnigOwCZAcLEu7q.png">
        </a>
        <img class="img-close" onclick="removeTbHb()" id="close-envelope" src="https://i.loli.net/2019/10/30/XhWyHlANe8MJujx.png">
    </div>
</div>


<script type="text/javascript" src="/vendor/wmc1125/tpfast-public/public/static/system/js/jquery.min.js"></script>
<script type="text/javascript" src="/vendor/wmc1125/tpfast-public/public/static/system/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/vendor/wmc1125/tpfast-public/public/static/system/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="/vendor/wmc1125/tpfast-public/public/static/system/js/bootstrap-multitabs/multitabs.js"></script>
<script type="text/javascript" src="/vendor/wmc1125/tpfast-public/public/static/system/js/index.min.js"></script>
</body>
</html>
<script>
function clearPhp(obj) {
  var url=obj.getAttribute('data-GetUrl');
  //询问框
  layer.confirm('您确定要清除吗？', {
        btn: ['确定','取消'] //按钮
    },
    function(){
        $.get(url,function(info){
            if(info.code === 1){
                setTimeout(function () {location.href = info.url;}, 1000);
            }
            layer.msg(info.msg);
        });
    },
    function(){});
}


function removeTbHb(){
	$('.red-envelope').hide();
	setCookie("noTb", "1")
}


</script>