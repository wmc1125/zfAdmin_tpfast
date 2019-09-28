-- -----------------------------
-- Think MySQL Data Transfer 
-- 
-- Host     : 127.0.0.1
-- Port     : 
-- Database : v1_fast_zf_90ckm
-- 
-- Part : #12
-- Date : 2019-09-27 16:59:23
-- -----------------------------

SET FOREIGN_KEY_CHECKS = 0;


-- -----------------------------
-- Table structure for `zf_admin_log`
-- -----------------------------
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
) ENGINE=MyISAM AUTO_INCREMENT=2064 DEFAULT CHARSET=utf8mb4 COMMENT='后台访问日志表';

