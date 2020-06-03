// 当前正在编辑的菜单对象
var ot = null;
// 一级菜单点击事件
$(document).off().on('click','.menu-item .menu-item-label',function () {
    let t = $(this);
    if (!t.parent().hasClass('ac')) {
        $('.menu-item').removeClass('ac');
        t.parent().addClass('ac');
    }

    $('.child-menu-item').removeClass('active');
    // 呼出编辑器 假装动态加载（‘—’）！！！
    _load(function () {
        $('.wx-editor-show').show(),$('.editor-tips').hide();
    },200)

    setFormVal(getMenuVal(t),1);
    if (t.parent().find('.child-menu-item').length > 0) {
        delMenuVal(t);
    } else {
        $('.cjb-radio-group').show();
        $('.cjb-val-group').show();
    }
    ot = t;
})

// 二级菜单点击事件
$(document).on('click','.child-menu-item .child-menu-item-label',function () {
    let t = $(this);
    if (!t.parent().hasClass('active')) {
        $('.child-menu-item').removeClass('active');
        t.parent().addClass('active');
    }
    // 执行输入框显示
    $('.cjb-radio-group').show();
    $('.cjb-val-group').show();
    // 呼出编辑器 假装动态加载（‘—’）！！！
    _load(function () {
        $('.wx-editor-show').show(),$('.editor-tips').hide();
    },200)
    setFormVal(getMenuVal(t),2);
    ot = t;
})

// 设置菜单内容
function setMenuVal(arr) {
    ot.attr('name',arr['name']);
    if (arr['type'] != '') ot.attr('type',arr['type']);
    if (arr['val'] != '') ot.attr('val',arr['val']);
}

// 设置编辑器内容
function setFormVal (val_arr) {
    $("input[name='cjb-name']").val(val_arr['name']);
    if (val_arr['type'] != 'undefined') {
        $(".cjb-radio").removeClass('select');
        $(".cjb-radio[type='"+val_arr['type']+"']").addClass('select');
        if (val_arr['type'] == 'view') {
            $('.cjb-input-tips').text('请输入包含http://或者https://的完整链接');
        } else {
            $('.cjb-input-tips').text('用户点击时自动回复的内容');
        }
    }
    if (val_arr['val'] != 'undefined') $("input[name='cjb-val']").val(val_arr['val']);
}

// 获取菜单内容
function getMenuVal (obj) {
    let arr = new Array();
    arr['name'] = obj.attr('name');
    arr['type'] = obj.attr('type');
    arr['val'] = obj.attr('val');
    return arr;
}

// 删除菜单属性和隐藏输入框
function delMenuVal (obj) {
    // layer.msg('已自动清除菜单类型和值');
    obj.removeAttr('type');
    obj.removeAttr('val');
    // 执行输入框隐藏
    $('.cjb-radio-group').hide();
    $('.cjb-val-group').hide();
}

// 单选框选择事件
$('.cjb-radio').on('click',function () {
    if (!$(this).hasClass('select')) {
        $(this).addClass('select').siblings('.cjb-radio').removeClass('select');
        if ($('.select').attr('type') == 'view') {
            $('.cjb-input-tips').text('请输入包含http://或者https://的完整链接');
        } else {
            $('.cjb-input-tips').text('用户点击时自动回复的内容');
        }
    }
})

// 获取表单内容
function getFormVal () {
    let arr = new Array();
    arr['name'] = $("input[name='cjb-name']").val();
    arr['type'] = getRadioVal();
    arr['val'] = $("input[name='cjb-val']").val();
    return arr;
}

// 获取单选框选中的值
function getRadioVal() {
    let val;
    $('.cjb-radio').each(function () {
        if ($(this).hasClass('select')) {
            val = $(this).attr('type');
        }
    });
    return val;
}
// 字符长度
function strlen(str){
    var len = 0;
    for (var i=0; i<str.length; i++) {
        var c = str.charCodeAt(i);
        if ((c >= 0x0001 && c <= 0x007e) || (0xff60<=c && c<=0xff9f)) {
            len++;
        }
        else {
            len+=2;
        }
    }
    return len;
}

// 添加一级菜单
$(document).on('click','.add-menu',function () {
    $(this).parent().find('.menu-item').length == 2 ? $(this).hide() : '' ;
    if ($(this).parent().find('.menu-item').length >= 3) {
        return false;
    }
    let html = '';
    html += '<li class="menu-item">';
    html += '<span class="item-text menu-item-label" name="菜单名称" type="view">菜单名称</span>';
    html += '<ul class="menu-child-list">';
    html += '<span class="triangle"><em></em></span>';
    html += '<li class="add-item"><i class="fa fa-plus"></i></li>';
    html += '</ul>';
    html += '</li>';
    $(this).before(html);
    setMenuWidth();
})

