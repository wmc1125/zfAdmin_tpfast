<?php /*a:2:{s:35:"./template/admin/index/welcome.html";i:1573991518;s:40:"./template/admin/public/common_tool.html";i:1572489515;}*/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php echo htmlentities($web_config['version']['ver_name']); ?></title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="/vendor/wmc1125/tpfast-public/public/static/style/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="/vendor/wmc1125/tpfast-public/public/static/system/style/admin.css" media="all">
</head> 
<body>
  
  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md12">
        <blockquote class="layui-elem-quote layui-bg-green">
          <div id="nowTime">亲爱的<?php echo htmlentities(app('session')->get('admin.name')); ?> 欢迎使用子枫后台管理系统(TpFast系列)模版,在使用过程中有什么问题,可以在<a class="layui-btn layui-btn-xs" href="http://bbs.wangmingchang.com/forum.php?mod=forumdisplay&fid=77" target="_blank">Mc技术论坛</a>留言。当前时间为： <span id="datetime"></span> </div>
        </blockquote>
      </div>
      
      <div class="layui-col-md8">
        <div class="layui-row layui-col-space15">


          <div class="layui-col-sm6 layui-col-md4">
            <div class="layui-card">
              <div class="layui-card-header">
                用户数
                <span class="layui-badge layui-bg-blue layuiadmin-badge">周</span>
              </div>
              <div class="layui-card-body layuiadmin-card-list">
                <p class="layuiadmin-big-font"><?php echo htmlentities($data['user_week']); ?></p>
                <p>
                  总用户数
                  <span class="layuiadmin-span-color"><?php echo htmlentities($data['user_total']); ?> <i class="layui-inline layui-icon layui-icon-flag"></i></span>
                </p>
              </div>
            </div>
          </div>
          <div class="layui-col-sm6 layui-col-md4">
            <div class="layui-card">
              <div class="layui-card-header">
                文章数
                <span class="layui-badge layui-bg-blue layuiadmin-badge">周</span>
              </div>
              <div class="layui-card-body layuiadmin-card-list">
                <p class="layuiadmin-big-font"><?php echo htmlentities($data['post_week']); ?></p>
                <p>
                  总文章数
                  <span class="layuiadmin-span-color"><?php echo htmlentities($data['post_total']); ?> <i class="layui-inline layui-icon layui-icon-flag"></i></span>
                </p>
              </div>
            </div>
          </div>
          <div class="layui-col-sm6 layui-col-md4">
            <div class="layui-card">
              <div class="layui-card-header">
                留言数
                <span class="layui-badge layui-bg-blue layuiadmin-badge">周</span>
              </div>
              <div class="layui-card-body layuiadmin-card-list">
                <p class="layuiadmin-big-font"><?php echo htmlentities($data['guessbook_week']); ?></p>
                <p>
                  总留言数
                  <span class="layuiadmin-span-color"><?php echo htmlentities($data['guessbook_total']); ?> <i class="layui-inline layui-icon layui-icon-flag"></i></span>
                </p>
              </div>
            </div>
          </div>
          
          <div class="layui-col-md12">
            <div class="layui-card">
              <div class="layui-card-header">最新文章</div>
              <div class="layui-card-body">
                <table class="layui-table">
                    <colgroup>
                      <col width="30">
                      <col width="120">
                      <col width="60">
                      <col width="100">
                      <col width="50">
                      <col width="50">
                      <col width="50">
                      <col width="20">
                      <col>
                    </colgroup>
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>标题</th>
                        <th>图片</th>
                        <th>链接</th>          
                        <th>排序</th>
                        <th>点击量</th>
                        <th>状态</th>
                        <th>操作</th>
                      </tr> 
                    </thead>
                    <tbody>
                      <?php if(is_array($data['posts']) || $data['posts'] instanceof \think\Collection || $data['posts'] instanceof \think\Paginator): $i = 0; $__LIST__ = $data['posts'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <tr>
                          <td><?php echo htmlentities($vo['id']); ?></td>
                          <td><?php echo htmlentities($vo['title']); ?></td>
                          <td><img src="<?php echo htmlentities($vo['pic']); ?>" style="width:50px;height:50px"/></td>
                          <td><?php echo htmlentities($vo['append']); ?></td>
                          <td><?php echo htmlentities($vo['sort']); ?></td>
                          <td><?php echo htmlentities($vo['hits']); ?></td>
                          <td> 
                              <?php echo $vo['status']==1?'开启':'关闭'; ?>
                          </td>                
                          <td> <button class="layui-btn layui-btn-sm" onclick='zfAdminShow("编辑","<?php echo url('category/post_edit',['id' => $vo['id'],'cid' => $vo['cid']] ); ?>")'>编辑</button> </td>
                        </tr>
                      <?php endforeach; endif; else: echo "" ;endif; ?>         
                    </tbody>
                  </table>
              </div>
            </div>
          </div>
          <div class="layui-col-sm12 layui-col-md12">
            <div class="layui-card">
              <div class="layui-card-header">版本信息</div>
              <div class="layui-card-body layui-text">
                <table class="layui-table">
                  <colgroup>
                    <col width="100">
                    <col>
                  </colgroup>
                  <tbody>
                    <tr>
                      <td>当前版本</td>
                      <td>
                        
                          <a href="http://bbs.wangmingchang.com/forum.php?mod=forumdisplay&fid=77" target="_blank" >子枫后台管理系统(TpFast系列)v1.0.1</a>
                      </td>
                    </tr>
                    <tr>
                      <td>基于框架</td>
                      <td>
                        <a href="http://www.thinkphp.cn">Tp5.1</a> + <a href="https://www.layui.com">layui</a> + <a href="https://gitee.com/yinqi/Light-Year-Admin-Template">光年后台模板</a>
                    </td>
                    </tr>
                    <tr>
                      <td>主要特色</td>
                      <td>零门槛 / 响应式 / 清爽 / 极简 / 快速开发</td>
                    </tr>
                    <tr>
                      <td>获取渠道</td>
                      <td style="padding-bottom: 0;">
                        <div class="layui-btn-container">
                          <a href="http://bbs.wangmingchang.com/forum.php?mod=forumdisplay&fid=77" target="_blank" class="layui-btn layui-btn-danger">子枫后台系统</a>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="layui-card">
              <div class="layui-card-header">服务器信息</div>
              <div class="layui-card-body layui-text">
                <table class="layui-table">
                  <colgroup>
                    <col width="400">
                    <col width="300">
                    <col>
                  </colgroup>
                  <tbody>
                    <tr>
                      <td>站点信息:</td>
                      <td>
                          <?php echo $_SERVER["SERVER_NAME"];?>(IP:<?php echo $_SERVER["SERVER_ADDR"];?>)
                      </td>
                    </tr>
                    
                    <tr>
                      <td>服务器：</td>
                      <td>
                        <?php echo php_uname('s').' '.php_uname('r');?>
                      </td>
                    </tr>
                    <tr>
                      <td>站点物理路径：</td>
                      <td>
                        <?php echo $_SERVER['DOCUMENT_ROOT'];?>
                      </td>
                    </tr>
                    <tr>
                      <td>POST大小：</td>
                      <td>
                        <?php echo ini_get('max_execution_time').'M';?>
                      </td>
                    </tr>
                      <tr>
                      <td>上传大小：</td>
                      <td>
                        <?php echo ini_get('upload_max_filesize');?>
                      </td>
                    </tr>
                      <tr>
                      <td>服务器时间：</td>
                      <td>
                        <?php echo date('Y-m-d H:i:s');?>
                      </td>
                    </tr>
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="layui-col-md4">
          <div class="layui-card">
            <div class="layui-tab layui-tab-brief layadmin-latestData">
              <ul class="layui-tab-title">
                <li class="">产品介绍</li>
              </ul>
              <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">
                  <blockquote class="layui-elem-quote main_btn">
                    <p class="layui-blue">子枫后台管理系统免费提供大家使用,有什么问题可以在<a class="layui-btn layui-btn-xs" href="http://bbs.wangmingchang.com/forum.php?mod=forumdisplay&fid=77" target="_blank">Mc技术论坛</a>提出异议,有什么好用的功能也可以写出建议,只为不断完善后台系统,后台可免费使用,但必须保留版权声明</p>
                  </blockquote>
                </div>
              </div>
            </div>
            <div class="layui-card-header">快捷方式</div>
            <div class="layui-card-body">
              
              <div class="layui-carousel layadmin-carousel layadmin-shortcut" lay-anim="" lay-indicator="inside" lay-arrow="none" style="width: 100%; height: 280px;">
                <div carousel-item="">
                  <ul class="layui-row layui-col-space10 layui-this">
                    <li class="layui-col-xs3">
                      <a href="<?php echo url('category/post_all_list'); ?>">
                        <i class="layui-icon layui-icon-console"></i>
                        <cite>文章列表</cite>
                      </a>
                    </li>
                    <li class="layui-col-xs3">
                      <a href="<?php echo url('user/index'); ?>">
                        <i class="layui-icon layui-icon-user"></i>
                        <cite>用户列表</cite>
                      </a>
                    </li>
                    <li class="layui-col-xs3">
                      <a href="<?php echo url('rests/guessbook'); ?>">
                        <i class="layui-icon layui-icon-survey"></i>
                        <cite>留言管理</cite>
                      </a>
                    </li>
                    <li class="layui-col-xs3">
                      <a href="http://bbs.wangmingchang.com/forum.php?mod=forumdisplay&fid=77" target="_blank">
                        <i class="layui-icon layui-icon-set"></i>
                        <cite>使用手册</cite>
                      </a>
                    </li>
                    <li class="layui-col-xs3">
                      <a href="<?php echo url(''); ?>">
                        <i class="layui-icon layui-icon-set"></i>
                        <cite>待添加</cite>
                      </a>
                    </li>
                    <li class="layui-col-xs3">
                      <a href="<?php echo url(''); ?>">
                        <i class="layui-icon layui-icon-set"></i>
                        <cite>待添加</cite>
                      </a>
                    </li>
                    <li class="layui-col-xs3">
                      <a href="<?php echo url(''); ?>">
                        <i class="layui-icon layui-icon-set"></i>
                        <cite>待添加</cite>
                      </a>
                    </li>
                    <li class="layui-col-xs3">
                      <a href="<?php echo url(''); ?>">
                        <i class="layui-icon layui-icon-set"></i>
                        <cite>待添加</cite>
                      </a>
                    </li>
                  </ul>
                </div>
            </div>
          </div>
        </div>

        <div class="layui-card">
          <div class="layui-tab layui-tab-brief layadmin-latestData">
            <ul class="layui-tab-title">
              <li class="">打赏列表</li>
            </ul>
            <div class="layui-tab-content">
              <div class="layui-tab-item layui-show">
                <iframe src="http://mctool.wangmingchang.com/index/jspay/dashang" width="100%" height="850" ></iframe>
              </div>
            </div>
          </div>
        </div>
        
            <!--  -->
<!--  -->
       


        <!-- <div class="layui-card aaaaa">
          <div class="layui-card-header">
            提示消息
          </div>
          <div class="layui-card-body layui-text layadmin-text">
            <p>一直以来，layui 秉承无偿开源的初心，虔诚致力于服务各层次前后端 Web 开发者，在商业横飞的当今时代，这一信念从未动摇。即便身单力薄，仍然重拾决心，埋头造轮，以尽可能地填补产品本身的缺口。</p>
            <p>在过去的一段的时间，我一直在寻求持久之道，已维持你眼前所见的一切。而 layuiAdmin 是我们尝试解决的手段之一。我相信真正有爱于 layui 生态的你，定然不会错过这一拥抱吧。</p>
            <p>子曰：君子不用防，小人防不住。请务必通过官网正规渠道，获得 <a href="http://www.layui.com/admin/" target="_blank">layuiAdmin</a>！</p>
            <p>—— 贤心（<a href="http://www.layui.com/" target="_blank">layui.com</a>）</p>
          </div>
        </div>  -->
      
    </div>
  </div>
<style type="text/css">
    .red-envelope {
        position: fixed;
        right: 30px;
        bottom: 40px;
      /*  width: 150px;
        height: 104px; */
        text-align: center;
        display: inline-block;
        z-index: 999;
    }
    .red-envelope .zf-content {
        width: 100%;
        height: 100%;
        position: relative;
    }
    </style>
    <div class="red-envelope">
        <div class="zf-content">
          <a href="javascript:location.reload();">
            <i class="layui-icon layui-icon-refresh-3"></i>
          </a>
        </div>
    </div>

  <script src="/vendor/wmc1125/tpfast-public/public/static/style/layui/layui.js?t=1"></script>  
  <script src="/vendor/wmc1125/tpfast-public/public/static/system/common.js"></script>  

  <script>
   layui.use(['layer'],function(){
      var $ = layui.$



    });
 setInterval("document.getElementById('datetime').innerHTML=new Date().toLocaleString();", 1000);

  </script>
</body>
</html>
