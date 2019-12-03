/*
 Navicat MySQL Data Transfer

 Source Server         : 测试服务器---个人阿里云
 Source Server Type    : MySQL
 Source Server Version : 50562
 Source Host           : 120.78.193.246:3306
 Source Schema         : v1_fast_zf_90ckm

 Target Server Type    : MySQL
 Target Server Version : 50562
 File Encoding         : 65001

 Date: 20/11/2019 21:28:53
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for zf_admin
-- ----------------------------
DROP TABLE IF EXISTS `zf_admin`;
CREATE TABLE `zf_admin` (
  `id` tinyint(11) unsigned NOT NULL AUTO_INCREMENT,
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
  `pic` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of zf_admin
-- ----------------------------
BEGIN;
INSERT INTO `zf_admin` VALUES (1, 3, 'admin', 'e10adc3949ba59abbe56e057f20f883e', '17621542500', '', 0, 1, '23', 1, 0, '', 0, 2018, 0, '', 0, 'https://i.loli.net/2019/10/29/9OCU2VXHtAFhzoT.jpg');
INSERT INTO `zf_admin` VALUES (10, 9, 'test', '96e79218965eb72c92a549dd5a330112', '', '', 0, 0, '', 1, 0, '', 0, 0, 1, '', 0, '');
COMMIT;

-- ----------------------------
-- Table structure for zf_admin_group
-- ----------------------------
DROP TABLE IF EXISTS `zf_admin_group`;
CREATE TABLE `zf_admin_group` (
  `id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `ctime` int(11) DEFAULT NULL,
  `sort` tinyint(5) NOT NULL DEFAULT '1',
  `role` varchar(250) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='管理员分组表';

-- ----------------------------
-- Records of zf_admin_group
-- ----------------------------
BEGIN;
INSERT INTO `zf_admin_group` VALUES (00000000001, '普通管理员', 1, 2018, 1, '1,4,10,19,8,9,36,95,15,14,32,24,37,68,40,41,45,46,50,88,54,55,60,64,70,77,79,80,82,83');
INSERT INTO `zf_admin_group` VALUES (00000000003, '超级管理员', 1, 2018, 1, '1,2,3,4,10,19,84,8,9,36,15,14,32,24,25,27,37,38,68,40,41,46,50,54,55,60,64,70,71,72,77,78,79,80,82,83');
INSERT INTO `zf_admin_group` VALUES (00000000009, '测试分组', 1, NULL, 0, '9,70,40,41,45,46,50,79,80,15,14,32,54,55,60,64,24,27,37,68,115,1,10,108');
COMMIT;

-- ----------------------------
-- Table structure for zf_admin_log
-- ----------------------------
DROP TABLE IF EXISTS `zf_admin_log`;
CREATE TABLE `zf_admin_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `action` varchar(255) NOT NULL,
  `ctime` int(11) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `uid` int(11) NOT NULL,
  `post` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6466 DEFAULT CHARSET=utf8mb4 COMMENT='后台访问日志表';

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
  `control` varchar(50) NOT NULL,
  `act` varchar(50) NOT NULL,
  `menu` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=126 DEFAULT CHARSET=utf8 COMMENT='管理员权限表';

-- ----------------------------
-- Records of zf_admin_role
-- ----------------------------
BEGIN;
INSERT INTO `zf_admin_role` VALUES (1, '网站管理', 'Config/', 1, 1, '', 99, 0, 'Config', '', 1);
INSERT INTO `zf_admin_role` VALUES (2, '网站设置', 'Config/index', 1, 1, '', 0, 1, 'Config', 'index', 1);
INSERT INTO `zf_admin_role` VALUES (3, '邮件服务', 'Config/email', 1, 1, '', 4, 1, 'Config', 'email', 1);
INSERT INTO `zf_admin_role` VALUES (4, '管理员列表', 'Config/admin_index', 1, 1, '', 1, 1, 'Config', 'admin_index', 1);
INSERT INTO `zf_admin_role` VALUES (5, '添加管理员', 'Config/admin_add', 1, 1, '', 0, 4, 'Config', 'admin_add', 0);
INSERT INTO `zf_admin_role` VALUES (6, '编辑管理员', 'Config/admin_edit', 1, 1, '', 0, 4, 'Config', 'admin_edit', 0);
INSERT INTO `zf_admin_role` VALUES (7, '删除管理员', 'Config/admin_del', 1, 1, '', 0, 4, 'Config', 'admin_del', 0);
INSERT INTO `zf_admin_role` VALUES (8, '后台首页', 'Index/index', 1, 1, '', 0, 0, 'Index', 'index', 0);
INSERT INTO `zf_admin_role` VALUES (9, '欢迎页', 'Index/welcome', 1, 1, '', 0, 8, 'Index', 'welcome', 1);
INSERT INTO `zf_admin_role` VALUES (10, '权限列表', 'Config/admin_role', 1, 1, '', 3, 1, 'Config', 'admin_role', 1);
INSERT INTO `zf_admin_role` VALUES (11, '增加权限', 'Config/admin_role_add', 1, 1, '', 0, 10, 'Config', 'admin_role_add', 0);
INSERT INTO `zf_admin_role` VALUES (12, '编辑权限', 'Config/admin_role_edit', 1, 1, '', 0, 10, 'Config', 'admin_role_edit', 0);
INSERT INTO `zf_admin_role` VALUES (13, '删除权限', 'Config/admin_role_del', 1, 1, '', 0, 10, 'Config', 'admin_role_del', 0);
INSERT INTO `zf_admin_role` VALUES (14, '用户列表', 'User/index', 1, 1, '', 0, 15, 'User', 'index', 1);
INSERT INTO `zf_admin_role` VALUES (15, '用户管理', 'User/', 1, 1, '', 5, 0, 'User', '', 1);
INSERT INTO `zf_admin_role` VALUES (16, '增加用户', 'User/add', 1, 1, '', 0, 14, 'User', 'add', 0);
INSERT INTO `zf_admin_role` VALUES (17, '编辑用户', 'User/edit', 1, 1, '', 0, 14, 'User', 'edit', 0);
INSERT INTO `zf_admin_role` VALUES (18, '获取方法', 'Config/get_action', 1, 1, '', 0, 10, 'Config', 'get_action', 0);
INSERT INTO `zf_admin_role` VALUES (19, '管理员分组', 'Config/admin_group', 1, 1, '', 2, 1, 'Config', 'admin_group', 1);
INSERT INTO `zf_admin_role` VALUES (20, '管理员分组-添加', 'Config/admin_group_add', 1, 1, '', 0, 19, 'Config', 'admin_group_add', 0);
INSERT INTO `zf_admin_role` VALUES (21, '管理员分组-修改', 'Config/admin_group_edit', 1, 1, '', 0, 19, 'Config', 'admin_group_edit', 0);
INSERT INTO `zf_admin_role` VALUES (22, '管理员分组-删除', 'Config/admin_group_del', 1, 1, '', 0, 19, 'Config', 'admin_group_del', 0);
INSERT INTO `zf_admin_role` VALUES (23, '管理员分组-权限', 'Config/admin_group_role', 1, 1, '', 0, 19, 'Config', 'admin_group_role', 0);
INSERT INTO `zf_admin_role` VALUES (24, '素材管理', 'Upload/', 1, 1, '', 6, 0, 'Upload', '', 0);
INSERT INTO `zf_admin_role` VALUES (25, '素材列表', 'Upload/index', 1, 1, '', 0, 24, 'Upload', 'index', 1);
INSERT INTO `zf_admin_role` VALUES (26, '添加图片', 'Upload/img_add', 1, 1, '', 0, 25, 'Upload', 'img_add', 0);
INSERT INTO `zf_admin_role` VALUES (27, '素材分类', 'Upload/group', 1, 1, '', 0, 24, 'Upload', 'group', 1);
INSERT INTO `zf_admin_role` VALUES (28, '素材分类-添加', 'Upload/group_add', 1, 1, '', 0, 27, 'Upload', 'group_add', 0);
INSERT INTO `zf_admin_role` VALUES (29, '素材分类-修改', 'Upload/group_edit', 1, 1, '', 0, 27, 'Upload', 'group_edit', 0);
INSERT INTO `zf_admin_role` VALUES (30, '素材分类-删除', 'Upload/group_del', 1, 1, '', 0, 27, 'Upload', 'group_del', 0);
INSERT INTO `zf_admin_role` VALUES (31, '删除用户', 'User/del', 1, 1, '', 0, 14, 'User', 'del', 0);
INSERT INTO `zf_admin_role` VALUES (32, '用户分组', 'User/group', 1, 1, '', 0, 15, 'User', 'group', 1);
INSERT INTO `zf_admin_role` VALUES (33, '增加分组', 'User/group_add', 1, 1, '', 0, 32, 'User', 'group_add', 0);
INSERT INTO `zf_admin_role` VALUES (34, '修改分组', 'User/group_edit', 1, 1, '', 0, 32, 'User', 'group_edit', 0);
INSERT INTO `zf_admin_role` VALUES (35, '删除分组', 'User/group_del', 1, 1, '', 0, 32, 'User', 'group_del', 0);
INSERT INTO `zf_admin_role` VALUES (36, '修改密码', 'User/pwd_edit', 1, 1, '', 0, 8, 'User', 'pwd_edit', 0);
INSERT INTO `zf_admin_role` VALUES (37, '数据库管理', 'Mysql/', 1, 1, '', 9, 0, 'Mysql', '', 1);
INSERT INTO `zf_admin_role` VALUES (40, '内容管理', 'Category/', 1, 1, '', 1, 0, 'Category', '', 1);
INSERT INTO `zf_admin_role` VALUES (41, '栏目列表', 'Category/index', 1, 1, '', 0, 40, 'Category', 'index', 1);
INSERT INTO `zf_admin_role` VALUES (42, '新增栏目', 'Category/category_add', 1, 1, '', 0, 41, 'Category', 'category_add', 0);
INSERT INTO `zf_admin_role` VALUES (43, '修改栏目', 'Category/category_edit', 1, 1, '', 0, 41, 'Category', 'category_edit', 0);
INSERT INTO `zf_admin_role` VALUES (44, '删除栏目', 'Category/category_del', 1, 1, '', 0, 41, 'Category', 'category_del', 0);
INSERT INTO `zf_admin_role` VALUES (45, '内容列表', 'Category/post_list', 1, 1, '', 0, 41, 'Category', 'post_list', 0);
INSERT INTO `zf_admin_role` VALUES (46, '内容模型', 'Category/category_model', 1, 1, '', 0, 40, 'Category', 'category_model', 1);
INSERT INTO `zf_admin_role` VALUES (47, '新增模型', 'Category/category_model_add', 1, 1, '', 0, 46, 'Category', 'category_model_add', 0);
INSERT INTO `zf_admin_role` VALUES (48, '编辑模型', 'Category/category_model_edit', 1, 1, '', 0, 46, 'Category', 'category_model_edit', 0);
INSERT INTO `zf_admin_role` VALUES (49, '删除模型', 'Category/category_model_del', 1, 1, '', 0, 46, 'Category', 'category_model_del', 0);
INSERT INTO `zf_admin_role` VALUES (50, '内容列表', 'Category/post_all_list', 1, 1, '', 0, 40, 'Category', 'post_all_list', 1);
INSERT INTO `zf_admin_role` VALUES (51, '内容添加', 'Category/post_add', 1, 1, '', 0, 50, 'Category', 'post_add', 0);
INSERT INTO `zf_admin_role` VALUES (52, '内容编辑', 'Category/post_edit', 1, 1, '', 0, 50, 'Category', 'post_edit', 0);
INSERT INTO `zf_admin_role` VALUES (53, '内容删除', 'Category/post_del', 1, 1, '', 0, 50, 'Category', 'post_del', 0);
INSERT INTO `zf_admin_role` VALUES (54, '其他管理', 'Rests/', 1, 1, '', 5, 0, 'Rests', '', 1);
INSERT INTO `zf_admin_role` VALUES (55, '广告管理', 'Rests/advert', 1, 1, '', 0, 54, 'Rests', 'advert', 1);
INSERT INTO `zf_admin_role` VALUES (57, '增加广告', 'Rests/advert_add', 1, 1, '', 0, 55, 'Rests', 'advert_add', 0);
INSERT INTO `zf_admin_role` VALUES (58, '修改广告', 'Rests/advert_edit', 1, 1, '', 0, 55, 'Rests', 'advert_edit', 0);
INSERT INTO `zf_admin_role` VALUES (59, '删除广告', 'Rests/advert_del', 1, 1, '', 0, 55, 'Rests', 'advert_del', 0);
INSERT INTO `zf_admin_role` VALUES (60, '超链管理', 'Rests/link', 1, 1, '', 0, 54, 'Rests', 'link', 1);
INSERT INTO `zf_admin_role` VALUES (61, '增加超链', 'Rests/link_add', 1, 1, '', 0, 60, 'Rests', 'link_add', 0);
INSERT INTO `zf_admin_role` VALUES (62, '编辑超链', 'Rests/link_edit', 1, 1, '', 0, 60, 'Rests', 'link_edit', 0);
INSERT INTO `zf_admin_role` VALUES (63, '删除超链', 'Rests/link_del', 1, 1, '', 0, 60, 'Rests', 'link_del', 0);
INSERT INTO `zf_admin_role` VALUES (64, '留言管理', 'Rests/guessbook', 1, 1, '', 0, 54, 'Rests', 'guessbook', 1);
INSERT INTO `zf_admin_role` VALUES (65, '添加留言', 'Rests/guessbook_add', 1, 1, '', 0, 64, 'Rests', 'guessbook_add', 0);
INSERT INTO `zf_admin_role` VALUES (66, '编辑留言', 'Rests/guessbook_edit', 1, 1, '', 0, 64, 'Rests', 'guessbook_edit', 0);
INSERT INTO `zf_admin_role` VALUES (67, '删除留言', 'Rests/guessbook_del', 1, 1, '', 0, 64, 'Rests', 'guessbook_del', 0);
INSERT INTO `zf_admin_role` VALUES (68, '数据表结构', 'Mysql/index', 1, 1, '', 0, 37, 'Mysql', 'index', 1);
INSERT INTO `zf_admin_role` VALUES (70, '公共方法', 'Common/', 1, 1, '', 0, 0, 'Common', '', 0);
INSERT INTO `zf_admin_role` VALUES (71, '上传方法', 'Common/upload_one', 1, 1, '', 0, 70, 'Common', 'upload_one', 1);
INSERT INTO `zf_admin_role` VALUES (72, '状态转换', 'Common/is_switch', 1, 1, '', 0, 70, 'Common', 'is_switch', 1);
INSERT INTO `zf_admin_role` VALUES (73, '获取相似的标题', 'Category/title_get_list', 1, 1, '', 0, 10, 'Category', 'title_get_list', 0);
INSERT INTO `zf_admin_role` VALUES (74, '导出用户', 'User/export', 1, 1, '', 0, 14, 'User', 'export', 0);
INSERT INTO `zf_admin_role` VALUES (124, '修复数据表', 'Mysql/repair', 1, 1, NULL, 0, 115, 'Mysql', 'repair', 0);
INSERT INTO `zf_admin_role` VALUES (79, '模版管理', 'Template/', 1, 1, '', 2, 0, 'Template', '', 1);
INSERT INTO `zf_admin_role` VALUES (80, '模板列表', 'Template/tpl_list', 1, 1, '', 0, 79, 'Template', 'tpl_list', 1);
INSERT INTO `zf_admin_role` VALUES (81, '修改模板', 'Template/tpl_edit', 1, 1, '', 0, 80, 'Template', 'tpl_edit', 0);
INSERT INTO `zf_admin_role` VALUES (84, '图片设置', 'Config/img_config', 1, 1, '', 0, 1, 'Config', 'img_config', 1);
INSERT INTO `zf_admin_role` VALUES (123, '优化数据表', 'Mysql/optimize', 1, 1, NULL, 0, 115, 'Mysql', 'optimize', 0);
INSERT INTO `zf_admin_role` VALUES (122, '恢复数据库', 'Mysql/import', 1, 1, NULL, 0, 115, 'Mysql', 'import', 0);
INSERT INTO `zf_admin_role` VALUES (87, '内容导入', 'Category/import', 1, 1, '', 0, 50, 'Category', 'import', 0);
INSERT INTO `zf_admin_role` VALUES (88, '内容页获取标题列表', 'Category/search_post', 1, 1, '', 0, 50, 'Category', 'search_post', 0);
INSERT INTO `zf_admin_role` VALUES (89, '转换菜单', 'Common/is_menu', 1, 1, '', 0, 70, 'Common', 'is_menu', 1);
INSERT INTO `zf_admin_role` VALUES (90, '删除内容', 'Common/del_post', 1, 1, '', 0, 70, 'Common', 'del_post', 1);
INSERT INTO `zf_admin_role` VALUES (91, '批量删除', 'Common/more_del', 1, 1, '', 0, 70, 'Common', 'more_del', 1);
INSERT INTO `zf_admin_role` VALUES (92, '修改字段的值', 'Common/value_edit', 1, 1, '', 0, 70, 'Common', 'value_edit', 1);
INSERT INTO `zf_admin_role` VALUES (93, '测试邮箱', 'Config/test_email', 1, 1, '', 0, 3, 'Config', 'test_email', 0);
INSERT INTO `zf_admin_role` VALUES (95, '修改个人信息', 'User/admin_info', 1, 1, '', 0, 8, 'User', 'admin_info', 1);
INSERT INTO `zf_admin_role` VALUES (121, '备份数据库', 'Mysql/export', 1, 1, NULL, 0, 115, 'Mysql', 'export', 0);
INSERT INTO `zf_admin_role` VALUES (120, '数据库清理', 'Index/db_clear', 1, 1, NULL, 0, 8, 'Index', 'db_clear', 1);
INSERT INTO `zf_admin_role` VALUES (119, '网站属性编辑', 'Common/config_edit', 1, 1, NULL, 0, 70, 'Common', 'config_edit', 1);
INSERT INTO `zf_admin_role` VALUES (118, '阿里云oss', 'Common/aliyunoss', 1, 1, NULL, 0, 70, 'Common', 'aliyunoss', 1);
INSERT INTO `zf_admin_role` VALUES (108, '操作日志', 'Config/action_log', 1, 1, '', 15, 1, 'Config', 'action_log', 1);
INSERT INTO `zf_admin_role` VALUES (109, '第三方配置', 'Config/other_app', 1, 1, '', 10, 1, 'Config', 'other_app', 0);
INSERT INTO `zf_admin_role` VALUES (117, '上传文件', 'Common/upload_one_file', 1, 1, NULL, 0, 70, 'Common', 'upload_one_file', 1);
INSERT INTO `zf_admin_role` VALUES (116, '获取详情中图片', 'Category/get_content_pic_list', 1, 1, NULL, 0, 45, 'Category', 'get_content_pic_list', 1);
INSERT INTO `zf_admin_role` VALUES (115, '备份列表', 'Mysql/index2', 1, 1, '', 0, 37, 'Mysql', 'index2', 1);
INSERT INTO `zf_admin_role` VALUES (125, '删除备份', 'Mysql/del', 1, 1, NULL, 0, 115, 'Mysql', 'del', 0);
COMMIT;

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
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='广告表';

-- ----------------------------
-- Records of zf_advert
-- ----------------------------
BEGIN;
INSERT INTO `zf_advert` VALUES (11, '1', 'https://timgsa.baidu.com', 10, 0, '我是一条描述的信息', '', '', '', '', 'https://i.loli.net/2019/11/16/iCrXmphy34Jce8z.jpg', 0, '', 0, '1');
INSERT INTO `zf_advert` VALUES (10, '首页banner', '', 0, 0, '', '', '', '', '', '', 0, 'banner', 0, '1');
INSERT INTO `zf_advert` VALUES (14, '2', '', 10, NULL, '<p class=\"title\">网络公司</p>\r\n            <p>完美前端体验</p>', NULL, NULL, NULL, NULL, 'http://v1.fast.zf.90ckm.com/template/index/a1/style//img/banner1.jpg', NULL, NULL, NULL, '9');
COMMIT;

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
) ENGINE=MyISAM AUTO_INCREMENT=446 DEFAULT CHARSET=utf8 COMMENT='分类表';

-- ----------------------------
-- Records of zf_category
-- ----------------------------
BEGIN;
INSERT INTO `zf_category` VALUES (425, 0, 14, '产品', 'Product Display', '', '', 'http://v1.fast.zf.90ckm.com/template/index/a1/style/img/nav_img1.jpg', '', '', 1, 0, 1, 1563957347, 0, '<p>qqq</p>', 'tpl_pro', 'tpl_content', 10, '', '', '', '', '');
INSERT INTO `zf_category` VALUES (441, 0, 14, '动态', 'Real-time News', NULL, '', '', '', '', 1, 0, 1, 1570589981, NULL, NULL, 'tpl_news', 'tpl_content_news', 6, '', '', '', '', '');
INSERT INTO `zf_category` VALUES (442, 0, 14, '案例', 'Successful Case', NULL, '', '', '', '', 1, 0, 1, 1570590006, NULL, NULL, 'tpl_case', '', 10, '', '', '', '', '');
INSERT INTO `zf_category` VALUES (443, 0, 1, '关于', 'About Us', NULL, '', '', '', '', 1, 0, 1, 1570590019, NULL, NULL, 'tpl_about', '', 10, '', '', '', '', '');
INSERT INTO `zf_category` VALUES (444, 0, 1, '获取地址', '', NULL, '', '', '', 'http://bbs.wangmingchang.com/forum.php?mod=forumdisplay&fid=77', 1, 0, 1, 1570590036, NULL, NULL, '', '', 10, '', '', '', '', '');
INSERT INTO `zf_category` VALUES (445, 443, 14, 'cs', '', NULL, '', '', '', '', 0, 0, 0, 1572253436, NULL, '<p>dsf</p>', '', '', 10, '', '', '', '', '');
COMMIT;

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
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='分类模型表';

-- ----------------------------
-- Records of zf_category_model
-- ----------------------------
BEGIN;
INSERT INTO `zf_category_model` VALUES (1, '单页模型', 'simple', 2, 1, 1, 0);
INSERT INTO `zf_category_model` VALUES (15, '新闻模型', 'news', 0, 1, 0, 0);
INSERT INTO `zf_category_model` VALUES (14, 'ZF内容模型', 'zf_tpl', 2, 1, 1, 1);
COMMIT;

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
BEGIN;
INSERT INTO `zf_category_model_parm` VALUES (2, 1, '图集', 'album', '', 'album', 1, 0, 0, 2, 3, 1);
INSERT INTO `zf_category_model_parm` VALUES (3, 1, '标题', 'title', '', 'layui-input', 1, 0, 0, 14, 1, 0);
INSERT INTO `zf_category_model_parm` VALUES (4, 1, '栏目描述', 'summary', '', 'layui-textarea', 1, 0, 0, 14, 2, 0);
INSERT INTO `zf_category_model_parm` VALUES (5, 1, '缩略图', 'album', '', 'album', 0, 0, 0, 14, 3, 0);
INSERT INTO `zf_category_model_parm` VALUES (6, 1, '栏目详情', 'content', '', 'ueditor', 1, 0, 0, 14, 4, 0);
INSERT INTO `zf_category_model_parm` VALUES (7, 2, '作者', 'author', '', 'layui-input', 1, 0, 0, 14, 1, 0);
INSERT INTO `zf_category_model_parm` VALUES (8, 1, '时间', 'ctime', '', 'layui-time', 1, 0, 0, 14, 1, 0);
INSERT INTO `zf_category_model_parm` VALUES (9, 2, '排序', 'sort', '', 'layui-input', 1, 0, 0, 14, 0, 0);
INSERT INTO `zf_category_model_parm` VALUES (10, 2, '扩展参数', 'append', '', 'layui-radio', 0, 0, 0, 14, 0, 0);
INSERT INTO `zf_category_model_parm` VALUES (11, 2, '封面图', 'pic', '', 'layui-pic', 1, 0, 0, 14, 5, 0);
INSERT INTO `zf_category_model_parm` VALUES (12, 2, '文件', 'file', '', 'layui-file', 1, 0, 0, 14, 6, 0);
INSERT INTO `zf_category_model_parm` VALUES (17, 1, '标题', 'title', '', 'layui-input', 1, 0, 0, 2, 1, 0);
INSERT INTO `zf_category_model_parm` VALUES (18, 1, '简介', 'summary', '', 'layui-textarea', 1, 0, 0, 2, 2, 0);
INSERT INTO `zf_category_model_parm` VALUES (19, 2, '图片', 'pic', '', 'layui-pic', 1, 0, 0, 2, 4, 0);
INSERT INTO `zf_category_model_parm` VALUES (20, 2, '排序', 'sort', '', 'layui-input', 1, 0, 0, 2, 2, 0);
INSERT INTO `zf_category_model_parm` VALUES (21, 2, '时间', 'ctime', '', 'layui-time', 1, 0, 0, 2, 3, 0);
INSERT INTO `zf_category_model_parm` VALUES (22, 1, '详情', 'content', '', 'ueditor', 1, 0, 0, 2, 4, 0);
INSERT INTO `zf_category_model_parm` VALUES (23, 2, '作者', 'author', '', 'layui-input', 1, 0, 0, 2, 1, 0);
INSERT INTO `zf_category_model_parm` VALUES (24, 2, '推荐', 'recommend', '', 'layui-switch', 1, 0, 0, 14, 9, 0);
COMMIT;

-- ----------------------------
-- Table structure for zf_config
-- ----------------------------
DROP TABLE IF EXISTS `zf_config`;
CREATE TABLE `zf_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(50) NOT NULL,
  `value` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `msg` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='系统变量表';

-- ----------------------------
-- Records of zf_config
-- ----------------------------
BEGIN;
INSERT INTO `zf_config` VALUES (1, 'zf_tpl_suffix', 'a1', 1, NULL);
COMMIT;

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
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='留言表';

-- ----------------------------
-- Records of zf_guessbook
-- ----------------------------
BEGIN;
INSERT INTO `zf_guessbook` VALUES (8, 'ewq', 'qwe', 'wqe', '', 0, 0, '', '', 1);
INSERT INTO `zf_guessbook` VALUES (9, 'admin', 'cs', 'cs', '', 0, 1572423987, '', '', 1);
COMMIT;

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='超链表';

-- ----------------------------
-- Records of zf_link
-- ----------------------------
BEGIN;
INSERT INTO `zf_link` VALUES (1, '王明昌博客', 'https://www.wangmingchang.com/', '2', '1', 1540285148, '', 0, '个人博客\r\n');
INSERT INTO `zf_link` VALUES (4, 'Mc技术论坛', 'http://bbs.wangmingchang.com/forum.php', '1', '1', NULL, NULL, 0, '');
COMMIT;

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
) ENGINE=MyISAM AUTO_INCREMENT=267 DEFAULT CHARSET=utf8 COMMENT='内容表';

-- ----------------------------
-- Records of zf_post
-- ----------------------------
BEGIN;
INSERT INTO `zf_post` VALUES (248, 425, 'hello.world!', '这是第一篇文章', 'http://zf-demo-test.oss-cn-beijing.aliyuncs.com/demo_zf_test/upload/simple/image/20190927/1569579364_moren_upload.png', 1, 1569579211, NULL, 0, '<p>这是第一篇文章</p>', '', '', '', 0.00, 0.00, '0', 15, '', '匿名', '', 0, 0, 0, NULL, 1, 0, 0, 0);
INSERT INTO `zf_post` VALUES (249, 425, '本地上传', '', 'http://v1.fast.zf.90ckm.com/upload/file/water/20191007102048_5154.png', 9, 1570414569, NULL, 0, '<p><img src=\"/upload/image/20191007/1570415283713210.png\" alt=\"1570415283713210.png\"/></p>', '', 'http://v1.fast.zf.90ckm.com/upload/file/20191007/98e796fb25d780da14b0f64c5c0b948b.png', '', 0.00, 0.00, '0', 3, '', '匿名', '', 0, 0, 0, NULL, 1, 0, 0, 0);
INSERT INTO `zf_post` VALUES (250, 441, '一直在你身边对你好，你却没有发现。', '找老婆要找爱发脾气的女人。永远不会发脾气的女人就如同一杯白开水，解渴，却无味。而发脾气的女人正如烈酒般，刺激而令人无法忘怀。', 'http://v1.fast.zf.90ckm.com/template/index/a1/style//img/news_img1.jpg', 1, 1570606577, NULL, 0, NULL, '', '', '', 0.00, 0.00, '0', 0, '', '匿名', '', 0, 0, 0, NULL, 1, 0, 0, 0);
INSERT INTO `zf_post` VALUES (251, 441, '一直在你身边对你好，你却没有发现。', '找老婆要找爱发脾气的女人。永远不会发脾气的女人就如同一杯白开水，解渴，却无味。而发脾气的女人正如烈酒般，刺激而令人无法忘怀。', 'http://v1.fast.zf.90ckm.com/template/index/a1/style//img/news_img1.jpg', 1, 1570606596, NULL, 0, NULL, '', '', '', 0.00, 0.00, '0', 0, '', '匿名', '', 0, 0, 0, NULL, 1, 0, 0, 0);
INSERT INTO `zf_post` VALUES (252, 441, '写经验交流材料的技巧全在这了！', '找老婆要找爱发脾气的女人。永远不会发脾气的女人就如同一杯白开水，解渴，却无味。而发脾气的女人正如烈酒般，刺激而令人无法忘怀。', 'http://v1.fast.zf.90ckm.com/template/index/a1/style//img/news_img1.jpg', 1, 1570606608, NULL, 0, NULL, '', '', '', 0.00, 0.00, '0', 0, '', '匿名', '', 0, 0, 0, NULL, 1, 0, 0, 0);
INSERT INTO `zf_post` VALUES (253, 441, '写经验交流材料的技巧全在这了！', '找老婆要找爱发脾气的女人。永远不会发脾气的女人就如同一杯白开水，解渴，却无味。而发脾气的女人正如烈酒般，刺激而令人无法忘怀。', 'http://v1.fast.zf.90ckm.com/template/index/a1/style//img/news_img1.jpg', 1, 1570606613, NULL, 0, NULL, '', '', '', 0.00, 0.00, '0', 1, '', '匿名', '', 0, 0, 0, NULL, 1, 0, 0, 0);
INSERT INTO `zf_post` VALUES (254, 441, '经验分享：我是如何做好每日计划的', '找老婆要找爱发脾气的女人。永远不会发脾气的女人就如同一杯白开水，解渴，却无味。而发脾气的女人正如烈酒般，刺激而令人无法忘怀。', 'http://v1.fast.zf.90ckm.com/template/index/a1/style//img/news_img1.jpg', 1, 1570606623, NULL, 0, NULL, '', '', '', 0.00, 0.00, '0', 0, '', '匿名', '', 0, 0, 0, NULL, 1, 0, 0, 0);
INSERT INTO `zf_post` VALUES (255, 441, '经验分享：我是如何做好每日计划的', '找老婆要找爱发脾气的女人。永远不会发脾气的女人就如同一杯白开水，解渴，却无味。而发脾气的女人正如烈酒般，刺激而令人无法忘怀。', 'http://v1.fast.zf.90ckm.com/template/index/a1/style//img/news_img1.jpg', 1, 1570606628, NULL, 0, NULL, '', '', '', 0.00, 0.00, '0', 2, '', '匿名', '', 0, 0, 0, NULL, 1, 0, 0, 0);
INSERT INTO `zf_post` VALUES (256, 441, '脾气不好的妈妈好好读读这篇文章，真的是细思极恐', '找老婆要找爱发脾气的女人。永远不会发脾气的女人就如同一杯白开水，解渴，却无味。而发脾气的女人正如烈酒般，刺激而令人无法忘怀。', 'http://v1.fast.zf.90ckm.com/template/index/a1/style//img/news_img1.jpg', 1, 1570606640, NULL, 0, NULL, '', '', '', 0.00, 0.00, '0', 1, '', '匿名', '', 0, 0, 0, NULL, 1, 0, 0, 0);
INSERT INTO `zf_post` VALUES (257, 441, '养女儿，一定要让她漂亮！', '找老婆要找爱发脾气的女人。永远不会发脾气的女人就如同一杯白开水，解渴，却无味。而发脾气的女人正如烈酒般，刺激而令人无法忘怀。', 'http://v1.fast.zf.90ckm.com/template/index/a1/style//img/news_img1.jpg', 1, 1570606645, NULL, 2, '<p class=\"introTop\">TA家的珍珠是用黑糖熬制的，要熬整整四个小时才行，每熬一锅黑糖只能做出40杯奶茶，好味，是值得等待的。</p><div><img src=\"{$tpl_static}/img/news_big.jpg\" alt=\"新闻详情图\"/></div><p class=\"introBott\">北极光的制作，需要300g葡萄来完成，要选用最新鲜的葡萄，才能做出最灿烂的北极光。满满一瓶葡萄，看着就让人倍感满足。喝之前，要先摇9下，才能喝出最好的果味。晨曦的寓意是，清晨的阳光。要用到一整颗百香果的晨曦，喝起来酸酸甜甜，果味浓郁。晨曦喝起来果味极浓，不仅仅有百香果，还有芒果、橙汁...的味道，十分清新，彷佛夏日的一抹凉风！</p>', '', '', '', 0.00, 0.00, '0', 27, '', '匿名', '', 0, 0, 0, NULL, 1, 0, 0, 0);
INSERT INTO `zf_post` VALUES (258, 442, '名牌工厂店', '一家工厂企业的商品展示网站，主要以卖高端服饰为主。主要以卖高端服饰为主。主要以卖高端服饰为主。', 'http://v1.fast.zf.90ckm.com/template/index/a1/style//img/case1.jpg', 1, 1570607284, NULL, 0, NULL, '', '', '', 0.00, 0.00, '0', 0, '', '匿名', '', 0, 0, 0, NULL, 1, 0, 0, 0);
INSERT INTO `zf_post` VALUES (259, 442, '名牌工厂店', '一家工厂企业的商品展示网站，主要以卖高端服饰为主。主要以卖高端服饰为主。主要以卖高端服饰为主。', 'http://v1.fast.zf.90ckm.com/template/index/a1/style//img/case1.jpg', 1, 1570607289, NULL, 0, NULL, '', '', '', 0.00, 0.00, '0', 0, '', '匿名', '', 0, 0, 0, NULL, 1, 0, 0, 0);
INSERT INTO `zf_post` VALUES (260, 442, '名牌工厂店', '一家工厂企业的商品展示网站，主要以卖高端服饰为主。主要以卖高端服饰为主。主要以卖高端服饰为主。', 'http://v1.fast.zf.90ckm.com/template/index/a1/style//img/case1.jpg', 1, 1570607294, NULL, 0, NULL, '', '', '', 0.00, 0.00, '0', 0, '', '匿名', '', 0, 0, 0, NULL, 1, 0, 0, 0);
INSERT INTO `zf_post` VALUES (261, 445, 'test1', '', '', 9, 1572266524, NULL, 11, NULL, '', '', '', 0.00, 0.00, '0', 0, '', '', '', 0, 0, 0, NULL, 1, 0, 0, 0);
INSERT INTO `zf_post` VALUES (262, 445, '1121', 'dsadw', 'http://v1.fast.zf.90ckm.com/upload/file/water/20191029174037_1605.png', 9, 1573310566, NULL, 0, '<p>dsadsa</p>', '0', 'http://v1.fast.zf.90ckm.com/upload/file/20191029/cf2e383ad622055892f34e96192bae40.txt', 'http://v1.fast.zf.90ckm.com/upload/file/water/20191029101204_6490.png,http://v1.fast.zf.90ckm.com/upload/file/water/20191029172758_2665.png,http://v1.fast.zf.90ckm.com/upload/file/water/20191029163624_1634.png', 0.00, 0.00, '0', 0, '', '', '', 0, 0, 0, NULL, 1, 0, 0, 0);
INSERT INTO `zf_post` VALUES (263, 445, 'test2', 'dsa', NULL, 9, 1572421806, NULL, 0, '<p>123dfssd</p>', '0', 'http://v1.fast.zf.90ckm.com/upload/file/20191029/6a1906b49d6cd554d9adaee3564ef11f.txt', 'http://v1.fast.zf.90ckm.com/upload/file/water/20191029174146_5983.png,http://v1.fast.zf.90ckm.com/upload/file/20191030/89126c3a68e54199bccdc4e18a40509b.jpg,http://v1.fast.zf.90ckm.com/upload/file/water/20191029174148_2329.png', 0.00, 0.00, '0', 0, '', '', '', 0, 0, 0, NULL, 1, 0, 0, 0);
INSERT INTO `zf_post` VALUES (264, 445, NULL, NULL, NULL, 9, 1572416148, NULL, 0, '<p>sa</p>', '1', '', '', 0.00, 0.00, '0', 0, '', '', '', 0, 0, 0, NULL, 1, 0, 0, 0);
INSERT INTO `zf_post` VALUES (265, 445, '1111', NULL, '', 9, 1572416331, NULL, 0, NULL, '0', '', '', 0.00, 0.00, '0', 0, '', '', '', 0, 0, 0, NULL, 1, 0, 0, 0);
INSERT INTO `zf_post` VALUES (266, 445, 'wewew', '', 'http://v1.fast.zf.90ckm.com/upload/file/20191118/ad3411963a149e958126056f5f364274.jpg', 1, 1574045581, NULL, 0, '<p>dsafds</p>', NULL, '', '', 0.00, 0.00, '0', 0, '', '', '', 0, 0, 0, NULL, 1, 0, 0, 0);
COMMIT;

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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=418 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of zf_user
-- ----------------------------
BEGIN;
INSERT INTO `zf_user` VALUES (387, 'Eric·枫1', '96e79218965eb72c92a549dd5a330112', '17621555555', '', 0, 1, '', 1, 1, '101.85.236.240', 0, 1559742074, 1, 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTLg2vgKPQCKeia72M77zDH9nEjdZjjUf1A9W3ciaicBCaDaoC7Wraur2Ll1wf0SMUa5TKgUy3zQyH2EQ/132', 'Eric·枫', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTLg2vgKPQCKeia72M77zDH9nEjdZjjUf1A9W3ciaicBCaDaoC7Wraur2Ll1wf0SMUa5TKgUy3zQyH2EQ/132', 'opXQA0ZqyQgvqGSupBkXqNsgMg_E', '', '');
COMMIT;

-- ----------------------------
-- Table structure for zf_user_group
-- ----------------------------
DROP TABLE IF EXISTS `zf_user_group`;
CREATE TABLE `zf_user_group` (
  `sort` tinyint(5) NOT NULL DEFAULT '1',
  `id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `ctime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='用户分组表';

-- ----------------------------
-- Records of zf_user_group
-- ----------------------------
BEGIN;
INSERT INTO `zf_user_group` VALUES (0, 00000000001, '高级会员', 1, 2018);
INSERT INTO `zf_user_group` VALUES (0, 00000000003, '普通会员', 1, 1538127552);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
