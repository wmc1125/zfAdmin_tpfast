<?php /*a:1:{s:34:"./template/admin/mysql/import.html";i:1569573846;}*/ ?>


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
</head>
<body>

  <div class="layui-fluid">
    <div class="layui-card">
      <div class="layui-card-body">
          <table id="dataTable"></table>
      </div>
    </div>
  </div>
  <script src="/public/static/style/jquery-1.8.3.min.js"></script>  
  <script src="/public/static/style/layui/layui.js"></script>    
  <script src="/public/static/system/common.js"></script>  
  <script type="text/html" id="buttonTpl">
      <div class="layui-btn-group">
          <a data-href="<?php echo url('mysql/import'); ?>?id={{ d.id }}" class="layui-btn layui-btn-primary layui-btn-sm j-ajax">恢复</a>
          <a data-href="<?php echo url('mysql/del?'); ?>?id={{ d.id }}" class="layui-btn layui-btn-primary layui-btn-sm j-ajax">删除</a>
      </div>
  </script>
  <script type="text/javascript">
      layui.use(['table'], function() {
          var table = layui.table;
          table.render({
              elem: '#dataTable'
              ,url: '<?php echo url(); ?>?group=import' //数据接口
              ,page: false //分页
              ,skin: 'row'
              ,even: true
              ,text: {
                  none : '暂无相关数据'
              }
              ,cols: [[ //表头
                  {field: 'name', title: '备份名称'}
                  ,{field: 'part', title: '备份卷数', width: 100}
                  ,{field: 'compress', title: '备份压缩', width: 100}
                  ,{field: 'size', title: '备份大小', width: 100, templet: function(d) {
                      return parseInt(d.size / 1024) + 'KB';
                  }}
                  ,{field: 'time', title: '备份时间', width: 170}
                  ,{title: '操作', width: 120, templet: '#buttonTpl'}
              ]]
          });
      });
  </script>
</body>
</html>
