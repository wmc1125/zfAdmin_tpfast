<?php /*a:1:{s:40:"./template/admin/category/pic/index.html";i:1569477749;}*/ ?>


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
        <div class="layui-form layui-card-header layuiadmin-card-header-auto">
          <div class="layui-form-item">
            <form method="get">
              <div class="layui-inline">
                <label class="layui-form-label">标题</label>
                <div class="layui-input-block">
                  <input type="text" name="title" placeholder="请输入" autocomplete="off" class="layui-input">
                </div>
              </div>
              <div class="layui-inline">
                  <button class="layui-btn" ><i class="layui-icon layui-icon-search layuiadmin-button-btn"></i></button>
              </div>
            </form>
            <!-- <form onclick="return false;" class="create_info"> -->
              <div class="layui-inline">
                  <button class="layui-btn layui-btn-sm" onclick='zfAdminShow("新增内容","<?php echo url('category/post_add',['cid' => $res['cid'],'mid' => $res['mid']] ); ?>")'>新增</button> 
                  <a class="layui-btn layui-btn-sm" id="up_file" >导入</a>
              </div>
            <!-- </form> -->
          </div>
        </div>
      <div class="layui-card-body">
        <table class="layui-table">
            <colgroup>
              <col width="30">
              <col width="60">
              <col width="60">
              <col width="60">
              <col width="50">
              <col width="50">
              <col width="50">
              <col width="50">
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
              <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <tr>
                  <td><?php echo htmlentities($vo['id']); ?></td>
                  <td><?php echo htmlentities($vo['title']); ?></td>
                  <td><img src="<?php echo htmlentities($vo['pic']); ?>" style="width:50px;height:50px"/></td>
                  <td><?php echo htmlentities($vo['append']); ?></td>
                  <td><?php echo htmlentities($vo['sort']); ?></td>
                  <td><?php echo htmlentities($vo['hits']); ?></td>
                  <td> 
                    <div class=" layui-form" lay-filter="component-form-element">        
                       <input type="checkbox" name="status" <?php echo $vo['status']==1?'checked':''; ?> lay-skin="switch" lay-text="开启|关闭" lay-filter="status_change" item="<?php echo htmlentities($vo['id']); ?>">
                    </div>
                  </td>                
                  <td> 
                    <a class="layui-btn btn_del layui-btn-danger layui-btn-sm" rel="<?php echo htmlentities($vo['id']); ?>" href="#">删除</a> 
                    <a class="layui-btn  layui-btn-danger layui-btn-sm save_content-list-pic" rel="<?php echo htmlentities($vo['id']); ?>" href="#">保存图片</a> 
                    <button class="layui-btn layui-btn-sm" onclick='zfAdminShow("编辑","<?php echo url('category/post_edit',['id' => $vo['id'],'cid' => $vo['cid'],'mid' => $mid] ); ?>")'>编辑</button> 
                  </td>
                </tr>
              <?php endforeach; endif; else: echo "" ;endif; ?>         
            </tbody>
          </table>
          <?php echo $page; ?>

      </div>
    </div>
  </div>
  <script src="/public/static/style/jquery-1.8.3.min.js"></script>  
  <script src="/public/static/style/layui/layui.js"></script>    
  <script src="/public/static/system/common.js"></script>  

  <script>
 layui.use([ 'table','element','layer','upload'], function(){
    var $ = layui.$
    ,form = layui.form
    ,element = layui.element
    ,table = layui.table
    ,layer = layui.layer
    ,upload = layui.upload;

    upload.render({
      elem: '#up_file'
      ,url: "<?php echo url('category/import'); ?>?cid=<?php echo htmlentities($cid); ?>"
      ,accept: 'file' //普通文件
      ,done: function(res){
        console.log(res);
        if(res.result==1){
            layer.msg(res.msg, {icon: 1});
            setTimeout(function() {
              window.location.reload();
            }, 2000);
        }else{
          layer.msg(res.msg, {icon: 2});
        }
      }
      ,error: function(){
          layer.msg(res.msg, {icon: 2});
      }
    });

    form.on('switch(status_change)', function(data){
      var id = $(this).attr("item")
      var dbname = 'post'
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

    // 删除
    $(".btn_del").on("click",function(){
      var id = $(this).attr("rel");
      layer.confirm('确认删除？', {
        btn: ['删除','取消'] //按钮
      }, function(){
        //执行删除操作
        $.get("<?php echo url('common/del_post'); ?>",{id:id,db:'post'},function(res){
          if(res.result==1){
            layer.msg("删除成功", {icon: 1});
            setTimeout(function() {
              location.reload(true);
            }, 1000);
          }else{
            layer.msg(res.msg, {icon: 2});
            
          }
        },"json");

      }, function(){
          //取消的操作
      });
    })
    $(".save_content-list-pic").on("click",function(){
      var id = $(this).attr("rel");
      layer.confirm('确认保存？', {
        btn: ['保存','取消'] //按钮
      }, function(){
        //执行删除操作
        $.get("<?php echo url('category/get_content_pic_list'); ?>",{id:id},function(res){
          if(res.result==1){
            layer.msg("保存成功", {icon: 1});
            setTimeout(function() {
              location.reload(true);
            }, 1000);
          }else{
            layer.msg(res.msg, {icon: 2});
            
          }
        },"json");

      }, function(){
          //取消的操作
      });
    })


    
  });
  </script>
</body>
</html>
