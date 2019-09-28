<?php /*a:1:{s:40:"./template/admin/config/admin_index.html";i:1569478548;}*/ ?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php echo htmlentities($web_config['version']['ver_name']); ?></title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="/public/static/style/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="/public/static/system/style/admin.css" media="all">
    <script src="https://www.jq22.com/jquery/bootstrap-3.3.4.js"></script>
  <link rel="stylesheet" href="https://www.jq22.com/jquery/bootstrap-3.3.4.css">
</head>
<body>

  <div class="layui-fluid">
    <div class="layui-card">
      
      <div class="layui-card-body">
        <div style="padding-bottom: 10px;">
          <button class="layui-btn layui-btn-sm" onclick="zfAdminShow('添加管理员','<?php echo url("config/admin_add"); ?>')">添加
          </button>
          <a class="layui-btn layui-btn-sm" href="<?php echo url('config/admin_group'); ?>">管理员分类</a>


        </div>
        
        <table class="layui-table">
            <colgroup>
              <col width="30">
              <col width="60">
              <col width="60">
              <col width="60">
              <col width="60">
              <col width="30">
              <col width="60">
              <col>
            </colgroup>
            <thead>
              <tr>
                <th>ID</th>
                <th>昵称</th>
                <th>分组</th>
                <th>IP</th>
                <th>加入时间</th>
                <th>状态</th>
                <th>操作</th>
              </tr> 
            </thead>
            <tbody>
              <?php if(is_array($user_list) || $user_list instanceof \think\Collection || $user_list instanceof \think\Paginator): $i = 0; $__LIST__ = $user_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <tr>
                  <td><?php echo htmlentities($vo['id']); ?></td>
                  <td><?php echo htmlentities($vo['name']); ?></td>
                  <td><?php echo get_admin_group_name($vo['gid']); ?></td>
                  <td><?php echo htmlentities($vo['ip']); ?></td>
                  <td><?php echo date("Y-m-d H:i:s",$vo['create_time']); ?></td>
                  <td> 
                    <div class=" layui-form" lay-filter="component-form-element">        
                       <input type="checkbox" name="status" <?php echo $vo['status']==1?'checked':''; ?> lay-skin="switch" lay-text="开启|关闭" lay-filter="status_change" item="<?php echo htmlentities($vo['id']); ?>">
                    </div>
                  </td>
                  <td> <a class="layui-btn layui-btn-danger layui-btn-sm" onclick="btn_del('common/del_post',<?php echo htmlentities($vo['id']); ?>,'admin')"  href="#">删除</a> <button class="layui-btn-sm layui-btn" onclick='zfAdminShow("编辑用户","<?php echo url('config/admin_edit',['id' => $vo['id']] ); ?>")'>编辑</button></td>
                </tr>
              <?php endforeach; endif; else: echo "" ;endif; ?>
           
              
            </tbody>
          </table>
          <?php echo $page; ?>

      </div>
    </div>
  </div>

  <script src="/public/static/style/layui/layui.js"></script>    
  <script src="/public/static/system/common.js"></script>  

  <script>
 layui.use([ 'table'], function(){
    var $ = layui.$
    ,form = layui.form
    ,table = layui.table;

    form.on('switch(status_change)', function(data){
      var id = $(this).attr("item")
      var dbname = 'admin'
      var status = this.checked ? '1' : '0'
      console.log(id)
      $.get("<?php echo url('common/is_switch'); ?>",{id:id,dbname:dbname,status:status},function(res){
          if(res.result==1){
            layer.msg(res.msg, {icon: 1});
          }else{
            layer.msg(res.msg, {icon: 2});
          }
        },"json");
    });
   
   
  });
  </script>
</body>
</html>
