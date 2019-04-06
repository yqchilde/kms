/*
Navicat MySQL Data Transfer

Source Server         : test
Source Server Version : 50553
Source Host           : 127.0.0.1:3306
Source Database       : project

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-03-10 11:14:29
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `t_role`
-- ----------------------------
DROP TABLE IF EXISTS `t_role`;
CREATE TABLE `t_role` (
  `role_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '权限编号',
  `role_name` varchar(10) NOT NULL COMMENT '权限名称',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_role
-- ----------------------------
INSERT INTO `t_role` VALUES ('1', '超级管理员');
INSERT INTO `t_role` VALUES ('2', '普通用户');
