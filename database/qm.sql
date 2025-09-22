-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for laravel
CREATE DATABASE IF NOT EXISTS `laravel` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `laravel`;

-- Dumping structure for table laravel.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table laravel.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel.migrations: ~10 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2014_10_12_100000_create_password_resets_table', 1),
	(4, '2019_08_19_000000_create_failed_jobs_table', 1),
	(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(6, '2024_04_05_080046_create_permission_tables', 1),
	(7, '2024_04_07_065632_create_navigations_table', 1),
	(8, '2024_04_10_125314_create_navigation_role_table', 1),
	(9, '2024_04_13_014727_create_user_profiles_table', 1),
	(10, '2025_09_20_100430_create_parameter_tables', 2);

-- Dumping structure for table laravel.model_has_permissions
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel.model_has_permissions: ~20 rows (approximately)
INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
	(25, 'App\\Models\\User', 1),
	(26, 'App\\Models\\User', 1),
	(27, 'App\\Models\\User', 1),
	(28, 'App\\Models\\User', 1),
	(29, 'App\\Models\\User', 1),
	(30, 'App\\Models\\User', 1),
	(31, 'App\\Models\\User', 1),
	(32, 'App\\Models\\User', 1),
	(33, 'App\\Models\\User', 1),
	(34, 'App\\Models\\User', 1),
	(35, 'App\\Models\\User', 1),
	(36, 'App\\Models\\User', 1),
	(37, 'App\\Models\\User', 1),
	(38, 'App\\Models\\User', 1),
	(39, 'App\\Models\\User', 1),
	(40, 'App\\Models\\User', 1),
	(41, 'App\\Models\\User', 1),
	(42, 'App\\Models\\User', 1),
	(43, 'App\\Models\\User', 1),
	(44, 'App\\Models\\User', 1);

-- Dumping structure for table laravel.model_has_roles
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel.model_has_roles: ~5 rows (approximately)
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
	(1, 'App\\Models\\User', 1),
	(3, 'App\\Models\\User', 2),
	(3, 'App\\Models\\User', 3),
	(3, 'App\\Models\\User', 4),
	(2, 'App\\Models\\User', 9);

-- Dumping structure for table laravel.navigations
CREATE TABLE IF NOT EXISTS `navigations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `main_menu` bigint DEFAULT NULL,
  `sort` int NOT NULL DEFAULT '0',
  `type_menu` enum('parent','child','single') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'single',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel.navigations: ~10 rows (approximately)
INSERT INTO `navigations` (`id`, `name`, `url`, `icon`, `main_menu`, `sort`, `type_menu`, `created_at`, `updated_at`) VALUES
	(14, 'Konfigurasi', 'konfigurasi', 'ti-settings', NULL, 0, 'parent', '2025-09-20 04:57:14', '2025-09-20 04:57:14'),
	(15, 'Roles', 'roles', '', 14, 0, 'child', '2025-09-20 04:57:14', '2025-09-20 04:57:14'),
	(16, 'Permissions', 'permissions', '', 14, 0, 'child', '2025-09-20 04:57:14', '2025-09-20 04:57:14'),
	(17, 'Navigation', 'navigation', '', 14, 0, 'child', '2025-09-20 04:57:14', '2025-09-20 04:57:14'),
	(18, 'Users', 'users', 'fas fa-users', NULL, 0, 'single', '2025-09-20 04:57:14', '2025-09-20 04:57:14'),
	(20, 'Parameter QM', 'parameter-qm', 'ti-clipboard', 19, 0, 'child', '2025-09-20 04:57:14', '2025-09-20 04:57:14'),
	(24, 'Penilaian Tapplings', 'penilaian-tappings', '', 19, 0, 'child', '2025-09-20 04:57:14', '2025-09-20 04:57:14'),
	(25, 'Penilaian Agent', 'penilaian-agent', 'ti-user', NULL, 10, 'parent', '2025-09-20 07:35:35', '2025-09-20 07:35:35'),
	(28, 'Parameter QM', 'parameter-qm', '', 25, 1, 'child', '2025-09-20 07:36:47', '2025-09-20 07:36:47'),
	(29, 'Penilaian Tapping', 'penilaian-tappings', '', 25, 2, 'child', '2025-09-20 07:36:47', '2025-09-20 07:36:47');

-- Dumping structure for table laravel.navigation_role
CREATE TABLE IF NOT EXISTS `navigation_role` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `navigation_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `navigation_role_navigation_id_foreign` (`navigation_id`),
  KEY `navigation_role_role_id_foreign` (`role_id`),
  CONSTRAINT `navigation_role_navigation_id_foreign` FOREIGN KEY (`navigation_id`) REFERENCES `navigations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `navigation_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel.navigation_role: ~8 rows (approximately)
INSERT INTO `navigation_role` (`id`, `navigation_id`, `role_id`, `created_at`, `updated_at`) VALUES
	(14, 14, 1, NULL, NULL),
	(15, 15, 1, NULL, NULL),
	(16, 16, 1, NULL, NULL),
	(17, 17, 1, NULL, NULL),
	(18, 18, 1, NULL, NULL),
	(20, 20, 1, NULL, NULL),
	(24, 24, 1, NULL, NULL),
	(25, 25, 1, NULL, NULL),
	(28, 28, 1, NULL, NULL),
	(29, 29, 1, NULL, NULL);

-- Dumping structure for table laravel.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel.password_resets: ~0 rows (approximately)

-- Dumping structure for table laravel.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table laravel.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel.permissions: ~44 rows (approximately)
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'read konfigurasi', 'web', '2025-09-20 00:38:41', '2025-09-20 00:38:41'),
	(2, 'read permissions', 'web', '2025-09-20 00:38:41', '2025-09-20 00:38:41'),
	(3, 'read roles', 'web', '2025-09-20 00:38:41', '2025-09-20 00:38:41'),
	(4, 'read navigation', 'web', '2025-09-20 00:38:41', '2025-09-20 00:38:41'),
	(5, 'read users', 'web', '2025-09-20 00:38:41', '2025-09-20 00:38:41'),
	(6, 'create konfigurasi', 'web', '2025-09-20 00:38:41', '2025-09-20 00:38:41'),
	(7, 'create permissions', 'web', '2025-09-20 00:38:41', '2025-09-20 00:38:41'),
	(8, 'create roles', 'web', '2025-09-20 00:38:41', '2025-09-20 00:38:41'),
	(9, 'create navigation', 'web', '2025-09-20 00:38:41', '2025-09-20 00:38:41'),
	(10, 'create users', 'web', '2025-09-20 00:38:41', '2025-09-20 00:38:41'),
	(11, 'update konfigurasi', 'web', '2025-09-20 00:38:41', '2025-09-20 00:38:41'),
	(12, 'update permissions', 'web', '2025-09-20 00:38:41', '2025-09-20 00:38:41'),
	(13, 'update roles', 'web', '2025-09-20 00:38:41', '2025-09-20 00:38:41'),
	(14, 'update navigation', 'web', '2025-09-20 00:38:41', '2025-09-20 00:38:41'),
	(15, 'update users', 'web', '2025-09-20 00:38:41', '2025-09-20 00:38:41'),
	(16, 'delete konfigurasi', 'web', '2025-09-20 00:38:41', '2025-09-20 00:38:41'),
	(17, 'delete permissions', 'web', '2025-09-20 00:38:41', '2025-09-20 00:38:41'),
	(18, 'delete roles', 'web', '2025-09-20 00:38:41', '2025-09-20 00:38:41'),
	(19, 'delete navigation', 'web', '2025-09-20 00:38:41', '2025-09-20 00:38:41'),
	(20, 'delete users', 'web', '2025-09-20 00:38:41', '2025-09-20 00:38:41'),
	(21, 'read parameter-qm', 'web', '2025-09-20 03:01:00', '2025-09-20 03:01:00'),
	(22, 'create parameter-qm', 'web', '2025-09-20 03:01:00', '2025-09-20 03:01:00'),
	(23, 'update parameter-qm', 'web', '2025-09-20 03:01:00', '2025-09-20 03:01:00'),
	(24, 'delete parameter-qm', 'web', '2025-09-20 03:01:00', '2025-09-20 03:01:00'),
	(25, 'read penilaian-agent', 'web', '2025-09-20 05:01:05', '2025-09-20 05:01:05'),
	(26, 'create penilaian-agent', 'web', '2025-09-20 05:01:05', '2025-09-20 05:01:05'),
	(27, 'update penilaian-agent', 'web', '2025-09-20 05:01:05', '2025-09-20 05:01:05'),
	(28, 'delete penilaian-agent', 'web', '2025-09-20 05:01:05', '2025-09-20 05:01:05'),
	(29, 'read penilaian-tappings', 'web', '2025-09-20 05:01:05', '2025-09-20 05:01:05'),
	(30, 'create penilaian-tappings', 'web', '2025-09-20 05:01:05', '2025-09-20 05:01:05'),
	(31, 'update penilaian-tappings', 'web', '2025-09-20 05:01:05', '2025-09-20 05:01:05'),
	(32, 'delete penilaian-tappings', 'web', '2025-09-20 05:01:05', '2025-09-20 05:01:05'),
	(33, 'read parameter-proses', 'web', '2025-09-20 05:01:05', '2025-09-20 05:01:05'),
	(34, 'create parameter-proses', 'web', '2025-09-20 05:01:05', '2025-09-20 05:01:05'),
	(35, 'update parameter-proses', 'web', '2025-09-20 05:01:05', '2025-09-20 05:01:05'),
	(36, 'delete parameter-proses', 'web', '2025-09-20 05:01:05', '2025-09-20 05:01:05'),
	(37, 'read parameter-sikap', 'web', '2025-09-20 05:01:05', '2025-09-20 05:01:05'),
	(38, 'create parameter-sikap', 'web', '2025-09-20 05:01:05', '2025-09-20 05:01:05'),
	(39, 'update parameter-sikap', 'web', '2025-09-20 05:01:05', '2025-09-20 05:01:05'),
	(40, 'delete parameter-sikap', 'web', '2025-09-20 05:01:05', '2025-09-20 05:01:05'),
	(41, 'read parameter-solusi', 'web', '2025-09-20 05:01:06', '2025-09-20 05:01:06'),
	(42, 'create parameter-solusi', 'web', '2025-09-20 05:01:06', '2025-09-20 05:01:06'),
	(43, 'update parameter-solusi', 'web', '2025-09-20 05:01:06', '2025-09-20 05:01:06'),
	(44, 'delete parameter-solusi', 'web', '2025-09-20 05:01:06', '2025-09-20 05:01:06');

