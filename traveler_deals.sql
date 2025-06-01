-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 04, 2024 at 10:25 AM
-- Server version: 10.11.7-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u520301225_traveler`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `fcm_token` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `email`, `username`, `image`, `email_verified_at`, `password`, `first_name`, `last_name`, `fcm_token`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin@test.com', 'admin', NULL, NULL, '$2y$10$MweZjnmaCpRB5Bw1ze2VROQqJoBE/c2lTH70T1wIs75PNIB/vX.Bq', NULL, NULL, NULL, 1, '54tYOAFyPK0TrSH0feuCTAwSpovSvdM05miqBv0IAsdCjRTLJmdP1S9GyfDj', '2023-11-13 01:43:13', '2023-11-13 01:43:13');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '2023-11-13 01:43:13', '2023-11-13 01:43:13'),
(2, 1, '2023-11-13 01:43:13', '2023-11-13 01:43:13'),
(3, 1, '2023-11-13 01:43:13', '2023-11-13 01:43:13'),
(4, 1, '2023-11-13 01:43:13', '2023-11-13 01:43:13'),
(5, 1, '2023-11-13 01:43:13', '2023-11-13 01:43:13'),
(6, 1, '2023-11-13 01:43:13', '2023-11-13 01:43:13'),
(7, 1, '2023-11-13 01:43:13', '2023-11-13 01:43:13'),
(8, 1, '2023-11-13 01:43:13', '2023-11-13 01:43:13'),
(9, 1, '2023-11-13 01:43:13', '2023-11-13 01:43:13'),
(10, 1, '2023-11-13 01:43:13', '2023-11-13 01:43:13'),
(11, 1, '2023-11-13 01:43:13', '2023-11-13 01:43:13'),
(12, 1, '2023-11-13 01:43:13', '2023-11-13 01:43:13'),
(13, 1, '2023-11-13 01:43:13', '2023-11-13 01:43:13');

-- --------------------------------------------------------

--
-- Table structure for table `category_translations`
--

CREATE TABLE `category_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `locale` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_translations`
--

INSERT INTO `category_translations` (`id`, `category_id`, `locale`, `title`, `description`) VALUES
(1, 1, 'en', 'Cell phones & Accessories', NULL),
(2, 1, 'ar', 'الهواتف الخلوية والاكسسوارات', NULL),
(3, 2, 'en', 'Computers & Accessories', NULL),
(4, 2, 'ar', 'أجهزة الكمبيوتر وملحقاتها', NULL),
(5, 3, 'en', 'Automotive parts & Accessories', NULL),
(6, 3, 'ar', 'قطع غيار السيارات', NULL),
(7, 4, 'en', 'Beauty & Personal care', NULL),
(8, 4, 'ar', 'الجمال و العناية الشخصية', NULL),
(9, 5, 'en', 'Vitamins & Supplements', NULL),
(10, 5, 'ar', 'الفيتامينات والمكملات الغذائية', NULL),
(11, 6, 'en', 'Cosmetic & Perfumes', NULL),
(12, 6, 'ar', 'مستحضرات التجميل والعطور', NULL),
(13, 7, 'en', 'Books & Documents', NULL),
(14, 7, 'ar', 'الكتب والوثائق', NULL),
(15, 8, 'en', 'Sunglasses & Watches', NULL),
(16, 8, 'ar', 'النظارات الشمسية والساعات', NULL),
(17, 9, 'en', 'Clothing & Shoes', NULL),
(18, 9, 'ar', 'الملابس والأحذية', NULL),
(19, 10, 'en', 'Arts & Gifts', NULL),
(20, 10, 'ar', 'الفنون والهدايا', NULL),
(21, 11, 'en', 'Toys & Games', NULL),
(22, 11, 'ar', 'الدمى والألعاب', NULL),
(23, 12, 'en', 'Food & Health', NULL),
(24, 12, 'ar', 'الغذاء والصحة', NULL),
(25, 13, 'en', 'Electronics', NULL),
(26, 13, 'ar', 'إلكترونيات', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deals`
--

CREATE TABLE `deals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `trip_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `qr_code` text NOT NULL,
  `dealable_id` int(11) NOT NULL,
  `dealable_type` varchar(255) NOT NULL,
  `reward` decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `amount` decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `estimated_total` decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `shopper_payed` tinyint(1) NOT NULL DEFAULT 1,
  `shopper_payed_at` timestamp NULL DEFAULT NULL,
  `traveler_payed` tinyint(1) NOT NULL DEFAULT 0,
  `traveler_payed_at` timestamp NULL DEFAULT NULL,
  `shopper_rated` tinyint(1) NOT NULL DEFAULT 0,
  `traveler_rated` tinyint(1) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deals`
--

INSERT INTO `deals` (`id`, `trip_id`, `order_id`, `qr_code`, `dealable_id`, `dealable_type`, `reward`, `amount`, `estimated_total`, `shopper_payed`, `shopper_payed_at`, `traveler_payed`, `traveler_payed_at`, `shopper_rated`, `traveler_rated`, `status`, `created_at`, `updated_at`) VALUES
(17, 25, 19, 'KaWIp37budaIFCFYjIsZTVwT1QH7A54apsDrxRcFRVfbjxipXj', 10, 'App\\Models\\OrderOffer', '112.00', '0.00', '1657.60', 1, '2024-01-05 11:42:30', 0, NULL, 0, 0, 1, '2024-01-05 11:42:30', '2024-01-05 11:42:30'),
(18, 26, 20, 'Ej49Q8mYHfK1SjDYodfOXoF3fYBYGC2VsXEFpSQuzTzrtudu6u', 11, 'App\\Models\\OrderOffer', '25.30', '0.00', '136.57', 1, '2024-01-05 12:10:09', 1, '2024-01-05 12:10:56', 1, 1, 4, '2024-01-05 12:10:09', '2024-01-05 13:35:15'),
(19, 29, 46, 'TuLEpC6K6bQq69QHfXiObuptp25Vt1cSsx7UWMyWnQ6B3GK33V', 15, 'App\\Models\\TripRequest', '103.20', '0.00', '1428.36', 1, '2024-04-22 20:02:53', 1, '2024-04-22 20:06:28', 1, 1, 4, '2024-04-22 20:02:53', '2024-04-22 20:08:47'),
(20, 30, 47, 'hi0FtIsJLJ7TfIhLkUkAUWEJNscZgfISx3F8FWtoleY4MLtS0L', 16, 'App\\Models\\TripRequest', '169.40', '0.00', '2597.87', 1, '2024-04-23 14:29:21', 1, '2024-04-23 14:29:45', 1, 1, 4, '2024-04-23 14:29:21', '2024-04-23 14:33:29');

-- --------------------------------------------------------

--
-- Table structure for table `deal_statuses`
--

CREATE TABLE `deal_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `deal_id` bigint(20) UNSIGNED NOT NULL,
  `message` varchar(255) DEFAULT NULL,
  `new_status` int(11) NOT NULL DEFAULT 1,
  `type` smallint(6) NOT NULL DEFAULT 1,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deal_statuses`
--

INSERT INTO `deal_statuses` (`id`, `deal_id`, `message`, `new_status`, `type`, `status`, `created_at`, `updated_at`) VALUES
(34, 17, NULL, 1, 1, 1, '2024-01-05 11:42:30', '2024-01-05 11:42:30'),
(36, 18, NULL, 1, 1, 1, '2024-01-05 12:10:09', '2024-01-05 12:10:09'),
(37, 18, NULL, 2, 2, 1, '2024-01-05 12:10:56', '2024-01-05 12:10:56'),
(38, 18, NULL, 3, 2, 1, '2024-01-05 12:11:12', '2024-01-05 12:11:12'),
(39, 18, NULL, 4, 1, 1, '2024-01-05 12:17:23', '2024-01-05 12:17:23'),
(40, 18, NULL, 5, 1, 1, '2024-01-05 12:17:41', '2024-01-05 12:17:41'),
(41, 18, NULL, 5, 2, 1, '2024-01-05 13:20:38', '2024-01-05 13:20:38'),
(42, 18, NULL, 5, 1, 1, '2024-01-05 13:35:15', '2024-01-05 13:35:15'),
(43, 19, NULL, 1, 1, 1, '2024-04-22 20:02:53', '2024-04-22 20:02:53'),
(44, 19, NULL, 2, 2, 1, '2024-04-22 20:06:28', '2024-04-22 20:06:28'),
(45, 19, NULL, 3, 2, 1, '2024-04-22 20:06:45', '2024-04-22 20:06:45'),
(46, 19, NULL, 4, 1, 1, '2024-04-22 20:07:36', '2024-04-22 20:07:36'),
(47, 19, NULL, 5, 2, 1, '2024-04-22 20:07:49', '2024-04-22 20:07:49'),
(48, 19, NULL, 5, 1, 1, '2024-04-22 20:08:47', '2024-04-22 20:08:47'),
(49, 20, NULL, 1, 1, 1, '2024-04-23 14:29:21', '2024-04-23 14:29:21'),
(50, 20, NULL, 2, 2, 1, '2024-04-23 14:29:45', '2024-04-23 14:29:45'),
(51, 20, NULL, 3, 2, 1, '2024-04-23 14:30:43', '2024-04-23 14:30:43'),
(52, 20, NULL, 4, 1, 1, '2024-04-23 14:31:34', '2024-04-23 14:31:34'),
(53, 20, NULL, 5, 2, 1, '2024-04-23 14:31:47', '2024-04-23 14:31:47'),
(54, 20, NULL, 5, 1, 1, '2024-04-23 14:33:29', '2024-04-23 14:33:29');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favourites`
--

CREATE TABLE `favourites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `help_supports`
--

CREATE TABLE `help_supports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `subject` text DEFAULT NULL,
  `details` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_02_22_132006_create_categories_table', 1),
