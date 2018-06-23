/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50640
 Source Host           : 127.0.0.1
 Source Database       : insider_crypto

 Target Server Type    : MySQL
 Target Server Version : 50640
 File Encoding         : utf-8

 Date: 06/23/2018 15:12:10 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `api_errors`
-- ----------------------------
DROP TABLE IF EXISTS `api_errors`;
CREATE TABLE `api_errors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `json` text,
  `error` varchar(0) NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1885 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `bitcoin_value`
-- ----------------------------
DROP TABLE IF EXISTS `bitcoin_value`;
CREATE TABLE `bitcoin_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fiat` varchar(255) NOT NULL,
  `cost` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE,
  KEY `fiat` (`fiat`) USING BTREE,
  KEY `cost` (`cost`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `chat`
-- ----------------------------
DROP TABLE IF EXISTS `chat`;
CREATE TABLE `chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `cold_storage`
-- ----------------------------
DROP TABLE IF EXISTS `cold_storage`;
CREATE TABLE `cold_storage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address` varchar(255) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `currency`
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
) ENGINE=InnoDB AUTO_INCREMENT=27555 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `last_update`
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
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `markets`
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
) ENGINE=InnoDB AUTO_INCREMENT=1096 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `markets_pairs`
-- ----------------------------
DROP TABLE IF EXISTS `markets_pairs`;
CREATE TABLE `markets_pairs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `market_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `symbol_id` int(11) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  `volume24hour` varchar(32) NOT NULL DEFAULT '0',
  `price` varchar(32) NOT NULL DEFAULT '0',
  `lastupdate` varchar(32) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE,
  KEY `market_id` (`market_id`) USING BTREE,
  KEY `currency_id` (`currency_id`) USING BTREE,
  KEY `symbol_id` (`symbol_id`) USING BTREE,
  KEY `active` (`active`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=179969 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `match_history`
-- ----------------------------
DROP TABLE IF EXISTS `match_history`;
CREATE TABLE `match_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `match_id` int(11) NOT NULL,
  `pair1_id` int(11) NOT NULL,
  `pair2_id` int(11) NOT NULL,
  `started` int(11) NOT NULL,
  `finished` int(11) NOT NULL,
  `avg_percent` varchar(32) NOT NULL DEFAULT '0',
  `avg_24hourvolume` varchar(32) NOT NULL DEFAULT '0',
  `price_calls` int(11) NOT NULL DEFAULT '0',
  `avg_price_pair1` varchar(32) NOT NULL,
  `avg_price_pair2` varchar(32) NOT NULL,
  `low_price_pair1` varchar(32) NOT NULL,
  `low_price_pair2` varchar(32) NOT NULL,
  `high_price_pair1` varchar(255) NOT NULL,
  `high_price_pair2` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `matches`
-- ----------------------------
DROP TABLE IF EXISTS `matches`;
CREATE TABLE `matches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pair1_id` int(11) NOT NULL,
  `pair2_id` int(11) NOT NULL,
  `started` int(11) NOT NULL,
  `finished` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=88448 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `matches_log`
-- ----------------------------
DROP TABLE IF EXISTS `matches_log`;
CREATE TABLE `matches_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `match_id` int(11) NOT NULL,
  `pair1_id` int(11) NOT NULL,
  `pair2_id` int(11) NOT NULL,
  `pair1_price` varchar(32) NOT NULL,
  `pair2_price` varchar(32) NOT NULL,
  `percent` varchar(32) NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=155868 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `orders`
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `usd_cost` float NOT NULL,
  `amount_requested` varchar(255) NOT NULL,
  `amount_received` varchar(255) NOT NULL DEFAULT '0',
  `tx_id` varchar(512) DEFAULT NULL,
  `cold_storage_id` int(11) NOT NULL,
  `confirmed` int(11) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `price_chart`
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
) ENGINE=InnoDB AUTO_INCREMENT=326399 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `requests`
-- ----------------------------
DROP TABLE IF EXISTS `requests`;
CREATE TABLE `requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `data` varchar(255) DEFAULT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `symbols`
-- ----------------------------
DROP TABLE IF EXISTS `symbols`;
CREATE TABLE `symbols` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `abbr` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE,
  KEY `abbr` (`abbr`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1980 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `trollbox`
-- ----------------------------
DROP TABLE IF EXISTS `trollbox`;
CREATE TABLE `trollbox` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `handle` varchar(255) NOT NULL,
  `user_type` tinyint(4) NOT NULL,
  `message` text NOT NULL,
  `created` int(11) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE,
  KEY `uid` (`uid`) USING BTREE,
  KEY `created` (`created`) USING BTREE,
  KEY `handle` (`handle`) USING BTREE,
  KEY `user_type` (`user_type`) USING BTREE,
  KEY `active` (`active`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `verification_key` varchar(255) DEFAULT NULL,
  `lsk_address` varchar(255) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `notifications` tinyint(4) NOT NULL DEFAULT '0',
  `subscribed` tinyint(4) NOT NULL DEFAULT '0',
  `threshold` tinyint(4) DEFAULT '3',
  `last_login` int(11) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `vip` int(11) NOT NULL DEFAULT '0',
  `paid` int(11) NOT NULL DEFAULT '0',
  `admin` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `users`
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES ('1', 'admin', 'opanelj@gmail.com', '79a7387515718b5f24b1b70d8ea44dbd', 'WjrPIECgap', '4287319913737945577L', '1516182413', '1', '1', '3', '1529790948', '127.0.0.1', '1', '0', '1');
COMMIT;

-- ----------------------------
--  Table structure for `users_ip_login`
-- ----------------------------
DROP TABLE IF EXISTS `users_ip_login`;
CREATE TABLE `users_ip_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `users_markets`
-- ----------------------------
DROP TABLE IF EXISTS `users_markets`;
CREATE TABLE `users_markets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `market_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;
