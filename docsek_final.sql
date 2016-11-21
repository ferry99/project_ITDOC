/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : docsek_uji

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-06-23 06:57:04
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ds_admin
-- ----------------------------
DROP TABLE IF EXISTS `ds_admin`;
CREATE TABLE `ds_admin` (
  `id_admin` int(12) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(25) NOT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ds_admin
-- ----------------------------
INSERT INTO `ds_admin` VALUES ('0', 'admin', '21232f297a57a5a743894a0e4a801fc3', '');

-- ----------------------------
-- Table structure for ds_directory
-- ----------------------------
DROP TABLE IF EXISTS `ds_directory`;
CREATE TABLE `ds_directory` (
  `id_directory` int(250) NOT NULL AUTO_INCREMENT,
  `name_directory` varchar(250) NOT NULL,
  `path_directory` varchar(250) NOT NULL,
  `date` datetime NOT NULL,
  `size` double DEFAULT NULL,
  PRIMARY KEY (`id_directory`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ds_directory
-- ----------------------------

-- ----------------------------
-- Table structure for ds_document
-- ----------------------------
DROP TABLE IF EXISTS `ds_document`;
CREATE TABLE `ds_document` (
  `id_document` int(11) NOT NULL AUTO_INCREMENT,
  `id_directory` int(11) NOT NULL,
  `name_document` varchar(250) NOT NULL,
  `name_file` varchar(255) NOT NULL,
  `path` varchar(100) NOT NULL,
  `size` double NOT NULL,
  `desc` varchar(300) DEFAULT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id_document`),
  KEY `id_directory` (`id_directory`),
  CONSTRAINT `ds_document_ibfk_1` FOREIGN KEY (`id_directory`) REFERENCES `ds_directory` (`id_directory`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ds_document
-- ----------------------------

-- ----------------------------
-- Table structure for ds_index
-- ----------------------------
DROP TABLE IF EXISTS `ds_index`;
CREATE TABLE `ds_index` (
  `id_document` int(50) NOT NULL,
  `id_term` int(50) NOT NULL,
  `tf` int(50) NOT NULL,
  KEY `id_document` (`id_document`),
  KEY `id_term` (`id_term`),
  CONSTRAINT `ds_index_ibfk_1` FOREIGN KEY (`id_document`) REFERENCES `ds_document` (`id_document`),
  CONSTRAINT `ds_index_ibfk_2` FOREIGN KEY (`id_term`) REFERENCES `ds_term` (`id_term`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ds_index
-- ----------------------------

-- ----------------------------
-- Table structure for ds_term
-- ----------------------------
DROP TABLE IF EXISTS `ds_term`;
CREATE TABLE `ds_term` (
  `id_term` int(11) NOT NULL AUTO_INCREMENT,
  `term` varchar(50) NOT NULL,
  `df` double NOT NULL,
  PRIMARY KEY (`id_term`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ds_term
-- ----------------------------
