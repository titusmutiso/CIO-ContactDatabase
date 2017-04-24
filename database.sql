/*
SQLyog Professional v12.09 (64 bit)
MySQL - 5.7.14 : Database - cio_contacts
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`cio_contacts` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `cio_contacts`;

/*Table structure for table `company_details` */

DROP TABLE IF EXISTS `company_details`;

CREATE TABLE `company_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT NULL COMMENT 'Comapny ID',
  `country_id` int(11) DEFAULT NULL COMMENT 'Country ID',
  `date_created` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Table structure for table `contact_details` */

DROP TABLE IF EXISTS `contact_details`;

CREATE TABLE `contact_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `subscription` int(11) DEFAULT NULL,
  `date_subscribed` varchar(30) DEFAULT NULL,
  `membership` int(11) DEFAULT NULL,
  `facebook` text,
  `twitter` text,
  `linkedin` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Table structure for table `sp_activities` */

DROP TABLE IF EXISTS `sp_activities`;

CREATE TABLE `sp_activities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` int(11) DEFAULT NULL,
  `activity` text,
  `company` int(11) DEFAULT NULL,
  `date_created` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Table structure for table `sp_company` */

DROP TABLE IF EXISTS `sp_company`;

CREATE TABLE `sp_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` text NOT NULL,
  `industry_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `email_address` text NOT NULL,
  `phone_number` text NOT NULL,
  `landline` text NOT NULL,
  `website_url` text NOT NULL,
  `address` text NOT NULL,
  `postal_code` varchar(20) NOT NULL,
  `city` text NOT NULL,
  `location` text NOT NULL,
  `logo` text NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_created` varchar(30) NOT NULL,
  `date_modofied` varchar(30) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Table structure for table `sp_contacts` */

DROP TABLE IF EXISTS `sp_contacts`;

CREATE TABLE `sp_contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `email_address` text NOT NULL,
  `phone_no` text NOT NULL,
  `company` text NOT NULL,
  `designation` text NOT NULL,
  `owner` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `date_created` text NOT NULL,
  `date_updated` text NOT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Table structure for table `sp_countries` */

DROP TABLE IF EXISTS `sp_countries`;

CREATE TABLE `sp_countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_name` varchar(150) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_created` varchar(30) NOT NULL,
  `date_modified` varchar(30) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=248 DEFAULT CHARSET=utf8;

/*Table structure for table `sp_designation` */

DROP TABLE IF EXISTS `sp_designation`;

CREATE TABLE `sp_designation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` text NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_created` varchar(30) NOT NULL,
  `date_modified` varchar(30) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Table structure for table `sp_history` */

DROP TABLE IF EXISTS `sp_history`;

CREATE TABLE `sp_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activity` text,
  `user_id` int(11) NOT NULL,
  `last_login` varchar(30) NOT NULL,
  `ip_address` text NOT NULL,
  `date_created` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `sp_industry` */

DROP TABLE IF EXISTS `sp_industry`;

CREATE TABLE `sp_industry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `industry_name` text NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_created` varchar(30) NOT NULL,
  `date_modified` varchar(30) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Table structure for table `sp_log` */

DROP TABLE IF EXISTS `sp_log`;

CREATE TABLE `sp_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `activity` text,
  `last_login` text NOT NULL,
  `ip_address` text NOT NULL,
  `date_created` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

/*Table structure for table `sp_notifications` */

DROP TABLE IF EXISTS `sp_notifications`;

CREATE TABLE `sp_notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `history_id` int(11) DEFAULT NULL,
  `activity` text,
  `date_created` varchar(30) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

/*Table structure for table `sp_settings` */

DROP TABLE IF EXISTS `sp_settings`;

CREATE TABLE `sp_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_name` varchar(100) NOT NULL,
  `site_logo` text NOT NULL,
  `site_title` varchar(100) NOT NULL,
  `site_desc` text NOT NULL,
  `site_phone_number` varchar(30) NOT NULL,
  `site_email` varchar(40) NOT NULL,
  `site_address` text NOT NULL,
  `site_url` varchar(40) NOT NULL,
  `facebook_acc` text NOT NULL,
  `twitter_acc` text NOT NULL,
  `gplus_acc` text NOT NULL,
  `linkedin` varchar(100) NOT NULL,
  `instagram` varchar(100) NOT NULL,
  `date_modified` varchar(30) NOT NULL,
  `date_created` varchar(30) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Table structure for table `sp_tasks` */

DROP TABLE IF EXISTS `sp_tasks`;

CREATE TABLE `sp_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_name` text,
  `task_desc` text,
  `priority` int(11) DEFAULT NULL COMMENT 'high,normal,low',
  `status` int(11) DEFAULT NULL COMMENT 'complete,ongoing',
  `percentage` int(11) DEFAULT NULL COMMENT 'progress bar',
  `owner` int(11) DEFAULT NULL COMMENT 'userid',
  `company` int(11) DEFAULT NULL,
  `start_date` varchar(40) DEFAULT NULL,
  `end_date` varchar(40) DEFAULT NULL,
  `date_created` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Table structure for table `sp_users` */

DROP TABLE IF EXISTS `sp_users`;

CREATE TABLE `sp_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email_add` varchar(100) NOT NULL,
  `phone_no` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `role` varchar(100) NOT NULL,
  `user_desc` text NOT NULL,
  `user_img` text NOT NULL,
  `status` varchar(10) NOT NULL,
  `date_created` text NOT NULL,
  `trash` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
