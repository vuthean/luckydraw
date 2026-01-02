/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


CREATE DATABASE /*!32312 IF NOT EXISTS*/ `spin_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `spin_db`;
DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `customer_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer_CIF` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_name` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_TEL` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_winStatus` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `prize`;
CREATE TABLE `prize` (
  `prize_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `prize_Description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`prize_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `ticket`;
CREATE TABLE `ticket` (
  `ticket_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ticket_number` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'text',
  `ticket_date` timestamp NULL DEFAULT NULL,
  `customer_CIF` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `users_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ticket_numberOfTicket` int(11) NOT NULL,
  PRIMARY KEY (`ticket_id`),
  UNIQUE KEY `ticket_number` (`ticket_number`) USING HASH
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint(20) unsigned DEFAULT NULL,
  `profile_photo_path` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `customer` (`customer_id`,`customer_CIF`,`customer_name`,`customer_TEL`,`customer_winStatus`,`created_at`,`updated_at`) VALUES (1,'0000001','Meanrith','0988988888',0,'2021-01-21 10:00:41','2021-01-21 10:00:41'),(2,'0000002','Safhone','0988988787',0,'2021-01-21 10:19:51','2021-01-21 10:19:51'),(3,'0000003','Ura','0988988333',0,'2021-01-21 23:12:25','2021-01-21 23:12:25');

INSERT INTO `prize` (`prize_id`,`prize_Description`,`created_at`,`updated_at`) VALUES (1,'1,000,000Riel',NULL,NULL),(2,'Fridge',NULL,NULL),(3,'Honda Scoopy 2021',NULL,NULL),(4,'Toyota Rush 2020',NULL,NULL),(5,'The Prince Condo 1 Unit',NULL,NULL),(6,'The Prince Condo 1 Unit',NULL,NULL);

INSERT INTO `sessions` (`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`,`created_at`,`updated_at`) VALUES ('0qO3LJUZKri3JslFIYw4FDRg4DCeSHUfE9kUYFEd',1,'::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.141 Safari/537.36 Edg/87.0.664.75','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiT04yS3YyR1J2YmpjRnpHdjZRREtLcklJRjNkS0hxSkdIMmhIekwySiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly9sb2NhbGhvc3QvU1BJTjEvcHVibGljL2Rhc2hib2FyZCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjA6IiQyeSQxMCQudFVLSnpsUFMueWJpRFRLcDQ2Ny9PcW5MTjZBTU83TzFzM0M4WXJ6VVBpaVExSmQxdy9qTyI7fQ==',1611309042,NULL,NULL);

INSERT INTO `ticket` (`ticket_id`,`ticket_number`,`ticket_date`,`customer_CIF`,`users_id`,`created_at`,`updated_at`,`ticket_numberOfTicket`) VALUES (1,'NUM000001',NULL,'0000001',1,'2021-01-21 23:17:53','2021-01-21 23:17:53',1),(2,'NUM000002',NULL,'0000002',3,'2021-01-21 23:18:36','2021-01-21 23:18:36',1),(3,'NUM000003',NULL,'0000003',3,'2021-01-22 08:40:17','2021-01-22 08:40:25',1),(4,'NUM000004',NULL,'0000002',3,'2021-01-22 08:40:32','2021-01-22 08:40:35',1),(5,'NUM000005',NULL,'0000001',3,'2021-01-22 08:12:25','2021-01-22 08:12:25',1),(6,'NUM000006',NULL,'0000001',3,'2021-01-22 08:14:36','2021-01-22 08:14:36',1),(7,'NUM000007',NULL,'0000001',3,'2021-01-22 08:22:57','2021-01-22 08:22:57',1),(8,'NUM000012',NULL,'0000001',3,'2021-01-22 08:29:43','2021-01-22 08:29:43',2),(9,'NUM000013',NULL,'0000001',3,'2021-01-22 08:29:43','2021-01-22 08:29:43',2);

INSERT INTO `users` (`id`,`name`,`email`,`email_verified_at`,`password`,`two_factor_secret`,`two_factor_recovery_codes`,`remember_token`,`current_team_id`,`profile_photo_path`,`created_at`,`updated_at`,`role_id`) VALUES (1,'requester01','requester01@usct.local',NULL,'$2y$10$.tUKJzlPS.ybiDTKp467/OqnLN6AMO7O1s3C8YrzUPiiQ1Jd1w/jO',NULL,NULL,NULL,NULL,NULL,'2021-01-21 22:11:46','2021-01-21 22:11:46',1),(2,'requester02','requester02@usct.local',NULL,'$2y$10$RVL0vtFE1vOD6Vm8QaGJYOdIio5kqNJKZg373m1FsVxagyIBXgpiS',NULL,NULL,NULL,NULL,NULL,'2021-01-20 20:53:13','2021-01-20 20:53:13',1),(3,'branch1','branch1@usct.local',NULL,'$2y$10$rDyiD.71EQ7pXcrKwmrKbuVCg4h1VUFSzF/grdlGrJLsz2gcq3abG',NULL,NULL,NULL,NULL,NULL,'2021-01-20 07:48:48','2021-01-20 07:48:48',2),(4,'branch2','branch2@usct.local',NULL,'$2y$10$dFGopvfeUzTGDtgf6Dm/auG5YIEbut9c/KCbY7hIfpfP3K3z6jKKK',NULL,NULL,NULL,NULL,NULL,'2021-01-20 07:49:28','2021-01-20 07:49:28',2),(6,'branch3','branch3@usct.local',NULL,'$2y$10$ct4vVXP.xUrMU.Mdnu/Hg.q5DShGnpBNwhUwMOXbalATCqYugsAbW',NULL,NULL,NULL,NULL,NULL,'2021-01-20 08:50:39','2021-01-20 08:50:39',2),(7,'sdafds','fsdafdsaf@dfdsf.com',NULL,'$2y$10$IfGp5XQiNIyfma3eOnTeauIiQfK7N2oawAycIWUN3PRHfGEziYXiS',NULL,NULL,NULL,NULL,NULL,'2021-01-20 09:27:44','2021-01-20 09:27:44',2);

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
