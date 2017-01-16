CREATE TABLE IF NOT EXISTS `#__inventory_devices` (
  `device_id` int(11) NOT NULL AUTO_INCREMENT,
  `catid` int(11) NOT NULL DEFAULT 0,
  `devicename` varchar(255) DEFAULT NULL,
  `snumber` varchar(255) DEFAULT NULL,
  `shortdescription` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `orgunit` varchar(255) DEFAULT NULL,
  `orgunit_id` int(11) DEFAULT NULL,
  `imageurl` varchar(255) DEFAULT NULL,
  `qrcode` varchar(255) NOT NULL  UNIQUE COLLATE latin1_general_cs,
  `qrcodesvg` text NOT NULL,
  `tags` VARCHAR( 255 ) NULL DEFAULT NULL,
  `lent_user_id` int(11) DEFAULT NULL,
  `lent_user_name` varchar(255) DEFAULT NULL,
  `lent_description` varchar(255) DEFAULT NULL,
  `lent` tinyint(2) DEFAULT 0,
  `lent_date` datetime DEFAULT NULL,
  `lent_due_date` datetime DEFAULT NULL,
  `locked` tinyint(2) DEFAULT 0,
  `active` tinyint(2) DEFAULT 1,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `newTags` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`device_id`)
)ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__inventory_orgunits` (
  `orgunit_id` int(11) NOT NULL AUTO_INCREMENT,
  `catid` int(11) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL,
  `shortdescription` varchar(255) DEFAULT NULL,
  `newTags` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`orgunit_id`)  
)ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__inventory_history` (
  `history_id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` int(11) NOT NULL,
  `lent_user_id` int(11) DEFAULT NULL,
  `shortdescription` varchar(255) DEFAULT NULL,
  `lent_start_date` datetime DEFAULT NULL,
  `lent_end_date` datetime DEFAULT NULL,
  PRIMARY KEY (`history_id`)  
)ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__inventory_waitlists` (
  `waitlist_id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` int(11) DEFAULT NULL,
  `lent_user_id` int(11) DEFAULT NULL,
  `fulfilled` tinyint(2) DEFAULT 0,
  `fulfilled_time` datetime DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`waitlist_id`)
)ENGINE=MyISAM  DEFAULT CHARSET=utf8;
