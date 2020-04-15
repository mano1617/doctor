-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2020 at 01:29 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `homeo_db`
--
CREATE DATABASE IF NOT EXISTS `homeo_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `homeo_db`;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ledgers`
--

DROP TABLE IF EXISTS `ledgers`;
CREATE TABLE `ledgers` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `recordable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recordable_id` bigint(20) UNSIGNED NOT NULL,
  `context` tinyint(3) UNSIGNED NOT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `properties` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `modified` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pivot` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `extra` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signature` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ledgers`
--

INSERT INTO `ledgers` (`id`, `user_type`, `user_id`, `recordable_type`, `recordable_id`, `context`, `event`, `properties`, `modified`, `pivot`, `extra`, `url`, `ip_address`, `user_agent`, `signature`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\Auth\\User', 1, 'App\\Models\\Auth\\User', 1, 4, 'updated', '{\"id\":1,\"uuid\":\"f17f41bc-9d46-4b6b-af38-34d57be7cd65\",\"first_name\":\"Super\",\"last_name\":\"Admin\",\"email\":\"admin@admin.com\",\"avatar_type\":\"gravatar\",\"avatar_location\":null,\"password\":\"$2y$10$VE0dj0rgX6oPRdQTG0VRfOQF\\/\\/OnYGKhCAhzcC7YNBGUceiohEAfO\",\"password_changed_at\":null,\"active\":1,\"confirmation_code\":\"8df2ddf96e75e38d112b47b5d41195e2\",\"confirmed\":1,\"timezone\":null,\"last_login_at\":null,\"last_login_ip\":null,\"to_be_logged_out\":0,\"remember_token\":\"YHgrQU0mEkVoBq7FUXRWghU0WSBxb85YFGeisGK2wlHofXQWZshTWf0YK96E\",\"created_at\":\"2020-04-14 18:04:32\",\"updated_at\":\"2020-04-14 18:04:32\",\"deleted_at\":null}', '[\"remember_token\"]', '[]', '[]', 'http://localhost/test_lar/public/login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36', '04e1e7e2ab48dd85366bd7ffba3c7539a25ae277317a187356cb6e10f1198630a01f8726fd328d95e703e9a5ba970d185a067f0c185a5780acb853cd587e6678', '2020-04-14 12:35:16', '2020-04-14 12:35:16'),
(2, 'App\\Models\\Auth\\User', 1, 'App\\Models\\Auth\\User', 1, 4, 'updated', '{\"id\":1,\"uuid\":\"f17f41bc-9d46-4b6b-af38-34d57be7cd65\",\"first_name\":\"Super\",\"last_name\":\"Admin\",\"email\":\"admin@admin.com\",\"avatar_type\":\"gravatar\",\"avatar_location\":null,\"password\":\"$2y$10$VE0dj0rgX6oPRdQTG0VRfOQF\\/\\/OnYGKhCAhzcC7YNBGUceiohEAfO\",\"password_changed_at\":null,\"active\":1,\"confirmation_code\":\"8df2ddf96e75e38d112b47b5d41195e2\",\"confirmed\":1,\"timezone\":\"America\\/New_York\",\"last_login_at\":\"2020-04-14 18:05:16\",\"last_login_ip\":\"::1\",\"to_be_logged_out\":0,\"remember_token\":\"YHgrQU0mEkVoBq7FUXRWghU0WSBxb85YFGeisGK2wlHofXQWZshTWf0YK96E\",\"created_at\":\"2020-04-14 18:04:32\",\"updated_at\":\"2020-04-14 18:05:19\",\"deleted_at\":null}', '[\"timezone\",\"last_login_at\",\"last_login_ip\",\"updated_at\"]', '[]', '[]', 'http://localhost/test_lar/public/login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36', 'de65b4a24cb161763fa847e1ee571d7921bc82a6e4fbef3dcbdc3ef841676ee461ad0b31c7fba67b0b409b53aed5f4ccaeda348f7781ca39d6ade9ab0098be23', '2020-04-14 12:35:19', '2020-04-14 12:35:19'),
(3, 'App\\Models\\Auth\\User', 1, 'App\\Models\\Auth\\User', 1, 4, 'updated', '{\"id\":1,\"uuid\":\"f17f41bc-9d46-4b6b-af38-34d57be7cd65\",\"first_name\":\"Super\",\"last_name\":\"Admin\",\"email\":\"admin@admin.com\",\"avatar_type\":\"gravatar\",\"avatar_location\":null,\"password\":\"$2y$10$VE0dj0rgX6oPRdQTG0VRfOQF\\/\\/OnYGKhCAhzcC7YNBGUceiohEAfO\",\"password_changed_at\":null,\"active\":1,\"confirmation_code\":\"8df2ddf96e75e38d112b47b5d41195e2\",\"confirmed\":1,\"timezone\":\"America\\/New_York\",\"last_login_at\":\"2020-04-14 18:05:16\",\"last_login_ip\":\"::1\",\"to_be_logged_out\":0,\"remember_token\":\"3Ree4fOpwQkNKKCdCk8pIj1fxAQOGPeeS3mbcqDfRJHHAnS7Ck96OCMT2mul\",\"created_at\":\"2020-04-14 18:04:32\",\"updated_at\":\"2020-04-14 18:05:19\",\"deleted_at\":null}', '[\"remember_token\"]', '[]', '[]', 'http://localhost/test_lar/public/logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36', 'eb629616c26d1f6b6106c58107cfaebd322e4df4b2ab4f61c86d8015f62d4ebe724b4905f32e8178dd269e1fbcb987529a44348be197d533aa257e8cfe5a2b80', '2020-04-14 12:35:48', '2020-04-14 12:35:48'),
(4, 'App\\Models\\Auth\\User', 1, 'App\\Models\\Auth\\User', 1, 4, 'updated', '{\"id\":1,\"uuid\":\"f17f41bc-9d46-4b6b-af38-34d57be7cd65\",\"first_name\":\"Super\",\"last_name\":\"Admin\",\"email\":\"admin@admin.com\",\"avatar_type\":\"gravatar\",\"avatar_location\":null,\"password\":\"$2y$10$VE0dj0rgX6oPRdQTG0VRfOQF\\/\\/OnYGKhCAhzcC7YNBGUceiohEAfO\",\"password_changed_at\":null,\"active\":1,\"confirmation_code\":\"8df2ddf96e75e38d112b47b5d41195e2\",\"confirmed\":1,\"timezone\":\"America\\/New_York\",\"last_login_at\":\"2020-04-14 18:11:29\",\"last_login_ip\":\"::1\",\"to_be_logged_out\":0,\"remember_token\":\"3Ree4fOpwQkNKKCdCk8pIj1fxAQOGPeeS3mbcqDfRJHHAnS7Ck96OCMT2mul\",\"created_at\":\"2020-04-14 18:04:32\",\"updated_at\":\"2020-04-14 18:11:30\",\"deleted_at\":null}', '[\"last_login_at\",\"updated_at\"]', '[]', '[]', 'http://localhost/test_lar/login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36', '9435fe69dcfad23a9e9739408fb1b7cfabe877ae1c9074836c3747a968f364baa7381cc0fd7aa019dd41320c7f42d7c4e9e3b4c9b7f26f160d610ef0381545d7', '2020-04-14 12:41:30', '2020-04-14 12:41:30'),
(5, 'App\\Models\\Auth\\User', 1, 'App\\Models\\Auth\\User', 1, 4, 'updated', '{\"id\":1,\"uuid\":\"f17f41bc-9d46-4b6b-af38-34d57be7cd65\",\"first_name\":\"Super\",\"last_name\":\"Admin\",\"email\":\"admin@admin.com\",\"avatar_type\":\"gravatar\",\"avatar_location\":null,\"password\":\"$2y$10$VE0dj0rgX6oPRdQTG0VRfOQF\\/\\/OnYGKhCAhzcC7YNBGUceiohEAfO\",\"password_changed_at\":null,\"active\":1,\"confirmation_code\":\"8df2ddf96e75e38d112b47b5d41195e2\",\"confirmed\":1,\"timezone\":\"America\\/New_York\",\"last_login_at\":\"2020-04-14 18:11:29\",\"last_login_ip\":\"::1\",\"to_be_logged_out\":0,\"remember_token\":\"Z5a8pwLyxtUy0MmtRpSvDWwhfrsbPRh6cyY6tPCtlJBDCa35fLGuTWrWRbrM\",\"created_at\":\"2020-04-14 18:04:32\",\"updated_at\":\"2020-04-14 18:11:30\",\"deleted_at\":null}', '[\"remember_token\"]', '[]', '[]', 'http://localhost/test_lar/logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36', 'f69a77213565194753bb63ff74efd5e13dffcb87d21f0421a1039d733570a1520eeee4bca12559fb49396b4c64ebaa94fd834ae249ff965566b67b3d16835661', '2020-04-15 04:41:33', '2020-04-15 04:41:33'),
(6, 'App\\Models\\Auth\\User', 1, 'App\\Models\\Auth\\User', 1, 4, 'updated', '{\"id\":1,\"uuid\":\"f17f41bc-9d46-4b6b-af38-34d57be7cd65\",\"first_name\":\"Super\",\"last_name\":\"Admin\",\"email\":\"admin@admin.com\",\"avatar_type\":\"gravatar\",\"avatar_location\":null,\"password\":\"$2y$10$VE0dj0rgX6oPRdQTG0VRfOQF\\/\\/OnYGKhCAhzcC7YNBGUceiohEAfO\",\"password_changed_at\":null,\"active\":1,\"confirmation_code\":\"8df2ddf96e75e38d112b47b5d41195e2\",\"confirmed\":1,\"timezone\":\"America\\/New_York\",\"last_login_at\":\"2020-04-15 10:18:40\",\"last_login_ip\":\"::1\",\"to_be_logged_out\":0,\"remember_token\":\"Z5a8pwLyxtUy0MmtRpSvDWwhfrsbPRh6cyY6tPCtlJBDCa35fLGuTWrWRbrM\",\"created_at\":\"2020-04-14 18:04:32\",\"updated_at\":\"2020-04-15 10:18:41\",\"deleted_at\":null}', '[\"last_login_at\",\"updated_at\"]', '[]', '[]', 'http://localhost/test_lar/login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36', '8bb42026ab17255d2a1d5ddaadc48ef9228cd6e1a9619c6102f28bd772bd2c716205f800b57b017d6813b39b341eeffe16a6d0d47b5a48cd71612653885eb0dd', '2020-04-15 04:48:41', '2020-04-15 04:48:41'),
(7, 'App\\Models\\Auth\\User', 1, 'App\\Models\\Auth\\User', 1, 4, 'updated', '{\"id\":1,\"uuid\":\"f17f41bc-9d46-4b6b-af38-34d57be7cd65\",\"first_name\":\"Super\",\"last_name\":\"Admin\",\"email\":\"admin@admin.com\",\"avatar_type\":\"gravatar\",\"avatar_location\":null,\"password\":\"$2y$10$VE0dj0rgX6oPRdQTG0VRfOQF\\/\\/OnYGKhCAhzcC7YNBGUceiohEAfO\",\"password_changed_at\":null,\"active\":1,\"confirmation_code\":\"8df2ddf96e75e38d112b47b5d41195e2\",\"confirmed\":1,\"timezone\":\"America\\/New_York\",\"last_login_at\":\"2020-04-15 10:18:40\",\"last_login_ip\":\"::1\",\"to_be_logged_out\":0,\"remember_token\":\"xvYmmGyWfb1EnXyqyFBGCqLK2SbxpKQX6rBIX4nfYktt5rpQ0otDNYV8uki6\",\"created_at\":\"2020-04-14 18:04:32\",\"updated_at\":\"2020-04-15 10:18:41\",\"deleted_at\":null}', '[\"remember_token\"]', '[]', '[]', 'http://localhost/test_lar/logout', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36', '75989c44734bb7ec0932b5f356a98a1b8185542c2de347a2212771b1de95eadc1e31fcce0b1b2a25ed92ca52a1dd36db45e4a570cca4008eb09ebc180a938e4d', '2020-04-15 04:52:18', '2020-04-15 04:52:18'),
(8, 'App\\Models\\Auth\\User', 1, 'App\\Models\\Auth\\User', 1, 4, 'updated', '{\"id\":1,\"uuid\":\"f17f41bc-9d46-4b6b-af38-34d57be7cd65\",\"first_name\":\"Super\",\"last_name\":\"Admin\",\"email\":\"admin@admin.com\",\"avatar_type\":\"gravatar\",\"avatar_location\":null,\"password\":\"$2y$10$VE0dj0rgX6oPRdQTG0VRfOQF\\/\\/OnYGKhCAhzcC7YNBGUceiohEAfO\",\"password_changed_at\":null,\"active\":1,\"confirmation_code\":\"8df2ddf96e75e38d112b47b5d41195e2\",\"confirmed\":1,\"timezone\":\"America\\/New_York\",\"last_login_at\":\"2020-04-15 10:27:57\",\"last_login_ip\":\"::1\",\"to_be_logged_out\":0,\"remember_token\":\"xvYmmGyWfb1EnXyqyFBGCqLK2SbxpKQX6rBIX4nfYktt5rpQ0otDNYV8uki6\",\"created_at\":\"2020-04-14 18:04:32\",\"updated_at\":\"2020-04-15 10:27:58\",\"deleted_at\":null}', '[\"last_login_at\",\"updated_at\"]', '[]', '[]', 'http://localhost/doctor/login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36', '9e198176b2ef5fb379cebfbc2de4c2c6e7de747824de72b61dce428df9b163aca8b1ef16bc20a479036795c2b92498448576e06ce96bb4ba2f48a0464c21c22a', '2020-04-15 04:57:58', '2020-04-15 04:57:58');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2017_09_03_144628_create_permission_tables', 1),
(4, '2017_09_11_174816_create_social_accounts_table', 1),
(5, '2017_09_26_140332_create_cache_table', 1),
(6, '2017_09_26_140528_create_sessions_table', 1),
(7, '2017_09_26_140609_create_jobs_table', 1),
(8, '2018_04_08_033256_create_password_histories_table', 1),
(9, '2018_11_21_000001_create_ledgers_table', 1),
(10, '2019_08_19_000000_create_failed_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\Auth\\User', 1),
(2, 'App\\Models\\Auth\\User', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_histories`
--

