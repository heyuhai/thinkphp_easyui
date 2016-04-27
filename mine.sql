/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50624
Source Host           : localhost:3306
Source Database       : mine

Target Server Type    : MYSQL
Target Server Version : 50624
File Encoding         : 65001

Date: 2016-04-27 10:37:20
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for me_sysadmin
-- ----------------------------
DROP TABLE IF EXISTS `me_sysadmin`;
CREATE TABLE `me_sysadmin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `password` varchar(50) NOT NULL COMMENT '密码',
  `pid` int(11) NOT NULL COMMENT '所在用户组ID',
  `power` varchar(255) NOT NULL COMMENT '权限',
  `orderby` int(11) NOT NULL COMMENT '排序',
  `createtime` int(10) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='后台用户表';

-- ----------------------------
-- Records of me_sysadmin
-- ----------------------------
INSERT INTO `me_sysadmin` VALUES ('1', 'yagni', '42b3ae09d16e7b60e81e010c63851f92', '3', '1,2,3,4,5,6,8', '1', '0');
INSERT INTO `me_sysadmin` VALUES ('3', 'web', '42b3ae09d16e7b60e81e010c63851f92', '0', '1,5,6,8', '2', '0');

-- ----------------------------
-- Table structure for me_sysadmin_group
-- ----------------------------
DROP TABLE IF EXISTS `me_sysadmin_group`;
CREATE TABLE `me_sysadmin_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL COMMENT '用户组名',
  `power` varchar(255) NOT NULL COMMENT '用户组权限',
  `orderby` int(11) NOT NULL COMMENT '排序',
  `createtime` int(10) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='后台用户组表';

-- ----------------------------
-- Records of me_sysadmin_group
-- ----------------------------
INSERT INTO `me_sysadmin_group` VALUES ('3', '超级管理员', '1,2,3,4,5,6,8', '1', '1435907788');
INSERT INTO `me_sysadmin_group` VALUES ('4', '网站编辑', '6,8', '2', '1435907955');

-- ----------------------------
-- Table structure for me_syslog
-- ----------------------------
DROP TABLE IF EXISTS `me_syslog`;
CREATE TABLE `me_syslog` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL COMMENT '用户ID',
  `uname` varchar(50) NOT NULL COMMENT '用户名',
  `content` text NOT NULL COMMENT '操作内容',
  `createtime` int(10) NOT NULL COMMENT '操作时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系统日志表';

-- ----------------------------
-- Records of me_syslog
-- ----------------------------

-- ----------------------------
-- Table structure for me_sysmodule
-- ----------------------------
DROP TABLE IF EXISTS `me_sysmodule`;
CREATE TABLE `me_sysmodule` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL COMMENT '模块名',
  `pid` int(11) unsigned NOT NULL COMMENT '父级模块ID',
  `module` varchar(100) NOT NULL COMMENT '模块module',
  `action` varchar(100) NOT NULL COMMENT '方法',
  `param` varchar(100) NOT NULL COMMENT '额外url',
  `orderby` int(11) NOT NULL COMMENT '排序',
  `createtime` int(10) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='模块表';

-- ----------------------------
-- Records of me_sysmodule
-- ----------------------------
INSERT INTO `me_sysmodule` VALUES ('1', '系统管理', '0', 'Sysadmin', 'sysmoduleList', '', '1', '1435817902');
INSERT INTO `me_sysmodule` VALUES ('2', '模块管理', '1', 'Sysadmin', 'sysmoduleList', '', '2', '1435818703');
INSERT INTO `me_sysmodule` VALUES ('3', '管理员管理', '1', 'Sysadmin', 'sysadminList', '', '3', '1435818713');
INSERT INTO `me_sysmodule` VALUES ('4', '角色管理', '1', 'Sysadmin', 'sysadminGroupList', '', '4', '1435818728');
INSERT INTO `me_sysmodule` VALUES ('5', '系统日志', '1', 'Sysadmin', 'syslogList', '', '5', '1435818740');
INSERT INTO `me_sysmodule` VALUES ('6', '文章管理', '0', 'News', 'newsList', '', '6', '1435818795');
INSERT INTO `me_sysmodule` VALUES ('8', '新闻列表', '6', 'News', 'newsList', '', '7', '1435818813');
INSERT INTO `me_sysmodule` VALUES ('24', '模块管理操作', '2', 'Sysadmin', 'sysmoduleModify', '', '8', '1454861453');
INSERT INTO `me_sysmodule` VALUES ('25', '模块管理列表', '2', 'Sysadmin', 'sysmoduleJsonData', '', '7', '1454861735');
INSERT INTO `me_sysmodule` VALUES ('26', '模块管理删除', '2', 'Sysadmin', 'sysmoduleDel', '', '9', '1454861783');
