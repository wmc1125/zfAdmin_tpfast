<?php
namespace app\common\widget;
use think\Controller;
class Form {
   public function __construct (){
        $this->upload_one  = siteUrl('common/upload/upload_one');
        $this->upload_one_file  = siteUrl('common/upload/upload_one_file');
        $this->filesystem_upload  = siteUrl('widget/Fileupload/upload');
        $this->meditor_upload  = siteUrl('common/upload/meditor_upload_one');

    }

    /**
     * @Notes    input输入框
     * @Author   子枫
     * @DateTime 2020-08-21
     * @Email    287851074@qq.com
     * @param    string           $title [description]
     * @param    string           $name  [description]
     * @param    string           $data  [description]
     * @return   [type]                  [description]
     */
    public function form_input($title='',$name='',$data='')
    {
        $tpl_id='zf_'.mt_rand().'_'.time();
        $zf_html = <<<INFO
 <div class="layui-card-header">$title</div>
<div class="layui-card-body layui-row layui-col-space8">
    <div class="layui-col-md12">
      <input  class="layui-input " type="text" name="$name" lay-verify="required" placeholder="" autocomplete="off"  value="$data">
    </div>
</div>
INFO;
        return $zf_html;
    }

    /**
     * @Notes    text输入框
     * @Author   子枫
     * @DateTime 2020-08-21
     * @Email    287851074@qq.com
     * @param    string           $title [description]
     * @param    string           $name  [description]
     * @param    string           $data  [description]
     * @return   [type]                  [description]
     */
    public function form_textarea($title='',$name='',$data='')
    {
        $tpl_id='zf_'.mt_rand().'_'.time();
        $zf_html = <<<INFO
 <div class="layui-card-header">$title</div>
<div class="layui-card-body layui-row layui-col-space8">
    <div class="layui-col-md12">
      <textarea name="$name" placeholder="请输入" class="layui-textarea">{$data}</textarea>
    </div>
</div>
INFO;
        return $zf_html;
    }
    public function form_time($title='',$name='',$data='')
    {
        $tpl_id='zf_'.mt_rand().'_'.time();
        $zf_html = <<<INFO
 <div class="layui-card-header">$title</div>
<div class="layui-card-body layui-row layui-col-space8">
    <div class="layui-col-md12">
      <input type="text" name="$name" id="$name" lay-verify="date" placeholder="yyyy-MM-dd HH:mm:ss" autocomplete="off" class="layui-input" lay-key="1" value="{$data}">
    </div>
</div>
 <script>
 layui.use(['form','upload','laydate'], function(){
    var $ = layui.$
    ,element = layui.element
    ,form = layui.form
    ,laydate = layui.laydate;
    laydate.render({
      elem: "#$name"
      ,type: 'datetime'
    });
  });
</script>

INFO;
        return $zf_html;
    }
    public function form_select($title='',$name='',$data='',$list=[],$id_t='id')
    {
        $tpl_id='zf_'.mt_rand().'_'.time();
        $zf_html = '
        <div class="layui-card-header">'.$title.'</div>
                  <div class="layui-card-body layui-row layui-col-space10">
                     <select name="'.$name.'" >';
                      foreach($list as $k=>$vo){
                           $zf_html .= '<option value="'.$vo[$id_t].'" ';
                           if($data==$vo[$id_t]){
                            $zf_html.='selected';
                           }
                            $zf_html.='> ┃'.str_repeat('━━', substr_count($vo['cname'],'  ')).$vo['name'].'</option>';
                      }
                      $zf_html.='</select>
                  </div>
                  ';
        return $zf_html;
    }