DROP TABLE IF EXISTS `password_histories`;
CREATE TABLE `password_histories` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_histories`
--

INSERT INTO `password_histories` (`id`, `user_id`, `password`, `created_at`, `updated_at`) VALUES
(1, 1, '$2y$10$VE0dj0rgX6oPRdQTG0VRfOQF//OnYGKhCAhzcC7YNBGUceiohEAfO', '2020-04-14 12:34:32', '2020-04-14 12:34:32'),
(2, 2, '$2y$10$Xvl2.BHIzLGFRbn/Hq2yL.bQ2iMMZrx2.ei07o8WP.dQdWA63PH72', '2020-04-14 12:34:32', '2020-04-14 12:34:32');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view backend', 'web', '2020-04-14 12:34:32', '2020-04-14 12:34:32');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'administrator', 'web', '2020-04-14 12:34:32', '2020-04-14 12:34:32'),
(2, 'user', 'web', '2020-04-14 12:34:32', '2020-04-14 12:34:32');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `social_accounts`
--

DROP TABLE IF EXISTS `social_accounts`;
CREATE TABLE `social_accounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `provider` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'gravatar',
  `avatar_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_changed_at` timestamp NULL DEFAULT NULL,
  `active` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `confirmation_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT 0,
  `timezone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `last_login_ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `to_be_logged_out` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uuid`, `first_name`, `last_name`, `email`, `avatar_type`, `avatar_location`, `password`, `password_changed_at`, `active`, `confirmation_code`, `confirmed`, `timezone`, `last_login_at`, `last_login_ip`, `to_be_logged_out`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'f17f41bc-9d46-4b6b-af38-34d57be7cd65', 'Super', 'Admin', 'admin@admin.com', 'gravatar', NULL, '$2y$10$VE0dj0rgX6oPRdQTG0VRfOQF//OnYGKhCAhzcC7YNBGUceiohEAfO', NULL, 1, '8df2ddf96e75e38d112b47b5d41195e2', 1, 'America/New_York', '2020-04-15 04:57:57', '::1', 0, 'xvYmmGyWfb1EnXyqyFBGCqLK2SbxpKQX6rBIX4nfYktt5rpQ0otDNYV8uki6', '2020-04-14 12:34:32', '2020-04-15 04:57:58', NULL),
