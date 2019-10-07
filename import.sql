-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2019-10-03 21:45:57
-- 服务器版本： 5.5.62-log
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `v1_fast_zf_90ckm`
--

-- --------------------------------------------------------

--
-- 表的结构 `zf_admin`
--

CREATE TABLE IF NOT EXISTS `zf_admin` (
  `id` tinyint(11) unsigned NOT NULL,
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
  `google_secret` varchar(255) DEFAULT NULL,
  `google_is` tinyint(255) NOT NULL DEFAULT '0',
  `pic` varchar(255) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='管理员表';

--
-- 转存表中的数据 `zf_admin`
--

INSERT INTO `zf_admin` (`id`, `gid`, `name`, `pwd`, `tel`, `email`, `age`, `sex`, `address`, `status`, `admin_group_id`, `ip`, `login_num`, `create_time`, `sort`, `google_secret`, `google_is`, `pic`) VALUES
(1, 3, 'admin', '96e79218965eb72c92a549dd5a330112', '17621542500', '', 0, 1, '23', 1, 0, '', 0, 2018, 0, 'Y67N442CU2G4CIAG', 1, 'http://demo.zf.90ckm.com/upload/file/water/20190910112514_6109.png'),
(5, 1, '测试', '6512bd43d9caa6e02c990b0a82652dca', '', '', 0, 0, '', 1, 0, '', 0, 1538125373, 1, '67CDCMFJCQALDVPK', 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `zf_admin_group`
--

CREATE TABLE IF NOT EXISTS `zf_admin_group` (
  `id` int(11) unsigned zerofill NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `create_time` int(11) DEFAULT NULL,
  `sort` tinyint(5) NOT NULL DEFAULT '1',
  `role` varchar(250) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='管理员分组表';

--
-- 转存表中的数据 `zf_admin_group`
--

INSERT INTO `zf_admin_group` (`id`, `name`, `status`, `create_time`, `sort`, `role`) VALUES
(00000000001, '普通管理员', 0, 2018, 1, '1,4,10,19,8,9,36,95,15,14,32,24,37,68,40,41,45,46,50,88,54,55,60,64,70,77,79,80,82,83'),
(00000000002, '网站编辑', 0, 2018, 1, '5,6,7,8,9'),
(00000000003, '超级管理员', 1, 2018, 1, '1,2,3,4,10,19,84,8,9,36,15,14,32,24,25,27,37,38,68,40,41,46,50,54,55,60,64,70,71,72,77,78,79,80,82,83'),
(00000000007, '监察员', 1, 1538126893, 0, '0');

-- --------------------------------------------------------

--
-- 表的结构 `zf_admin_log`
--

CREATE TABLE IF NOT EXISTS `zf_admin_log` (
  `id` int(11) unsigned NOT NULL,
  `action` varchar(255) NOT NULL,
  `ctime` int(11) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `uid` int(11) NOT NULL,
  `post` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM AUTO_INCREMENT=2178 DEFAULT CHARSET=utf8mb4 COMMENT='后台访问日志表';

--
-- 转存表中的数据 `zf_admin_log`
--

INSERT INTO `zf_admin_log` (`id`, `action`, `ctime`, `ip`, `uid`, `post`, `status`) VALUES
(13, 'admin/application/yhq', 1565920414, '222.69.227.221', 1, '[]', 0),
(14, 'admin/common/del_post', 1565920419, '222.69.227.221', 1, '{"id":"73","db":"yhq"}', 0),
(15, 'admin/application/yhq', 1565920420, '222.69.227.221', 1, '[]', 0),
(2173, 'admin/index/index', 1569714812, '112.65.62.203', 1, '[]', 1),
(2174, 'admin/index/welcome', 1569714812, '112.65.62.203', 1, '[]', 1),
(2175, 'admin/index/favicon.ico', 1569714812, '112.65.62.203', 1, '[]', 1),
(2176, 'admin/index/index', 1569715301, '112.65.62.203', 1, '[]', 1),
(2177, 'admin/index/welcome', 1569715301, '112.65.62.203', 1, '[]', 1);

-- --------------------------------------------------------

--
-- 表的结构 `zf_admin_role`
--

CREATE TABLE IF NOT EXISTS `zf_admin_role` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `value` varchar(50) DEFAULT NULL,
  `check` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `summary` varchar(255) DEFAULT NULL,
  `sort` tinyint(10) NOT NULL DEFAULT '0',
  `pid` int(11) NOT NULL DEFAULT '0',
  `control` varchar(50) NOT NULL,
  `act` varchar(50) NOT NULL,
  `menu` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM AUTO_INCREMENT=116 DEFAULT CHARSET=utf8 COMMENT='管理员权限表';

--
-- 转存表中的数据 `zf_admin_role`
--

INSERT INTO `zf_admin_role` (`id`, `name`, `value`, `check`, `status`, `summary`, `sort`, `pid`, `control`, `act`, `menu`) VALUES
(1, '网站管理', 'Config/', 1, 1, '', 99, 0, 'Config', '', 1),
(2, '网站设置', 'Config/index', 1, 1, '', 0, 1, 'Config', 'index', 1),
(3, '邮件服务', 'Config/email', 1, 1, '', 4, 1, 'Config', 'email', 1),
(4, '管理员列表', 'Config/admin_index', 1, 1, '', 1, 1, 'Config', 'admin_index', 1),
(5, '添加管理员', 'Config/admin_add', 1, 1, '', 0, 4, 'Config', 'admin_add', 0),
(6, '编辑管理员', 'Config/admin_edit', 1, 1, '', 0, 4, 'Config', 'admin_edit', 0),
(7, '删除管理员', 'Config/admin_del', 1, 1, '', 0, 4, 'Config', 'admin_del', 0),
(8, '后台首页', 'Index/index', 1, 1, '', 0, 0, 'Index', 'index', 0),
(9, '欢迎页', 'Index/welcome', 1, 1, '', 0, 8, 'Index', 'welcome', 1),
(10, '权限列表', 'Config/admin_role', 1, 1, '', 3, 1, 'Config', 'admin_role', 1),
(11, '增加权限', 'Config/admin_role_add', 1, 1, '', 0, 10, 'Config', 'admin_role_add', 0),
(12, '编辑权限', 'Config/admin_role_edit', 1, 1, '', 0, 10, 'Config', 'admin_role_edit', 0),
(13, '删除权限', 'Config/admin_role_del', 1, 1, '', 0, 10, 'Config', 'admin_role_del', 0),
(14, '用户列表', 'User/index', 1, 1, '', 0, 15, 'User', 'index', 1),
(15, '用户管理', 'User/', 1, 1, '', 5, 0, 'User', '', 1),
(16, '增加用户', 'User/add', 1, 1, '', 0, 14, 'User', 'add', 0),
(17, '编辑用户', 'User/edit', 1, 1, '', 0, 14, 'User', 'edit', 0),
(18, '获取方法', 'Config/get_action', 1, 1, '', 0, 10, 'Config', 'get_action', 0),
(19, '管理员分组', 'Config/admin_group', 1, 1, '', 2, 1, 'Config', 'admin_group', 1),
(20, '管理员分组-添加', 'Config/admin_group_add', 1, 1, '', 0, 19, 'Config', 'admin_group_add', 0),
(21, '管理员分组-修改', 'Config/admin_group_edit', 1, 1, '', 0, 19, 'Config', 'admin_group_edit', 0),
(22, '管理员分组-删除', 'Config/admin_group_del', 1, 1, '', 0, 19, 'Config', 'admin_group_del', 0),
(23, '管理员分组-权限', 'Config/admin_group_role', 1, 1, '', 0, 19, 'Config', 'admin_group_role', 0),
(24, '素材管理', 'Upload/', 1, 1, '', 6, 0, 'Upload', '', 0),
(25, '素材列表', 'Upload/index', 1, 1, '', 0, 24, 'Upload', 'index', 1),
(26, '添加图片', 'Upload/img_add', 1, 1, '', 0, 25, 'Upload', 'img_add', 0),
(27, '素材分类', 'Upload/group', 1, 1, '', 0, 24, 'Upload', 'group', 1),
(28, '素材分类-添加', 'Upload/group_add', 1, 1, '', 0, 27, 'Upload', 'group_add', 0),
(29, '素材分类-修改', 'Upload/group_edit', 1, 1, '', 0, 27, 'Upload', 'group_edit', 0),
(30, '素材分类-删除', 'Upload/group_del', 1, 1, '', 0, 27, 'Upload', 'group_del', 0),
(31, '删除用户', 'User/del', 1, 1, '', 0, 14, 'User', 'del', 0),
(32, '用户分组', 'User/group', 1, 1, '', 0, 15, 'User', 'group', 1),
(33, '增加分组', 'User/group_add', 1, 1, '', 0, 32, 'User', 'group_add', 0),
(34, '修改分组', 'User/group_edit', 1, 1, '', 0, 32, 'User', 'group_edit', 0),
(35, '删除分组', 'User/group_del', 1, 1, '', 0, 32, 'User', 'group_del', 0),
(36, '修改密码', 'User/pwd_edit', 1, 1, '', 0, 8, 'User', 'pwd_edit', 0),
(37, '数据库管理', 'Mysql/', 1, 1, '', 9, 0, 'Mysql', '', 1),
(40, '内容管理', 'Category/', 1, 1, '', 1, 0, 'Category', '', 1),
(41, '栏目列表', 'Category/index', 1, 1, '', 0, 40, 'Category', 'index', 1),
(42, '新增栏目', 'Category/category_add', 1, 1, '', 0, 41, 'Category', 'category_add', 0),
(43, '修改栏目', 'Category/category_edit', 1, 1, '', 0, 41, 'Category', 'category_edit', 0),
(44, '删除栏目', 'Category/category_del', 1, 1, '', 0, 41, 'Category', 'category_del', 0),
(45, '内容列表', 'Category/post_list', 1, 1, '', 0, 41, 'Category', 'post_list', 0),
(46, '内容模型', 'Category/category_model', 1, 1, '', 0, 40, 'Category', 'category_model', 1),
(47, '新增模型', 'Category/category_model_add', 1, 1, '', 0, 46, 'Category', 'category_model_add', 0),
(48, '编辑模型', 'Category/category_model_edit', 1, 1, '', 0, 46, 'Category', 'category_model_edit', 0),
(49, '删除模型', 'Category/category_model_del', 1, 1, '', 0, 46, 'Category', 'category_model_del', 0),
(50, '内容列表', 'Category/post_all_list', 1, 1, '', 0, 40, 'Category', 'post_all_list', 1),
(51, '内容添加', 'Category/post_add', 1, 1, '', 0, 50, 'Category', 'post_add', 0),
(52, '内容编辑', 'Category/post_edit', 1, 1, '', 0, 50, 'Category', 'post_edit', 0),
(53, '内容删除', 'Category/post_del', 1, 1, '', 0, 50, 'Category', 'post_del', 0),
(54, '其他管理', 'Rests/', 1, 1, '', 5, 0, 'Rests', '', 1),
(55, '广告管理', 'Rests/advert', 1, 1, '', 0, 54, 'Rests', 'advert', 1),
(57, '增加广告', 'Rests/advert_add', 1, 1, '', 0, 55, 'Rests', 'advert_add', 0),
(58, '修改广告', 'Rests/advert_edit', 1, 1, '', 0, 55, 'Rests', 'advert_edit', 0),
(59, '删除广告', 'Rests/advert_del', 1, 1, '', 0, 55, 'Rests', 'advert_del', 0),
(60, '超链管理', 'Rests/link', 1, 1, '', 0, 54, 'Rests', 'link', 1),
(61, '增加超链', 'Rests/link_add', 1, 1, '', 0, 60, 'Rests', 'link_add', 0),
(62, '编辑超链', 'Rests/link_edit', 1, 1, '', 0, 60, 'Rests', 'link_edit', 0),
(63, '删除超链', 'Rests/link_del', 1, 1, '', 0, 60, 'Rests', 'link_del', 0),
(64, '留言管理', 'Rests/guessbook', 1, 1, '', 0, 54, 'Rests', 'guessbook', 1),
(65, '添加留言', 'Rests/guessbook_add', 1, 1, '', 0, 64, 'Rests', 'guessbook_add', 0),
(66, '编辑留言', 'Rests/guessbook_edit', 1, 1, '', 0, 64, 'Rests', 'guessbook_edit', 0),
(67, '删除留言', 'Rests/guessbook_del', 1, 1, '', 0, 64, 'Rests', 'guessbook_del', 0),
(68, '数据表结构', 'Mysql/index', 1, 1, '', 0, 37, 'Mysql', 'index', 1),
(70, '公共方法', 'Common/', 1, 1, '', 0, 0, 'Common', '', 0),
(71, '上传方法', 'Common/upload_one', 1, 1, '', 0, 70, 'Common', 'upload_one', 1),
(72, '状态转换', 'Common/is_switch', 1, 1, '', 0, 70, 'Common', 'is_switch', 1),
(73, '获取相似的标题', 'Category/title_get_list', 1, 1, '', 0, 10, 'Category', 'title_get_list', 0),
(74, '导出用户', 'User/export', 1, 1, '', 0, 14, 'User', 'export', 0),
(77, '小程序', 'Xcx/', 1, 1, '', 10, 96, 'Xcx', '', 1),
(78, '基本信息', 'Xcx/setting', 1, 1, '', 0, 77, 'Xcx', 'setting', 1),
(79, '模版管理', 'Template/', 1, 1, '', 2, 0, 'Template', '', 1),
(80, '模板列表', 'Template/tpl_list', 1, 1, '', 0, 79, 'Template', 'tpl_list', 1),
(81, '修改模板', 'Template/tpl_edit', 1, 1, '', 0, 80, 'Template', 'tpl_edit', 0),
(83, '采集列表', 'Caiji/list', 1, 1, '', 0, 111, 'Caiji', 'list', 1),
(84, '图片设置', 'Config/img_config', 1, 1, '', 0, 1, 'Config', 'img_config', 1),
(85, '增加采集', 'Caiji/add', 1, 1, '', 0, 83, 'Caiji', 'add', 0),
(86, '采集文章列表', 'Caiji/cj_list', 1, 1, '', 0, 83, 'Caiji', 'cj_list', 0),
(106, '页面管理', 'Xcx/page', 1, 1, '', 0, 77, 'Xcx', 'page', 1),
(87, '内容导入', 'Category/import', 1, 1, '', 0, 50, 'Category', 'import', 0),
(88, '内容页获取标题列表', 'Category/search_post', 1, 1, '', 0, 50, 'Category', 'search_post', 0),
(89, '转换菜单', 'Common/is_menu', 1, 1, '', 0, 70, 'Common', 'is_menu', 1),
(90, '删除内容', 'Common/del_post', 1, 1, '', 0, 70, 'Common', 'del_post', 1),
(91, '批量删除', 'Common/more_del', 1, 1, '', 0, 70, 'Common', 'more_del', 1),
(92, '修改字段的值', 'Common/value_edit', 1, 1, '', 0, 70, 'Common', 'value_edit', 1),
(93, '测试邮箱', 'Config/test_email', 1, 1, '', 0, 3, 'Config', 'test_email', 0),
(95, '修改个人信息', 'User/admin_info', 1, 1, '', 0, 8, 'User', 'admin_info', 1),
(96, '应用中心', 'Application/', 1, 1, '', 10, 0, 'Application', '', 0),
(97, '优惠券列表', 'Application/yhq', 1, 1, '', 0, 110, 'Application', 'yhq', 1),
(98, '添加优惠券', 'Application/yhq_add', 1, 1, '', 0, 97, 'Application', 'yhq_add', 0),
(99, '编辑优惠券', 'Application/yhq_edit', 1, 1, '', 0, 97, 'Application', 'yhq_edit', 0),
(100, '商品管理', 'Products/', 1, 1, '', 4, 0, 'Products', '', 0),
(101, '订单列表', 'Products/order', 1, 1, '', 3, 100, 'Products', 'order', 1),
(102, '编辑订单', 'Products/order_edit', 1, 1, '', 0, 101, 'Products', 'order_edit', 0),
(103, '订单详情', 'Products/order_detail', 1, 1, '', 0, 101, 'Products', 'order_detail', 0),
(104, '商品列表', 'Products/product', 1, 1, '', 1, 100, 'Products', 'product', 1),
(105, '商品分类', 'Products/cate', 1, 1, '', 2, 100, 'Products', 'cate', 1),
(107, '页面设计', 'Xcx/page_edit', 1, 1, '', 0, 77, 'Xcx', 'page_edit', 1),
(108, '操作日志', 'Config/action_log', 1, 1, '', 15, 1, 'Config', 'action_log', 1),
(109, '第三方配置', 'Config/other_app', 1, 1, '', 10, 1, 'Config', 'other_app', 0),
(110, '商城', 'Application/', 1, 1, '', 0, 96, 'Application', '', 1),
(111, '内容', 'Application/', 1, 1, '', 0, 96, 'Application', '', 1),
(112, '秒杀列表', 'Application/seckill', 1, 1, '', 0, 110, 'Application', 'seckill', 1),
(113, '拼团列表', 'Application/group_buy', 1, 1, '', 0, 110, 'Application', 'group_buy', 1),
(115, '备份列表', 'Mysql/index2', 1, 1, '', 0, 37, 'Mysql', 'index2', 1);

-- --------------------------------------------------------

--
-- 表的结构 `zf_advert`
--

CREATE TABLE IF NOT EXISTS `zf_advert` (
  `id` int(11) unsigned NOT NULL,
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
  `status` varchar(255) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='广告表';

--
-- 转存表中的数据 `zf_advert`
--

INSERT INTO `zf_advert` (`id`, `name`, `url`, `pid`, `create_time`, `summary`, `content`, `target`, `cname`, `file`, `pic`, `sort`, `tag`, `end_time`, `status`) VALUES
(11, '1', 'https://timgsa.baidu.com', 10, 0, 's', '', '', '', '', 'https://demo.zf.90ckm.com/upload/file/20190724/7b5abb5ec820ebf22ec1d5974571ff4c.jpg', 0, '', 0, '1'),
(10, '首页banner', '', 0, 0, '', '', '', '', '', '', 0, 'banner', 0, '0');

-- --------------------------------------------------------

--
-- 表的结构 `zf_category`
--

CREATE TABLE IF NOT EXISTS `zf_category` (
  `cid` int(10) unsigned NOT NULL,
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
  `content` text,
  `tpl_category` varchar(50) DEFAULT NULL,
  `tpl_post` varchar(50) DEFAULT NULL,
  `page` int(255) NOT NULL DEFAULT '10',
  `sname` varchar(100) DEFAULT NULL,
  `keyword` varchar(255) DEFAULT NULL,
  `target` varchar(20) DEFAULT NULL,
  `append` varchar(255) DEFAULT NULL,
  `file` varchar(255) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=441 DEFAULT CHARSET=utf8 COMMENT='分类表';

--
-- 转存表中的数据 `zf_category`
--

INSERT INTO `zf_category` (`cid`, `pid`, `mid`, `name`, `ename`, `cname`, `summary`, `pic`, `icon`, `url`, `status`, `sort`, `menu`, `ctime`, `utime`, `content`, `tpl_category`, `tpl_post`, `page`, `sname`, `keyword`, `target`, `append`, `file`) VALUES
(426, 0, 1, '关于我', '', '', '', '', '', '', 1, 9, 1, 1563961521, 0, '<p>这是一个测试站点</p>', 'tpl_page', '', 10, '', '', '', '', ''),
(425, 0, 4, '默认分类', '', '', '', '', '', '', 1, 7, 1, 1563957347, 0, '', 'tpl_list', 'tpl_content', 10, '', '', '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `zf_category_model`
--

CREATE TABLE IF NOT EXISTS `zf_category_model` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(25) NOT NULL,
  `model` varchar(25) NOT NULL,
  `sort` tinyint(255) NOT NULL DEFAULT '0',
  `status` tinyint(5) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='分类模型表';

--
-- 转存表中的数据 `zf_category_model`
--

INSERT INTO `zf_category_model` (`id`, `name`, `model`, `sort`, `status`) VALUES
(1, '单页模型', 'simple', 1, 1),
(2, '新闻模型', 'news', 2, 1),
(4, '内容模型', 'article', 3, 1),
(13, '图片模型', 'pic', 10, 1),
(12, '关联模型', 'relevan', 9, 1);

-- --------------------------------------------------------

--
-- 表的结构 `zf_config`
--

CREATE TABLE IF NOT EXISTS `zf_config` (
  `id` int(10) unsigned zerofill NOT NULL,
  `key` varchar(50) NOT NULL,
  `value` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='系统变量表';

--
-- 转存表中的数据 `zf_config`
--

INSERT INTO `zf_config` (`id`, `key`, `value`, `status`) VALUES
(0000000001, 'zf_tpl_suffix', 'a1', 1);

-- --------------------------------------------------------

--
-- 表的结构 `zf_guessbook`
--

CREATE TABLE IF NOT EXISTS `zf_guessbook` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `summary` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `sort` tinyint(2) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `tel` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='留言表';

--
-- 转存表中的数据 `zf_guessbook`
--

INSERT INTO `zf_guessbook` (`id`, `name`, `title`, `summary`, `content`, `sort`, `create_time`, `tel`, `email`, `status`) VALUES
(5, 'sa', '12', '121', 'sad', 0, 1564022817, '', '11@qq.com', 0);

-- --------------------------------------------------------

--
-- 表的结构 `zf_link`
--

CREATE TABLE IF NOT EXISTS `zf_link` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `target` varchar(255) DEFAULT NULL,
  `sort` int(5) DEFAULT '0',
  `summary` varchar(255) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='超链表';

--
-- 转存表中的数据 `zf_link`
--

INSERT INTO `zf_link` (`id`, `name`, `url`, `type`, `status`, `create_time`, `target`, `sort`, `summary`) VALUES
(1, '王明昌博客', 'https://www.wangmingchang.com/', '1', '0', 1540285148, '', 0, '个人博客\r\n');

-- --------------------------------------------------------

--
-- 表的结构 `zf_post`
--

CREATE TABLE IF NOT EXISTS `zf_post` (
  `id` int(11) unsigned NOT NULL,
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
  `ini_hits` int(5) NOT NULL DEFAULT '0' COMMENT '初始访问量    总访问量=初始访问量+实际访问量'
) ENGINE=MyISAM AUTO_INCREMENT=249 DEFAULT CHARSET=utf8 COMMENT='内容表';

--
-- 转存表中的数据 `zf_post`
--

INSERT INTO `zf_post` (`id`, `cid`, `title`, `summary`, `pic`, `status`, `ctime`, `utime`, `sort`, `content`, `append`, `file`, `album`, `price`, `price_new`, `tkl`, `hits`, `url`, `author`, `openid`, `cj_id`, `relevan_id`, `is_product`, `p_cate`, `sku_type`, `ini_hits`) VALUES
(248, 425, 'hello.world!', '', 'http://zf-demo-test.oss-cn-beijing.aliyuncs.com/demo_zf_test/upload/simple/image/20190927/1569579364_moren_upload.png', 1, 1569579211, NULL, 0, '<p>这是第一篇文章</p>', '', '', '', '0.00', '0.00', '0', 11, '', '匿名', '', 0, 0, 0, NULL, 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `zf_user`
--

CREATE TABLE IF NOT EXISTS `zf_user` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(25) NOT NULL,
  `pwd` varchar(250) NOT NULL,
  `tel` varchar(12) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `age` tinyint(3) DEFAULT NULL,
  `sex` tinyint(1) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `gid` tinyint(2) NOT NULL,
  `ip` varchar(50) DEFAULT NULL,
  `login_num` int(11) NOT NULL DEFAULT '0',
  `ctime` int(11) DEFAULT NULL,
  `sort` tinyint(5) NOT NULL DEFAULT '1',
  `pic` varchar(255) DEFAULT NULL,
  `nickName` varchar(50) NOT NULL,
  `avatarUrl` varchar(255) NOT NULL,
  `openid` varchar(50) NOT NULL,
  `api_key` varchar(255) NOT NULL,
  `login_act_code` varchar(50) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=413 DEFAULT CHARSET=utf8 COMMENT='用户表';

--
-- 转存表中的数据 `zf_user`
--

INSERT INTO `zf_user` (`id`, `name`, `pwd`, `tel`, `email`, `age`, `sex`, `address`, `status`, `gid`, `ip`, `login_num`, `ctime`, `sort`, `pic`, `nickName`, `avatarUrl`, `openid`, `api_key`, `login_act_code`) VALUES
(387, 'Eric·枫1', '96e79218965eb72c92a549dd5a330112', '17621555555', '', 0, 1, '', 1, 1, '101.85.236.240', 0, 1559742074, 1, 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTLg2vgKPQCKeia72M77zDH9nEjdZjjUf1A9W3ciaicBCaDaoC7Wraur2Ll1wf0SMUa5TKgUy3zQyH2EQ/132', 'Eric·枫', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTLg2vgKPQCKeia72M77zDH9nEjdZjjUf1A9W3ciaicBCaDaoC7Wraur2Ll1wf0SMUa5TKgUy3zQyH2EQ/132', 'opXQA0ZqyQgvqGSupBkXqNsgMg_E', '', ''),
(397, '411', '111111', 'admin', '', 0, 0, '', 1, 1, '', 0, 0, 1, '', '', '', '', '', ''),
(403, '1011', '111111', 'admin', '', 0, 0, '', 1, 1, '', 0, 0, 1, '', '', '', '', '', ''),
(405, 'sdad1', '96e79218965eb72c92a549dd5a330112', 'admin', '', 0, 0, '', 1, 1, '', 0, 0, 1, '', '', '', '', '', ''),
(412, '222', 'e10adc3949ba59abbe56e057f20f883e', 'admin', '', 0, 0, '', 1, 1, '', 0, 1569478144, 1, '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `zf_user_group`
--

CREATE TABLE IF NOT EXISTS `zf_user_group` (
  `sort` tinyint(5) NOT NULL DEFAULT '1',
  `id` int(11) unsigned zerofill NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `ctime` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='用户分组表';

--
-- 转存表中的数据 `zf_user_group`
--

INSERT INTO `zf_user_group` (`sort`, `id`, `name`, `status`, `ctime`) VALUES
(0, 00000000001, '高级会员', 1, 2018),
(0, 00000000003, '普通会员', 1, 1538127552);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `zf_admin`
--
ALTER TABLE `zf_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zf_admin_group`
--
ALTER TABLE `zf_admin_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zf_admin_log`
--
ALTER TABLE `zf_admin_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zf_admin_role`
--
ALTER TABLE `zf_admin_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zf_advert`
--
ALTER TABLE `zf_advert`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zf_category`
--
ALTER TABLE `zf_category`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `zf_category_model`
--
ALTER TABLE `zf_category_model`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zf_config`
--
ALTER TABLE `zf_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zf_guessbook`
--
ALTER TABLE `zf_guessbook`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zf_link`
--
ALTER TABLE `zf_link`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zf_post`
--
ALTER TABLE `zf_post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zf_user`
--
ALTER TABLE `zf_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zf_user_group`
--
ALTER TABLE `zf_user_group`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `zf_admin`
--
ALTER TABLE `zf_admin`
  MODIFY `id` tinyint(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `zf_admin_group`
--
ALTER TABLE `zf_admin_group`
  MODIFY `id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `zf_admin_log`
--
ALTER TABLE `zf_admin_log`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2178;
--
-- AUTO_INCREMENT for table `zf_admin_role`
--
ALTER TABLE `zf_admin_role`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=116;
--
-- AUTO_INCREMENT for table `zf_advert`
--
ALTER TABLE `zf_advert`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `zf_category`
--
ALTER TABLE `zf_category`
  MODIFY `cid` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=441;
--
-- AUTO_INCREMENT for table `zf_category_model`
--
ALTER TABLE `zf_category_model`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `zf_config`
--
ALTER TABLE `zf_config`
  MODIFY `id` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `zf_guessbook`
--
ALTER TABLE `zf_guessbook`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `zf_link`
--
ALTER TABLE `zf_link`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `zf_post`
--
ALTER TABLE `zf_post`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=249;
--
-- AUTO_INCREMENT for table `zf_user`
--
ALTER TABLE `zf_user`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=413;
--
-- AUTO_INCREMENT for table `zf_user_group`
--
ALTER TABLE `zf_user_group`
  MODIFY `id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
