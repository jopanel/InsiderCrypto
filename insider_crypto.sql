/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50713
Source Host           : localhost:3306
Source Database       : insider_crypto

Target Server Type    : MYSQL
Target Server Version : 50713
File Encoding         : 65001

Date: 2018-01-14 15:27:13
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `currency`
-- ----------------------------
DROP TABLE IF EXISTS `currency`;
CREATE TABLE `currency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `abbr` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE,
  KEY `name` (`name`) USING BTREE,
  KEY `abbr` (`abbr`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=13956 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of currency
-- ----------------------------

-- ----------------------------
-- Table structure for `last_update`
-- ----------------------------
DROP TABLE IF EXISTS `last_update`;
CREATE TABLE `last_update` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lastupdate` int(11) NOT NULL,
  `reset` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE,
  KEY `lastupdate` (`lastupdate`) USING BTREE,
  KEY `reset` (`reset`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of last_update
-- ----------------------------

-- ----------------------------
-- Table structure for `markets`
-- ----------------------------
DROP TABLE IF EXISTS `markets`;
CREATE TABLE `markets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE,
  KEY `name` (`name`) USING BTREE,
  KEY `active` (`active`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=506 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of markets
-- ----------------------------

-- ----------------------------
-- Table structure for `markets_pairs`
-- ----------------------------
DROP TABLE IF EXISTS `markets_pairs`;
CREATE TABLE `markets_pairs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `market_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `symbol_id` int(11) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE,
  KEY `market_id` (`market_id`) USING BTREE,
  KEY `currency_id` (`currency_id`) USING BTREE,
  KEY `symbol_id` (`symbol_id`) USING BTREE,
  KEY `active` (`active`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=54780 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of markets_pairs
-- ----------------------------

-- ----------------------------
-- Table structure for `orders`
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `transaction_id_received` int(11) DEFAULT NULL,
  `transaction_id_withdrawn` int(11) DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `usd_cost` float NOT NULL,
  `amount_requested` varchar(255) NOT NULL,
  `amount_received` varchar(255) DEFAULT NULL,
  `tx_id` varchar(512) DEFAULT NULL,
  `withdrawn` int(11) NOT NULL DEFAULT '0',
  `created` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of orders
-- ----------------------------

-- ----------------------------
-- Table structure for `price_chart`
-- ----------------------------
DROP TABLE IF EXISTS `price_chart`;
CREATE TABLE `price_chart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `market_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `symbol_id` int(11) NOT NULL,
  `price` varchar(255) DEFAULT NULL,
  `lastupdate` int(11) DEFAULT NULL,
  `price_low` varchar(255) DEFAULT NULL,
  `price_high` varchar(255) DEFAULT NULL,
  `changepct24hour` varchar(255) DEFAULT NULL,
  `volume24hour` varchar(255) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE,
  KEY `market_id` (`market_id`) USING BTREE,
  KEY `currency_id` (`currency_id`) USING BTREE,
  KEY `symbol_id` (`symbol_id`) USING BTREE,
  KEY `price` (`price`) USING BTREE,
  KEY `lastupdate` (`lastupdate`) USING BTREE,
  KEY `price_low` (`price_low`) USING BTREE,
  KEY `price_high` (`price_high`) USING BTREE,
  KEY `volume24hour` (`volume24hour`) USING BTREE,
  KEY `created` (`created`) USING BTREE,
  KEY `changepct24hour` (`changepct24hour`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3471 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of price_chart
-- ----------------------------

-- ----------------------------
-- Table structure for `symbols`
-- ----------------------------
DROP TABLE IF EXISTS `symbols`;
CREATE TABLE `symbols` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `abbr` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE,
  KEY `abbr` (`abbr`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=707 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of symbols
-- ----------------------------

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `verification_id` varchar(255) DEFAULT NULL,
  `lsk_public_key` varchar(255) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
