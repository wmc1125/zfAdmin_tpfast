-- -----------------------------
-- Think MySQL Data Transfer 
-- 
-- Host     : 127.0.0.1
-- Port     : 
-- Database : v1_fast_zf_90ckm
-- 
-- Part : #2173
-- Date : 2019-09-27 16:59:25
-- -----------------------------

SET FOREIGN_KEY_CHECKS = 0;


-- -----------------------------
-- Table structure for `zf_advert`
-- -----------------------------
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
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='广告表';