    public function form_select_simple($title='',$name='',$data='',$list=[],$id_t='id')
    {
        $tpl_id='zf_'.mt_rand().'_'.time();
        $zf_html = '
        <div class="layui-card-header">'.$title.'</div>
                  <div class="layui-card-body layui-row layui-col-space10">
                     <select name="'.$name.'" >';
                      foreach($list as $k=>$vo){
                           $zf_html .= '<option value="'.$vo.'" ';
                           if($data==$id_t){
                            $zf_html.='selected';
                           }
                            $zf_html.='> '.$vo.'</option>';
                      }
                      $zf_html.='</select>
                  </div>
                  ';
        return $zf_html;
    }
    public function form_select_arr($title='',$name='',$data='',$list=[],$id_t='id')
    {
        $tpl_id='zf_'.mt_rand().'_'.time();
        $zf_html = '
        <div class="layui-card-header">'.$title.'</div>
                  <div class="layui-card-body layui-row layui-col-space10">
                     <select name="'.$name.'" >';
                      foreach($list as $k=>$vo){
                           $zf_html .= '<option value="'.$vo[$id_t].'" ';
                           if($data==$vo[$id_t]){
                            $zf_html.='selected';
                           }
                            $zf_html.='> '.$vo['title'].'</option>';
                      }
                      $zf_html.='</select>
                  </div>
                  ';
        return $zf_html;
    }
    /**
     * @Notes    图片上传
     * @Author   子枫
     * @DateTime 2020-08-21
     * @Email    287851074@qq.com
     * @param    string           $title [description]
     * @param    string           $name  [description]
     * @param    string           $data  [description]
     * @return   [type]                  [description]
     */
    public function upload_pic($title='',$name='',$data='')
    {
        $tpl_id='zf_'.mt_rand().'_'.time();
        $zf_html = <<<INFO
 <div class="layui-card-header">$title</div>
<div class="layui-card-body layui-row layui-col-space8">
    <div class="layui-col-md12">
      <input  class="layui-input $tpl_id" type="text" name="$name" lay-verify="required" placeholder="" autocomplete="off"  value="$data">
        <div class="layui-upload">
          <button type="button" class="layui-btn" id="$tpl_id">上传图片</button>
          <div class="layui-upload-list">
            <img class="layui-upload-img $tpl_id" style="max-height:200px" src="$data" >
            <p id="demoText"></p>
          </div>
        </div> 
    </div>
</div>
 <script>
 layui.use(['form','upload','laydate'], function(){
    var $ = layui.$
    ,element = layui.element
    ,form = layui.form
    ,upload = layui.upload;
    
    upload.render({
      elem: '#$tpl_id'
      ,url: "$this->upload_one"
      ,done: function(res){
        console.log(res)
        if(res.result==1){
            layer.msg("上传成功", {icon: 1});
            $(".$tpl_id").val(res.msg);
            $('.$tpl_id').attr('src', res.msg);
        }else{
          layer.msg(res.msg, {icon: 2});
        }
      }
    });
  });
</script>
INFO;
        return $zf_html;
    }
    
