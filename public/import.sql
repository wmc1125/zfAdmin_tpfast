/*
Navicat MySQL Data Transfer

Source Server         : v1
Source Server Version : 50562
Source Host           : 120.78.193.246:3306
Source Database       : v1_fast_zf_90ckm

Target Server Type    : MYSQL
Target Server Version : 50562
File Encoding         : 65001

Date: 2020-09-27 10:39:55
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for zf_admin
-- ----------------------------
DROP TABLE IF EXISTS `zf_admin`;
CREATE TABLE `zf_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `gid` int(11) DEFAULT NULL COMMENT '管理员分类id',
  `name` varchar(25) NOT NULL,
  `pwd` varchar(250) NOT NULL,
  `tel` varchar(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `age` tinyint(3) DEFAULT NULL,
  `sex` tinyint(1) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `admin_group_id` tinyint(2) NOT NULL,
  `ip` varchar(50) DEFAULT NULL,
  `login_num` int(11) NOT NULL DEFAULT '0',
  `ctime` int(11) DEFAULT NULL,
  `sort` tinyint(5) NOT NULL DEFAULT '1',
  `google_secret` varchar(255) DEFAULT NULL,
  `google_is` tinyint(255) NOT NULL DEFAULT '0',
  `pic` varchar(255) NOT NULL DEFAULT 'https://i.loli.net/2019/10/29/9OCU2VXHtAFhzoT.jpg',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of zf_admin
-- ----------------------------
INSERT INTO `zf_admin` VALUES ('1', '3', 'admin', '1213213', '', '', '0', '1', '23', '1', '0', '', '0', '2018', '0', '76DGRK3PKWYNP23Z', '0', 'https://i.loli.net/2019/10/29/9OCU2VXHtAFhzoT.jpg');
INSERT INTO `zf_admin` VALUES ('2', '2', 'test', '96e79218965eb72c92a549dd5a330112', '', '', '0', '0', '', '1', '0', '', '0', '0', '1', '', '0', '');

-- ----------------------------
-- Table structure for zf_admin_group
-- ----------------------------
DROP TABLE IF EXISTS `zf_admin_group`;
CREATE TABLE `zf_admin_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `ctime` int(11) DEFAULT NULL,
  `sort` tinyint(5) NOT NULL DEFAULT '1',
  `role` varchar(1000) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='管理员分组表';

-- ----------------------------
-- Records of zf_admin_group
-- ----------------------------
INSERT INTO `zf_admin_group` VALUES ('1', '普通管理员', '1', '2018', '1', '1,4,10,19,8,9,36,95,15,14,32,24,37,68,40,41,45,46,50,88,54,55,60,64,70,77,79,80,82,83');
INSERT INTO `zf_admin_group` VALUES ('2', '测试分组', '1', null, '0', '8,9,36,95,70,40,41,45,46,50,54,55,60,64,15,14,32,79,80,1,10,108');
INSERT INTO `zf_admin_group` VALUES ('3', '超级管理员', '1', '2018', '1', '8,9,36,95,120,70,71,72,89,90,91,92,117,118,119,40,41,42,43,44,45,116,46,47,48,49,50,51,52,53,87,88,79,80,81,126,15,14,16,17,31,74,32,33,34,35,54,55,57,58,59,60,61,62,63,64,65,66,67,24,25,26,27,28,29,30,37,68,115,121,122,123,124,125,1,2,84,4,5,6,7,19,20,21,22,23,10,11,12,13,18,73,3,93,109,108');

-- ----------------------------
-- Table structure for zf_admin_log
-- ----------------------------
DROP TABLE IF EXISTS `zf_admin_log`;
CREATE TABLE `zf_admin_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `action` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `ctime` int(11) NOT NULL,
  `ip` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `uid` int(11) NOT NULL,
  `post` text CHARACTER SET utf8mb4 NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='后台访问日志表';

-- ----------------------------
-- Records of zf_admin_log
-- ----------------------------

-- ----------------------------
-- Table structure for zf_admin_role
-- ----------------------------
DROP TABLE IF EXISTS `zf_admin_role`;
CREATE TABLE `zf_admin_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `value` varchar(50) DEFAULT NULL,
  `check` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `summary` varchar(255) DEFAULT NULL,
  `sort` tinyint(10) NOT NULL DEFAULT '0',
  `pid` int(11) NOT NULL DEFAULT '0',
  `module` varchar(255) DEFAULT NULL,
  `control` varchar(50) NOT NULL,
  `act` varchar(50) NOT NULL,
  `menu` tinyint(1) NOT NULL DEFAULT '1',
  `parm` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=150 DEFAULT CHARSET=utf8 COMMENT='管理员权限表';

-- ----------------------------
-- Records of zf_admin_role
-- ----------------------------
INSERT INTO `zf_admin_role` VALUES ('1', '网站管理', 'admin/Config/', '1', '1', '', '99', '0', 'admin', 'Config', '', '1', null);
INSERT INTO `zf_admin_role` VALUES ('2', '网站设置', 'admin/Config/index', '1', '1', '', '0', '144', 'admin', 'Config', 'index', '1', null);
INSERT INTO `zf_admin_role` VALUES ('4', '管理员列表', 'admin/Config/admin_index', '1', '1', '', '1', '1', 'admin', 'Config', 'admin_index', '1', null);
INSERT INTO `zf_admin_role` VALUES ('5', '添加管理员', 'admin/Config/admin_add', '1', '1', '', '0', '4', 'admin', 'Config', 'admin_add', '0', null);
INSERT INTO `zf_admin_role` VALUES ('6', '编辑管理员', 'admin/Config/admin_edit', '1', '1', '', '0', '4', 'admin', 'Config', 'admin_edit', '0', null);
INSERT INTO `zf_admin_role` VALUES ('7', '删除管理员', 'admin/Config/admin_del', '1', '1', '', '0', '4', 'admin', 'Config', 'admin_del', '0', null);
INSERT INTO `zf_admin_role` VALUES ('8', '后台首页', 'admin/Index/index', '1', '1', '', '0', '0', 'admin', 'Index', 'index', '0', null);
INSERT INTO `zf_admin_role` VALUES ('9', '欢迎页', 'admin/Index/welcome', '1', '1', '', '0', '8', 'admin', 'Index', 'welcome', '1', null);
INSERT INTO `zf_admin_role` VALUES ('10', '权限列表', 'admin/Config/admin_role', '1', '1', '', '3', '1', 'admin', 'Config', 'admin_role', '1', null);
INSERT INTO `zf_admin_role` VALUES ('11', '增加权限', 'admin/Config/admin_role_add', '1', '1', '', '0', '10', 'admin', 'Config', 'admin_role_add', '0', null);
INSERT INTO `zf_admin_role` VALUES ('12', '编辑权限', 'admin/Config/admin_role_edit', '1', '1', '', '0', '10', 'admin', 'Config', 'admin_role_edit', '0', null);
INSERT INTO `zf_admin_role` VALUES ('13', '删除权限', 'admin/Config/admin_role_del', '1', '1', '', '0', '10', 'admin', 'Config', 'admin_role_del', '0', null);
INSERT INTO `zf_admin_role` VALUES ('14', '用户列表', 'admin/User/index', '1', '1', '', '0', '15', 'admin', 'User', 'index', '1', null);
INSERT INTO `zf_admin_role` VALUES ('15', '用户管理', 'admin/User/', '1', '1', '', '2', '0', 'admin', 'User', '', '1', null);
INSERT INTO `zf_admin_role` VALUES ('16', '增加用户', 'admin/User/add', '1', '1', '', '0', '14', 'admin', 'User', 'add', '0', null);
INSERT INTO `zf_admin_role` VALUES ('17', '编辑用户', 'admin/User/edit', '1', '1', '', '0', '14', 'admin', 'User', 'edit', '0', null);
INSERT INTO `zf_admin_role` VALUES ('18', '获取方法', 'admin/Config/get_action', '1', '1', '', '0', '10', 'admin', 'Config', 'get_action', '0', null);
INSERT INTO `zf_admin_role` VALUES ('19', '管理员分组', 'admin/Config/admin_group', '1', '1', '', '2', '1', 'admin', 'Config', 'admin_group', '0', null);
INSERT INTO `zf_admin_role` VALUES ('20', '管理员分组-添加', 'admin/Config/admin_group_add', '1', '1', '', '0', '19', 'admin', 'Config', 'admin_group_add', '0', null);
INSERT INTO `zf_admin_role` VALUES ('21', '管理员分组-修改', 'admin/Config/admin_group_edit', '1', '1', '', '0', '19', 'admin', 'Config', 'admin_group_edit', '0', null);
INSERT INTO `zf_admin_role` VALUES ('22', '管理员分组-删除', 'admin/Config/admin_group_del', '1', '1', '', '0', '19', 'admin', 'Config', 'admin_group_del', '0', null);
INSERT INTO `zf_admin_role` VALUES ('23', '管理员分组-权限', 'admin/Config/admin_group_role', '1', '1', '', '0', '19', 'admin', 'Config', 'admin_group_role', '0', null);
INSERT INTO `zf_admin_role` VALUES ('31', '删除用户', 'admin/User/del', '1', '1', '', '0', '14', 'admin', 'User', 'del', '0', null);
INSERT INTO `zf_admin_role` VALUES ('32', '用户分组', 'admin/User/group', '1', '1', '', '0', '15', 'admin', 'User', 'group', '1', null);
INSERT INTO `zf_admin_role` VALUES ('33', '增加分组', 'admin/User/group_add', '1', '1', '', '0', '32', 'admin', 'User', 'group_add', '0', null);
INSERT INTO `zf_admin_role` VALUES ('34', '修改分组', 'admin/User/group_edit', '1', '1', '', '0', '32', 'admin', 'User', 'group_edit', '0', null);
INSERT INTO `zf_admin_role` VALUES ('35', '删除分组', 'admin/User/group_del', '1', '1', '', '0', '32', 'admin', 'User', 'group_del', '0', null);
INSERT INTO `zf_admin_role` VALUES ('36', '修改密码', 'admin/User/pwd_edit', '1', '1', '', '0', '8', 'admin', 'User', 'pwd_edit', '0', null);
INSERT INTO `zf_admin_role` VALUES ('40', 'CMS内容管理', 'admin/Category/', '1', '1', '', '1', '0', 'admin', 'Category', '', '1', null);
INSERT INTO `zf_admin_role` VALUES ('41', '栏目列表', 'admin/Category/index', '1', '1', '', '0', '40', 'admin', 'Category', 'index', '1', null);
INSERT INTO `zf_admin_role` VALUES ('42', '新增栏目', 'admin/Category/category_add', '1', '1', '', '0', '41', 'admin', 'Category', 'category_add', '0', null);
INSERT INTO `zf_admin_role` VALUES ('43', '修改栏目', 'admin/Category/category_edit', '1', '1', '', '0', '41', 'admin', 'Category', 'category_edit', '0', null);
INSERT INTO `zf_admin_role` VALUES ('44', '删除栏目', 'admin/Category/category_del', '1', '1', '', '0', '41', 'admin', 'Category', 'category_del', '0', null);
INSERT INTO `zf_admin_role` VALUES ('45', '内容列表', 'admin/Category/post_list', '1', '1', '', '0', '41', 'admin', 'Category', 'post_list', '0', null);
INSERT INTO `zf_admin_role` VALUES ('46', '内容模型', 'admin/Category/category_model', '1', '1', '', '0', '40', 'admin', 'Category', 'category_model', '1', null);
INSERT INTO `zf_admin_role` VALUES ('47', '新增模型', 'admin/Category/category_model_add', '1', '1', '', '0', '46', 'admin', 'Category', 'category_model_add', '0', null);
INSERT INTO `zf_admin_role` VALUES ('48', '编辑模型', 'admin/Category/category_model_edit', '1', '1', '', '0', '46', 'admin', 'Category', 'category_model_edit', '0', null);
INSERT INTO `zf_admin_role` VALUES ('49', '删除模型', 'admin/Category/category_model_del', '1', '1', '', '0', '46', 'admin', 'Category', 'category_model_del', '0', null);
INSERT INTO `zf_admin_role` VALUES ('50', '内容列表', 'admin/Category/post_all_list', '1', '1', '', '0', '40', 'admin', 'Category', 'post_all_list', '1', null);
INSERT INTO `zf_admin_role` VALUES ('51', '内容添加', 'admin/Category/post_add', '1', '1', '', '0', '50', 'admin', 'Category', 'post_add', '0', null);
INSERT INTO `zf_admin_role` VALUES ('52', '内容编辑', 'admin/Category/post_edit', '1', '1', '', '0', '50', 'admin', 'Category', 'post_edit', '0', null);
INSERT INTO `zf_admin_role` VALUES ('53', '内容删除', 'admin/Category/post_del', '1', '1', '', '0', '50', 'admin', 'Category', 'post_del', '0', null);
INSERT INTO `zf_admin_role` VALUES ('54', '其他管理', 'admin/Rests/', '1', '1', '', '4', '0', 'admin', 'Rests', '', '1', '');
INSERT INTO `zf_admin_role` VALUES ('55', '广告管理', 'admin/Rests/advert', '1', '1', '', '0', '54', 'admin', 'Rests', 'advert', '1', null);
INSERT INTO `zf_admin_role` VALUES ('57', '增加广告', 'admin/Rests/advert_add', '1', '1', '', '0', '55', 'admin', 'Rests', 'advert_add', '0', null);
INSERT INTO `zf_admin_role` VALUES ('58', '修改广告', 'admin/Rests/advert_edit', '1', '1', '', '0', '55', 'admin', 'Rests', 'advert_edit', '0', null);
INSERT INTO `zf_admin_role` VALUES ('59', '删除广告', 'admin/Rests/advert_del', '1', '1', '', '0', '55', 'admin', 'Rests', 'advert_del', '0', null);
INSERT INTO `zf_admin_role` VALUES ('60', '超链管理', 'admin/Rests/link', '1', '1', '', '0', '54', 'admin', 'Rests', 'link', '1', null);
INSERT INTO `zf_admin_role` VALUES ('61', '增加超链', 'admin/Rests/link_add', '1', '1', '', '0', '60', 'admin', 'Rests', 'link_add', '0', null);
INSERT INTO `zf_admin_role` VALUES ('62', '编辑超链', 'admin/Rests/link_edit', '1', '1', '', '0', '60', 'admin', 'Rests', 'link_edit', '0', null);
INSERT INTO `zf_admin_role` VALUES ('63', '删除超链', 'admin/Rests/link_del', '1', '1', '', '0', '60', 'admin', 'Rests', 'link_del', '0', null);
INSERT INTO `zf_admin_role` VALUES ('64', '留言管理', 'admin/Rests/guessbook', '1', '1', '', '0', '54', 'admin', 'Rests', 'guessbook', '1', null);
INSERT INTO `zf_admin_role` VALUES ('65', '添加留言', 'admin/Rests/guessbook_add', '1', '1', '', '0', '64', 'admin', 'Rests', 'guessbook_add', '0', null);
INSERT INTO `zf_admin_role` VALUES ('66', '编辑留言', 'admin/Rests/guessbook_edit', '1', '1', '', '0', '64', 'admin', 'Rests', 'guessbook_edit', '0', null);
INSERT INTO `zf_admin_role` VALUES ('67', '删除留言', 'admin/Rests/guessbook_del', '1', '1', '', '0', '64', 'admin', 'Rests', 'guessbook_del', '0', null);
INSERT INTO `zf_admin_role` VALUES ('70', '公共方法', 'admin/Common/', '1', '1', '', '0', '0', 'admin', 'Common', '', '0', null);
INSERT INTO `zf_admin_role` VALUES ('71', '上传方法', 'admin/Common/upload_one', '1', '1', '', '0', '70', 'admin', 'Common', 'upload_one', '1', null);
INSERT INTO `zf_admin_role` VALUES ('72', '状态转换', 'admin/Common/is_switch', '1', '1', '', '0', '70', 'admin', 'Common', 'is_switch', '1', null);
INSERT INTO `zf_admin_role` VALUES ('73', '获取相似的标题', 'admin/Category/title_get_list', '1', '1', '', '0', '10', 'admin', 'Category', 'title_get_list', '0', null);
INSERT INTO `zf_admin_role` VALUES ('74', '导出用户', 'admin/User/export', '1', '1', '', '0', '14', 'admin', 'User', 'export', '0', null);
INSERT INTO `zf_admin_role` VALUES ('79', '应用中心', 'addons/zf_plugin_client', '1', '1', '', '5', '0', 'addons', 'zf_plugin_client.soft', '', '1', null);
INSERT INTO `zf_admin_role` VALUES ('80', '模板列表', 'admin/Plugins/themes', '1', '1', '', '0', '79', 'admin', 'Plugins', 'themes', '1', null);
INSERT INTO `zf_admin_role` VALUES ('81', '上传模板', 'admin/Plugins/themes_upload', '1', '1', '', '0', '80', 'admin', 'Plugins', 'themes_upload', '0', null);
INSERT INTO `zf_admin_role` VALUES ('87', '内容导入', 'admin/Category/import', '1', '1', '', '0', '50', 'admin', 'Category', 'import', '0', null);
INSERT INTO `zf_admin_role` VALUES ('88', '内容页获取标题列表', 'admin/Category/search_post', '1', '1', '', '0', '50', 'admin', 'Category', 'search_post', '0', null);
INSERT INTO `zf_admin_role` VALUES ('89', '转换菜单', 'admin/Common/is_menu', '1', '1', '', '0', '70', 'admin', 'Common', 'is_menu', '1', null);
INSERT INTO `zf_admin_role` VALUES ('90', '删除内容', 'admin/Common/del_post', '1', '1', '', '0', '70', 'admin', 'Common', 'del_post', '1', null);
INSERT INTO `zf_admin_role` VALUES ('91', '批量删除', 'admin/Common/more_del', '1', '1', '', '0', '70', 'admin', 'Common', 'more_del', '1', null);
INSERT INTO `zf_admin_role` VALUES ('92', '修改字段的值', 'admin/Common/value_edit', '1', '1', '', '0', '70', 'admin', 'Common', 'value_edit', '1', null);
INSERT INTO `zf_admin_role` VALUES ('95', '修改个人信息', 'admin/User/admin_info', '1', '1', '', '0', '8', 'admin', 'User', 'admin_info', '1', null);
INSERT INTO `zf_admin_role` VALUES ('108', '操作日志', 'admin/Config/action_log', '1', '1', '', '15', '1', 'admin', 'Config', 'action_log', '1', null);
INSERT INTO `zf_admin_role` VALUES ('116', '获取详情中图片', 'admin/Category/get_content_pic_list', '1', '1', null, '0', '45', 'admin', 'Category', 'get_content_pic_list', '1', null);
INSERT INTO `zf_admin_role` VALUES ('117', '上传文件', 'admin/Common/upload_one_file', '1', '1', null, '0', '70', 'admin', 'Common', 'upload_one_file', '1', null);
INSERT INTO `zf_admin_role` VALUES ('118', '阿里云oss', 'admin/Common/aliyunoss', '1', '1', null, '0', '70', 'admin', 'Common', 'aliyunoss', '1', null);
INSERT INTO `zf_admin_role` VALUES ('119', '网站属性编辑', 'admin/Common/config_edit', '1', '1', null, '0', '70', 'admin', 'Common', 'config_edit', '1', null);
INSERT INTO `zf_admin_role` VALUES ('120', '数据库清理', 'admin/Index/db_clear', '1', '1', null, '0', '8', 'admin', 'Index', 'db_clear', '1', null);
INSERT INTO `zf_admin_role` VALUES ('126', '插件管理', 'admin/Plugins/plugins', '1', '1', null, '0', '79', 'admin', 'Plugins', 'plugins', '1', null);
INSERT INTO `zf_admin_role` VALUES ('133', '商品管理', 'admin/Products/', '1', '1', null, '3', '0', 'admin', 'Products', '', '1', '');
INSERT INTO `zf_admin_role` VALUES ('134', '商品列表', 'admin/Products/product', '1', '1', null, '0', '133', 'admin', 'Products', 'product', '1', null);
INSERT INTO `zf_admin_role` VALUES ('135', '增加商品', 'admin/Products/product_add', '1', '1', null, '0', '134', 'admin', 'Products', 'product_add', '0', null);
INSERT INTO `zf_admin_role` VALUES ('136', '编辑商品', 'admin/Products/product_edit', '1', '1', null, '0', '134', 'admin', 'Products', 'product_edit', '0', null);
INSERT INTO `zf_admin_role` VALUES ('141', '商品分类', 'admin/Products/cate', '1', '1', null, '0', '133', 'admin', 'Products', 'cate', '1', null);
INSERT INTO `zf_admin_role` VALUES ('142', '增加分类', 'admin/Products/cate_add', '1', '1', null, '0', '141', 'admin', 'Products', 'cate_add', '0', null);
INSERT INTO `zf_admin_role` VALUES ('143', '编辑分类', 'admin/Products/cate_edit', '1', '1', null, '0', '141', 'admin', 'Products', 'cate_edit', '0', null);
INSERT INTO `zf_admin_role` VALUES ('144', '基本设置', 'admin/0/0', '1', '1', null, '0', '1', 'admin', '0', '0', '1', null);
INSERT INTO `zf_admin_role` VALUES ('146', '自定义参数', 'admin/Config/custom_config', '1', '1', null, '0', '144', 'admin', 'Config', 'custom_config', '1', null);
INSERT INTO `zf_admin_role` VALUES ('148', '上传插件', 'admin/Plugins/plugin_upload', '1', '1', null, '0', '126', 'admin', 'Plugins', 'plugin_upload', '0', '');
INSERT INTO `zf_admin_role` VALUES ('149', '插件卸载', 'admin/Plugins/plugin_uninstall', '1', '1', null, '0', '126', 'admin', 'Plugins', 'plugin_uninstall', '0', '');

-- ----------------------------
-- Table structure for zf_advert
-- ----------------------------
DROP TABLE IF EXISTS `zf_advert`;
CREATE TABLE `zf_advert` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `summary` varchar(255) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `target` varchar(255) DEFAULT NULL,
  `cname` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `pic` varchar(255) DEFAULT NULL,
  `sort` int(3) DEFAULT NULL,
  `tag` varchar(25) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='广告表';

-- ----------------------------
-- Records of zf_advert
-- ----------------------------
INSERT INTO `zf_advert` VALUES ('1', '首页banner', '', '0', '0', '', '', '', '', '', '', '0', 'banner', '0', '1');
INSERT INTO `zf_advert` VALUES ('2', '1', 'https://timgsa.baidu.com', '1', '0', '我是一条描述的信息', '', '', '', '', 'https://i.loli.net/2019/11/16/iCrXmphy34Jce8z.jpg', '0', '', '0', '1');

-- ----------------------------
-- Table structure for zf_category
-- ----------------------------
DROP TABLE IF EXISTS `zf_category`;
CREATE TABLE `zf_category` (
  `cid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `mid` tinyint(1) NOT NULL DEFAULT '1',
  `name` varchar(30) NOT NULL COMMENT '标题',
  `ename` varchar(30) DEFAULT NULL COMMENT '英文名',
  `cname` varchar(255) DEFAULT NULL,
  `summary` varchar(255) DEFAULT NULL COMMENT '简介',
  `pic` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `url` varchar(150) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `sort` tinyint(4) NOT NULL DEFAULT '0',
  `menu` tinyint(1) NOT NULL DEFAULT '0',
  `ctime` int(11) DEFAULT NULL,
  `utime` int(11) DEFAULT NULL,
  `content` text,
  `tpl_category` varchar(50) DEFAULT NULL,
  `tpl_post` varchar(50) DEFAULT NULL,
  `page` int(255) NOT NULL DEFAULT '10',
  `sname` varchar(100) DEFAULT NULL,
  `keyword` varchar(255) DEFAULT NULL,
  `target` varchar(20) DEFAULT NULL,
  `append` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='分类表';

-- ----------------------------
-- Records of zf_category
-- ----------------------------
INSERT INTO `zf_category` VALUES ('1', '0', '2', '产品', 'Product Display', '', '', 'http://v1.fast.zf.90ckm.com/template/index/a1/style/img/nav_img1.jpg', '', '', '1', '0', '1', '1563957347', '0', '<p>qqq</p>', 'tpl_pro', 'tpl_content', '10', '', '', '', '', '');
INSERT INTO `zf_category` VALUES ('2', '0', '2', '动态', 'Real-time News', null, '', '', '', '', '1', '0', '1', '1570589981', null, null, 'tpl_news', 'tpl_content_news', '6', '', '', '', '', '');
INSERT INTO `zf_category` VALUES ('3', '0', '3', '案例', 'Successful Case', null, '', '', '', '', '1', '0', '1', '1570590006', null, null, 'tpl_case', '', '10', '', '', '', '', '');
INSERT INTO `zf_category` VALUES ('4', '0', '1', '关于', 'About Us', null, '', '', '', '', '1', '0', '1', '1570590019', null, null, 'tpl_about', '', '10', '', '', '', '', '');
INSERT INTO `zf_category` VALUES ('5', '0', '1', '获取地址', '', null, '', '', '', 'http://bbs.wangmingchang.com/forum.php?mod=forumdisplay&fid=77', '1', '0', '1', '1570590036', null, null, '', '', '10', '', '', '', '', '');
INSERT INTO `zf_category` VALUES ('6', '443', '14', 'cs', '', null, '', '', '', '', '0', '0', '0', '1572253436', null, '<p>dsf</p>', '', '', '10', '', '', '', '', '');

-- ----------------------------
-- Table structure for zf_category_model
-- ----------------------------
DROP TABLE IF EXISTS `zf_category_model`;
CREATE TABLE `zf_category_model` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `model` varchar(25) NOT NULL,
  `sort` tinyint(255) NOT NULL DEFAULT '0',
  `status` tinyint(5) NOT NULL DEFAULT '0',
  `is_two` tinyint(1) NOT NULL DEFAULT '0',
  `is_parm` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='分类模型表';

-- ----------------------------
-- Records of zf_category_model
-- ----------------------------
INSERT INTO `zf_category_model` VALUES ('1', '单页模型', 'simple', '2', '1', '1', '0');
INSERT INTO `zf_category_model` VALUES ('2', '新闻模型', 'news', '0', '1', '0', '0');
INSERT INTO `zf_category_model` VALUES ('3', 'ZF内容模型', 'zf_tpl', '2', '1', '1', '1');

-- ----------------------------
-- Table structure for zf_category_model_parm
-- ----------------------------
DROP TABLE IF EXISTS `zf_category_model_parm`;
CREATE TABLE `zf_category_model_parm` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `position` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1左  2右',
  `name` varchar(50) NOT NULL,
  `key` varchar(50) NOT NULL,
  `value` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL DEFAULT 'layui-input',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `readonly` tinyint(1) NOT NULL DEFAULT '0',
  `hidden` tinyint(1) NOT NULL DEFAULT '0',
  `mid` int(11) NOT NULL DEFAULT '0',
  `sort` tinyint(5) NOT NULL DEFAULT '0',
  `is_multi` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否多选   0 否   1 多选',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COMMENT='模型参数列表';

-- ----------------------------
-- Records of zf_category_model_parm
-- ----------------------------
INSERT INTO `zf_category_model_parm` VALUES ('2', '1', '图集', 'album', '', 'album', '1', '0', '0', '2', '3', '1');
INSERT INTO `zf_category_model_parm` VALUES ('3', '1', '标题', 'title', '', 'layui-input', '1', '0', '0', '14', '1', '0');
INSERT INTO `zf_category_model_parm` VALUES ('4', '1', '栏目描述', 'summary', '', 'layui-textarea', '1', '0', '0', '14', '2', '0');
INSERT INTO `zf_category_model_parm` VALUES ('5', '1', '缩略图', 'album', '', 'album', '0', '0', '0', '14', '3', '0');
INSERT INTO `zf_category_model_parm` VALUES ('6', '1', '栏目详情', 'content', '', 'ueditor', '1', '0', '0', '14', '4', '0');
INSERT INTO `zf_category_model_parm` VALUES ('7', '2', '作者', 'author', '', 'layui-input', '1', '0', '0', '14', '1', '0');
INSERT INTO `zf_category_model_parm` VALUES ('8', '1', '时间', 'ctime', '', 'layui-time', '1', '0', '0', '14', '1', '0');
INSERT INTO `zf_category_model_parm` VALUES ('9', '2', '排序', 'sort', '', 'layui-input', '1', '0', '0', '14', '0', '0');
INSERT INTO `zf_category_model_parm` VALUES ('10', '2', '扩展参数', 'append', '', 'layui-radio', '0', '0', '0', '14', '0', '0');
INSERT INTO `zf_category_model_parm` VALUES ('11', '2', '封面图', 'pic', '', 'layui-pic', '1', '0', '0', '14', '5', '0');
INSERT INTO `zf_category_model_parm` VALUES ('12', '2', '文件', 'file', '', 'layui-file', '1', '0', '0', '14', '6', '0');
INSERT INTO `zf_category_model_parm` VALUES ('17', '1', '标题', 'title', '', 'layui-input', '1', '0', '0', '2', '1', '0');
INSERT INTO `zf_category_model_parm` VALUES ('18', '1', '简介', 'summary', '', 'layui-textarea', '1', '0', '0', '2', '2', '0');
INSERT INTO `zf_category_model_parm` VALUES ('19', '2', '图片', 'pic', '', 'layui-pic', '1', '0', '0', '2', '4', '0');
INSERT INTO `zf_category_model_parm` VALUES ('20', '2', '排序', 'sort', '', 'layui-input', '1', '0', '0', '2', '2', '0');
INSERT INTO `zf_category_model_parm` VALUES ('21', '2', '时间', 'ctime', '', 'layui-time', '1', '0', '0', '2', '3', '0');
INSERT INTO `zf_category_model_parm` VALUES ('22', '1', '详情', 'content', '', 'ueditor', '1', '0', '0', '2', '4', '0');
INSERT INTO `zf_category_model_parm` VALUES ('23', '2', '作者', 'author', '', 'layui-input', '1', '0', '0', '2', '1', '0');
INSERT INTO `zf_category_model_parm` VALUES ('24', '2', '推荐', 'recommend', '', 'layui-switch', '1', '0', '0', '14', '9', '0');

-- ----------------------------
-- Table structure for zf_config
-- ----------------------------
DROP TABLE IF EXISTS `zf_config`;
CREATE TABLE `zf_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(50) NOT NULL,
  `value` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `msg` varchar(255) DEFAULT NULL,
  `type` varchar(50) NOT NULL DEFAULT 'user' COMMENT 'user 用户   system系统',
  `sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='系统变量表';

-- ----------------------------
-- Records of zf_config
-- ----------------------------
INSERT INTO `zf_config` VALUES ('1', 'zf_tpl_suffix', 'def', '1', null, 'system', '0');
INSERT INTO `zf_config` VALUES ('2', 'test1', 'aaa', '1', '测试11', 'user', '3');

-- ----------------------------
-- Table structure for zf_guessbook
-- ----------------------------
DROP TABLE IF EXISTS `zf_guessbook`;
CREATE TABLE `zf_guessbook` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `summary` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `sort` tinyint(2) NOT NULL DEFAULT '0',
  `ctime` int(11) NOT NULL DEFAULT '0',
  `tel` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='留言表';

-- ----------------------------
-- Records of zf_guessbook
-- ----------------------------

-- ----------------------------
-- Table structure for zf_link
-- ----------------------------
DROP TABLE IF EXISTS `zf_link`;
CREATE TABLE `zf_link` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `target` varchar(255) DEFAULT NULL,
  `sort` int(5) DEFAULT '0',
  `summary` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='超链表';

-- ----------------------------
-- Records of zf_link
-- ----------------------------
INSERT INTO `zf_link` VALUES ('1', '王明昌博客', 'https://www.wangmingchang.com/', '2', '1', '1540285148', '', '0', '个人博客\r\n');
INSERT INTO `zf_link` VALUES ('2', 'Mc技术论坛', 'http://bbs.wangmingchang.com/forum.php', '1', '1', null, null, '0', '');

-- ----------------------------
-- Table structure for zf_plugin
-- ----------------------------
DROP TABLE IF EXISTS `zf_plugin`;
CREATE TABLE `zf_plugin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `plugin_name` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `ctime` varchar(50) DEFAULT NULL,
  `utime` varchar(50) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 正常   2 未激活  9 停止使用',
  `sort` varchar(255) DEFAULT NULL,
  `version` varchar(255) DEFAULT NULL,
  `pic` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `source` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='插件列表';

-- ----------------------------
-- Records of zf_plugin
-- ----------------------------
INSERT INTO `zf_plugin` VALUES ('1', 'def', '演示站点', '子枫', '2019-7-24', null, '1', null, 'v1.0.0', 'http://oss1.wangmingchang.com/mac/MdImd/20200528081400.png', 'theme', '');

-- ----------------------------
-- Table structure for zf_post
-- ----------------------------
DROP TABLE IF EXISTS `zf_post`;
CREATE TABLE `zf_post` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(10) NOT NULL,
  `title` text,
  `summary` varchar(255) DEFAULT NULL,
  `pic` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `ctime` int(11) DEFAULT NULL,
  `utime` int(11) DEFAULT NULL,
  `sort` tinyint(5) DEFAULT '0',
  `content` text,
  `append` varchar(255) DEFAULT NULL,
  `file` varchar(255) NOT NULL,
  `album` varchar(500) NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `price_new` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tkl` varchar(20) NOT NULL DEFAULT '0',
  `hits` int(11) NOT NULL DEFAULT '0',
  `url` varchar(255) NOT NULL,
  `author` varchar(50) NOT NULL,
  `openid` varchar(50) NOT NULL,
  `cj_id` int(11) NOT NULL DEFAULT '0',
  `relevan_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联文章ID  0不关联',
  `is_product` tinyint(1) NOT NULL DEFAULT '0',
  `p_cate` varchar(255) DEFAULT NULL,
  `sku_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 单规格 2 多规格',
  `ini_hits` int(5) NOT NULL DEFAULT '0' COMMENT '初始访问量    总访问量=初始访问量+实际访问量',
  `recommend` tinyint(1) NOT NULL DEFAULT '0',
  `istop` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='内容表';

-- ----------------------------
-- Records of zf_post
-- ----------------------------
INSERT INTO `zf_post` VALUES ('2', '1', 'hello.world!', '这是第一篇文章', 'http://zf-demo-test.oss-cn-beijing.aliyuncs.com/demo_zf_test/public/upload/simple/image/20190927/1569579364_moren_upload.png', '1', '1569579211', null, '0', '<p>这是第一篇文章</p>', '', '', '', '0.00', '0.00', '0', '15', '', '匿名', '', '0', '0', '0', null, '1', '0', '0', '0');
INSERT INTO `zf_post` VALUES ('3', '2', '一直在你身边对你好，你却没有发现。', '找老婆要找爱发脾气的女人。永远不会发脾气的女人就如同一杯白开水，解渴，却无味。而发脾气的女人正如烈酒般，刺激而令人无法忘怀。', 'http://v1.fast.zf.90ckm.com/template/index/a1/style//img/news_img1.jpg', '1', '1570606577', null, '0', null, '', '', '', '0.00', '0.00', '0', '0', '', '匿名', '', '0', '0', '0', null, '1', '0', '0', '0');
INSERT INTO `zf_post` VALUES ('4', '2', '一直在你身边对你好，你却没有发现。', '找老婆要找爱发脾气的女人。永远不会发脾气的女人就如同一杯白开水，解渴，却无味。而发脾气的女人正如烈酒般，刺激而令人无法忘怀。', 'http://v1.fast.zf.90ckm.com/template/index/a1/style//img/news_img1.jpg', '1', '1570606596', null, '0', null, '', '', '', '0.00', '0.00', '0', '0', '', '匿名', '', '0', '0', '0', null, '1', '0', '0', '0');
INSERT INTO `zf_post` VALUES ('5', '2', '写经验交流材料的技巧全在这了！', '找老婆要找爱发脾气的女人。永远不会发脾气的女人就如同一杯白开水，解渴，却无味。而发脾气的女人正如烈酒般，刺激而令人无法忘怀。', 'http://v1.fast.zf.90ckm.com/template/index/a1/style//img/news_img1.jpg', '1', '1570606608', null, '0', null, '', '', '', '0.00', '0.00', '0', '2', '', '匿名', '', '0', '0', '0', null, '1', '0', '0', '0');
INSERT INTO `zf_post` VALUES ('6', '2', '写经验交流材料的技巧全在这了！', '找老婆要找爱发脾气的女人。永远不会发脾气的女人就如同一杯白开水，解渴，却无味。而发脾气的女人正如烈酒般，刺激而令人无法忘怀。', 'http://v1.fast.zf.90ckm.com/template/index/a1/style//img/news_img1.jpg', '1', '1570606613', null, '0', null, '', '', '', '0.00', '0.00', '0', '11', '', '匿名', '', '0', '0', '0', null, '1', '0', '0', '0');
INSERT INTO `zf_post` VALUES ('7', '2', '经验分享：我是如何做好每日计划的', '找老婆要找爱发脾气的女人。永远不会发脾气的女人就如同一杯白开水，解渴，却无味。而发脾气的女人正如烈酒般，刺激而令人无法忘怀。', 'http://v1.fast.zf.90ckm.com/template/index/a1/style//img/news_img1.jpg', '1', '1570606623', null, '0', null, '', '', '', '0.00', '0.00', '0', '4', '', '匿名', '', '0', '0', '0', null, '1', '0', '0', '0');
INSERT INTO `zf_post` VALUES ('8', '2', '经验分享：我是如何做好每日计划的', '找老婆要找爱发脾气的女人。永远不会发脾气的女人就如同一杯白开水，解渴，却无味。而发脾气的女人正如烈酒般，刺激而令人无法忘怀。', 'http://v1.fast.zf.90ckm.com/template/index/a1/style//img/news_img1.jpg', '1', '1570606628', null, '0', null, '', '', '', '0.00', '0.00', '0', '15', '', '匿名', '', '0', '0', '0', null, '1', '0', '0', '0');
INSERT INTO `zf_post` VALUES ('9', '2', '脾气不好的妈妈好好读读这篇文章，真的是细思极恐', '找老婆要找爱发脾气的女人。永远不会发脾气的女人就如同一杯白开水，解渴，却无味。而发脾气的女人正如烈酒般，刺激而令人无法忘怀。', 'http://v1.fast.zf.90ckm.com/template/index/a1/style//img/news_img1.jpg', '1', '1570606640', null, '0', null, '', '', '', '0.00', '0.00', '0', '15', '', '匿名', '', '0', '0', '0', null, '1', '0', '0', '0');
INSERT INTO `zf_post` VALUES ('10', '2', '养女儿，一定要让她漂亮！', '找老婆要找爱发脾气的女人。永远不会发脾气的女人就如同一杯白开水，解渴，却无味。而发脾气的女人正如烈酒般，刺激而令人无法忘怀。', 'http://v1.fast.zf.90ckm.com/template/index/a1/style//img/news_img1.jpg', '1', '1570606645', null, '2', '<p class=\"introTop\">TA家的珍珠是用黑糖熬制的，要熬整整四个小时才行，每熬一锅黑糖只能做出40杯奶茶，好味，是值得等待的。</p><div><img src=\"{$tpl_static}/img/news_big.jpg\" alt=\"新闻详情图\"/></div><p class=\"introBott\">北极光的制作，需要300g葡萄来完成，要选用最新鲜的葡萄，才能做出最灿烂的北极光。满满一瓶葡萄，看着就让人倍感满足。喝之前，要先摇9下，才能喝出最好的果味。晨曦的寓意是，清晨的阳光。要用到一整颗百香果的晨曦，喝起来酸酸甜甜，果味浓郁。晨曦喝起来果味极浓，不仅仅有百香果，还有芒果、橙汁...的味道，十分清新，彷佛夏日的一抹凉风！</p>', '', '', '', '0.00', '0.00', '0', '40', '', '匿名', '', '0', '0', '0', null, '1', '0', '0', '0');
INSERT INTO `zf_post` VALUES ('11', '3', '名牌工厂店', '一家工厂企业的商品展示网站，主要以卖高端服饰为主。主要以卖高端服饰为主。主要以卖高端服饰为主。', 'http://v1.fast.zf.90ckm.com/template/index/a1/style//img/case1.jpg', '1', '1570607284', null, '0', null, '', '', '', '0.00', '0.00', '0', '0', '', '匿名', '', '0', '0', '0', null, '1', '0', '0', '0');
INSERT INTO `zf_post` VALUES ('12', '4', '名牌工厂店', '一家工厂企业的商品展示网站，主要以卖高端服饰为主。主要以卖高端服饰为主。主要以卖高端服饰为主。', 'http://v1.fast.zf.90ckm.com/template/index/a1/style//img/case1.jpg', '1', '1570607289', null, '0', null, '', '', '', '0.00', '0.00', '0', '0', '', '匿名', '', '0', '0', '0', null, '1', '0', '0', '0');
INSERT INTO `zf_post` VALUES ('13', '4', '名牌工厂店', '一家工厂企业的商品展示网站，主要以卖高端服饰为主。主要以卖高端服饰为主。主要以卖高端服饰为主。', 'http://v1.fast.zf.90ckm.com/template/index/a1/style//img/case1.jpg', '1', '1570607294', null, '0', null, '', '', '', '0.00', '0.00', '0', '0', '', '匿名', '', '0', '0', '0', null, '1', '0', '0', '0');
INSERT INTO `zf_post` VALUES ('14', '445', 'wewew', '', 'http://v1.fast.zf.90ckm.com/public/upload/file/20191118/ad3411963a149e958126056f5f364274.jpg', '1', '1574045581', null, '0', '<p>dsafds</p>', null, '', '', '0.00', '0.00', '0', '0', '', '', '', '0', '0', '0', null, '1', '0', '0', '0');
INSERT INTO `zf_post` VALUES ('15', '0', 'test', '', '', '1', '1591156850', null, '0', '', '', '', '', '0.00', '0.00', '0', '0', '', '匿名', '', '0', '0', '1', '1', '1', '0', '0', '0');

-- ----------------------------
-- Table structure for zf_product_cate
-- ----------------------------
DROP TABLE IF EXISTS `zf_product_cate`;
CREATE TABLE `zf_product_cate` (
  `cid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `mid` tinyint(1) NOT NULL DEFAULT '1',
  `name` varchar(30) NOT NULL COMMENT '标题',
  `ename` varchar(30) DEFAULT NULL COMMENT '英文名',
  `cname` varchar(255) DEFAULT NULL,
  `summary` varchar(255) DEFAULT NULL COMMENT '简介',
  `pic` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `url` varchar(150) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `sort` tinyint(4) NOT NULL DEFAULT '0',
  `menu` tinyint(1) NOT NULL DEFAULT '0',
  `ctime` int(11) DEFAULT NULL,
  `utime` int(11) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `tpl_category` varchar(50) DEFAULT NULL,
  `tpl_post` varchar(50) DEFAULT NULL,
  `page` int(255) NOT NULL DEFAULT '10',
  `sname` varchar(100) DEFAULT NULL,
  `keyword` varchar(255) DEFAULT NULL,
  `target` varchar(20) DEFAULT NULL,
  `append` varchar(255) DEFAULT NULL,
  `file` varchar(255) NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='产品分类';

-- ----------------------------
-- Records of zf_product_cate
-- ----------------------------
INSERT INTO `zf_product_cate` VALUES ('1', '0', '1', 'test分类', null, null, null, null, null, '', '1', '0', '1', null, null, null, null, null, '10', null, null, null, null, '');

-- ----------------------------
-- Table structure for zf_product_sku
-- ----------------------------
DROP TABLE IF EXISTS `zf_product_sku`;
CREATE TABLE `zf_product_sku` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sku_name` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `sku_value` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `uid` int(11) NOT NULL DEFAULT '0',
  `gid` int(11) NOT NULL DEFAULT '0',
  `_gid` int(11) NOT NULL DEFAULT '0' COMMENT '伪gid',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='产品sku';

-- ----------------------------
-- Records of zf_product_sku
-- ----------------------------
INSERT INTO `zf_product_sku` VALUES ('1', '颜色', '红', '1', '15', '0', '1');
INSERT INTO `zf_product_sku` VALUES ('2', '大小', '16G', '1', '15', '0', '1');
INSERT INTO `zf_product_sku` VALUES ('3', '颜色', '土豪金', '1', '15', '0', '1');

-- ----------------------------
-- Table structure for zf_product_sku_info
-- ----------------------------
DROP TABLE IF EXISTS `zf_product_sku_info`;
CREATE TABLE `zf_product_sku_info` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `gid` int(11) DEFAULT NULL,
  `pic` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `code` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `price_line` decimal(10,0) DEFAULT NULL,
  `stock` int(50) NOT NULL,
  `kg` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `uid` varchar(11) CHARACTER SET utf8mb4 NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='sku详细参数';

-- ----------------------------
-- Records of zf_product_sku_info
-- ----------------------------
INSERT INTO `zf_product_sku_info` VALUES ('3', '15', '', '001', '100.00', '255', '99', '30g', '1', '1');
INSERT INTO `zf_product_sku_info` VALUES ('4', '15', '', '002', '200.00', '355', '99', '30g', '1', '1');

-- ----------------------------
-- Table structure for zf_product_sku_info_parm
-- ----------------------------
DROP TABLE IF EXISTS `zf_product_sku_info_parm`;
CREATE TABLE `zf_product_sku_info_parm` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `info_id` int(11) NOT NULL DEFAULT '0',
  `sku_id` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `gid` int(11) NOT NULL,
  `uid` varchar(11) CHARACTER SET utf8mb4 NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='sku相关联';

-- ----------------------------
-- Records of zf_product_sku_info_parm
-- ----------------------------
INSERT INTO `zf_product_sku_info_parm` VALUES ('5', '3', '2', '1', '15', '1');
INSERT INTO `zf_product_sku_info_parm` VALUES ('6', '3', '1', '1', '15', '1');
INSERT INTO `zf_product_sku_info_parm` VALUES ('7', '4', '2', '1', '15', '1');
INSERT INTO `zf_product_sku_info_parm` VALUES ('8', '4', '3', '1', '15', '1');

-- ----------------------------
-- Table structure for zf_user
-- ----------------------------
DROP TABLE IF EXISTS `zf_user`;
CREATE TABLE `zf_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `pwd` varchar(250) NOT NULL,
  `tel` varchar(12) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `age` tinyint(3) DEFAULT NULL,
  `sex` tinyint(1) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `gid` tinyint(2) NOT NULL DEFAULT '1',
  `ip` varchar(50) DEFAULT NULL,
  `login_num` int(11) NOT NULL DEFAULT '0',
  `ctime` int(11) DEFAULT NULL,
  `sort` tinyint(5) NOT NULL DEFAULT '1',
  `pic` varchar(255) NOT NULL DEFAULT 'https://i.loli.net/2019/11/01/yl8rCLRnOuz7k4g.png',
  `nickName` varchar(50) NOT NULL,
  `avatarUrl` varchar(255) NOT NULL,
  `openid` varchar(50) NOT NULL,
  `api_key` varchar(255) NOT NULL,
  `login_act_code` varchar(50) NOT NULL,
  `utime` int(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  `appid` varchar(255) DEFAULT NULL,
  `github_openid` varchar(255) DEFAULT NULL,
  `login_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of zf_user
-- ----------------------------

-- ----------------------------
-- Table structure for zf_user_group
-- ----------------------------
DROP TABLE IF EXISTS `zf_user_group`;
CREATE TABLE `zf_user_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `ctime` int(11) NOT NULL DEFAULT '0',
  `sort` tinyint(5) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='用户分组表';

-- ----------------------------
-- Records of zf_user_group
-- ----------------------------
INSERT INTO `zf_user_group` VALUES ('1', '高级会员', '1', '1538127552', '0');
INSERT INTO `zf_user_group` VALUES ('2', '普通会员', '1', '1538127552', '0');
