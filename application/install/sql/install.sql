/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : zfadmin_db

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-11-01 14:49:37
*/

SET FOREIGN_KEY_CHECKS=0;

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
  `create_time` int(11) DEFAULT NULL,
  `sort` tinyint(5) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zf_admin
-- ----------------------------
INSERT INTO `zf_admin` VALUES ('1', '1', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '88888888', '', '0', '1', '上海', '1', '0', '', '0', '0', '0');
INSERT INTO `zf_admin` VALUES ('3', '1', '12345', 'e10adc3949ba59abbe56e057f20f883e', '', '', '0', '0', '', '0', '0', '', '0', '0', '1');

-- ----------------------------
-- Table structure for zf_admin_group
-- ----------------------------
DROP TABLE IF EXISTS `zf_admin_group`;
CREATE TABLE `zf_admin_group` (
  `id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `create_time` int(11) DEFAULT NULL,
  `sort` tinyint(5) NOT NULL DEFAULT '1',
  `role` varchar(250) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zf_admin_group
-- ----------------------------
INSERT INTO `zf_admin_group` VALUES ('00000000001', '超级管理员', '1', '0', '1', '8,9,36,40,41,42,43,44,45,46,47,48,49,50,51,52,53,70,71,72,15,14,16,17,31,32,33,34,35,24,25,26,27,28,29,30,54,55,57,58,59,60,61,62,63,64,65,66,67,37,38,68,39,69,1,2,76,4,5,6,7,19,20,21,22,23,10,11,12,13,18,3');
INSERT INTO `zf_admin_group` VALUES ('00000000003', 'pt123', '1', '1540702872', '0', '0');

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
) ENGINE=MyISAM AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zf_admin_role
-- ----------------------------
INSERT INTO `zf_admin_role` VALUES ('1', '网站设置', 'Config/', '1', '1', '', '99', '0', 'Config', '', '1');
INSERT INTO `zf_admin_role` VALUES ('2', '基本设置', 'Config/index', '1', '1', '', '0', '1', 'Config', 'index', '1');
INSERT INTO `zf_admin_role` VALUES ('3', '邮件服务', 'Config/email', '1', '1', '', '4', '1', 'Config', 'email', '1');
INSERT INTO `zf_admin_role` VALUES ('4', '管理员列表', 'Config/admin_index', '1', '1', '', '1', '1', 'Config', 'admin_index', '1');
INSERT INTO `zf_admin_role` VALUES ('5', '添加管理员', 'Config/admin_add', '1', '1', '', '0', '4', 'Config', 'admin_add', '1');
INSERT INTO `zf_admin_role` VALUES ('6', '编辑管理员', 'Config/admin_edit', '1', '1', '', '0', '4', 'Config', 'admin_edit', '1');
INSERT INTO `zf_admin_role` VALUES ('7', '删除管理员', 'Config/admin_del', '1', '1', '', '0', '4', 'Config', 'admin_del', '1');
INSERT INTO `zf_admin_role` VALUES ('8', '后台首页', 'Index/index', '1', '1', '', '0', '0', 'Index', 'index', '1');
INSERT INTO `zf_admin_role` VALUES ('9', '欢迎页', 'Index/welcome', '1', '1', '', '0', '8', 'Index', 'welcome', '1');
INSERT INTO `zf_admin_role` VALUES ('10', '权限列表', 'Config/admin_role', '1', '1', '', '3', '1', 'Config', 'admin_role', '1');
INSERT INTO `zf_admin_role` VALUES ('11', '增加权限', 'Config/admin_role_add', '1', '1', '', '0', '10', 'Config', 'admin_role_add', '1');
INSERT INTO `zf_admin_role` VALUES ('12', '编辑权限', 'Config/admin_role_edit', '1', '1', '', '0', '10', 'Config', 'admin_role_edit', '1');
INSERT INTO `zf_admin_role` VALUES ('13', '删除权限', 'Config/admin_role_del', '1', '1', '', '0', '10', 'Config', 'admin_role_del', '1');
INSERT INTO `zf_admin_role` VALUES ('14', '用户列表', 'User/index', '1', '1', '', '0', '15', 'User', 'index', '1');
INSERT INTO `zf_admin_role` VALUES ('15', '用户管理', 'User/', '1', '1', '', '1', '0', 'User', '', '1');
INSERT INTO `zf_admin_role` VALUES ('16', '增加用户', 'User/add', '1', '1', '', '0', '14', 'User', 'add', '1');
INSERT INTO `zf_admin_role` VALUES ('17', '编辑用户', 'User/edit', '1', '1', '', '0', '14', 'User', 'edit', '1');
INSERT INTO `zf_admin_role` VALUES ('18', '获取方法', 'Config/get_action', '1', '1', '', '0', '10', 'Config', 'get_action', '1');
INSERT INTO `zf_admin_role` VALUES ('19', '管理员分组', 'Config/admin_group', '1', '1', '', '2', '1', 'Config', 'admin_group', '0');
INSERT INTO `zf_admin_role` VALUES ('20', '管理员分组-添加', 'Config/admin_group_add', '1', '1', '', '0', '19', 'Config', 'admin_group_add', '1');
INSERT INTO `zf_admin_role` VALUES ('21', '管理员分组-修改', 'Config/admin_group_edit', '1', '1', '', '0', '19', 'Config', 'admin_group_edit', '1');
INSERT INTO `zf_admin_role` VALUES ('22', '管理员分组-删除', 'Config/admin_group_del', '1', '1', '', '0', '19', 'Config', 'admin_group_del', '1');
INSERT INTO `zf_admin_role` VALUES ('23', '管理员分组-权限', 'Config/admin_group_role', '1', '1', '', '0', '19', 'Config', 'admin_group_role', '1');
INSERT INTO `zf_admin_role` VALUES ('24', '素材管理', 'Upload/', '1', '1', '', '2', '0', 'Upload', '', '1');
INSERT INTO `zf_admin_role` VALUES ('25', '素材列表', 'Upload/index', '1', '1', '', '0', '24', 'Upload', 'index', '1');
INSERT INTO `zf_admin_role` VALUES ('26', '添加图片', 'Upload/img_add', '1', '1', '', '0', '25', 'Upload', 'img_add', '1');
INSERT INTO `zf_admin_role` VALUES ('27', '素材分类', 'Upload/group', '1', '1', '', '0', '24', 'Upload', 'group', '1');
INSERT INTO `zf_admin_role` VALUES ('28', '素材分类-添加', 'Upload/group_add', '1', '1', '', '0', '27', 'Upload', 'group_add', '1');
INSERT INTO `zf_admin_role` VALUES ('29', '素材分类-修改', 'Upload/group_edit', '1', '1', '', '0', '27', 'Upload', 'group_edit', '1');
INSERT INTO `zf_admin_role` VALUES ('30', '素材分类-删除', 'Upload/group_del', '1', '1', '', '0', '27', 'Upload', 'group_del', '1');
INSERT INTO `zf_admin_role` VALUES ('31', '删除用户', 'User/del', '1', '1', '', '0', '14', 'User', 'del', '1');
INSERT INTO `zf_admin_role` VALUES ('32', '用户分组', 'User/group', '1', '1', '', '0', '15', 'User', 'group', '1');
INSERT INTO `zf_admin_role` VALUES ('33', '增加分组', 'User/group_add', '1', '1', '', '0', '32', 'User', 'group_add', '1');
INSERT INTO `zf_admin_role` VALUES ('34', '修改分组', 'User/group_edit', '1', '1', '', '0', '32', 'User', 'group_edit', '1');
INSERT INTO `zf_admin_role` VALUES ('35', '删除分组', 'User/group_del', '1', '1', '', '0', '32', 'User', 'group_del', '1');
INSERT INTO `zf_admin_role` VALUES ('36', '修改密码', 'User/pwd_edit', '1', '1', '', '0', '8', 'User', 'pwd_edit', '0');
INSERT INTO `zf_admin_role` VALUES ('37', '数据库管理', 'Mysql/', '1', '1', '', '9', '0', 'Mysql', '', '1');
INSERT INTO `zf_admin_role` VALUES ('38', '数据库备份', 'Mysql/backup', '1', '1', '', '0', '37', 'Mysql', 'backup', '1');
INSERT INTO `zf_admin_role` VALUES ('39', '数据库还原', 'Mysql/restore', '1', '1', '', '0', '68', 'Mysql', 'restore', '1');
INSERT INTO `zf_admin_role` VALUES ('40', '内容管理', 'Category/', '1', '1', '', '0', '0', 'Category', '', '1');
INSERT INTO `zf_admin_role` VALUES ('41', '栏目列表', 'Category/index', '1', '1', '', '0', '40', 'Category', 'index', '1');
INSERT INTO `zf_admin_role` VALUES ('42', '新增栏目', 'Category/category_add', '1', '1', '', '0', '41', 'Category', 'category_add', '1');
INSERT INTO `zf_admin_role` VALUES ('43', '修改栏目', 'Category/category_edit', '1', '1', '', '0', '41', 'Category', 'category_edit', '1');
INSERT INTO `zf_admin_role` VALUES ('44', '删除栏目', 'Category/category_del', '1', '1', '', '0', '41', 'Category', 'category_del', '1');
INSERT INTO `zf_admin_role` VALUES ('45', '内容列表', 'Category/post_list', '1', '1', '', '0', '41', 'Category', 'post_list', '1');
INSERT INTO `zf_admin_role` VALUES ('46', '内容模型', 'Category/category_model', '1', '1', '', '0', '40', 'Category', 'category_model', '1');
INSERT INTO `zf_admin_role` VALUES ('47', '新增模型', 'Category/category_model_add', '1', '1', '', '0', '46', 'Category', 'category_model_add', '1');
INSERT INTO `zf_admin_role` VALUES ('48', '编辑模型', 'Category/category_model_edit', '1', '1', '', '0', '46', 'Category', 'category_model_edit', '1');
INSERT INTO `zf_admin_role` VALUES ('49', '删除模型', 'Category/category_model_del', '1', '1', '', '0', '46', 'Category', 'category_model_del', '1');
INSERT INTO `zf_admin_role` VALUES ('50', '内容列表', 'Category/post_all_list', '1', '1', '', '0', '40', 'Category', 'post_all_list', '1');
INSERT INTO `zf_admin_role` VALUES ('51', '内容添加', 'Category/post_add', '1', '1', '', '0', '50', 'Category', 'post_add', '1');
INSERT INTO `zf_admin_role` VALUES ('52', '内容编辑', 'Category/post_edit', '1', '1', '', '0', '50', 'Category', 'post_edit', '1');
INSERT INTO `zf_admin_role` VALUES ('53', '内容删除', 'Category/post_del', '1', '1', '', '0', '50', 'Category', 'post_del', '1');
INSERT INTO `zf_admin_role` VALUES ('54', '其他管理', 'Rests/', '1', '1', '', '5', '0', 'Rests', '', '1');
INSERT INTO `zf_admin_role` VALUES ('55', '广告管理', 'Rests/advert', '1', '1', '', '0', '54', 'Rests', 'advert', '1');
INSERT INTO `zf_admin_role` VALUES ('57', '增加广告', 'Rests/advert_add', '1', '1', '', '0', '55', 'Rests', 'advert_add', '1');
INSERT INTO `zf_admin_role` VALUES ('58', '修改广告', 'Rests/advert_edit', '1', '1', '', '0', '55', 'Rests', 'advert_edit', '1');
INSERT INTO `zf_admin_role` VALUES ('59', '删除广告', 'Rests/advert_del', '1', '1', '', '0', '55', 'Rests', 'advert_del', '1');
INSERT INTO `zf_admin_role` VALUES ('60', '超链管理', 'Rests/link', '1', '1', '', '0', '54', 'Rests', 'link', '1');
INSERT INTO `zf_admin_role` VALUES ('61', '增加超链', 'Rests/link_add', '1', '1', '', '0', '60', 'Rests', 'link_add', '1');
INSERT INTO `zf_admin_role` VALUES ('62', '编辑超链', 'Rests/link_edit', '1', '1', '', '0', '60', 'Rests', 'link_edit', '1');
INSERT INTO `zf_admin_role` VALUES ('63', '删除超链', 'Rests/link_del', '1', '1', '', '0', '60', 'Rests', 'link_del', '1');
INSERT INTO `zf_admin_role` VALUES ('64', '留言管理', 'Rests/guessbook', '1', '1', '', '0', '54', 'Rests', 'guessbook', '1');
INSERT INTO `zf_admin_role` VALUES ('65', '添加留言', 'Rests/guessbook_add', '1', '1', '', '0', '64', 'Rests', 'guessbook_add', '1');
INSERT INTO `zf_admin_role` VALUES ('66', '编辑留言', 'Rests/guessbook_edit', '1', '1', '', '0', '64', 'Rests', 'guessbook_edit', '1');
INSERT INTO `zf_admin_role` VALUES ('67', '删除留言', 'Rests/guessbook_del', '1', '1', '', '0', '64', 'Rests', 'guessbook_del', '1');
INSERT INTO `zf_admin_role` VALUES ('68', '备份列表', 'Mysql/index', '1', '1', '', '0', '37', 'Mysql', 'index', '1');
INSERT INTO `zf_admin_role` VALUES ('69', '删除数据库', 'Mysql/delete', '1', '1', '', '0', '68', 'Mysql', 'delete', '1');
INSERT INTO `zf_admin_role` VALUES ('70', '公共方法', 'Common/', '1', '1', '', '0', '0', 'Common', '', '0');
INSERT INTO `zf_admin_role` VALUES ('71', '上传方法', 'Common/upload_one', '1', '1', '', '0', '70', 'Common', 'upload_one', '1');
INSERT INTO `zf_admin_role` VALUES ('72', '切换方法', 'Common/is_switch', '1', '1', '', '0', '70', 'Common', 'is_switch', '1');
INSERT INTO `zf_admin_role` VALUES ('76', '第三方设置', 'Config/thirdparty', '1', '1', null, '0', '1', 'Config', 'thirdparty', '1');

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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zf_advert
-- ----------------------------
INSERT INTO `zf_advert` VALUES ('2', '广告2', '', '0', '1540278594', '', '', '', '', '', '', '0', 'gg2', '0', '1');
INSERT INTO `zf_advert` VALUES ('3', '广告3', '', '0', '1540278615', 'dd', '', '', '', '', '', '0', 'gg3', '0', '1');
INSERT INTO `zf_advert` VALUES ('8', '1122', '', '0', '1540701833', '', '', '', '', '', '', '0', '', '0', '0');
INSERT INTO `zf_advert` VALUES ('7', 'qq', '', '2', '1540693424', '', '', '', '', '', '', '0', '', '0', '1');

-- ----------------------------
-- Table structure for zf_category
-- ----------------------------
DROP TABLE IF EXISTS `zf_category`;
CREATE TABLE `zf_category` (
  `cid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) DEFAULT NULL,
  `mid` tinyint(1) NOT NULL DEFAULT '1',
  `name` varchar(30) NOT NULL COMMENT '标题',
  `ccname` varchar(30) DEFAULT NULL COMMENT '别名',
  `ename` varchar(30) DEFAULT NULL COMMENT '英文名',
  `summary` varchar(255) DEFAULT NULL COMMENT '简介',
  `pic` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `url` varchar(150) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `sort` tinyint(4) DEFAULT NULL,
  `menu` tinyint(1) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `tpl_category` varchar(50) DEFAULT NULL,
  `tpl_post` varchar(50) DEFAULT NULL,
  `page` int(255) NOT NULL DEFAULT '10',
  `sname` varchar(100) DEFAULT NULL,
  `keyword` varchar(255) DEFAULT NULL,
  `target` varchar(20) DEFAULT NULL,
  `append` varchar(255) DEFAULT NULL,
  `album` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zf_category
