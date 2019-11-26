-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.23 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             10.0.0.5460
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table core.affiliates
CREATE TABLE IF NOT EXISTS `affiliates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `order_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `affiliate_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `module` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'purchase, renew',
  `percent` double DEFAULT NULL,
  `fixed` double DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `currency_code` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `order_price` double DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '99',
  `payment_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table core.affiliates: ~0 rows (approximately)
/*!40000 ALTER TABLE `affiliates` DISABLE KEYS */;
/*!40000 ALTER TABLE `affiliates` ENABLE KEYS */;

-- Dumping structure for table core.affiliates_config
CREATE TABLE IF NOT EXISTS `affiliates_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(50) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8;

-- Dumping data for table core.affiliates_config: ~5 rows (approximately)
/*!40000 ALTER TABLE `affiliates_config` DISABLE KEYS */;
INSERT INTO `affiliates_config` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
	(90, 'active', 'on', '2019-09-26 23:44:07', '2019-09-26 23:44:07'),
	(91, 'payout', '7', '2019-09-26 23:44:07', '2019-09-26 23:44:07'),
	(92, 'Mtopup', '{"new_purchase":"30","webmaster":"10","renewal":"10"}', '2019-09-26 23:44:07', '2019-09-26 23:44:07'),
	(93, 'Product', '{"new_purchase":"30","webmaster":"5","renewal":"5"}', '2019-09-26 23:44:07', '2019-09-26 23:44:07'),
	(94, 'Softcard', '{"new_purchase":"30","webmaster":"25","renewal":"20"}', '2019-09-26 23:44:07', '2019-09-26 23:44:07');
/*!40000 ALTER TABLE `affiliates_config` ENABLE KEYS */;

-- Dumping structure for table core.auth_logs
CREATE TABLE IF NOT EXISTS `auth_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `phone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `twofactor` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=345 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table core.auth_logs: ~343 rows (approximately)
/*!40000 ALTER TABLE `auth_logs` DISABLE KEYS */;
INSERT INTO `auth_logs` (`id`, `user_id`, `phone`, `email`, `ip`, `twofactor`, `user_agent`, `created_at`, `updated_at`) VALUES
	(2, 1, '0943793985', NULL, '127.0.0.1', '888888', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36', '2019-01-24 21:37:15', '2019-01-24 21:37:15'),
	(3, 25, '0943793986', NULL, '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36', '2019-01-24 21:55:27', '2019-01-24 21:55:27'),
	(4, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36', '2019-01-25 03:22:20', '2019-01-25 03:22:20'),
	(5, 1, '0943793985', 'support@nencer.com', '127.0.0.1', '888888', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36', '2019-01-25 07:39:59', '2019-01-25 07:39:59'),
	(6, 1, '0943793985', 'support@nencer.com', '127.0.0.1', '888888', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36', '2019-01-25 17:54:12', '2019-01-25 17:54:12'),
	(7, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36', '2019-01-26 07:19:35', '2019-01-26 07:19:35'),
	(8, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36', '2019-01-26 09:47:16', '2019-01-26 09:47:16'),
	(9, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36', '2019-01-29 07:47:52', '2019-01-29 07:47:52'),
	(10, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36', '2019-01-29 07:49:27', '2019-01-29 07:49:27'),
	(11, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36', '2019-01-30 08:39:25', '2019-01-30 08:39:25'),
	(12, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36', '2019-01-30 09:36:57', '2019-01-30 09:36:57'),
	(13, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36', '2019-02-10 08:21:27', '2019-02-10 08:21:27'),
	(14, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36', '2019-02-10 08:22:36', '2019-02-10 08:22:36'),
	(15, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36', '2019-02-11 07:11:09', '2019-02-11 07:11:09'),
	(16, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36', '2019-02-11 07:11:30', '2019-02-11 07:11:30'),
	(17, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.109 Safari/537.36', '2019-02-16 09:26:04', '2019-02-16 09:26:04'),
	(18, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.109 Safari/537.36', '2019-02-16 09:36:15', '2019-02-16 09:36:15'),
	(19, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.109 Safari/537.36', '2019-02-19 01:06:49', '2019-02-19 01:06:49'),
	(20, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.109 Safari/537.36', '2019-02-19 01:07:23', '2019-02-19 01:07:23'),
	(21, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.109 Safari/537.36', '2019-02-22 21:17:20', '2019-02-22 21:17:20'),
	(22, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.109 Safari/537.36', '2019-02-23 03:33:35', '2019-02-23 03:33:35'),
	(23, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.109 Safari/537.36', '2019-02-23 07:39:09', '2019-02-23 07:39:09'),
	(24, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.109 Safari/537.36', '2019-02-23 08:13:32', '2019-02-23 08:13:32'),
	(25, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.109 Safari/537.36', '2019-02-23 19:45:45', '2019-02-23 19:45:45'),
	(26, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.109 Safari/537.36', '2019-02-23 20:21:14', '2019-02-23 20:21:14'),
	(27, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.109 Safari/537.36', '2019-02-24 01:58:29', '2019-02-24 01:58:29'),
	(28, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.109 Safari/537.36', '2019-02-24 02:08:26', '2019-02-24 02:08:26'),
	(29, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.109 Safari/537.36', '2019-02-24 04:38:34', '2019-02-24 04:38:34'),
	(30, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.109 Safari/537.36', '2019-02-24 08:19:38', '2019-02-24 08:19:38'),
	(31, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.109 Safari/537.36', '2019-02-25 09:05:18', '2019-02-25 09:05:18'),
	(32, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.119 Safari/537.36', '2019-02-27 08:21:48', '2019-02-27 08:21:48'),
	(33, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.119 Safari/537.36', '2019-02-28 07:12:15', '2019-02-28 07:12:15'),
	(34, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.119 Safari/537.36', '2019-02-28 17:27:30', '2019-02-28 17:27:30'),
	(35, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.119 Safari/537.36', '2019-03-01 07:35:02', '2019-03-01 07:35:02'),
	(36, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.119 Safari/537.36', '2019-03-01 09:09:44', '2019-03-01 09:09:44'),
	(37, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.119 Safari/537.36', '2019-03-03 02:05:00', '2019-03-03 02:05:00'),
	(38, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.119 Safari/537.36', '2019-03-03 02:38:49', '2019-03-03 02:38:49'),
	(39, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.119 Safari/537.36', '2019-03-03 06:55:08', '2019-03-03 06:55:08'),
	(40, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.119 Safari/537.36', '2019-03-04 02:39:24', '2019-03-04 02:39:24'),
	(41, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.119 Safari/537.36', '2019-03-04 04:15:26', '2019-03-04 04:15:26'),
	(42, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.119 Safari/537.36', '2019-03-05 07:21:39', '2019-03-05 07:21:39'),
	(43, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.119 Safari/537.36', '2019-03-05 08:09:19', '2019-03-05 08:09:19'),
	(44, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.119 Safari/537.36', '2019-03-05 10:17:06', '2019-03-05 10:17:06'),
	(45, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.119 Safari/537.36', '2019-03-05 23:09:06', '2019-03-05 23:09:06'),
	(46, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.119 Safari/537.36', '2019-03-05 23:09:19', '2019-03-05 23:09:19'),
	(47, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.119 Safari/537.36', '2019-03-06 00:56:43', '2019-03-06 00:56:43'),
	(48, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.119 Safari/537.36', '2019-03-06 08:28:04', '2019-03-06 08:28:04'),
	(49, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.119 Safari/537.36', '2019-03-06 08:28:39', '2019-03-06 08:28:39'),
	(50, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.119 Safari/537.36', '2019-03-07 06:40:10', '2019-03-07 06:40:10'),
	(51, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.119 Safari/537.36', '2019-03-07 06:44:06', '2019-03-07 06:44:06'),
	(52, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) coc_coc_browser/77.0.126 Chrome/71.0.3578.126 Safari/537.36', '2019-03-07 11:46:34', '2019-03-07 11:46:34'),
	(53, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.119 Safari/537.36', '2019-03-07 13:47:32', '2019-03-07 13:47:32'),
	(54, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-08 13:24:20', '2019-03-08 13:24:20'),
	(55, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-09 01:10:34', '2019-03-09 01:10:34'),
	(56, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-09 01:13:38', '2019-03-09 01:13:38'),
	(57, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-10 09:46:05', '2019-03-10 09:46:05'),
	(58, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-10 10:44:55', '2019-03-10 10:44:55'),
	(59, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-10 11:01:22', '2019-03-10 11:01:22'),
	(60, 27, NULL, 'abcn@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-10 14:55:34', '2019-03-10 14:55:34'),
	(61, 27, NULL, 'abcn@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-10 14:56:23', '2019-03-10 14:56:23'),
	(62, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-10 14:57:24', '2019-03-10 14:57:24'),
	(63, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-10 14:57:40', '2019-03-10 14:57:40'),
	(64, 27, NULL, 'abcn@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-10 14:57:51', '2019-03-10 14:57:51'),
	(65, 27, NULL, 'abcn@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-10 15:03:33', '2019-03-10 15:03:33'),
	(66, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-11 09:04:02', '2019-03-11 09:04:02'),
	(67, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-11 10:30:55', '2019-03-11 10:30:55'),
	(68, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-12 13:30:50', '2019-03-12 13:30:50'),
	(69, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-12 15:51:40', '2019-03-12 15:51:40'),
	(70, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-13 09:03:02', '2019-03-13 09:03:02'),
	(71, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-13 09:04:34', '2019-03-13 09:04:34'),
	(72, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-16 16:11:04', '2019-03-16 16:11:04'),
	(73, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-16 17:37:10', '2019-03-16 17:37:10'),
	(74, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-17 02:33:10', '2019-03-17 02:33:10'),
	(75, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-17 07:19:18', '2019-03-17 07:19:18'),
	(76, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-17 07:25:33', '2019-03-17 07:25:33'),
	(77, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-17 09:51:21', '2019-03-17 09:51:21'),
	(78, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-17 15:41:49', '2019-03-17 15:41:49'),
	(79, 26, NULL, 'baoanh@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-17 15:59:05', '2019-03-17 15:59:05'),
	(80, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-18 12:22:04', '2019-03-18 12:22:04'),
	(81, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-18 15:35:51', '2019-03-18 15:35:51'),
	(82, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-20 12:07:14', '2019-03-20 12:07:14'),
	(83, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-20 13:04:11', '2019-03-20 13:04:11'),
	(84, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-20 15:29:27', '2019-03-20 15:29:27'),
	(85, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-20 17:28:00', '2019-03-20 17:28:00'),
	(86, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-21 15:13:52', '2019-03-21 15:13:52'),
	(87, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-21 15:34:33', '2019-03-21 15:34:33'),
	(88, 26, '0988888888', 'baoanh@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) coc_coc_browser/77.0.126 Chrome/71.0.3578.126 Safari/537.36', '2019-03-21 16:44:42', '2019-03-21 16:44:42'),
	(89, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36', '2019-03-22 18:45:25', '2019-03-22 18:45:25'),
	(90, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36', '2019-03-23 16:45:12', '2019-03-23 16:45:12'),
	(91, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36', '2019-03-23 17:37:27', '2019-03-23 17:37:27'),
	(92, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36', '2019-03-24 01:52:19', '2019-03-24 01:52:19'),
	(93, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36', '2019-03-24 03:32:23', '2019-03-24 03:32:23'),
	(94, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36', '2019-03-24 07:07:36', '2019-03-24 07:07:36'),
	(95, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36', '2019-03-24 14:20:45', '2019-03-24 14:20:45'),
	(96, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-26 03:42:01', '2019-03-26 03:42:01'),
	(97, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-26 07:04:43', '2019-03-26 07:04:43'),
	(98, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-28 07:04:38', '2019-03-28 07:04:38'),
	(99, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36', '2019-03-29 12:19:18', '2019-03-29 12:19:18'),
	(100, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36', '2019-04-01 07:27:33', '2019-04-01 07:27:33'),
	(101, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36', '2019-04-01 14:03:16', '2019-04-01 14:03:16'),
	(102, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36', '2019-04-01 16:44:15', '2019-04-01 16:44:15'),
	(103, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36', '2019-04-02 13:25:06', '2019-04-02 13:25:06'),
	(104, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36', '2019-04-02 18:14:13', '2019-04-02 18:14:13'),
	(105, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36', '2019-04-03 02:19:06', '2019-04-03 02:19:06'),
	(106, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36', '2019-04-03 06:13:32', '2019-04-03 06:13:32'),
	(107, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36', '2019-04-03 10:32:08', '2019-04-03 10:32:08'),
	(108, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36', '2019-04-03 10:52:01', '2019-04-03 10:52:01'),
	(109, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36', '2019-04-04 11:45:57', '2019-04-04 11:45:57'),
	(110, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36', '2019-04-04 16:22:24', '2019-04-04 16:22:24'),
	(111, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36', '2019-04-05 10:22:48', '2019-04-05 10:22:48'),
	(112, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36', '2019-04-05 17:42:28', '2019-04-05 17:42:28'),
	(113, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36', '2019-04-07 06:51:14', '2019-04-07 06:51:14'),
	(114, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36', '2019-04-07 10:05:55', '2019-04-07 10:05:55'),
	(115, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36', '2019-04-07 12:24:48', '2019-04-07 12:24:48'),
	(116, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36', '2019-04-07 13:42:58', '2019-04-07 13:42:58'),
	(117, 26, '0988888888', 'baoanh@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36', '2019-04-08 16:40:29', '2019-04-08 16:40:29'),
	(118, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36', '2019-04-08 17:05:19', '2019-04-08 17:05:19'),
	(119, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36', '2019-04-09 15:24:40', '2019-04-09 15:24:40'),
	(120, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36', '2019-04-09 15:24:56', '2019-04-09 15:24:56'),
	(121, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36', '2019-04-10 06:39:50', '2019-04-10 06:39:50'),
	(122, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36', '2019-04-10 06:41:44', '2019-04-10 06:41:44'),
	(123, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36', '2019-04-10 16:16:34', '2019-04-10 16:16:34'),
	(124, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36', '2019-04-10 16:18:49', '2019-04-10 16:18:49'),
	(125, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '2019-04-12 10:39:28', '2019-04-12 10:39:28'),
	(126, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '2019-04-12 10:47:12', '2019-04-12 10:47:12'),
	(127, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '2019-04-13 04:58:15', '2019-04-13 04:58:15'),
	(128, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '2019-04-14 03:42:09', '2019-04-14 03:42:09'),
	(129, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '2019-04-14 03:50:13', '2019-04-14 03:50:13'),
	(130, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '2019-04-14 13:31:48', '2019-04-14 13:31:48'),
	(131, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '2019-04-15 15:14:39', '2019-04-15 15:14:39'),
	(132, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '2019-04-16 04:10:00', '2019-04-16 04:10:00'),
	(133, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '2019-04-16 18:12:38', '2019-04-16 18:12:38'),
	(134, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '2019-04-17 10:53:38', '2019-04-17 10:53:38'),
	(135, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '2019-04-18 04:21:27', '2019-04-18 04:21:27'),
	(136, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '2019-04-18 09:11:24', '2019-04-18 09:11:24'),
	(137, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '2019-04-18 14:12:41', '2019-04-18 14:12:41'),
	(138, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '2019-04-18 16:20:34', '2019-04-18 16:20:34'),
	(139, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '2019-04-19 08:33:35', '2019-04-19 08:33:35'),
	(140, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '2019-04-19 14:06:11', '2019-04-19 14:06:11'),
	(141, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '2019-04-20 08:42:44', '2019-04-20 08:42:44'),
	(142, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '2019-04-20 11:18:33', '2019-04-20 11:18:33'),
	(143, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '2019-04-20 15:24:30', '2019-04-20 15:24:30'),
	(144, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '2019-04-20 17:19:19', '2019-04-20 17:19:19'),
	(145, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '2019-04-21 04:55:22', '2019-04-21 04:55:22'),
	(146, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '2019-04-21 05:34:02', '2019-04-21 05:34:02'),
	(147, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '2019-04-21 14:14:44', '2019-04-21 14:14:44'),
	(148, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '2019-04-23 05:45:36', '2019-04-23 05:45:36'),
	(149, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '2019-04-23 06:20:49', '2019-04-23 06:20:49'),
	(150, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '2019-04-24 12:07:31', '2019-04-24 12:07:31'),
	(151, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '2019-04-24 12:50:52', '2019-04-24 12:50:52'),
	(152, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '2019-04-24 15:10:19', '2019-04-24 15:10:19'),
	(153, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '2019-04-25 17:13:39', '2019-04-25 17:13:39'),
	(154, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '2019-04-25 17:22:04', '2019-04-25 17:22:04'),
	(155, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.108 Safari/537.36', '2019-04-26 11:09:21', '2019-04-26 11:09:21'),
	(156, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.108 Safari/537.36', '2019-04-26 11:12:31', '2019-04-26 11:12:31'),
	(157, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.108 Safari/537.36', '2019-04-26 15:45:39', '2019-04-26 15:45:39'),
	(158, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.108 Safari/537.36', '2019-04-27 01:40:36', '2019-04-27 01:40:36'),
	(159, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.108 Safari/537.36', '2019-04-27 05:50:14', '2019-04-27 05:50:14'),
	(160, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36', '2019-05-01 15:09:58', '2019-05-01 15:09:58'),
	(161, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36', '2019-05-02 18:04:17', '2019-05-02 18:04:17'),
	(162, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '2019-05-03 05:03:48', '2019-05-03 05:03:48'),
	(163, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '2019-05-04 04:12:18', '2019-05-04 04:12:18'),
	(164, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '2019-05-04 04:12:57', '2019-05-04 04:12:57'),
	(165, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36', '2019-05-05 03:09:43', '2019-05-05 03:09:43'),
	(166, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36', '2019-05-05 03:10:30', '2019-05-05 03:10:30'),
	(167, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36', '2019-05-06 08:57:57', '2019-05-06 08:57:57'),
	(168, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36', '2019-05-07 16:42:01', '2019-05-07 16:42:01'),
	(169, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36', '2019-05-08 15:47:12', '2019-05-08 15:47:12'),
	(170, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36', '2019-05-10 16:59:39', '2019-05-10 16:59:39'),
	(171, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36', '2019-05-11 17:09:28', '2019-05-11 17:09:28'),
	(172, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36', '2019-05-11 17:42:08', '2019-05-11 17:42:08'),
	(173, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36', '2019-05-12 01:24:52', '2019-05-12 01:24:52'),
	(174, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36', '2019-05-12 15:43:40', '2019-05-12 15:43:40'),
	(175, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36', '2019-05-13 07:51:28', '2019-05-13 07:51:28'),
	(176, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36', '2019-05-13 08:30:57', '2019-05-13 08:30:57'),
	(177, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36', '2019-05-14 02:29:05', '2019-05-14 02:29:05'),
	(178, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36', '2019-05-14 05:56:39', '2019-05-14 05:56:39'),
	(179, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36', '2019-05-16 02:06:39', '2019-05-16 02:06:39'),
	(180, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36', '2019-05-16 02:30:56', '2019-05-16 02:30:56'),
	(181, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36', '2019-05-16 03:18:47', '2019-05-16 03:18:47'),
	(182, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36', '2019-05-16 09:07:33', '2019-05-16 09:07:33'),
	(183, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36', '2019-05-16 09:50:42', '2019-05-16 09:50:42'),
	(184, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36', '2019-05-17 01:53:05', '2019-05-17 01:53:05'),
	(185, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36', '2019-05-17 03:09:51', '2019-05-17 03:09:51'),
	(186, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36', '2019-05-17 06:47:22', '2019-05-17 06:47:22'),
	(187, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.157 Safari/537.36', '2019-05-17 16:51:44', '2019-05-17 16:51:44'),
	(188, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.157 Safari/537.36', '2019-05-18 02:43:19', '2019-05-18 02:43:19'),
	(189, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.157 Safari/537.36', '2019-05-18 03:03:21', '2019-05-18 03:03:21'),
	(190, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.157 Safari/537.36', '2019-05-19 11:35:38', '2019-05-19 11:35:38'),
	(191, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.157 Safari/537.36', '2019-05-20 06:20:42', '2019-05-20 06:20:42'),
	(192, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.157 Safari/537.36', '2019-05-20 06:31:12', '2019-05-20 06:31:12'),
	(193, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.157 Safari/537.36', '2019-05-21 02:17:52', '2019-05-21 02:17:52'),
	(194, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.157 Safari/537.36', '2019-05-21 04:38:28', '2019-05-21 04:38:28'),
	(195, 26, '0988888888', 'baoanh@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.157 Safari/537.36', '2019-05-21 04:38:51', '2019-05-21 04:38:51'),
	(196, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.157 Safari/537.36', '2019-05-21 04:39:10', '2019-05-21 04:39:10'),
	(197, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.157 Safari/537.36', '2019-05-21 08:29:36', '2019-05-21 08:29:36'),
	(198, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.157 Safari/537.36', '2019-05-21 08:32:27', '2019-05-21 08:32:27'),
	(199, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.157 Safari/537.36', '2019-05-21 08:34:24', '2019-05-21 08:34:24'),
	(200, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.157 Safari/537.36', '2019-05-21 08:36:57', '2019-05-21 08:36:57'),
	(201, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.157 Safari/537.36', '2019-05-22 10:28:44', '2019-05-22 10:28:44'),
	(202, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.157 Safari/537.36', '2019-05-23 03:54:37', '2019-05-23 03:54:37'),
	(203, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.157 Safari/537.36', '2019-05-23 04:07:43', '2019-05-23 04:07:43'),
	(204, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36', '2019-05-24 04:27:25', '2019-05-24 04:27:25'),
	(205, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36', '2019-05-24 04:43:14', '2019-05-24 04:43:14'),
	(206, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36', '2019-05-28 03:20:15', '2019-05-28 03:20:15'),
	(207, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36', '2019-05-28 05:45:04', '2019-05-28 05:45:04'),
	(208, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36', '2019-05-29 02:03:29', '2019-05-29 02:03:29'),
	(209, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36', '2019-05-29 08:14:24', '2019-05-29 08:14:24'),
	(210, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36', '2019-05-30 02:34:32', '2019-05-30 02:34:32'),
	(211, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36', '2019-05-30 02:34:58', '2019-05-30 02:34:58'),
	(212, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36', '2019-05-30 09:39:25', '2019-05-30 09:39:25'),
	(213, 26, '0988888888', 'baoanh@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36', '2019-05-30 09:39:55', '2019-05-30 09:39:55'),
	(214, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36', '2019-06-02 02:34:10', '2019-06-02 02:34:10'),
	(215, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36', '2019-06-02 10:59:49', '2019-06-02 10:59:49'),
	(216, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36', '2019-06-02 15:57:58', '2019-06-02 15:57:58'),
	(217, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36', '2019-06-06 06:40:27', '2019-06-06 06:40:27'),
	(218, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36', '2019-06-06 07:11:25', '2019-06-06 07:11:25'),
	(219, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.80 Safari/537.36', '2019-06-06 14:32:30', '2019-06-06 14:32:30'),
	(220, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.80 Safari/537.36', '2019-06-06 15:24:50', '2019-06-06 15:24:50'),
	(221, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.80 Safari/537.36', '2019-06-06 23:49:45', '2019-06-06 23:49:45'),
	(222, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.80 Safari/537.36', '2019-06-07 11:09:32', '2019-06-07 11:09:32'),
	(223, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.80 Safari/537.36', '2019-06-09 02:05:43', '2019-06-09 02:05:43'),
	(224, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.80 Safari/537.36', '2019-06-09 02:18:19', '2019-06-09 02:18:19'),
	(225, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.80 Safari/537.36', '2019-06-09 02:28:59', '2019-06-09 02:28:59'),
	(226, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.80 Safari/537.36', '2019-06-09 10:21:53', '2019-06-09 10:21:53'),
	(227, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.80 Safari/537.36', '2019-06-09 10:22:11', '2019-06-09 10:22:11'),
	(228, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.80 Safari/537.36', '2019-06-09 15:30:52', '2019-06-09 15:30:52'),
	(229, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.90 Safari/537.36', '2019-06-17 11:47:28', '2019-06-17 11:47:28'),
	(230, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.90 Safari/537.36', '2019-06-17 13:47:32', '2019-06-17 13:47:32'),
	(231, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36', '2019-06-18 06:42:32', '2019-06-18 06:42:32'),
	(232, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.90 Safari/537.36', '2019-06-18 11:46:33', '2019-06-18 11:46:33'),
	(233, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.90 Safari/537.36', '2019-06-18 11:48:56', '2019-06-18 11:48:56'),
	(234, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36', '2019-06-21 16:00:25', '2019-06-21 16:00:25'),
	(235, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36', '2019-06-22 15:09:22', '2019-06-22 15:09:22'),
	(236, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36', '2019-06-25 14:21:01', '2019-06-25 14:21:01'),
	(237, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36', '2019-06-26 10:48:48', '2019-06-26 10:48:48'),
	(238, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36', '2019-06-26 10:49:32', '2019-06-26 10:49:32'),
	(239, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36', '2019-06-27 15:03:29', '2019-06-27 15:03:29'),
	(240, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36', '2019-06-29 13:07:23', '2019-06-29 13:07:23'),
	(241, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36', '2019-06-29 13:08:59', '2019-06-29 13:08:59'),
	(242, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36', '2019-06-30 05:54:20', '2019-06-30 05:54:20'),
	(243, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36', '2019-07-01 13:52:16', '2019-07-01 13:52:16'),
	(244, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36', '2019-07-03 15:00:37', '2019-07-03 15:00:37'),
	(245, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36', '2019-07-03 15:16:07', '2019-07-03 15:16:07'),
	(246, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36', '2019-07-05 15:39:10', '2019-07-05 15:39:10'),
	(247, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36', '2019-07-06 17:18:34', '2019-07-06 17:18:34'),
	(248, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36', '2019-07-07 09:27:18', '2019-07-07 09:27:18'),
	(249, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36', '2019-07-07 11:01:15', '2019-07-07 11:01:15'),
	(250, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36', '2019-07-11 16:37:47', '2019-07-11 16:37:47'),
	(251, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36', '2019-07-15 16:59:13', '2019-07-15 16:59:13'),
	(252, 28, NULL, 'support4@nencer.net', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', '2019-07-17 16:08:40', '2019-07-17 16:08:40'),
	(253, 31, NULL, 'hotronet10@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', '2019-07-19 14:06:30', '2019-07-19 14:06:30'),
	(254, 31, NULL, 'hotronet10@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', '2019-07-19 14:07:07', '2019-07-19 14:07:07'),
	(255, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', '2019-07-25 16:53:10', '2019-07-25 16:53:10'),
	(256, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', '2019-07-26 11:24:07', '2019-07-26 11:24:07'),
	(257, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', '2019-07-27 03:44:48', '2019-07-27 03:44:48'),
	(258, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', '2019-07-27 07:49:14', '2019-07-27 07:49:14'),
	(259, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', '2019-07-27 14:45:31', '2019-07-27 14:45:31'),
	(260, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', '2019-07-28 02:27:48', '2019-07-28 02:27:48'),
	(261, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', '2019-07-28 02:34:04', '2019-07-28 02:34:04'),
	(262, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', '2019-07-30 15:38:29', '2019-07-30 15:38:29'),
	(263, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', '2019-07-30 15:43:00', '2019-07-30 15:43:00'),
	(264, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', '2019-07-30 15:44:11', '2019-07-30 15:44:11'),
	(265, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', '2019-07-30 16:00:02', '2019-07-30 16:00:02'),
	(266, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', '2019-07-31 12:15:12', '2019-07-31 12:15:12'),
	(267, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', '2019-08-02 10:09:40', '2019-08-02 10:09:40'),
	(268, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', '2019-08-02 10:11:16', '2019-08-02 10:11:16'),
	(269, 25, '0943793986', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', '2019-08-04 16:49:10', '2019-08-04 16:49:10'),
	(270, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', '2019-08-05 15:45:09', '2019-08-05 15:45:09'),
	(271, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36', '2019-08-09 15:10:34', '2019-08-09 15:10:34'),
	(272, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36', '2019-08-11 16:46:06', '2019-08-11 16:46:06'),
	(273, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36', '2019-08-12 15:35:09', '2019-08-12 15:35:09'),
	(274, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36', '2019-08-13 11:13:14', '2019-08-13 11:13:14'),
	(275, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36', '2019-08-13 15:43:11', '2019-08-13 15:43:11'),
	(276, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36', '2019-08-14 05:40:41', '2019-08-14 05:40:41'),
	(277, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36', '2019-08-15 07:02:25', '2019-08-15 07:02:25'),
	(278, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36', '2019-08-25 16:30:54', '2019-08-25 16:30:54'),
	(279, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', '2019-08-27 13:55:09', '2019-08-27 13:55:09'),
	(280, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', '2019-08-27 14:00:18', '2019-08-27 14:00:18'),
	(281, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', '2019-08-27 14:08:31', '2019-08-27 14:08:31'),
	(282, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', '2019-08-27 15:22:46', '2019-08-27 15:22:46'),
	(283, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36', '2019-08-27 20:42:40', '2019-08-27 20:42:40'),
	(284, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36', '2019-08-27 21:26:39', '2019-08-27 21:26:39'),
	(285, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', '2019-08-28 11:11:44', '2019-08-28 11:11:44'),
	(286, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36', '2019-08-28 18:51:52', '2019-08-28 18:51:52'),
	(287, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36', '2019-08-29 00:00:38', '2019-08-29 00:00:38'),
	(288, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36', '2019-08-29 00:26:16', '2019-08-29 00:26:16'),
	(289, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', '2019-08-29 08:16:17', '2019-08-29 08:16:17'),
	(290, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', '2019-08-29 08:29:38', '2019-08-29 08:29:38'),
	(291, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', '2019-08-29 08:29:58', '2019-08-29 08:29:58'),
	(292, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', '2019-08-29 08:30:08', '2019-08-29 08:30:08'),
	(293, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', '2019-08-29 08:30:18', '2019-08-29 08:30:18'),
	(294, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', '2019-08-29 08:32:32', '2019-08-29 08:32:32'),
	(295, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', '2019-08-29 22:47:19', '2019-08-29 22:47:19'),
	(296, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', '2019-08-30 20:29:45', '2019-08-30 20:29:45'),
	(297, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', '2019-08-30 20:50:13', '2019-08-30 20:50:13'),
	(298, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', '2019-08-30 21:17:41', '2019-08-30 21:17:41'),
	(299, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', '2019-08-30 21:21:10', '2019-08-30 21:21:10'),
	(300, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', '2019-08-30 22:23:55', '2019-08-30 22:23:55'),
	(301, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', '2019-08-31 13:17:41', '2019-08-31 13:17:41'),
	(302, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', '2019-08-31 21:49:49', '2019-08-31 21:49:49'),
	(303, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', '2019-09-01 22:49:27', '2019-09-01 22:49:27'),
	(304, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', '2019-09-02 09:11:21', '2019-09-02 09:11:21'),
	(305, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', '2019-09-05 10:19:07', '2019-09-05 10:19:07'),
	(306, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', '2019-09-06 09:15:25', '2019-09-06 09:15:25'),
	(307, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'PostmanRuntime/7.15.2', '2019-09-06 14:07:59', '2019-09-06 14:07:59'),
	(308, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'PostmanRuntime/7.15.2', '2019-09-06 14:08:37', '2019-09-06 14:08:37'),
	(309, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'PostmanRuntime/7.15.2', '2019-09-06 14:10:22', '2019-09-06 14:10:22'),
	(310, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'PostmanRuntime/7.15.2', '2019-09-06 14:16:30', '2019-09-06 14:16:30'),
	(311, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'PostmanRuntime/7.15.2', '2019-09-06 15:20:56', '2019-09-06 15:20:56'),
	(312, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'PostmanRuntime/7.15.2', '2019-09-06 15:23:34', '2019-09-06 15:23:34'),
	(313, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'PostmanRuntime/7.15.2', '2019-09-06 15:25:02', '2019-09-06 15:25:02'),
	(314, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'PostmanRuntime/7.15.2', '2019-09-06 15:26:10', '2019-09-06 15:26:10'),
	(315, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'PostmanRuntime/7.15.2', '2019-09-06 15:41:21', '2019-09-06 15:41:21'),
	(316, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'PostmanRuntime/7.15.2', '2019-09-06 15:48:13', '2019-09-06 15:48:13'),
	(317, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'PostmanRuntime/7.15.2', '2019-09-06 15:51:09', '2019-09-06 15:51:09'),
	(318, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'PostmanRuntime/7.15.2', '2019-09-06 16:06:47', '2019-09-06 16:06:47'),
	(319, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', '2019-09-11 09:18:44', '2019-09-11 09:18:44'),
	(320, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', '2019-09-11 09:31:11', '2019-09-11 09:31:11'),
	(321, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', '2019-09-11 12:11:29', '2019-09-11 12:11:29'),
	(322, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', '2019-09-11 18:06:24', '2019-09-11 18:06:24'),
	(323, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', '2019-09-11 18:15:02', '2019-09-11 18:15:02'),
	(324, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', '2019-09-14 22:15:08', '2019-09-14 22:15:08'),
	(325, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', '2019-09-17 13:47:52', '2019-09-17 13:47:52'),
	(326, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', '2019-09-17 21:01:11', '2019-09-17 21:01:11'),
	(327, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', '2019-09-17 21:15:12', '2019-09-17 21:15:12'),
	(328, 31, NULL, 'hotronet3@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', '2019-09-19 23:21:02', '2019-09-19 23:21:02'),
	(329, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', '2019-09-19 23:26:54', '2019-09-19 23:26:54'),
	(330, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'PostmanRuntime/7.17.1', '2019-09-19 23:54:50', '2019-09-19 23:54:50'),
	(331, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', '2019-09-22 14:03:28', '2019-09-22 14:03:28'),
	(332, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', '2019-09-22 16:02:26', '2019-09-22 16:02:26'),
	(333, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', '2019-09-25 20:37:24', '2019-09-25 20:37:24'),
	(334, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', '2019-09-26 23:21:52', '2019-09-26 23:21:52'),
	(335, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', '2019-09-27 14:59:24', '2019-09-27 14:59:24'),
	(336, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', '2019-09-27 19:37:46', '2019-09-27 19:37:46'),
	(337, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', '2019-09-27 19:45:32', '2019-09-27 19:45:32'),
	(338, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', '2019-09-27 19:45:45', '2019-09-27 19:45:45'),
	(339, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', '2019-09-27 20:05:56', '2019-09-27 20:05:56'),
	(340, 30, '0956856229', NULL, '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', '2019-09-27 20:10:48', '2019-09-27 20:10:48'),
	(341, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', '2019-09-28 22:47:49', '2019-09-28 22:47:49'),
	(342, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', '2019-09-28 23:11:30', '2019-09-28 23:11:30'),
	(343, 1, '0943793985', 'support@nencer.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', '2019-09-29 14:31:58', '2019-09-29 14:31:58'),
	(344, 25, '0943793984', 'hotronet@gmail.com', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', '2019-09-29 15:11:19', '2019-09-29 15:11:19');
/*!40000 ALTER TABLE `auth_logs` ENABLE KEYS */;

-- Dumping structure for table core.balance_logs
CREATE TABLE IF NOT EXISTS `balance_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `balance_user` double NOT NULL,
  `balance_admin` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table core.balance_logs: ~0 rows (approximately)
