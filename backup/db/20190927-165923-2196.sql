-- -----------------------------
-- Think MySQL Data Transfer 
-- 
-- Host     : 127.0.0.1
-- Port     : 
-- Database : v1_fast_zf_90ckm
-- 
-- Part : #2196
-- Date : 2019-09-27 16:59:25
-- -----------------------------

SET FOREIGN_KEY_CHECKS = 0;


-- -----------------------------
-- Table structure for `zf_config`
-- -----------------------------
DROP TABLE IF EXISTS `zf_config`;
CREATE TABLE `zf_config` (
  `id` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `key` varchar(50) NOT NULL,
  `value` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='系统变量表';

