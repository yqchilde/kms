/*
Navicat MySQL Data Transfer

Source Server         : test
Source Server Version : 50553
Source Host           : 127.0.0.1:3306
Source Database       : project

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-03-10 11:13:35
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `t_knowledge`
-- ----------------------------
DROP TABLE IF EXISTS `t_knowledge`;
CREATE TABLE `t_knowledge` (
  `knowledge_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '知识编号',
  `knowledge_title` varchar(20) DEFAULT NULL COMMENT '知识名称',
  `knowledge_msg` text COMMENT '知识内容',
  `knowledge_date` int(10) DEFAULT NULL COMMENT '知识发布时间',
  `knowledge_censor` varchar(50) DEFAULT NULL COMMENT '文章审核',
  `knowledge_filename` varchar(40) DEFAULT NULL COMMENT '文件名',
  `state` tinyint(4) NOT NULL DEFAULT '2' COMMENT '知识标记（0表示不通过，1表示已发布，2表示审核中）',
  `type_id` int(10) unsigned DEFAULT NULL COMMENT '知识类型编号',
  `user_id` int(10) unsigned DEFAULT NULL COMMENT '用户编号',
  PRIMARY KEY (`knowledge_id`),
  KEY `type_id` (`type_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE,
  CONSTRAINT `t_knowledge_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `t_type` (`type_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `t_knowledge_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `t_user` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_knowledge
-- ----------------------------
INSERT INTO `t_knowledge` VALUES ('70', '阿丽塔 战斗天使', '<p><span style=\"color: rgb(73, 73, 73); white-space: normal;font-size:18px;;font-family:微软雅黑, Microsoft YaHei\">从特效上说，是好莱坞电影工业的顶级水准……仅凭地下室和球赛两场打戏，便值回IMAX票价。电影剧情非常简单，幸好叙事紧凑连贯不拖沓，情感也还算饱满（卡梅隆爸爸的橘子确实香），7.5到8分吧。2月12日更新：流浪地球电影还没看过，但每天看评论已经足够精彩了。而因为流浪地球评论区的争论，导致了很多人在阿丽塔这里故意刷一星差评，让我感到流浪地球不仅是中国科幻的里程碑，更在无意中，让大家看到国内民族主义，集体主义与民粹主义带来的残酷两面性。正面是集体主义带来的普遍社会认同感，反面是压制理性带来的普遍妄想型人格，丧失了对真理的追求动力与评判能力，并催生出了暴力的网络乃至社会氛围。2月17日更新，流浪地球电影看过了因为价值观只能给3星，为了飘渺的千年大计，宣判35亿人死亡的设定让我无法接受。</span></p><p><span style=\"color: rgb(73, 73, 73); white-space: normal;font-size:18px;;font-family:微软雅黑, Microsoft YaHei\"><img src=\"http://127.0.0.1/project/umeditor/php/upload/20190307/15519404276139.jpg\" _src=\"http://127.0.0.1/project/umeditor/php/upload/20190307/15519404276139.jpg\"/></span></p>', '1551940437', null, '0', '1', '1', '10004');
INSERT INTO `t_knowledge` VALUES ('87', '这是一个test', '<p>fdsafsdf</p>', '1552063436', null, '1', '1', '1', '10013');
INSERT INTO `t_knowledge` VALUES ('98', 'php常用工具类', '<div style=\"color: rgb(248, 248, 242); background-color: rgb(39, 40, 34); font-family: Consolas, &quot;Courier New&quot;, monospace; font-size: 18px; line-height: 24px; white-space: pre;\"><div><span style=\"color: #f92672;\">&lt;?php</span></div><div><span style=\"color: #75715e;\">/* 常用工具类</span></div><div><span style=\"color: #75715e;\"> * @Author: 于波 </span></div><div><span style=\"color: #75715e;\"> * @Date: 2019-02-16 20:36:12 </span></div><div><span style=\"color: #75715e;\"> * @Last Modified by: 于波</span></div><div><span style=\"color: #75715e;\"> * @Last Modified time: 2019-02-22 13:53:58</span></div><div><span style=\"color: #75715e;\"> */</span></div><div><span style=\"color: #66d9ef;font-style: italic;\">class</span> <span style=\"color: rgb(166, 226, 46); text-decoration-line: underline;\">Tool</span></div><div>{</div><div>&nbsp;&nbsp;&nbsp;&nbsp;<span style=\"color: #f92672;\">public</span> <span style=\"color: #f92672;\">static</span> <span style=\"color: #66d9ef;font-style: italic;\">function</span> <span style=\"color: #a6e22e;\">alert</span>($info)</div><div>&nbsp;&nbsp;&nbsp;&nbsp;{</div><div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style=\"color: #66d9ef;\">echo</span> <span style=\"color: #e6db74;\">&quot;&lt;script&gt;alert(&#39;</span>$info<span style=\"color: #e6db74;\">&#39;);&lt;/script&gt;&quot;</span>;</div><div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style=\"color: #f92672;\">exit</span>();</div><div>&nbsp;&nbsp;&nbsp;&nbsp;}</div><br/><div>&nbsp;&nbsp;&nbsp;&nbsp;<span style=\"color: #f92672;\">public</span> <span style=\"color: #f92672;\">static</span> <span style=\"color: #66d9ef;font-style: italic;\">function</span> <span style=\"color: #a6e22e;\">alertGo</span>($info, $url)</div><div>&nbsp;&nbsp;&nbsp;&nbsp;{</div><div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style=\"color: #66d9ef;\">echo</span> <span style=\"color: #e6db74;\">&quot;&lt;script&gt;alert(&#39;</span>$info<span style=\"color: #e6db74;\">&#39;);location.href=&#39;</span>$url<span style=\"color: #e6db74;\">&#39;&lt;/script&gt;&quot;</span>;</div><div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style=\"color: #f92672;\">exit</span>();</div><div>&nbsp;&nbsp;&nbsp;&nbsp;}</div><br/><div>&nbsp;&nbsp;&nbsp;&nbsp;<span style=\"color: #f92672;\">public</span> <span style=\"color: #f92672;\">static</span> <span style=\"color: #66d9ef;font-style: italic;\">function</span> <span style=\"color: #a6e22e;\">alertBack</span>($info)</div><div>&nbsp;&nbsp;&nbsp;&nbsp;{</div><div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style=\"color: #66d9ef;\">echo</span> <span style=\"color: #e6db74;\">&quot;&lt;script&gt;alert(&#39;</span>$info<span style=\"color: #e6db74;\">&#39;);history.back();&lt;/script&gt;&quot;</span>;</div><div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style=\"color: #f92672;\">exit</span>();</div><div>&nbsp;&nbsp;&nbsp;&nbsp;}</div><div>}</div></div><p><br/></p>', '1552091522', null, '', '1', '2', '10013');
INSERT INTO `t_knowledge` VALUES ('99', '菜鸟教程', '<p><span style=\"color: rgb(26, 26, 166); font-size: medium; white-space: pre-wrap;\">菜鸟教程(www.runoob.com)提供了编程的基础技术教程, 介绍了HTML、CSS、Javascript、Python，Java，Ruby，C，PHP , MySQL等各种编程语言的基础知识。 同时本站中也提供了大量的在线实例，通过实例，您可以更好的学习编程。</span></p><p><span style=\"color: rgb(26, 26, 166); font-size: medium; white-space: pre-wrap;\"> 网址是 </span><a href=\"http://www.runoob.com/\" target=\"_self\" style=\"background-color: rgb(255, 255, 0);\">http://www.runoob.com/</a></p>', '1552093104', null, '', '1', '3', '10013');
INSERT INTO `t_knowledge` VALUES ('100', '应届生美观Word简历模板', '<ul class=\"download-card__list\" style=\"-webkit-tap-highlight-color: transparent; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 20px 0px 0px; list-style: none; font-family: PingFangSC-Regular, &quot;PingFang SC&quot;, &quot;Microsoft YaHei&quot;, &quot;Lantinghei SC&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, &quot;\\\\5FAE软雅黑&quot;, STHeitiSC-Light, simsun, &quot;\\\\5B8B体&quot;, &quot;WenQuanYi Zen Hei&quot;, &quot;WenQuanYi Micro Hei&quot;, sans-serif; -webkit-font-smoothing: antialiased; vertical-align: baseline; border-top: 1px solid rgb(238, 238, 238); border-right: none; border-bottom: none; border-left: none; border-image: initial; width: 222px; color: rgb(0, 0, 0); white-space: normal;\"><li style=\"-webkit-tap-highlight-color: transparent; margin: 0px; padding: 0px; vertical-align: baseline; border: none; color: rgb(102, 102, 102); font-size: 14px; letter-spacing: 0.73px; line-height: 24px;\">格式：doc/docx/wps</li><li style=\"-webkit-tap-highlight-color: transparent; margin: 0px; padding: 0px; vertical-align: baseline; border: none; color: rgb(102, 102, 102); font-size: 14px; letter-spacing: 0.73px; line-height: 24px;\">尺寸：A4</li><li style=\"-webkit-tap-highlight-color: transparent; margin: 0px; padding: 0px; vertical-align: baseline; border: none; color: rgb(102, 102, 102); font-size: 14px; letter-spacing: 0.73px; line-height: 24px;\">语言：中文</li><li style=\"-webkit-tap-highlight-color: transparent; margin: 0px; padding: 0px; vertical-align: baseline; border: none; color: rgb(102, 102, 102); font-size: 14px; letter-spacing: 0.73px; line-height: 24px;\">上架时间：2019/3/9</li><li style=\"-webkit-tap-highlight-color: transparent; margin: 0px; padding: 0px; vertical-align: baseline; border: none; color: rgb(102, 102, 102); font-size: 14px; letter-spacing: 0.73px; line-height: 24px;\"><img src=\"http://127.0.0.1/project/umeditor/php/upload/20190309/15520952146622.jpg\" _src=\"http://127.0.0.1/project/umeditor/php/upload/20190309/15520952146622.jpg\"/></li></ul><p><br/></p>', '1552095337', null, '20190309/user_100045c831869388e2.zip', '1', '5', '10004');
INSERT INTO `t_knowledge` VALUES ('101', '生动形象的html+css+js关系图', '<p>生动形象的html+css+js关系图:</p><p><img src=\"http://127.0.0.1/project/umeditor/php/upload/20190309/15520954632436.jpeg\" _src=\"http://127.0.0.1/project/umeditor/php/upload/20190309/15520954632436.jpeg\"/></p>', '1552095651', null, '', '1', '4', '10004');
INSERT INTO `t_knowledge` VALUES ('102', '百度网址', '<p>http://www.baidu.com尝试重新审核一下</p>', '1552099232', '太随便', '', '1', '3', '10014');
INSERT INTO `t_knowledge` VALUES ('103', '简历模板', '<p>xxxxx</p><p><br/></p>', '1552099083', null, '20190309/user_100145c83270b09885.zip', '1', '5', '10014');
INSERT INTO `t_knowledge` VALUES ('104', 'jgugyg', '<p>yuguguy</p>', '1552106029', null, '20190309/user_100135c83422d505a1.zip', '1', '1', '10013');
INSERT INTO `t_knowledge` VALUES ('105', 'dfsdf', '<p>fsdfsadf</p>', '1552108132', null, '20190309/user_100135c834a641dbd2.zip', '2', '1', '10013');
INSERT INTO `t_knowledge` VALUES ('106', 'sfasdf', '<p>sdafasdfas</p>', '1552108239', null, 'file20190309/user_100135c834acf95a9f.zip', '2', '1', '10013');
INSERT INTO `t_knowledge` VALUES ('107', '经典简历模板', '<p>fsdfsadf</p>', '1552109346', null, 'file20190309/user_100135c834f226ba80.zip', '2', '1', '10013');
INSERT INTO `t_knowledge` VALUES ('108', 'fsdfsa', '<p>fsdfsaafsadfasddf</p>', '1552113838', null, 'file20190309/user_100135c8360ae360af.zip', '2', '1', '10013');
INSERT INTO `t_knowledge` VALUES ('109', '经典简历模板', '<p>下载附件就行</p>', '1552185480', null, 'file20190310/user_100135c847888e756c.zip', '2', '1', '10013');
