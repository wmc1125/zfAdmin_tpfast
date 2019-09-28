layui.define(['jquery', 'form', 'layer', 'element','table'], function(exports) {
	var $ = layui.jquery,
		form = layui.form,
        table = layui.table,
		layer = layui.layer,
		element = layui.element;
	var menu = [];
	var curMenu;

	/*
	 * @todo 弹出层，弹窗方法
	 * layui.use 加载layui.define 定义的模块，当外部 js 或 onclick调用 use 内部函数时，需要在 use 中定义 window 函数供外部引用
	 * http://blog.csdn.net/xcmonline/article/details/75647144 
	 */
	/*
	    参数解释：
	    title   标题
	    url     请求的url
	    id      需要操作的数据id
	    w       弹出层宽度（缺省调默认值）
	    h       弹出层高度（缺省调默认值）
	*/
	window.zfAdminShow = function(title, url, w, h) {
		if(title == null || title == '') {
			title = false;
		};
		if(url == null || url == '') {
			url = "404.html";
		};
		if(w == null || w == '') {
			w = ($(window).width() * 0.9);
		};
		if(h == null || h == '') {
			h = ($(window).height() - 50);
		};
		layer.open({
			type: 2,
			area: [w + 'px', h + 'px'],
			fix: false, //不固定
			maxmin: true,
			shadeClose: true,
			shade: 0.4,
			title: title,
			content: url
		});
	}
	/*弹出层+传递ID参数*/
	window.zfAdminEdit = function(title, url, id, w, h) {
		if(title == null || title == '') {
			title = false;
		};
		if(url == null || url == '') {
			url = "404.html";
		};
		if(w == null || w == '') {
			w = ($(window).width() * 0.9);
		};
		if(h == null || h == '') {
			h = ($(window).height() - 50);
		};
		layer.open({
			type: 2,
			area: [w + 'px', h + 'px'],
			fix: false, //不固定
			maxmin: true,
			shadeClose: true,
			shade: 0.4,
			title: title,
			content: url,
			success: function(layero, index) {
				//向iframe页的id=house的元素传值  // 参考 https://yq.aliyun.com/ziliao/133150
				var body = layer.getChildFrame('body', index);
				body.contents().find("#dataId").val(id);
				console.log(id);
			},
			error: function(layero, index) {
				alert("aaa");
			}
		});
	}


	/*删除
		role 控制器/方法
		id
		type
	*/
    window.btn_del = function(role,id,db,type){
		layer.confirm('确认删除？', {
		  btn: ['删除','取消'] //按钮
		}, function(){
		  //执行删除操作
		  $.get('../'+role,{id:id,db:db},function(res){
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
	  }
	/*转化
		dbname数据库名,id,现在的状态
	*/
	window.is_switch = function(dbname,id,status){
		$.ajax({
		  type:'post',
		  url:"../common/is_switch",
		  data:{dbname:dbname,id:id,status:status},
		  dataType:'json',
		  success:function(res){
		  // console.log(res)
		  if(res.result==1){
			layer.msg("转换成功", {icon: 1});
			setTimeout(function() {
			window.location.reload();
			}, 100);
		  }else{
			layer.msg("转换失败", {icon: 2}); 
		  }  
		  }
		})
	  }
	/*添加
		role,
		type  1关闭子类刷新父类  0刷新子类
	*/
	window.tijiao_data = function(role,type=1){
        var index = layer.load(2);
		var data = $(".info_tj input,.info_tj select,.info_tj textarea,.info_tj option,.info_tj radio").serialize();      
      	$.ajax({
          type:'post',
          url:'../'+role,
          data:data,
          dataType:'json',
          success:function(res){
          	console.log(res)
            if(res.result==1){
              layer.msg(res.msg, {icon: 1});
              layer.close()
              setTimeout(function() {
				  if(type==1){
					window.parent.location.reload();
				  }else{
					window.location.reload();
				  }
              }, 2000);
            }else{
              layer.msg(res.msg, {icon: 2});
              layer.close(index)
            }   
          }
      	})
	 }

	 /**
     * ajax请求操作
     * @attr href或data-href 请求地址
     * @attr refresh 操作完成后是否自动刷新
     * @class confirm confirm提示内容
     */
    $(document).on('click', '.j-ajax,.zf-ajax', function() {
        var that = $(this), 
            href = !that.attr('data-href') ? that.attr('href') : that.attr('data-href'),
            refresh = !that.attr('refresh') ? 'true' : that.attr('refresh');
        if (!href) {
            layer.msg('请设置data-href参数');
            return false;
        }

        if (!that.attr('confirm')) {
            layer.msg('数据提交中...', {time:500000});
            $.get(href, {}, function(res) {
                layer.msg(res.msg, {}, function() {
                    if (refresh == 'true' || refresh == 'yes') {
                        if (typeof(res.url) != 'undefined' && res.url != null && res.url != '') {
                            location.href = res.url;
                        } else {
                            location.reload();
                        }
                    }
                });
            });
            layer.close();
        } else {
            layer.confirm(that.attr('confirm'), {title:false, closeBtn:0}, function(index){
                layer.msg('数据提交中...', {time:500000});
                $.get(href, {}, function(res) {
                    layer.msg(res.msg, {}, function() {
                        if (refresh == 'true') {
                            if (typeof(res.url) != 'undefined' && res.url != null && res.url != '') {
                                location.href = res.url;
                            } else {
                                location.reload();
                            }
                        }
                    });
                });
                layer.close(index);
            });
        }
        return false;
    });


    /**
     * 列表页批量操作按钮组
     * @attr href 操作地址
     * @attr data-table table容器ID
     * @class confirm 类似系统confirm
     * @attr tips confirm提示内容
     */
    $(document).on('click', '.j-page-btns,.zf-page-btns', function(){
        var that = $(this),
            query = '',
            code = function(that) {
                var href = that.attr('href') ? that.attr('href') : that.attr('data-href');
                var tableObj = that.attr('data-table') ? that.attr('data-table') : 'dataTable';
                if (!href) {
                    layer.msg('请设置data-href参数');
                    return false;
                }

                if ($('.checkbox-ids:checked').length <= 0) {
                    var checkStatus = table.checkStatus(tableObj);
                    if (checkStatus.data.length <= 0) {
                        layer.msg('请选择要操作的数据');
                        return false;
                    }
                    for (var i in checkStatus.data) {
                        if (i > 0) {
                            query += '&';
                        }
                        query += 'id[]='+checkStatus.data[i].id;
                    }
                } else {
                    if (that.parents('form')[0]) {
                        query = that.parents('form').serialize();
                    } else {
                        query = $('#pageListForm').serialize();
                    }
                }

                layer.msg('数据提交中...',{time:500000});
                $.post(href, query, function(res) {
                    layer.msg(res.msg, {}, function(){
                        if (res.code != 0) {
                            location.reload();
                        } 
                    });
                });
            };
        if (that.hasClass('confirm')) {
            var tips = that.attr('tips') ? that.attr('tips') : '您确定要执行此操作吗？';
            layer.confirm(tips, {title:false, closeBtn:0}, function(index){
                code(that);
                layer.close(index);
            });
        } else {
           code(that); 
        }
        return false;
    });


		




 
	
});