-- ----------------------------
INSERT INTO `zf_category` VALUES ('1', '0', '1', '首页', 'index1', 'index', '打顶顶顶顶', '/public/data/upload/20181026\\d00e2ed1511ce159735c62ceefb8c9c5.jpg', '/public/data/upload/20181026\\f1bc489be9f04d791643489b1e2cce1f.jpg', '/public/data/upload/20181026\\e5aa52cb0d3461c7f8480775df142c3e.txt', 'www.baidu.com', '0', '0', '0', '1539157401', '1540540199', '<p>大萨达11111111111<img src=\"/upload/image/20181022/1540190178406478.jpg\" title=\"1540190178406478.jpg\" alt=\"3.jpg\"/></p>', 'index', 'index', '100', '11123', '搜索', '_black', '大萨达顶顶顶顶', '');
INSERT INTO `zf_category` VALUES ('3', '0', '2', '今日头条', '', '', '', '', '', '', '', '0', '0', '0', '1539160415', '1540191428', '', 'tpl_tt', 'tpl_post', '0', '', '', '', '', '');
INSERT INTO `zf_category` VALUES ('4', '3', '2', '新闻', '', '', '', '', '', '', '', '0', '0', '0', '1539160744', '1539659892', '', 'tpl_news', 'con_news', '0', '', '', '', '', '');
INSERT INTO `zf_category` VALUES ('5', '3', '4', '快讯', '', '', '', '', '', '', '', '0', '0', '0', '1539161446', '1539769717', '', 'tpl_news', 'tpl_news', '0', '', '', '', '', '');
INSERT INTO `zf_category` VALUES ('6', '0', '2', '每日搞笑', '', '', '', '', '', '', '', '0', '0', '0', '1539769794', '1540192250', '', '', '', '10', '', '', '', '', '');
INSERT INTO `zf_category` VALUES ('8', '0', '1', '22', 'two2', '', '111122', '', '', '', '', '0', '0', '0', '1540700961', '1540701222', '', '', '', '10', '', '', '', '', '');

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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zf_category_model
-- ----------------------------
INSERT INTO `zf_category_model` VALUES ('1', '单页模型', 'simple', '1', '1');
INSERT INTO `zf_category_model` VALUES ('2', '新闻模型', 'news', '2', '1');
INSERT INTO `zf_category_model` VALUES ('4', '内容模型', 'article', '3', '0');
INSERT INTO `zf_category_model` VALUES ('5', '视频模型', 'video', '4', '0');
INSERT INTO `zf_category_model` VALUES ('6', '下载模型', 'download', '5', '0');
INSERT INTO `zf_category_model` VALUES ('7', '图片模型', 'pic', '6', '0');
INSERT INTO `zf_category_model` VALUES ('8', '招聘模型', 'join', '7', '0');
INSERT INTO `zf_category_model` VALUES ('10', '222', '', '0', '1');

