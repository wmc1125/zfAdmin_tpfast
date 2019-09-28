-- -----------------------------
-- Think MySQL Data Transfer 
-- 
-- Host     : 127.0.0.1
-- Port     : 
-- Database : v1_fast_zf_90ckm
-- 
-- Part : #2
-- Date : 2019-09-27 16:59:23
-- -----------------------------

SET FOREIGN_KEY_CHECKS = 0;


-- -----------------------------
-- Table structure for `zf_admin`
-- -----------------------------
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
  `google_secret` varchar(255) DEFAULT NULL,
  `google_is` tinyint(255) NOT NULL DEFAULT '0',
  `pic` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='管理员表';

