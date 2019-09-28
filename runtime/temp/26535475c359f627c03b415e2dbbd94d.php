<?php /*a:1:{s:44:"./template/admin/config/admin_role_edit.html";i:1569477696;}*/ ?>


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
      <input type="hidden" name="id" value="<?php echo htmlentities($res['id']); ?>">
      <div class="layui-form-item">
        <label class="layui-form-label">名称</label>
        <div class="layui-input-inline">
          <input type="text" name="name"  placeholder="请输入名称" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['name']); ?>">
        </div>
      </div>
      
      <div class="layui-form-item">
        <label class="layui-form-label">权限</label>
        <div class="layui-input-inline">
          <input type="text" name="value"  placeholder="请输入权限" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['value']); ?>" readonly="">
        </div>
      </div>

      <div class="layui-form-item">
        <label class="layui-form-label">父类</label>
        <div class="layui-input-inline">
          <select name="pid">
            <option value="<?php echo htmlentities($res['pid']); ?>"><?php echo r_name($res['pid']);?></option>
            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <option value="<?php echo htmlentities($vo['id']); ?>"><?php echo '┃'.str_repeat('━━', substr_count($vo['cname'],'  '));?> <?php echo htmlentities($vo['name']); ?></option>
            <?php endforeach; endif; else: echo "" ;endif; ?>
          </select>
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label">排序</label>
        <div class="layui-input-inline">
          <input type="text" name="sort"  placeholder="请输入" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['sort']); ?>" >
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label">是否菜单项:</label>
        <div class="layui-input-block">
          <input type="radio" name="menu" value="1" title="开启" <?php echo $res['menu']==1?'checked':''; ?> ><div class="layui-unselect layui-form-radio"><i class="layui-anim layui-icon"></i><div>开启</div></div>
          <input type="radio" name="menu" value="0" title="关闭" <?php echo $res['menu']==0?'checked':''; ?>><div class="layui-unselect layui-form-radio"><i class="layui-anim layui-icon"></i><div>关闭</div></div>
          
        </div>
      </div>
      <div class="layui-form-item">
        <div class="layui-input-block">
          <button class="layui-btn layui-btn-sm" onclick="tijiao_data('config/admin_role_edit')" lay-submit lay-filter="formDemo">立即提交</button>
        </div>
      </div>
    </form>
  </div>

  <script src="/public/static/style/layui/layui.js"></script>    
  <script type="text/javascript" src="/public/static/system/common.js"></script>  

  <script>
 layui.use(['form', 'upload'], function(){
    var $ = layui.$
    ,form = layui.form
    ,upload = layui.upload ;

      
  })
  </script>
</body>
</html>