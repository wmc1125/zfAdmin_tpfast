<?php /*a:1:{s:35:"./template/admin/user/pwd_edit.html";i:1569477696;}*/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php echo htmlentities($web_config['version']['ver_name']); ?></title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="/public/static/style/layui/css/layui.css" media="all">
</head>
<body>

  <div class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin" style="padding: 20px 0 0 0;">
    <form class="info_tj" onclick="return false">
      <input type="hidden" name="id" value="<?php echo htmlentities(app('session')->get('admin.id')); ?>">
      <div class="layui-form-item">
        <label class="layui-form-label">密码</label>
        <div class="layui-input-inline">
          <input type="password" name="pwd" lay-verify="required" placeholder="请输入用密码" autocomplete="off" class="layui-input">
        </div>
      </div>
      
      <div class="layui-form-item">
        <div class="layui-input-block">
          <button class="layui-btn tijiao layui-btn-sm" lay-submit lay-filter="formDemo">立即提交</button>
        </div>
      </div>
    </form>
  </div>

  <script src="/public/static/style/layui/layui.js"></script>    
  <script>
 layui.use(['form', 'upload'], function(){
    var $ = layui.$
    ,form = layui.form
    ,upload = layui.upload ;

    $(".tijiao").on("click",function(){
      var data = $(".info_tj input").serialize();      
      $.ajax({
          type:'post',
          url:"<?php echo url('user/pwd_edit'); ?>",
          data:data,
          dataType:'json',
          success:function(res){
            // console.log(res)
            if(res.result==1){
              layer.msg("修改成功,请重新登陆", {icon: 1});
              setTimeout(function() {
                window.parent.location.reload();
              }, 2000);
            }else{
              layer.msg(res.msg, {icon: 2});
              setTimeout(function() {
                window.parent.location.reload();
              }, 2000);
            }
            
          }
      })

    })
    
    
  })
  </script>
</body>
</html>