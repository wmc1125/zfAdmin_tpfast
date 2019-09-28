<?php /*a:1:{s:39:"./template/admin/config/img_config.html";i:1569564138;}*/ ?>


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
      <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-header">图片操作设置</div>

          <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
            <ul class="layui-tab-title">
              <li class="layui-this">基本设置</li>
              <li>七牛云OSS</li>
               <li>又拍云OSS</li>
              <li>阿里云OSS</li>
              <!-- <li>腾讯云OSS</li> -->
            </ul>
            <div class="layui-tab-content" style="height: 100%;">
              <div class="layui-tab-item layui-show">
                <form class="layui-form info_tj" onclick="return false;" >
                  <div class="layui-row layui-col-space10 layui-form-item">
                    <div class="layui-col-lg5">
                      <label class="layui-form-label">保存路径:</label>
                      <div class="layui-input-block">
                        <input type="text" name="save_path"  placeholder="" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['save_path']); ?>" >
                      </div>
                    </div>
                    <!-- <div class="layui-col-lg5"></div> -->
                  </div>
                  <div class="layui-row layui-col-space10 layui-form-item">
                    <div class="layui-col-lg5">
                      <label class="layui-form-label">水印路径:</label>
                      <div class="layui-input-block">
                        <input type="text" name="water_path"  placeholder="" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['water_path']); ?>" >
                      </div>
                    </div>
                    <!-- <div class="layui-col-lg5"></div> -->
                  </div>
                  <div class="layui-row layui-col-space10 layui-form-item">
                    <div class="layui-col-lg5">
                      <label class="layui-form-label">水印图片透明度:</label>
                      <div class="layui-input-block">
                        <input type="text" name="water_clarity"  placeholder="" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['water_clarity']); ?>" >
                      </div>
                    </div>
                    <div class="layui-col-lg5"> 0~100，默认值是100 </div>
                  </div>
                  <div class="layui-row layui-col-space10 layui-form-item">
                    <div class="layui-col-lg5">
                      <label class="layui-form-label">水印文字内容:</label>
                      <div class="layui-input-block">
                        <input type="text" name="water_text"  placeholder="" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['water_text']); ?>" >
                      </div>
                    </div>
                    <!-- <div class="layui-col-lg5"></div> -->
                  </div>
                  <div class="layui-row layui-col-space10 layui-form-item">
                    <div class="layui-col-lg5">
                      <label class="layui-form-label">水印文字大小:</label>
                      <div class="layui-input-block">
                        <input type="text" name="water_text_size"  placeholder="" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['water_text_size']); ?>" >
                      </div>
                    </div>
                    <!-- <div class="layui-col-lg5"></div> -->
                  </div>
                  <div class="layui-row layui-col-space10 layui-form-item">
                    <div class="layui-col-lg5">
                      <label class="layui-form-label">水印文字颜色:</label>
                      <!-- <div class="layui-input-block">
                        <input type="text" name="water_text_color"  placeholder="" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['water_text_color']); ?>" >
                      </div> -->
                      <div class="layui-input-inline" style="width: 120px;">
                        <input type="text" name="water_text_color" value="<?php echo htmlentities($res['water_text_color']); ?>" placeholder="请选择颜色" class="layui-input" id="water_text_color">
                      </div>
                      <div class="layui-inline" style="left: -11px;">
                        <div id="test-form"></div>
                      </div>
                    </div>
                    <!-- <div class="layui-col-lg5"></div> -->
                  </div>
                  <div class="layui-row layui-col-space10 layui-form-item">
                    <div class="layui-col-lg5">
                      <label class="layui-form-label">水印字体路径:</label>
                      <div class="layui-input-block">
                        <input type="text" name="water_font_path"  placeholder="" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['water_font_path']); ?>" >
                      </div>
                    </div>
                    <!-- <div class="layui-col-lg5"></div> -->
                  </div>
                  <div class="layui-row layui-col-space10 layui-form-item">
                    <div class="layui-col-lg5">
                      <label class="layui-form-label">水印位置:</label>
                      <div class="layui-input-block">
                        <input type="text" name="water_position"  placeholder="" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['water_position']); ?>" >
                      </div>
                    </div>
                    <div class="layui-col-lg5">
                      <pre>
                        1  2  3
                        4  5  6
                        7  8  9
                      </pre>
                    </div>
                  </div>
                  <div class="layui-row layui-col-space10 layui-form-item">
                    <div class="layui-col-lg5">
                      <label class="layui-form-label">使用水印:</label>
                      <div class="layui-input-block">
                        <input type="text" name="is_water"  placeholder="" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['is_water']); ?>" >
                      </div>
                    </div>
                    <div class="layui-col-lg5">0 不使用   1 图片水印   2文字水印 </div>
                  </div>
                  <div class="layui-row layui-col-space10 layui-form-item">
                    <div class="layui-col-lg5">
                      <label class="layui-form-label">图片储存方式:</label>
                      <div class="layui-input-block">
                        <input type="text" name="pic_save_type"  placeholder="" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['pic_save_type']); ?>" >
                      </div>
                    </div>
                    <div class="layui-col-lg5">0 本地  3阿里云oss  </div>
                  </div>
                  <div class="layui-row layui-col-space10 layui-form-item">
                    <div class="layui-col-lg5">
                      <label class="layui-form-label">文件储存方式:</label>
                      <div class="layui-input-block">
                        <input type="text" name="file_save_type"  placeholder="" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['file_save_type']); ?>" >
                      </div>
                    </div>
                    <div class="layui-col-lg5">0 本地  3阿里云oss  </div>
                  </div>
                  <!-- <div class="layui-form-item">
                    <label class="layui-form-label">描述:</label>
                    <div class="layui-input-block">
                      <textarea name="summary" placeholder="" class="layui-textarea"></textarea>
                    </div>
                  </div> -->
                  <div class="layui-form-item">
                    <div class="layui-input-block">
                      <button class="layui-btn layui-btn-sm" onclick="tijiao_data('config/img_config',0)"  lay-submit="" lay-filter="component-form-element">提交</button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="layui-tab-item">
                <form class="info_tj" >
                  <input type="hidden" name="type" value="qny">
                  <div class="layui-form"  lay-filter="">
                    <div class="layui-row layui-col-space10 layui-form-item">
                      <div class="layui-col-lg6">
                        <label class="layui-form-label">ACCESSKEY:</label>
                        <div class="layui-input-block"> 
                          <input type="text" name="qn_ACCESSKEY"  placeholder="" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['qn_ACCESSKEY']); ?>" >
                        </div>
                      </div>
                      <div class="layui-col-lg4">
                        <label>*七牛秘钥中的AK</label>
                      </div>
                    </div>
                    <div class="layui-row layui-col-space10 layui-form-item">
                      <div class="layui-col-lg6">
                        <label class="layui-form-label">SECRETKEY:</label>
                        <div class="layui-input-block"> 
                          <input type="text" name="qn_SECRETKEY"  placeholder="" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['qn_SECRETKEY']); ?>" >
                        </div>
                      </div>
                      <div class="layui-col-lg4">
                        <label >*七牛秘钥中的SK</label>
                      </div>
                    </div>
                    <div class="layui-row layui-col-space10 layui-form-item">
                      <div class="layui-col-lg6">
                        <label class="layui-form-label">储存空间名:</label>
                        <div class="layui-input-block"> 
                          <input type="text" name="qn_BUCKET"  placeholder="" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['qn_BUCKET']); ?>" >
                        </div>
                      </div>
                      <div class="layui-col-lg4">
                        <label >*七牛对象存储空间名称</label>
                      </div>
                    </div>
                    <div class="layui-row layui-col-space10 layui-form-item">
                      <div class="layui-col-lg6">
                        <label class="layui-form-label">域名:</label>
                        <div class="layui-input-block"> 
                          <input type="text" name="qn_DOMAIN"  placeholder="" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['qn_DOMAIN']); ?>" >
                        </div>
                      </div>
                      <div class="layui-col-lg4">
                        <label > *绑定的加速域名或测试域名</label>
                      </div>
                    </div>
                     <div class="layui-form-item">
                       <div class="layui-input-block">
                          <input type="button" class="layui-btn layui-btn-sm" onclick="tijiao_data('config/img_config',0)"   lay-filter="component-form-element" value="提交" />
                          <a class="layui-btn layui-btn-sm" href="https://portal.qiniu.com/signup?code=1h79wo9rxknki" target="_blank" >注册账号</a>
                       </div>
                     </div>
                   </div>
                </form>
              </div>
              <div class="layui-tab-item">
                 <form class="info_tj" >
                  <input type="hidden" name="type" value="qny">
                  <div class="layui-form"  lay-filter="">
                    <div class="layui-row layui-col-space10 layui-form-item">
                      <div class="layui-col-lg6">
                        <label class="layui-form-label">服务名称:</label>
                        <div class="layui-input-block"> 
                          <input type="text" name="upyun_ACCESSKEY"  placeholder="" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['upyun_ACCESSKEY']); ?>" >
                        </div>
                      </div>
                      <div class="layui-col-lg4">
                        <label>*云存储服务名称</label>
                      </div>
                    </div>
                    <div class="layui-row layui-col-space10 layui-form-item">
                      <div class="layui-col-lg6">
                        <label class="layui-form-label">操作员帐号:</label>
                        <div class="layui-input-block"> 
                          <input type="text" name="upyun_SECRETKEY"  placeholder="" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['upyun_SECRETKEY']); ?>" >
                        </div>
                      </div>
                      <div class="layui-col-lg4">
                        <label >*云存储操作员帐号</label>
                      </div>
                    </div>
                    <div class="layui-row layui-col-space10 layui-form-item">
                      <div class="layui-col-lg6">
                        <label class="layui-form-label">操作员密码:</label>
                        <div class="layui-input-block"> 
                          <input type="text" name="upyun_BUCKET"  placeholder="" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['upyun_BUCKET']); ?>" >
                        </div>
                      </div>
                      <div class="layui-col-lg4">
                        <label >*云存储操作员密码</label>
                      </div>
                    </div>
                    <div class="layui-row layui-col-space10 layui-form-item">
                      <div class="layui-col-lg6">
                        <label class="layui-form-label">外链域名:</label>
                        <div class="layui-input-block"> 
                          <input type="text" name="upyun_DOMAIN"  placeholder="" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['upyun_DOMAIN']); ?>" >
                        </div>
                      </div>
                      <div class="layui-col-lg4">
                        <label > *云存储加速域名</label>
                      </div>
                    </div>
                     <div class="layui-form-item">
                       <div class="layui-input-block">
                          <input type="button" class="layui-btn layui-btn-sm" onclick="tijiao_data('config/img_config',0)"   lay-filter="component-form-element" value="提交" />
                          <a class="layui-btn layui-btn-sm" href="https://console.upyun.com/register/?invite=HkFr_Xg7H" target="_blank" >注册账号</a>
                       </div>
                     </div>
                   </div>
                </form>   
              </div>
              <div class="layui-tab-item">
                <form class="info_tj" >
                  <input type="hidden" name="type" value="qny">
                  <div class="layui-form"  lay-filter="">
                    <div class="layui-row layui-col-space10 layui-form-item">
                      <div class="layui-col-lg6">
                        <label class="layui-form-label">ACCESSKEY:</label>
                        <div class="layui-input-block"> 
                          <input type="text" name="ali_ACCESSKEY"  placeholder="" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['ali_ACCESSKEY']); ?>" >
                        </div>
                      </div>
                      <div class="layui-col-lg4">
                        <label>*阿里云秘钥中的AK</label>
                      </div>
                    </div>
                    <div class="layui-row layui-col-space10 layui-form-item">
                      <div class="layui-col-lg6">
                        <label class="layui-form-label">SECRETKEY:</label>
                        <div class="layui-input-block"> 
                          <input type="text" name="ali_SECRETKEY"  placeholder="" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['ali_SECRETKEY']); ?>" >
                        </div>
                      </div>
                      <div class="layui-col-lg4">
                        <label >*阿里云秘钥中的SK</label>
                      </div>
                    </div>
                    <div class="layui-row layui-col-space10 layui-form-item">
                      <div class="layui-col-lg6">
                        <label class="layui-form-label">储存空间名:</label>
                        <div class="layui-input-block"> 
                          <input type="text" name="ali_BUCKET"  placeholder="" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['ali_BUCKET']); ?>" >
                        </div>
                      </div>
                      <div class="layui-col-lg4">
                        <label >*阿里云对象存储空间名称</label>
                      </div>
                    </div>
                    <div class="layui-row layui-col-space10 layui-form-item">
                      <div class="layui-col-lg6">
                        <label class="layui-form-label">域名:</label>
                        <div class="layui-input-block"> 
                          <input type="text" name="ali_DOMAIN"  placeholder="" autocomplete="off" class="layui-input" value="<?php echo htmlentities($res['ali_DOMAIN']); ?>" >
                        </div>
                      </div>
                      <div class="layui-col-lg4">
                        <label > *绑定的加速域名或测试域名</label>
                      </div>
                    </div>
                     <div class="layui-form-item">
                       <div class="layui-input-block">
                          <input type="button" class="layui-btn layui-btn-sm" onclick="tijiao_data('config/img_config',0)"   lay-filter="component-form-element" value="提交" />
                          <a class="layui-btn layui-btn-sm" href="#" target="_blank" >注册账号</a>
                       </div>
                     </div>
                   </div>
                </form>
              </div>
              <!-- <div class="layui-tab-item">内容4</div> -->
            </div>
          </div> 
        </div>
      </div>
    </div>
  </div>

  <script src="/public/static/style/layui/layui.js"></script>    
  <script type="text/javascript" src="/public/static/system/common.js"></script>  

  <script>
 layui.define(['form', 'upload','colorpicker'], function(exports){
  var $ = layui.$
  ,layer = layui.layer
  ,laytpl = layui.laytpl
  ,setter = layui.setter
  ,view = layui.view
  ,admin = layui.admin
  ,form = layui.form
  ,colorpicker = layui.colorpicker
  ,upload = layui.upload;


  //表单赋值
  colorpicker.render({
    elem: '#test-form'
    ,color: "<?php echo htmlentities($res['water_text_color']); ?>"
    ,done: function(color){
      $('#water_text_color').val(color);
    }
  });



 })
  </script>
</body>
</html>