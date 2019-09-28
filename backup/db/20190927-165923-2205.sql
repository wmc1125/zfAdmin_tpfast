-- -----------------------------
-- Think MySQL Data Transfer 
-- 
-- Host     : 127.0.0.1
-- Port     : 
-- Database : v1_fast_zf_90ckm
-- 
-- Part : #2205
-- Date : 2019-09-27 16:59:25
-- -----------------------------

SET FOREIGN_KEY_CHECKS = 0;


-- -----------------------------
-- Table structure for `zf_post`
-- -----------------------------
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=248 DEFAULT CHARSET=utf8 COMMENT='内容表';