    /**
     * @Notes    文件上传
     * @Author   子枫
     * @DateTime 2020-08-21
     * @Email    287851074@qq.com
     * @param    string           $title [description]
     * @param    string           $name  [description]
     * @param    string           $data  [description]
     * @return   [type]                  [description]
     */
    public function upload_file($title='',$name='',$data='')
    {
        $tpl_id='zf_'.mt_rand().'_'.time();
        $zf_html = <<<INFO
 <div class="layui-card-header">$title</div>
<div class="layui-card-body layui-row layui-col-space8">
    <div class="layui-col-md12">
      <input  class="layui-input $tpl_id" type="text" name="$name" lay-verify="required" placeholder="" autocomplete="off"  value="$data">
    </div>
    <span type="button" class="layui-btn layui-btn-sm" id="$tpl_id">上传文件</span>
</div>
 <script>
 layui.use(['form','upload','laydate'], function(){
    var $ = layui.$
    ,element = layui.element
    ,form = layui.form
    ,upload = layui.upload;
    
    upload.render({
      elem: '#$tpl_id'
      ,url: "$this->upload_one_file"
      ,accept: 'file'
      ,done: function(res){
        console.log(res)
        if(res.result==1){
            layer.msg("上传成功", {icon: 1});
            $(".$tpl_id").val(res.msg);
        }else{
          layer.msg(res.msg, {icon: 2});
        }
      }
    });
  });
</script>
INFO;
        return $zf_html;
    }
    /**
     * @Notes    图集上传
     * @Author   子枫
     * @DateTime 2020-08-21
     * @Email    287851074@qq.com
     * @param    string           $title [description]
     * @param    string           $name  [description]
     * @param    string           $data  [description]
     * @return   [type]                  [description]
     */
    public function upload_album($title='',$name='',$data='')
    {
        $tpl_id='zf_'.mt_rand().'_'.time();

        if($data!='' && $data!=[]){
          $pics=explode(',',$data);
          $count=count($pics);
        }else{
          $count=0;
        }
        $zf_html ='';

        $zf_html .='
 <div class="layui-card-header">'.$title.'</div>
<div class="layui-card-body layui-row layui-col-space8">
    <div class="layui-col-md12">
        <div class="layui-upload">
          <button type="button" class="layui-btn" id="'.$tpl_id.'">上传'.$title.'</button>
          <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
              预览图：
              <div class="layui-row '.$tpl_id.'">';

                  for($i=0;$i<$count;$i++){
                    $zf_html .='<div class> <img src="'.$pics[$i].'" class="layui-upload-img"  style="width:150px;margin-left:10px;" > 
                      <input type="hidden" name="zf_list_'.$name.'" value="'.$pics[$i].'" /><span style="margin-left: 78%;cursor:pointer;" onclick="deleteFile(this)">删除</span>
                    </div>';
                  }
              $zf_html .='</div>
          </blockquote>
        </div> 
    </div>
</div>';
$zf_html .=<<<INFO
 <script>
 layui.use(['form','upload','laydate'], function(){
    var $ = layui.$
    ,element = layui.element
    ,form = layui.form
    ,upload = layui.upload;
    
     upload.render({
      elem: '#$tpl_id'
      ,url: "$this->upload_one"
      ,multiple: true
      ,before: function(obj){
      }
      ,done: function(res){
        console.log(res)
        if(res.result==1){
            layer.msg('上传成功', {icon: 1});
            console.log('---start---')
            $('.$tpl_id').append('<div class> <img src="'+ res.msg +'" class="layui-upload-img"  style="width:150px;margin-left:10px;" > ')
            $('.$tpl_id').append('<input type="hidden" name="zf_list_$name" value="'+ res.msg +'" /><span style="margin-left: 78%;cursor:pointer;" onclick="deleteFile(this)">删除</span>')
            $('.$tpl_id').append('</div>')
            console.log('---end---')
        }else{
          layer.msg(res.msg, {icon: 2});
        }
      }

    });

  });
</script>
INFO;
        return $zf_html;
    }

