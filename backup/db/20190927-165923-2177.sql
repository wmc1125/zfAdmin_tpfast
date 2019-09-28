-- -----------------------------
-- Think MySQL Data Transfer 
-- 
-- Host     : 127.0.0.1
-- Port     : 
-- Database : v1_fast_zf_90ckm
-- 
-- Part : #2177
-- Date : 2019-09-27 16:59:25
-- -----------------------------

SET FOREIGN_KEY_CHECKS = 0;


-- -----------------------------
-- Table structure for `zf_category`
-- -----------------------------
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
  `file` varchar(255) NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=441 DEFAULT CHARSET=utf8 COMMENT='分类表';