(6, '2023_02_22_132621_create_category_translations_table', 1),
(7, '2023_02_22_132638_create_news_table', 1),
(8, '2023_02_22_132719_create_news_translations_table', 1),
(9, '2023_02_22_154724_create_admins_table', 1),
(10, '2023_02_24_213503_create_trips_table', 1),
(11, '2023_02_24_213524_create_orders_table', 1),
(12, '2023_02_25_102949_create_order_items_table', 1),
(13, '2023_02_25_115708_create_help_supports_table', 1),
(14, '2023_03_02_092752_create_order_offers_table', 1),
(15, '2023_03_02_093225_create_trip_requests_table', 1),
(16, '2023_03_02_093244_create_deals_table', 1),
(17, '2023_03_13_124129_create_deal_statuses_table', 1),
(18, '2023_03_13_131303_create_trip_not_categories_table', 1),
(19, '2023_03_13_134657_create_favourites_table', 1),
(20, '2023_03_13_134716_create_coupons_table', 1),
(21, '2023_03_13_141128_create_otps_table', 1),
(22, '2023_04_05_191524_create_order_item_images_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `news_translations`
--

CREATE TABLE `news_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `news_id` bigint(20) UNSIGNED NOT NULL,
  `locale` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `notifiable_type`, `notifiable_id`, `data`, `type`, `status`, `read_at`, `created_at`, `updated_at`) VALUES
('b25f7471-2d6e-4f2c-acd1-aaefcca8fdd7', 'App\\Models\\User', 3, '{\"title\":\"notifications.accepted_your_trip\",\"body\":\"notifications.accepted_your_trip_txt\",\"item_id\":23,\"image_path\":\"https:\\/\\/traveler.hananalslaiman.com\\/uploads\\/trips\\/photos\\/thumbs\\/trips_1704452758.jpg\",\"route\":\"\\/trips_View\"}', 'App\\Notifications\\User\\SendTripPublishedNotif', 1, '2024-01-05 11:09:44', '2024-01-05 11:09:06', '2024-01-05 11:09:44'),
('3d75ed28-4050-42ad-86fd-5591ef3fb07b', 'App\\Models\\User', 3, '{\"title\":\"notifications.accepted_your_trip\",\"body\":\"notifications.accepted_your_trip_txt\",\"item_id\":24,\"image_path\":\"https:\\/\\/traveler.hananalslaiman.com\\/uploads\\/trips\\/photos\\/thumbs\\/trips_1704453408.jpg\",\"route\":\"\\/trips_View\"}', 'App\\Notifications\\User\\SendTripPublishedNotif', 1, NULL, '2024-01-05 11:17:55', '2024-01-05 11:17:55'),
('c2856b88-5366-445c-a5dc-e8ab5497b39c', 'App\\Models\\User', 5, '{\"title\":\"notifications.new_order_offer\",\"body\":\"notifications.new_order_offer\",\"item_id\":18,\"image_path\":\"https:\\/\\/traveler.hananalslaiman.com\\/assets\\/dash\\/img\\/trip.png\",\"route\":\"\\/offers_Order_View\"}', 'App\\Notifications\\User\\SendNewOrderOfferNotif', 1, '2024-01-05 11:19:44', '2024-01-05 11:19:25', '2024-01-05 11:19:44'),
('a42be2aa-dfa1-4d5a-8d76-896e0b6bedaf', 'App\\Models\\User', 5, '{\"title\":\"notifications.accepted_your_offer\",\"body\":\"notifications.accepted_your_offer_txt\",\"item_id\":24,\"image_path\":null,\"route\":null}', 'App\\Notifications\\User\\SendOrderOfferAcceptedNotif', 1, '2024-01-05 11:23:15', '2024-01-05 11:19:47', '2024-01-05 11:23:15'),
('050b5cfd-e62c-4048-898b-8a3fca565c6d', 'App\\Models\\User', 3, '{\"title\":\"notifications.payed_order\",\"body\":\"notifications.payed_order_txt\",\"item_id\":18,\"image_path\":null,\"route\":\"\\/traking_Order_For_Travaler\"}', 'App\\Notifications\\User\\SendOrderPayedNotif', 1, NULL, '2024-01-05 11:20:36', '2024-01-05 11:20:36'),
('cad34244-2ec0-4516-baca-f17b01430abb', 'App\\Models\\User', 5, '{\"title\":\"notifications.accepted_your_trip\",\"body\":\"notifications.accepted_your_trip_txt\",\"item_id\":25,\"image_path\":\"https:\\/\\/traveler.hananalslaiman.com\\/uploads\\/trips\\/photos\\/thumbs\\/trips_1704454780.jpg\",\"route\":\"\\/trips_View\"}', 'App\\Notifications\\User\\SendTripPublishedNotif', 1, '2024-03-17 18:01:40', '2024-01-05 11:40:23', '2024-03-17 18:01:40'),
('2cd3c7c2-b314-453c-87d2-d7beabc8952d', 'App\\Models\\User', 5, '{\"title\":\"notifications.new_trip_request\",\"body\":\"notifications.new_trip_request_txt\",\"item_id\":25,\"image_path\":null,\"route\":\"\\/trip-offers\"}', 'App\\Notifications\\User\\SendNewTripRequestNotif', 1, '2024-03-17 18:01:34', '2024-01-05 11:40:46', '2024-03-17 18:01:34'),
('d03ab0a4-ff90-4774-be4b-9a04d2657b9a', 'App\\Models\\User', 3, '{\"title\":\"notifications.new_order_offer\",\"body\":\"notifications.new_order_offer\",\"item_id\":19,\"image_path\":\"https:\\/\\/traveler.hananalslaiman.com\\/assets\\/dash\\/img\\/trip.png\",\"route\":\"\\/offers_Order_View\"}', 'App\\Notifications\\User\\SendNewOrderOfferNotif', 1, NULL, '2024-01-05 11:41:45', '2024-01-05 11:41:45'),
('4b058c8d-46a1-4930-be8e-de81dabea602', 'App\\Models\\User', 3, '{\"title\":\"notifications.accepted_your_offer\",\"body\":\"notifications.accepted_your_offer_txt\",\"item_id\":25,\"image_path\":null,\"route\":null}', 'App\\Notifications\\User\\SendOrderOfferAcceptedNotif', 1, NULL, '2024-01-05 11:42:08', '2024-01-05 11:42:08'),
('eaf856ba-7cae-41f6-bfb1-cf55193c43c5', 'App\\Models\\User', 5, '{\"title\":\"notifications.payed_order\",\"body\":\"notifications.payed_order_txt\",\"item_id\":19,\"image_path\":null,\"route\":\"\\/traking_Order_For_Travaler\"}', 'App\\Notifications\\User\\SendOrderPayedNotif', 1, '2024-01-05 11:42:41', '2024-01-05 11:42:30', '2024-01-05 11:42:41'),
('8a4fb027-0484-43d5-8a73-0194fd599991', 'App\\Models\\User', 5, '{\"title\":\"notifications.traveler_payed_order\",\"body\":\"notifications.traveler_payed_order_txt\",\"item_id\":18,\"image_path\":null,\"route\":\"\\/traking_Order\"}', 'App\\Notifications\\User\\SendTravelerPayedOrderNotif', 1, '2024-01-05 11:49:35', '2024-01-05 11:47:11', '2024-01-05 11:49:35'),
('4f8c2406-3c43-4eff-bd1a-fe68443bc675', 'App\\Models\\User', 3, '{\"title\":\"notifications.accepted_your_trip\",\"body\":\"notifications.accepted_your_trip_txt\",\"item_id\":26,\"image_path\":\"https:\\/\\/traveler.hananalslaiman.com\\/uploads\\/trips\\/photos\\/thumbs\\/trips_1704456072.jpg\",\"route\":\"\\/trips_View\"}', 'App\\Notifications\\User\\SendTripPublishedNotif', 1, NULL, '2024-01-05 12:08:01', '2024-01-05 12:08:01'),
('043e138f-afb2-42ca-91ca-a698c5ddc1a7', 'App\\Models\\User', 5, '{\"title\":\"notifications.new_order_offer\",\"body\":\"notifications.new_order_offer\",\"item_id\":20,\"image_path\":\"https:\\/\\/traveler.hananalslaiman.com\\/assets\\/dash\\/img\\/trip.png\",\"route\":\"\\/offers_Order_View\"}', 'App\\Notifications\\User\\SendNewOrderOfferNotif', 1, '2024-01-05 12:09:43', '2024-01-05 12:09:30', '2024-01-05 12:09:43'),
('09a49a9a-0e63-458a-ac4c-46947331df9d', 'App\\Models\\User', 5, '{\"title\":\"notifications.accepted_your_offer\",\"body\":\"notifications.accepted_your_offer_txt\",\"item_id\":26,\"image_path\":null,\"route\":null}', 'App\\Notifications\\User\\SendOrderOfferAcceptedNotif', 1, '2024-03-17 18:00:47', '2024-01-05 12:09:59', '2024-03-17 18:00:47'),
('fd30d53c-561a-4da2-871a-d1810364069d', 'App\\Models\\User', 3, '{\"title\":\"notifications.payed_order\",\"body\":\"notifications.payed_order_txt\",\"item_id\":20,\"image_path\":null,\"route\":\"\\/traking_Order_For_Travaler\"}', 'App\\Notifications\\User\\SendOrderPayedNotif', 1, NULL, '2024-01-05 12:10:09', '2024-01-05 12:10:09'),
('cb1326bc-2785-443a-b533-64d4f0071ba0', 'App\\Models\\User', 5, '{\"title\":\"notifications.traveler_payed_order\",\"body\":\"notifications.traveler_payed_order_txt\",\"item_id\":20,\"image_path\":null,\"route\":\"\\/traking_Order\"}', 'App\\Notifications\\User\\SendTravelerPayedOrderNotif', 1, '2024-03-17 18:00:44', '2024-01-05 12:10:56', '2024-03-17 18:00:44'),
('9474e8f8-432f-4e81-9e88-1b0888ff9627', 'App\\Models\\User', 5, '{\"title\":\"notifications.picked_your_order\",\"body\":\"notifications.picked_your_order_txt\",\"item_id\":20,\"image_path\":null,\"route\":\"\\/traking_Order_For_Travaler\"}', 'App\\Notifications\\User\\SendOrderPickedUpNotif', 1, '2024-03-17 18:00:41', '2024-01-05 12:11:12', '2024-03-17 18:00:41'),
('43b4d2e1-1914-4850-bd31-e54855f3f295', 'App\\Models\\User', 5, '{\"title\":\"notifications.new_trip_request\",\"body\":\"notifications.new_trip_request_txt\",\"item_id\":25,\"image_path\":null,\"route\":\"\\/trip-offers\"}', 'App\\Notifications\\User\\SendNewTripRequestNotif', 1, '2024-01-07 08:48:42', '2024-01-07 08:47:28', '2024-01-07 08:48:42'),
('904e6810-1bc7-48ad-88e8-4ca18c33fa36', 'App\\Models\\User', 3, '{\"title\":\"notifications.accepted_your_request\",\"body\":\"notifications.accepted_your_request_txt\",\"item_id\":19,\"image_path\":null,\"route\":\"\\/offers_Order_View\"}', 'App\\Notifications\\User\\SendTripRequestAcceptedNotif', 1, NULL, '2024-01-07 08:49:04', '2024-01-07 08:49:04'),
('fcd26ce9-74f8-4edd-8692-7c83e15f0369', 'App\\Models\\User', 5, '{\"title\":\"notifications.new_order_offer\",\"body\":\"notifications.new_order_offer\",\"item_id\":41,\"image_path\":\"https:\\/\\/traveler.hananalslaiman.com\\/assets\\/dash\\/img\\/trip.png\",\"route\":\"\\/offers_Order_View\"}', 'App\\Notifications\\User\\SendNewOrderOfferNotif', 1, '2024-03-03 10:12:52', '2024-03-03 10:12:12', '2024-03-03 10:12:52'),
('54dc7b5c-86b5-4ecb-943a-0e50627c6890', 'App\\Models\\User', 5, '{\"title\":\"notifications.accepted_your_offer\",\"body\":\"notifications.accepted_your_offer_txt\",\"item_id\":27,\"image_path\":null,\"route\":null}', 'App\\Notifications\\User\\SendOrderOfferAcceptedNotif', 1, '2024-03-17 18:00:11', '2024-03-03 10:14:01', '2024-03-17 18:00:11'),
('68639351-1b8b-40d9-9810-356b5e499f17', 'App\\Models\\User', 12, '{\"title\":\"notifications.accepted_your_trip\",\"body\":\"notifications.accepted_your_trip_txt\",\"item_id\":29,\"image_path\":\"https:\\/\\/traveler.hananalslaiman.com\\/uploads\\/trips\\/photos\\/thumbs\\/trips_1713815094.jpg\",\"route\":\"\\/trips_View\"}', 'App\\Notifications\\User\\SendTripPublishedNotif', 1, NULL, '2024-04-22 19:50:54', '2024-04-22 19:50:54'),
('65e8fcfc-7ea1-40a0-8222-079afe6e15e8', 'App\\Models\\User', 12, '{\"title\":\"notifications.new_trip_request\",\"body\":\"notifications.new_trip_request_txt\",\"item_id\":29,\"image_path\":null,\"route\":\"\\/trip-offers\"}', 'App\\Notifications\\User\\SendNewTripRequestNotif', 1, NULL, '2024-04-22 19:51:21', '2024-04-22 19:51:21'),
('9de0adc3-4bcf-44c9-bb0a-35b99af4ae85', 'App\\Models\\User', 11, '{\"title\":\"notifications.accepted_your_request\",\"body\":\"notifications.accepted_your_request_txt\",\"item_id\":46,\"image_path\":null,\"route\":\"\\/offers_Order_View\"}', 'App\\Notifications\\User\\SendTripRequestAcceptedNotif', 1, '2024-04-23 14:35:00', '2024-04-22 19:52:11', '2024-04-23 14:35:00'),
('c0fee8bd-e1c8-4d96-ad19-dac191544060', 'App\\Models\\User', 12, '{\"title\":\"notifications.payed_order\",\"body\":\"notifications.payed_order_txt\",\"item_id\":46,\"image_path\":null,\"route\":\"\\/traking_Order_For_Travaler\"}', 'App\\Notifications\\User\\SendOrderPayedNotif', 1, NULL, '2024-04-22 20:02:53', '2024-04-22 20:02:53'),
('8f555189-afe2-42b6-98fd-cf5b579bb09f', 'App\\Models\\User', 11, '{\"title\":\"notifications.traveler_payed_order\",\"body\":\"notifications.traveler_payed_order_txt\",\"item_id\":46,\"image_path\":null,\"route\":\"\\/traking_Order\"}', 'App\\Notifications\\User\\SendTravelerPayedOrderNotif', 1, '2024-04-23 14:35:16', '2024-04-22 20:06:28', '2024-04-23 14:35:16'),
('ac0b2e6e-0243-4920-8ab4-457d428b85e5', 'App\\Models\\User', 11, '{\"title\":\"notifications.picked_your_order\",\"body\":\"notifications.picked_your_order_txt\",\"item_id\":46,\"image_path\":null,\"route\":\"\\/traking_Order_For_Travaler\"}', 'App\\Notifications\\User\\SendOrderPickedUpNotif', 1, NULL, '2024-04-22 20:06:45', '2024-04-22 20:06:45'),
('c4f20dc3-4669-43b0-ab52-5fd8080b06ca', 'App\\Models\\User', 4, '{\"title\":\"notifications.accepted_your_trip\",\"body\":\"notifications.accepted_your_trip_txt\",\"item_id\":30,\"image_path\":\"https:\\/\\/traveler.hananalslaiman.com\\/uploads\\/trips\\/photos\\/thumbs\\/trips_1713881814.jpg\",\"route\":\"\\/trips_View\"}', 'App\\Notifications\\User\\SendTripPublishedNotif', 1, NULL, '2024-04-23 14:20:10', '2024-04-23 14:20:10'),
('d0b5645a-ef77-4f4e-829c-b890448291ee', 'App\\Models\\User', 4, '{\"title\":\"notifications.new_trip_request\",\"body\":\"notifications.new_trip_request_txt\",\"item_id\":30,\"image_path\":null,\"route\":\"\\/trip-offers\"}', 'App\\Notifications\\User\\SendNewTripRequestNotif', 1, NULL, '2024-04-23 14:22:50', '2024-04-23 14:22:50'),
('ffbc3e3f-998a-43d0-aea6-41ecb54e0f5b', 'App\\Models\\User', 11, '{\"title\":\"notifications.accepted_your_request\",\"body\":\"notifications.accepted_your_request_txt\",\"item_id\":47,\"image_path\":null,\"route\":\"\\/offers_Order_View\"}', 'App\\Notifications\\User\\SendTripRequestAcceptedNotif', 1, '2024-04-23 14:35:14', '2024-04-23 14:23:58', '2024-04-23 14:35:14'),
('e26314bd-2c4a-4b70-8c5b-fec74f60d0db', 'App\\Models\\User', 4, '{\"title\":\"notifications.payed_order\",\"body\":\"notifications.payed_order_txt\",\"item_id\":47,\"image_path\":null,\"route\":\"\\/traking_Order_For_Travaler\"}', 'App\\Notifications\\User\\SendOrderPayedNotif', 1, NULL, '2024-04-23 14:29:21', '2024-04-23 14:29:21'),
('52548a89-8b19-4bea-abe0-64c8e28bf71e', 'App\\Models\\User', 11, '{\"title\":\"notifications.traveler_payed_order\",\"body\":\"notifications.traveler_payed_order_txt\",\"item_id\":47,\"image_path\":null,\"route\":\"\\/traking_Order\"}', 'App\\Notifications\\User\\SendTravelerPayedOrderNotif', 1, NULL, '2024-04-23 14:29:45', '2024-04-23 14:29:45'),
('b478ff11-523a-4207-8ece-6c40f6d761b6', 'App\\Models\\User', 11, '{\"title\":\"notifications.picked_your_order\",\"body\":\"notifications.picked_your_order_txt\",\"item_id\":47,\"image_path\":null,\"route\":\"\\/traking_Order_For_Travaler\"}', 'App\\Notifications\\User\\SendOrderPickedUpNotif', 1, '2024-04-23 14:35:04', '2024-04-23 14:30:43', '2024-04-23 14:35:04');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `from_place` varchar(255) DEFAULT NULL,
  `to_place` varchar(255) DEFAULT NULL,
  `from_country` varchar(255) DEFAULT NULL,
  `from_city` varchar(255) DEFAULT NULL,
  `to_country` varchar(255) DEFAULT NULL,
  `to_city` varchar(255) DEFAULT NULL,
  `before_date` date DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `deal_method` int(11) DEFAULT NULL,
  `total_weight` decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `total_price` decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `reward` decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `fees` decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `payment_processing` decimal(10,2) UNSIGNED DEFAULT 0.00,
  `estimated_total` decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `notes` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `from_place`, `to_place`, `from_country`, `from_city`, `to_country`, `to_city`, `before_date`, `name`, `deal_method`, `total_weight`, `total_price`, `reward`, `fees`, `payment_processing`, `estimated_total`, `notes`, `status`, `created_at`, `updated_at`) VALUES
(19, 3, 'Brazil', 'Syria', 'BR', NULL, 'SY', NULL, '2024-01-31', 's22', 1, '1.00', '1400.00', '112.00', '70.00', '75.60', '1657.60', 'ggdudjjd', 1, '2024-01-05 11:38:29', '2024-01-05 11:38:29'),
(20, 5, 'Syria', 'United Arab Emirates', 'SY', NULL, 'AE', NULL, '2024-01-17', 'toyes', 1, '1.00', '100.00', '25.30', '5.00', '6.27', '136.57', 'ñgryxdtg', 4, '2024-01-05 12:05:37', '2024-01-05 12:05:37'),
(21, 3, 'Syria', 'United Arab Emirates', 'SY', NULL, 'AE', NULL, '2024-01-15', 'ggg', 2, '27.00', '70.00', '49.23', '19.50', '0.00', '480.69', 'يجب جلب كل الاغراض', 1, '2024-01-05 13:59:40', '2024-01-05 13:59:40'),
(22, 3, 'Andorra', 'Afghanistan', 'AD', NULL, 'AF', NULL, '2024-01-23', 'تقننق', 2, '5.00', '400.00', '97.30', '30.00', '0.00', '762.17', 'تبننقنق', 1, '2024-01-05 14:02:54', '2024-01-05 14:02:54'),
(23, 3, 'United Arab Emirates', 'United Arab Emirates', 'AE', NULL, 'AE', NULL, '2024-01-09', 'عننبزنث', 2, '5.00', '400.00', '61.00', '25.00', '0.00', '614.05', 'مبممق', 1, '2024-01-05 15:27:23', '2024-01-05 15:27:23'),
(24, 3, 'Afghanistan', 'United Arab Emirates', 'AF', NULL, 'AE', NULL, '2024-01-16', 'زلخقزى', 1, '2.00', '200.00', '35.70', '10.00', '11.79', '257.49', 'مويرمق', 1, '2024-01-05 15:35:08', '2024-01-05 15:35:08'),
(25, 3, 'Afghanistan', 'United Arab Emirates', 'AF', NULL, 'AE', NULL, '2024-01-23', 'تتووظ', 1, '4.00', '60.00', '51.82', '13.00', '15.59', '340.41', 'زيززيزي', 1, '2024-01-05 15:43:59', '2024-01-05 15:43:59'),
(26, 3, 'United Arab Emirates', 'Afghanistan', 'AE', NULL, 'AF', NULL, '2024-01-23', 'خقممب', 1, '8.00', '40.00', '41.86', '12.00', '14.09', '307.95', 'نبننق', 1, '2024-01-05 16:09:59', '2024-01-05 16:09:59'),
(27, 5, 'United Arab Emirates', 'United Arab Emirates', 'AE', NULL, 'AE', NULL, '2024-04-28', 'ءؤر', 1, '10.00', '24.00', '10.00', '10.00', NULL, '10.00', '2023-04-28', 1, '2024-01-05 17:28:48', '2024-01-05 17:28:48'),
(28, 5, 'United Arab Emirates', 'United Arab Emirates', 'AE', NULL, 'AE', NULL, '2024-04-28', 'ءؤر', 1, '20.00', '24.00', '10.00', '10.00', NULL, '10.00', '2023-04-28', 1, '2024-01-05 17:29:37', '2024-01-05 17:29:37'),
(29, 5, 'United Arab Emirates', 'United Arab Emirates', 'AE', NULL, 'AE', NULL, '2024-04-28', 'ءؤر', 1, '20.00', '24.00', '10.00', '10.00', NULL, '10.00', '2023-04-28', 1, '2024-01-05 17:34:44', '2024-01-05 17:34:44'),
(30, 5, 'United Arab Emirates', 'United Arab Emirates', 'AE', NULL, 'AE', NULL, '2024-04-28', 'ءؤر', 1, '20.00', '24.00', '10.00', '10.00', NULL, '10.00', '2023-04-28', 1, '2024-01-05 17:35:13', '2024-01-05 17:35:13'),
(31, 5, 'United Arab Emirates', 'United Arab Emirates', 'AE', NULL, 'AE', NULL, '2024-04-28', 'ءؤر', 1, '20.00', '24.00', '10.00', '10.00', NULL, '10.00', '2023-04-28', 1, '2024-01-05 17:35:42', '2024-01-05 17:35:42'),
(32, 5, 'United Arab Emirates', 'United Arab Emirates', 'AE', NULL, 'AE', NULL, '2024-04-28', 'ءؤر', 1, '20.00', '24.00', '10.00', '10.00', NULL, '10.00', '2023-04-28', 1, '2024-01-05 17:36:17', '2024-01-05 17:36:17'),
(33, 5, 'United Arab Emirates', 'United Arab Emirates', 'AE', NULL, 'AE', NULL, '2024-04-28', 'ءؤر', 1, '20.00', '24.00', '10.00', '10.00', NULL, '10.00', '2023-04-28', 1, '2024-01-05 17:36:33', '2024-01-05 17:36:33'),
(34, 5, 'United Arab Emirates', 'United Arab Emirates', 'AE', NULL, 'AE', NULL, '2024-04-28', 'ءؤر', 1, '20.00', '24.00', '10.00', '10.00', NULL, '10.00', '2023-04-28', 1, '2024-01-05 17:38:44', '2024-01-05 17:38:44'),
(35, 5, 'United Arab Emirates', 'United Arab Emirates', 'AE', NULL, 'AE', NULL, '2024-04-28', 'ءؤر', 1, '20.00', '24.00', '10.00', '10.00', NULL, '10.00', '2023-04-28', 1, '2024-01-05 17:43:21', '2024-01-05 17:43:21'),
(36, 5, 'United Arab Emirates', 'United Arab Emirates', 'AE', NULL, 'AE', NULL, '2024-04-28', 'ءؤر', 1, '20.00', '24.00', '10.00', '10.00', NULL, '10.00', '2023-04-28', 1, '2024-01-05 17:52:20', '2024-01-05 17:52:20'),
(37, 3, 'Andorra', 'United Arab Emirates', 'AD', NULL, 'AE', NULL, '2024-01-31', 'جعفرررررر', 2, '4.00', '20.00', '31.46', '6.00', '0.00', '165.03', 'وبنبنزب', 1, '2024-01-05 18:06:53', '2024-01-05 18:06:53'),
(38, 3, 'Afghanistan', 'United Arab Emirates', 'AF', NULL, 'AE', NULL, '2024-01-23', 'نةعلع', 1, '5.00', '30.00', '15.40', '2.50', '3.27', '71.17', 'لهلعلع', 1, '2024-01-05 18:16:36', '2024-01-05 18:16:36'),
(39, 3, 'Afghanistan', 'Afghanistan', 'AF', NULL, 'AF', NULL, '2024-01-31', 'bdbx', 1, '10.00', '6000.00', '103.20', '300.00', '305.16', '6708.36', 'jdjdn', 1, '2024-01-07 08:54:21', '2024-01-07 08:54:21'),
(40, 3, 'Andorra', 'United Arab Emirates', 'AD', NULL, 'AE', NULL, '2024-02-07', 'kdkkd', 1, '4.00', '240.00', '26.66', '12.00', '13.33', '292.00', 'jdjkd', 1, '2024-02-02 21:09:23', '2024-02-02 21:09:23'),
(41, 5, 'Homs', 'United Arab Emirates', 'SY', NULL, 'AE', NULL, '2024-06-20', 'ghgt', 1, '2.00', '100.00', '25.30', '5.00', '6.27', '136.57', 'rhrhehe', 1, '2024-03-03 09:56:59', '2024-03-03 09:56:59'),
(42, 3, 'United Arab Emirates', 'American Samoa', 'AE', NULL, 'AS', NULL, '2024-03-08', 'laptop', 1, '1.00', '1600.00', '123.20', '80.00', '86.16', '1889.36', 'يجب التسليم مع الصندوق', 1, '2024-03-06 21:59:04', '2024-03-06 21:59:04'),
(43, 5, 'Germany', 'Hamah', 'DE', NULL, 'SY', NULL, '2024-08-11', 'suit', 2, '6.00', '900.00', '48.81', '45.00', '0.00', '1041.25', 'yellow', 1, '2024-03-17 09:17:07', '2024-03-17 09:17:07'),
(44, 5, 'Australia', 'Homs', 'AU', NULL, 'SY', NULL, '2024-05-05', 'dress', 1, '10.00', '400.00', '123.20', '40.00', '46.16', '1009.36', 'pink', 1, '2024-03-17 09:27:30', '2024-03-17 09:27:30'),
(45, 5, 'Armenia', 'Europe', 'AM', NULL, 'EU', NULL, '2024-03-22', 'glasses', 1, '1.00', '66.00', '10.16', '3.30', '3.81', '83.27', 'black &white', 1, '2024-03-17 20:03:10', '2024-03-17 20:03:10'),
(46, 11, 'Syria', 'United Arab Emirates', 'SY', NULL, 'AE', NULL, '2024-05-31', 'labtop', 1, '1.00', '1200.00', '103.20', '60.00', '65.16', '1428.36', 'يرجى الاهتمام بنظافة الاسنان', 4, '2024-04-22 19:37:57', '2024-04-22 20:07:36'),
(47, 11, 'United Arab Emirates', 'Syria', 'AE', NULL, 'SY', NULL, '2024-05-31', 'mobile s23', 1, '1.00', '2200.00', '169.40', '110.00', '118.47', '2597.87', 'فرشاية سنان', 4, '2024-04-23 14:14:02', '2024-04-23 14:31:34');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `price` double NOT NULL DEFAULT 0,
  `weight` double NOT NULL DEFAULT 0,
  `unit` int(10) UNSIGNED NOT NULL DEFAULT 2,
  `with_box` int(11) NOT NULL DEFAULT 0,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `category_id`, `link`, `name`, `quantity`, `price`, `weight`, `unit`, `with_box`, `photo`, `created_at`, `updated_at`) VALUES
(18, 19, 11, 'https://www.amazon.com', NULL, 1, 1400, 1, 1, 1, NULL, '2024-01-05 11:38:29', '2024-01-05 11:38:29'),
(19, 20, 11, 'https://www.xrayteamm.com', NULL, 1, 100, 1, 1, 0, NULL, '2024-01-05 12:05:37', '2024-01-05 12:05:37'),
(20, 21, 12, 'https://www.amazon.com', NULL, 1, 200, 2, 1, 0, NULL, '2024-01-05 13:59:40', '2024-01-05 13:59:40'),
(21, 21, 12, 'https://www.goodfood.com', NULL, 4, 30, 1, 1, 0, NULL, '2024-01-05 13:59:40', '2024-01-05 13:59:40'),
(22, 22, 8, 'https://www.amazon.com', NULL, 1, 200, 2, 1, 0, NULL, '2024-01-05 14:02:54', '2024-01-05 14:02:54'),
(23, 22, 5, 'https://www.jdbej.com', NULL, 1, 400, 3, 1, 0, NULL, '2024-01-05 14:02:54', '2024-01-05 14:02:54'),
(24, 23, 8, 'https://www.amazon.com', NULL, 1, 100, 1, 1, 0, NULL, '2024-01-05 15:27:23', '2024-01-05 15:27:23'),
(25, 23, 10, 'https://www.amazon.com', NULL, 2, 200, 2, 1, 0, NULL, '2024-01-05 15:27:23', '2024-01-05 15:27:23'),
(26, 24, 8, 'https://www.amaxon.com', NULL, 1, 200, 2, 1, 0, NULL, '2024-01-05 15:35:08', '2024-01-05 15:35:08'),
(27, 25, 8, 'https://www.amazon.com', NULL, 1, 200, 2, 1, 0, NULL, '2024-01-05 15:43:59', '2024-01-05 15:43:59'),
(28, 25, 8, 'https://www.amazon.com', NULL, 1, 60, 2, 1, 0, NULL, '2024-01-05 15:43:59', '2024-01-05 15:43:59'),
(29, 26, 9, 'https://www.amzon.com', NULL, 1, 200, 2, 1, 0, NULL, '2024-01-05 16:09:59', '2024-01-05 16:09:59'),
(30, 26, 9, 'https://www.amazon.com', NULL, 2, 20, 3, 1, 1, NULL, '2024-01-05 16:10:00', '2024-01-05 16:10:00'),
(31, 27, 2, 'http://www.hananalslaiman.com', NULL, 2, 12, 5, 1, 1, NULL, '2024-01-05 17:28:48', '2024-01-05 17:28:48'),
(32, 28, 2, 'http://www.hananalslaiman.com', NULL, 2, 12, 5, 1, 1, NULL, '2024-01-05 17:29:37', '2024-01-05 17:29:37'),
(33, 28, 2, 'http://www.hananalslaiman.com', NULL, 2, 12, 5, 1, 1, NULL, '2024-01-05 17:29:37', '2024-01-05 17:29:37'),
(34, 29, 2, 'http://www.hananalslaiman.com', NULL, 2, 12, 5, 1, 1, NULL, '2024-01-05 17:34:44', '2024-01-05 17:34:44'),
(35, 29, 2, 'http://www.hananalslaiman.com', NULL, 2, 12, 5, 1, 1, NULL, '2024-01-05 17:34:44', '2024-01-05 17:34:44'),
(36, 30, 2, 'http://www.hananalslaiman.com', NULL, 2, 12, 5, 1, 1, NULL, '2024-01-05 17:35:13', '2024-01-05 17:35:13'),
(37, 30, 2, 'http://www.hananalslaiman.com', NULL, 2, 12, 5, 1, 1, NULL, '2024-01-05 17:35:13', '2024-01-05 17:35:13'),
(38, 31, 2, 'http://www.hananalslaiman.com', NULL, 2, 12, 5, 1, 1, NULL, '2024-01-05 17:35:42', '2024-01-05 17:35:42'),
(39, 31, 2, 'http://www.hananalslaiman.com', NULL, 2, 12, 5, 1, 1, NULL, '2024-01-05 17:35:43', '2024-01-05 17:35:43'),
(40, 32, 2, 'http://www.hananalslaiman.com', NULL, 2, 12, 5, 1, 1, NULL, '2024-01-05 17:36:17', '2024-01-05 17:36:17'),
(41, 33, 2, 'http://www.hananalslaiman.com', NULL, 2, 12, 5, 1, 1, NULL, '2024-01-05 17:36:33', '2024-01-05 17:36:33'),
(42, 34, 2, 'http://www.hananalslaiman.com', NULL, 2, 12, 5, 1, 1, NULL, '2024-01-05 17:38:44', '2024-01-05 17:38:44'),
(43, 34, 2, 'http://www.hananalslaiman.com', NULL, 2, 12, 5, 1, 1, NULL, '2024-01-05 17:38:44', '2024-01-05 17:38:44'),
(44, 35, 2, 'http://www.hananalslaiman.com', NULL, 2, 12, 5, 1, 1, NULL, '2024-01-05 17:43:21', '2024-01-05 17:43:21'),
(45, 35, 2, 'http://www.hananalslaiman.com', NULL, 2, 12, 5, 1, 1, NULL, '2024-01-05 17:43:21', '2024-01-05 17:43:21'),
(46, 36, 2, 'http://www.hananalslaiman.com', NULL, 2, 12, 5, 1, 1, NULL, '2024-01-05 17:52:20', '2024-01-05 17:52:20'),
(47, 36, 2, 'http://www.hananalslaiman.com', NULL, 2, 12, 5, 1, 1, NULL, '2024-01-05 17:52:20', '2024-01-05 17:52:20'),
(48, 37, 9, 'https://www.amazon.com', NULL, 1, 100, 2, 1, 0, NULL, '2024-01-05 18:06:53', '2024-01-05 18:06:53'),
(49, 37, 9, 'https://www.amazon.com', NULL, 1, 20, 2, 1, 0, NULL, '2024-01-05 18:06:53', '2024-01-05 18:06:53'),
(50, 38, 9, 'http://www.amazon.con', NULL, 1, 20, 2, 1, 1, NULL, '2024-01-05 18:16:36', '2024-01-05 18:16:36'),
(51, 38, 9, 'https://www.amazon.com', NULL, 1, 30, 3, 1, 1, NULL, '2024-01-05 18:16:36', '2024-01-05 18:16:36'),
(52, 39, 2, 'https://www.amazon.com', NULL, 5, 1200, 2, 1, 1, NULL, '2024-01-07 08:54:21', '2024-01-07 08:54:21'),
(53, 40, 3, 'https://www.amazon.com', NULL, 2, 120, 2, 1, 1, NULL, '2024-02-02 21:09:23', '2024-02-02 21:09:23'),
(54, 41, 7, 'https://www.amazon.com', NULL, 1, 100, 2, 1, 0, NULL, '2024-03-03 09:56:59', '2024-03-03 09:56:59'),
(55, 42, 13, 'https://www.amazon.com', NULL, 1, 1600, 1, 1, 1, NULL, '2024-03-06 21:59:04', '2024-03-06 21:59:04'),
(56, 43, 9, 'https://amazonmakeup.com', NULL, 3, 300, 2, 1, 0, NULL, '2024-03-17 09:17:07', '2024-03-17 09:17:07'),
(57, 44, 8, 'https://amazon.com', NULL, 1, 400, 5, 1, 1, NULL, '2024-03-17 09:27:30', '2024-03-17 09:27:30'),
(58, 44, 9, 'https://amazon.com', NULL, 1, 400, 5, 1, 1, NULL, '2024-03-17 09:27:30', '2024-03-17 09:27:30'),
(59, 45, 8, 'https://shein.com', NULL, 2, 33, 0.5, 1, 1, NULL, '2024-03-17 20:03:10', '2024-03-17 20:03:10'),
(60, 46, 13, 'https://www.amazon.com', NULL, 1, 1200, 1, 1, 1, NULL, '2024-04-22 19:37:57', '2024-04-22 19:37:57'),
(61, 47, 13, 'https://www.facebook.com', NULL, 1, 2200, 1, 1, 1, NULL, '2024-04-23 14:14:02', '2024-04-23 14:14:02');

-- --------------------------------------------------------

--
-- Table structure for table `order_item_images`
--

CREATE TABLE `order_item_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_item_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_item_images`
--

INSERT INTO `order_item_images` (`id`, `order_item_id`, `image`, `created_at`, `updated_at`) VALUES
(19, 18, 'orders_1_1704454709.jpg', '2024-01-05 11:38:29', '2024-01-05 11:38:29'),
(20, 19, 'orders_1_1704456337.jpg', '2024-01-05 12:05:37', '2024-01-05 12:05:37'),
(21, 20, 'orders_1_1704463180.jpg', '2024-01-05 13:59:40', '2024-01-05 13:59:40'),
(22, 22, 'orders_1_1704463374.jpg', '2024-01-05 14:02:54', '2024-01-05 14:02:54'),
(23, 24, 'orders_1_1704468443.jpg', '2024-01-05 15:27:23', '2024-01-05 15:27:23'),
(24, 26, 'orders_1_1704468908.jpg', '2024-01-05 15:35:08', '2024-01-05 15:35:08'),
(25, 27, 'orders_1_1704469439.jpg', '2024-01-05 15:43:59', '2024-01-05 15:43:59'),
(26, 29, 'orders_1_1704470999.jpg', '2024-01-05 16:10:00', '2024-01-05 16:10:00'),
(27, 31, 'orders_1_1704475728.png', '2024-01-05 17:28:48', '2024-01-05 17:28:48'),
(28, 31, 'orders_2_1704475728.jpg', '2024-01-05 17:28:48', '2024-01-05 17:28:48'),
(29, 32, 'orders_1_1704475777.png', '2024-01-05 17:29:37', '2024-01-05 17:29:37'),
(30, 32, 'orders_2_1704475777.jpg', '2024-01-05 17:29:37', '2024-01-05 17:29:37'),
(31, 34, 'orders_1_1704476084.png', '2024-01-05 17:34:44', '2024-01-05 17:34:44'),
(32, 34, 'orders_2_1704476084.jpg', '2024-01-05 17:34:44', '2024-01-05 17:34:44'),
(33, 36, 'orders_1_1704476113.png', '2024-01-05 17:35:13', '2024-01-05 17:35:13'),
(34, 36, 'orders_2_1704476113.jpg', '2024-01-05 17:35:13', '2024-01-05 17:35:13'),
(35, 38, 'orders_1_1704476142.png', '2024-01-05 17:35:42', '2024-01-05 17:35:42'),
(36, 38, 'orders_2_1704476142.jpg', '2024-01-05 17:35:43', '2024-01-05 17:35:43'),
(37, 42, 'orders_1_1704476324.png', '2024-01-05 17:38:44', '2024-01-05 17:38:44'),
(38, 42, 'orders_2_1704476324.jpg', '2024-01-05 17:38:44', '2024-01-05 17:38:44'),
(39, 44, 'orders_1_1704476601.png', '2024-01-05 17:43:21', '2024-01-05 17:43:21'),
(40, 44, 'orders_2_1704476601.jpg', '2024-01-05 17:43:21', '2024-01-05 17:43:21'),
(41, 45, 'orders_1_1704476601.jpeg', '2024-01-05 17:43:21', '2024-01-05 17:43:21'),
(42, 46, 'orders_1_1704477140.jpeg', '2024-01-05 17:52:20', '2024-01-05 17:52:20'),
(43, 46, 'orders_2_1704477140.jpg', '2024-01-05 17:52:20', '2024-01-05 17:52:20'),
(44, 48, 'orders_1_1704478013.jpg', '2024-01-05 18:06:53', '2024-01-05 18:06:53'),
(45, 49, 'orders_1_1704478013.jpg', '2024-01-05 18:06:53', '2024-01-05 18:06:53'),
(46, 50, 'orders_50_1_1704478596.jpg', '2024-01-05 18:16:36', '2024-01-05 18:16:36'),
(47, 51, 'orders_51_1_1704478596.jpg', '2024-01-05 18:16:36', '2024-01-05 18:16:36'),
(48, 52, 'orders_52_1_1704617661.jpg', '2024-01-07 08:54:21', '2024-01-07 08:54:21'),
(49, 53, 'orders_53_1_1706908163.jpg', '2024-02-02 21:09:23', '2024-02-02 21:09:23'),
(50, 54, 'orders_54_1_1709459819.jpg', '2024-03-03 09:56:59', '2024-03-03 09:56:59'),
(51, 55, 'orders_55_1_1709762344.jpg', '2024-03-06 21:59:04', '2024-03-06 21:59:04'),
(52, 56, 'orders_56_1_1710667027.jpg', '2024-03-17 09:17:07', '2024-03-17 09:17:07'),
(53, 57, 'orders_57_1_1710667650.jpg', '2024-03-17 09:27:30', '2024-03-17 09:27:30'),
(54, 58, 'orders_58_1_1710667650.jpg', '2024-03-17 09:27:30', '2024-03-17 09:27:30'),
(55, 59, 'orders_59_1_1710705790.jpg', '2024-03-17 20:03:10', '2024-03-17 20:03:10'),
(56, 60, 'orders_60_1_1713814677.jpg', '2024-04-22 19:37:57', '2024-04-22 19:37:57'),
(57, 60, 'orders_60_2_1713814677.jpg', '2024-04-22 19:37:57', '2024-04-22 19:37:57'),
(58, 60, 'orders_60_3_1713814677.jpg', '2024-04-22 19:37:57', '2024-04-22 19:37:57'),
(59, 61, 'orders_61_1_1713881642.jpg', '2024-04-23 14:14:02', '2024-04-23 14:14:02');

-- --------------------------------------------------------

--
-- Table structure for table `order_offers`
--

CREATE TABLE `order_offers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `trip_id` bigint(20) UNSIGNED NOT NULL,
  `numeric` decimal(10,2) DEFAULT NULL,
  `reward` decimal(10,2) NOT NULL DEFAULT 0.00,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `message` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_offers`
--

INSERT INTO `order_offers` (`id`, `order_id`, `trip_id`, `numeric`, `reward`, `amount`, `message`, `status`, `created_at`, `updated_at`) VALUES
(10, 19, 25, NULL, '112.00', '0.00', 'messs', 2, '2024-01-05 11:41:45', '2024-01-05 11:42:30'),
(11, 20, 26, NULL, '25.30', '0.00', 'كيفك يا حبيب', 2, '2024-01-05 12:09:30', '2024-01-05 12:10:09'),
(12, 41, 27, NULL, '25.30', '0.00', 'تىاةاراةغؤل', 2, '2024-03-03 10:12:12', '2024-03-03 10:14:01');

-- --------------------------------------------------------

--
-- Table structure for table `otps`
--

CREATE TABLE `otps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `validity` int(11) NOT NULL,
  `expired` tinyint(1) NOT NULL DEFAULT 0,
  `no_times_generated` int(11) NOT NULL DEFAULT 0,
  `no_times_attempted` int(11) NOT NULL DEFAULT 0,
  `generated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `otps`
--

INSERT INTO `otps` (`id`, `identifier`, `token`, `validity`, `expired`, `no_times_generated`, `no_times_attempted`, `generated_at`, `created_at`, `updated_at`) VALUES
(17, 'hananalsleman100@gmail.com', '3141', 10, 0, 1, 1, '2024-04-22 19:39:39', '2024-04-22 19:38:21', '2024-04-22 19:39:39');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `amount` double(8,2) UNSIGNED NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 1,
  `trans_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review_ratings`
--

CREATE TABLE `review_ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `deal_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rated_id` bigint(20) UNSIGNED NOT NULL,
  `comment` longtext DEFAULT NULL,
  `star_rating` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `review_ratings`
--

INSERT INTO `review_ratings` (`id`, `deal_id`, `user_id`, `rated_id`, `comment`, `star_rating`, `status`, `created_at`, `updated_at`) VALUES
(14, 18, 5, 3, 'good 👍', 4, 1, '2024-01-05 13:20:38', '2024-01-05 13:20:38'),
(15, 18, 3, 5, 'حزين وواعي', 4, 1, '2024-01-05 13:35:15', '2024-01-05 13:35:15'),
(16, 19, 11, 12, 'كويس', 5, 1, '2024-04-22 20:07:49', '2024-04-22 20:07:49'),
(17, 19, 12, 11, 'good', 4, 1, '2024-04-22 20:08:47', '2024-04-22 20:08:47'),
(18, 20, 11, 4, 'تأخرت', 2, 1, '2024-04-23 14:31:47', '2024-04-23 14:31:47'),
(19, 20, 4, 11, 'hchg', 5, 1, '2024-04-23 14:33:29', '2024-04-23 14:33:29');

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

CREATE TABLE `trips` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `from_place` varchar(255) DEFAULT NULL,
  `to_place` varchar(255) DEFAULT NULL,
  `from_country` varchar(255) DEFAULT NULL,
  `from_city` varchar(255) DEFAULT NULL,
  `to_country` varchar(255) DEFAULT NULL,
  `to_city` varchar(255) DEFAULT NULL,
  `available_weight` double UNSIGNED NOT NULL DEFAULT 0,
  `deal_method` int(11) DEFAULT NULL,
  `departure_date` date DEFAULT NULL,
  `departure_time` time DEFAULT NULL,
  `arrive_date` date DEFAULT NULL,
  `arrive_time` time DEFAULT NULL,
  `delivery_date_from` date DEFAULT NULL,
  `delivery_date_to` date DEFAULT NULL,
  `pickup_place` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `booking_airline` varchar(255) DEFAULT NULL,
  `booking_reference` varchar(255) DEFAULT NULL,
  `booking_first_name` varchar(255) DEFAULT NULL,
  `booking_last_name` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `replied_at` timestamp NULL DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trips`
--

INSERT INTO `trips` (`id`, `user_id`, `from_place`, `to_place`, `from_country`, `from_city`, `to_country`, `to_city`, `available_weight`, `deal_method`, `departure_date`, `departure_time`, `arrive_date`, `arrive_time`, `delivery_date_from`, `delivery_date_to`, `pickup_place`, `notes`, `booking_airline`, `booking_reference`, `booking_first_name`, `booking_last_name`, `photo`, `replied_at`, `status`, `created_at`, `updated_at`) VALUES
(24, 3, 'United Arab Emirates', 'Syria', 'AE', NULL, 'SY', NULL, 2, 1, '2024-01-10', '05:03:00', '2024-01-10', '04:04:00', '2024-01-12', '2024-01-15', 'دبي', 'أجهزة الموبايل تنقل مفتوحة', 'ALPHA AIR TRANSPORT', 'معلومات الحجز', 'جعفر', 'الخلوف', 'trips_1704453408.jpg', '2024-01-05 11:17:55', 2, '2024-01-05 11:16:48', '2024-01-05 11:17:55'),
(25, 5, 'Brazil', 'Syria', 'BR', NULL, 'SY', NULL, 6, 1, '2024-01-11', '04:00:00', '2024-01-11', '17:44:00', '2024-01-11', '2024-01-24', 'Syria Damas', 'no notes', 'ALPHA AIR TRANSPORT', 'ggggggg', 'Hanan', 'Slaiman', 'trips_1704454780.jpg', '2024-01-05 11:40:23', 2, '2024-01-05 11:39:40', '2024-01-05 11:40:23'),
(26, 3, 'Syria', 'United Arab Emirates', 'SY', NULL, 'AE', NULL, 3, 1, '2024-01-10', '02:03:00', '2024-01-10', '05:05:00', '2024-01-17', '2024-01-20', 'vdbd', 'زبظيظزى', 'TRADEWIND AVIATION', 'ndnnd', 'جعفر', 'خلوف', 'trips_1704456072.jpg', '2024-01-05 12:08:01', 2, '2024-01-05 12:01:12', '2024-01-05 12:08:01'),
(27, 3, 'Homs', 'United Arab Emirates', 'SY', NULL, 'AE', NULL, 2, 1, '2024-03-06', '03:06:00', NULL, NULL, '2024-03-08', '2024-03-12', 'uguv', 'nvych', 'TRADEWIND AVIATION', 'b h', 'j h', 'hvh h', NULL, '2024-03-06 13:05:08', 2, '2024-03-03 10:07:47', '2024-03-03 10:07:47'),
(28, 5, 'Homs', 'United Arab Emirates', 'SY', NULL, 'AE', NULL, 3, 2, '2024-04-15', '02:00:00', NULL, NULL, '2024-04-15', '2024-04-20', 's77', 'grgghhs', 'WIND ROSE AVIATION', 'eygdhjjgg', 'sally', 'raghad', NULL, NULL, 1, '2024-03-17 09:06:40', '2024-03-17 09:06:40'),
(29, 12, 'Syria', 'United Arab Emirates', 'SY', NULL, 'AE', NULL, 10, 1, '2024-04-26', '03:00:00', '2024-04-26', '12:55:00', '2024-04-27', '2024-04-28', 'Dubai', 'no noteees', 'TRADEWIND AVIATION', 'hanan', 'Hanan', 'Slaiman', 'trips_1713815094.jpg', '2024-04-22 19:50:54', 2, '2024-04-22 19:44:54', '2024-04-22 19:50:54'),
(30, 4, 'United Arab Emirates', 'Syria', 'AE', NULL, 'SY', NULL, 4, 1, '2024-04-25', '02:02:00', '2024-04-25', '12:03:00', '2024-04-27', '2024-04-29', 'hvggfg', 'rvrvr', 'AMADEUS 7Y', 'gfgh', 'gdfg', 'bbvv', 'trips_1713881814.jpg', '2024-04-23 14:20:10', 2, '2024-04-23 14:16:54', '2024-04-23 14:20:10');

-- --------------------------------------------------------

--
-- Table structure for table `trip_not_categories`
--

CREATE TABLE `trip_not_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `trip_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trip_not_categories`
--

INSERT INTO `trip_not_categories` (`id`, `trip_id`, `category_id`, `created_at`, `updated_at`) VALUES
(19, 24, 11, NULL, NULL),
(20, 27, 13, NULL, NULL),
(21, 28, 7, NULL, NULL),
(22, 28, 3, NULL, NULL),
(23, 30, 9, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `trip_requests`
--

CREATE TABLE `trip_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `trip_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `target_price` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trip_requests`
--

INSERT INTO `trip_requests` (`id`, `trip_id`, `order_id`, `reason`, `target_price`, `status`, `created_at`, `updated_at`) VALUES
(13, 25, 19, NULL, NULL, 5, '2024-01-05 11:40:46', '2024-01-05 11:42:30'),
(14, 25, 19, NULL, NULL, 2, '2024-01-07 08:47:28', '2024-01-07 08:49:04'),
(15, 29, 46, NULL, NULL, 2, '2024-04-22 19:51:21', '2024-04-22 20:02:53'),
(16, 30, 47, NULL, NULL, 2, '2024-04-23 14:22:50', '2024-04-23 14:29:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `mobile_verified_at` timestamp NULL DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `place` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `gender` tinyint(1) NOT NULL DEFAULT 1,
  `passport_photo` varchar(255) DEFAULT NULL,
  `passport` varchar(255) DEFAULT NULL,
  `id_card` varchar(255) DEFAULT NULL,
  `refer_code` varchar(255) DEFAULT NULL,
  `invitation_code` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `fcm_token` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `mobile`, `mobile_verified_at`, `email`, `email_verified_at`, `is_verified`, `image`, `first_name`, `last_name`, `place`, `country`, `city`, `birthdate`, `gender`, `passport_photo`, `passport`, `id_card`, `refer_code`, `invitation_code`, `status`, `fcm_token`, `remember_token`, `created_at`, `updated_at`) VALUES
(3, NULL, '$2y$10$sC0WwLR3LVVASJcBOs2KA.k21fNwTLaVrKX6Z.sbypwygyFOvmXZ.', '0999605516', '2023-11-13 12:18:16', 'raghad@gmail.com', NULL, 1, 'users_1702127745.jpg', 'Raghad', 'M', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'users_1705506609.jpg', NULL, NULL, 1, NULL, NULL, '2023-11-13 12:17:53', '2023-12-09 13:15:45'),
(4, NULL, '$2y$10$4To1/Tcz326WoMnkPVATEO1J34VlBGihsgJTg3RtdKp0Z.H.L7wcy', '0999786543', '2023-11-14 11:08:31', 'raghadsaade87@gmail.com', NULL, 1, 'users_1699961138.jpg', 'yhyhy', 'hyhyh', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2023-11-14 11:08:08', '2023-11-14 11:25:38'),
(5, NULL, '$2y$10$Acr.tke346Nq5tyWAydVu.5GwptR4w.S2jjnGrZi74BudnYhtaYFq', '0999605866', '2023-12-05 13:13:18', 'sallyalsalman100@gmail.com', NULL, 1, NULL, 'Sally', 'salman', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'users_1705506300.png', NULL, NULL, 1, NULL, NULL, '2023-12-05 13:12:46', '2023-12-05 13:13:18'),
(6, NULL, '$2y$10$z0ZOyDJ2WGhPUbI1WXCW4eZ/DDweFPmOrS4aQlmusOfgAuVQIU6sC', '0994335873', NULL, 'ahmad@gmail.com', NULL, 0, NULL, 'jafara', 'hgjd', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2024-01-30 16:08:13', '2024-01-30 16:08:13'),
(7, NULL, '$2y$10$nYz5uHr61FmMIzkINT/7Nu8rbySNRN5dxuNHP8RNYuXUAU5/rnw1K', '0982312299', NULL, 'sallyalsalman@gmail.com', NULL, 0, NULL, 'raghad', 'saade', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2024-03-17 15:27:34', '2024-03-17 15:27:34'),
(8, NULL, '$2y$10$2ocDbv/AJ5oimOjaHf.eJ.7.YaJaKZl9QtJzQ25MqrDYRHbc0Vy5G', '0940997762', NULL, 'www.raghad2001@gmail.com', NULL, 0, NULL, 'raghad', 'mourrah', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2024-03-17 16:55:04', '2024-03-17 16:55:04'),
(9, NULL, '$2y$10$yOjGnzNqtApqqJFFEztHeuTireOJRSF4UsohWAi1mNZIaBqujyg2W', '0997625420', NULL, 'danialassil2001@gmail.com', NULL, 0, NULL, 'Danial', 'Assil', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2024-03-17 17:31:51', '2024-03-17 17:31:51'),
(10, NULL, '$2y$10$vZ1wSn5gx32BFZLzixtc3.TkoQB.eGO/WQKNXlKPEmSzoNbOFVid2', '0954542075', NULL, 'qasemqaseem29@gmail.com', NULL, 0, NULL, 'eeee', 'sbshs', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2024-03-17 17:38:05', '2024-03-17 17:38:05'),
(11, NULL, '$2y$10$nM8BxRUY1S827vo.Vhz95upUGlt4BmTFRkp.fGFiL0WwSJnbxmL22', '0994335985', NULL, 'jafar.khalouf1996@gmail.com', '2024-04-22 18:58:47', 1, NULL, 'mohamad', 'ali', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2024-04-22 18:42:14', '2024-04-22 18:58:47'),
(12, NULL, '$2y$10$iYp88KiM8YRp8EGMBMDs/uVQnG62SbrbJmigkqWN0bBW5t/rBDina', '0935739102', NULL, 'hananalsleman100@gmail.com', '2024-04-22 19:39:39', 1, NULL, 'Hanan', 'Slaiman', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2024-04-22 19:38:21', '2024-04-22 19:39:39');

-- --------------------------------------------------------

--
-- Table structure for table `user_attachments`
--

CREATE TABLE `user_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `reply_txt` text DEFAULT NULL,
  `replyed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_attachments`
--

INSERT INTO `user_attachments` (`id`, `user_id`, `type`, `file`, `verified_at`, `is_verified`, `reply_txt`, `replyed_at`, `created_at`, `updated_at`) VALUES
(1, 5, 'id', 'users_1705437867.jpg', NULL, 0, NULL, NULL, '2024-01-16 20:44:27', '2024-01-16 20:44:27'),
(2, 5, 'id', 'users_1705504928.jpg', NULL, 0, NULL, NULL, '2024-01-17 15:22:08', '2024-01-17 15:22:08'),
(3, 5, 'passport', NULL, NULL, 0, NULL, NULL, '2024-01-17 15:39:45', '2024-01-17 15:39:45'),
(4, 5, 'passport', 'users_1705506239.png', NULL, 0, NULL, NULL, '2024-01-17 15:43:59', '2024-01-17 15:43:59'),
(5, 5, 'passport', 'users_1705506264.png', NULL, 0, NULL, NULL, '2024-01-17 15:44:24', '2024-01-17 15:44:24'),
(6, 5, 'id', 'users_1705506300.png', NULL, 0, NULL, NULL, '2024-01-17 15:45:00', '2024-01-17 15:45:00'),
(7, 3, 'id', 'users_1705506609.jpg', NULL, 0, NULL, NULL, '2024-01-17 15:50:09', '2024-01-17 15:50:09');

-- --------------------------------------------------------

--
-- Table structure for table `user_fcms`
--

CREATE TABLE `user_fcms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_fcms`
--

INSERT INTO `user_fcms` (`id`, `user_id`, `token`, `created_at`, `updated_at`) VALUES
(29, 5, 'fuuun3cjSxKcF_PpAE3g3Z:APA91bGVVkS34QbBdKjnpVJhUrrjFVitXTTCZsRxtheN1dU-dfD8PGe7ochjy5uPqMqy8EmRRRRTVsJetWzhkiiwXOtcfLpW7x9g2pORkT9AixbdnOeeXM7nt87LtjpaIE-nCsFeW1ox', '2024-01-05 11:02:10', '2024-01-05 11:02:10'),
(30, 3, 'czJGufLfR7uZQAWJ2uMCjw:APA91bECUAhFI5UvHLJzNbhZ7FESys8BcucGkBOGtIza6T9NICz23kmJplk_fyzASq3lC-a8LN5s6TRmsKonpHiCNye2_gGIl8VEcewsxduJRJCpLOV1NJMuW2ktggSxyQO_J0j6zLNp', '2024-01-05 11:02:23', '2024-01-05 11:02:23'),
(31, 5, 'czJGufLfR7uZQAWJ2uMCjw:APA91bECUAhFI5UvHLJzNbhZ7FESys8BcucGkBOGtIza6T9NICz23kmJplk_fyzASq3lC-a8LN5s6TRmsKonpHiCNye2_gGIl8VEcewsxduJRJCpLOV1NJMuW2ktggSxyQO_J0j6zLNp', '2024-01-05 11:32:49', '2024-01-05 11:32:49'),
(32, 3, 'czJGufLfR7uZQAWJ2uMCjw:APA91bECUAhFI5UvHLJzNbhZ7FESys8BcucGkBOGtIza6T9NICz23kmJplk_fyzASq3lC-a8LN5s6TRmsKonpHiCNye2_gGIl8VEcewsxduJRJCpLOV1NJMuW2ktggSxyQO_J0j6zLNp', '2024-01-05 11:36:29', '2024-01-05 11:36:29'),
(33, 5, 'czJGufLfR7uZQAWJ2uMCjw:APA91bECUAhFI5UvHLJzNbhZ7FESys8BcucGkBOGtIza6T9NICz23kmJplk_fyzASq3lC-a8LN5s6TRmsKonpHiCNye2_gGIl8VEcewsxduJRJCpLOV1NJMuW2ktggSxyQO_J0j6zLNp', '2024-01-07 08:48:33', '2024-01-07 08:48:33'),
(34, 3, 'czJGufLfR7uZQAWJ2uMCjw:APA91bECUAhFI5UvHLJzNbhZ7FESys8BcucGkBOGtIza6T9NICz23kmJplk_fyzASq3lC-a8LN5s6TRmsKonpHiCNye2_gGIl8VEcewsxduJRJCpLOV1NJMuW2ktggSxyQO_J0j6zLNp', '2024-01-07 08:49:39', '2024-01-07 08:49:39'),
(35, 5, 'dcsdfsdfsd', '2024-01-17 16:27:57', '2024-01-17 16:27:57'),
(36, 5, 'dcsdfsdfsd', '2024-01-17 16:52:36', '2024-01-17 16:52:36'),
(37, 3, 'czJGufLfR7uZQAWJ2uMCjw:APA91bECUAhFI5UvHLJzNbhZ7FESys8BcucGkBOGtIza6T9NICz23kmJplk_fyzASq3lC-a8LN5s6TRmsKonpHiCNye2_gGIl8VEcewsxduJRJCpLOV1NJMuW2ktggSxyQO_J0j6zLNp', '2024-01-19 14:19:46', '2024-01-19 14:19:46'),
(38, 3, 'd1Cszls9Rkq6a9xN282Mq7:APA91bEX2zLIirRdyvrmaR-8a2hCsWwGRVJ9ymrqiAgcvyaaM56HFuigH3xoD9G5rNI3K72yKsyZh3gPHvYocvYgtEW8nZ66cO3rl5CrSV--3QlPtigDg7JePTu2tGfniKIwyUKg85UQ', '2024-01-19 14:33:59', '2024-01-19 14:33:59'),
(39, 3, 'cPThBdE_TAWwsAxO3wSD64:APA91bFeW_9D8sq7OcEj9Rmwhlr1fo5B58dguC8Ykk1Jga99VJMwkU4YodSdwiU97qOlWm_sN6OxdeiAQg6L_CmusRJT1VVP-d4yPLafkIPphHrncUZeoTWTxHskbmDcU9pB3QVkjvv_', '2024-01-20 19:44:55', '2024-01-20 19:44:55'),
(40, 3, 'cPThBdE_TAWwsAxO3wSD64:APA91bFeW_9D8sq7OcEj9Rmwhlr1fo5B58dguC8Ykk1Jga99VJMwkU4YodSdwiU97qOlWm_sN6OxdeiAQg6L_CmusRJT1VVP-d4yPLafkIPphHrncUZeoTWTxHskbmDcU9pB3QVkjvv_', '2024-01-20 19:45:50', '2024-01-20 19:45:50'),
(41, 5, 'cPThBdE_TAWwsAxO3wSD64:APA91bFeW_9D8sq7OcEj9Rmwhlr1fo5B58dguC8Ykk1Jga99VJMwkU4YodSdwiU97qOlWm_sN6OxdeiAQg6L_CmusRJT1VVP-d4yPLafkIPphHrncUZeoTWTxHskbmDcU9pB3QVkjvv_', '2024-01-20 19:46:35', '2024-01-20 19:46:35'),
(42, 3, 'cPThBdE_TAWwsAxO3wSD64:APA91bFeW_9D8sq7OcEj9Rmwhlr1fo5B58dguC8Ykk1Jga99VJMwkU4YodSdwiU97qOlWm_sN6OxdeiAQg6L_CmusRJT1VVP-d4yPLafkIPphHrncUZeoTWTxHskbmDcU9pB3QVkjvv_', '2024-01-20 19:47:45', '2024-01-20 19:47:45'),
(43, 3, 'ddtGPUyDQJqZbbun9q-1pe:APA91bFb3F97pkV_n9Qh1bH4WznXAcuznmrIhrUs1Yx2mbeRLVj02dCNQrAwVLFqO4n9QFNWpF3AeOQdvdsdFPYAd8c1hMrHkMKl6RbsJTHbFvK3_nm3KajcZP-v-FGFSPlimpCcYZvv', '2024-01-20 19:55:42', '2024-01-20 19:55:42'),
(44, 5, 'dcsdfsdfsd', '2024-01-21 18:42:29', '2024-01-21 18:42:29'),
(45, 5, 'dcsdfsdfsd', '2024-01-21 19:07:01', '2024-01-21 19:07:01'),
(46, 5, 'dcsdfsdfsd', '2024-01-21 19:07:24', '2024-01-21 19:07:24'),
(47, 5, 'dcsdfsdfsd', '2024-01-21 19:10:43', '2024-01-21 19:10:43'),
(48, 3, 'ddtGPUyDQJqZbbun9q-1pe:APA91bFb3F97pkV_n9Qh1bH4WznXAcuznmrIhrUs1Yx2mbeRLVj02dCNQrAwVLFqO4n9QFNWpF3AeOQdvdsdFPYAd8c1hMrHkMKl6RbsJTHbFvK3_nm3KajcZP-v-FGFSPlimpCcYZvv', '2024-01-21 19:24:01', '2024-01-21 19:24:01'),
(49, 3, 'ddtGPUyDQJqZbbun9q-1pe:APA91bFb3F97pkV_n9Qh1bH4WznXAcuznmrIhrUs1Yx2mbeRLVj02dCNQrAwVLFqO4n9QFNWpF3AeOQdvdsdFPYAd8c1hMrHkMKl6RbsJTHbFvK3_nm3KajcZP-v-FGFSPlimpCcYZvv', '2024-02-01 15:44:54', '2024-02-01 15:44:54'),
(50, 5, 'dcsdfsdfsd', '2024-02-01 16:57:11', '2024-02-01 16:57:11'),
(51, 3, 'ddtGPUyDQJqZbbun9q-1pe:APA91bFb3F97pkV_n9Qh1bH4WznXAcuznmrIhrUs1Yx2mbeRLVj02dCNQrAwVLFqO4n9QFNWpF3AeOQdvdsdFPYAd8c1hMrHkMKl6RbsJTHbFvK3_nm3KajcZP-v-FGFSPlimpCcYZvv', '2024-02-02 21:15:37', '2024-02-02 21:15:37'),
(52, 3, 'ddtGPUyDQJqZbbun9q-1pe:APA91bFb3F97pkV_n9Qh1bH4WznXAcuznmrIhrUs1Yx2mbeRLVj02dCNQrAwVLFqO4n9QFNWpF3AeOQdvdsdFPYAd8c1hMrHkMKl6RbsJTHbFvK3_nm3KajcZP-v-FGFSPlimpCcYZvv', '2024-02-03 17:07:09', '2024-02-03 17:07:09'),
(53, 3, 'ddtGPUyDQJqZbbun9q-1pe:APA91bF9GxVkxQr6YVs6ogF6DGKuyjY_58r--hihlPXP9f9gr64HamDxeTeNCVu20Hcp1-hQNnuiE-EE0yuFO8hB-oZb1uATEeOqAPashzUCSat_T7SxQzv0jHz4NVnMwF3HmCVEvP9_', '2024-02-26 10:29:43', '2024-02-26 10:29:43'),
(54, 3, 'cuvyMcCYS1qo0BSCyhF2nD:APA91bGa9YbbtBt3yoZweP_ADl1SAXUH8DZFtsWYMDTgBGjyy4p5mrfzJwXfj86Axl7QIEUU5CLTtpgHpHbdvZ-ikC3ndp3zktLJ2ZJmUoQ-toM3O0FuQ6cDxYZR2TGJuNiHn7MaK3yZ', '2024-03-03 09:44:52', '2024-03-03 09:44:52'),
(55, 5, 'e0ELNxL0R7uREgj50zMoCr:APA91bH7SOcteLSe4hBun0Of_XzxAAXFQAgDULma6XrReemEzwNhi7Slo3tkUzA3YzP6Y8J9ck8JJgunpXeCVmcWFqrtzV01S2SpLO-Hwz4Pa8L45lkR-T9-QaCaZInIaigmMVQEhNMd', '2024-03-03 09:48:10', '2024-03-03 09:48:10'),
(56, 3, 'e4aAClSuTBSCZ1exYgE3m9:APA91bEV-eW_mpN2ZFZ-R5mZHAHIxNI4VVMPGfunIlE_hVnyx3S0bwP6_xvKgmHO5jm-Qr4mjyaI_ApnOieFc0AuYsFHApPx6u6XcY_6xU5qMD8jrbMRCCELY2pMu3zK-KWCHbKySSMw', '2024-03-06 22:25:33', '2024-03-06 22:25:33'),
(57, 3, 'cuvyMcCYS1qo0BSCyhF2nD:APA91bGa9YbbtBt3yoZweP_ADl1SAXUH8DZFtsWYMDTgBGjyy4p5mrfzJwXfj86Axl7QIEUU5CLTtpgHpHbdvZ-ikC3ndp3zktLJ2ZJmUoQ-toM3O0FuQ6cDxYZR2TGJuNiHn7MaK3yZ', '2024-03-17 19:21:44', '2024-03-17 19:21:44'),
(58, 3, 'dZIzg606QDuYWmeXCk5wJO:APA91bF8p9phkA3fvwOnjVcIbaoX6FU7YEYJRE4PTvut9RD5XniSLk4I2Fvp6tFdo2WxEtQfwgSdJDwATIKT8wbyQvVgeldttKWm63d8FMhhJe1NBGhY3NN3366yO46WgToyIoB0hoRa', '2024-03-17 19:28:11', '2024-03-17 19:28:11'),
(59, 3, 'dchFgPJeT9erHTPyJjpmRZ:APA91bHrAncJdbfJf2bfUqRpE_sltw2rTryg__oZyFv7azhlJZIGRAeNQ5p74CiQiiwSG2IRf10LdWFeFlRLxkgyDTiE3wY_DMkkmJ9huTtUjCmE6HcvvCzKehlnpS89KMKpl4_-aanp', '2024-03-17 19:41:15', '2024-03-17 19:41:15'),
(60, 3, 'clYz5NDLRv6gj3cYxDauGS:APA91bHSDgAwBB4HqgGcf1ltjhRndhn0vawHjpigkCvBaDIdEE6xljNftvA3tE2rg5tbIXfDxYexogsVQZ62GSGRxwNvjWK4Vq1fSn5FrmvO6LaMZRPWUDVPD3CJWEG9YGizdZ0NWyBH', '2024-03-17 19:47:31', '2024-03-17 19:47:31'),
(61, 3, 'clYz5NDLRv6gj3cYxDauGS:APA91bHSDgAwBB4HqgGcf1ltjhRndhn0vawHjpigkCvBaDIdEE6xljNftvA3tE2rg5tbIXfDxYexogsVQZ62GSGRxwNvjWK4Vq1fSn5FrmvO6LaMZRPWUDVPD3CJWEG9YGizdZ0NWyBH', '2024-03-17 19:55:49', '2024-03-17 19:55:49'),
(62, 11, 'cMi37VBcTZefy-buQHhsZh:APA91bEUtAqV9TLm-rMUT4rIulrWPQA-lE9mN-POgF28Y4OZ3ZAw5B9oU16W_IAQ1iCeq_8BF9J4MDHjUuXQjJ8fsaX0le7cQMCIZHhTRu7ibTUpOQFK1TN2_8N_6b5UXfJbHXVuM7HG', '2024-04-22 18:59:16', '2024-04-22 18:59:16'),
(63, 11, 'cB0Hzv-4SXW5CZHex1HBU7:APA91bH-SxSBgGVtpPF65L0sUi31sM9MYguyVtaJw0oVLhP8U8ysYyqWPoqKWjQ2C3kued9axekoEPvk2Vrr5tfvOKIf7icOujyD8mkdkMBoy1xFB9IQRNd4k7Jy-8objeTGkpEveXON', '2024-04-22 19:35:52', '2024-04-22 19:35:52'),
(64, 12, 'f70YDRK1S4KF1_TMNOuOHp:APA91bG3iuxw_c6mZGF09H6kLwpQ4-mkud1pp_MAOueGWXC517GRbnYWSzycES0S2jdqecQ2_BZhUclvWfGcfZwE8PrNKPhBEKy-vmlkfzIInuQ4WO-_tO8RB-tCAlGd4z2iz2dTQGbc', '2024-04-22 19:40:14', '2024-04-22 19:40:14'),
(65, 11, 'dWxZO4o0TU24VR8NuGm7U1:APA91bGvu0Up_GKwLxYgrZTT5b9HBcQx6ZWpG2vKPcDRV_bvME6HtOdhn0A5gAUqryKAbd6DLSBFOO2jaEBiTdOGDWuEfq5TuZHOrXB9_ARhQu4X4nhKnYpgHm3K55XZHcwMPlJnKPdr', '2024-04-22 19:56:34', '2024-04-22 19:56:34'),
(66, 4, 'dS34vLnZRHWw5feclG2VWD:APA91bF0-CYnR5tRcG_EZE442NF7X-f9vOmR9C8_kXAWkem842-tlsRdMeuWwFlXngP_F6IWX-4ar1qCtXCtEKrJJD_BgUaHK8NHqHzxJlCDiQWtLOVbkgInSkybnzNqiLe8EjAEABZJ', '2024-04-23 13:54:16', '2024-04-23 13:54:16'),
(67, 11, 'fIa8dnfFT-W6s7XYz2g10k:APA91bErH9YLmx3dBGczLyIpokA8R5j3fv1n0y-4at-U2Wj6eoRcfg9gpggBjVYQF6cgvFAw2mfPbeUta8JVG70cK4c_LyO0O4n492AfpTtQNBChRrAB1_4v7xPMI_6qhwpVHloExwCr', '2024-04-23 14:07:37', '2024-04-23 14:07:37');

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `amount` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallets`
--

INSERT INTO `wallets` (`id`, `user_id`, `amount`, `created_at`, `updated_at`) VALUES
(1, 5, 0, '2024-01-19 15:01:31', '2024-01-19 15:01:31'),
(2, 3, 0, '2024-01-19 16:51:42', '2024-01-19 16:51:42');

-- --------------------------------------------------------

--
-- Table structure for table `wallet_deposits`
--

CREATE TABLE `wallet_deposits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `wallet_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `method` varchar(255) DEFAULT NULL,
  `trans_token` varchar(255) DEFAULT NULL,
  `amount` int(10) UNSIGNED NOT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallet_deposits`
--

INSERT INTO `wallet_deposits` (`id`, `wallet_id`, `email`, `method`, `trans_token`, `amount`, `currency`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, NULL, 10, NULL, '2024-01-19 19:27:14', '2024-01-19 19:27:14'),
(2, 1, 'hanan@gmail.com', NULL, NULL, 1, NULL, '2024-02-03 21:14:27', '2024-02-03 21:14:27');

-- --------------------------------------------------------

--
-- Table structure for table `wallet_deposit_requests`
--

CREATE TABLE `wallet_deposit_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `wallet_id` bigint(20) UNSIGNED NOT NULL,
  `amount` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `whatsapp_number` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `pref_payment_method` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallet_deposit_requests`
--

INSERT INTO `wallet_deposit_requests` (`id`, `wallet_id`, `amount`, `full_name`, `whatsapp_number`, `country`, `pref_payment_method`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Hanan', '123', NULL, 'haram', '2024-01-25 18:11:50', '2024-01-25 18:11:50'),
(2, 2, 50, 'jaafar alkhalouf', '963994335985', NULL, 'alharam', '2024-01-26 12:02:37', '2024-01-26 12:02:37'),
(3, 2, 100, 'g4grgrg', 'btbrbr', NULL, 'ntbtbt', '2024-01-26 13:58:57', '2024-01-26 13:58:57'),
(4, 2, 50, 'jaafar alkhalouf', '963994335985', NULL, 'alharam', '2024-01-27 10:55:57', '2024-01-27 10:55:57'),
(5, 2, 50, 'jaafar alkhalouf', '963994335985', NULL, 'alharam', '2024-02-01 18:42:01', '2024-02-01 18:42:01'),
(6, 2, 100, 'gfhv', '9865567', 'stgbij', 'hfjh', '2024-02-02 12:55:25', '2024-02-02 12:55:25');

-- --------------------------------------------------------

--
-- Table structure for table `wallet_withdraws`
--

CREATE TABLE `wallet_withdraws` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `wallet_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `method` varchar(255) DEFAULT NULL,
  `trans_token` varchar(255) DEFAULT NULL,
  `amount` double(8,2) UNSIGNED NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wallet_withdraw_requests`
--

CREATE TABLE `wallet_withdraw_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `wallet_id` bigint(20) UNSIGNED NOT NULL,
  `amount` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `whatsapp_number` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `pref_payment_method` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallet_withdraw_requests`
--

INSERT INTO `wallet_withdraw_requests` (`id`, `wallet_id`, `amount`, `full_name`, `whatsapp_number`, `country`, `pref_payment_method`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'hanna', '+963 5 255', 'Sy', 'haram', '2024-02-02 12:44:36', '2024-02-02 12:44:36'),
(2, 2, 30, 'gfhv', '9865567', 'stgbij', 'hfjh', '2024-02-02 12:55:01', '2024-02-02 12:55:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`),
  ADD UNIQUE KEY `admins_username_unique` (`username`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_translations`
--
ALTER TABLE `category_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_translations_category_id_locale_unique` (`category_id`,`locale`),
  ADD KEY `category_translations_locale_index` (`locale`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_code_unique` (`code`);

--
-- Indexes for table `deals`
--
ALTER TABLE `deals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `deals_qr_code_unique` (`qr_code`) USING HASH,
  ADD KEY `deals_trip_id_foreign` (`trip_id`),
  ADD KEY `deals_order_id_foreign` (`order_id`);

--
-- Indexes for table `deal_statuses`
--
ALTER TABLE `deal_statuses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `deal_statuses_deal_id_foreign` (`deal_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `favourites`
--
ALTER TABLE `favourites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `favourites_user_id_foreign` (`user_id`);

--
-- Indexes for table `help_supports`
--
ALTER TABLE `help_supports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `help_supports_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news_translations`
--
ALTER TABLE `news_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `news_translations_news_id_locale_unique` (`news_id`,`locale`),
  ADD KEY `news_translations_locale_index` (`locale`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_category_id_foreign` (`category_id`);

--
-- Indexes for table `order_item_images`
--
ALTER TABLE `order_item_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_item_images_order_item_id_foreign` (`order_item_id`);

--
-- Indexes for table `order_offers`
--
ALTER TABLE `order_offers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_offers_order_id_foreign` (`order_id`),
  ADD KEY `order_offers_trip_id_foreign` (`trip_id`);

--
-- Indexes for table `otps`
--
ALTER TABLE `otps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_user_id_foreign` (`user_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `review_ratings`
--
ALTER TABLE `review_ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `review_ratings_deal_id_foreign` (`deal_id`),
  ADD KEY `review_ratings_user_id_foreign` (`user_id`),
  ADD KEY `review_ratings_rated_id_foreign` (`rated_id`);

--
-- Indexes for table `trips`
--
ALTER TABLE `trips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trips_user_id_foreign` (`user_id`);

--
-- Indexes for table `trip_not_categories`
--
ALTER TABLE `trip_not_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trip_not_categories_trip_id_foreign` (`trip_id`),
  ADD KEY `trip_not_categories_category_id_foreign` (`category_id`);

--
-- Indexes for table `trip_requests`
--
ALTER TABLE `trip_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trip_requests_trip_id_foreign` (`trip_id`),
  ADD KEY `trip_requests_order_id_foreign` (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_mobile_unique` (`mobile`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_attachments`
--
ALTER TABLE `user_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_attachments_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_fcms`
--
ALTER TABLE `user_fcms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_fcms_user_id_foreign` (`user_id`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wallets_user_id_foreign` (`user_id`);

--
-- Indexes for table `wallet_deposits`
--
ALTER TABLE `wallet_deposits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wallet_deposits_wallet_id_foreign` (`wallet_id`);

--
-- Indexes for table `wallet_deposit_requests`
--
ALTER TABLE `wallet_deposit_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wallet_deposit_requests_wallet_id_foreign` (`wallet_id`);

--
-- Indexes for table `wallet_withdraws`
--
ALTER TABLE `wallet_withdraws`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wallet_withdraws_wallet_id_foreign` (`wallet_id`);

--
-- Indexes for table `wallet_withdraw_requests`
--
ALTER TABLE `wallet_withdraw_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wallet_withdraw_requests_wallet_id_foreign` (`wallet_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `category_translations`
--
ALTER TABLE `category_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deals`
--
ALTER TABLE `deals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `deal_statuses`
--
ALTER TABLE `deal_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favourites`
--
ALTER TABLE `favourites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `help_supports`
--
ALTER TABLE `help_supports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `news_translations`
--
ALTER TABLE `news_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `order_item_images`
--
ALTER TABLE `order_item_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `order_offers`
--
ALTER TABLE `order_offers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `otps`
--
ALTER TABLE `otps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review_ratings`
--
ALTER TABLE `review_ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `trips`
--
ALTER TABLE `trips`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `trip_not_categories`
--
ALTER TABLE `trip_not_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `trip_requests`
--
ALTER TABLE `trip_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_attachments`
--
ALTER TABLE `user_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_fcms`
--
ALTER TABLE `user_fcms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wallet_deposits`
--
ALTER TABLE `wallet_deposits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wallet_deposit_requests`
--
ALTER TABLE `wallet_deposit_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `wallet_withdraws`
--
ALTER TABLE `wallet_withdraws`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wallet_withdraw_requests`
--
ALTER TABLE `wallet_withdraw_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `category_translations`
--
ALTER TABLE `category_translations`
  ADD CONSTRAINT `category_translations_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `deals`
--
ALTER TABLE `deals`
  ADD CONSTRAINT `deals_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `deals_trip_id_foreign` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `deal_statuses`
--
ALTER TABLE `deal_statuses`
  ADD CONSTRAINT `deal_statuses_deal_id_foreign` FOREIGN KEY (`deal_id`) REFERENCES `deals` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `favourites`
--
ALTER TABLE `favourites`
  ADD CONSTRAINT `favourites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `help_supports`
--
ALTER TABLE `help_supports`
  ADD CONSTRAINT `help_supports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `news_translations`
--
ALTER TABLE `news_translations`
  ADD CONSTRAINT `news_translations_news_id_foreign` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_item_images`
--
ALTER TABLE `order_item_images`
  ADD CONSTRAINT `order_item_images_order_item_id_foreign` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_offers`
--
ALTER TABLE `order_offers`
  ADD CONSTRAINT `order_offers_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_offers_trip_id_foreign` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `review_ratings`
--
ALTER TABLE `review_ratings`
  ADD CONSTRAINT `review_ratings_deal_id_foreign` FOREIGN KEY (`deal_id`) REFERENCES `deals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `review_ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `trips`
--
ALTER TABLE `trips`
  ADD CONSTRAINT `trips_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `trip_not_categories`
--
ALTER TABLE `trip_not_categories`
  ADD CONSTRAINT `trip_not_categories_trip_id_foreign` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `trip_requests`
--
ALTER TABLE `trip_requests`
  ADD CONSTRAINT `trip_requests_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `trip_requests_trip_id_foreign` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_attachments`
--
ALTER TABLE `user_attachments`
  ADD CONSTRAINT `user_attachments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_fcms`
--
ALTER TABLE `user_fcms`
  ADD CONSTRAINT `user_fcms_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wallets`
--
ALTER TABLE `wallets`
  ADD CONSTRAINT `wallets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wallet_deposits`
--
ALTER TABLE `wallet_deposits`
  ADD CONSTRAINT `wallet_deposits_wallet_id_foreign` FOREIGN KEY (`wallet_id`) REFERENCES `wallets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wallet_deposit_requests`
--
ALTER TABLE `wallet_deposit_requests`
  ADD CONSTRAINT `wallet_deposit_requests_wallet_id_foreign` FOREIGN KEY (`wallet_id`) REFERENCES `wallets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wallet_withdraws`
--
ALTER TABLE `wallet_withdraws`
  ADD CONSTRAINT `wallet_withdraws_wallet_id_foreign` FOREIGN KEY (`wallet_id`) REFERENCES `wallets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wallet_withdraw_requests`
--
ALTER TABLE `wallet_withdraw_requests`
  ADD CONSTRAINT `wallet_withdraw_requests_wallet_id_foreign` FOREIGN KEY (`wallet_id`) REFERENCES `wallets` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
