-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `a_groups`;
CREATE TABLE `a_groups` (
  `group_id` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `private_link` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `msg_count` bigint(20) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `a_users`;
CREATE TABLE `a_users` (
  `user_id` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `private_msg_count` bigint(20) DEFAULT NULL,
  `group_msg_count` bigint(20) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `groups_history`;
CREATE TABLE `groups_history` (
  `group_id` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  KEY `group_id` (`group_id`),
  CONSTRAINT `groups_history_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `a_groups` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `groups_setting`;
CREATE TABLE `groups_setting` (
  `group_id` varchar(255) NOT NULL,
  `max_warn` int(11) NOT NULL DEFAULT '3',
  `welcome_message` text,
  `history_notification` enum('true','false') DEFAULT 'false',
  KEY `group_id` (`group_id`),
  CONSTRAINT `groups_setting_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `a_groups` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `group_admins`;
CREATE TABLE `group_admins` (
  `group_id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `status` enum('creator','administrator') NOT NULL,
  `privileges` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  KEY `group_id` (`group_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `group_admins_ibfk_3` FOREIGN KEY (`group_id`) REFERENCES `a_groups` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `group_admins_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `a_users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `group_messages`;
CREATE TABLE `group_messages` (
  `msg_uniq` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `group_id` varchar(255) NOT NULL,
  `message_id` varchar(255) NOT NULL,
  `reply_to_message_id` varchar(255) DEFAULT NULL,
  `type` enum('text','photo','voice','video') NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`msg_uniq`),
  KEY `user_id` (`user_id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `group_messages_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `a_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `group_messages_ibfk_6` FOREIGN KEY (`group_id`) REFERENCES `a_groups` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `group_messages_data`;
CREATE TABLE `group_messages_data` (
  `msg_uniq` varchar(255) NOT NULL,
  `text` text,
  `file` varchar(255) DEFAULT NULL,
  KEY `msg_uniq` (`msg_uniq`),
  CONSTRAINT `group_messages_data_ibfk_2` FOREIGN KEY (`msg_uniq`) REFERENCES `group_messages` (`msg_uniq`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `private_messages`;
CREATE TABLE `private_messages` (
  `msg_uniq` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `message_id` varchar(255) NOT NULL,
  `reply_to_message_id` varchar(255) DEFAULT NULL,
  `type` enum('text','photo','voice','video') NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`msg_uniq`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `private_messages_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `a_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `private_messages_data`;
CREATE TABLE `private_messages_data` (
  `msg_uniq` varchar(255) NOT NULL,
  `text` text,
  `file` varchar(255) DEFAULT NULL,
  KEY `msg_uniq` (`msg_uniq`),
  CONSTRAINT `private_messages_data_ibfk_2` FOREIGN KEY (`msg_uniq`) REFERENCES `private_messages` (`msg_uniq`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `users_history`;
CREATE TABLE `users_history` (
  `user_id` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  KEY `user_id` (`user_id`),
  CONSTRAINT `users_history_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `a_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `users_warn`;
CREATE TABLE `users_warn` (
  `user_id` varchar(255) NOT NULL,
  `group_id` varchar(255) NOT NULL,
  `reasons` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  KEY `user_id` (`user_id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `users_warn_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `a_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `users_warn_ibfk_4` FOREIGN KEY (`group_id`) REFERENCES `a_groups` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- 2017-11-03 10:14:15