-- ----------------------------
-- Table structure for zf_config
-- ----------------------------
DROP TABLE IF EXISTS `zf_config`;
CREATE TABLE `zf_config` (
  `id` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `key` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zf_config
-- ----------------------------
INSERT INTO `zf_config` VALUES ('0000000001', 'webname', '');
INSERT INTO `zf_config` VALUES ('0000000002', 'email', '');
INSERT INTO `zf_config` VALUES ('0000000003', 'tel', '');
INSERT INTO `zf_config` VALUES ('0000000004', 'address', '');
INSERT INTO `zf_config` VALUES ('0000000005', '', '');

-- ----------------------------
-- Table structure for zf_file
-- ----------------------------
DROP TABLE IF EXISTS `zf_file`;
CREATE TABLE `zf_file` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `file_url` varchar(255) NOT NULL,
  `sina_img` varchar(255) DEFAULT NULL COMMENT 'sina图片链接',
  `create_time` int(11) DEFAULT NULL,
  `summary` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `sina_id` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zf_file
-- ----------------------------
INSERT INTO `zf_file` VALUES ('29', '', '', '', '0', '', '1', '007goYVsgy1fvfmhkrpf3j31kw0wf4lg');
INSERT INTO `zf_file` VALUES ('28', '', '', '', '0', '', '1', '007goYVsgy1fvfmhdhz8zj30ij0cx40f');
INSERT INTO `zf_file` VALUES ('27', '', '', '', '0', '', '1', '007goYVsgy1fvfmh90tjij30ku0dugs9');
INSERT INTO `zf_file` VALUES ('26', '', '', '', '0', '', '1', '007goYVsgy1fvfmh3hmq1j30k00b9wgl');
INSERT INTO `zf_file` VALUES ('23', '', '', 'http://ws3.sinaimg.cn/thumb150/007goYVsgy1fvflw4foa8j30dw0cm74g.jpg', '0', '', '1', '007goYVsgy1fvflw4foa8j30dw0cm74g');
INSERT INTO `zf_file` VALUES ('24', '', '', '', '0', '', '1', '007goYVsgy1fvfm0tg5gwj30dw0cm74g');
INSERT INTO `zf_file` VALUES ('25', '', '', '', '0', '', '1', '007goYVsgy1fvfmg51imlj31hc0xc1ku');
INSERT INTO `zf_file` VALUES ('30', '', '', '', '1538125873', '', '1', '007goYVsgy1fvpdbwcnv0j305k05kq2s');

-- ----------------------------
-- Table structure for zf_file_group
-- ----------------------------
DROP TABLE IF EXISTS `zf_file_group`;
CREATE TABLE `zf_file_group` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `create_time` int(11) DEFAULT NULL,
  `sort` varchar(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zf_file_group
-- ----------------------------
INSERT INTO `zf_file_group` VALUES ('4', '22', '1', '1540701624', '');
INSERT INTO `zf_file_group` VALUES ('3', '测试', '1', '1538125971', '11');

-- ----------------------------
-- Table structure for zf_guessbook
-- ----------------------------
DROP TABLE IF EXISTS `zf_guessbook`;
CREATE TABLE `zf_guessbook` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `summary` varchar(255) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `sort` tinyint(2) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zf_guessbook
-- ----------------------------
INSERT INTO `zf_guessbook` VALUES ('1', 'guessbookModel', '留言11', 'guessbookModel1', '', '0', '1540286359', '', '', '1');
INSERT INTO `zf_guessbook` VALUES ('2', '2', '留言2', '', '', '0', '1540287038', '', '', '1');
INSERT INTO `zf_guessbook` VALUES ('4', '', '22', '', '', '0', '1540702239', '', '', '1');

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zf_link
-- ----------------------------
INSERT INTO `zf_link` VALUES ('1', '王明昌博客', 'https://www.wangmingchang.com/', '1', '1', '1540285148', '', '0', '个人博客\r\n');
INSERT INTO `zf_link` VALUES ('4', '1122', '', '1', '0', '1540702097', '', '0', '');

-- ----------------------------
-- Table structure for zf_nav
-- ----------------------------
DROP TABLE IF EXISTS `zf_nav`;
CREATE TABLE `zf_nav` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `summary` varchar(255) DEFAULT NULL,
  `sort` tinyint(10) NOT NULL DEFAULT '0',
  `pid` int(11) NOT NULL DEFAULT '0',
  `menu` tinyint(1) NOT NULL DEFAULT '0',
  `ico` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zf_nav
-- ----------------------------

-- ----------------------------
-- Table structure for zf_post
-- ----------------------------
DROP TABLE IF EXISTS `zf_post`;
CREATE TABLE `zf_post` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(10) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `summary` varchar(255) DEFAULT NULL,
  `pic` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `sort` tinyint(5) DEFAULT '0',
  `content` varchar(1000) DEFAULT NULL,
  `append` varchar(255) DEFAULT NULL,
  `album` varchar(500) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `author` varchar(50) DEFAULT NULL,
  `hits` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zf_post
-- ----------------------------
INSERT INTO `zf_post` VALUES ('3', '6', '测试2', '描述11', '/public/data/upload/20181026\\507d4f308f535543d46f3cf5345ea7d9.jpg', '1', '1540198021', '1540532393', '0', '<p>详情111</p>', '11', '', '', null, '0');
INSERT INTO `zf_post` VALUES ('2', '6', '测试11', '描述11', '/public/data/upload/20181026\\ce3eb6f2aedadbe27c81c681b73b2724.jpg', '1', '1540196605', '1540540270', '0', '<p>详情111</p>', '', '', '/public/data/upload/20181026\\08d56f49d8fed17907b1381f0403440f.png', null, '0');
INSERT INTO `zf_post` VALUES ('17', '6', 'test', '', '/public/data/upload/20181026\\b19bf595419695143896ae2c9d466be6.jpg', '1', '1540532281', '0', '0', '', '', '', '', null, '0');
INSERT INTO `zf_post` VALUES ('19', '6', '2221212', '', '/public/data/upload/20181026\\c3c0821b0867563cbf3c8f33e45f7bdf.jpg', '1', '1540533627', '1540533642', '0', '', '', '', '/public/data/upload/20181026\\0277a9c03044abe300ba7b8a6e75996c.txt', null, '0');
INSERT INTO `zf_post` VALUES ('22', '6', '测试1', '1', '/public/data/upload/20181030\\78d7733c6d377946ef0acd6bc2f07310.jpg', '1', '1540869630', '1540870621', '2', '<p>我</p>', '1111', '/public/data/upload/20181030\\011fd81a6937ca69aa90e87a15d117c9.png,/public/data/upload/20181030\\49703addf0d681e745f5cac9a5a6b976.jpg,/public/data/upload/20181030\\101ce501b15e5af72f1836e0db9a52c4.jpg,/public/data/upload/20181030\\15ffedc6f90d9f0b4761770aa01be1c1.jpg', '/public/data/upload/20181030\\8bcb1274563d02373f5bee315b69ae39.txt', '22', '0');

-- ----------------------------
-- Table structure for zf_user
-- ----------------------------
DROP TABLE IF EXISTS `zf_user`;
CREATE TABLE `zf_user` (
  `id` tinyint(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `pwd` varchar(250) NOT NULL,
  `tel` varchar(12) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `age` tinyint(3) DEFAULT NULL,
  `sex` tinyint(1) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `user_group_id` tinyint(2) NOT NULL,
  `ip` varchar(50) DEFAULT NULL,
  `login_num` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) DEFAULT NULL,
  `sort` tinyint(5) NOT NULL DEFAULT '1',
  `pic` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zf_user
-- ----------------------------
INSERT INTO `zf_user` VALUES ('50', '121', '123456', 'admin', '', '0', '0', '', '1', '1', '', '0', '1540700467', '1', '');
INSERT INTO `zf_user` VALUES ('7', 'admin123', '123', '17621542500', '21', '0', '1', '', '1', '3', '', '0', '2018', '1', '');
INSERT INTO `zf_user` VALUES ('36', 'dsadsa11', '123', '17621542500', '', '0', '0', '', '1', '0', '', '0', '2018', '1', '');
INSERT INTO `zf_user` VALUES ('48', '2222', '123456', 'admin', '', '0', '0', '', '1', '1', '', '0', '1540699984', '1', '');
INSERT INTO `zf_user` VALUES ('45', '112233', '123456', '17621542555', '', '0', '0', '', '1', '1', '', '0', '0', '1', '');
INSERT INTO `zf_user` VALUES ('47', '11111', '123456', 'admin', '', '0', '0', '', '1', '1', '', '0', '1540699883', '1', '');

-- ----------------------------
-- Table structure for zf_user_group
-- ----------------------------
DROP TABLE IF EXISTS `zf_user_group`;
CREATE TABLE `zf_user_group` (
  `sort` tinyint(5) NOT NULL DEFAULT '1',
  `id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zf_user_group
-- ----------------------------
INSERT INTO `zf_user_group` VALUES ('0', '00000000001', '高级会员', '1', '2018');
INSERT INTO `zf_user_group` VALUES ('0', '00000000003', '普通会员', '1', '1538127552');
INSERT INTO `zf_user_group` VALUES ('0', '00000000005', '2211331', '1', '1540700207');
INSERT INTO `zf_user_group` VALUES ('0', '00000000006', '332', '1', '1540700319');
INSERT INTO `zf_user_group` VALUES ('0', '00000000007', '44', '1', '1540700344');