    /**
     * @Notes    图片上传(从列表中上传)
     * @Author   子枫
     * @DateTime 2020-08-21
     * @Email    287851074@qq.com
     * @param    string           $title [description]
     * @param    string           $name  [description]
     * @param    string           $data  [description]
     * @return   [type]                  [description]
     */
    public function filesystem_pic($title='',$name='',$data='')
    {
        $tpl_id='zf_'.mt_rand().'_'.time();
        $zf_html = <<<INFO
 <div class="layui-card-header">$title</div>
<div class="layui-card-body layui-row layui-col-space8">
    <div class="layui-col-md12">
      <input  class="layui-input $tpl_id" type="text" name="$name" lay-verify="required" placeholder="" autocomplete="off"  value="$data">
        <div class="layui-upload">
          <button type="button" class="layui-btn" id="$tpl_id">选择图片</button>
          <div class="layui-upload-list">
            <img class="layui-upload-img $tpl_id" style="max-width:100%" src="$data" >
            <p id="demoText"></p>
          </div>
        </div> 
    </div>
</div>
 <script>
 layui.use(['form','upload','laydate'], function(){
    var $ = layui.$
    ,element = layui.element
    ,form = layui.form
    ,upload = layui.upload;
    $('#$tpl_id').on('click',function(){
      layer.open({
        type: 2,
        area: ['1100px', '700px'],
        fixed: false,
        maxmin: true,
        content: "$this->filesystem_upload&t=1&zf_class=.$tpl_id"
      });
    })


  });
</script>
INFO;
        return $zf_html;
    }
    /**
     * @Notes    图集上传(从列表中上传)
     * @Author   子枫
     * @DateTime 2020-08-21
     * @Email    287851074@qq.com
     * @param    string           $title [description]
     * @param    string           $name  [description]
     * @param    string           $data  [description]
     * @return   [type]                  [description]
     */
    public function filesystem_album($title='',$name='',$data='')
    {
        $tpl_id='zf_'.mt_rand().'_'.time();

        if($data!='' && $data!=[]){
          $pics=explode(',',$data);
          $count=count($pics);
        }else{
          $count=0;
        }
        $zf_html ='';

        $zf_html .='
 <div class="layui-card-header">'.$title.'</div>
<div class="layui-card-body layui-row layui-col-space8">
    <div class="layui-col-md12">
        <div class="layui-upload">
          <button type="button" class="layui-btn" id="'.$tpl_id.'">上传'.$title.'</button>
          <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
              预览图：
              <div class="layui-row '.$tpl_id.'">';

                  for($i=0;$i<$count;$i++){
                    $zf_html .='<div class> <img src="'.$pics[$i].'" class="layui-upload-img"  style="width:150px;margin-left:10px;" > 
                      <input type="hidden" name="zf_list_'.$name.'" value="'.$pics[$i].'" /><span style="margin-left: 78%;cursor:pointer;" onclick="deleteFile(this)">删除</span>
                    </div>';
                  }
              $zf_html .='</div>
          </blockquote>
        </div> 
    </div>
</div>';
$zf_html .=<<<INFO
 <script>
 layui.use(['form','upload','laydate'], function(){
    var $ = layui.$
    ,element = layui.element
    ,form = layui.form
    ,upload = layui.upload;

    $('#$tpl_id').on('click',function(){
      layer.open({
        type: 2,
        area: ['1100px', '700px'],
        fixed: false,
        maxmin: true,
        content: "$this->filesystem_upload&t=2&zf_class=.$tpl_id"
      });
    })
  });
</script>
INFO;
        return $zf_html;
    }
    /**
     * @Notes    文件上传(从列表中上传)
     * @Author   子枫
     * @DateTime 2020-08-21
     * @Email    287851074@qq.com
     * @param    string           $title [description]
     * @param    string           $name  [description]
     * @param    string           $data  [description]
     * @return   [type]                  [description]
     */
    public function filesystem_file($title='',$name='',$data='')
    {
        $tpl_id='zf_'.mt_rand().'_'.time();
        $zf_html = <<<INFO
 <div class="layui-card-header">$title</div>
<div class="layui-card-body layui-row layui-col-space8">
    <div class="layui-col-md12">
      <input  class="layui-input $tpl_id" type="text" name="$name" lay-verify="required" placeholder="" autocomplete="off"  value="$data">
        <div class="layui-upload">
          <button type="button" class="layui-btn" id="$tpl_id">选择文件</button>
        </div> 
    </div>
</div>
 <script>
 layui.use(['form','upload','laydate'], function(){
    var $ = layui.$
    ,element = layui.element
    ,form = layui.form
    ,upload = layui.upload;
    
    $('#$tpl_id').on('click',function(){
      layer.open({
        type: 2,
        area: ['1100px', '700px'],
        fixed: false,
        maxmin: true,
        content: "$this->filesystem_upload&t=3&zf_class=.$tpl_id"
      });
    })


  });
</script>
INFO;
        return $zf_html;
    }
    /**
     * @Notes    ueditor编辑器
     * @Author   子枫
     * @DateTime 2020-08-21
     * @Email    287851074@qq.com
     * @param    string           $title [description]
     * @param    string           $name  [description]
     * @param    string           $data  [description]
     * @return   [type]                  [description]
     */
    public function form_ueditor($title='',$name='',$data=''){
        $tpl_id='zf_'.mt_rand().'_'.time();
        $zf_html = <<<INFO
            <div class="layui-card-header">
              <fieldset class="layui-elem-field layui-field-title site-title">
                <legend><a name="quickstart">$title</a></legend>
              </fieldset>
            </div>
            <div class="layui-card-body">
                <script id="$tpl_id" name="$name" type="text/plain" >$data</script>
            </div>
<script type="text/javascript"> 
var ue = UE.getEditor("$tpl_id",{
  initialFrameHeight:350,
  scaleEnabled:false
});
</script>
INFO;
        return $zf_html;
    }
    /**
     * @Notes    tinymce编辑器
     * @Author   子枫
     * @DateTime 2020-08-21
     * @Email    287851074@qq.com
     * @param    string           $title [description]
     * @param    string           $name  [description]
     * @param    string           $data  [description]
     * @return   [type]                  [description]
     */
    public function form_tinymce($title='',$name='',$data=''){
        $tpl_id='zf_'.mt_rand().'_'.time();
        $zf_html = <<<INFO
            <div class="layui-card-header">
              <fieldset class="layui-elem-field layui-field-title site-title">
                <legend><a name="quickstart">$title</a></legend>
              </fieldset>
            </div>
            <div class="layui-card-body">
                <textarea name="$name" id="$tpl_id">
                     $data
                </textarea>
            </div>
<script type="text/javascript"> 
tinymce.init({
    selector: '#$tpl_id',
    menubar:false,
    height: 500,
    language: 'zh_CN',
    convert_urls: false,
    plugins : ['advlist','autolink','link','code','image','preview','searchreplace','table','wordcount','media','fullscreen','codesample','axupimgs','powerpaste'], 
    toolbar: ' undo redo | fontselect styleselect | forecolor bold italic searchreplace |  alignleft aligncenter alignright  | link image axupimgs media table codesample | code preview fullscreen',
    
    powerpaste_word_import: 'propmt',
    powerpaste_html_import: 'propmt',
    powerpaste_allow_local_images: true,
    paste_data_images: true,

    images_upload_handler: function (blobInfo, succFun, failFun) {
        var xhr, formData;
        var file = blobInfo.blob();
        xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', "$this->upload_one");
        var token = 'wx:zifeng1788';
        xhr.setRequestHeader("X-CSRF-Token", token);
        xhr.onload = function() {
            var json;
            if (xhr.status != 200) {
                failFun('HTTP Error: ' + xhr.status);
                return;
            }
            json = JSON.parse(xhr.responseText);
            if (!json ||  json.result != '1') {
                failFun('Invalid JSON: ' + xhr.responseText);
                return;
            }
            succFun(json.msg);
        };
        formData = new FormData();
        formData.append('file', file, file.name );
        xhr.send(formData);
    },
    mobile: {
      menubar: false
  },
    file_picker_types: 'media', 
    file_picker_callback: function(cb, value, meta) {
      if (meta.filetype == 'media'){
            let input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.onchange = function(){
                let file = this.files[0];
                let xhr, formData;
                xhr = new XMLHttpRequest();
                xhr.open('POST', "$this->upload_one_file");
                var token = 'wx:zifeng1788';
              xhr.setRequestHeader("X-CSRF-Token", token);
                xhr.withCredentials = self.credentials;
                xhr.upload.onprogress = function (e) {
                };
                xhr.onerror = function () {
                  console.log(xhr.status);
                  return;
                };
                xhr.onload = function () {
                  let json;
                  if (xhr.status < 200 || xhr.status >= 300) {
                    console.log('HTTP 错误: ' + xhr.status);
                    return;
                  }
                  json = JSON.parse(xhr.responseText);
                  if(json.result==1){
                    let mediaLocation=json.msg;
                    cb(mediaLocation, { title: file.name });
                  }else{
                    console.log(json.msg);
                    return;
                  }
                };
                formData = new FormData();
                formData.append('file', file);
                xhr.send(formData);
            }
            input.click();
        }
    }
  });


</script>
INFO;
        return $zf_html;
    }

