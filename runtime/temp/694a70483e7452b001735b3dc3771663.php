<?php /*a:2:{s:44:"./template/admin/category/category_edit.html";i:1569479027;s:35:"./template/admin/public/editor.html";i:1568165645;}*/ ?>
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
    <div class="layui-row layui-col-space15">
      <form method="post" class="info_tj" >
        <input type="hidden" name="cid" value="<?php echo htmlentities($res['cid']); ?>">
        <input type="hidden" name="t" value="<?php echo htmlentities($t); ?>">
        <div class="layui-col-sm12">
          <div class="layui-row layui-col-space15">
              <div class="layui-col-sm9">
                <div class="layui-card">
                  <div class="layui-card-header">栏目信息</div>
                  <br/>
                  <div class="layui-row layui-col-space10 layui-form-item">
                    <div class="layui-col-lg6">
                      <label class="layui-form-label">栏目名称</label>
                      <div class="layui-input-block">
                        <input type="text" name="name" lay-verify="required" placeholder="" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['name']); ?>">
                      </div>
                    </div>
                  </div>
                  <div class="layui-row layui-col-space10 layui-form-item">
                    <div class="layui-col-lg6">
                      <label class="layui-form-label">英文名称</label>
                      <div class="layui-input-block">
                        <input type="text" name="ename" lay-verify="required" placeholder="" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['ename']); ?>">
                      </div>
                    </div>
                    <div class="layui-col-lg6">
                    </div>
                  </div>
                  <div class="layui-row layui-col-space10 layui-form-item">
                    <div class="layui-col-lg6">
                      <label class="layui-form-label">SEO标题</label>
                      <div class="layui-input-block">
                        <input type="text" name="sname" lay-verify="required" placeholder="" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['sname']); ?>">
                      </div>
                    </div>
                    <div class="layui-col-lg6">
                    </div>
                  </div>
                  <div class="layui-row layui-col-space10 layui-form-item">
                    <div class="layui-col-lg6">
                      <label class="layui-form-label">关键字</label>
                      <div class="layui-input-block">
                        <input type="text" name="keyword" lay-verify="required" placeholder="" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['keyword']); ?>">
                      </div>
                    </div>
                    <div class="layui-col-lg6">
                    </div>
                  </div>
                  <div class="layui-row layui-col-space10 layui-form-item">
                    <div class="layui-col-lg6">
                      <label class="layui-form-label">外部链接</label>
                      <div class="layui-input-block">
                        <input type="text" name="url" lay-verify="required" placeholder="" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['url']); ?>">
                      </div>
                    </div>
                    <div class="layui-col-lg6">
                    </div>
                  </div>
                  <div class="layui-row layui-col-space10 layui-form-item">
                    <div class="layui-col-lg6">
                      <label class="layui-form-label">栏目模板名</label>
                      <div class="layui-input-block">
                        <input type="text" name="tpl_category" lay-verify="required" placeholder="" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['tpl_category']); ?>">
                      </div>
                    </div>
                    <div class="layui-col-lg6">
                    </div>
                  </div>
                  <div class="layui-row layui-col-space10 layui-form-item">
                    <div class="layui-col-lg6">
                      <label class="layui-form-label">内容模板名</label>
                      <div class="layui-input-block">
                        <input type="text" name="tpl_post" lay-verify="required" placeholder="" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['tpl_post']); ?>">
                      </div>
                    </div>
                    <div class="layui-col-lg6">
                    </div>
                  </div>
                  <div class="layui-row layui-col-space10 layui-form-item">
                    <div class="layui-col-lg6">
                      <label class="layui-form-label">每页显示数</label>
                      <div class="layui-input-block">
                        <input type="text" name="page" lay-verify="required" placeholder="" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['page']); ?>">
                      </div>
                    </div>
                    <div class="layui-col-lg6">
                    </div>
                  </div>
                  <div class="layui-row layui-col-space10 layui-form-item">
                    <div class="layui-col-lg6">
                      <label class="layui-form-label">链接目标</label>
                      <div class="layui-input-block">
                        <input type="text" name="target" lay-verify="required" placeholder="" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['target']); ?>">
                      </div>
                    </div>
                    <div class="layui-col-lg6">
                    </div>
                  </div>
                  <br/>
                </div>
                <div class="layui-card">
                  <div class="layui-card-header">栏目描述</div>
                  <div class="layui-card-body layui-row layui-col-space12">
                    <div class="layui-col-md12">
                      <textarea name="summary" placeholder="请输入" class="layui-textarea"><?php echo htmlentities($res['summary']); ?></textarea>
                    </div>
                  </div>
                </div>
                <div class="layui-card">
                  <br>
                  <div class="layui-card-header">
                    <fieldset class="layui-elem-field layui-field-title site-title">
                      <legend><a name="quickstart">栏目详情</a></legend>
                    </fieldset>
                  </div>
                  <div class="layui-card-body">
                    
