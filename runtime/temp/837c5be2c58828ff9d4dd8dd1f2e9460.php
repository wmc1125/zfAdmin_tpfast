<?php /*a:3:{s:36:"./template/index/a1/cate/liuyan.html";i:1569578992;s:38:"./template/index/a1/public/header.html";i:1569579509;s:38:"./template/index/a1/public/footer.html";i:1569549656;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title><?php echo htmlentities($seo['title']); ?></title>
    <meta name="keywords" content="<?php echo htmlentities($seo['keywords']); ?>" />
    <meta name="description" content="<?php echo htmlentities($seo['description']); ?>" />
	<link href="<?php echo htmlentities($tpl_static); ?>css/swiper.min.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="<?php echo htmlentities($tpl_static); ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo htmlentities($tpl_static); ?>css/carousel.css" rel="stylesheet">
	<style>.margin-width{
			margin-bottom: 8px;
			margin-top: 1px;
		}
		.font-size{
			font-size: 16px;
		}
		.ul-li li{
			margin:0 0 5px 0;
		}
		.a-color{
			color: #333;
			font-weight:400;
			font-family: Georgia;
			margin:0 0 5px 0;
		
		}
		.a-color:hover{
			color: #33ccff;
			text-decoration: none;
		}
		.list-group a:hover{
			background: #33ccff;
			color: #fff;
		}
		.modal-dialog {
			width: 600px;
			margin: 190px auto;
		}
		.last span{
			position: fixed;
			z-index: 110;
			width: 70px;
			height: 70px;
			right: 25px;
			bottom: 55px;
			cursor: pointer;
			text-align: center;
			line-height: 70px;
			background-color: #00b7ee;
			border-radius: 50%;
			opacity: 0.8;
			color: #fff;
		}
		.last:hover{
			background-color: #1fb5ad;
			color: #fff;
		}
		body {
			color: #5a5a5a;
			padding-bottom: 0;
		}

		.back,.back a{
		   background-color: #000;
			color: #999;
			padding-bottom: 10px;
			padding-top: 5px;
			width: 100%;
		}
	</style>
	<!-- Matomo -->
<script type="text/javascript">
  var _paq = window._paq || [];
  /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="https://tongji.wangmingchang.com/";
    _paq.push(['setTrackerUrl', u+'matomo.php']);
    _paq.push(['setSiteId', '8']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<!-- End Matomo Code -->
</head>
<body>
<nav class="navbar navbar-inverse" >  
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/" title="<?php echo htmlentities($web_config['web']['site_name']); ?>"><?php echo htmlentities($web_config['web']['site_name']); ?></a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="/" title="/">首页 </a>
                </li>
                <?php foreach($menu as $k=>$vo){ ?>
                <li class="<?php echo $cid==$vo['cid']?'active':''; ?>"><a href="<?php echo url('cate/list',['cid'=>$vo['cid']]); ?>" title="<?php echo htmlentities($vo['name']); ?>"><?php echo htmlentities($vo['name']); ?></a></li>
                <?php } ?>
                <!-- <li class="<?php echo $cid==$vo['cid']?'active':''; ?>"><a href="<?php echo url('cate/liuyan'); ?>" title="<?php echo htmlentities($vo['name']); ?>">留言</a></li> -->

            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <ol class="breadcrumb">
        <li class="active"><a href="/" title="">网站首页</a> </li>
        <li class="active">
            <a href="<?php echo url('cate/liuyan'); ?>" title="留言">留言</a>
        </li>
    </ol>
</div>
<div class="container"><!--内容区-->
    <div class="row">
        <div class="col-sm-6 col-md-8"><!--文章内容-->
            <div class="row">
                <div class="col-lg-11">
                    <div class="panel panel-default">
                        <div class="panel-heading">请填写留言内容：</div>
                        <div class="panel-body">
                            <form class="form-horizontal info_tj" role="form">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Email：</label>
                                    <div class="col-sm-5">
                                        <input type="email" class="form-control" id="inputEmail3" name="email" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail4" class="col-sm-2 control-label">留言内容：</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control"  id="inputEmail4"  class="form-control" name="content" rows="5" placeholder="留言内容保持在140字符左右" ></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <input type="button" class="btn btn-primary sub tijiao" value="提 交" />
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <div class="bs-example message">
                <!------留言列表----->
                <ul class="media-list">
                        <!-----分割线---->
                    <?php foreach($list as $k=>$vo){ ?>
                    <hr/>
                    <li class="media">
                        <a title="回复" class="pull-left" href="javascript:void(0);" >
                            <p>游客</p>
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading"><?php echo htmlentities($vo['email']); ?><a href="/cdn-cgi/l/email-protection" class="__cf_email__" ></a></h4>
                            <p><?php echo htmlentities($vo['content']); ?></p>
                            <!--留言回复--->
                            <div class="line"></div>
                            <!-- <div class="media">
                                <a title="回复" class="pull-left" href="javascript:void(0);"  >
                                    <p>游客</p>                                                </a>
                                <div class="media-body">
                                    <h4 class="media-heading"><?php echo htmlentities($vo['email']); ?><a href="/cdn-cgi/l/email-protection" class="__cf_email__" ></a></h4>
                                    <p>1</p>

                                </div>
                            </div>
                            <div class="line"></div>
                            <div class="media">
                                <a title="回复" class="pull-left" href="javascript:void(0);" onclick="iframe(48,'<?php echo htmlentities($vo['email']); ?>381@163.com')" >
                                    <p>游客</p>                                                </a>
                                <div class="media-body">
                                    <h4 class="media-heading"><?php echo htmlentities($vo['email']); ?><a href="/cdn-cgi/l/email-protection" class="__cf_email__" ></a></h4>
                                    <p>1</p>

                                </div>
                            </div> -->
                        <!--end 留言回复--->
                        </div>
                    </li>
                    <?php } ?>
                    <!-----分割线---->
                    <hr/>
                </ul>
                <nav aria-label="Page navigation"><!--分页-->
                           <?php echo $list->render(); ?>
                </nav> <!--分页 end-->
            </div>
        </div><!--文章内容 end-->
        <div class="col-sm-6 col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="form-inline s22" action="<?php echo url('cate/search'); ?>" method="get">
                        <div class="row">
                            <div class="col-xs-8">
                                <input type="text" name="keyword" class="form-control" placeholder="Search">
                            </div>
                            <button type="submit" class="btn btn-info">全站搜索</button>
                            </div>
                    </form>
                </div>
            </div> 
            <!--最新文章-->
            <div class="panel panel-default">
                <div class="panel-heading font-size">推荐<span style="color: #33cc99;">文章</span></div>
                <div class="panel-body">
                    <ul class="ul-li">
                        <?php foreach($post_sort as $k=>$vo){ ?>
                        <li><a class="a-color" href="<?php echo url('cate/detail',['id'=>$vo['id']]); ?>"> <?php echo htmlentities($vo['title']); ?></a></li>
                        <?php } ?>

                    </ul>
                </div>
            </div> 
            <!--点击排行-->
            <div class="panel panel-default">
                <div class="panel-heading font-size">点击<span style="color: #00ccff;">排行</span></div>
                <div class="panel-body">
                    <ol class="ul-li">
                        <?php foreach($post_hits as $k=>$vo){ ?>
                        <li><a href="<?php echo url('cate/detail',['id'=>$vo['id']]); ?>" class="a-color" title=" <?php echo htmlentities($vo['title']); ?>">  <?php echo htmlentities($vo['title']); ?></a></li>  
                        <?php } ?>
                    </ol>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading font-size">友情<span style="color: #ff3300;">链接</span></div>
                <div class="list-group">
                    <?php foreach($links as $k=>$vo){ ?>
                        <a href="<?php echo htmlentities($vo['url']); ?>" class="list-group-item" title="<?php echo htmlentities($vo['name']); ?>" target="_blank"><?php echo htmlentities($vo['name']); ?></a>
                    <?php } ?>
                </div>
            </div>
            <!--返回顶部 start-->
            <div class=" container last">
                <span> 顶部 </span>
            </div>
            <!--返回顶部 end-->
        </div>
    </div>
</div>

<!--底部 col-md-offset-2 -->
<div class="container back">
    <div class="row">
        <div class="col-md-12 ">
            <p></p>
            <p class="text-center">
                <span><?php echo htmlentities($web_config['web']['site_copyright']); ?> </span>
                <a href="http://www.miitbeian.gov.cn/" target="_blank"><?php echo htmlentities($web_config['web']['site_icp']); ?></a>
            </p>
            <p class="text-center"><span>联系方式：<a href="/"><span><?php echo htmlentities($web_config['web']['site_mail']); ?></span></a></span> </p>
        </div>
    </div>
</div><!--底部 end-->

<script src="<?php echo htmlentities($tpl_static); ?>js/jquery.min.js"></script>
<script src="<?php echo htmlentities($tpl_static); ?>js/bootstrap.min.js"></script>
<script src="<?php echo htmlentities($tpl_static); ?>js/holder.min.js"></script>
<script src="<?php echo htmlentities($tpl_static); ?>style/layer/layer.js"></script>

<style>
.navbar {
		position: relative;
		min-height: 50px;
		margin-bottom: 0;
		border: 1px solid transparent;
	}
	.swiper-pagination-progressbar .swiper-pagination-progressbar-fill {
		background: #009999;
		position: absolute;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		-webkit-transform: scale(0);
		-ms-transform: scale(0);
		transform: scale(0);
		-webkit-transform-origin: left top;
		-ms-transform-origin: left top;
		transform-origin: left top;
	}
	.img-responsive {
		display: block;
		height: auto;
		max-width: 100%;
		margin: 0 auto;
	}
	.swiper-container {
		margin: 0 auto;
		position: relative;
		overflow: hidden;
		list-style: none;
		padding: 0;
		z-index: 1;
		background: #000;
	}
</style>
<script src="<?php echo htmlentities($tpl_static); ?>js/swiper.min.js"></script>
<script>
var mySwiper = new Swiper ('.swiper-container', {
    direction: 'horizontal', // 垂直切换选项 vertical
    loop:true, // 循环模式选项 
    autoplay: false,  // 自动切换
    effect : 'fade', // 切换效果 默认为"slide"（位移切换），可设置为'slide'（普通切换、默认）,"fade"（淡入）"cube"（方块）"coverflow"（3d流）"flip"（3d翻转）。
    // 如果需要分页器
    pagination: {
        el: '.swiper-pagination',
        type: 'progressbar'

    },
    // 如果需要前进后退按钮
 /*   navigation: {
        nextEl: '.swiper-button-next',
        progressbarFillClass : 'my-bullet-active',
    }*/
});
function page(page){
	//加载层
	layer.msg('数据加载中', {
		icon: 16,
		time: 1000,
		shade: 0.01
	});
	// 发异步请求完成分页
	$.ajax({
		type: "POST",
		url: 'http://.cn/pages',
		dataType: 'json',
		cache: false,
		data: { page: page, _token: "pFM77yRU1PUINSIvkvU1gm60QeqRiFBLxCsS6jjB"},
		success: function(msg) {
			if(msg){
				$('.ul-list').html(msg);
					 $(document).ready(function() {
						$(function() {
							// 异步数据加载完成  回到文章列表顶部
								$('html,body').animate({
									scrollTop:230
								},200);
								return false;
						});
				});
			}
		}
	});
}
</script>



<!--返回顶部 start-->
<script>
    $(document).ready(function() {
        //首先将.last 隐藏
        $(".last").hide();
        //当滚动条的位置处于距顶部150像素以下时，返回顶部按钮显示，否则隐藏
        $(function() {
            $(window).scroll(function() {
                if ($(window).scrollTop() > 150) {
                    $(".last").fadeIn(1500);
                } else {
                    $(".last").fadeOut(1500);
                }
            });
            // 点击返回顶部
            $('.last').on('click',function(){
                $('html,body').animate({
                    scrollTop:0
                },500);
                return false;
            });
        });
    });
</script>

</body>
</html>
<script type="text/javascript">
    $(".tijiao").on("click",function(){
      var data = $(".info_tj input,.info_tj textarea,.info_tj radio").serialize();      
      $.ajax({
          type:'post',
          url:"<?php echo url('cate/liuyan'); ?>",
          data:data,
          dataType:'json',
          success:function(res){
            // console.log(res)
            if(res.result==1){
              layer.msg(res.msg, {icon: 1});
              setTimeout(function() {
                window.parent.location.reload();
              }, 2000);
            }else{
              layer.msg(res.msg, {icon: 2});
              
            }
            
          }
      })

    })
</script>