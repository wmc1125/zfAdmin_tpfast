<?php /*a:1:{s:45:"./template/admin/category/category_model.html";i:1569477750;}*/ ?>
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
      <form onclick="return false;" class="info_tj">
        <div class="layui-form layui-card-header layuiadmin-card-header-auto">
          <div class="layui-form-item">
            
            <div class="layui-inline">
              <label class="layui-form-label">名称</label>
              <div class="layui-input-block">
                <input type="text" name="name" placeholder="请输入" autocomplete="off" class="layui-input">
              </div>
            </div>
            <div class="layui-inline">
              <label class="layui-form-label">Model</label>
              <div class="layui-input-inline">
                <input type="text" name="model" placeholder="请输入" autocomplete="off" class="layui-input">
              </div>
            </div>
             <div class="layui-inline">
              <label class="layui-form-label">排序</label>
              <div class="layui-input-block">
                <input type="text" name="sort" placeholder="请输入" autocomplete="off" class="layui-input">
              </div>
            </div>
            <div class="layui-inline">
                <button class="layui-btn layui-btn-sm " onclick="tijiao_data('category/category_model_add',0)"  >新增</button>
            </div>
          </div>
        </div>
      </form>
      <div class="layui-card-body">
        <table class="layui-table">
            <colgroup>
              <col width="30">
              <col width="60">
              <col width="60">
              <col width="50">
              <col width="50">
              <col width="50">
              <col>
            </colgroup>
            <thead>
              <tr>
                <th>ID</th>
                <th>名称</th>
                <th>Model</th>          
                <th>排序</th>
                <th>状态</th>
                <th>操作</th>
              </tr> 
            </thead>
            <tbody>
              <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <tr>
                  <td><?php echo htmlentities($vo['id']); ?></td>
                  <td><?php echo htmlentities($vo['name']); ?></td>
                  <td><?php echo htmlentities($vo['model']); ?></td>
                  <td><?php echo htmlentities($vo['sort']); ?></td>
                  <td> 
                    <div class=" layui-form" lay-filter="component-form-element">        
                       <input type="checkbox" name="status" <?php echo $vo['status']==1?'checked':''; ?> lay-skin="switch" lay-text="开启|关闭" lay-filter="status_change" item="<?php echo htmlentities($vo['id']); ?>">
                    </div>
                  </td>
                  <td>  <button class="layui-btn layui-btn-sm" onclick='zfAdminShow("编辑权限","<?php echo url('category/category_model_edit',['id' => $vo['id']] ); ?>")'>编辑</button> </td>
                </tr>
              <?php endforeach; endif; else: echo "" ;endif; ?>         
            </tbody>
          </table>
      </div>
    </div>
  </div>
  <script src="/public/static/style/jquery-1.8.3.min.js"></script>  
  <script src="/public/static/style/layui/layui.js"></script>    
  <script src="/public/static/system/common.js"></script>  

  <script>
 layui.use([ 'table','element'], function(){
    var $ = layui.$
    ,form = layui.form
    ,element = layui.element
    ,table = layui.table;

    form.on('switch(status_change)', function(data){
      var id = $(this).attr("item")
      var dbname = 'category_model'
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