/*!40000 ALTER TABLE `balance_logs` DISABLE KEYS */;
INSERT INTO `balance_logs` (`id`, `balance_user`, `balance_admin`, `created_at`, `updated_at`) VALUES
	(1, 55387238, 9944357762, '2019-03-28 07:39:27', '2019-03-28 07:39:27');
/*!40000 ALTER TABLE `balance_logs` ENABLE KEYS */;

-- Dumping structure for table core.blocks
CREATE TABLE IF NOT EXISTS `blocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `key` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `require_login` int(11) NOT NULL DEFAULT '0',
  `position` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `widget` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort` varchar(255) COLLATE utf8_unicode_ci DEFAULT '0',
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table core.blocks: ~0 rows (approximately)
/*!40000 ALTER TABLE `blocks` DISABLE KEYS */;
INSERT INTO `blocks` (`id`, `name`, `key`, `lang`, `require_login`, `position`, `widget`, `url`, `sort`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'Khách phản hồi', 'cusfeedback', 'vi', 0, 'homecenter', 'Html', NULL, '0', '1', '2019-09-02 09:43:15', '2019-09-02 09:43:15');
/*!40000 ALTER TABLE `blocks` ENABLE KEYS */;

-- Dumping structure for table core.block_content
CREATE TABLE IF NOT EXISTS `block_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `block` int(11) NOT NULL COMMENT 'Dùng để nhóm các block',
  `lang` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Fa icon',
  `info` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `sort` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table core.block_content: ~2 rows (approximately)
/*!40000 ALTER TABLE `block_content` DISABLE KEYS */;
INSERT INTO `block_content` (`id`, `block`, `lang`, `title`, `image`, `icon`, `info`, `data`, `url`, `status`, `sort`, `created_at`, `updated_at`) VALUES
	(2, 1, 'vi', 'Nguyễn Thị Tâm', '/storage/userfiles/images/thecao/the-viettel.png', NULL, 'Lãnh đạo Trung Quốc, Nga, Triều Tiên, Cuba và các nước ASEAN gửi điện, thư mừng 74 năm Quốc khánh nước CHXHCN Việt Nam.', '["Trong \\u0111i\\u1ec7n m\\u1eebng Qu\\u1ed1c kh\\u00e1nh Vi\\u1ec7t Nam (2\\/9\\/1945 - 2\\/9\\/2019), Ch\\u1ee7 t\\u1ecbch Trung Qu\\u1ed1c T\\u1eadp C\\u1eadn B\\u00ecnh \\u0111\\u00e1nh gi\\u00e1 cao th\\u00e0nh t\\u1ef1u Vi\\u1ec7t Nam \\u0111\\u1ea1t \\u0111\\u01b0\\u1ee3c trong th\\u1eddi gian qua, kh\\u1eb3ng \\u0111\\u1ecbnh coi tr\\u1ecdng ph\\u00e1t tri\\u1ec3n quan h\\u1ec7 v\\u1edbi Vi\\u1ec7t Nam, theo th\\u00f4ng c\\u00e1o c\\u1ee7a B\\u1ed9 Ngo\\u1ea1i giao."]', NULL, 1, 1, '2019-09-02 16:40:25', '2019-09-02 16:40:25'),
	(3, 1, 'vi', 'Phạm Tuần Tài', '/storage/userfiles/images/thecao/the-scoin.jpg', NULL, 'Vai trò ngày càng tăng của lực lượng chống khủng bố Trung Quốc', '["Ch\\u1ee7 t\\u1ecbch Trung Qu\\u1ed1c s\\u1eb5n s\\u00e0ng th\\u00fac \\u0111\\u1ea9y quan h\\u1ec7 \\u0111\\u1ed1i t\\u00e1c h\\u1ee3p t\\u00e1c chi\\u1ebfn l\\u01b0\\u1ee3c to\\u00e0n di\\u1ec7n v\\u1edbi Vi\\u1ec7t Nam ph\\u00e1t tri\\u1ec3n \\u1ed5n \\u0111\\u1ecbnh, b\\u1ec1n v\\u1eefng, c\\u00f9ng h\\u01b0\\u1edbng t\\u1edbi k\\u1ef7 ni\\u1ec7m 70 n\\u0103m thi\\u1ebft l\\u1eadp quan h\\u1ec7 ngo\\u1ea1i giao hai n\\u01b0\\u1edbc trong n\\u0103m t\\u1edbi."]', NULL, 1, 2, '2019-09-02 16:41:28', '2019-09-02 16:41:28');
/*!40000 ALTER TABLE `block_content` ENABLE KEYS */;

-- Dumping structure for table core.cart
CREATE TABLE IF NOT EXISTS `cart` (
  `identifier` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instance` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`identifier`,`instance`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table core.cart: ~0 rows (approximately)
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;

-- Dumping structure for table core.catalogs
CREATE TABLE IF NOT EXISTS `catalogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lang` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cover` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Cover phto',
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `_lft` int(10) unsigned DEFAULT NULL,
  `_rgt` int(10) unsigned DEFAULT NULL,
  `sort` int(10) DEFAULT '0',
  `status` int(10) NOT NULL DEFAULT '1',
  `hidden` int(10) NOT NULL DEFAULT '0',
  `featured` int(10) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Nested set catalog';

-- Dumping data for table core.catalogs: ~9 rows (approximately)
/*!40000 ALTER TABLE `catalogs` DISABLE KEYS */;
INSERT INTO `catalogs` (`id`, `name`, `slug`, `lang`, `image`, `cover`, `icon`, `description`, `parent_id`, `_lft`, `_rgt`, `sort`, `status`, `hidden`, `featured`, `created_at`, `updated_at`) VALUES
	(1, 'Thư mục gốc', '', NULL, NULL, NULL, NULL, NULL, NULL, 1, 18, 0, 1, 0, 0, '2019-08-28 11:26:56', '2019-08-28 11:26:56'),
	(3, 'Thẻ điện thoại', 'thedienthoai', 'vi', NULL, NULL, NULL, NULL, 1, 2, 3, 1, 1, 0, 0, '2019-08-28 16:01:39', '2019-08-28 16:01:39'),
	(4, 'Thẻ garena', 'thegarena', 'vi', NULL, NULL, NULL, NULL, 8, 13, 14, 1, 1, 0, 0, '2019-08-28 16:06:46', '2019-09-11 23:36:48'),
	(5, 'tienganh', 'tienganh', 'en', NULL, NULL, NULL, NULL, 1, 4, 5, 1, 1, 0, 0, '2019-08-28 19:03:13', '2019-08-28 19:03:13'),
	(6, 'Thẻ zing', 'the-zing', 'vi', NULL, NULL, NULL, NULL, 8, 7, 12, 1, 1, 0, 0, '2019-09-11 22:57:57', '2019-09-11 23:35:43'),
	(7, 'Thẻ zing 10k', 'the-zing-10k', 'vi', NULL, NULL, NULL, NULL, 6, 8, 9, 1, 1, 0, 0, '2019-09-11 22:58:22', '2019-09-11 22:58:22'),
	(8, 'Thẻ game', 'the-game', 'vi', NULL, NULL, NULL, NULL, 1, 6, 17, 1, 1, 0, 0, '2019-09-11 22:58:40', '2019-09-11 22:58:40'),
	(9, 'Thẻ vcoin', 'the-vcoin', 'vi', NULL, NULL, NULL, NULL, 8, 15, 16, 1, 1, 0, 0, '2019-09-11 22:59:05', '2019-09-11 22:59:05'),
	(10, 'Thẻ zing 20k', 'the-zing-20k', 'vi', NULL, NULL, NULL, NULL, 6, 10, 11, 1, 1, 0, 0, '2019-09-11 22:59:26', '2019-09-11 23:16:27');
/*!40000 ALTER TABLE `catalogs` ENABLE KEYS */;

-- Dumping structure for table core.category
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `parent_id` int(11) DEFAULT '0',
  `sort_order` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT '1',
  `children_count` int(11) DEFAULT '0',
  `custom_layout` tinyint(2) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table core.category: ~2 rows (approximately)
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` (`id`, `name`, `url_key`, `description`, `parent_id`, `sort_order`, `level`, `children_count`, `custom_layout`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'Thẻ bán chạy', 'the-dien-thoai', 'Thẻ điện thoại viettel, thẻ điện thoại mobile, thẻ điện thoại vina...', 0, 1, 1, 0, NULL, 1, '2018-08-06 13:16:41', '2019-01-25 08:16:24'),
	(7, 'Các thẻ khác', 'the-game-online', 'Thẻ game. VNG, VTC,...', 0, 2, 1, 0, NULL, 1, '2018-08-06 13:26:38', '2019-01-25 08:16:40');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;

-- Dumping structure for table core.category_product
CREATE TABLE IF NOT EXISTS `category_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table core.category_product: ~17 rows (approximately)
/*!40000 ALTER TABLE `category_product` DISABLE KEYS */;
INSERT INTO `category_product` (`id`, `category_id`, `product_id`, `product_type`, `sort_order`, `created_at`, `updated_at`) VALUES
	(7, 1, 23, 'softcard', NULL, '2018-08-10 00:50:45', '2018-08-10 00:50:45'),
	(8, 1, 24, 'softcard', NULL, '2018-08-21 09:08:03', '2018-08-21 09:08:03'),
	(9, 1, 25, 'softcard', NULL, '2018-08-28 01:41:21', '2018-08-28 01:41:21'),
	(18, 1, 34, 'softcard', NULL, '2018-12-20 22:29:11', '2018-12-20 22:29:11'),
	(20, 7, 37, 'softcard', NULL, '2018-12-20 22:59:34', '2018-12-20 22:59:34'),
	(21, 7, 38, 'softcard', NULL, '2018-12-21 00:16:39', '2018-12-21 00:16:39'),
	(23, 7, 40, 'softcard', NULL, '2018-12-21 03:39:52', '2018-12-21 03:39:52'),
	(24, 7, 41, 'softcard', NULL, '2018-12-21 04:02:41', '2018-12-21 04:02:41'),
	(25, 7, 27, 'softcard', NULL, '2019-01-25 08:17:27', '2019-01-25 08:17:27'),
	(26, 7, 26, 'softcard', NULL, '2019-01-25 08:17:41', '2019-01-25 08:17:41'),
	(27, 1, 32, 'softcard', NULL, '2019-01-25 08:18:35', '2019-01-25 08:18:35'),
	(28, 1, 31, 'softcard', NULL, '2019-01-25 08:18:44', '2019-01-25 08:18:44'),
	(29, 1, 28, 'softcard', NULL, '2019-01-25 08:19:00', '2019-01-25 08:19:00'),
	(30, 1, 29, 'softcard', NULL, '2019-01-25 08:19:15', '2019-01-25 08:19:15'),
	(31, 1, 30, 'softcard', NULL, '2019-01-25 08:19:46', '2019-01-25 08:19:46'),
	(32, 1, 38, 'softcard', NULL, '2019-01-25 08:21:23', '2019-01-25 08:21:23'),
	(33, 1, 39, 'softcard', NULL, '2019-05-12 17:06:27', '2019-05-12 17:06:27');
/*!40000 ALTER TABLE `category_product` ENABLE KEYS */;

-- Dumping structure for table core.currencies
CREATE TABLE IF NOT EXISTS `currencies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Mã tiền tệ',
  `value` decimal(16,8) NOT NULL COMMENT '1 USD bằng bao nhiêu tiền này',
  `symbol_left` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `symbol_right` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seperator` enum('space','comma','dot') COLLATE utf8mb4_unicode_ci NOT NULL,
  `decimal` tinyint(4) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `fiat` tinyint(1) NOT NULL DEFAULT '1',
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `homepage` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Có cho hiện trên trang chủ hay ko',
  `checksum` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `checksum` (`checksum`),
  KEY `currencies_status_index` (`status`),
  KEY `currencies_hide_index` (`homepage`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table core.currencies: ~3 rows (approximately)
/*!40000 ALTER TABLE `currencies` DISABLE KEYS */;
INSERT INTO `currencies` (`id`, `name`, `code`, `value`, `symbol_left`, `symbol_right`, `seperator`, `decimal`, `status`, `fiat`, `default`, `homepage`, `checksum`, `sort`, `created_at`, `updated_at`) VALUES
	(1, 'Đồng', 'VND', 20000.00000000, NULL, 'đ', 'comma', 0, 1, 1, 1, 1, '44c0d0dc44a0a070f01b1f1c7280e598', 1, '2018-07-25 18:32:10', '2019-05-28 09:06:38'),
	(2, 'Dollars', 'USD', 1.00000000, '$', NULL, 'comma', 2, 1, 1, 0, 1, '20aa8bd0fef9e9f711ffa92c9b7a4d8e', 1, '2018-07-26 14:54:56', '2019-05-28 03:48:37'),
	(3, 'TWD', 'TWD', 0.50000000, NULL, 'twd', 'comma', 0, 1, 1, 0, 0, NULL, 3, '2019-02-23 07:46:18', '2019-02-23 07:46:18');
/*!40000 ALTER TABLE `currencies` ENABLE KEYS */;

-- Dumping structure for table core.currencies_code
CREATE TABLE IF NOT EXISTS `currencies_code` (
  `code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Các mã code của tiền tệ trên thế giới';

-- Dumping data for table core.currencies_code: ~154 rows (approximately)
/*!40000 ALTER TABLE `currencies_code` DISABLE KEYS */;
INSERT INTO `currencies_code` (`code`, `name`) VALUES
	('AED', 'United Arab Emirates Dirham'),
	('AFN', 'Afghanistan Afghani'),
	('ALL', 'Albania Lek'),
	('AMD', 'Armenia Dram'),
	('ANG', 'Netherlands Antilles Guilder'),
	('AOA', 'Angola Kwanza'),
	('ARS', 'Argentina Peso'),
	('AUD', 'Australia Dollar'),
	('AWG', 'Aruba Guilder'),
	('AZN', 'Azerbaijan New Manat'),
	('BBD', 'Barbados Dollar'),
	('BDT', 'Bangladesh Taka'),
	('BGN', 'Bulgaria Lev'),
	('BHD', 'Bahrain Dinar'),
	('BIF', 'Burundi Franc'),
	('BMD', 'Bermuda Dollar'),
	('BND', 'Brunei Darussalam Dollar'),
	('BOB', 'Bolivia Bolíviano'),
	('BRL', 'Brazil Real'),
	('BSD', 'Bahamas Dollar'),
	('BTC', 'Bitcoin'),
	('BTN', 'Bhutan Ngultrum'),
	('BWP', 'Botswana Pula'),
	('BYN', 'Belarus Ruble'),
	('BZD', 'Belize Dollar'),
	('CAD', 'Canada Dollar'),
	('CDF', 'Congo/Kinshasa Franc'),
	('CHF', 'Switzerland Franc'),
	('CLP', 'Chile Peso'),
	('CNY', 'China Yuan Renminbi'),
	('COP', 'Colombia Peso'),
	('CRC', 'Costa Rica Colon'),
	('CUC', 'Cuba Convertible Peso'),
	('CUP', 'Cuba Peso'),
	('CVE', 'Cape Verde Escudo'),
	('CZK', 'Czech Republic Koruna'),
	('DJF', 'Djibouti Franc'),
	('DKK', 'Denmark Krone'),
	('DOP', 'Dominican Republic Peso'),
	('DZD', 'Algeria Dinar'),
	('EGP', 'Egypt Pound'),
	('ERN', 'Eritrea Nakfa'),
	('ETB', 'Ethiopia Birr'),
	('ETH', 'Ethereum'),
	('EUR', 'Euro Member Countries'),
	('FJD', 'Fiji Dollar'),
	('GBP', 'United Kingdom Pound'),
	('GEL', 'Georgia Lari'),
	('GGP', 'Guernsey Pound'),
	('GHS', 'Ghana Cedi'),
	('GIP', 'Gibraltar Pound'),
	('GMD', 'Gambia Dalasi'),
	('GNF', 'Guinea Franc'),
	('GTQ', 'Guatemala Quetzal'),
	('GYD', 'Guyana Dollar'),
	('HKD', 'Hong Kong Dollar'),
	('HNL', 'Honduras Lempira'),
	('HRK', 'Croatia Kuna'),
	('HTG', 'Haiti Gourde'),
	('HUF', 'Hungary Forint'),
	('IDR', 'Indonesia Rupiah'),
	('ILS', 'Israel Shekel'),
	('IMP', 'Isle of Man Pound'),
	('INR', 'India Rupee'),
	('IQD', 'Iraq Dinar'),
	('IRR', 'Iran Rial'),
	('ISK', 'Iceland Krona'),
	('JEP', 'Jersey Pound'),
	('JMD', 'Jamaica Dollar'),
	('JOD', 'Jordan Dinar'),
	('JPY', 'Japan Yen'),
	('KES', 'Kenya Shilling'),
	('KGS', 'Kyrgyzstan Som'),
	('KHR', 'Cambodia Riel'),
	('KMF', 'Comoros Franc'),
	('KPW', 'Korea (North) Won'),
	('KRW', 'Korea (South) Won'),
	('KWD', 'Kuwait Dinar'),
	('KYD', 'Cayman Islands Dollar'),
	('KZT', 'Kazakhstan Tenge'),
	('LAK', 'Laos Kip'),
	('LBP', 'Lebanon Pound'),
	('LKR', 'Sri Lanka Rupee'),
	('LRD', 'Liberia Dollar'),
	('LSL', 'Lesotho Loti'),
	('LTC', 'Litecoin'),
	('LYD', 'Libya Dinar'),
	('MAD', 'Morocco Dirham'),
	('MDL', 'Moldova Leu'),
	('MGA', 'Madagascar Ariary'),
	('MKD', 'Macedonia Denar'),
	('MMK', 'Myanmar (Burma) Kyat'),
	('MNT', 'Mongolia Tughrik'),
	('MOP', 'Macau Pataca'),
	('MRO', 'Mauritania Ouguiya'),
	('MUR', 'Mauritius Rupee'),
	('MWK', 'Malawi Kwacha'),
	('MXN', 'Mexico Peso'),
	('MYR', 'Malaysia Ringgit'),
	('MZN', 'Mozambique Metical'),
	('NAD', 'Namibia Dollar'),
	('NGN', 'Nigeria Naira'),
	('NIO', 'Nicaragua Cordoba'),
	('NOK', 'Norway Krone'),
	('NPR', 'Nepal Rupee'),
	('NZD', 'New Zealand Dollar'),
	('OMR', 'Oman Rial'),
	('PAB', 'Panama Balboa'),
	('PEN', 'Peru Sol'),
	('PGK', 'Papua New Guinea Kina'),
	('PHP', 'Philippines Peso'),
	('PKR', 'Pakistan Rupee'),
	('PLN', 'Poland Zloty'),
	('PYG', 'Paraguay Guarani'),
	('QAR', 'Qatar Riyal'),
	('RON', 'Romania New Leu'),
	('RSD', 'Serbia Dinar'),
	('RUB', 'Russia Ruble'),
	('RWF', 'Rwanda Franc'),
	('SAR', 'Saudi Arabia Riyal'),
	('SCR', 'Seychelles Rupee'),
	('SDG', 'Sudan Pound'),
	('SEK', 'Sweden Krona'),
	('SGD', 'Singapore Dollar'),
	('SHP', 'Saint Helena Pound'),
	('SLL', 'Sierra Leone Leone'),
	('SOS', 'Somalia Shilling'),
	('SPL', 'Seborga Luigino'),
	('SRD', 'Suriname Dollar'),
	('SVC', 'El Salvador Colon'),
	('SYP', 'Syria Pound'),
	('SZL', 'Swaziland Lilangeni'),
	('THB', 'Thailand Baht'),
	('TJS', 'Tajikistan Somoni'),
	('TMT', 'Turkmenistan Manat'),
	('TND', 'Tunisia Dinar'),
	('TOP', 'Tonga Pa\'anga'),
	('TRY', 'Turkey Lira'),
	('TVD', 'Tuvalu Dollar'),
	('TWD', 'Taiwan New Dollar'),
	('TZS', 'Tanzania Shilling'),
	('UAH', 'Ukraine Hryvnia'),
	('UGX', 'Uganda Shilling'),
	('USD', 'United States Dollar'),
	('UYU', 'Uruguay Peso'),
	('UZS', 'Uzbekistan Som'),
	('VEF', 'Venezuela Bolivar'),
	('VND', 'Viet Nam Dong'),
	('VUV', 'Vanuatu Vatu'),
	('WST', 'Samoa Tala'),
	('YER', 'Yemen Rial'),
	('ZAR', 'South Africa Rand'),
	('ZMW', 'Zambia Kwacha'),
	('ZWD', 'Zimbabwe Dollar');