<?php if(1==1){  ?>
<script id="container" name="content" type="text/plain" ><?php echo isset($res['content'])?$res['content']:''; ?></script>
<?php if(config()['img']['pic_save_type']=='3'){  ?>
<!-- 阿里云oss-editor专用 -->
    <script type="text/javascript" src="/public/static/style/ueditor_aliyunoss/ueditor.config.js"></script>
    <script type="text/javascript" src="/public/static/style/ueditor_aliyunoss/ueditor.all.js"></script>
  	<link rel="stylesheet" type="text/css" href="/public/static/style/ueditor_aliyunoss/themes/default/css/ueditor.css" />
<?php }else{ ?>
	<script type="text/javascript" src="/public/static/style/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" src="/public/static/style/ueditor/ueditor.all.js"></script>
  	<link rel="stylesheet" type="text/css" href="/public/static/style/ueditor/themes/default/css/ueditor.css" />
<?php } ?>
<script type="text/javascript"> 
    var ue = UE.getEditor('container',{
    initialFrameHeight:350,//设置编辑器高度
    scaleEnabled:false//设置不自动调整高度
    });
</script>
<?php }else{ }?>
                  </div>
                </div>
              </div>
              <div class="layui-col-sm3">
                <div class="layui-card">
                  <div class="layui-card-header">发布</div>
                  <div class="layui-card-body layui-row layui-col-space10">
                    <div class="layui-form-item">
                      
                      <div class="layui-input-block" style="margin-left: 50px;">
                        <input class="layui-btn tj_btn layui-btn-sm"   lay-filter="component-form-element" type="button" value="发布" />
                      </div> 
                    </div>
                  </div>
                </div>
                
                <div class="layui-card">
                  <div class="layui-card-header">栏目ICON</div>
                  <div class="layui-card-body layui-row layui-col-space8">
                    <div class="layui-col-md12">
                      <input  id="main_icon" type="text" name="icon" lay-verify="required" placeholder="" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['icon']); ?>" >
                    </div>
                      <span type="button" class="layui-btn layui-btn-sm" id="up_icon">上传图片</span>
                  </div>
                </div>
                <div class="layui-card">
                  <div class="layui-card-header">封面图</div>
                  <div class="layui-card-body layui-row layui-col-space8">
                    <div class="layui-col-md12">
                      <input  id="main_pic" type="text" name="pic" lay-verify="required" placeholder="" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['pic']); ?>" >
                    </div>
                      <span type="button" class="layui-btn layui-btn-sm" id="up_img">上传图片</span>
                  </div>
                </div>
                <div class="layui-card">
                  <div class="layui-card-header">文件</div>
                  <div class="layui-card-body layui-row layui-col-space8">
                    <div class="layui-col-md12">
                      <input  id="main_file" type="text" name="file" lay-verify="required" placeholder="" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['file']); ?>">
                    </div>
                      <span type="button" class="layui-btn layui-btn-sm" id="up_file">上传文件</span>
                  </div>
                </div>

                <div class="layui-card">
                  <div class="layui-card-header">栏目模型</div>
                  <div class="layui-card-body layui-row layui-col-space10">
                      <select name="mid" lay-verify="required" lay-filter="aihao">
                        <option value="<?php echo htmlentities($res['mid']); ?>"><?php echo m_name($res['mid']); ?></option>
                        <?php foreach($mlist as $k=>$vo):?>
                          <option value="<?php echo htmlentities($vo['id']); ?>"><?php echo htmlentities($vo['name']); ?></option>
                        <?php endforeach;  ?>
                      </select>
                  </div>
                </div>
                <div class="layui-card">
                  <div class="layui-card-header">父类</div>
                  <div class="layui-card-body layui-row layui-col-space10">
                     <select name="pid" lay-verify="required" lay-filter="aihao">
                       <option value="<?php echo htmlentities($res['pid']); ?>"><?php echo p_name($res['pid']); ?></option>
                       <?php foreach($plist as $k=>$vo):if($vo['pid']==0 && $vo['cid']!= $res['cid']): ?>
                         <option value="<?php echo htmlentities($vo['cid']); ?>"><?php echo htmlentities($vo['cname']); ?></option>
                         <?php foreach($plist as $k2 =>$vo2): if($vo2['pid']==$vo['cid'] && $vo2['cid']!= $res['cid']): ?>
                         <option value="<?php echo htmlentities($vo2['cid']); ?>"><?php echo htmlentities($vo2['cname']); ?></option>
                         <?php endif; ?>
                         <?php endforeach; ?>
                       <?php endif; endforeach; ?>
                      </select>
                  </div>
                </div>
                <div class="layui-card">
                  <div class="layui-card-header">排序</div>
                  <div class="layui-card-body layui-row layui-col-space8">
                    <div class="layui-col-md12">
                      <input type="text" name="sort" lay-verify="required" placeholder="" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['sort']); ?>">
                    </div>
                  </div>
                </div>
                <div class="layui-card">
                  <div class="layui-card-header">扩展参数</div>
                  <div class="layui-card-body layui-row layui-col-space8">
                    <div class="layui-col-md12">
                      <textarea name="append" placeholder="请输入" class="layui-textarea"><?php echo htmlentities($res['append']); ?></textarea>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </form>
        
      </div>
    </div>
  </div>
  
  <script src="/public/static/style/layui/layui.js"></script>    
  <script type="text/javascript" src="/public/static/system/common.js"></script>  

  <script>

 layui.use(['form','upload'], function(){
    var $ = layui.$
    ,admin = layui.admin
    ,element = layui.element
    ,form = layui.form
    ,upload = layui.upload;

    

    upload.render({
      elem: '#up_img'
      ,url: "<?php echo url('common/upload_one'); ?>"
      ,done: function(res){
        console.log(res)
        if(res.result==1){
            layer.msg("上传成功", {icon: 1});
            $("#main_pic").val(res.msg);
        }else{
          layer.msg(res.msg, {icon: 2});
        }
      }
    });
    upload.render({
      elem: '#up_file'
      ,url: "<?php echo url('common/upload_one_file'); ?>"
      ,accept: 'file' //普通文件
      ,done: function(res){
        console.log(res)
        if(res.result==1){
            layer.msg("上传成功", {icon: 1});
            $("#main_file").val(res.msg);
        }else{
          layer.msg(res.msg, {icon: 2});
        }
      }
    });
    upload.render({
      elem: '#up_icon'
      ,url: "<?php echo url('common/upload_one'); ?>"
      ,accept: 'file' //普通文件
      ,done: function(res){
        console.log(res)
        if(res.result==1){
            layer.msg("上传成功", {icon: 1});
            $("#main_icon").val(res.msg);
        }else{
          layer.msg(res.msg, {icon: 2});
        }
      }
    });
    $('.tj_btn').on("click",function(){
        var index = layer.load(2);
        var data = $(".info_tj input,.info_tj select,.info_tj textarea,.info_tj option,.info_tj radio").serialize();      
        $.ajax({
            type:'post',
            url:"<?php echo url('category/category_edit'); ?>",
            data:data,
            dataType:'json',
            success:function(res){
              if(res.result==1){
                layer.msg(res.msg.msg, {icon: 1});
                setTimeout(function() {
                    if(res.msg.code==1){
                      window.location.reload();
                    }else{
                      window.parent.location.reload();
                    }
                }, 2000);
              }else{
                layer.close(index);
                layer.msg(res.msg, {icon: 2});
              }   
            }
        })
    })
    


  });
  </script>
</body>
</html>