-- Dumping structure for table laravel.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for table laravel.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel.roles: ~3 rows (approximately)
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'admin', 'web', '2025-09-20 00:38:41', '2025-09-20 00:38:41'),
	(2, 'TL', 'web', '2025-09-20 00:38:41', '2025-09-20 07:41:36'),
	(3, 'Agent', 'web', '2025-09-20 00:38:41', '2025-09-20 07:42:15'),
	(4, 'Spv', 'web', '2025-09-20 07:42:29', '2025-09-20 07:42:29');

-- Dumping structure for table laravel.role_has_permissions
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel.role_has_permissions: ~88 rows (approximately)
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
	(1, 1),
	(2, 1),
	(3, 1),
	(4, 1),
	(5, 1),
	(6, 1),
	(7, 1),
	(8, 1),
	(9, 1),
	(10, 1),
	(11, 1),
	(12, 1),
	(13, 1),
	(14, 1),
	(15, 1),
	(16, 1),
	(17, 1),
	(18, 1),
	(19, 1),
	(20, 1),
	(21, 1),
	(22, 1),
	(23, 1),
	(24, 1),
	(25, 1),
	(26, 1),
	(27, 1),
	(28, 1),
	(29, 1),
	(30, 1),
	(31, 1),
	(32, 1),
	(33, 1),
	(34, 1),
	(35, 1),
	(36, 1),
	(37, 1),
	(38, 1),
	(39, 1),
	(40, 1),
	(41, 1),
	(42, 1),
	(43, 1),
	(44, 1),
	(1, 2),
	(2, 2),
	(3, 2),
	(4, 2),
	(5, 2),
	(6, 2),
	(7, 2),
	(8, 2),
	(9, 2),
	(10, 2),
	(11, 2),
	(12, 2),
	(13, 2),
	(14, 2),
	(15, 2),
	(16, 2),
	(17, 2),
	(18, 2),
	(19, 2),
	(20, 2),
	(21, 2),
	(22, 2),
	(23, 2),
	(24, 2),
	(25, 2),
	(26, 2),
	(27, 2),
	(28, 2),
	(29, 2),
	(30, 2),
	(31, 2),
	(32, 2),
	(33, 2),
	(34, 2),
	(35, 2),
	(36, 2),
	(37, 2),
	(38, 2),
	(39, 2),
	(40, 2),
	(41, 2),
	(42, 2),
	(43, 2),
	(44, 2);

