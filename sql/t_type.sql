/*
Navicat MySQL Data Transfer

Source Server         : test
Source Server Version : 50553
Source Host           : 127.0.0.1:3306
Source Database       : project

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-03-10 11:14:02
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `t_type`
-- ----------------------------
DROP TABLE IF EXISTS `t_type`;
CREATE TABLE `t_type` (
  `type_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '知识类型编号',
  `type_name` varchar(20) NOT NULL COMMENT '知识类型名称',
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_type
-- ----------------------------
INSERT INTO `t_type` VALUES ('1', '文章库');
INSERT INTO `t_type` VALUES ('2', '代码库');
INSERT INTO `t_type` VALUES ('3', '网址库');
INSERT INTO `t_type` VALUES ('4', '图片库');
INSERT INTO `t_type` VALUES ('5', '模板库');
