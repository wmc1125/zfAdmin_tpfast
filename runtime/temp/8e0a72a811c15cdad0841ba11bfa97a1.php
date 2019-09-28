<?php /*a:1:{s:34:"./template/admin/mysql/export.html";i:1569574394;}*/ ?>


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
          <a data-href="<?php echo url('mysql/optimize'); ?>?id={{ d.Name }}" class="layui-btn layui-btn-primary layui-btn-sm j-ajax">优化</a>
          <a data-href="<?php echo url('mysql/repair?'); ?>?id={{ d.Name }}" class="layui-btn layui-btn-primary layui-btn-sm j-ajax">修复</a>
      </div>
  </script>

  <script type="text/html" id="toolbar">
      <div class="layui-btn-group fl">
          <a data-href="<?php echo url('mysql/export'); ?>" class="layui-btn layui-btn-primary layui-btn-sm j-page-btns" data-table="dataTable">备份数据库</a>
          <a data-href="<?php echo url('mysql/optimize'); ?>" class="layui-btn layui-btn-primary layui-btn-sm j-page-btns" data-table="dataTable">优化数据库</a>
          <a data-href="<?php echo url('mysql/repair'); ?>" class="layui-btn layui-btn-primary layui-btn-sm j-page-btns" data-table="dataTable">修复数据库</a>
      </div>
  </script>

  <script type="text/javascript">
      layui.use(['table'], function() {
          var table = layui.table;
          table.render({
              elem: '#dataTable'
              ,url: '<?php echo url(); ?>?group=export' //数据接口
              ,page: false //分页
              ,skin: 'row'
              ,even: true
              ,text: {
                  none : '暂无相关数据'
              }
              ,toolbar: '#toolbar'
              ,defaultToolbar: ['filter']
              ,cols: [[ //表头
                  {type:'checkbox'}
                  ,{field: 'Name', title: '表名'}
                  ,{field: 'Rows', title: '数据量', width: 100}
                  ,{field: 'Data_length', title: '大小', width: 100, templet: function(d) {
                      return d.Data_length / 1024;
                  }}
                  ,{field: 'Data_free', title: '冗余', width: 100, templet: function(d) {
                      return d.Data_free / 1024;
                  }}
                  ,{field: 'Comment', title: '备注'}
                  ,{title: '操作', width: 120, templet: '#buttonTpl'}
              ]]
          });
      });
  </script>

</body>
</html>