-- Dumping structure for table laravel.tb_parameter_proses
CREATE TABLE IF NOT EXISTS `tb_parameter_proses` (
  `id` int NOT NULL,
  `header_parameter_pembuka` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_p1` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_p2` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_p3` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_p4` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_p5` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `bobot_proses` int DEFAULT NULL,
  `header_parameter_verifikasi` varchar(200) DEFAULT NULL,
  `detail_v1` varchar(200) DEFAULT NULL,
  `bobot_verifikasi` varchar(200) DEFAULT NULL,
  `header_parameter_penutup` varchar(200) DEFAULT NULL,
  `detail_sp1` varchar(200) DEFAULT NULL,
  `detail_sp2` varchar(200) DEFAULT NULL,
  `bobot_penutup` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table laravel.tb_parameter_proses: ~1 rows (approximately)
INSERT INTO `tb_parameter_proses` (`id`, `header_parameter_pembuka`, `detail_p1`, `detail_p2`, `detail_p3`, `detail_p4`, `detail_p5`, `bobot_proses`, `header_parameter_verifikasi`, `detail_v1`, `bobot_verifikasi`, `header_parameter_penutup`, `detail_sp1`, `detail_sp2`, `bobot_penutup`, `created_at`, `updated_at`) VALUES
	(1, 'Menyampaikan salam pembuka', 'Salam pembuka diucapkan tidak jelas dan benar', 'Opening diucapkan dengan tidak benar (Ex:119 PSC Kota Bandung, dengan (nama agent) ada yang bisa dibantu ?)', 'Salam pembuka dan Opening tidak diucapkan dengan intonasi ramah, dan terdengar sedang tersenyum', 'Salam pembuka diucapkan > 3 detik', 'Salam pembuka dan Opening diucapkan terdengar tersendat-sendat, ragu-ragu atau diralat', 3, 'Melakukan verifikasi data pelanggan', 'Melakukan verifikasi data pelanggan', '4', 'Menyampaikan salam penutup', 'Salam penutup diucapkan tidak jelas dan benar', 'Tidak memutus (release) Closing ketika pelanggan memutus hubungan telepon (Maksimal pada detik ke-3, apabila pelanggan belum memutuskan hubungan telepon)', '3', '2024-06-26 03:45:03', '2025-09-22 05:20:57');

-- Dumping structure for table laravel.tb_parameter_sikap
CREATE TABLE IF NOT EXISTS `tb_parameter_sikap` (
  `id` int NOT NULL,
  `header_p1` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_1_1` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_1_2` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_1_3` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `bobot_p1` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `header_p2` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_2_1` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `bobot_p2` int DEFAULT NULL,
  `header_p3` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_3_1` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_3_2` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_3_3` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_3_4` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `bobot_p3` int DEFAULT NULL,
  `header_p4` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_4_1` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_4_2` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_4_3` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `bobot_p4` int DEFAULT NULL,
  `header_p5` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_5_1` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_5_2` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_5_3` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_5_4` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_5_5` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_5_6` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_5_7` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_5_8` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_5_9` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_5_10` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `bobot_p5` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `header_p6` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_6_1` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_6_2` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_6_3` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_6_4` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_6_5` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_6_6` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `bobot_p6` int DEFAULT NULL,
  `header_p7` varchar(200) DEFAULT NULL,
  `detail_7_1` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `bobot_p7` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `header_p8` varchar(200) DEFAULT NULL,
  `detail_8_1` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `bobot_p8` int DEFAULT NULL,
  `header_p9` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_9_1` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_9_2` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_9_3` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_9_4` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_9_5` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_9_6` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_9_7` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `bobot_p9` int DEFAULT NULL,
  `header_p10` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_10_1` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_10_2` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_10_3` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_10_4` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `bobot_p10` int DEFAULT NULL,
  `header_p11` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_11_1` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_11_2` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_11_3` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `bobot_p11` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table laravel.tb_parameter_sikap: ~0 rows (approximately)
INSERT INTO `tb_parameter_sikap` (`id`, `header_p1`, `detail_1_1`, `detail_1_2`, `detail_1_3`, `bobot_p1`, `header_p2`, `detail_2_1`, `bobot_p2`, `header_p3`, `detail_3_1`, `detail_3_2`, `detail_3_3`, `detail_3_4`, `bobot_p3`, `header_p4`, `detail_4_1`, `detail_4_2`, `detail_4_3`, `bobot_p4`, `header_p5`, `detail_5_1`, `detail_5_2`, `detail_5_3`, `detail_5_4`, `detail_5_5`, `detail_5_6`, `detail_5_7`, `detail_5_8`, `detail_5_9`, `detail_5_10`, `bobot_p5`, `header_p6`, `detail_6_1`, `detail_6_2`, `detail_6_3`, `detail_6_4`, `detail_6_5`, `detail_6_6`, `bobot_p6`, `header_p7`, `detail_7_1`, `bobot_p7`, `header_p8`, `detail_8_1`, `bobot_p8`, `header_p9`, `detail_9_1`, `detail_9_2`, `detail_9_3`, `detail_9_4`, `detail_9_5`, `detail_9_6`, `detail_9_7`, `bobot_p9`, `header_p10`, `detail_10_1`, `detail_10_2`, `detail_10_3`, `detail_10_4`, `bobot_p10`, `header_p11`, `detail_11_1`, `detail_11_2`, `detail_11_3`, `bobot_p11`, `created_at`, `updated_at`) VALUES
	(1, 'Menanyakan nama pelanggan & menggunakannya selama percakapan secara proporsional', 'Tidak menanyakan nama pelanggan untuk memulai membangun pembicaran yang bersahabat', 'Tidak menggunakan nama pelanggan selama percakapan secara wajar', 'Tidak melakukan perubahan, apabila terjadi perbedaan nama pelanggan yang disebutkan', '4', 'Tidak memotong percakapan pelanggan', 'Memotong pembicaraan pelanggan ketika pelanggan sedang berbicara (Notes : Boleh memotong pembicaraan dengan menggunakan kalimat Interupsi, seperti permintaan maaf terlebih dahulu)', 4, 'Menyampaikan informasi dengan jelas, tidak ragu, tidak berbelit, sistematis & tidak terburu-buru', 'Tidak menyampaikan informasi dengan jelas dan penuh keyakinan sehingga pelanggan menanyakan hal yang sama', 'Informasi disampaikan dengan berbelit-belit', 'Informasi disampaikan dengan tidak lancar, tersendat-sendat atau terdengar bergumam', 'Mengulang-ulang informasi yang telah disebutkan pelanggan, sehingga tidak merangkumnya dalam penjelasan lengkap', 5, 'Menggunakan bahasa Indonesia/inggris dengan baik, benar & sopan serta mudah dimengerti', 'Menggunakan kata Non Formal, Slank, Kedaerahan, dan kalimat mengeluh (Contoh : Aku, Kau, Lapan, Kosong, keukeuh, Bla bla, ina ini- ina ini, Lu, Kalo, Ntar, Gue, Genggeus, Doang, Rempong, Keules, Lebay, Pamali, Lemot, Susah, Lama, Ribet, Mahal, Murah, dll)', 'Tidak menyebutkan angka satu persatu (Contoh : penyebutan kata 501, tidak boleh dengan kalimat : limaratus satu, tetapi harus : lima, Nol, satu)', 'Tidak menggunakan istilah teknis yang umum dipakai di industri masing-masing dan dimengerti oleh pelanggan, Jika pelanggan tidak mengerti dengan istilah yang dipakai, maka agent wajib menjelaskannya', 7, 'Intonasi, artikulasi, logat, smiling voice, volume suara serta kecepatan berbicara', 'Tidak Terdengar ramah, tidak bersahabat atau tidak antusias', 'Nada suara tidak naik turun, datar atau terdengar seperti robot dan malas', 'Tidak ada pengaturan tempo (cepat lambat) baik saat berdialog dengan pelanggan', 'Kalimat diucapkan dengan tidak jelas', 'Mengintimidasi pelanggan dan terkesan membentak pelanggan', 'Jika pelanggan marah, nada bicara agent ikut meninggi', 'Volume suara terlalu keras sehingga mengganggu lawan bicara dan rekan kerja atau terlalu lemah sehingga tidak dapat didengar oleh lawan bicara', 'Kualitas suara terdengar sengau, kasar dan hembusan nafas (seperti mendesah) saat bicara', 'Berlogat, dialek atau aksen daerah tertentu', 'Menggunakan naskah (script) tidak sesuai dengan panduan naskah, sehingga terdengar tidak alami (seperti membaca)', '7', 'Ada kemauan untuk membantu', 'Tidak menunjukkan kepedulian terhadap masalah pelanggan, sehingga tidak menunjukkan kemauan untuk membantu', 'Apabila suara pelanggan terdengar tidak jelas (Terputus-putus) ketika komplain, agent tidak menawarkan kepada pelanggan untuk di callback kembali', 'Tidak menawarkan bantuan lain sebelum menyampaikan salam penutup', 'Menanggapi atau merespon terhadap apa yang dirasakan oleh pelanggan, tetapi datar, sehingga terkesan hanya menjalankan kewajiban saja (Tidak menyampaikan permohonan maaf atas ketidaknyamanan yang terjadi dengan tulus, pada saat pax mengajukan komplain)', 'Agent tidak mau melayani permasalahan pelanggan > 1 dan terdengar terburu-buru dalam melayani pelanggan, sehingga terkesan ingin cepat mengakhiri percakapan', 'Menanyakan kembali permasalahan pelanggan tanpa melihat history CWC (Pelanggan komplain dengan permasalahan yang sama, dan call berulang)', 4, 'Tidak memutus pembicaraan secara sepihak (Jika terbukti memutus, maka seluruh atribut dinilai 0)', 'Memutus pembicaraan secara sepihak (Jika terbukti memutus, maka seluruh atribut dinilai 0)', '0', 'Tidak ikut menyalahkan NCC 119 (Jika terbukti, maka seluruh atribut dinilai 0)', 'Menyalahkan/Menyudutkan NCC 119', 0, 'Memberikan perhatian kepada pelanggan dengan mendengarkan secara aktif dan bersikap empati', 'Tidak konsentrasi mendengarkan informasi yang disampaikan pelanggan, sehingga meminta pelanggan mengulangi informasi yang sama', 'Tidak memberikan respon aktif sehingga pelanggan merasa agent tidak mendengarkan (kata-kata yang digunakan untuk merespon harus berVARIASI, sehingga tidak terdengar seperti robot)', 'Tidak mengucapkan terima kasih setelah pelanggan memberikan informasi data yang ditanyakan', 'Tidak cepat tanggap atau tidak cepat memahami kebutuhan pelanggan', 'Tidak merangkum dan mengulangi kembali poin-poin penting yang disampaikan pelanggan dengan benar, sehingga pelanggan tidak tahu bahwa agent memahami apa yang disampaikan', 'Terdengar suara latar belakang selain agent sedang melayani pelanggan yang menyebabkan kegaduhan (Contoh : suara agent lain sedang mengobrol, ketikan keyboard komputer, dll)', 'Tidak mendengarkan pelanggan ketika pelanggan menanyakan hal lain saat agent sedang menjelaskan', 3, 'Meminta ijin saat meminta penelpon menunggu & mengucapkan terima kasih setelah pelanggan menunggu', 'Tidak meminta ijin sebelum meminta pelanggan menunggu', 'Menggunakan HOLD > 2 Menit', 'Tidak menekan tombol hold ketika melakukan pengecekan data', 'Tidak mengucapkan terima kasih setelah meminta pelanggan menunggu', 4, 'Melakukan dokumentasi permasalahan pelanggan', 'Tidak Melakukan pencatatan permasalahan serta kronologis pelanggan dengan lengkap dan akurat', 'Seluruh kontak yang ditangani, tidak dicatat dalam aplikasi dokumentasi (Contoh: CWC)', 'Penginputan data Tidak akurat (Nama, Pilihan kategori atau unit eskalasi dokumentasi, sehingga permasalahan pelanggan tidak dapat ditindaklanjuti oleh unit terkait yang tepat)', 7, '2024-06-26 03:45:03', '2025-09-22 05:21:13');

-- Dumping structure for table laravel.tb_parameter_solusi
CREATE TABLE IF NOT EXISTS `tb_parameter_solusi` (
  `id` int NOT NULL,
  `header_p1` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_p1` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `bobot_p1` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `header_p2` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_p2_1` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detail_p2_2` varchar(300) DEFAULT NULL,
  `detail_p2_3` varchar(300) DEFAULT NULL,
  `detail_p2_4` varchar(300) DEFAULT NULL,
  `bobot_p2` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table laravel.tb_parameter_solusi: ~1 rows (approximately)
INSERT INTO `tb_parameter_solusi` (`id`, `header_p1`, `detail_p1`, `bobot_p1`, `header_p2`, `detail_p2_1`, `detail_p2_2`, `detail_p2_3`, `detail_p2_4`, `bobot_p2`, `created_at`, `updated_at`) VALUES
	(1, 'Melakukan identifikasi kebutuhan pelanggan', 'Tidak menggali permasalahan pelanggan dengan tepat (Permasalahan : Informasi, Komplain dan permintaan)', '15', 'Memiliki pengetahuan yang memadai terhadap produk & prosedur layanan perusahaan', 'Tidak memberikan jawaban LENGKAP dan AKURAT (Tidak sesuai : Panduan solusi, syarat dan ketentuan beserta penalti, kewenangan yang berlaku)', 'Tidak mengeskalasi masalah yang seharusnya dieskalasi sesuai dengan SOP yang berlaku dan kewenangannya', 'Mengeskalasi tapi tidak membuat laporan baik melalui CRM ataupun media laporan lainnya yang diperbolehkan', 'Menyebutkan waktu penyelesaian masalah (SLA) tidak sesuai dengan referensi atau tidak disebutkan', 30, '2024-06-26 03:45:03', '2025-09-22 05:23:15');

-- Dumping structure for table laravel.tb_penilaian_tapping
CREATE TABLE IF NOT EXISTS `tb_penilaian_tapping` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tanggal_recording` date DEFAULT NULL,
  `periode` char(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `name_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `perner` varchar(10) DEFAULT NULL,
  `login_id` varchar(50) DEFAULT NULL,
  `site` varchar(50) DEFAULT NULL,
  `peak` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `nama_checker` varchar(50) DEFAULT NULL,
  `file` varchar(50) DEFAULT NULL,
  `detail_n1_1` int DEFAULT NULL,
  `detail_n1_2` int DEFAULT NULL,
  `detail_n1_3` int DEFAULT NULL,
  `detail_n1_4` int DEFAULT NULL,
  `detail_n1_5` int DEFAULT NULL,
  `total_n1` int DEFAULT NULL,
  `detail_n2_1` int DEFAULT NULL,
  `total_n2` int DEFAULT NULL,
  `detail_n3_1` int DEFAULT NULL,
  `detail_n3_2` int DEFAULT NULL,
  `total_n3` int DEFAULT NULL,
  `detail_n4_1` int DEFAULT NULL,
  `detail_n4_2` int DEFAULT NULL,
  `detail_n4_3` int DEFAULT NULL,
  `total_n4` int DEFAULT NULL,
  `detail_n5_1` int DEFAULT NULL,
  `total_n5` int DEFAULT NULL,
  `detail_n6_1` int DEFAULT NULL,
  `detail_n6_2` int DEFAULT NULL,
  `detail_n6_3` int DEFAULT NULL,
  `detail_n6_4` int DEFAULT NULL,
  `total_n6` int DEFAULT NULL,
  `detail_n7_1` int DEFAULT NULL,
  `detail_n7_2` int DEFAULT NULL,
  `detail_n7_3` int DEFAULT NULL,
  `total_n7` int DEFAULT NULL,
  `detail_n8_1` int DEFAULT NULL,
  `detail_n8_2` int DEFAULT NULL,
  `detail_n8_3` int DEFAULT NULL,
  `detail_n8_4` int DEFAULT NULL,
  `detail_n8_5` int DEFAULT NULL,
  `detail_n8_6` int DEFAULT NULL,
  `detail_n8_7` int DEFAULT NULL,
  `detail_n8_8` int DEFAULT NULL,
  `detail_n8_9` int DEFAULT NULL,
  `detail_n8_10` int DEFAULT NULL,
  `total_n8` int DEFAULT NULL,
  `detail_n9_1` int DEFAULT NULL,
  `detail_n9_2` int DEFAULT NULL,
  `detail_n9_3` int DEFAULT NULL,
  `detail_n9_4` int DEFAULT NULL,
  `detail_n9_5` int DEFAULT NULL,
  `detail_n9_6` int DEFAULT NULL,
  `total_n9` int DEFAULT NULL,
  `detail_n10_1` int DEFAULT NULL,
  `total_n10` int DEFAULT NULL,
  `detail_n11_1` int DEFAULT NULL,
  `total_n11` int DEFAULT NULL,
  `detail_n12_1` int DEFAULT NULL,
  `detail_n12_2` int DEFAULT NULL,
  `detail_n12_3` int DEFAULT NULL,
  `detail_n12_4` int DEFAULT NULL,
  `detail_n12_5` int DEFAULT NULL,
  `detail_n12_6` int DEFAULT NULL,
  `detail_n12_7` int DEFAULT NULL,
  `total_n12` int DEFAULT NULL,
  `detail_n13_1` int DEFAULT NULL,
  `detail_n13_2` int DEFAULT NULL,
  `detail_n13_3` int DEFAULT NULL,
  `detail_n13_4` int DEFAULT NULL,
  `total_n13` int DEFAULT NULL,
  `detail_n14_1` int DEFAULT NULL,
  `detail_n14_2` int DEFAULT NULL,
  `detail_n14_3` int DEFAULT NULL,
  `total_n14` int DEFAULT NULL,
  `detail_n15_1` int DEFAULT NULL,
  `total_n15` int DEFAULT NULL,
  `detail_n16_1` int DEFAULT NULL,
  `detail_n16_2` int DEFAULT NULL,
  `detail_n16_3` int DEFAULT NULL,
  `detail_n16_4` int DEFAULT NULL,
  `total_n16` int DEFAULT NULL,
  `total_proses` int DEFAULT NULL,
  `total_sikap` int DEFAULT NULL,
  `total_solusi` int DEFAULT NULL,
  `total_qm_p1` int DEFAULT NULL,
  `total_qm_p2` int DEFAULT NULL,
  `total_qm_p3` int DEFAULT NULL,
  `total_qm_p4` int DEFAULT NULL,
  `peak_1` int DEFAULT NULL,
  `peak_2` int DEFAULT NULL,
  `peak_3` int DEFAULT NULL,
  `total_qm` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `keterangan` varchar(50) DEFAULT NULL,
  `email_sent` varchar(50) DEFAULT NULL,
  `total_peak` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=365 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table laravel.tb_penilaian_tapping: ~0 rows (approximately)
INSERT INTO `tb_penilaian_tapping` (`id`, `tanggal_recording`, `periode`, `name_id`, `perner`, `login_id`, `site`, `peak`, `nama_checker`, `file`, `detail_n1_1`, `detail_n1_2`, `detail_n1_3`, `detail_n1_4`, `detail_n1_5`, `total_n1`, `detail_n2_1`, `total_n2`, `detail_n3_1`, `detail_n3_2`, `total_n3`, `detail_n4_1`, `detail_n4_2`, `detail_n4_3`, `total_n4`, `detail_n5_1`, `total_n5`, `detail_n6_1`, `detail_n6_2`, `detail_n6_3`, `detail_n6_4`, `total_n6`, `detail_n7_1`, `detail_n7_2`, `detail_n7_3`, `total_n7`, `detail_n8_1`, `detail_n8_2`, `detail_n8_3`, `detail_n8_4`, `detail_n8_5`, `detail_n8_6`, `detail_n8_7`, `detail_n8_8`, `detail_n8_9`, `detail_n8_10`, `total_n8`, `detail_n9_1`, `detail_n9_2`, `detail_n9_3`, `detail_n9_4`, `detail_n9_5`, `detail_n9_6`, `total_n9`, `detail_n10_1`, `total_n10`, `detail_n11_1`, `total_n11`, `detail_n12_1`, `detail_n12_2`, `detail_n12_3`, `detail_n12_4`, `detail_n12_5`, `detail_n12_6`, `detail_n12_7`, `total_n12`, `detail_n13_1`, `detail_n13_2`, `detail_n13_3`, `detail_n13_4`, `total_n13`, `detail_n14_1`, `detail_n14_2`, `detail_n14_3`, `total_n14`, `detail_n15_1`, `total_n15`, `detail_n16_1`, `detail_n16_2`, `detail_n16_3`, `detail_n16_4`, `total_n16`, `total_proses`, `total_sikap`, `total_solusi`, `total_qm_p1`, `total_qm_p2`, `total_qm_p3`, `total_qm_p4`, `peak_1`, `peak_2`, `peak_3`, `total_qm`, `created_at`, `updated_at`, `keterangan`, `email_sent`, `total_peak`) VALUES
	(359, '2025-09-01', '2025-09', '2', '216029', '1111', 'P2KT bandung', '1', 'vickybahaya', '1758537815_file_example_WAV_1MG.wav', 1, 1, 0, 1, 1, 0, 1, 4, 1, 1, 3, 1, 1, 1, 4, 1, 4, 1, 1, 1, 1, 5, 1, 1, 1, 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 7, 1, 1, 1, 1, 1, 1, 4, 1, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 3, 1, 1, 1, 1, 4, 1, 1, 1, 7, 1, 15, 1, 1, 1, 1, 30, 7, 45, 45, 97, 97, 97, NULL, NULL, NULL, NULL, NULL, '2025-09-22 03:43:35', '2025-09-22 03:48:09', 'LULUS', NULL, 97),
	(360, '2025-09-23', '2025-09', '2', '216029', '1111', 'P2KT bandung', '2', 'vickybahaya', '1758537867_file_example_WAV_1MG.wav', 1, 1, 1, 1, 1, 3, 1, 4, 1, 1, 3, 1, 1, 1, 4, 1, 4, 1, 1, 1, 1, 5, 1, 1, 1, 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 7, 1, 1, 1, 1, 1, 1, 4, 1, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 3, 1, 1, 1, 1, 4, 1, 1, 1, 7, 1, 15, 1, 1, 1, 1, 30, 10, 45, 45, 100, 100, 100, NULL, NULL, NULL, NULL, NULL, '2025-09-22 03:44:27', '2025-09-22 03:44:27', 'LULUS', NULL, 100),
	(361, '2025-09-24', '2025-09', '2', '216029', '1111', 'P2KT bandung', '3', 'vickybahaya', '1758537900_file_example_WAV_1MG.wav', 1, 1, 1, 1, 1, 3, 1, 4, 1, 1, 3, 1, 1, 1, 4, 1, 4, 1, 1, 1, 1, 5, 1, 1, 1, 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 7, 1, 1, 1, 1, 1, 1, 4, 1, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 3, 1, 1, 1, 1, 4, 1, 1, 1, 7, 1, 15, 1, 1, 1, 1, 30, 10, 45, 45, 100, 100, 100, NULL, NULL, NULL, NULL, NULL, '2025-09-22 03:45:01', '2025-09-22 03:45:01', 'LULUS', NULL, 100),
	(362, '2025-09-01', '2025-09', '3', '208288', '55480', 'P2KT bandung', '1', 'vickybahaya', '1758537966_file_example_WAV_1MG.wav', 0, 1, 1, 1, 1, 0, 0, 0, 1, 1, 3, 1, 1, 1, 4, 1, 4, 1, 1, 1, 1, 5, 1, 1, 1, 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 7, 1, 1, 1, 1, 1, 1, 4, 1, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 3, 1, 1, 1, 1, 4, 1, 1, 1, 7, 1, 15, 1, 1, 1, 1, 30, 3, 45, 45, 93, 93, 93, NULL, NULL, NULL, NULL, NULL, '2025-09-22 03:46:06', '2025-09-22 03:46:06', 'TIDAK LULUS', NULL, 93),
	(363, '2025-09-23', '2025-09', '3', '208288', '55480', 'P2KT bandung', '2', 'vickybahaya', '1758538002_file_example_WAV_1MG.wav', 1, 1, 1, 1, 1, 3, 1, 4, 1, 1, 3, 0, 1, 1, 0, 0, 0, 1, 1, 1, 1, 5, 1, 1, 1, 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 7, 1, 1, 1, 1, 1, 1, 4, 1, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 3, 1, 1, 1, 1, 4, 1, 1, 1, 7, 1, 15, 1, 1, 1, 1, 30, 10, 37, 45, 92, 92, 92, NULL, NULL, NULL, NULL, NULL, '2025-09-22 03:46:42', '2025-09-22 03:46:42', 'TIDAK LULUS', NULL, 92),
	(364, '2025-09-24', '2025-09', '3', '208288', '55480', 'P2KT bandung', '3', 'vickybahaya', '1758538034_file_example_WAV_1MG.wav', 1, 1, 1, 1, 1, 3, 1, 4, 1, 1, 3, 1, 1, 1, 4, 1, 4, 1, 1, 1, 1, 5, 1, 1, 1, 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 7, 1, 1, 1, 1, 1, 1, 4, 1, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 3, 1, 1, 1, 1, 4, 1, 1, 1, 7, 0, 0, 1, 1, 1, 1, 30, 10, 45, 30, 85, 85, 85, NULL, NULL, NULL, NULL, NULL, '2025-09-22 03:47:14', '2025-09-22 03:47:14', 'TIDAK LULUS', NULL, 85);

-- Dumping structure for table laravel.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel.users: ~5 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'vickybahaya', 'vickybahaya@gmail.com', '2025-09-20 00:38:41', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'v17uJyYmSrmZSY8jUnrPvIa8F1ta8L4xxhgwbxiVJfPm2xq9D5JPIteKPgky', '2025-09-20 00:38:41', '2025-09-20 00:38:41'),
	(2, 'Nopita Sari', 'nonnitaadiana@gmail.com', '2025-09-20 00:38:41', '$2y$10$XtjXjiAemGzeRsVOLYrqS.vx886IfkUDKqsFUzFYbuznEorkY1uKK', 'VAamBMPan5', '2025-09-20 00:38:41', '2025-09-20 07:40:35'),
	(3, 'Dudi Hermayadi', 'dudihermayadi@gmail.com', '2025-09-20 00:38:41', '$2y$10$5W49yfYo79i2hEKyENwzZOxQlwrLlK9imZPPloKUHh.PVm.Hn06ZW', '3U1HlQe3B8', '2025-09-20 00:38:41', '2025-09-20 19:03:58'),
	(4, 'RIZKA NAJIHAD', 'rizkanajihad@gmail.com', NULL, '$2y$10$ZGex3XSaLWJIoiHY8gwKiOLwMQcaVBYrKKh.iAAmQoXVQPW7JE1KK', NULL, '2025-09-20 00:57:52', '2025-09-20 19:05:13'),
	(9, 'NINDA HAPSARI', 'nindahapsari@gmail.com', NULL, '$2y$10$2HjFuwAdmo3/8wqodrJwwOhr5M6mi8Y.PXcbQswrmSSP7LlGqfiv6', NULL, '2025-09-21 12:55:09', '2025-09-21 12:55:09');

-- Dumping structure for table laravel.user_profiles
CREATE TABLE IF NOT EXISTS `user_profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempat_lahir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `perner` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `layanan` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `login_id` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_profiles_user_id_foreign` (`user_id`),
  CONSTRAINT `user_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel.user_profiles: ~4 rows (approximately)
INSERT INTO `user_profiles` (`id`, `user_id`, `no_hp`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `image`, `created_at`, `updated_at`, `perner`, `site`, `layanan`, `login_id`) VALUES
	(1, 1, '089678468651', 'Jakarta', '1991-04-05', 'laki-laki', 'Jl. H. Gadung no.20, Pondok Ranji, Ciputat Timur, Tangerang Selatan, Banten', NULL, '2025-09-20 00:38:41', '2025-09-20 00:38:41', NULL, NULL, NULL, NULL),
	(2, 2, '085175029112', 'Bogor', '1991-11-29', 'perempuan', 'Jl.Rancasawo no.36a', NULL, '2025-09-20 00:38:41', '2025-09-20 07:40:35', '216029', 'P2KT bandung', 'SPGDT 119', '1111'),
	(3, 3, '088', 'Bandung', '1990-11-21', 'laki-laki', '-', NULL, '2025-09-20 00:38:41', '2025-09-20 19:03:58', '208288', 'P2KT bandung', 'SPGDT 119', '55480'),
	(4, 4, '78373624983', NULL, '2025-09-18', 'laki-laki', '-', NULL, '2025-09-20 00:57:52', '2025-09-20 19:05:13', '63436', 'P2KT bandung', 'SPGDT 119', '55497'),
	(5, 9, '098765876', NULL, '2025-09-21', 'perempuan', 'ertyuijokl;\'', NULL, '2025-09-21 12:55:09', '2025-09-21 12:55:09', '45678', 'P2KT bandung', 'SPGDT 119', '456789');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