/*!40000 ALTER TABLE `currencies_code` ENABLE KEYS */;

-- Dumping structure for table core.giftcodes
CREATE TABLE IF NOT EXISTS `giftcodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'prepaid, voucher, product',
  `prefix` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Tên model của code',
  `sku` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Mã sản phẩm, cách nhau bởi dấu phẩy',
  `currency_id` tinyint(4) DEFAULT NULL,
  `currency_code` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` double unsigned DEFAULT NULL,
  `discount` double unsigned DEFAULT '0',
  `description` text COLLATE utf8_unicode_ci,
  `logs` text COLLATE utf8_unicode_ci,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1 - valid, 2 - invalid, 3 - blocked',
  `active` int(11) NOT NULL DEFAULT '1',
  `used_time` int(11) NOT NULL DEFAULT '0' COMMENT 'Số lần đã dùng',
  `premiumday` tinyint(4) DEFAULT NULL,
  `expired_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=331 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table core.giftcodes: ~10 rows (approximately)
/*!40000 ALTER TABLE `giftcodes` DISABLE KEYS */;
INSERT INTO `giftcodes` (`id`, `name`, `type`, `prefix`, `code`, `model`, `sku`, `currency_id`, `currency_code`, `value`, `discount`, `description`, `logs`, `status`, `active`, `used_time`, `premiumday`, `expired_at`, `created_at`, `updated_at`) VALUES
	(321, 'Thẻ nạp tiền', 'deposit', 'GCP', 'GCP739153946333', 'AddFund', NULL, 1, 'VND', 100000, NULL, NULL, NULL, 1, 1, 1, NULL, '2019-11-25 21:31:03', '2019-08-27 21:31:03', '2019-08-27 21:31:03'),
	(322, 'Thẻ nạp tiền', 'deposit', 'GCP', 'GCP668712146977', 'AddFund', NULL, 1, 'VND', 100000, NULL, NULL, NULL, 2, 1, 1, NULL, '2019-11-25 21:31:03', '2019-08-27 21:31:03', '2019-08-27 22:00:08'),
	(323, 'Thẻ nạp tiền', 'deposit', 'GCP', 'GCP962400634825', 'AddFund', NULL, 1, 'VND', 100000, NULL, NULL, NULL, 1, 1, 1, NULL, '2019-11-25 21:31:03', '2019-08-27 21:31:03', '2019-08-27 21:31:03'),
	(324, 'Thẻ nạp tiền', 'deposit', 'GCP', 'GCP550434536417', 'AddFund', NULL, 1, 'VND', 100000, NULL, NULL, NULL, 2, 1, 1, NULL, '2019-11-25 21:31:03', '2019-08-27 21:31:03', '2019-08-27 21:58:07'),
	(325, 'Thẻ nạp tiền', 'deposit', 'GCP', 'GCP418213522627', 'AddFund', NULL, 1, 'VND', 100000, NULL, NULL, NULL, 1, 1, 1, NULL, '2019-11-25 21:31:03', '2019-08-27 21:31:03', '2019-08-27 21:31:03'),
	(326, 'Thẻ nạp tiền', 'deposit', 'GCP', 'GCP902849788930', 'AddFund', NULL, 1, 'VND', 100000, NULL, NULL, NULL, 2, 1, 1, NULL, '2019-11-25 21:31:03', '2019-08-27 21:31:03', '2019-08-27 21:57:47'),
	(327, 'Thẻ nạp tiền', 'deposit', 'GCP', 'GCP259819533769', 'AddFund', NULL, 1, 'VND', 100000, NULL, NULL, NULL, 1, 1, 1, NULL, '2019-11-25 21:31:03', '2019-08-27 21:31:03', '2019-08-27 21:31:03'),
	(328, 'Thẻ nạp tiền', 'deposit', 'GCP', 'GCP166655362297', 'AddFund', NULL, 1, 'VND', 100000, NULL, NULL, NULL, 2, 1, 2, NULL, '2019-11-25 21:31:03', '2019-08-27 21:31:03', '2019-08-27 21:52:03'),
	(329, 'Thẻ nạp tiền', 'deposit', 'GCP', 'GCP893358082193', 'AddFund', NULL, 1, 'VND', 100000, NULL, NULL, NULL, 2, 1, 1, NULL, '2019-11-25 21:31:03', '2019-08-27 21:31:03', '2019-08-27 21:46:30'),
	(330, 'Thẻ nạp tiền', 'deposit', 'GCP', 'GCP433560991661', 'AddFund', NULL, 1, 'VND', 100000, NULL, NULL, NULL, 2, 1, 2, NULL, '2019-11-25 21:31:03', '2019-08-27 21:31:03', '2019-08-27 21:48:30');
/*!40000 ALTER TABLE `giftcodes` ENABLE KEYS */;

-- Dumping structure for table core.giftcode_logs
CREATE TABLE IF NOT EXISTS `giftcode_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `model` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logs` text COLLATE utf8_unicode_ci,
  `sku` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `checksum` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `checksum` (`checksum`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table core.giftcode_logs: ~8 rows (approximately)
/*!40000 ALTER TABLE `giftcode_logs` DISABLE KEYS */;
INSERT INTO `giftcode_logs` (`id`, `code`, `user_id`, `model`, `logs`, `sku`, `status`, `checksum`, `created_at`, `updated_at`) VALUES
	(27, 'GCP893358082193', 25, 'AddFund', NULL, NULL, 'completed', '1ed177565c0095a3a119b3ea35e1ede9', '2019-08-27 21:46:30', '2019-08-27 21:46:30'),
	(28, 'GCP433560991661', 25, 'AddFund', NULL, NULL, 'completed', 'ebb26d9fb42df17372334a4abd2907ab', '2019-08-27 21:47:16', '2019-08-27 21:47:16'),
	(30, 'GCP433560991661', 25, 'AddFund', NULL, NULL, 'completed', '8fb7b97e08cb503dfeac07f098fd6d22', '2019-08-27 21:48:30', '2019-08-27 21:48:30'),
	(31, 'GCP166655362297', 25, 'AddFund', NULL, NULL, 'completed', '7148d6b06497ed1d6c4bae4f6e02259c', '2019-08-27 21:49:33', '2019-08-27 21:49:33'),
	(35, 'GCP166655362297', 25, 'AddFund', NULL, NULL, 'completed', '49c065e352fb74e815dd96105ce81124', '2019-08-27 21:52:03', '2019-08-27 21:52:03'),
	(36, 'GCP902849788930', 25, 'AddFund', NULL, NULL, 'completed', '8a0d422d45242e491beb15402e5e3a7f', '2019-08-27 21:57:47', '2019-08-27 21:57:47'),
	(37, 'GCP550434536417', 25, 'AddFund', NULL, NULL, 'completed', '9a1636d9979e69a27a22966dc3387e09', '2019-08-27 21:58:07', '2019-08-27 21:58:07'),
	(38, 'GCP668712146977', 25, 'AddFund', NULL, NULL, 'completed', '27abdf54c8dff29ecd461eff4d36b02a', '2019-08-27 22:00:08', '2019-08-27 22:00:08');
/*!40000 ALTER TABLE `giftcode_logs` ENABLE KEYS */;

-- Dumping structure for table core.groups
CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `hideit` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table core.groups: ~3 rows (approximately)
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` (`id`, `name`, `description`, `status`, `hideit`, `created_at`, `updated_at`) VALUES
	(1, 'Guest', 'Không phải thành viên', 1, 0, '2018-07-25 14:08:28', '2018-08-18 19:16:32'),
	(2, 'Thành viên', 'Thành viên', 1, 1, '2018-07-25 14:08:23', '2018-08-18 19:15:29'),
	(3, 'Đại lý', 'Đại lý', 1, 0, '2018-08-18 19:14:46', '2019-03-06 01:01:41');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;

-- Dumping structure for table core.languages
CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `code` varchar(10) NOT NULL,
  `flag` varchar(255) DEFAULT NULL,
  `hreflang` varchar(50) DEFAULT NULL,
  `charset` varchar(50) DEFAULT NULL,
  `default` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `installed` tinyint(4) NOT NULL DEFAULT '0',
  `sort` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table core.languages: ~2 rows (approximately)
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
INSERT INTO `languages` (`id`, `name`, `code`, `flag`, `hreflang`, `charset`, `default`, `status`, `installed`, `sort`, `created_at`, `updated_at`) VALUES
	(1, 'English', 'en', 'en.png', NULL, NULL, 0, 1, 1, 2, '2018-11-01 03:30:53', '2018-11-01 03:30:53'),
	(2, 'Tiếng Việt', 'vi', 'vi.png', NULL, NULL, 1, 1, 1, 1, '2018-11-01 03:30:12', '2018-10-31 07:14:42');
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;

-- Dumping structure for table core.languages_trans
CREATE TABLE IF NOT EXISTS `languages_trans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang_code` varchar(50) NOT NULL,
  `lang_key` varchar(50) NOT NULL,
  `filename` varchar(50) NOT NULL,
  `key` varchar(100) NOT NULL COMMENT 'en_auth ==> gồm lang_code + filename',
  `content` text NOT NULL,
  `type` varchar(50) NOT NULL DEFAULT 'string',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=572 DEFAULT CHARSET=utf8;