/*添加二级菜单*/
$("body").off().on('click','.add-item',function () {
    const t = $(this);
    delMenuVal(t.parents('.menu-item').children('span'));
    const list_length = t.parent().find('.child-menu-item').length + 1;
    if (list_length > 4) t.hide();
    let child_html = null;
    child_html = "<li class=\"child-menu-item\"><span class='item-text child-menu-item-label' name=\"子菜单"+list_length+"\" type=\"view\">子菜单"+list_length+"</span></li>";
    t.parent().prepend(child_html);
})

// 删除菜单
$('.menu-delete').on('click',function () {
    ot.parent().remove();
    // 执行表单隐藏
    $('.wx-editor-show').hide();
    $('.editor-tips').show();
    // 显示添加按钮
    if ($('.wx-footer').find('.menu-item').length < 3) {
        $('.add-menu').show();
    }
})

// 菜单名称编辑
$("input[name='cjb-name']").keyup(function () {
    let val = $(this).val();
    ot.text(val);
})

// 保存修改
$('.set_menu').on('click',function () {
    setMenuVal(getFormVal());
    layer.msg('修改成功');
    // getMenuList();
})
setMenuWidth();
// 设置菜单宽度
function setMenuWidth() {
    let item_length = $('.wx-footer').children().length;
    let _width;
    if (item_length > 3) {
        _width = 100/(item_length-1);
    } else {
        _width = 100/item_length;
    }
    $('.wx-footer').children().each(function () {
        $(this).width(_width+'%');
    })
    console.log(item_length);
}

/**
 * 编辑器加载方法
 * @param callback 回调方法
 * @param out_time 停止时间
 * @private
 */
function _load(callback,out_time) {
    $('.editor-load').show();
    $('.wx-editor-show').hide();
    let load = setTimeout(function () {
        $('.editor-load').hide();
        clearTimeout(load);
        if (typeof callback == 'function') {
            callback();
        }
    },out_time)
}

/**
 * 获取菜单数据对象
 * @returns {{menu: {button: Array}}}
 */
function getMenuList() {
    let arr = [],i = 0,child_list = [];
    $('.menu-item').each(function () {
        let than = $(this);
        let t = than.children('.menu-item-label');
        let type = t.attr('type');
        const item = {
            'name': t.attr('name')
        };

        let child_length = than.find('.child-menu-item').length;
        if (child_length == 0) {
            if (typeof type != 'undefined') {
                item.type = type;
                if (type == 'view') {
                    item.url = t.attr('val');
                } else {
                    item.key = t.attr('val');
                }
            }
        } else {
            let i = 0;
            than.find('.child-menu-item').each(function () {
                let child_than = $(this);
                let ct = child_than.children('.child-menu-item-label');
                let name = ct.attr('name');
                let type = ct.attr('type');
                let val = ct.attr('val');
                child_list[i] = {
                    'name': name,
                    'type': type
                }
                if (type == 'view') {
                    child_list[i].url = val;
                } else {
                    child_list[i].key = val;
                }
                i++;
            })
            item.sub_button = child_list;
        }
        // 清除内存
        child_list = [];
        arr.push(item);
    })
    console.log(arr);
    // 整理并返回数据
    return ({
        'menu' : {
            "button" : arr
        }
    })
}

/**
 * 初始化菜单方法
 * @param object data 菜单的json数据
 */
function setMenuList(data) {
    console.log(data)
    let obj = data.menu.button;
    // 先删除所有菜单
    $('.menu-item').remove();
    for (let i in obj) {
        let type = '',val = '';
        if (typeof obj[i].type != 'undefined') {
            type = obj[i].type;
        }
        if (typeof obj[i].url != 'undefined') {
            val = obj[i].url;
        } else if (typeof obj[i].key != 'undefined') {
            val = obj[i].key;
        }
        let html = '';
        html += '<li class="menu-item">';
        html += '<span class="item-text menu-item-label" name="'+obj[i].name+'" type="'+type+'" val="'+val+'">'+obj[i].name+'</span>';
        html += '<ul class="menu-child-list">';
        let count_child_menu = 0;
        if (typeof obj[i].sub_button != 'undefined') {
            for (let j in obj[i].sub_button) {
                let v = '';
                v = obj[i].sub_button[j].type == 'view' ? obj[i].sub_button[j].url : obj[i].sub_button[j].key;
                html += '<li class="child-menu-item"><span class="item-text child-menu-item-label" name="'+obj[i].sub_button[j].name+'" type="'+obj[i].sub_button[j].type+'" val="'+v+'">'+obj[i].sub_button[j].name+'</span></li>';
                count_child_menu++;
            }
        }
        html += '<span class="triangle"><em></em></span>';
        if (count_child_menu >= 5) {
            html += '<li class="add-item" style="display: none;"><i class="fa fa-plus"></i></li>';
        } else {
            html += '<li class="add-item"><i class="fa fa-plus"></i></li>';
        }
        html += '</ul>';
        html += '</li>';
        setTimeout(function () {
            $('.add-menu').before(html);
        },2000)
    }
}
// 得到适用于微信自定义菜单接口格式的数据
$('.create_menu').on('click',function () {
    //
    let info = getMenuList();
    $("#json").text(JSON.stringify(info,null,'    '));
})