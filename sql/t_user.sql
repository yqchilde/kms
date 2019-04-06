/*
Navicat MySQL Data Transfer

Source Server         : test
Source Server Version : 50553
Source Host           : 127.0.0.1:3306
Source Database       : project

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-03-10 11:13:22
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `t_user`
-- ----------------------------
DROP TABLE IF EXISTS `t_user`;
CREATE TABLE `t_user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户编号',
  `username` varchar(20) NOT NULL COMMENT '用户账号',
  `password` varchar(32) NOT NULL COMMENT '用户密码',
  `user_realname` varchar(20) DEFAULT NULL COMMENT '用户姓名',
  `user_email` varchar(20) DEFAULT NULL COMMENT '用户邮箱',
  `state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '用户删除标记（0表示删除，1表示未删除）',
  `role_id` int(10) unsigned DEFAULT NULL COMMENT '权限编号',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`) USING BTREE,
  KEY `role_id` (`role_id`) USING BTREE,
  CONSTRAINT `t_user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `t_role` (`role_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10016 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_user
-- ----------------------------
INSERT INTO `t_user` VALUES ('10004', 'yqchilde', '4297f44b13955235245b2497399d7a93', '于波', 'y@ini8.cn', '1', '1');
INSERT INTO `t_user` VALUES ('10005', 'qweqweqwe', 'eqrqrqwrq', '三大爷', '666@vn', '0', '1');
INSERT INTO `t_user` VALUES ('10006', '时光飞逝的风格', 'sfsdfsdfsdfs', '二大爷的', '12132131@qq.com', '0', '2');
INSERT INTO `t_user` VALUES ('10009', 'qazqazwerwerwerw', 'e10adc3949ba59abbe56e057f20f883e', 'sdfsf', 'y@ini8.cna', '0', '2');
INSERT INTO `t_user` VALUES ('10010', 'fsdfsfgs', 'dfgdfgsdafg', 'dfgagdfag', 'dgdfagdfg', '0', '2');
INSERT INTO `t_user` VALUES ('10011', 'gagsagrgdag', 'dgfadgdafgad', 'gdgadgdafgd', 'dgdfagdfa', '0', '2');
INSERT INTO `t_user` VALUES ('10012', 'sfdgadfgdfgda', 'dfgdfagdfa', 'dfgdfagdafg', 'dgagdaga', '0', '2');
INSERT INTO `t_user` VALUES ('10013', 'test404', '4297f44b13955235245b2497399d7a93', '测试账号', 'y@ini8.cnd', '1', '2');
INSERT INTO `t_user` VALUES ('10014', 'test111', '4297f44b13955235245b2497399d7a93', '于波', 'y@ini8.cn', '1', '2');
INSERT INTO `t_user` VALUES ('10015', 'test101', '123123', null, null, '1', '1');