    /**
     * @Notes    wangeditor编辑器
     * @Author   子枫
     * @DateTime 2020-08-21
     * @Email    287851074@qq.com
     * @param    string           $title [description]
     * @param    string           $name  [description]
     * @param    string           $data  [description]
     * @return   [type]                  [description]
     */
    public function form_wangeditor($title='',$name='',$data=''){
        $tpl_id='zf_'.mt_rand().'_'.time();
        $zf_html = <<<INFO
            <div class="layui-card-header">
              <fieldset class="layui-elem-field layui-field-title site-title">
                <legend><a name="quickstart">$title</a></legend>
              </fieldset>
            </div>
            <div class="layui-card-body">
                <div  class="fabu_editor " id="$tpl_id">$data</div>
                <textarea class="$tpl_id" style="width:100%; height:200px;" name="$name" hidden="">$data</textarea>
            </div>
<script>
$(function (){
    var E = window.wangEditor
    var $tpl_id = new E("#$tpl_id")
    var text1 = $(".$tpl_id")
    $tpl_id.customConfig.onchange = function (html) {
        text1.val(html)
    }
    $tpl_id.customConfig.debug = true;
    $tpl_id.customConfig.pasteFilterStyle = false
    $tpl_id.customConfig.pasteIgnoreImg = true
    $tpl_id.customConfig.uploadFileName = 'file'; 
    $tpl_id.customConfig.uploadImgServer = "$this->upload_one"; 
    $tpl_id.customConfig.uploadImgMaxSize = 3 * 1024 * 1024; 
    $tpl_id.customConfig.uploadImgHooks = {
      customInsert: function (insertImg, result, $tpl_id) {
        if(result.result==1){
          var url = result.msg
          insertImg(url)
        }else{
          layer.msg(上传失败,{icon: 2})
        }
      }
    }
    $tpl_id.create()
    text1.val($tpl_id.txt.html())
});
</script>


INFO;
        return $zf_html;
    }

