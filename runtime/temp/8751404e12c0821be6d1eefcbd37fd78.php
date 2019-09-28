<?php /*a:2:{s:43:"./template/admin/category/article/edit.html";i:1569479027;s:35:"./template/admin/public/editor.html";i:1568165645;}*/ ?>


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
  <script type="text/javascript" src="/public/static/style/jquery-1.8.3.min.js"></script>
  <link rel="stylesheet" type="text/css" href="/public/static/style/webuploader/webuploader.css">
  <script type="text/javascript" src="/public/static/style/webuploader/webuploader.js"></script>
</head>
<body>
  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">

      <form class="info_tj" method="post"  >
        <input type="hidden" name="cid" value="<?php echo htmlentities($cid); ?>">
        <input type="hidden" name="id" value="<?php echo htmlentities($res['id']); ?>">
        <div class="layui-col-sm12">
          <div class="layui-row layui-col-space15">
              <div class="layui-col-sm9">
                <div class="layui-card">
                  <!-- <div class="layui-card-header">内容信息</div> -->
                  <br/>
                  <div class="layui-row layui-col-space10 layui-form-item">
                    
                    <div class="layui-col-lg10">
                      <div class="layui-card-header">标题</div>

                      <div class="layui-card-body layui-row layui-col-space10">
                        <div class="layui-col-md12">
                          <input type="text" name="title" placeholder="请输入标题" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['title']); ?>">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="layui-card-header">栏目描述</div>
                  <div class="layui-card-body layui-row layui-col-space12">
                    <div class="layui-col-md12">
                      <textarea name="summary" placeholder="请输入" class="layui-textarea"><?php echo htmlentities($res['summary']); ?></textarea>
                    </div>
                  </div>
                  <div class="layui-card-header">缩略图</div>
                  <div class="layui-card-body layui-row layui-col-space12">
                    <div class="layui-col-md12">
                       <div class = "row">
                          <div class="btns col-sm-2">
                            <div id="picker">选择文件</div>
                          </div>
                        <!--用来存放文件信息-->
                          <div id="thelist" class="uploader-list col-sm-10">
                            <?php if($res['album']!=''){ $pics=explode(',',$res['album']);
                                $count=count($pics);
                                for($i=0;$i<$count;$i++){?>
                                  <div id="WU_FILE_<?php echo htmlentities($i); ?>" class="file-item thumbnail layui-col-md3 upload-state-done" style="width:150px;margin-left:10px;"><img src="<?php echo htmlentities($pics[$i]); ?>"><span style="margin-left: 78%;cursor:pointer;" onclick="deleteFile(this)">删除</span><div class=""><input type="hidden" name="album_list[]" value="<?php echo htmlentities($pics[$i]); ?>"></div></div>
                            <?php }} ?>
                          </div> 
                       </div>
                    </div>
                  </div>
                  
                  <br/>
                </div>
                <div class="layui-card">
                  
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
                    <div class="layui-col-lg12" style="margin-left: -50px;">
                      <label class="layui-form-label" >作者:</label>
                      <div class="layui-input-block">
                        <input type="text" name="author"  autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['author']); ?>">
                      </div>
                    </div>
                    <div class="layui-col-lg12" style="margin-left: -50px;">
                      <label class="layui-form-label" >时间:</label>
                      <div class="layui-input-block">
                       <input type="text" name="ctime" id="LAY-component-form-group-date" lay-verify="date" placeholder="yyyy-MM-dd HH:mm:ss" autocomplete="off" class="layui-input" lay-key="1" value="<?php echo date('Y-m-d H:i:s',$res['ctime']); ?>">
                      </div>
                    </div>
                    <div class="layui-col-lg12" style="margin-left: -50px;">
                      <label class="layui-form-label" >排序:</label>
                      <div class="layui-input-block">
                        <input type="text" name="sort"  autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['sort']); ?>">
                      </div>
                    </div>
                    <div class="layui-form-item">
                      <div class="layui-input-block" style="margin-left: 50px;">
                        <input class="layui-btn tijiao"  lay-filter="component-form-element" type="button" value="发布" />
                      </div> 
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
                <div class="layui-card">
                  <div class="layui-card-header">封面图</div>
                  <div class="layui-card-body layui-row layui-col-space8">
                    <div class="layui-col-md12">
                      <input  id="main_pic" type="text" name="pic" lay-verify="required" placeholder="" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['pic']); ?>" >
                    </div>
                      <span type="button" class="layui-btn" id="up_img">上传图片</span>
                  </div>
                </div>
                <div class="layui-card">
                  <div class="layui-card-header">文件</div>
                  <div class="layui-card-body layui-row layui-col-space8">
                    <div class="layui-col-md12">
                      <input  id="main_file" type="text" name="file" lay-verify="required" placeholder="" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['file']); ?>">
                    </div>
                      <span type="button" class="layui-btn" id="up_file">上传文件</span>
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
  <script>

 layui.use(['form','upload','laydate'], function(){
    var $ = layui.$
    ,admin = layui.admin
    ,element = layui.element
    ,form = layui.form
    ,laydate = layui.laydate
    ,upload = layui.upload;
    
    

    laydate.render({
      elem: '#LAY-component-form-group-date'
      ,type: 'datetime'
    });

    $(".tijiao").on("click",function(){
      var index = layer.load(2);
      var data = $(".info_tj input,.info_tj textarea,.info_tj option").serialize();      
      $.ajax({
          type:'post',
          url:"<?php echo url('category/post_edit'); ?>",
          data:data,
          dataType:'json',
          success:function(res){
            layer.close(index);
            if(res.result==1){
              layer.msg("修改成功", {icon: 1});
              setTimeout(function() {
                window.parent.location.reload();
              }, 2000);
            }else{
              layer.msg(res.msg, {icon: 2});
              
            }
            
          }
      })
    })
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


  });

  </script>
  <script type="text/javascript"> 
      var ue = UE.getEditor('container',{
        initialFrameHeight:350,//设置编辑器高度
        scaleEnabled:false//设置不自动调整高度

      });
      function editorContent(){
        alert(ue.getContent());//获取编辑器html内容
        // alert(ue.getPlainTxt());//获取保留换行/空格等格式的纯文本
        // alert(ue.getContentTxt());//获取纯文本内容
      }


      $(function(){
      var uploader = WebUploader.create({
      // 选完文件后，是否自动上传。
      auto: true,
      // 文件接收服务端。
       server: "<?php echo url('common/upload_one'); ?>",
       // 选择文件的按钮。可选。
       // 内部根据当前运行是创建，可能是input元素，也可能是flash.
       pick: '#picker',
       // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
       resize: false,
       // 只允许选择图片文件。
       accept: {
        title: 'Images',
        extensions: 'gif,jpg,jpeg,bmp,png',
        mimeTypes: 'image/*'
       },
       /* fileSizeLimit :10, //验证文件总大小是否超出限制, 超出则不允许加入队列
       fileSingleSizeLimit :10,   //验证单个文件大小是否超出限制, 超出则不允许加入队列。 */
       duplicate :true //去重， 根据文件名字、文件大小和最后修改时间来生成hash Key.
   
      });
   
   
    // 当文件被加入队列之前触发，此事件的handler返回值为false，则此文件不会被添加进入队列。
     uploader.on( 'beforeFileQueued', function( file ) {
      // 限制图片数量
      img_length = $("#thelist img").length;
      if (img_length >= 6) {
      layer.msg("图片最多上传6张");
      return false;
      }
   
     });
   
    // 当有文件添加进来的时候
     uploader.on( 'fileQueued', function( file ) {
     var $li = $(
        '<div id="' + file.id + '" class="file-item thumbnail layui-col-md3" style="width:150px;margin-left:10px;">' +
         '<img>' +
         '<span style="margin-left: 78%;cursor:pointer;" onclick="deleteFile(this)">删除</span>' +
        '</div>'
        ),
       $img = $li.find('img');
      // $list为容器jQuery实例
      $("#thelist").append( $li );
      // 创建缩略图
      // 如果为非图片文件，可以不用调用此方法。
      // thumbnailWidth x thumbnailHeight 为 100 x 100
      uploader.makeThumb( file, function( error, src ) {
       if ( error ) {
        $img.replaceWith('<span>不能预览</span>');
        return;
       }
       $img.attr( 'src', src );
      }, 150, 150 );
   
     });
   
    // 文件上传成功，给item添加成功class, 用样式标记上传成功。
     uploader.on( 'uploadSuccess', function( file,response ) {
      $( '#'+file.id ).addClass('upload-state-done');
      var $li = $( '#'+file.id ),
       $done = $li.find('div.upload-state-done');
       console.log(response);
      // 避免重复创建
      if ( !$done.length ) {
      $done = $('<div class=""></div>').appendTo( $li );
      }
      $done.html('<input type="hidden" name="album_list[]" value="'+response.msg+'" />');
     });
    // 文件上传失败，显示上传出错。
     uploader.on( 'uploadError', function( file ) {
      var $li = $( '#'+file.id ),
       $error = $li.find('div.error');
      // 避免重复创建
      if ( !$error.length ) {
       $error = $('<div class="error"></div>').appendTo( $li );
      }
      $error.html('<font color="red">上传失败</font>');
     });
  })
  function deleteFile(obj) {
   $(obj).parent().remove();
  }
  </script>
</body>
</html>