(2, '367f65f1-7a56-4fbb-8bed-e8dbd9dabab9', 'Default', 'User', 'user@user.com', 'gravatar', NULL, '$2y$10$Xvl2.BHIzLGFRbn/Hq2yL.bQ2iMMZrx2.ei07o8WP.dQdWA63PH72', NULL, 1, '14ae515819e3f47db64495958048c1b5', 1, NULL, NULL, NULL, 0, NULL, '2020-04-14 12:34:32', '2020-04-14 12:34:32', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD UNIQUE KEY `cache_key_unique` (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `ledgers`
--
ALTER TABLE `ledgers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ledgers_recordable_type_recordable_id_index` (`recordable_type`,`recordable_id`),
  ADD KEY `ledgers_user_id_user_type_index` (`user_id`,`user_type`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_type_model_id_index` (`model_type`,`model_id`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_type_model_id_index` (`model_type`,`model_id`);

--
-- Indexes for table `password_histories`
--
ALTER TABLE `password_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `password_histories_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `roles_name_index` (`name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD UNIQUE KEY `sessions_id_unique` (`id`);

--
-- Indexes for table `social_accounts`
--
ALTER TABLE `social_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `social_accounts_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ledgers`
--
ALTER TABLE `ledgers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `password_histories`
--
ALTER TABLE `password_histories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `social_accounts`
--
ALTER TABLE `social_accounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `password_histories`
--
ALTER TABLE `password_histories`
  ADD CONSTRAINT `password_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `social_accounts`
--
ALTER TABLE `social_accounts`
  ADD CONSTRAINT `social_accounts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
