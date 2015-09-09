SET NAMES 'utf8';
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(10) unsigned NOT NULL auto_increment,
  `uuid` varchar(36) NOT NULL,
  `node` tinyint(3) unsigned NOT NULL default '0',
  `date_created` datetime NOT NULL COMMENT 'via Trigger (user)',
  `last_modified` datetime NOT NULL COMMENT 'via Trigger (user)',
  `last_login` date default NULL,
  `username` varchar(60) NOT NULL,
  `password` varchar(128) default NULL,
  `email` varchar(60) default NULL,
  `email_problems` int(10) NOT NULL default '0',
  `first_email_problem` date default NULL,
  `last_email_problem` datetime default NULL,
  `mailing_problems` int(10) unsigned NOT NULL default '0',
  `accept_mailing` tinyint(1) NOT NULL default '1',
  `usermail_send_addr` tinyint(1) NOT NULL default '0',
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `is_active_flag` tinyint(1) NOT NULL,
  `last_name` varchar(60) NOT NULL,
  `first_name` varchar(60) NOT NULL,
  `country` char(2) default NULL,
  `pmr_flag` tinyint(1) NOT NULL,
  `new_pw_code` varchar(13) default NULL,
  `new_pw_date` datetime default NULL,
  `new_email_code` varchar(13) default NULL,
  `new_email_date` datetime default NULL,
  `new_email` varchar(60) default NULL,
  `permanent_login_flag` tinyint(1) NOT NULL,
  `watchmail_mode` tinyint(3) unsigned NOT NULL default '1',
  `watchmail_hour` tinyint(3) unsigned NOT NULL default '0',
  `watchmail_nextmail` datetime NOT NULL default '0000-00-00 00:00:00' COMMENT 'via cronjob',
  `watchmail_day` tinyint(3) unsigned NOT NULL default '0',
  `activation_code` varchar(13) NOT NULL,
  `statpic_logo` tinyint(3) unsigned NOT NULL default '0',
  `statpic_text` varchar(30) NOT NULL default 'Opencaching',
  `no_htmledit_flag` tinyint(1) NOT NULL default '0',
  `notify_radius` int(10) unsigned NOT NULL default '0',
  `notify_oconly` tinyint(1) NOT NULL default '1',
  `language` char(2) default NULL,
  `language_guessed` tinyint(1) NOT NULL default '0',
  `admin` smallint(5) unsigned NOT NULL default '0',
  `data_license` tinyint(1) NOT NULL default '0',
  `description` mediumtext NOT NULL,
  `desc_htmledit` tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `uuid` (`uuid`),
  UNIQUE KEY `email` (`email`),
  KEY `notify_radius` (`notify_radius`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;