    /**
     * @Notes    meditor编辑器
     * @Author   子枫
     * @DateTime 2020-08-21
     * @Email    287851074@qq.com
     * @param    string           $title [description]
     * @param    string           $name  [description]
     * @param    string           $data  [description]
     * @return   [type]                  [description]
     */
     public function form_meditor($title='',$name='',$data=''){
        $tpl_id='zf_'.mt_rand().'_'.time();
        $zf_html = <<<INFO
            <div class="layui-card-header">
              <fieldset class="layui-elem-field layui-field-title site-title">
                <legend><a name="quickstart">$title</a></legend>
              </fieldset>
            </div>
            <div class="layui-card-body">
                <div id="$name">
                    <textarea name="$name" style="display: none;">$data</textarea>
                </div>
            </div>
 <script type="text/javascript">
var $name;
$(function() {
$name = editormd("$name", {
    width: "90%",
    height: 740,
    path : "/vendor/wmc1125/tpfast-public/public/static/style/meditor/lib/",
    theme : "dark",
    previewTheme : "dark",
    editorTheme : "pastel-on-dark",
    codeFold : true,
    saveHTMLToTextarea : true,   
    searchReplace : true,
    htmlDecode : "style,script,iframe|on*",           
    emoji : true,
    taskList : true,
    tocm            : true,        
    tex : true,                  
    flowChart : true,            
    sequenceDiagram : true,      

    imageUpload : true,
    imageFormats : ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
    imageUploadURL : "$this->meditor_upload",
    onload : function() {
        console.log('onload', this);
    }
});
  
  $("#goto-line-btn").bind("click", function(){
      testEditor.gotoLine(90);
  });
  
  $("#show-btn").bind('click', function(){
      testEditor.show();
  });
  
  $("#hide-btn").bind('click', function(){
      testEditor.hide();
  });
  
  $("#get-md-btn").bind('click', function(){
      alert(testEditor.getMarkdown());
  });
  
  $("#get-html-btn").bind('click', function() {
      alert(testEditor.getHTML());
  });                
  
  $("#watch-btn").bind('click', function() {
      testEditor.watch();
  });                 
  
  $("#unwatch-btn").bind('click', function() {
      testEditor.unwatch();
  });              
  
  $("#preview-btn").bind('click', function() {
      testEditor.previewing();
  });
  
  $("#fullscreen-btn").bind('click', function() {
      testEditor.fullscreen();
  });
  
  $("#show-toolbar-btn").bind('click', function() {
      testEditor.showToolbar();
  });
  
  $("#close-toolbar-btn").bind('click', function() {
      testEditor.hideToolbar();
  });
  
  $("#toc-menu-btn").click(function(){
      testEditor.config({
          tocDropdown   : true,
          tocTitle      : "目录 Table of Contents",
      });
  });
  
  $("#toc-default-btn").click(function() {
      testEditor.config("tocDropdown", false);
  });
});
</script>

INFO;
        return $zf_html;
    }


//      public function form_layui_checkbox($title='',$name='',$list_str='',$id_t='id')
//     {
//         $tpl_id='zf_'.mt_rand().'_'.time();
//         $list = explode(',', $list_str);
//         $zf_html = '
//         <div class="layui-card-header">'.$title.'</div>
//             <div class="layui-card-body layui-row layui-col-space8 ">
//               <div class="layui-col-md12 layui-form-item">
//                 <div class="layui-input-inline" style="width: 100%">';
//                 foreach($list as $k=>$vo){
//                     $zf_html.= $vo.':<input type="checkbox" name="'.$name.'[]" lay-skin="primary" title="'.$vo.'" value="'.$vo.'" />';
//                  }
//                   $zf_html.='</div>
//               </div>
//             </div>
//             <script>
// layui.use(["form"], function(){
// var $ = layui.$
// ,form = layui.form
// ,element = layui.element;
// });
// </script>
//                   ';
//         return $zf_html;
//     }






    
   


   
}