-- Dumping data for table core.languages_trans: ~167 rows (approximately)
/*!40000 ALTER TABLE `languages_trans` DISABLE KEYS */;
INSERT INTO `languages_trans` (`id`, `lang_code`, `lang_key`, `filename`, `key`, `content`, `type`, `created_at`, `updated_at`) VALUES
	(405, 'vi', 'auth.failed', 'auth', 'vi_auth_failed', 'Thông tin đăng nhập không chính xác.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(406, 'vi', 'home.home_title', 'home', 'vi_home_home_title', 'Trang chủ', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(407, 'vi', 'home.paid', 'home', 'vi_home_paid', 'Đã thanh toán', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(408, 'vi', 'home.card-pay', 'home', 'vi_home_card-pay', 'ĐỔI THẺ', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(409, 'vi', 'pagination.previous', 'pagination', 'vi_pagination_previous', 'dafds', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(410, 'vi', 'pagination.next', 'pagination', 'vi_pagination_next', 'dasdsa', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(411, 'vi', 'profiles.login', 'profiles', 'vi_profiles_login', 'Đăng nhập', 'string', '2019-08-15 08:08:54', '2019-08-15 08:08:54'),
	(412, 'vi', 'profiles.logout', 'profiles', 'vi_profiles_logout', 'Đăng xuất', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(413, 'vi', 'profiles.profile', 'profiles', 'vi_profiles_profile', 'Bảng điều khiển', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(414, 'vi', 'profiles.register', 'profiles', 'vi_profiles_register', 'Đăng ký', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(415, 'vi', 'profiles.account', 'profiles', 'vi_profiles_account', 'Tài khoản', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(416, 'vi', 'profiles.localbank', 'profiles', 'vi_profiles_localbank', 'Ngân hàng', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(417, 'vi', 'profiles.changepassword', 'profiles', 'vi_profiles_changepassword', 'Đổi mật khẩu', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(418, 'vi', 'validation.number_phone', 'validation', 'vi_validation_number_phone', 'Số điện thoại không đúng định dạng', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(419, 'vi', 'validation.recaptcha', 'validation', 'vi_validation_recaptcha', 'Mã xác nhận không chính xác', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(420, 'vi', 'validation.accepted', 'validation', 'vi_validation_accepted', 'Bạn cần phải chấp nhận :attribute.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(421, 'vi', 'validation.active_url', 'validation', 'vi_validation_active_url', ':attribute không phải là đường dẫn chính xác.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(422, 'vi', 'validation.after', 'validation', 'vi_validation_after', ':attribute phải sau :date.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(423, 'vi', 'validation.after_or_equal', 'validation', 'vi_validation_after_or_equal', ':attribute phải bằng hoặc sau :date.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(424, 'vi', 'validation.alpha', 'validation', 'vi_validation_alpha', ':attribute chỉ chấp nhận kí tự.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(425, 'vi', 'validation.alpha_dash', 'validation', 'vi_validation_alpha_dash', ':attribute chỉ chấp nhận kí tự, chữ số, dấu gạch ngang và gạch dưới.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(426, 'vi', 'validation.alpha_num', 'validation', 'vi_validation_alpha_num', ':attribute chỉ chấp nhận kí tự và chữ số.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(427, 'vi', 'validation.array', 'validation', 'vi_validation_array', ':attribute phải là 1 mảng phần tử.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(428, 'vi', 'validation.before', 'validation', 'vi_validation_before', ':attribute phải trước :date.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(429, 'vi', 'validation.before_or_equal', 'validation', 'vi_validation_before_or_equal', ':attribute phải bằng hoặc trước :date.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(430, 'vi', 'validation.between', 'validation', 'vi_validation_between', '{"numeric":"The :attribute must be between :min and :max.","file":"The :attribute must be between :min and :max kilobytes.","string":"The :attribute must be between :min and :max characters.","array":"The :attribute must have between :min and :max items."}', 'array', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(431, 'vi', 'validation.boolean', 'validation', 'vi_validation_boolean', 'The :attribute field must be true or false.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(432, 'vi', 'validation.confirmed', 'validation', 'vi_validation_confirmed', 'The :attribute confirmation does not match.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(433, 'vi', 'validation.date', 'validation', 'vi_validation_date', 'The :attribute is not a valid date.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(434, 'vi', 'validation.date_format', 'validation', 'vi_validation_date_format', 'The :attribute does not match the format :format.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(435, 'vi', 'validation.different', 'validation', 'vi_validation_different', 'The :attribute and :other must be different.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(436, 'vi', 'validation.digits', 'validation', 'vi_validation_digits', 'The :attribute must be :digits digits.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(437, 'vi', 'validation.digits_between', 'validation', 'vi_validation_digits_between', 'The :attribute must be between :min and :max digits.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(438, 'vi', 'validation.dimensions', 'validation', 'vi_validation_dimensions', 'The :attribute has invalid image dimensions.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(439, 'vi', 'validation.distinct', 'validation', 'vi_validation_distinct', 'The :attribute field has a duplicate value.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(440, 'vi', 'validation.email', 'validation', 'vi_validation_email', ':attribute không đúng định dạng email.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(441, 'vi', 'validation.exists', 'validation', 'vi_validation_exists', ':attribute đã tồn tại.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(442, 'vi', 'validation.file', 'validation', 'vi_validation_file', ':attribute phải là file.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(443, 'vi', 'validation.filled', 'validation', 'vi_validation_filled', ':attribute cần phải nhập dữ liệu.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(444, 'vi', 'validation.gt', 'validation', 'vi_validation_gt', '{"numeric":"The :attribute must be greater than :value.","file":"The :attribute must be greater than :value kilobytes.","string":"The :attribute must be greater than :value characters.","array":"The :attribute must have more than :value items."}', 'array', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(445, 'vi', 'validation.gte', 'validation', 'vi_validation_gte', '{"numeric":"The :attribute must be greater than or equal :value.","file":"The :attribute must be greater than or equal :value kilobytes.","string":"The :attribute must be greater than or equal :value characters.","array":"The :attribute must have :value items or more."}', 'array', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(446, 'vi', 'validation.image', 'validation', 'vi_validation_image', ':attribute phải là file hình ảnh.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(447, 'vi', 'validation.in', 'validation', 'vi_validation_in', 'The selected :attribute is invalid.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(448, 'vi', 'validation.in_array', 'validation', 'vi_validation_in_array', 'The :attribute field does not exist in :other.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(449, 'vi', 'validation.integer', 'validation', 'vi_validation_integer', ':attribute cần phải là số nguyên.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(450, 'vi', 'validation.ip', 'validation', 'vi_validation_ip', 'The :attribute must be a valid IP address.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(451, 'vi', 'validation.ipv4', 'validation', 'vi_validation_ipv4', 'The :attribute must be a valid IPv4 address.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(452, 'vi', 'validation.ipv6', 'validation', 'vi_validation_ipv6', 'The :attribute must be a valid IPv6 address.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(453, 'vi', 'validation.json', 'validation', 'vi_validation_json', 'The :attribute must be a valid JSON string.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(454, 'vi', 'validation.lt', 'validation', 'vi_validation_lt', '{"numeric":"The :attribute must be less than :value.","file":"The :attribute must be less than :value kilobytes.","string":"The :attribute must be less than :value characters.","array":"The :attribute must have less than :value items."}', 'array', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(455, 'vi', 'validation.lte', 'validation', 'vi_validation_lte', '{"numeric":"The :attribute must be less than or equal :value.","file":"The :attribute must be less than or equal :value kilobytes.","string":"The :attribute must be less than or equal :value characters.","array":"The :attribute must not have more than :value items."}', 'array', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(456, 'vi', 'validation.max', 'validation', 'vi_validation_max', '{"numeric":":attribute kh\\u00f4ng \\u0111\\u01b0\\u1ee3c l\\u1edbn h\\u01a1n :max.","file":":attribute kh\\u00f4ng \\u0111\\u01b0\\u1ee3c l\\u1edbn h\\u01a1n :max kilobytes.","string":":attribute kh\\u00f4ng \\u0111\\u01b0\\u1ee3c l\\u1edbn h\\u01a1n :max k\\u00ed t\\u1ef1.","array":":attribute kh\\u00f4ng \\u0111\\u01b0\\u1ee3c l\\u1edbn h\\u01a1n :max ph\\u1ea7n t\\u1eed."}', 'array', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(457, 'vi', 'validation.mimes', 'validation', 'vi_validation_mimes', ':attribute cần phải có định dạng: :values.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(458, 'vi', 'validation.mimetypes', 'validation', 'vi_validation_mimetypes', ':attribute cần phải có định dạng: :values.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(459, 'vi', 'validation.min', 'validation', 'vi_validation_min', '{"numeric":":attribute kh\\u00f4ng \\u0111\\u01b0\\u1ee3c nh\\u1ecf h\\u01a1n :min.","file":":attribute kh\\u00f4ng \\u0111\\u01b0\\u1ee3c nh\\u1ecf h\\u01a1n :min kilobytes.","string":":attribute kh\\u00f4ng \\u0111\\u01b0\\u1ee3c nh\\u1ecf h\\u01a1n :min k\\u00ed t\\u1ef1.","array":":attribute kh\\u00f4ng \\u0111\\u01b0\\u1ee3c nh\\u1ecf h\\u01a1n :min ph\\u1ea7n t\\u1eed."}', 'array', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(460, 'vi', 'validation.not_in', 'validation', 'vi_validation_not_in', 'The selected :attribute is invalid.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(461, 'vi', 'validation.not_regex', 'validation', 'vi_validation_not_regex', 'The :attribute format is invalid.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(462, 'vi', 'validation.numeric', 'validation', 'vi_validation_numeric', ':attribute phải là chữ số.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(463, 'vi', 'validation.present', 'validation', 'vi_validation_present', 'The :attribute field must be present.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(464, 'vi', 'validation.regex', 'validation', 'vi_validation_regex', ':attribute không đúng định dạng.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(465, 'vi', 'validation.required', 'validation', 'vi_validation_required', ':attribute không được để trống.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(466, 'vi', 'validation.required_if', 'validation', 'vi_validation_required_if', 'The :attribute field is required when :other is :value.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(467, 'vi', 'validation.required_unless', 'validation', 'vi_validation_required_unless', 'The :attribute field is required unless :other is in :values.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(468, 'vi', 'validation.required_with', 'validation', 'vi_validation_required_with', 'The :attribute field is required when :values is present.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(469, 'vi', 'validation.required_with_all', 'validation', 'vi_validation_required_with_all', 'The :attribute field is required when :values is present.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(470, 'vi', 'validation.required_without', 'validation', 'vi_validation_required_without', 'The :attribute field is required when :values is not present.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(471, 'vi', 'validation.required_without_all', 'validation', 'vi_validation_required_without_all', 'The :attribute field is required when none of :values are present.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(472, 'vi', 'validation.same', 'validation', 'vi_validation_same', ':attribute và :other không trùng nhau.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(473, 'vi', 'validation.size', 'validation', 'vi_validation_size', '{"numeric":"The :attribute must be :size.","file":"The :attribute must be :size kilobytes.","string":"The :attribute must be :size characters.","array":"The :attribute must contain :size items."}', 'array', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(474, 'vi', 'validation.string', 'validation', 'vi_validation_string', 'The :attribute must be a string.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(475, 'vi', 'validation.timezone', 'validation', 'vi_validation_timezone', 'The :attribute must be a valid zone.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(476, 'vi', 'validation.unique', 'validation', 'vi_validation_unique', 'The :attribute has already been taken.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(477, 'vi', 'validation.uploaded', 'validation', 'vi_validation_uploaded', 'The :attribute failed to upload.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(478, 'vi', 'validation.url', 'validation', 'vi_validation_url', 'The :attribute format is invalid.', 'string', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(479, 'vi', 'validation.custom', 'validation', 'vi_validation_custom', '{"attribute-name":{"rule-name":"custom-message"}}', 'array', '2019-08-13 15:43:22', '2019-08-13 15:43:22'),
	(480, 'en', 'auth.failed', 'auth', 'en_auth_failed', 'These credentials do not match our records.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(481, 'en', 'home.home_title', 'home', 'en_home_home_title', 'Home', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(482, 'en', 'home.paid', 'home', 'en_home_paid', 'Paid', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(483, 'en', 'home.card-pay', 'home', 'en_home_card-pay', 'CHARGING', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(484, 'en', 'pagination.previous', 'pagination', 'en_pagination_previous', '&laquo; Previous', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(485, 'en', 'pagination.next', 'pagination', 'en_pagination_next', 'Next &raquo;', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(486, 'en', 'passwords.password', 'passwords', 'en_passwords_password', 'Passwords must be at least six characters and match the confirmation.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(487, 'en', 'passwords.reset', 'passwords', 'en_passwords_reset', 'Your password has been reset!', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(488, 'en', 'passwords.sent', 'passwords', 'en_passwords_sent', 'We have e-mailed your password reset link!', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(489, 'en', 'passwords.token', 'passwords', 'en_passwords_token', 'This password reset token is invalid.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(490, 'en', 'passwords.user', 'passwords', 'en_passwords_user', 'We can\'t find a user with that e-mail address.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(491, 'en', 'profiles.login', 'profiles', 'en_profiles_login', 'Login', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(492, 'en', 'profiles.register', 'profiles', 'en_profiles_register', 'Register', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(493, 'en', 'profiles.logout', 'profiles', 'en_profiles_logout', 'Logout', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(494, 'en', 'profiles.profile', 'profiles', 'en_profiles_profile', 'Profile', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(495, 'en', 'profiles.account', 'profiles', 'en_profiles_account', 'My Account', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(496, 'en', 'profiles.changepassword', 'profiles', 'en_profiles_changepassword', 'Change password', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(497, 'en', 'validation.recaptcha', 'validation', 'en_validation_recaptcha', 'Please ensure that you are a human!', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(498, 'en', 'validation.accepted', 'validation', 'en_validation_accepted', 'The :attribute must be accepted.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(499, 'en', 'validation.active_url', 'validation', 'en_validation_active_url', 'The :attribute is not a valid URL.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(500, 'en', 'validation.after', 'validation', 'en_validation_after', 'The :attribute must be a date after :date.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(501, 'en', 'validation.after_or_equal', 'validation', 'en_validation_after_or_equal', 'The :attribute must be a date after or equal to :date.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(502, 'en', 'validation.alpha', 'validation', 'en_validation_alpha', 'The :attribute may only contain letters.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(503, 'en', 'validation.alpha_dash', 'validation', 'en_validation_alpha_dash', 'The :attribute may only contain letters, numbers, dashes and underscores.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(504, 'en', 'validation.alpha_num', 'validation', 'en_validation_alpha_num', 'The :attribute may only contain letters and numbers.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(505, 'en', 'validation.array', 'validation', 'en_validation_array', 'The :attribute must be an array.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(506, 'en', 'validation.before', 'validation', 'en_validation_before', 'The :attribute must be a date before :date.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(507, 'en', 'validation.before_or_equal', 'validation', 'en_validation_before_or_equal', 'The :attribute must be a date before or equal to :date.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(508, 'en', 'validation.between', 'validation', 'en_validation_between', '{"numeric":"The :attribute must be between :min and :max.","file":"The :attribute must be between :min and :max kilobytes.","string":"The :attribute must be between :min and :max characters.","array":"The :attribute must have between :min and :max items."}', 'array', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(509, 'en', 'validation.boolean', 'validation', 'en_validation_boolean', 'The :attribute field must be true or false.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(510, 'en', 'validation.confirmed', 'validation', 'en_validation_confirmed', 'The :attribute confirmation does not match.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(511, 'en', 'validation.date', 'validation', 'en_validation_date', 'The :attribute is not a valid date.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(512, 'en', 'validation.date_format', 'validation', 'en_validation_date_format', 'The :attribute does not match the format :format.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(513, 'en', 'validation.different', 'validation', 'en_validation_different', 'The :attribute and :other must be different.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(514, 'en', 'validation.digits', 'validation', 'en_validation_digits', 'The :attribute must be :digits digits.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(515, 'en', 'validation.digits_between', 'validation', 'en_validation_digits_between', 'The :attribute must be between :min and :max digits.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(516, 'en', 'validation.dimensions', 'validation', 'en_validation_dimensions', 'The :attribute has invalid image dimensions.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(517, 'en', 'validation.distinct', 'validation', 'en_validation_distinct', 'The :attribute field has a duplicate value.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(518, 'en', 'validation.email', 'validation', 'en_validation_email', 'The :attribute must be a valid email address.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(519, 'en', 'validation.exists', 'validation', 'en_validation_exists', 'The selected :attribute is invalid.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(520, 'en', 'validation.file', 'validation', 'en_validation_file', 'The :attribute must be a file.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(521, 'en', 'validation.filled', 'validation', 'en_validation_filled', 'The :attribute field must have a value.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(522, 'en', 'validation.gt', 'validation', 'en_validation_gt', '{"numeric":"The :attribute must be greater than :value.","file":"The :attribute must be greater than :value kilobytes.","string":"The :attribute must be greater than :value characters.","array":"The :attribute must have more than :value items."}', 'array', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(523, 'en', 'validation.gte', 'validation', 'en_validation_gte', '{"numeric":"The :attribute must be greater than or equal :value.","file":"The :attribute must be greater than or equal :value kilobytes.","string":"The :attribute must be greater than or equal :value characters.","array":"The :attribute must have :value items or more."}', 'array', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(524, 'en', 'validation.image', 'validation', 'en_validation_image', 'The :attribute must be an image.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(525, 'en', 'validation.in', 'validation', 'en_validation_in', 'The selected :attribute is invalid.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(526, 'en', 'validation.in_array', 'validation', 'en_validation_in_array', 'The :attribute field does not exist in :other.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(527, 'en', 'validation.integer', 'validation', 'en_validation_integer', 'The :attribute must be an integer.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(528, 'en', 'validation.ip', 'validation', 'en_validation_ip', 'The :attribute must be a valid IP address.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(529, 'en', 'validation.ipv4', 'validation', 'en_validation_ipv4', 'The :attribute must be a valid IPv4 address.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(530, 'en', 'validation.ipv6', 'validation', 'en_validation_ipv6', 'The :attribute must be a valid IPv6 address.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(531, 'en', 'validation.json', 'validation', 'en_validation_json', 'The :attribute must be a valid JSON string.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(532, 'en', 'validation.lt', 'validation', 'en_validation_lt', '{"numeric":"The :attribute must be less than :value.","file":"The :attribute must be less than :value kilobytes.","string":"The :attribute must be less than :value characters.","array":"The :attribute must have less than :value items."}', 'array', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(533, 'en', 'validation.lte', 'validation', 'en_validation_lte', '{"numeric":"The :attribute must be less than or equal :value.","file":"The :attribute must be less than or equal :value kilobytes.","string":"The :attribute must be less than or equal :value characters.","array":"The :attribute must not have more than :value items."}', 'array', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(534, 'en', 'validation.max', 'validation', 'en_validation_max', '{"numeric":"The :attribute may not be greater than :max.","file":"The :attribute may not be greater than :max kilobytes.","string":"The :attribute may not be greater than :max characters.","array":"The :attribute may not have more than :max items."}', 'array', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(535, 'en', 'validation.mimes', 'validation', 'en_validation_mimes', 'The :attribute must be a file of type: :values.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(536, 'en', 'validation.mimetypes', 'validation', 'en_validation_mimetypes', 'The :attribute must be a file of type: :values.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(537, 'en', 'validation.min', 'validation', 'en_validation_min', '{"numeric":"The :attribute must be at least :min.","file":"The :attribute must be at least :min kilobytes.","string":"The :attribute must be at least :min characters.","array":"The :attribute must have at least :min items."}', 'array', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(538, 'en', 'validation.not_in', 'validation', 'en_validation_not_in', 'The selected :attribute is invalid.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(539, 'en', 'validation.not_regex', 'validation', 'en_validation_not_regex', 'The :attribute format is invalid.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(540, 'en', 'validation.numeric', 'validation', 'en_validation_numeric', 'The :attribute must be a number.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(541, 'en', 'validation.present', 'validation', 'en_validation_present', 'The :attribute field must be present.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(542, 'en', 'validation.regex', 'validation', 'en_validation_regex', 'The :attribute format is invalid.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(543, 'en', 'validation.required', 'validation', 'en_validation_required', 'The :attribute field is required.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(544, 'en', 'validation.required_if', 'validation', 'en_validation_required_if', 'The :attribute field is required when :other is :value.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(545, 'en', 'validation.required_unless', 'validation', 'en_validation_required_unless', 'The :attribute field is required unless :other is in :values.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(546, 'en', 'validation.required_with', 'validation', 'en_validation_required_with', 'The :attribute field is required when :values is present.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(547, 'en', 'validation.required_with_all', 'validation', 'en_validation_required_with_all', 'The :attribute field is required when :values is present.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(548, 'en', 'validation.required_without', 'validation', 'en_validation_required_without', 'The :attribute field is required when :values is not present.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(549, 'en', 'validation.required_without_all', 'validation', 'en_validation_required_without_all', 'The :attribute field is required when none of :values are present.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(550, 'en', 'validation.same', 'validation', 'en_validation_same', 'The :attribute and :other must match.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(551, 'en', 'validation.size', 'validation', 'en_validation_size', '{"numeric":"The :attribute must be :size.","file":"The :attribute must be :size kilobytes.","string":"The :attribute must be :size characters.","array":"The :attribute must contain :size items."}', 'array', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(552, 'en', 'validation.string', 'validation', 'en_validation_string', 'The :attribute must be a string.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(553, 'en', 'validation.timezone', 'validation', 'en_validation_timezone', 'The :attribute must be a valid zone.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(554, 'en', 'validation.unique', 'validation', 'en_validation_unique', 'The :attribute has already been taken.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(555, 'en', 'validation.uploaded', 'validation', 'en_validation_uploaded', 'The :attribute failed to upload.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(556, 'en', 'validation.url', 'validation', 'en_validation_url', 'The :attribute format is invalid.', 'string', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(557, 'en', 'validation.custom', 'validation', 'en_validation_custom', '{"attribute-name":{"rule-name":"custom-message"}}', 'array', '2019-08-14 05:41:12', '2019-08-14 05:41:12'),
	(558, 'en', 'auth.loginaccount', 'auth', 'en_auth_loginaccount', 'Email or Phone', 'string', '2019-08-15 08:30:19', '2019-08-15 08:30:19'),
	(559, 'en', 'auth.username', 'auth', 'en_auth_username', 'Username', 'string', '2019-08-14 07:20:56', '2019-08-14 07:20:56'),
	(560, 'en', 'auth.password', 'auth', 'en_auth_password', 'Password', 'string', '2019-08-14 07:24:10', '2019-08-14 07:24:10'),
	(561, 'en', 'auth.remember', 'auth', 'en_auth_remember', 'Remember?', 'string', '2019-08-14 07:24:10', '2019-08-14 07:24:10'),
	(562, 'en', 'auth.buttonlogin', 'auth', 'en_auth_buttonlogin', 'Login', 'string', '2019-08-14 07:26:19', '2019-08-14 07:26:19'),
	(563, 'en', 'auth.forgotpassword', 'auth', 'en_auth_forgotpassword', 'Forgot password?', 'string', '2019-08-14 07:24:10', '2019-08-14 07:24:10'),
	(564, 'en', 'auth.titlelogin', 'auth', 'en_auth_titlelogin', 'Account Login', 'string', '2019-08-14 07:30:19', '2019-08-14 07:30:19'),
	(565, 'vi', 'auth.loginaccount', 'auth', 'vi_auth_loginaccount', 'Email hoặc Số điện thoại', 'string', '2019-08-25 16:31:05', '2019-08-25 16:31:05'),
	(566, 'vi', 'auth.username', 'auth', 'vi_auth_username', 'Tên đăng nhập', 'string', '2019-08-25 16:31:05', '2019-08-25 16:31:05'),
	(567, 'vi', 'auth.password', 'auth', 'vi_auth_password', 'Mật khẩu', 'string', '2019-08-25 16:31:05', '2019-08-25 16:31:05'),
	(568, 'vi', 'auth.remember', 'auth', 'vi_auth_remember', 'Ghi nhớ?', 'string', '2019-08-25 16:31:05', '2019-08-25 16:31:05'),
	(569, 'vi', 'auth.buttonlogin', 'auth', 'vi_auth_buttonlogin', 'Đăng nhập', 'string', '2019-08-25 16:31:05', '2019-08-25 16:31:05'),
	(570, 'vi', 'auth.titlelogin', 'auth', 'vi_auth_titlelogin', 'Đăng nhập tài khoản', 'string', '2019-08-25 16:31:05', '2019-08-25 16:31:05'),
	(571, 'vi', 'auth.forgotpassword', 'auth', 'vi_auth_forgotpassword', 'Quên mật khẩu?', 'string', '2019-08-25 16:31:05', '2019-08-25 16:31:05');
/*!40000 ALTER TABLE `languages_trans` ENABLE KEYS */;

-- Dumping structure for table core.localbanks
CREATE TABLE IF NOT EXISTS `localbanks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Mã paygatecode',
  `paygate` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'Localbank',
  `paygate_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `acc_num` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `acc_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `branch` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `card_num` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `info` text COLLATE utf8_unicode_ci,
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deposit` int(1) NOT NULL DEFAULT '1',
  `withdraw` int(1) NOT NULL DEFAULT '1',
  `status` int(1) NOT NULL DEFAULT '1',
  `sort` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table core.localbanks: ~3 rows (approximately)
/*!40000 ALTER TABLE `localbanks` DISABLE KEYS */;
INSERT INTO `localbanks` (`id`, `code`, `paygate`, `paygate_code`, `name`, `acc_num`, `acc_name`, `branch`, `card_num`, `link`, `info`, `icon`, `deposit`, `withdraw`, `status`, `sort`) VALUES
	(2, 'EAB', 'Localbank', 'Localbank_EAB', 'Ngân hàng Đông Á', '0104659963', 'Nguyen Van Nghia', 'Hai Phong', NULL, NULL, NULL, '/storage/userfiles/images/paygates/dongabank.png', 1, 1, 1, 0),
	(3, 'VCB', 'Localbank', 'Localbank_VCB', 'Ngân hàng Vietcombank', '00310001535454', 'nguyen van nghia', 'Hai Phong', NULL, NULL, NULL, '/storage/userfiles/images/paygates/vietcombank.png', 1, 1, 1, 2),
	(5, 'BIDV', 'Localbank', 'Localbank_BIDV', 'Ngân hàng BIDV', '000000', 'Nguyen Van Nghia', 'HN', '6666666666666666', NULL, NULL, '/storage/userfiles/images/paygates/bidv.png', 1, 1, 1, 5);
/*!40000 ALTER TABLE `localbanks` ENABLE KEYS */;

-- Dumping structure for table core.localbanks_user
CREATE TABLE IF NOT EXISTS `localbanks_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `paygate_code` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `acc_num` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `acc_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `branch` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `card_num` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `approved` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table core.localbanks_user: ~2 rows (approximately)
/*!40000 ALTER TABLE `localbanks_user` DISABLE KEYS */;
INSERT INTO `localbanks_user` (`id`, `user_id`, `code`, `paygate_code`, `acc_num`, `acc_name`, `branch`, `card_num`, `approved`, `created_at`, `updated_at`) VALUES
	(41, 25, 'VCB', 'Localbank_VCB', '0031000495366', 'Nguyen Van Giang', 'Ha Noi', NULL, 1, '2019-07-28 09:47:45', '2019-06-02 17:09:13'),
	(45, 25, 'VCB', 'Localbank_VCB', '54353543', 'NGUYEN VAN HAU', 'Hai Phong', '768768976876878', 1, '2019-07-28 09:47:58', '2019-07-28 08:58:03');
/*!40000 ALTER TABLE `localbanks_user` ENABLE KEYS */;

-- Dumping structure for table core.ltm_translations
CREATE TABLE IF NOT EXISTS `ltm_translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` int(11) NOT NULL DEFAULT '0',
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=149 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table core.ltm_translations: ~139 rows (approximately)
/*!40000 ALTER TABLE `ltm_translations` DISABLE KEYS */;
INSERT INTO `ltm_translations` (`id`, `status`, `locale`, `group`, `key`, `value`, `created_at`, `updated_at`) VALUES
	(1, 0, 'en', 'auth', 'failed', 'These credentials do not match our records.', '2018-07-02 04:46:15', '2018-08-02 13:01:47'),
	(3, 0, 'en', 'pagination', 'previous', '&laquo; Previous', '2018-07-02 04:46:15', '2018-08-02 13:01:47'),
	(4, 0, 'en', 'pagination', 'next', 'Next &raquo;', '2018-07-02 04:46:15', '2018-08-02 13:01:47'),
	(5, 0, 'en', '_json', 'Login', NULL, '2018-07-02 04:46:15', '2018-07-02 04:46:15'),
	(6, 0, 'en', '_json', 'Register', NULL, '2018-07-02 04:46:15', '2018-07-02 04:46:15'),
	(7, 0, 'en', '_json', 'Logout', NULL, '2018-07-02 04:46:15', '2018-07-02 04:46:15'),
	(8, 0, 'en', '_json', 'E-Mail Address', NULL, '2018-07-02 04:46:15', '2018-07-02 04:46:15'),
	(9, 0, 'en', '_json', 'Password', NULL, '2018-07-02 04:46:15', '2018-07-02 04:46:15'),
	(10, 0, 'en', '_json', 'Remember Me', NULL, '2018-07-02 04:46:15', '2018-07-02 04:46:15'),
	(11, 0, 'en', '_json', 'Forgot Your Password?', NULL, '2018-07-02 04:46:15', '2018-07-02 04:46:15'),
	(12, 0, 'en', '_json', 'Reset Password', NULL, '2018-07-02 04:46:15', '2018-07-02 04:46:15'),
	(13, 0, 'en', '_json', 'Send Password Reset Link', NULL, '2018-07-02 04:46:15', '2018-07-02 04:46:15'),
	(14, 0, 'en', '_json', 'Confirm Password', NULL, '2018-07-02 04:46:15', '2018-07-02 04:46:15'),
	(15, 0, 'en', '_json', 'Name', NULL, '2018-07-02 04:46:15', '2018-07-02 04:46:15'),
	(16, 0, 'en', '_json', 'Toggle navigation', NULL, '2018-07-02 04:46:15', '2018-07-02 04:46:15'),
	(17, 0, 'en', '_json', 'Whoops!', NULL, '2018-07-02 04:46:15', '2018-07-02 04:46:15'),
	(18, 0, 'en', '_json', 'Hello!', NULL, '2018-07-02 04:46:15', '2018-07-02 04:46:15'),
	(19, 0, 'en', '_json', 'Regards', NULL, '2018-07-02 04:46:15', '2018-07-02 04:46:15'),
	(20, 0, 'en', 'passwords', 'password', 'Passwords must be at least six characters and match the confirmation.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(21, 0, 'en', 'passwords', 'reset', 'Your password has been reset!', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(22, 0, 'en', 'passwords', 'sent', 'We have e-mailed your password reset link!', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(23, 0, 'en', 'passwords', 'token', 'This password reset token is invalid.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(24, 0, 'en', 'passwords', 'user', 'We can\'t find a user with that e-mail address.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(25, 0, 'en', 'validation', 'accepted', 'The :attribute must be accepted.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(26, 0, 'en', 'validation', 'active_url', 'The :attribute is not a valid URL.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(27, 0, 'en', 'validation', 'after', 'The :attribute must be a date after :date.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(28, 0, 'en', 'validation', 'after_or_equal', 'The :attribute must be a date after or equal to :date.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(29, 0, 'en', 'validation', 'alpha', 'The :attribute may only contain letters.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(30, 0, 'en', 'validation', 'alpha_dash', 'The :attribute may only contain letters, numbers, dashes and underscores.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(31, 0, 'en', 'validation', 'alpha_num', 'The :attribute may only contain letters and numbers.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(32, 0, 'en', 'validation', 'array', 'The :attribute must be an array.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(33, 0, 'en', 'validation', 'before', 'The :attribute must be a date before :date.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(34, 0, 'en', 'validation', 'before_or_equal', 'The :attribute must be a date before or equal to :date.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(35, 0, 'en', 'validation', 'between.numeric', 'The :attribute must be between :min and :max.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(36, 0, 'en', 'validation', 'between.file', 'The :attribute must be between :min and :max kilobytes.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(37, 0, 'en', 'validation', 'between.string', 'The :attribute must be between :min and :max characters.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(38, 0, 'en', 'validation', 'between.array', 'The :attribute must have between :min and :max items.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(39, 0, 'en', 'validation', 'boolean', 'The :attribute field must be true or false.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(40, 0, 'en', 'validation', 'confirmed', 'The :attribute confirmation does not match.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(41, 0, 'en', 'validation', 'date', 'The :attribute is not a valid date.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(42, 0, 'en', 'validation', 'date_format', 'The :attribute does not match the format :format.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(43, 0, 'en', 'validation', 'different', 'The :attribute and :other must be different.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(44, 0, 'en', 'validation', 'digits', 'The :attribute must be :digits digits.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(45, 0, 'en', 'validation', 'digits_between', 'The :attribute must be between :min and :max digits.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(46, 0, 'en', 'validation', 'dimensions', 'The :attribute has invalid image dimensions.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(47, 0, 'en', 'validation', 'distinct', 'The :attribute field has a duplicate value.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(48, 0, 'en', 'validation', 'email', 'The :attribute must be a valid email address.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(49, 0, 'en', 'validation', 'exists', 'The selected :attribute is invalid.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(50, 0, 'en', 'validation', 'file', 'The :attribute must be a file.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(51, 0, 'en', 'validation', 'filled', 'The :attribute field must have a value.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(52, 0, 'en', 'validation', 'gt.numeric', 'The :attribute must be greater than :value.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(53, 0, 'en', 'validation', 'gt.file', 'The :attribute must be greater than :value kilobytes.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(54, 0, 'en', 'validation', 'gt.string', 'The :attribute must be greater than :value characters.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(55, 0, 'en', 'validation', 'gt.array', 'The :attribute must have more than :value items.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(56, 0, 'en', 'validation', 'gte.numeric', 'The :attribute must be greater than or equal :value.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(57, 0, 'en', 'validation', 'gte.file', 'The :attribute must be greater than or equal :value kilobytes.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(58, 0, 'en', 'validation', 'gte.string', 'The :attribute must be greater than or equal :value characters.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(59, 0, 'en', 'validation', 'gte.array', 'The :attribute must have :value items or more.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(60, 0, 'en', 'validation', 'image', 'The :attribute must be an image.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(61, 0, 'en', 'validation', 'in', 'The selected :attribute is invalid.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(62, 0, 'en', 'validation', 'in_array', 'The :attribute field does not exist in :other.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(63, 0, 'en', 'validation', 'integer', 'The :attribute must be an integer.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(64, 0, 'en', 'validation', 'ip', 'The :attribute must be a valid IP address.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(65, 0, 'en', 'validation', 'ipv4', 'The :attribute must be a valid IPv4 address.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(66, 0, 'en', 'validation', 'ipv6', 'The :attribute must be a valid IPv6 address.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(67, 0, 'en', 'validation', 'json', 'The :attribute must be a valid JSON string.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(68, 0, 'en', 'validation', 'lt.numeric', 'The :attribute must be less than :value.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(69, 0, 'en', 'validation', 'lt.file', 'The :attribute must be less than :value kilobytes.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(70, 0, 'en', 'validation', 'lt.string', 'The :attribute must be less than :value characters.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(71, 0, 'en', 'validation', 'lt.array', 'The :attribute must have less than :value items.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(72, 0, 'en', 'validation', 'lte.numeric', 'The :attribute must be less than or equal :value.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(73, 0, 'en', 'validation', 'lte.file', 'The :attribute must be less than or equal :value kilobytes.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(74, 0, 'en', 'validation', 'lte.string', 'The :attribute must be less than or equal :value characters.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(75, 0, 'en', 'validation', 'lte.array', 'The :attribute must not have more than :value items.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(76, 0, 'en', 'validation', 'max.numeric', 'The :attribute may not be greater than :max.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(77, 0, 'en', 'validation', 'max.file', 'The :attribute may not be greater than :max kilobytes.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(78, 0, 'en', 'validation', 'max.string', 'The :attribute may not be greater than :max characters.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(79, 0, 'en', 'validation', 'max.array', 'The :attribute may not have more than :max items.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(80, 0, 'en', 'validation', 'mimes', 'The :attribute must be a file of type: :values.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(81, 0, 'en', 'validation', 'mimetypes', 'The :attribute must be a file of type: :values.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(82, 0, 'en', 'validation', 'min.numeric', 'The :attribute must be at least :min.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(83, 0, 'en', 'validation', 'min.file', 'The :attribute must be at least :min kilobytes.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(84, 0, 'en', 'validation', 'min.string', 'The :attribute must be at least :min characters.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(85, 0, 'en', 'validation', 'min.array', 'The :attribute must have at least :min items.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(86, 0, 'en', 'validation', 'not_in', 'The selected :attribute is invalid.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(87, 0, 'en', 'validation', 'not_regex', 'The :attribute format is invalid.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(88, 0, 'en', 'validation', 'numeric', 'The :attribute must be a number.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(89, 0, 'en', 'validation', 'present', 'The :attribute field must be present.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(90, 0, 'en', 'validation', 'regex', 'The :attribute format is invalid.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(91, 0, 'en', 'validation', 'required', 'The :attribute field is required.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(92, 0, 'en', 'validation', 'required_if', 'The :attribute field is required when :other is :value.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(93, 0, 'en', 'validation', 'required_unless', 'The :attribute field is required unless :other is in :values.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(94, 0, 'en', 'validation', 'required_with', 'The :attribute field is required when :values is present.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(95, 0, 'en', 'validation', 'required_with_all', 'The :attribute field is required when :values is present.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(96, 0, 'en', 'validation', 'required_without', 'The :attribute field is required when :values is not present.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(97, 0, 'en', 'validation', 'required_without_all', 'The :attribute field is required when none of :values are present.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(98, 0, 'en', 'validation', 'same', 'The :attribute and :other must match.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(99, 0, 'en', 'validation', 'size.numeric', 'The :attribute must be :size.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(100, 0, 'en', 'validation', 'size.file', 'The :attribute must be :size kilobytes.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(101, 0, 'en', 'validation', 'size.string', 'The :attribute must be :size characters.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(102, 0, 'en', 'validation', 'size.array', 'The :attribute must contain :size items.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(103, 0, 'en', 'validation', 'string', 'The :attribute must be a string.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(104, 0, 'en', 'validation', 'timezone', 'The :attribute must be a valid zone.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(105, 0, 'en', 'validation', 'unique', 'The :attribute has already been taken.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(106, 0, 'en', 'validation', 'uploaded', 'The :attribute failed to upload.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(107, 0, 'en', 'validation', 'url', 'The :attribute format is invalid.', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(108, 0, 'en', 'validation', 'custom.attribute-name.rule-name', 'custom-message', '2018-07-02 04:48:25', '2018-08-02 13:01:47'),
	(109, 0, 'vi', 'auth', 'failed', 'xin chào', '2018-07-02 05:11:48', '2018-08-02 13:01:47'),
	(111, 0, 'en', 'home', 'home_title', 'Home', '2018-07-02 05:14:14', '2018-08-02 13:01:47'),
	(112, 0, 'vi', 'home', 'home_title', 'Tiêu đề 1 2', '2018-07-02 05:14:48', '2018-08-02 13:01:47'),
	(113, 0, 'vi', 'pagination', 'previous', 'dafds', '2018-07-02 07:03:05', '2018-08-02 13:01:47'),
	(114, 0, 'vi', 'pagination', 'next', 'dasdsa', '2018-07-02 07:03:12', '2018-08-02 13:01:47'),
	(116, 0, 'en', 'auth', 'throttle', NULL, '2018-08-01 11:48:07', '2018-08-01 11:48:07'),
	(117, 0, 'en', '_json', 'Username', NULL, '2018-08-01 11:48:07', '2018-08-01 11:48:07'),
	(118, 0, 'en', '_json', 'laravel-filemanager::lfm', NULL, '2018-08-01 11:48:07', '2018-08-01 11:48:07'),
	(120, 0, 'en', 'test', 'dsadsa', 'vcxv', '2018-08-01 12:49:11', '2018-08-02 13:01:47'),
	(122, 0, 'vi', 'test', 'dsadsa', 'fdsafds', '2018-08-01 12:57:29', '2018-08-02 13:01:47'),
	(124, 0, 'en', 'test', 'gfgdf', 'gfdsgdsf', '2018-08-01 12:57:57', '2018-08-02 13:01:47'),
	(125, 0, 'en', 'test', 'gfdsgf', 'gfdsgfds', '2018-08-01 12:57:57', '2018-08-02 13:01:47'),
	(126, 0, 'en', 'test', 'gdfsgf', 'gfdsgf', '2018-08-01 12:57:57', '2018-08-02 13:01:47'),
	(130, 0, 'en', 'wallet', 'title', 'fdsafdsa', '2018-08-01 13:03:54', '2018-08-02 13:01:47'),
	(131, 0, 'en', 'wallet', 'fdsafdsa', 'dfsafdasfdsa', '2018-08-01 13:13:29', '2018-08-02 13:01:47'),
	(132, 0, 'en', 'wallet', 'fdsa', 'fdasfdsafdas', '2018-08-01 13:13:29', '2018-08-02 13:01:47'),
	(133, 0, 'en', 'wallet', 'fds', 'fdas', '2018-08-01 13:13:29', '2018-08-02 13:01:47'),
	(134, 0, 'en', 'wallet', 'afd', 'fdsafdsa', '2018-08-01 13:13:29', '2018-08-02 13:01:47'),
	(135, 0, 'en', 'wallet', 'asf', 'fdsafdsa', '2018-08-01 13:13:29', '2018-08-02 13:01:47'),
	(136, 0, 'en', 'wallet', 'dsa', 'fdsa', '2018-08-01 13:13:29', '2018-08-02 13:01:47'),
	(137, 0, 'en', 'profiles', 'login', 'login', '2018-08-02 12:46:26', '2018-08-02 13:01:47'),
	(138, 0, 'en', 'profiles', 'register', 'register', '2018-08-02 12:46:26', '2018-08-02 13:01:47'),
	(139, 0, 'en', 'profiles', 'logout', 'logout', '2018-08-02 12:46:26', '2018-08-02 13:01:47'),
	(140, 0, 'en', 'profiles', 'profile', 'profile', '2018-08-02 12:46:26', '2018-08-02 13:01:47'),
	(141, 0, 'vi', 'profiles', 'login', 'đăng nhập', '2018-08-02 12:47:23', '2018-08-02 13:01:47'),
	(142, 0, 'vi', 'profiles', 'logout', 'đăng xuất', '2018-08-02 12:47:28', '2018-08-02 13:01:47'),
	(143, 0, 'vi', 'profiles', 'profile', 'profile', '2018-08-02 12:47:40', '2018-08-02 13:01:47'),
	(144, 0, 'vi', 'profiles', 'register', 'đăng ký', '2018-08-02 12:47:45', '2018-08-02 13:01:47'),
	(145, 0, 'en', 'profiles', 'account', 'acount', '2018-08-02 13:00:22', '2018-08-02 13:01:47'),
	(146, 0, 'vi', 'profiles', 'account', 'tài khoản', '2018-08-02 13:00:40', '2018-08-02 13:01:47'),
	(147, 0, 'en', 'profiles', 'changepassword', 'change password', '2018-08-02 13:01:19', '2018-08-02 13:01:47'),
	(148, 0, 'vi', 'profiles', 'changepassword', 'đổi mật khẩu', '2018-08-02 13:01:41', '2018-08-02 13:01:47');
/*!40000 ALTER TABLE `ltm_translations` ENABLE KEYS */;

-- Dumping structure for table core.menu
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` text COLLATE utf8_unicode_ci NOT NULL,
  `menu_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT '0',
  `level` int(11) DEFAULT '1',
  `children_count` int(11) DEFAULT '0',
  `sort_order` int(11) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table core.menu: ~12 rows (approximately)
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` (`id`, `name`, `url`, `menu_type`, `parent_id`, `level`, `children_count`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
	(60, 'Mua mã thẻ', '/muamathe', 'header', 0, 1, 0, 1, 1, '2018-08-06 09:16:17', '2018-08-13 21:05:23'),
	(61, 'Đổi thẻ cào', '/doithecao', 'header', 0, 1, 0, 2, 1, '2018-08-06 09:16:37', '2018-10-08 08:07:54'),
	(71, 'Tin tức', 'tin-tuc', 'header', 0, 1, 0, 5, 1, '2018-08-13 02:52:37', '2018-08-17 22:41:39'),
	(73, 'Chính sách', '#', 'footer', 0, 1, 4, 22, 1, '2018-08-17 20:11:21', '2018-08-17 20:11:21'),
	(74, 'Hướng dẫn', '#', 'footer', 0, 1, 4, 33, 1, '2018-08-17 20:11:35', '2018-09-12 08:10:52'),
	(79, 'Về chúng tôi', '#', NULL, 73, 2, 0, 1, 1, '2018-08-17 20:12:08', '2018-08-17 20:12:08'),
	(80, 'Giới thiệu chung tâm', '#', NULL, 73, 2, 0, 2, 1, '2018-08-17 20:12:42', '2018-08-17 20:12:42'),
	(81, 'Chính sách bảo mật', '#', NULL, 73, 2, 0, 3, 1, '2018-08-17 20:13:34', '2018-08-17 20:13:34'),
	(83, 'Về chúng tôi 234234', '#', NULL, 74, 2, 0, 1, 1, '2018-08-17 20:12:08', '2018-09-12 08:10:52'),
	(84, 'Giới thiệu chung tâm', '#', NULL, 74, 2, 0, 2, 1, '2018-08-17 20:12:42', '2018-08-17 20:12:42'),
	(85, 'Chính sách bảo mật', '#', NULL, 74, 2, 0, 3, 1, '2018-08-17 20:13:34', '2018-08-17 20:13:34'),
	(87, 'Nạp cước', '/mtopup', 'header', 0, 1, 0, 3, 1, '2019-01-11 00:48:45', '2019-01-11 00:48:45');
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;

-- Dumping structure for table core.merchants
CREATE TABLE IF NOT EXISTS `merchants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `partner_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `partner_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `wallet_num` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ips` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `callback` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `callback_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'POST',
  `description` text COLLATE utf8_unicode_ci,
  `status` int(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `partner_id` (`partner_id`),
  UNIQUE KEY `partner_key` (`partner_key`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table core.merchants: ~0 rows (approximately)
/*!40000 ALTER TABLE `merchants` DISABLE KEYS */;
INSERT INTO `merchants` (`id`, `user`, `name`, `partner_id`, `partner_key`, `wallet_num`, `ips`, `callback`, `callback_type`, `description`, `status`, `created_at`, `updated_at`) VALUES
	(2, 25, 'Nguyen Neo', '0601968451', '6dd372151552c79c1fbabc49d02829f4', '0071070849', NULL, 'http://webthetest.com/chargingws/Napcuoc/callback', 'POST', NULL, 1, '2019-06-02 11:41:34', '2019-06-02 11:41:34');
/*!40000 ALTER TABLE `merchants` ENABLE KEYS */;

-- Dumping structure for table core.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table core.migrations: ~8 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2018_06_21_160547_create_permission_tables', 2),
	(4, '2018_06_21_160736_create_products_table', 2),
	(5, '2014_04_02_193005_create_translations_table', 3),
	(6, '2018_07_25_162512_create_weblink_table', 4),
	(7, '2018_07_26_023843_create_groups_table', 4),
	(8, '2018_07_26_064856_create_currencies_table', 5);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table core.model_has_permissions
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_type_model_id_index` (`model_type`,`model_id`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table core.model_has_permissions: ~2 rows (approximately)
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
	(1, 'App\\User', 1),
	(3, 'App\\User', 1);
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;

-- Dumping structure for table core.model_has_roles
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` int(10) unsigned NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_type_model_id_index` (`model_type`,`model_id`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table core.model_has_roles: ~5 rows (approximately)
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
	(2, 'App\\User', 1),
	(3, 'App\\User', 1),
	(5, 'App\\User', 25),
	(5, 'App\\User', 30),
	(5, 'App\\User', 31);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;

-- Dumping structure for table core.news
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `news_slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `short_description` text COLLATE utf8_unicode_ci,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `author` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `author_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `language` varchar(9) COLLATE utf8_unicode_ci DEFAULT NULL,
  `custom_layout` tinyint(2) DEFAULT NULL,
  `view_count` int(11) DEFAULT '0',
  `seo` int(11) DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1',
  `publish_date` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table core.news: ~0 rows (approximately)
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` (`id`, `title`, `news_slug`, `short_description`, `content`, `author`, `author_email`, `image`, `language`, `custom_layout`, `view_count`, `seo`, `status`, `publish_date`, `created_at`, `updated_at`) VALUES
	(1, 'Bỏ túi 3 điều cần lưu ý khi vay tiền mua nhà', 'bo-tui-3-dieu-can-luu-y-khi-vay-tien-mua-nha', 'Vay tiền mua nhà là điều được nhiều người lựa chọn để có được một nơi an cư lạc nghiệp trước tình trạng giá bất động sản leo thang từng ngày như hiện nay. Tuy nhiên, để có được một quyết định chính xác và không phải gánh một khoản nợ quá lớn thì bạn nên lưu ý 3 điều sau khi vay tiền.', '<p><strong>Vay tiền mua nhà</strong>&nbsp;là điều được nhiều người lựa chọn để có được một nơi an cư lạc nghiệp trước tình trạng giá bất động sản leo thang từng ngày như hiện nay. Tuy nhiên, để có được một quyết định chính xác và không phải gánh một khoản nợ quá lớn thì bạn nên lưu ý 3 điều sau khi <a href="http://nencer.com" rel="nofollow">vay tiền.</a></p>\r\n\r\n<p><strong>Không nên vay quá 50% giá trị căn nhà</strong></p>\r\n\r\n<p>Đừng “đánh bài liều” mà vay với số tiền quá lớn. Trước khi quyết định&nbsp;<strong>vay tiền mua nhà</strong>&nbsp;thì bạn cần phải có được một khoản tích lũy ít nhất là bằng 50% giá trị căn nhà định mua. Khi đó, bạn chỉ cần vay tối đa 50% còn lại.&nbsp; Theo các chuyên gia tư vấn tài chính thì đây là mức vay lý tưởng nhất đối với bạn. Nó vừa giảm được áp lực về lãi suất mà còn giúp bạn có thể nhanh chóng trả hết khoản vay trong một thời gian ngắn.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><img alt="vay tiền mua nhà" src="http://beta.tygia.vn/storage/userfiles/images/news/vay-tien-de-mua-nha-can-luu-y-nhung-gi.JPG" /></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Nắm rõ quy định lãi suất ngân hàng</strong></p>\r\n\r\n<p>Rất nhiều người do không nắm được một quy luật hoạt động cho vay tiền của các ngân hàng hiện nay là “Vốn cố định nhưng lãi vay của ngân hàng thường bị thả nổi". Điều đó có nghĩa là mức lãi suất cho vay ban đầu sẽ rẻ để thu hút khách hàng nhưng nó chỉ áp dụng trong khoảng 12 tháng đầu tiên. Bắt đầu từ tháng thứ 13 thì mức lãi sẽ được điều chỉnh tùy theo quy định của mỗi ngân hàng khác nhau. Tuy nhiên, mức tăng lên thường dao động ở khoảng 3 – 4%. Vì thế, bạn cần được tư vấn chi tiết thông tin về lãi suất trước khi vay để tránh việc gánh một khoản lãi quá lớn.</p>\r\n\r\n<p><strong>Có kế hoạch thanh toán cụ thể</strong></p>\r\n\r\n<p>Hiện nay, việc&nbsp;<strong>vay tiền mua nhà</strong>&nbsp;không còn là điều quá khó khăn. Nhưng việc bạn có khả năng thanh toán hay không mới là điều đáng nói. Bởi nếu bạn vay mà không thanh toán đúng theo quy định sẽ phải chịu các quy định phạt từ phía ngân hàng. Thậm chí, trường hợp của bạn sẽ bị liệt vào danh sách nợ xấu và sẽ khó có thể vay tiền cho những lần sau. Đó là lý mà bạn cần phải xác định rõ 3 điều sau:</p>\r\n\r\n<p>Thứ nhất là khả năng tài chính của bản thân. Với mức thu nhập hàng tháng của mình liệu có đủ để trả tiền vay mua nhà và chi phí sinh hoạt hay không?</p>\r\n\r\n<p>Thứ hai là khả năng tài chính hỗ trợ từ người thân, bạn bè.</p>\r\n\r\n<p>Thứ ba là khả năng xoay hồi nguồn tiền khi cần thiết của mình.</p>\r\n\r\n<p>Nếu bạn đang có ý định&nbsp;<strong>vay tiền mua nhà</strong>&nbsp;thì đừng bỏ qua những yếu tố quan trọng mà chúng tôi đưa ra trên đây. Nó sẽ giúp bạn có được kế hoạch cụ thể, chính xác đối với quyết định mua nhà của mình một cách hiệu quả nhất.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Từ khóa tìm kiếm:&nbsp;</strong>vay mua nhà techcombank, vay tiền mua nhà bidv, vay mua nhà 100%, vay tiền mua nhà lãi suất thấp, vay tiền mua nhà không thế chấp, vay mua nhà agribank, vay mua nhà vietcombank, vay mua nhà vpbank&nbsp;</p>\r\n\r\n<h3><a href="http://beta.tygia.vn/chi-tiet/bo-tui-3-dieu-can-luu-y-khi-vay-tien-mua-nha-459#">TIN LIÊN QUAN</a></h3>', 'God Admin', 'support@nencer.com', NULL, 'vi', NULL, 3, 4, 1, NULL, '2019-04-27 01:41:29', '2019-09-27 19:57:05');
/*!40000 ALTER TABLE `news` ENABLE KEYS */;

-- Dumping structure for table core.notification
CREATE TABLE IF NOT EXISTS `notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(2) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table core.notification: ~0 rows (approximately)
/*!40000 ALTER TABLE `notification` DISABLE KEYS */;
/*!40000 ALTER TABLE `notification` ENABLE KEYS */;

-- Dumping structure for table core.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `order_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Purchase',
  `module` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `currency_id` int(11) NOT NULL,
  `currency_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `payer_id` int(11) NOT NULL,
  `payer_wallet` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payer_info` text COLLATE utf8_unicode_ci COMMENT 'có thể là bill info',
  `payee_id` int(11) NOT NULL,
  `payee_wallet` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `payee_info` text COLLATE utf8_unicode_ci,
  `net_amount` double NOT NULL COMMENT 'Tổng tiền đã gồm tiền hàng, thuế, phí',
  `fees` double NOT NULL COMMENT 'Thuế và phí (chỉ lưu với mục đích xem)',
  `discount` double DEFAULT '0' COMMENT 'Số tiền được giảm',
  `pay_amount` double NOT NULL,
  `paygate_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Cổng thanh toán gì',
  `paygate_trans` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bank_code` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `affiliate_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Mã giới thiệu',
  `status` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'trạng thái đơn hàng',
  `payment` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'trạng thái thanh toán',
  `shipment` int(1) NOT NULL COMMENT '0 hoặc 1',
  `shipment_info` text COLLATE utf8_unicode_ci COMMENT 'Thông tin ship',
  `description` text COLLATE utf8_unicode_ci,
  `admin_note` text COLLATE utf8_unicode_ci,
  `ipaddress` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `request_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `receive_bank_id` int(11) DEFAULT NULL COMMENT 'ID của bank Admin hoac User',
  `creator` int(11) NOT NULL,
  `code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `instant` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expire` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_code` (`order_code`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=168 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table core.orders: ~19 rows (approximately)
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` (`id`, `order_code`, `order_type`, `module`, `currency_id`, `currency_code`, `payer_id`, `payer_wallet`, `payer_info`, `payee_id`, `payee_wallet`, `payee_info`, `net_amount`, `fees`, `discount`, `pay_amount`, `paygate_code`, `paygate_trans`, `bank_code`, `affiliate_code`, `status`, `payment`, `shipment`, `shipment_info`, `description`, `admin_note`, `ipaddress`, `request_id`, `payment_type`, `receive_bank_id`, `creator`, `code`, `token`, `instant`, `created_at`, `updated_at`, `expire`) VALUES
	(148, 'TW15687064629410', 'Transfer', 'Wallet', 1, 'VND', 25, '0071070849', '', 1, '0000000000', 'support@nencer.com', 10000.025, 1100.00025, 0, 11100.025249999999, 'Wallet', NULL, 'Wallet_VND', '', 'completed', 'paid', 0, NULL, 'chuyen tien', '', '127.0.0.1', NULL, 't', NULL, 25, 'T1084C923BA91B433ADB4DFF3B5BC1F92', 'ad8b0a58c19b2a20f7c2a1433842ea0dc7fc0229', NULL, '2019-09-17 14:47:42', '2019-09-17 14:47:53', NULL),
	(149, 'TW15687066691956', 'Transfer', 'Wallet', 1, 'VND', 25, '0071070849', '', 1, '0000000000', 'support@nencer.com', 100000.025, 2000.00025, 0, 102000.02524999999, 'Wallet', NULL, 'Wallet_VND', '', 'completed', 'paid', 0, NULL, 'chuyen tien', '', '127.0.0.1', NULL, 't', NULL, 25, 'TE3916E42325C1FDB015FFABF21A55E7F', 'adc4b252db4602e6441b5ae9b2a11e9a688ff08f', NULL, '2019-09-17 14:51:09', '2019-09-17 14:51:16', NULL),
	(150, 'TW15687067555191', 'Transfer', 'Wallet', 1, 'VND', 25, '0071070849', '', 1, '0000000000', 'support@nencer.com', 10000.025, 1100.00025, 0, 11100.025249999999, 'Wallet', NULL, 'Wallet_VND', '', 'none', 'none', 0, NULL, 'chuyen tien', '', '127.0.0.1', NULL, 't', NULL, 25, 'T37A9F796CD2B85FE7250648AA6DDA720', '324e774c469748a08368230b976733326ad9cecc', NULL, '2019-09-17 14:52:35', '2019-09-17 14:52:35', NULL),
	(152, 'TW15687298432270', 'Transfer', 'Wallet', 1, 'VND', 25, '0071070849', '', 1, '0000000000', 'support@nencer.com', 300000, 4000, 0, 304000, 'Wallet', NULL, 'Wallet_VND', '', 'none', 'none', 0, NULL, 'dsfs dsf dsfdf', '', '127.0.0.1', NULL, 't', NULL, 25, 'T749F65A64F3CDD4BF6223804506DD1A4', 'df98341a493b7df5f77dc3a82347e8c7228c5a57', NULL, '2019-09-17 21:17:23', '2019-09-17 21:17:23', NULL),
	(153, 'TW15687306896292', 'Transfer', 'Wallet', 1, 'VND', 25, '0071070849', '', 1, '0000000000', 'support@nencer.com', 300000, 4000, 0, 304000, 'Wallet', NULL, 'Wallet_VND', '', 'completed', 'paid', 0, NULL, 'dsfs dsf dsfdf', '', '127.0.0.1', NULL, 't', NULL, 25, 'T198A8517A637FC06DD2B73A07739B362', '11f70c576f26379fd4e13bdc149bc35377b90bad', NULL, '2019-09-17 21:31:29', '2019-09-17 21:31:42', NULL),
	(154, 'D156873396987821', 'Deposit', 'Wallet', 1, 'VND', 1, '0000000000', '', 25, '0071070849', '', 600000, 0, 0, 600000, 'Wallet', NULL, NULL, '', 'completed', 'paid', 0, NULL, 'Admin cộng tiền: ví 0071070849 thời gian 17-09-2019 22:25:49', 'AdminDeposit', '127.0.0.1', NULL, NULL, NULL, 1, 'DBD61B4FA603134B6B067E478C9BBF0CF', '22df65eb012e46779e13cf90e20a9da83373e9ed', NULL, '2019-09-17 22:26:09', '2019-09-17 22:26:09', NULL),
	(155, 'W156873398887388', 'Withdraw', 'Wallet', 1, 'VND', 25, '0071070849', '', 1, '0000000000', '', 600000, 0, 0, 600000, 'Wallet', NULL, NULL, '', 'completed', 'paid', 0, NULL, 'Admin trừ tiền: ví 0071070849 thời gian 17-09-2019 22:26:22', 'AdminWithdraw', '127.0.0.1', NULL, NULL, NULL, 1, 'W2C22605C598FA89E5B1A1CCCF9DAB160', 'a041a04ef19cb19eca11d9cff51ac192c92c4c4d', NULL, '2019-09-17 22:26:28', '2019-09-17 22:26:28', NULL),
	(156, 'C156916218013873', 'Charging', 'Charging', 1, 'VND', 1, '0000000000', '', 25, '0071070849', NULL, 70000, 0, 0, 70000, 'Wallet', NULL, NULL, '', 'completed', 'paid', 0, NULL, 'Nạp tiền từ đơn hàng đổi thẻ: 423423434 / 9947676599998', '', '', NULL, NULL, NULL, 25, 'C8BBB304DF733B0D843D567E891AC6AB1', NULL, NULL, '2019-09-22 21:23:00', '2019-09-22 21:23:00', NULL),
	(157, 'C156916265571361', 'Charging', 'Charging', 1, 'VND', 1, '0000000000', '', 25, '0071070849', NULL, 70000, 0, 0, 70000, 'Wallet', NULL, NULL, '', 'completed', 'paid', 0, NULL, 'Nạp tiền từ đơn hàng đổi thẻ: 5454435423 / 9999965465658', '', '', NULL, NULL, NULL, 25, 'CD1B5981A850316F49C3497ED8C49CBA1', NULL, NULL, '2019-09-22 21:30:55', '2019-09-22 21:30:55', NULL),
	(158, 'MW15694186584160', 'Buy', 'Mtopup', 1, 'VND', 25, '0071070849', 'hotronet@gmail.com', 1, '0000000000', NULL, 78000, 0, 0, 78000, 'Wallet', NULL, 'Wallet_VND', '', 'none', 'none', 0, NULL, 'Nạp cước cho thuê bao: 0943794545', '', '127.0.0.1', NULL, 'p', NULL, 25, 'M91A8919D6F75D6F64F1484F0225A7860', 'e9dfb2700294210a2b5a6ecc8e7fcbfad72140f2', NULL, '2019-09-25 20:37:38', '2019-09-25 20:37:38', NULL),
	(159, 'MW15694224465099', 'Buy', 'Mtopup', 1, 'VND', 25, '0071070849', 'hotronet@gmail.com', 1, '0000000000', NULL, 78000, 0, 0, 78000, 'Wallet', NULL, 'Wallet_VND', '', 'none', 'none', 0, NULL, 'Nạp cước cho thuê bao: 0943794545', '', '127.0.0.1', NULL, 'p', NULL, 25, 'M06B4EE09676FDD404FF27761F00B0ADD', '46ffb308141133368305e07f3fac31070dfa1cae', NULL, '2019-09-25 21:40:46', '2019-09-25 21:40:46', NULL),
	(160, 'MW15694225636819', 'Buy', 'Mtopup', 1, 'VND', 25, '0071070849', 'hotronet@gmail.com', 1, '0000000000', NULL, 78000, 0, 0, 78000, 'Wallet', NULL, 'Wallet_VND', '', 'pending', 'paid', 0, NULL, 'Nạp cước cho thuê bao: 0943794545', '', '127.0.0.1', NULL, 'p', NULL, 25, 'M0F056FAE871D0FB15020557CD75190E6', 'bc681e6822185d2c5ec44dc40f4521543de3cad0', NULL, '2019-09-25 21:42:43', '2019-09-25 21:42:49', NULL),
	(161, 'TW15695886326855', 'Transfer', 'Wallet', 1, 'VND', 25, '0071070849', '', 1, '0000000000', 'support@nencer.com', 100000, 2000, 0, 102000, 'Wallet', NULL, 'Wallet_VND', '', 'completed', 'paid', 0, NULL, 'cjlklklk', '', '127.0.0.1', NULL, 't', NULL, 25, 'T6D0F3396C96E9022907899FCF9DC715E', '722b711698a50c7b9c635b89c95243c697e31eb6', NULL, '2019-09-27 19:50:32', '2019-09-27 19:50:42', NULL),
	(162, 'D156958977033490', 'Deposit', 'Wallet', 1, 'VND', 1, '0000000000', '', 30, '0032764404', '', 5000000, 0, 0, 5000000, 'Wallet', NULL, NULL, '', 'completed', 'paid', 0, NULL, 'Admin cộng tiền: ví 0032764404 thời gian 27-09-2019 20:09:19', 'AdminDeposit', '127.0.0.1', NULL, NULL, NULL, 1, 'D35E97D3476BD9C56B661AC80EBE10AAD', 'c5c0fbb619852d3a20ead6a590ab1768314b5c95', NULL, '2019-09-27 20:09:30', '2019-09-27 20:09:30', NULL),
	(163, 'TW15695898844204', 'Transfer', 'Wallet', 1, 'VND', 30, '0032764404', '', 25, '0071070849', 'hotronet@gmail.com', 100000, 2000, 0, 102000, 'Wallet', NULL, 'Wallet_VND', '', 'completed', 'paid', 0, NULL, 'chuyen thu', '', '127.0.0.1', NULL, 't', NULL, 30, 'T6D09A78A0153C6CF4A4EC105D30F9BDC', '76140cf4b1d236c75371a986aa6b2b45e5a9b553', NULL, '2019-09-27 20:11:24', '2019-09-27 20:11:39', NULL),
	(164, 'TW15695899391855', 'Transfer', 'Wallet', 1, 'VND', 30, '0032764404', '', 25, '0071070849', 'hotronet@gmail.com', 200000, 3000, 0, 203000, 'Wallet', NULL, 'Wallet_VND', '', 'completed', 'paid', 0, NULL, 'chuyen lan 2', '', '127.0.0.1', NULL, 't', NULL, 30, 'T43ACB9869D84AB0EDC7EE5FE3528977C', '71f0d22ab9ef8bbb69d0cf252d8ad6f1de48d898', NULL, '2019-09-27 20:12:19', '2019-09-27 20:12:38', NULL),
	(165, 'TW15695923246074', 'Transfer', 'Wallet', 1, 'VND', 25, '0071070849', '', 30, '0032764404', 'hotronet1', 50000, 1500, 0, 51500, 'Wallet', NULL, 'Wallet_VND', '', 'completed', 'paid', 0, NULL, 'chueyen a a', '', '127.0.0.1', NULL, 't', NULL, 25, 'T04CD53B909E59F728F42DF0BD06B9570', '5f78f76263194f749215e305c60adff74ef505bf', NULL, '2019-09-27 20:52:04', '2019-09-27 20:52:13', NULL),
	(166, 'TW15695929944306', 'Transfer', 'Wallet', 1, 'VND', 25, '0071070849', '', 30, '0032764404', 'hotronet1', 300000, 4000, 0, 304000, 'Wallet', NULL, 'Wallet_VND', '', 'completed', 'paid', 0, NULL, 'chuyen', '', '127.0.0.1', NULL, 't', NULL, 25, 'TB8436F6D3C2A235EB3FA08C1E439517F', '257c0d177bf08646e21aad7dcd4de34c8deb3d33', NULL, '2019-09-27 21:03:14', '2019-09-27 21:03:22', NULL),
	(167, 'TW15695940208441', 'Transfer', 'Wallet', 1, 'VND', 30, '0032764404', '', 25, '0071070849', 'hotronet@gmail.com', 100000, 2000, 0, 102000, 'Wallet', NULL, 'Wallet_VND', '', 'completed', 'paid', 0, NULL, '43 435 345', '', '127.0.0.1', NULL, 't', NULL, 30, 'T75DA59C22A8482DC116D24F886491799', 'd4297a1fe96b7ae1fad5053b1d40ac772cf70e47', NULL, '2019-09-27 21:20:20', '2019-09-27 21:20:31', NULL);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;

-- Dumping structure for table core.order_items
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `currency_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `product_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_sku` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `product_qty` int(11) NOT NULL,
  `product_price` double NOT NULL,
  `product_tax` double NOT NULL,
  `subtotal` double NOT NULL,
  `options` text COLLATE utf8_unicode_ci NOT NULL,
  `module` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Module xử lý item',
  `provider_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Mã nhà cung cấp',
  `provider_key` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `admin_note` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Thông tin mã thẻ trả về',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table core.order_items: ~0 rows (approximately)
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;

-- Dumping structure for table core.pages
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `language` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seo` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table core.pages: ~0 rows (approximately)
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` (`id`, `title`, `slug`, `image`, `status`, `description`, `language`, `seo`, `created_at`, `updated_at`) VALUES
	(1, 'Điểu khoản sử dụng3', 'dieu-khoan-su-dung3', NULL, 1, '<p>&nbsp;rwerwe wer we rêr wwwwwwwwwwwwwwwwwwwww</p>', 'vi', 5, '2019-08-31 15:36:22', '2019-08-31 15:49:07');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;

-- Dumping structure for table core.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table core.password_resets: ~0 rows (approximately)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
	('hotronet@gmail.com', '$2y$10$/2fCvS2y9zQ3pNRtjF4fOOwPFrDyZu9mUf9yaPCLj4tHdsrd/qHUW', '2019-01-01 08:45:15');
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Dumping structure for table core.paygates
CREATE TABLE IF NOT EXISTS `paygates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `currency_id` int(11) NOT NULL,
  `currency_code` varchar(10) NOT NULL,
  `code` varchar(255) NOT NULL,
  `paygate` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `withdraw` tinyint(4) NOT NULL DEFAULT '0',
  `withdrawField` text,
  `deposit` tinyint(4) NOT NULL DEFAULT '0',
  `payment` tinyint(4) NOT NULL DEFAULT '0',
  `instant` tinyint(4) DEFAULT '0',
  `verify` tinyint(4) DEFAULT '0',
  `convert` tinyint(4) DEFAULT '0',
  `description` text,
  `avatar` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `configs` text,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `w_fixed_fees` varchar(255) DEFAULT NULL,
  `w_percent_fees` varchar(255) DEFAULT NULL,
  `w_daily_limit` varchar(255) DEFAULT NULL,
  `w_country_block` varchar(255) DEFAULT NULL,
  `w_min` varchar(255) DEFAULT NULL,
  `w_max` varchar(255) DEFAULT NULL,
  `w_nofees` varchar(255) DEFAULT NULL,
  `d_fixed_fees` varchar(255) DEFAULT NULL,
  `d_percent_fees` varchar(255) DEFAULT NULL,
  `d_daily_limit` varchar(255) DEFAULT NULL,
  `d_country_block` varchar(255) DEFAULT NULL,
  `d_min` varchar(255) DEFAULT NULL,
  `d_max` varchar(255) DEFAULT NULL,
  `d_nofees` varchar(255) DEFAULT NULL,
  `p_fixed_fees` varchar(255) DEFAULT NULL,
  `p_percent_fees` varchar(255) DEFAULT NULL,
  `p_daily_limit` varchar(255) DEFAULT NULL,
  `p_country_block` varchar(255) DEFAULT NULL,
  `p_min` varchar(255) DEFAULT NULL,
  `p_max` varchar(255) DEFAULT NULL,
  `p_nofees` varchar(255) DEFAULT NULL,
  `allow_groups` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

-- Dumping data for table core.paygates: ~4 rows (approximately)
/*!40000 ALTER TABLE `paygates` DISABLE KEYS */;
INSERT INTO `paygates` (`id`, `currency_id`, `currency_code`, `code`, `paygate`, `name`, `withdraw`, `withdrawField`, `deposit`, `payment`, `instant`, `verify`, `convert`, `description`, `avatar`, `url`, `configs`, `status`, `w_fixed_fees`, `w_percent_fees`, `w_daily_limit`, `w_country_block`, `w_min`, `w_max`, `w_nofees`, `d_fixed_fees`, `d_percent_fees`, `d_daily_limit`, `d_country_block`, `d_min`, `d_max`, `d_nofees`, `p_fixed_fees`, `p_percent_fees`, `p_daily_limit`, `p_country_block`, `p_min`, `p_max`, `p_nofees`, `allow_groups`, `created_at`, `updated_at`) VALUES
	(28, 1, 'VND', 'Vietcombank', 'Vietcombank', 'Vietcombank Tự động', 1, '[]', 1, 1, 1, 0, 0, NULL, '/storage/userfiles/images/nencer-fav.png', 'http://149.28.151.147/api/v1/kiem-tra-giao-dich', '{"username":"2182635A59","password":"Xuanhk2011@","account_name":"NGUYEN VAN HAU","account_number":"0031000495366"}', 1, '{"1":null,"2":null,"3":null}', '{"1":"1","2":"1","3":"1"}', '{"1":null,"2":null,"3":null}', NULL, '{"1":null,"2":null,"3":null}', '{"1":null,"2":null,"3":null}', '{"1":null,"2":null,"3":null}', '{"1":null,"2":null,"3":null}', '{"1":"1","2":"1","3":"1"}', '{"1":null,"2":null,"3":null}', NULL, '{"1":null,"2":null,"3":null}', '{"1":null,"2":null,"3":null}', '{"1":null,"2":null,"3":null}', '{"1":null,"2":null,"3":null}', '{"1":"1","2":"1","3":"1"}', '{"1":null,"2":null,"3":null}', NULL, '{"1":null,"2":null,"3":null}', '{"1":null,"2":null,"3":null}', '{"1":null,"2":null,"3":null}', NULL, '2019-04-24 12:20:14', '2019-07-27 08:29:08'),
	(29, 1, 'VND', 'OnepayND', 'OnepayND', 'Onepay Nội địa', 0, '[]', 1, 1, 1, 0, 0, NULL, '/storage/userfiles/images/nencer-fav.png', 'http://mtf.onepay.vn/onecomm-pay/vpc.op', '{"merchant_id":null,"access_code":null,"secure_secret":null}', 0, '{"1":null,"2":null,"3":null}', '{"1":null,"2":null,"3":null}', '{"1":null,"2":null,"3":null}', NULL, '{"1":null,"2":null,"3":null}', '{"1":null,"2":null,"3":null}', '{"1":null,"2":null,"3":null}', '{"1":null,"2":null,"3":null}', '{"1":null,"2":null,"3":null}', '{"1":null,"2":null,"3":null}', NULL, '{"1":null,"2":null,"3":null}', '{"1":null,"2":null,"3":null}', '{"1":null,"2":null,"3":null}', '{"1":null,"2":null,"3":null}', '{"1":null,"2":null,"3":null}', '{"1":null,"2":null,"3":null}', NULL, '{"1":null,"2":null,"3":null}', '{"1":null,"2":null,"3":null}', '{"1":null,"2":null,"3":null}', NULL, '2019-05-28 04:31:47', '2019-07-27 08:33:19'),
	(30, 1, 'VND', 'Localbank_ACB', 'Localbank', 'Ngân hàng ACB', 1, '["acc_name","acc_num","branch"]', 1, 1, 0, 0, 0, NULL, NULL, NULL, NULL, 1, '0.0000', '0.0000', NULL, NULL, NULL, NULL, NULL, '0.0000', '0.0000', NULL, NULL, NULL, NULL, NULL, '0.0000', '0.0000', NULL, NULL, NULL, NULL, NULL, NULL, '2019-05-28 05:09:12', '2019-05-28 05:09:12'),
	(33, 2, 'USD', 'Paypal', 'Paypal', 'Cổng thanh toán Paypal', 0, '[]', 1, 1, 1, 0, 0, '', '/storage/userfiles/images/nencer-fav.png', 'https://www.paypal.com/webscr&cmd=_express-checkout&token=', '{"Username":"","Password":"","Signature":"","CurrencyCode":"USD"}', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-07-27 03:52:30', '2019-07-27 03:52:30');
/*!40000 ALTER TABLE `paygates` ENABLE KEYS */;

-- Dumping structure for table core.paygates_logs
CREATE TABLE IF NOT EXISTS `paygates_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user` int(11) DEFAULT NULL,
  `pay_amount` double NOT NULL,
  `currency_id` tinyint(4) DEFAULT NULL,
  `currency_code` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `provider` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bank_code` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `post_logs` text COLLATE utf8_unicode_ci,
  `payment_logs` text COLLATE utf8_unicode_ci,
  `callback_logs` text COLLATE utf8_unicode_ci,
  `ip` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table core.paygates_logs: ~2 rows (approximately)
/*!40000 ALTER TABLE `paygates_logs` DISABLE KEYS */;
INSERT INTO `paygates_logs` (`id`, `order_code`, `user`, `pay_amount`, `currency_id`, `currency_code`, `provider`, `bank_code`, `post_logs`, `payment_logs`, `callback_logs`, `ip`, `country`, `user_agent`, `created_at`, `updated_at`) VALUES
	(19, 'D155627804775921', 25, 5000, NULL, NULL, 'Vietcombank', NULL, 'username=2182635A59&password=Xuanhk2011@&stk=0031000495366&noidung=D155627804775921++CAN_THAN_LUA_DAO++>>>GOI:0943793984&sotien=5000', '{\n  "errorCode": 1,\n  "message": "khong co giao dich"\n}', NULL, NULL, NULL, NULL, '2019-04-26 14:15:07', '2019-04-26 14:15:07'),
	(20, 'D155629360337653', 25, 6000, NULL, NULL, 'Vietcombank', NULL, 'username=2182635A59&password=Xuanhk2011@&stk=0031000495366&noidung=D155629360337653++CAN_THAN_LUA_DAO++GOI:0943793984&sotien=6000', '{\n  "errorCode": 1,\n  "message": "khong co giao dich"\n}', NULL, NULL, NULL, NULL, '2019-04-26 15:51:42', '2019-04-26 15:51:42');
/*!40000 ALTER TABLE `paygates_logs` ENABLE KEYS */;

-- Dumping structure for table core.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table core.permissions: ~9 rows (approximately)
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `description`, `created_at`, `updated_at`) VALUES
	(1, 'list', 'web', 'Quyền xem danh sách', '2018-06-21 02:14:46', '2018-06-21 02:14:46'),
	(2, 'create', 'web', 'Quyền tạo mới', '2018-06-21 02:14:46', '2018-06-21 02:14:46'),
	(3, 'edit', 'web', 'Quyền sửa', '2018-06-21 02:14:46', '2018-06-21 02:14:46'),
	(4, 'delete', 'web', 'Quyền xóa dữ liệu', '2018-06-21 02:14:46', '2019-08-29 00:52:35'),
	(12, 'view', 'web', 'Quyền được xem chi tiết bản ghi nào đó', '2019-08-29 00:54:33', '2019-08-29 00:54:33'),
	(13, 'viewstats', 'web', 'Quyền xem thống kê', '2019-08-29 01:17:22', '2019-08-29 01:17:22'),
	(14, 'user', 'web', 'Quyền của khách hàng', '2019-08-29 08:49:22', '2019-08-29 08:49:22'),
	(15, 'addfund', 'web', 'Quyền được nạp tiền cho khách hàng', '2019-08-29 10:22:21', '2019-08-29 10:22:21'),
	(16, 'withdrawfund', 'web', 'Quyền rút tiền của khách hàng', '2019-08-29 10:32:13', '2019-08-29 10:32:13');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;

-- Dumping structure for table core.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '0',
  `url` varchar(250) NOT NULL DEFAULT '0',
  `catalog` int(11) NOT NULL DEFAULT '0',
  `image` int(11) DEFAULT '0',
  `image_other` int(11) DEFAULT '0',
  `description` varchar(500) DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  `public` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table core.products: ~2 rows (approximately)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`id`, `name`, `url`, `catalog`, `image`, `image_other`, `description`, `order`, `public`, `created_at`, `updated_at`) VALUES
	(2, 'Viettel', '1-2-3', 5, 5, 3, 'de', 2, 0, '2018-07-14 16:02:36', '2018-07-14 16:02:36'),
	(3, 'dadsa', 'dasdass', 6, 5, 2, 'dsadas', 1, 1, '2018-07-14 16:03:26', '2018-07-14 16:38:14');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

-- Dumping structure for table core.product_gallery
CREATE TABLE IF NOT EXISTS `product_gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `product_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_thumb` tinyint(2) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table core.product_gallery: ~12 rows (approximately)
/*!40000 ALTER TABLE `product_gallery` DISABLE KEYS */;
INSERT INTO `product_gallery` (`id`, `product_id`, `product_type`, `value`, `label`, `is_thumb`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
	(4, 23, 'softcard', 'softcard/images/vTmCwWWYKn9PxSKxiE0AR1IAE5de4AxgRyRApQvZ.png', '', 0, 0, 1, '2018-08-28 01:35:13', '2018-08-28 01:35:13'),
	(5, 24, 'softcard', 'softcard/images/eXZfOP9avnC6PJL8AE1WQzqowz5NCElwvWhe5Qxr.jpeg', '', 0, 0, 1, '2018-08-28 01:39:50', '2018-08-28 01:39:50'),
	(6, 25, 'softcard', 'softcard/images/KEnEcpCmxEm7apZx2XiwA08S3jYcvAlli5UQRMH1.jpeg', '', 1, 0, 1, '2018-08-28 01:41:21', '2018-08-28 01:41:21'),
	(7, 26, 'softcard', 'softcard/images/JaGV5MmY2Vs78e45Nn1LSjETtlPrVYf2rTwV4kVb.jpeg', '', 1, 0, 1, '2018-08-28 01:47:58', '2018-08-28 01:47:58'),
	(8, 27, 'softcard', 'softcard/images/pesocV2GXgeIK804cn2ZVMBp8kYGHrj7gLdP4erz.jpeg', '', 1, 0, 1, '2018-08-28 01:50:28', '2018-08-28 01:50:28'),
	(9, 28, 'softcard', 'softcard/images/eODhn4E1whFtTp88wM5cGwjfllETtOC88ipLEflf.png', '', 1, 0, 1, '2018-08-28 02:20:01', '2018-08-28 02:20:01'),
	(10, 29, 'softcard', 'softcard/images/oXcdDaH1oCtcYN4vKzGIEpOgWLLa4MY3qTRcEEot.png', '', 1, 0, 1, '2018-08-28 02:20:28', '2018-08-28 02:20:28'),
	(11, 30, 'softcard', 'softcard/images/d0Q0u0c4XKyIh4ckgKiMWmwl40M0yrS4j371eefQ.png', '', 1, 0, 1, '2018-08-28 02:20:47', '2018-08-28 02:20:47'),
	(12, 31, 'softcard', 'softcard/images/cTdppKRLlqqH8YGBcDiCVSLp7luVoBEcQQpdrA8u.png', '', 1, 0, 1, '2018-08-28 02:21:08', '2018-08-28 02:21:08'),
	(13, 32, 'softcard', 'softcard/images/UOrtQztsCJD3VoXHRNKQPQIBWzqlcwxHUSVJEhE9.png', '', 1, 0, 1, '2018-08-28 02:21:36', '2018-08-28 02:21:36'),
	(15, 34, 'softcard', 'softcard/images/dEiavOK9VXyl8A8KNYkYqLUsfawE9gU0R9fHQs31.png', '', 1, 0, 1, '2018-12-20 22:29:11', '2018-12-20 22:29:11'),
	(17, 37, 'softcard', 'softcard/images/dRwKmAKeBK9ObRqfShc9yBbs8kW5PNMeeJHnhd7w.png', '', 1, 0, 1, '2018-12-20 22:59:34', '2018-12-20 22:59:34');
/*!40000 ALTER TABLE `product_gallery` ENABLE KEYS */;

-- Dumping structure for table core.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table core.roles: ~4 rows (approximately)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`id`, `name`, `guard_name`, `description`, `created_at`, `updated_at`) VALUES
	(2, 'BACKEND', 'web', 'Quản trị hệ thống, có quyền backend', '2018-06-20 10:00:00', NULL),
	(3, 'SUPER_ADMIN', 'web', 'Admin tổng có tất cả các quyền', '2018-06-20 10:00:00', '2018-06-29 06:52:31'),
	(5, 'USER', 'web', 'Thành viên', '2018-06-30 11:57:15', '2018-06-30 11:57:15'),
	(7, 'SALES', 'web', 'Vai trò là người bán hàng, được quản lý danh sách và sửa', '2019-08-28 23:18:00', '2019-08-28 23:39:52');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

-- Dumping structure for table core.role_has_permissions
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table core.role_has_permissions: ~16 rows (approximately)
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
	(1, 2),
	(3, 2),
	(12, 2),
	(1, 3),
	(2, 3),
	(3, 3),
	(4, 3),
	(12, 3),
	(13, 3),
	(14, 3),
	(15, 3),
	(16, 3),
	(14, 5),
	(1, 7),
	(2, 7),
	(12, 7);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;

-- Dumping structure for table core.sendform
CREATE TABLE IF NOT EXISTS `sendform` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `identity` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `other_info` text COLLATE utf8_unicode_ci,
  `current_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table core.sendform: ~0 rows (approximately)
/*!40000 ALTER TABLE `sendform` DISABLE KEYS */;
/*!40000 ALTER TABLE `sendform` ENABLE KEYS */;

-- Dumping structure for table core.sendform_fields
CREATE TABLE IF NOT EXISTS `sendform_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `placeholder` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` text COLLATE utf8_unicode_ci,
  `type` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'input',
  `require` tinyint(4) NOT NULL DEFAULT '0',
  `lang` varchar(50) COLLATE utf8_unicode_ci DEFAULT 'vi',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table core.sendform_fields: ~2 rows (approximately)
/*!40000 ALTER TABLE `sendform_fields` DISABLE KEYS */;
INSERT INTO `sendform_fields` (`id`, `key`, `title`, `placeholder`, `value`, `type`, `require`, `lang`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'cmnd', 'CMND/Hộ chiếu', 'CMND hoặc Hộ chiếu', NULL, 'input', 0, 'vi', 1, '2019-08-23 17:21:32', '2019-08-23 17:21:32'),
	(2, 'city', 'Thành phố', 'Tỉnh/Thành phố', 'hanoi,hcm', 'select', 0, 'vi', 1, '2019-08-23 17:21:32', '2019-08-23 17:21:32');
/*!40000 ALTER TABLE `sendform_fields` ENABLE KEYS */;

-- Dumping structure for table core.sendmail_driver
CREATE TABLE IF NOT EXISTS `sendmail_driver` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `driver` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `configs` text COLLATE utf8_unicode_ci,
  `status` int(11) DEFAULT NULL,
  `installed` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `driver` (`driver`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table core.sendmail_driver: ~2 rows (approximately)
/*!40000 ALTER TABLE `sendmail_driver` DISABLE KEYS */;
INSERT INTO `sendmail_driver` (`id`, `name`, `driver`, `configs`, `status`, `installed`) VALUES
	(3, 'Gửi mail bằng Smtp', 'Smtp', '{"host":"smtp.gmail.com","username":"phuonganh5694@gmail.com","password":"147258Abc","port":"587","encryption":"tls","sendmail":"\\/usr\\/sbin\\/sendmail -bs"}', 1, 1),
	(5, 'Gửi mail bằng Amazon Ses', 'Ses', '{"key":"AKIAQGRVXXZJIIR6P6NS","secret":"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","region":"us-east-1"}', 1, 1);
/*!40000 ALTER TABLE `sendmail_driver` ENABLE KEYS */;

-- Dumping structure for table core.sendmail_setting
CREATE TABLE IF NOT EXISTS `sendmail_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `from_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `driver` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table core.sendmail_setting: ~0 rows (approximately)
/*!40000 ALTER TABLE `sendmail_setting` DISABLE KEYS */;
INSERT INTO `sendmail_setting` (`id`, `from_email`, `from_name`, `driver`) VALUES
	(1, 'support@nencer.net', 'Nencer JSC', 'Ses');
/*!40000 ALTER TABLE `sendmail_setting` ENABLE KEYS */;

-- Dumping structure for table core.seo
CREATE TABLE IF NOT EXISTS `seo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `checksum` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `h1` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `noindex` tinyint(4) DEFAULT NULL,
  `avatar` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `language` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `link` (`link`),
  UNIQUE KEY `checksum` (`checksum`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table core.seo: ~5 rows (approximately)
/*!40000 ALTER TABLE `seo` DISABLE KEYS */;
INSERT INTO `seo` (`id`, `link`, `checksum`, `title`, `description`, `h1`, `noindex`, `avatar`, `language`, `created_at`, `updated_at`) VALUES
	(1, '/', 'd41d8cd98f00b204e9800998ecf8427e', 'Bán thẻ game, thẻ điện thoại, đổi thẻ cào, nạp cước', 'Website chúng tôi uy tín cao về bán thẻ game, thẻ điện thoại, đổi thẻ cào, nạp cước với chiết khấu rất hấp dẫn.', 'Bán thẻ game, thẻ điện thoại, đổi thẻ cào, nạp cước', 0, '', 'vi', '2019-04-03 11:55:33', '2019-04-03 11:55:33'),
	(2, '/muamathe', '629a0ee78ce69fe785e2317a3a1f214f', 'Mua mã thẻ điện thoại, thẻ game online', 'Mua mã thẻ điện thoại, thẻ game online', 'Mua mã thẻ điện thoại, thẻ game online', 0, '', 'vi', '2019-04-03 12:03:32', '2019-04-03 12:03:32'),
	(3, '/doithecao', '1fb11ccf80de783b8c1fecef4bebc703', 'Đổi thẻ cào thành tiền mặt giá rẻ', 'Đổi thẻ cào thành tiền mặt giá rẻ', 'Đổi thẻ cào thành tiền mặt giá rẻ', 0, '', 'vi', '2019-04-04 11:46:43', '2019-04-04 11:46:43'),
	(4, 'bo-tui-3-dieu-can-luu-y-khi-vay-tien-mua-nha', '2a85579f25e9beeff6ce92b217e96603', 'Bỏ túi 3 điều cần lưu ý khi vay tiền mua nhà', 'Vay tiền mua nhà là điều được nhiều người lựa chọn để có được một nơi an cư lạc nghiệp trước tình trạng giá bất động sản leo thang từng ngày như hiện nay. Tuy nhiên, để có được một quyết định chính xác và không phải gánh một khoản nợ quá lớn thì bạn nên lưu ý 3 điều sau khi vay tiền.', '', NULL, '', 'vi', '2019-04-27 01:41:29', '2019-04-27 01:41:29'),
	(5, 'dieu-khoan-su-dung3', 'bcc8067fdf8894571f8c0764f27d5097', 'Điểu khoản sử dụng3', 'aser ẻ wer wer', '', NULL, '', 'vi', '2019-08-31 15:36:22', '2019-08-31 15:36:22');
/*!40000 ALTER TABLE `seo` ENABLE KEYS */;

-- Dumping structure for table core.settings
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(250) DEFAULT NULL,
  `value` text,
  `tab` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

-- Dumping data for table core.settings: ~47 rows (approximately)
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` (`id`, `key`, `value`, `tab`, `created_at`, `updated_at`) VALUES
	(1, 'favicon', '/storage/userfiles/images/nencer-fav.png', 'general', NULL, '2019-09-23 22:31:22'),
	(2, 'backendlogo', '/storage/userfiles/images/nencer-logo-gray.png', 'general', NULL, '2019-09-23 22:31:22'),
	(3, 'name', 'CÔNG TY NENCER SOFTWARE', 'general', NULL, '2019-09-23 22:31:22'),
	(4, 'title', 'Đổi thẻ cào, mua thẻ điện thoại, thẻ game online', 'general', NULL, '2019-09-23 22:31:22'),
	(5, 'description', 'Đổi thẻ cào, mua thẻ điện thoại, thẻ game online, bán tài khoản game', 'general', NULL, '2019-09-23 22:31:22'),
	(6, 'language', 'vi', 'general', NULL, '2019-09-23 22:31:22'),
	(7, 'phone', '0943793984', 'general', NULL, '2019-09-23 22:31:22'),
	(8, 'twitter', 'fb.com/admin', 'connection', NULL, '2019-09-23 22:48:51'),
	(9, 'email', 'hotronet@gmail.com', 'general', NULL, '2019-09-23 22:31:22'),
	(10, 'facebook', 'fb.com/admin', 'connection', NULL, '2019-09-23 22:48:51'),
	(11, 'logo', '/storage/userfiles/images/nencer-logo.png', 'general', NULL, '2019-09-23 22:31:22'),
	(12, 'hotline', '0123456789', 'general', NULL, '2019-09-23 22:31:22'),
	(13, 'backendname', 'AdminLTE', 'general', NULL, '2019-09-23 22:31:22'),
	(14, 'backendlang', 'en', 'general', NULL, '2019-09-23 22:31:22'),
	(15, 'copyright', 'Software by Nencer Jsc.,', 'general', NULL, '2019-09-23 22:31:22'),
	(16, 'timezone', 'Asia/Ho_Chi_Minh', 'general', NULL, '2019-09-23 22:31:22'),
	(17, 'googleplus', 'fb.com/admin', 'connection', NULL, '2019-09-23 22:48:51'),
	(18, 'websitestatus', 'ONLINE', 'general', NULL, '2019-09-23 22:31:22'),
	(19, 'address', '35/45 Tran Thai Tong, Cau Giay, Ha Noi', 'general', '2018-08-20 20:53:44', '2019-09-23 22:31:22'),
	(21, 'default_user_group', '2', 'user', '2018-08-20 21:06:25', '2019-09-29 17:20:40'),
	(22, 'twofactor', 'none', 'security', '2018-09-05 07:17:56', '2019-09-23 22:52:40'),
	(23, 'smsprovider', 'none', 'security', '2018-09-27 00:27:47', '2019-09-23 22:52:40'),
	(24, 'fronttemplate', 'default', 'design', NULL, '2019-09-23 23:22:57'),
	(25, 'offline_mes', 'Website đang bảo trì, vui lòng quay lại sau!', 'general', NULL, '2019-09-23 22:31:22'),
	(26, 'youtube', 'https://www.youtube.com/watch?v=neCmEbI2VWg', 'connection', NULL, '2019-09-23 22:48:51'),
	(27, 'globalpopup', '0', 'general', NULL, '2019-09-23 22:31:22'),
	(28, 'globalpopup_mes', '<p>Chưa có nội dung gì</p>', 'general', NULL, '2019-09-23 22:31:22'),
	(29, 'social_login', '0', 'connection', NULL, '2019-09-23 22:48:51'),
	(30, 'google_analytic_id', '321312323', 'connection', NULL, '2019-09-23 22:48:51'),
	(31, 'header_js', 'N/A', 'design', NULL, '2019-09-23 23:22:57'),
	(32, 'footer_js', 'N/A', 'design', NULL, '2019-09-23 23:22:57'),
	(33, 'home_tab_active', 'Softcard', 'design', NULL, '2019-09-23 23:22:57'),
	(34, 'top_bg', '#3b3b3b', 'design', NULL, '2019-09-23 23:22:57'),
	(35, 'slide_bg', '#afafaf', 'design', NULL, '2019-09-23 23:22:57'),
	(36, 'footer_bg', '#004b7f', 'design', NULL, '2019-09-23 23:22:57'),
	(37, 'allow_transfer', '1', 'user', NULL, '2019-09-29 17:20:40'),
	(38, 'top_color', '#ffffff', 'design', NULL, '2019-09-23 23:22:57'),
	(39, 'type_slider', 'slider', 'design', NULL, '2019-09-23 23:22:57'),
	(40, 'require_phone', '0', 'user', NULL, '2019-09-29 17:20:40'),
	(41, 'approve_user', '0', 'user', NULL, '2019-09-29 17:20:40'),
	(42, 'allow_register', '1', 'user', NULL, '2019-09-29 17:20:40'),
	(43, 'require_username', '1', 'user', NULL, '2019-09-29 17:20:40'),
	(44, 'sms_command_code', 'TSR', NULL, NULL, NULL),
	(46, 'sms_gateway_number', '8079', NULL, NULL, NULL),
	(49, 'captcha_service', 'Anticaptcha', NULL, NULL, NULL),
	(50, 'captcha_key', '213124234324', NULL, NULL, NULL),
	(51, 'send_email_order', '0', NULL, NULL, NULL);
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;

-- Dumping structure for table core.settings_meta
CREATE TABLE IF NOT EXISTS `settings_meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `meta_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `h1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `language` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `module` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table core.settings_meta: ~5 rows (approximately)
/*!40000 ALTER TABLE `settings_meta` DISABLE KEYS */;
INSERT INTO `settings_meta` (`id`, `meta_title`, `meta_description`, `h1`, `avatar`, `description`, `language`, `module`, `created_at`, `updated_at`) VALUES
	(1, 'Mua mã thẻ điện thoại, thẻ game online', 'Mua mã thẻ điện thoại, thẻ game online', 'Mua mã thẻ điện thoại, thẻ game online', '', '<p>Thẻ chiết khấu cao, nhiều loại mệnh gi&aacute;, ch&iacute;nh s&aacute;ch đại l&yacute; vui l&ograve;ng li&ecirc;n hệ. Hệ thống hoạt động 24/24, mua thẻ chỉ trong t&iacute;ch tắc.</p>', 'vi', 'Softcard', NULL, NULL),
	(3, 'ểtrtret', 'retretretretreeeeeeee323333333', 'tretretret', '', '<p>retretretrtretrt6666666666666</p>', 'vi', 'Charging', NULL, NULL),
	(6, '213213', '123123', '21312', '', '<p>32132323</p>', 'vi', 'Chargingauto', NULL, NULL),
	(7, '435435', '435435435', '435435', '', '<p>54354354353333333675 345345</p>', 'vi', 'Mtopup', NULL, NULL),
	(8, '23423423', '4234234', '234234', '', '<p>234 324234 234&nbsp; 34</p>', 'vi', 'Topup', NULL, NULL);
/*!40000 ALTER TABLE `settings_meta` ENABLE KEYS */;

-- Dumping structure for table core.settings_module
CREATE TABLE IF NOT EXISTS `settings_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(50) NOT NULL,
  `value` varchar(255) NOT NULL,
  `module` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Dumping data for table core.settings_module: ~9 rows (approximately)
/*!40000 ALTER TABLE `settings_module` DISABLE KEYS */;
INSERT INTO `settings_module` (`id`, `key`, `value`, `module`) VALUES
	(1, 'stopsell', '0', 'Softcard'),
	(2, 'maxbuy', '10', 'Softcard'),
	(3, 'stopcharging', '0', 'Charging'),
	(4, 'maxpendingcard', '100', 'Charging'),
	(6, 'stoptopup', '0', 'Mtopup'),
	(7, 'vtkppotp', '8974', 'Mtopup'),
	(8, 'topup5k', '5000', 'Mtopup'),
	(9, 'send_notify', '0', 'Charging'),
	(10, 'auto_match', '1', 'Charging');
/*!40000 ALTER TABLE `settings_module` ENABLE KEYS */;

-- Dumping structure for table core.sliders
CREATE TABLE IF NOT EXISTS `sliders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slider_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slider_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slider_text` text COLLATE utf8_unicode_ci,
  `slider_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slider_btn_text` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slider_btn_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_order` int(11) DEFAULT '0',
  `status` tinyint(2) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table core.sliders: ~4 rows (approximately)
/*!40000 ALTER TABLE `sliders` DISABLE KEYS */;
INSERT INTO `sliders` (`id`, `slider_name`, `slider_image`, `slider_text`, `slider_url`, `slider_btn_text`, `slider_btn_url`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
	(6, 'Nạp tiền điện thoại chiết khấu cao', 'sliders/Jxwj9cukC8PYAYUePf46mbUUYjOgjOH2EPV5Aaux.jpeg', 'Nạp 3 nhà mạng chính Viettel, Vinaphone, Mobifone với chiết khấu lên đến 20%. Bạn chỉ việc tạo 1 tài khoản, nạp tiền lên website và đặt hàng nạp chậm. Cam kết 100% an toàn và nhanh chóng.', NULL, 'Nạp tại đây', 'http://localhost/webthefull/public/napcham.html', 3, 0, '2018-08-28 03:04:23', '2018-10-04 03:48:01'),
	(7, 'Giao diện BlueZim - Mùa đông xanh', '/storage/userfiles/images/sliders/ezQn4Z0lBkq4fu1GGBICHEEo3wthNU1Uj1OvFoZM.png', 'Cho rằng VEC không phối hợp giải quyết vướng mắc sau thông xe cao tốc, Quảng Ngãi cảnh báo Bộ Giao thông khả năng người dân chặn đường.', NULL, 'Mua ngay', '#', 2, 1, '2018-10-07 00:57:39', '2018-11-01 03:57:09'),
	(8, '234234234', '/storage/userfiles/images/sliders/home10_han_1524318586.jpg', '4234234', NULL, '2323', '423432', 2, 0, '2018-10-20 22:36:17', '2018-10-20 23:53:30'),
	(10, 'Lễ hội bia Nga', '/storage/userfiles/images/sliders/home3_han_1524318709.jpg', NULL, NULL, NULL, NULL, NULL, 0, '2018-10-20 22:55:27', '2018-10-20 22:55:27');
/*!40000 ALTER TABLE `sliders` ENABLE KEYS */;

-- Dumping structure for table core.slugs
CREATE TABLE IF NOT EXISTS `slugs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `module` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table core.slugs: ~2 rows (approximately)
/*!40000 ALTER TABLE `slugs` DISABLE KEYS */;
INSERT INTO `slugs` (`id`, `slug`, `module`, `model`, `model_id`, `created_at`, `updated_at`) VALUES
	(1, 'bo-tui-3-dieu-can-luu-y-khi-vay-tien-mua-nha', 'News', 'News', 1, '2019-04-27 01:41:29', '2019-04-27 01:41:29'),
	(2, 'dieu-khoan-su-dung3', 'Page', 'Page', 1, '2019-08-31 15:36:22', '2019-08-31 15:36:22');
/*!40000 ALTER TABLE `slugs` ENABLE KEYS */;

-- Dumping structure for table core.sms
CREATE TABLE IF NOT EXISTS `sms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `text` varchar(160) COLLATE utf8_unicode_ci NOT NULL,
  `secret` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `verified` tinyint(4) DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `modulename` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'ID của item trong module',
  `type` varchar(100) COLLATE utf8_unicode_ci DEFAULT 'otp',
  `expired_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `log` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table core.sms: ~8 rows (approximately)
/*!40000 ALTER TABLE `sms` DISABLE KEYS */;
INSERT INTO `sms` (`id`, `phone`, `text`, `secret`, `verified`, `user_id`, `modulename`, `model_id`, `type`, `expired_at`, `created_at`, `updated_at`, `log`) VALUES
	(1, '0943793986', '135465 - La ma xac thuc ODP ngay 05-04-2019', '135465', 0, 25, 'Order', 'S155445977474184', 'Odp', '2019-04-05 17:00:00', '2019-04-05 10:22:54', '2019-04-05 10:22:54', 'null'),
	(2, '0943793986', 'Ma xac thuc la 310034', '310034', 0, 25, 'Verifyphone', '25', 'Otp', NULL, '2019-08-04 18:18:39', '2019-08-04 18:18:40', '{"CodeResult":"103","CountRegenerate":0,"ErrorMessage":"Balance not enough to send message"}'),
	(3, '0943793986', 'Ma xac thuc la 408062', '408062', 0, 25, 'Verifyphone', '25', 'Otp', NULL, '2019-08-04 18:20:13', '2019-08-04 18:20:13', '{"CodeResult":"103","CountRegenerate":0,"ErrorMessage":"Balance not enough to send message"}'),
	(4, '0943793986', 'Ma xac thuc la 560890', '560890', 0, 25, 'Verifyphone', '25', 'Otp', NULL, '2019-08-04 18:20:53', '2019-08-04 18:20:53', '{"CodeResult":"103","CountRegenerate":0,"ErrorMessage":"Balance not enough to send message"}'),
	(5, '0943793984', 'Ma xac thuc la 212564', '212564', 0, 25, 'Verifyphone', '25', 'Otp', NULL, '2019-08-04 18:26:06', '2019-08-04 18:26:06', '{"CodeResult":"103","CountRegenerate":0,"ErrorMessage":"Balance not enough to send message"}'),
	(6, '0943793984', 'Ma xac thuc la 228269', '228269', 0, 25, 'Verifyphone', '25', 'Otp', NULL, '2019-08-04 18:27:25', '2019-08-04 18:27:25', '{"CodeResult":"103","CountRegenerate":0,"ErrorMessage":"Balance not enough to send message"}'),
	(7, '0943793984', 'Ma xac thuc la 213248', '213248', 0, 25, 'Verifyphone', '25', 'Otp', NULL, '2019-08-04 18:28:54', '2019-08-04 18:28:54', '{"CodeResult":"103","CountRegenerate":0,"ErrorMessage":"Balance not enough to send message"}'),
	(8, '0956856229', 'Ma xac thuc la 784953', '784953', 0, 30, 'Verifyphone', '30', 'Otp', NULL, '2019-09-27 20:20:51', '2019-09-27 20:20:51', NULL);
/*!40000 ALTER TABLE `sms` ENABLE KEYS */;

-- Dumping structure for table core.sms_provider
CREATE TABLE IF NOT EXISTS `sms_provider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `brandname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `provider` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `configs` text COLLATE utf8_unicode_ci,
  `balance` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `installed` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `provider` (`provider`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table core.sms_provider: ~0 rows (approximately)
/*!40000 ALTER TABLE `sms_provider` DISABLE KEYS */;
INSERT INTO `sms_provider` (`id`, `name`, `brandname`, `provider`, `configs`, `balance`, `status`, `installed`) VALUES
	(3, 'Nhà cung cấp Esms', 'QCAO_ONLINE', 'Esms', '{"url":"http:\\/\\/rest.esms.vn\\/MainService.svc\\/json","APIKey":"1A7DBA675FBAD9877324DC3B3BDD00","SecretKey":"EB8D28EDB7F9AE81D6BDDEB1535118","SmsType":"2"}', NULL, 1, 1);
/*!40000 ALTER TABLE `sms_provider` ENABLE KEYS */;

-- Dumping structure for table core.tags
CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `author` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `module` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model_id` int(11) DEFAULT NULL,
  `checksum` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(2) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `checksum` (`checksum`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table core.tags: ~0 rows (approximately)
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` (`id`, `code`, `label`, `description`, `author`, `module`, `model`, `model_id`, `checksum`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'nghia', 'nghia', 'nghia', 'God Admin', 'News', 'News', 1, '3a773f41feb2a104a95d37eb18195254', 1, '2019-06-25 14:37:24', '2019-06-25 14:37:24');
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;

-- Dumping structure for table core.ticket
CREATE TABLE IF NOT EXISTS `ticket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Mã vẽ',
  `phone` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `other_info` text COLLATE utf8_unicode_ci,
  `current_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user` int(11) DEFAULT NULL,
  `admin` int(11) DEFAULT NULL,
  `vote` float DEFAULT '0',
  `status` varchar(50) COLLATE utf8_unicode_ci DEFAULT 'pending',
  `file` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table core.ticket: ~3 rows (approximately)
/*!40000 ALTER TABLE `ticket` DISABLE KEYS */;
INSERT INTO `ticket` (`id`, `title`, `name`, `code`, `phone`, `email`, `address`, `city`, `message`, `lang`, `other_info`, `current_url`, `user`, `admin`, `vote`, `status`, `file`, `created_at`, `updated_at`) VALUES
	(8, 'Hướng dẫn sử dụng phần mềm', 'Nguyen Van Nghia', 'HW15666228409485', '943793984', 'hotronet@gmail.com', 'An dung àd', 'Hà Nội', 'Đêm diễn "Huyền thoại làng chài" khép lại trong tiếng vỗ tay giòn giã khi đồng hồ báo 21h. Ánh sáng lịm dần nhưng Dũng vẫn đứng sau cánh gà nhìn khán giả lần lượt rời đi. Gần 1.000 người lấp kín nhà hát đêm nay là thành quả lớn nhất của Dũng sau ba năm khởi nghiệp với không biết bao lần điều chỉnh vở diễn văn hóa tái hiện sự tích cá Ông và cuộc sống mưu sinh bám biển của dân làng chài...', 'vi', '{"cmnd":"4353654656","city":"H\\u00e0 N\\u1ed9i","address":"An dung \\u00e0d"}', 'http://webthefull.com/ticket/create', NULL, NULL, 0, 'pending', NULL, '2019-08-24 12:00:40', '2019-08-24 12:34:40'),
	(9, '', 'Nguyen Van Nghia', 'HW15666247646545', '943793984', 'hotronet@gmail.com', 'An dung àd', 'Hà Nội', 'ádasdasd', 'vi', '{"cmnd":"sssssssssss","city":"H\\u00e0 N\\u1ed9i","address":"An dung \\u00e0d"}', 'http://webthefull.com/ticket/create', NULL, NULL, 0, 'pending', NULL, '2019-08-24 12:32:44', '2019-08-24 12:32:44'),
	(10, '', 'Nguyen Van Nghia2222', 'HW15666247926559', '943793984', 'hotronet@gmail.com', 'đâsd', 'Hà Nội', 'ádasdas', 'vi', '{"cmnd":"\\u00e1dasdsd","city":"H\\u00e0 N\\u1ed9i","address":"\\u0111\\u00e2sd"}', 'http://webthefull.com/ticket/create', NULL, NULL, 0, 'pending', NULL, '2019-08-24 12:33:12', '2019-08-24 12:33:12');
/*!40000 ALTER TABLE `ticket` ENABLE KEYS */;

-- Dumping structure for table core.ticket_fields
CREATE TABLE IF NOT EXISTS `ticket_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `placeholder` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` text COLLATE utf8_unicode_ci,
  `type` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'input',
  `require` tinyint(4) NOT NULL DEFAULT '0',
  `lang` varchar(50) COLLATE utf8_unicode_ci DEFAULT 'vi',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table core.ticket_fields: ~3 rows (approximately)
/*!40000 ALTER TABLE `ticket_fields` DISABLE KEYS */;
INSERT INTO `ticket_fields` (`id`, `key`, `title`, `placeholder`, `value`, `type`, `require`, `lang`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'cmnd', 'CMND/Hộ chiếu', 'CMND hoặc Hộ chiếu', NULL, 'input', 0, 'vi', 1, '2019-08-24 00:21:32', '2019-08-24 00:21:32'),
	(2, 'city', 'Thành phố', 'Tỉnh/Thành phố', 'Hà Nội, HCM, Hải Phòng, Quảng Ninh', 'select', 0, 'vi', 1, '2019-08-24 00:21:32', '2019-08-24 00:21:32'),
	(3, 'address', 'Địa chỉ', 'Địa chỉ hiện tại', NULL, 'input', 0, 'vi', 1, '2019-08-24 00:21:32', '2019-08-24 00:21:32');
/*!40000 ALTER TABLE `ticket_fields` ENABLE KEYS */;

-- Dumping structure for table core.ticket_reply
CREATE TABLE IF NOT EXISTS `ticket_reply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) DEFAULT NULL,
  `ticket_code` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reply` text COLLATE utf8_unicode_ci,
  `user` int(11) DEFAULT NULL,
  `user_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_phone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table core.ticket_reply: ~6 rows (approximately)
/*!40000 ALTER TABLE `ticket_reply` DISABLE KEYS */;
INSERT INTO `ticket_reply` (`id`, `ticket_id`, `ticket_code`, `reply`, `user`, `user_name`, `user_email`, `user_phone`, `file`, `created_at`, `updated_at`) VALUES
	(1, 8, 'HW15666228409485', 'Bà Lê Thị Hiền (Hà Nội) bị cấm bay trong một năm, đến ngày 27/8/2020 vì "gây rối tại sân bay Tân Sơn Nhất".', NULL, NULL, NULL, NULL, NULL, '2019-08-24 14:59:59', '2019-08-24 15:00:07'),
	(2, 8, 'HW15666228409485', 'Để thúc ép các công ty Mỹ tìm "phương án thay thế Trung Quốc", Trump không chỉ có công cụ duy nhất là tăng thuế.', NULL, NULL, NULL, NULL, NULL, '2019-08-24 15:00:38', '2019-08-24 15:00:41'),
	(3, 8, 'HW15666228409485', 'Trường hợp này cần được xác minh, chúng tôi sẽ trả lời bạn sau nhé!', 1, 'God Admin', 'support@nencer.com', '0943793985', NULL, '2019-08-24 15:31:39', '2019-08-24 15:31:39'),
	(4, 8, 'HW15666228409485', 'Vất vả ba năm qua bằng chục năm trước, từ lúc tôi ở nước ngoài về Sài Gòn và thành lập một công ty nghiệp cứu thị trường, cộng lại", Dũng nói', 1, 'God Admin', 'support@nencer.com', '0943793985', NULL, '2019-08-24 15:37:07', '2019-08-24 15:37:07'),
	(5, 8, 'HW15666228409485', 'ok rồi nhé', 1, 'God Admin', 'support@nencer.com', NULL, NULL, '2019-08-24 15:38:56', '2019-08-24 15:38:56'),
	(6, 8, 'HW15666228409485', 'ơ vãi rồi', 1, 'CÔNG TY NENCER SOFTWARE', 'hotronet@gmail.com', '0943793984', NULL, '2019-08-24 15:42:00', '2019-08-24 15:42:00');
/*!40000 ALTER TABLE `ticket_reply` ENABLE KEYS */;

-- Dumping structure for table core.tmp
CREATE TABLE IF NOT EXISTS `tmp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `module` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table core.tmp: ~0 rows (approximately)
/*!40000 ALTER TABLE `tmp` DISABLE KEYS */;
/*!40000 ALTER TABLE `tmp` ENABLE KEYS */;

-- Dumping structure for table core.twofactors
CREATE TABLE IF NOT EXISTS `twofactors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `driver` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `secret` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `text` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modulename` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `expired_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table core.twofactors: ~2 rows (approximately)
/*!40000 ALTER TABLE `twofactors` DISABLE KEYS */;
INSERT INTO `twofactors` (`id`, `object`, `driver`, `user_id`, `secret`, `text`, `modulename`, `model_id`, `expired_at`, `created_at`, `updated_at`) VALUES
	(3, 'hotronet@gmail.com', 'Email', 25, '787921', '787921 - Là mã xác thực ODP ngày 01-01-2019tại website http://webthefull.com', 'Order', 'M154635866022627', '2019-01-01 10:00:00', '2019-01-01 09:38:38', '2019-01-01 09:38:38'),
	(4, 'hotronet@gmail.com', 'Email', 25, '915589', '915589 - Là mã xác thực ODP ngày 03-01-2019 tại website http://webthefull.com', 'Order', 'M154650917338294', '2019-01-03 10:00:00', '2019-01-03 02:52:54', '2019-01-03 02:52:54');
/*!40000 ALTER TABLE `twofactors` ENABLE KEYS */;

-- Dumping structure for table core.uploads
CREATE TABLE IF NOT EXISTS `uploads` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `path` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `extension` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `caption` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL DEFAULT '1',
  `hash` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `public` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `uploads_user_id_foreign` (`user_id`),
  CONSTRAINT `uploads_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table core.uploads: ~0 rows (approximately)
/*!40000 ALTER TABLE `uploads` DISABLE KEYS */;
/*!40000 ALTER TABLE `uploads` ENABLE KEYS */;

-- Dumping structure for table core.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT 'VN',
  `gender` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group` int(11) DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `api_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `api_token_created` timestamp NULL DEFAULT NULL,
  `provider` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Login bằng mạng xã hội',
  `provider_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ID tại mạng xã hội',
  `mkc2` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tmp` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `tmp_token` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(4) DEFAULT '0',
  `parent_id` int(11) DEFAULT NULL,
  `_lft` int(11) unsigned DEFAULT NULL,
  `_rgt` int(11) unsigned DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `language` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twofactor` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twofactor_secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `failed` tinyint(4) DEFAULT '0' COMMENT 'Số lần đăng nhập sai',
  `failed_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verify_phone` tinyint(4) DEFAULT NULL,
  `verify_email` tinyint(4) DEFAULT NULL,
  `verify_document` tinyint(4) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `phone` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table core.users: ~4 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `name`, `email`, `phone`, `country_code`, `gender`, `group`, `password`, `remember_token`, `api_token`, `api_token_created`, `provider`, `provider_id`, `mkc2`, `tmp`, `tmp_token`, `status`, `parent_id`, `_lft`, `_rgt`, `currency_id`, `language`, `twofactor`, `twofactor_secret`, `ip`, `ref`, `failed`, `failed_reason`, `verify_phone`, `verify_email`, `verify_document`, `birthday`, `created_at`, `updated_at`) VALUES
	(1, 'administrator', 'God Admin', 'support@nencer.com', '0943793985', NULL, 'male', 2, '$2y$10$fhFgzGTdBpUlCu.iH8F/4.t4KkZlOsIMdGQCdbrgFbgDQfDSG6EiW', 'MlbCYGXBtHpIFjs47DJOm4rktjWiSiqnER7ICjUETWY9Tg5p0kovz48wIayw', NULL, NULL, NULL, NULL, '1f82c942befda29b6ed487a51da199f78fce7f05', 'f05247d52f537439f3ba0c7fc87fceab', '4905314a883da147e61132736de3945e71ad864f', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '1984-01-16', '2018-06-21 02:27:42', '2019-08-25 03:22:22'),
	(25, 'neonguyen', 'Nguyễn NEO', 'hotronet@gmail.com', '0943793984', NULL, 'male', 2, '$2y$10$aj9pc2eS9RvZrujRWKnMBOegRRtg9cRRvrgb6dBrwxlXjJFFSHtJe', 'fUqQiDCkhCu4dGFqqDM8bgNoxOZrMKMZFa2pWetDpegoRcD59COJHYQSpo64', 'e44d4ee4e460cd89aa7e1bf8481bf6b75df790a52d5a5c942b0e136f63b80b83', '2019-09-19 23:54:50', NULL, NULL, '1496aa696d9d35aa2c23b0f1ef3020df7f26f869', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 1, 1, 1, NULL, '2018-11-01 08:30:25', '2019-09-29 15:48:52'),
	(30, 'hotronet1', 'hotronet1', NULL, '0956856229', 'VN', 'male', 2, '$2y$10$BVtTeEGO7SRvVf8Qw4Sr4u/GDvsXOS9ElMNkBk2ChWRowjeuaudD.', NULL, NULL, NULL, NULL, NULL, NULL, '784953', '542be7e6e628bd2bc9af0fda8537677d7a8dccc7', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '127.0.0.1', '5d83a9f1a4c57', 0, NULL, NULL, NULL, NULL, NULL, '2019-09-19 23:16:49', '2019-09-27 20:20:50'),
	(31, '0943793980', 'Nguyen Nguyen', 'hotronet99@gmail.com', NULL, 'VN', NULL, 2, '$2y$10$Y/ob9fhCCAmTp5B5hcdbnuLMSwsiVYmN75iS0/1Op7Q/04Yr7LhtO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '127.0.0.1', '5d9085af6d484', 0, NULL, NULL, NULL, NULL, NULL, '2019-09-29 17:21:35', '2019-09-29 17:21:35');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Dumping structure for table core.user_discount
CREATE TABLE IF NOT EXISTS `user_discount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `level` int(11) NOT NULL COMMENT 'Độ sâu hoặc tầng đa cấp',
  `module` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `discount` double NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='lưu các thông tin chiêt khấu đa cấp';

-- Dumping data for table core.user_discount: ~0 rows (approximately)
/*!40000 ALTER TABLE `user_discount` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_discount` ENABLE KEYS */;

-- Dumping structure for table core.user_images
CREATE TABLE IF NOT EXISTS `user_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `size` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `extension` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `album` int(11) DEFAULT NULL,
  `cat` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort` int(11) DEFAULT '0',
  `type` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'public' COMMENT 'public/private',
  `admin` varchar(50) COLLATE utf8_unicode_ci DEFAULT '0' COMMENT 'chỉ show cho admin',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table core.user_images: ~3 rows (approximately)
/*!40000 ALTER TABLE `user_images` DISABLE KEYS */;
INSERT INTO `user_images` (`id`, `title`, `token`, `user_id`, `description`, `image`, `size`, `extension`, `album`, `cat`, `sort`, `type`, `admin`, `created_at`, `updated_at`) VALUES
	(7, 'Mặt trước', '71a688e38401395aae50b3c984c8cc01', 25, NULL, '/storage/verify/15d8e47b0378aa_cmt1.jpg', NULL, NULL, NULL, 'verify', 0, 'private', '1', '2019-09-28 00:32:32', '2019-09-28 00:32:32'),
	(8, 'Mặt sau', '43216b89fa5342544eeca5dc93fdfc0a', 25, NULL, '/storage/verify/25d8e47b038820_cmt2.jpg', NULL, NULL, NULL, 'verify', 0, 'private', '1', '2019-09-28 00:32:32', '2019-09-28 00:32:32'),
	(9, 'Chân dung', '60e8f37d5f76d90bf865d33b61c1e444', 25, NULL, '/storage/verify/35d8e47b038f12_cmt3.jpg', NULL, NULL, NULL, 'verify', 0, 'private', '1', '2019-09-28 00:32:32', '2019-09-28 00:32:32');
/*!40000 ALTER TABLE `user_images` ENABLE KEYS */;

-- Dumping structure for table core.wallets
CREATE TABLE IF NOT EXISTS `wallets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(15) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `currency_code` varchar(5) NOT NULL,
  `user` int(11) NOT NULL,
  `balance` text,
  `balance_decode` double unsigned NOT NULL,
  `pending_balance` double unsigned NOT NULL,
  `checksum` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `checksum` (`checksum`),
  UNIQUE KEY `number` (`number`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- Dumping data for table core.wallets: ~4 rows (approximately)
/*!40000 ALTER TABLE `wallets` DISABLE KEYS */;
INSERT INTO `wallets` (`id`, `number`, `currency_id`, `currency_code`, `user`, `balance`, `balance_decode`, `pending_balance`, `checksum`, `status`, `created_at`, `updated_at`) VALUES
	(1, '0000000000', 1, 'VND', 1, 'eyJpdiI6IkRlS1ZRa3BtQ0RFUXAzRGZaWVYyVnc9PSIsInZhbHVlIjoiVThxd2V6dEkzK3RNZm90U2hrek5nQnYydDRrajBBQkhWa0lDdzZZV3RFUT0iLCJtYWMiOiI5NTMwNWU4MDU0MmQ5MWY5MDE2ZWI5Yzk5ZDk5MWRhMDU0ZmQxMWY4MjFiZjJmM2Y1OTkzNTI0MGEyZjE3OTVhIn0=', 9964341732.074999, 0, '8cf0a3405bcd8ec543e18859f8327b89', 1, '2019-03-26 07:07:40', '2019-09-27 20:09:30'),
	(17, '0071070849', 1, 'VND', 25, 'eyJpdiI6IkVVcFBVXC9CMkxyMzlaOWxmNUNvNXJBPT0iLCJ2YWx1ZSI6ImxMUXI3dTdcLzlYM3pMeUNMVEZ4aG9CVzZHK1wvTWYwUDRwbUFQa3BRK1E3OD0iLCJtYWMiOiIxN2ZlZTNkYzM5Y2VkNjFiNjNjZjk2ZWMzNTUwODlhMjhhYjhmMjM1MTc0YzVjZTk2MWIwNzI5YTFhYWY2OTU4In0=', 10222432.924249997, 0, '249d0370d3c32bfc591eb66828421781', 1, '2019-03-26 07:07:40', '2019-09-27 21:20:31'),
	(18, '0032764404', 1, 'VND', 30, 'eyJpdiI6IkE4c3d4czB5cmgySXQ2dXA5UzVjNXc9PSIsInZhbHVlIjoiMTZySVdGUHBcL1pjTkNmK0JseVhaNlE9PSIsIm1hYyI6ImUwMTA5N2JiYjY1OTU0MzIzMmQ5NWZhMzRmOTg3NDM4ZDZhM2ZjZGJjYmZkZDQ4ZGM4NzdhYTRiMjU2ZjM4YWEifQ==', 4943000, 0, '9bc26fae9cab5104d3ec78c98e7a7b66', 1, '2019-09-19 23:16:49', '2019-09-27 21:20:31'),
	(19, '0010581672', 1, 'VND', 31, 'eyJpdiI6Iit1MTZCRGxkcVJCNlhScWxrcFFjYXc9PSIsInZhbHVlIjoiQ09Jakt2NmxcLzl6VTNpOXVoYVBBR3c9PSIsIm1hYyI6IjQwYzFjNzI1ODNhZDQ0ZTg2NzViMjMxNDFjOTdiYTgzNjk2NjFjMmFiMGJkNjQ1ODVkNzU4YzZjMmVmYzliNmUifQ==', 0, 0, '154088e4c6413ee87f1f375ab90ce7de', 1, '2019-09-29 17:21:35', '2019-09-29 17:21:35');
/*!40000 ALTER TABLE `wallets` ENABLE KEYS */;

-- Dumping structure for table core.wallet_fees
CREATE TABLE IF NOT EXISTS `wallet_fees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT NULL,
  `paygate` varchar(50) DEFAULT NULL,
  `currency_id` int(11) NOT NULL,
  `currency_code` varchar(50) NOT NULL,
  `wallet_id` int(11) NOT NULL,
  `p_fixed_fees` varchar(255) DEFAULT NULL,
  `p_percent_fees` varchar(255) DEFAULT NULL,
  `p_daily_limit` varchar(255) DEFAULT NULL,
  `p_min` varchar(255) DEFAULT NULL,
  `p_max` varchar(255) DEFAULT NULL,
  `p_nofees` varchar(255) DEFAULT NULL,
  `t_fixed_fees` varchar(255) DEFAULT NULL,
  `t_percent_fees` varchar(255) DEFAULT NULL,
  `t_daily_limit` varchar(255) DEFAULT NULL,
  `t_min` varchar(255) DEFAULT NULL,
  `t_max` varchar(255) DEFAULT NULL,
  `t_nofees` varchar(255) DEFAULT NULL,
  `total_daily_deposit` varchar(255) DEFAULT NULL,
  `total_daily_withdraw` varchar(255) DEFAULT NULL,
  `deposit_info` text,
  `withdraw_info` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Dumping data for table core.wallet_fees: ~0 rows (approximately)
/*!40000 ALTER TABLE `wallet_fees` DISABLE KEYS */;
INSERT INTO `wallet_fees` (`id`, `code`, `paygate`, `currency_id`, `currency_code`, `wallet_id`, `p_fixed_fees`, `p_percent_fees`, `p_daily_limit`, `p_min`, `p_max`, `p_nofees`, `t_fixed_fees`, `t_percent_fees`, `t_daily_limit`, `t_min`, `t_max`, `t_nofees`, `total_daily_deposit`, `total_daily_withdraw`, `deposit_info`, `withdraw_info`, `created_at`, `updated_at`) VALUES
	(6, 'Wallet_VND', 'Wallet', 1, 'VND', 1, '{"3":"0","2":"0","1":"0"}', '{"3":"0","2":"0","1":"0"}', '{"3":"20000000","2":"200000000","1":"50000000"}', '{"3":null,"2":null,"1":null}', '{"3":"10000000","2":"20000000","1":"20000000"}', '{"3":"500000","2":"50000000","1":"50000000"}', '{"3":"1000","2":"1000","1":"1000"}', '{"3":"1","2":"1","1":"1"}', '{"3":null,"2":null,"1":null}', '{"3":"10000","2":"10000","1":"10000"}', '{"3":"5000000","2":"5000000","1":"5000000"}', '{"3":null,"2":null,"1":null}', '{"3":"5000000","2":"5000000","1":"5000000"}', '{"3":"5000000","2":"5000000","1":"5000000"}', 'Các giao dịch nạp tiền vào ví điện tử quý khách vui lòng thanh toán trong vòng 15 phút, nếu sau thời gian đó chúng tôi không nhận được thanh toán, hệ thống sẽ tự động hủy đơn hàng này. Phí nạp tiền sẽ áp dụng theo cổng thanh toán mà bạn chuyển tiền cho chúng tôi. Đơn hàng nạp thủ công sẽ được xử lý trong vòng 10 phút. Liên hệ: 09x xxx xxx', 'Các giao dịch rút tiền từ ví sẽ được thực hiện trong vòng 30 phút đến 24 giờ. Phí rút tính theo ngân hàng nhận tiền. Nếu đơn hàng không thể giao dịch, chúng tôi sẽ tiến hàng hoàn lại tiền vào ví của bạn. Liên hệ: 09x xxx xxx', '2019-07-26 17:50:09', '2019-09-11 09:37:16');
/*!40000 ALTER TABLE `wallet_fees` ENABLE KEYS */;

-- Dumping structure for table core.wallet_history
CREATE TABLE IF NOT EXISTS `wallet_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `order_code` varchar(100) NOT NULL,
  `code` varchar(100) NOT NULL,
  `wallet_number` varchar(20) NOT NULL,
  `net_amount` double NOT NULL,
  `fees` double NOT NULL,
  `pay_amount` double NOT NULL,
  `before_balance` double NOT NULL,
  `after_balance` double NOT NULL,
  `checksum` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `currency_id` int(11) NOT NULL,
  `currency_code` varchar(10) NOT NULL,
  `operation` char(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `checksum` (`checksum`)
) ENGINE=InnoDB AUTO_INCREMENT=149 DEFAULT CHARSET=utf8;

-- Dumping data for table core.wallet_history: ~30 rows (approximately)
/*!40000 ALTER TABLE `wallet_history` DISABLE KEYS */;
INSERT INTO `wallet_history` (`id`, `user_id`, `order_code`, `code`, `wallet_number`, `net_amount`, `fees`, `pay_amount`, `before_balance`, `after_balance`, `checksum`, `description`, `currency_id`, `currency_code`, `operation`, `created_at`, `updated_at`) VALUES
	(115, 25, 'TW15687064629410', 'T', '0071070849', 10000.025, 1100.00025, 11100.025249999999, 10635032.97475, 10623932.949499998, 'ef2f3788bb12946941479d1ce92e6cd2', 'chuyen tien', 1, 'VND', '-', '2019-09-17 14:47:53', '2019-09-17 14:47:53'),
	(116, 1, 'TW15687064629410', 'T', '0000000000', 10000.025, 0, 10000.025, 9968893732.025, 9968903732.05, '9b3a1b8eda4d1bd92b879c1e4b2756d9', 'chuyen tien', 1, 'VND', '+', '2019-09-17 14:47:53', '2019-09-17 14:47:53'),
	(117, 25, 'TW15687066691956', 'T', '0071070849', 100000.025, 2000.00025, 102000.02524999999, 10623932.949499998, 10521932.924249997, 'd4d7f4e38ad6a763e2e79bdbc9adc71b', 'chuyen tien', 1, 'VND', '-', '2019-09-17 14:51:16', '2019-09-17 14:51:16'),
	(118, 1, 'TW15687066691956', 'T', '0000000000', 100000.025, 0, 100000.025, 9968903732.05, 9969003732.074999, 'a1c33eb80b37b31fc844bd5ddf368a4f', 'chuyen tien', 1, 'VND', '+', '2019-09-17 14:51:16', '2019-09-17 14:51:16'),
	(123, 25, 'TW15687306896292', 'T', '0071070849', 300000, 4000, 304000, 10521932.924249997, 10217932.924249997, '8fb81bb61aa5baf53a1589f304b7fafd', 'dsfs dsf dsfdf', 1, 'VND', '-', '2019-09-17 21:31:42', '2019-09-17 21:31:42'),
	(124, 1, 'TW15687306896292', 'T', '0000000000', 300000, 0, 300000, 9969003732.074999, 9969303732.074999, '694ec8765410884623be4468946693aa', 'dsfs dsf dsfdf', 1, 'VND', '+', '2019-09-17 21:31:42', '2019-09-17 21:31:42'),
	(125, 1, 'D156873396987821', 'D', '0000000000', 600000, 0, 600000, 9969303732.074999, 9968703732.074999, '035ed80ecbd0e4a6d207014220120cfd', 'Admin cộng tiền: ví 0071070849 thời gian 17-09-2019 22:25:49', 1, 'VND', '-', '2019-09-17 22:26:09', '2019-09-17 22:26:09'),
	(126, 25, 'D156873396987821', 'D', '0071070849', 600000, 0, 600000, 10217932.924249997, 10817932.924249997, '045673bb1e643a65757316505cd35cd0', 'Admin cộng tiền: ví 0071070849 thời gian 17-09-2019 22:25:49', 1, 'VND', '+', '2019-09-17 22:26:09', '2019-09-17 22:26:09'),
	(127, 25, 'W156873398887388', 'W', '0071070849', 600000, 0, 600000, 10817932.924249997, 10217932.924249997, '7851d94fc1eee928c89b430e06077bc6', 'Admin trừ tiền: ví 0071070849 thời gian 17-09-2019 22:26:22', 1, 'VND', '-', '2019-09-17 22:26:28', '2019-09-17 22:26:28'),
	(128, 1, 'W156873398887388', 'W', '0000000000', 600000, 0, 600000, 9968703732.074999, 9969303732.074999, 'ef4c8859697e0d7a12b913257ebf0320', 'Admin trừ tiền: ví 0071070849 thời gian 17-09-2019 22:26:22', 1, 'VND', '+', '2019-09-17 22:26:28', '2019-09-17 22:26:28'),
	(129, 1, 'C156916218013873', 'C', '0000000000', 70000, 0, 70000, 9969303732.074999, 9969233732.074999, '191386892a8fef4a5c8f126f65317eb6', 'Nạp tiền từ đơn hàng đổi thẻ: 423423434 / 9947676599998', 1, 'VND', '-', '2019-09-22 21:23:00', '2019-09-22 21:23:00'),
	(130, 25, 'C156916218013873', 'C', '0071070849', 70000, 0, 70000, 10217932.924249997, 10287932.924249997, 'f3fc5e728b5565de35cad038d9fbc006', 'Nạp tiền từ đơn hàng đổi thẻ: 423423434 / 9947676599998', 1, 'VND', '+', '2019-09-22 21:23:00', '2019-09-22 21:23:00'),
	(131, 1, 'C156916265571361', 'C', '0000000000', 70000, 0, 70000, 9969233732.074999, 9969163732.074999, '3633dfeed8aa524e0a3be8cd0828f43d', 'Nạp tiền từ đơn hàng đổi thẻ: 5454435423 / 9999965465658', 1, 'VND', '-', '2019-09-22 21:30:55', '2019-09-22 21:30:55'),
	(132, 25, 'C156916265571361', 'C', '0071070849', 70000, 0, 70000, 10287932.924249997, 10357932.924249997, 'e419f77d6e6339a5878172308cb14c1b', 'Nạp tiền từ đơn hàng đổi thẻ: 5454435423 / 9999965465658', 1, 'VND', '+', '2019-09-22 21:30:55', '2019-09-22 21:30:55'),
	(133, 25, 'MW15694225636819', 'M', '0071070849', 78000, 0, 78000, 10357932.924249997, 10279932.924249997, '1ec78ff8671cd5531f5c1436d00c930b', 'Nạp cước cho thuê bao: 0943794545', 1, 'VND', '-', '2019-09-25 21:42:49', '2019-09-25 21:42:49'),
	(134, 1, 'MW15694225636819', 'M', '0000000000', 78000, 0, 78000, 9969163732.074999, 9969241732.074999, '043700354ec79b9b99376fab6df7ac17', 'Nạp cước cho thuê bao: 0943794545', 1, 'VND', '+', '2019-09-25 21:42:49', '2019-09-25 21:42:49'),
	(135, 25, 'TW15695886326855', 'T', '0071070849', 100000, 2000, 102000, 10279932.924249997, 10177932.924249997, '69be6c58f342778a17fc7dc66f66fe7f', 'cjlklklk', 1, 'VND', '-', '2019-09-27 19:50:42', '2019-09-27 19:50:42'),
	(136, 1, 'TW15695886326855', 'T', '0000000000', 100000, 0, 100000, 9969241732.074999, 9969341732.074999, '77ef00316b4cc970da22a9ec4a6658b1', 'cjlklklk', 1, 'VND', '+', '2019-09-27 19:50:42', '2019-09-27 19:50:42'),
	(137, 1, 'D156958977033490', 'D', '0000000000', 5000000, 0, 5000000, 9969341732.074999, 9964341732.074999, 'e5c880cfe193164386fec301b966d35a', 'Admin cộng tiền: ví 0032764404 thời gian 27-09-2019 20:09:19', 1, 'VND', '-', '2019-09-27 20:09:30', '2019-09-27 20:09:30'),
	(138, 30, 'D156958977033490', 'D', '0032764404', 5000000, 0, 5000000, 0, 5000000, '0fec790442547c33625f5f8e77537b37', 'Admin cộng tiền: ví 0032764404 thời gian 27-09-2019 20:09:19', 1, 'VND', '+', '2019-09-27 20:09:30', '2019-09-27 20:09:30'),
	(139, 30, 'TW15695898844204', 'T', '0032764404', 100000, 2000, 102000, 5000000, 4898000, 'bfe7776c19e1f1f1a0949e66e7a0de55', 'chuyen thu', 1, 'VND', '-', '2019-09-27 20:11:39', '2019-09-27 20:11:39'),
	(140, 25, 'TW15695898844204', 'T', '0071070849', 100000, 0, 100000, 10177932.924249997, 10277932.924249997, '052f26644893f7620da6bf370af85888', 'chuyen thu', 1, 'VND', '+', '2019-09-27 20:11:39', '2019-09-27 20:11:39'),
	(141, 30, 'TW15695899391855', 'T', '0032764404', 200000, 3000, 203000, 4898000, 4695000, '212a6ae2c67f2f533cf62d3bbd2d0d5c', 'chuyen lan 2', 1, 'VND', '-', '2019-09-27 20:12:38', '2019-09-27 20:12:38'),
	(142, 25, 'TW15695899391855', 'T', '0071070849', 200000, 0, 200000, 10277932.924249997, 10477932.924249997, 'c33bd77075e5e2aec20415fbc1c2b344', 'chuyen lan 2', 1, 'VND', '+', '2019-09-27 20:12:38', '2019-09-27 20:12:38'),
	(143, 25, 'TW15695923246074', 'T', '0071070849', 50000, 1500, 51500, 10477932.924249997, 10426432.924249997, 'b08adfb59da314acfd50b926ab7b15b7', 'chueyen a a', 1, 'VND', '-', '2019-09-27 20:52:13', '2019-09-27 20:52:13'),
	(144, 30, 'TW15695923246074', 'T', '0032764404', 50000, 0, 50000, 4695000, 4745000, '71aaa62c5ddb71ddd2875fcf31bae829', 'chueyen a a', 1, 'VND', '+', '2019-09-27 20:52:13', '2019-09-27 20:52:13'),
	(145, 25, 'TW15695929944306', 'T', '0071070849', 300000, 4000, 304000, 10426432.924249997, 10122432.924249997, '29ca6bb1c45569ab944c274b1e58eb36', 'chuyen', 1, 'VND', '-', '2019-09-27 21:03:22', '2019-09-27 21:03:22'),
	(146, 30, 'TW15695929944306', 'T', '0032764404', 300000, 0, 300000, 4745000, 5045000, 'aca720c025bb5cef657556d3848775de', 'chuyen', 1, 'VND', '+', '2019-09-27 21:03:22', '2019-09-27 21:03:22'),
	(147, 30, 'TW15695940208441', 'T', '0032764404', 100000, 2000, 102000, 5045000, 4943000, 'a491f65db24250910e930bce32c2c93d', '43 435 345', 1, 'VND', '-', '2019-09-27 21:20:31', '2019-09-27 21:20:31'),
	(148, 25, 'TW15695940208441', 'T', '0071070849', 100000, 0, 100000, 10122432.924249997, 10222432.924249997, 'd230393eea41ba0a0f8e3dda86755275', '43 435 345', 1, 'VND', '+', '2019-09-27 21:20:31', '2019-09-27 21:20:31');
/*!40000 ALTER TABLE `wallet_history` ENABLE KEYS */;

-- Dumping structure for table core.wallet_settings
CREATE TABLE IF NOT EXISTS `wallet_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `currency_id` int(11) NOT NULL,
  `currency_code` varchar(10) NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `paygate` varchar(50) DEFAULT NULL,
  `description` text,
  `status` int(11) DEFAULT '1',
  `sort` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `currency_code` (`currency_code`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table core.wallet_settings: ~0 rows (approximately)
/*!40000 ALTER TABLE `wallet_settings` DISABLE KEYS */;
INSERT INTO `wallet_settings` (`id`, `currency_id`, `currency_code`, `code`, `paygate`, `description`, `status`, `sort`, `created_at`, `updated_at`) VALUES
	(1, 1, 'VND', 'Wallet_VND', 'Wallet', 'Ví điện tử VND', 1, 0, '2019-07-26 17:50:09', '2019-07-26 17:50:09');
/*!40000 ALTER TABLE `wallet_settings` ENABLE KEYS */;

-- Dumping structure for table core.weblinks
CREATE TABLE IF NOT EXISTS `weblinks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `sort` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table core.weblinks: ~0 rows (approximately)
/*!40000 ALTER TABLE `weblinks` DISABLE KEYS */;
INSERT INTO `weblinks` (`id`, `created_at`, `updated_at`, `name`, `image`, `description`, `url`, `status`, `sort`) VALUES
	(1, '2018-10-19 04:39:33', '2018-10-19 04:39:33', 'Công ty nencer', '/storage/userfiles/images/1539191180873464-logo-1715-en.png', 'Thiết kế web', 'https://www.nencer.com', 1, 1);
/*!40000 ALTER TABLE `weblinks` ENABLE KEYS */;

-- Dumping structure for table core.web_data
CREATE TABLE IF NOT EXISTS `web_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `key` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Vài dữ liệu module';

-- Dumping data for table core.web_data: ~18 rows (approximately)
/*!40000 ALTER TABLE `web_data` DISABLE KEYS */;
INSERT INTO `web_data` (`id`, `module`, `type`, `key`, `description`) VALUES
	(1, 'Mtopup', 'topup', 'VIETTEL_TRATRUOC', 'Viettel trả trước'),
	(2, 'Mtopup', 'topup', 'VIETTEL_TRASAU', 'Viettel trả sau'),
	(3, 'Mtopup', 'topup', 'VINAPHONE_TRATRUOC', 'Vina trả trước'),
	(5, 'Mtopup', 'topup', 'VINAPHONE_TRASAU', 'Vina trả sau'),
	(7, 'Mtopup', 'topup', 'MOBIFONE_TRASAU', 'Mobi trả sau'),
	(8, 'Mtopup', 'topup', 'MOBIFONE_TRATRUOC', 'Mobi trả trước'),
	(9, 'Mtopup', 'telco', 'MOBIFONE', 'Mạng Mobifone'),
	(11, 'Mtopup', 'telco', 'VINAPHONE', 'Mạng Vinaphone'),
	(13, 'Mtopup', 'telco', 'VIETTEL', 'Mạng Viettel'),
	(14, 'Mtopup', 'telco', 'KPLUS', 'Truyền hình'),
	(16, 'Mtopup', 'topup', 'KPLUS', 'Truyền hình K+'),
	(24, 'Mtopup', 'topup', 'VIETTEL_TRASAU_C', 'Viettel trả sau - Nạp chậm'),
	(25, 'Mtopup', 'topup', 'VIETTEL_TRATRUOC_C', 'Viettel trả trước - Nạp chậm'),
	(26, 'Mtopup', 'topup', 'VIETTEL_ADSL', 'Viettel ADLS'),
	(27, 'Mtopup', 'topup', 'VIETTEL_ADSL_C', 'Nạp chậm Viettel ADLS'),
	(28, 'Mtopup', 'topup', 'VIETTEL_LL', 'Viettel Leadline'),
	(29, 'Mtopup', 'topup', 'VIETTEL_LL_C', 'Viettel LeadLine chậm'),
	(30, 'Mtopup', 'topup', 'MYVIETTEL', 'Nạp MyViettel');
/*!40000 ALTER TABLE `web_data` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
