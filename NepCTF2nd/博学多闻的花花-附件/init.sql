/*
 Navicat Premium Data Transfer

 Source Server         : 127.0.0.1
 Source Server Type    : MySQL
 Source Server Version : 50651
 Source Host           : localhost:22068
 Source Schema         : score
 Name                  : Err0r

 Target Server Type    : MySQL
 Target Server Version : 50651
 File Encoding         : 65001

 Date: 12/06/2022 11:53:39
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE score;
use score;

-- ----------------------------
-- Table structure for challengesAll
-- ----------------------------
DROP TABLE IF EXISTS `challengesAll`;
CREATE TABLE `challengesAll` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `TitleImg` varchar(255) DEFAULT NULL,
  `OptionA` varchar(255) DEFAULT NULL,
  `OptionB` varchar(255) DEFAULT NULL,
  `OptionC` varchar(255) DEFAULT NULL,
  `OptionD` varchar(255) DEFAULT NULL,
  `Answer` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of challengesAll
-- ----------------------------
BEGIN;
-- do it youself
COMMIT;

-- ----------------------------
-- Table structure for ctf
-- ----------------------------
DROP TABLE IF EXISTS `ctf`;
CREATE TABLE `ctf` (
  `id` int(11) DEFAULT NULL,
  `name` mediumtext,
  `value` mediumtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ctf
-- ----------------------------
BEGIN;
INSERT INTO `ctf` VALUES (1, 'flag', 'flag_in_/flag');
COMMIT;

-- ----------------------------
-- Table structure for randChallenges
-- ----------------------------
DROP TABLE IF EXISTS `randChallenges`;
CREATE TABLE `randChallenges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `challengeId1` varchar(255) DEFAULT NULL,
  `challengeId2` varchar(255) DEFAULT NULL,
  `challengeId3` varchar(255) DEFAULT NULL,
  `challengeId4` varchar(255) DEFAULT NULL,
  `challengeId5` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of randChallenges
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for score
-- ----------------------------
DROP TABLE IF EXISTS `score`;
CREATE TABLE `score` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` mediumtext,
  `score` int(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of score
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for userAnswer
-- ----------------------------
DROP TABLE IF EXISTS `userAnswer`;
CREATE TABLE `userAnswer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `studentid` varchar(255) DEFAULT NULL,
  `ans1` varchar(255) DEFAULT NULL,
  `ans2` varchar(255) DEFAULT NULL,
  `ans3` varchar(255) DEFAULT NULL,
  `ans4` varchar(255) DEFAULT NULL,
  `ans5` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of userAnswer
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` mediumtext,
  `studentid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `studentid` (`studentid`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
-- The admin password will be updated every 10 minutes
INSERT INTO `users` VALUES (1, 'admin', 'admin_passwd_is_here');
-- The password will be changed every time when admin logs in
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;

CREATE USER 'ctf' IDENTIFIED BY '123456';
GRANT select,insert,update ON score.* TO 'ctf'@'%';
GRANT file,insert ON *.* TO 'ctf'@'%';
FLUSH PRIVILEGES;
