-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2022 at 02:06 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_statements`
--

CREATE TABLE `account_statements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `date_search` date NOT NULL,
  `debit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accountType` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `governorate_id` bigint(20) UNSIGNED DEFAULT NULL,
  `city_ar` varchar(75) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city_en` varchar(75) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street_ar` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street_en` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `building_no` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `country_id`, `governorate_id`, `city_ar`, `city_en`, `street_ar`, `street_en`, `building_no`) VALUES
(1, 64, 1, 'مصر الجديدة', 'new egypt', 'وزارة الدفاع', 'ministry of defense', '0'),
(2, 64, 1, 'شيراتون', 'Sheraton', 'مربع 1157 مكرر مساكن شيراتون', 'Square 1157 bis Sheraton Residences', '8'),
(3, 64, 1, 'شيراتون', 'Sheraton', 'مربع 1111 مكرر مساكن شيراتون', 'Square 1111 bis Sheraton Residences', '58'),
(4, 1, 1, 'العبور', 'Al-obbour', 'الشهداء', 'Shohadaa', '1'),
(5, 1, 2, 'العبور', 'Al-obbour', 'الشهداء', 'Shohadaa', '2'),
(6, 1, 3, 'العبور', 'Al-obbour', 'الشهداء', 'Shohadaa', '3'),
(7, 1, 4, 'العبور', 'Al-obbour', 'الشهداء', 'Shohadaa', '4'),
(8, 1, 5, 'العبور', 'Al-obbour', 'الشهداء', 'Shohadaa', '5'),
(9, 1, 6, 'العبور', 'Al-obbour', 'الشهداء', 'Shohadaa', '6'),
(10, 1, 7, 'العبور', 'Al-obbour', 'الشهداء', 'Shohadaa', '7'),
(11, 1, 8, 'العبور', 'Al-obbour', 'الشهداء', 'Shohadaa', '8'),
(12, 1, 9, 'العبور', 'Al-obbour', 'الشهداء', 'Shohadaa', '9'),
(13, 1, 10, 'العبور', 'Al-obbour', 'الشهداء', 'Shohadaa', '10');

-- --------------------------------------------------------

--
-- Table structure for table `approval_cycles`
--

CREATE TABLE `approval_cycles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `approval_cycles`
--

INSERT INTO `approval_cycles` (`id`, `name_ar`, `name_en`, `code`) VALUES
(1, 'إذن إنصراف', 'Early Leave Permission', 'PER-01'),
(2, 'إذن تأخير', 'Late Permission', 'PER-02'),
(3, 'إذن مأموريه', 'Mission Permission', 'PER-03'),
(4, 'طلب اجازة', 'Vacation Request', 'PER-04'),
(5, 'طلب من قسم تكنولوجيا المعلومات ', 'IT Change Request', 'IT-01'),
(6, 'إذن الاستثناء', 'Exception Permission', 'IT-02'),
(7, 'طلب توظيف', 'Hiring Request', 'HR-01'),
(8, 'نقل موظف', 'Employee Transfer', 'HR-02'),
(9, 'طلب شراء لمشروع (البناء - المدني)', 'Project Purchasing Request (Construction - Civil)', 'C_Civil'),
(10, 'طلب شراء لمشروع (البناء - الهندسة الكهربائية والميكانيكية)', 'Project Purchasing Request (Construction - MEP)', 'C_MEP'),
(11, 'طلب شراء لمشروع (Stationary)', 'Project Purchasing Request (Stationary)', 'stationary'),
(12, 'طلب شراء لمشروع (تكنولوجيا المعلومات)', 'Project Purchasing Request (IT)', 'IT'),
(13, 'طلب شراء لمشروع (المكاتب)', 'Project Purchasing Request (Desks)', 'desks'),
(14, 'اوامر الشراء', 'Purchase orders', 'PO'),
(15, 'طلب شيك', 'Cheque Request', 'cheque_request'),
(16, 'طلب شراء من المصنع', ' Purchasing Request (Factory)', 'factory');

-- --------------------------------------------------------

--
-- Table structure for table `approval_cycle_approval_steps`
--

CREATE TABLE `approval_cycle_approval_steps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `approval_cycle_id` bigint(20) UNSIGNED NOT NULL,
  `approval_step_id` bigint(20) UNSIGNED NOT NULL,
  `level` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `next_id` bigint(20) UNSIGNED DEFAULT NULL,
  `previous_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `approval_cycle_approval_steps`
--

INSERT INTO `approval_cycle_approval_steps` (`id`, `approval_cycle_id`, `approval_step_id`, `level`, `next_id`, `previous_id`, `created_at`, `updated_at`) VALUES
(1, 15, 4, '1', 2, NULL, '2022-03-28 09:21:38', '2022-03-28 09:21:39'),
(2, 15, 7, '2', 3, 1, '2022-03-28 09:21:38', '2022-03-28 09:21:39'),
(3, 15, 5, '3', 4, 2, '2022-03-28 09:21:38', '2022-03-28 09:21:39'),
(4, 15, 13, '4', 5, 3, '2022-03-28 09:21:38', '2022-03-28 09:21:39'),
(5, 15, 6, '5', 6, 4, '2022-03-28 09:21:38', '2022-03-28 09:21:39'),
(6, 15, 9, '6', NULL, 5, '2022-03-28 09:21:39', '2022-03-28 09:21:39'),
(7, 16, 18, '1', 8, NULL, '2022-03-28 09:21:39', '2022-03-28 09:21:39'),
(8, 16, 19, '2', 9, 7, '2022-03-28 09:21:39', '2022-03-28 09:21:39'),
(9, 16, 20, '3', 10, 8, '2022-03-28 09:21:39', '2022-03-28 09:21:39'),
(10, 16, 21, '4', 11, 8, '2022-03-28 09:21:39', '2022-03-28 09:21:39'),
(11, 16, 9, '5', NULL, 10, '2022-03-28 09:21:39', '2022-03-28 09:21:39'),
(12, 14, 4, '1', 13, NULL, '2022-03-28 09:21:40', '2022-03-28 09:21:40'),
(13, 14, 7, '2', 14, 12, '2022-03-28 09:21:40', '2022-03-28 09:21:40'),
(14, 14, 5, '3', 15, 12, '2022-03-28 09:21:40', '2022-03-28 09:21:40'),
(15, 14, 13, '4', 16, 12, '2022-03-28 09:21:40', '2022-03-28 09:21:40'),
(16, 14, 9, '5', NULL, 15, '2022-03-28 09:21:40', '2022-03-28 09:21:40'),
(17, 9, 15, '1', 18, NULL, '2022-03-28 09:21:40', '2022-03-28 09:21:40'),
(18, 9, 8, '2', 19, 17, '2022-03-28 09:21:40', '2022-03-28 09:21:40'),
(19, 9, 16, '3', 20, 17, '2022-03-28 09:21:40', '2022-03-28 09:21:40'),
(20, 9, 13, '4', 21, 18, '2022-03-28 09:21:40', '2022-03-28 09:21:40'),
(21, 9, 9, '5', NULL, 18, '2022-03-28 09:21:40', '2022-03-28 09:21:40'),
(22, 10, 15, '1', 23, NULL, '2022-03-28 09:21:41', '2022-03-28 09:21:41'),
(23, 10, 8, '2', 24, 22, '2022-03-28 09:21:41', '2022-03-28 09:21:41'),
(24, 10, 17, '3', 25, 22, '2022-03-28 09:21:41', '2022-03-28 09:21:41'),
(25, 10, 13, '4', 26, 23, '2022-03-28 09:21:41', '2022-03-28 09:21:41'),
(26, 10, 9, '5', NULL, 23, '2022-03-28 09:21:41', '2022-03-28 09:21:41'),
(27, 5, 3, '1', 28, NULL, '2022-03-28 09:21:41', '2022-03-28 09:21:41'),
(28, 5, 12, '2', NULL, 27, '2022-03-28 09:21:41', '2022-03-28 09:21:41');

-- --------------------------------------------------------

--
-- Table structure for table `approval_steps`
--

CREATE TABLE `approval_steps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `approval_steps`
--

INSERT INTO `approval_steps` (`id`, `name_ar`, `name_en`, `code`, `value`, `created_at`, `updated_at`) VALUES
(1, 'المدير المباشر', 'Direct manager', 'DIR_M', '{\"depth\":[\"manager\"], \"query\" : []}', '2022-03-28 09:21:37', '2022-03-28 09:21:37'),
(2, 'المنشئ ', 'Merchandising team leader', 'CREATOR', '{\"depth\":[\"user\"], \"query\" : []}', '2022-03-28 09:21:37', '2022-03-28 09:21:37'),
(3, 'مدير القسم', 'Department manager', 'DEP_M', '{\"depth\":[\"department\", \"manager\"], \"query\" : []}', '2022-03-28 09:21:37', '2022-03-28 09:21:37'),
(4, 'مدير ادارة المشتريات', 'Purchasing Department manager', 'PUR_DEP_M', '{\"depth\":[],\"query\":{\"T\":\"departments\",\"CONs\":[{\"CN\":\"name_en\",\"CV\":\"Internal Purchasing\"}],\"depth\":[\"first()\" ,\"manager\"]}}', '2022-03-28 09:21:37', '2022-03-28 09:21:37'),
(5, 'مدير المراجعه', 'Audit Manager', 'AUD_M', '{\"depth\":[],\"query\":{\"T\":\"departments\",\"CONs\":[{\"CN\":\"name_en\",\"CV\":\"Audit\"}],\"depth\":[\"first()\" ,\"manager\"]}}', '2022-03-28 09:21:37', '2022-03-28 09:21:37'),
(6, ' رئيس قطاع الحسابات والمراجعة والمخازن', ' Head of Accounts, Audit & Inventory', 'HEAD_ACC_AUD', '{\"depth\":[],\"query\":{\"T\":\"sectors\",\"CONs\":[{\"CN\":\"name_en\",\"CV\":\"Accounts, Audit & Inventory\"}],\"depth\":[\"first()\" ,\"head\"]}}', '2022-03-28 09:21:37', '2022-03-28 09:21:37'),
(7, 'مدير مراقبة التكاليف', 'Cost Control Manager', 'COST_M', '{\"depth\":[],\"query\":{\"T\":\"departments\",\"CONs\":[{\"CN\":\"name_en\",\"CV\":\"Cost\"}],\"depth\":[\"first()\" ,\"manager\"]}}', '2022-03-28 09:21:37', '2022-03-28 09:21:37'),
(8, 'رئيس القطاع', 'Sector head', 'SEC_H', '{\"depth\":[\"sector\", \"head\"], \"query\" : []}', '2022-03-28 09:21:37', '2022-03-28 09:21:37'),
(9, 'الرئيس التنفيذي', 'Chief Executive Officer (CEO)', 'CEO_H', '{\"depth\":[],\"query\":{\"T\":\"sectors\",\"CONs\":[{\"CN\":\"name_en\",\"CV\":\"Chief Executive Officer (CEO)\"}],\"depth\":[\"first()\" ,\"head\"]}}', '2022-03-28 09:21:38', '2022-03-28 09:21:38'),
(10, 'الرئيس التنفيذي للعمليات', 'Chief Operating Officer (COO)', 'COO_H', '{\"depth\":[],\"query\":{\"T\":\"sectors\",\"CONs\":[{\"CN\":\"name_en\",\"CV\":\"Chief Operating Officer (COO)\"}],\"depth\":[\"first()\" ,\"head\"]}}', '2022-03-28 09:21:38', '2022-03-28 09:21:38'),
(11, 'المدير المالي', 'Chief Financial Officer (CFO)', 'CFO_H', '{\"depth\":[],\"query\":{\"T\":\"sectors\",\"CONs\":[{\"CN\":\"name_en\",\"CV\":\"Chief Financial Officer (CFO)}],\"depth\":[\"first()\" ,\"head\"]}}', '2022-03-28 09:21:38', '2022-03-28 09:21:38'),
(12, 'رئيس قطاع التخطيط', 'Planning sector head', 'Pln_H', '{\"depth\":[],\"query\":{\"T\":\"sectors\",\"CONs\":[{\"CN\":\"name_en\",\"CV\":\"Corporate Planning & Development\"}],\"depth\":[\"first()\" ,\"head\"]}}', '2022-03-28 09:21:38', '2022-03-28 09:21:38'),
(13, 'رئيس قطاع المشتريات', 'Purchasing sector head', 'PUR_H', '{\"depth\":[],\"query\":{\"T\":\"sectors\",\"CONs\":[{\"CN\":\"name_en\",\"CV\":\"Purchasing\"}],\"depth\":[\"first()\" ,\"head\"]}}', '2022-03-28 09:21:38', '2022-03-28 09:21:38'),
(14, ' تطوير الاعمال', 'Business Development', 'B_DEV', '{\"depth\":[],\"query\":{\"T\":\"sectors\",\"CONs\":[{\"CN\":\"name_en\",\"CV\":\"Business Development\"}],\"depth\":[\"first()\" ,\"head\"]}}', '2022-03-28 09:21:38', '2022-03-28 09:21:38'),
(15, 'مدير المشروع', 'Project manager', 'PRO_M', '{\"depth\":[\"project\", \"manager\"], \"query\" : []}', '2022-03-28 09:21:38', '2022-03-28 09:21:38'),
(16, 'رئيس المكتب الفني للبناء - المدني', 'Civil Technical Office', 'TEC_OFF_Civil', '{\"depth\":[],\"query\":{\"T\":\"departments\",\"CONs\":[{\"CN\":\"name_en\",\"CV\":\"Civil Technical Office\"}],\"depth\":[\"first()\" ,\"manager\"]}}', '2022-03-28 09:21:38', '2022-03-28 09:21:38'),
(17, 'رئيس المكتب الفني للهندسة الكهربائية والميكانيكية', 'MEP Technical Office', 'TEC_OFF_MEP', '{\"depth\":[],\"query\":{\"T\":\"departments\",\"CONs\":[{\"CN\":\"name_en\",\"CV\":\"MEP Technical Office\"}],\"depth\":[\"first()\" ,\"manager\"]}}', '2022-03-28 09:21:38', '2022-03-28 09:21:38'),
(18, '     مسئول تخطيط ومتابعة الخامات', 'Plan & MRP Director', 'PLAN_MRP', '{\"depth\":[],\"query\":{\"T\":\"users\",\"CONs\":[{\"CN\":\"code\",\"CV\":\"2022-100\"}],\"depth\":[\"first()\"]}}', '2022-03-28 09:21:38', '2022-03-28 09:21:38'),
(19, ' مدير تخطيط ومتابعة الخامات', 'Plan & MRP Director', 'PLAN_MRP_DIR', '{\"depth\":[],\"query\":{\"T\":\"users\",\"CONs\":[{\"CN\":\"code\",\"CV\":\"2022-101\"}],\"depth\":[\"first()\"]}}', '2022-03-28 09:21:38', '2022-03-28 09:21:38'),
(20, 'مدير عام المصانع', 'administrator', 'ADMI', '{\"depth\":[],\"query\":{\"T\":\"users\",\"CONs\":[{\"CN\":\"code\",\"CV\":\"2022-102\"}],\"depth\":[\"first()\"]}}', '2022-03-28 09:21:38', '2022-03-28 09:21:38'),
(21, 'نائب رئيس مجلس الاداره ', 'Resident Executive Vice President', 'RES_EXE', '{\"depth\":[],\"query\":{\"T\":\"users\",\"CONs\":[{\"CN\":\"code\",\"CV\":\"2022-103\"}],\"depth\":[\"first()\"]}}', '2022-03-28 09:21:38', '2022-03-28 09:21:38');

-- --------------------------------------------------------

--
-- Table structure for table `approval_timelines`
--

CREATE TABLE `approval_timelines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `table_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `record_id` bigint(20) NOT NULL,
  `approval_cycle_approval_step_id` bigint(20) UNSIGNED NOT NULL,
  `approval_status` enum('P','A','RV','RJ') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'P' COMMENT 'P: Pending, A: Approved, RV: Revert, RJ: Reject',
  `business_action` int(11) NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `action_id` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `approval_timeline_comments`
--

CREATE TABLE `approval_timeline_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment_approve` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_approve` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_image_approve` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approval_timeline_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bank_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_account_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_branch` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_ibn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_swift` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`id`, `bank_code`, `bank_account_number`, `bank_name`, `bank_branch`, `currency`, `bank_ibn`, `bank_swift`, `bank_address`, `approved`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '1', '20310214867-29', 'QNB', NULL, 'يورو', NULL, NULL, NULL, 0, NULL, '2022-03-28 09:21:41', '2022-03-28 09:21:41'),
(2, '2', '20310214868-26', 'QNB', NULL, 'استرلينى', NULL, NULL, NULL, 0, NULL, '2022-03-28 09:21:41', '2022-03-28 09:21:41'),
(3, '3', '20310214869-23', 'QNB', NULL, 'دولار', NULL, NULL, NULL, 0, NULL, '2022-03-28 09:21:41', '2022-03-28 09:21:41'),
(4, '4', '24635419003-21', 'QNB', NULL, 'دولار', NULL, NULL, NULL, 0, NULL, '2022-03-28 09:21:41', '2022-03-28 09:21:41'),
(5, '5', '20315214068-81', 'QNB', NULL, 'دولار', NULL, NULL, NULL, 0, NULL, '2022-03-28 09:21:41', '2022-03-28 09:21:41'),
(6, '6', '20315158062-95', 'QNB', NULL, 'مصري', NULL, NULL, NULL, 0, NULL, '2022-03-28 09:21:41', '2022-03-28 09:21:41'),
(7, '7', '20310214866-32', 'QNB', NULL, 'مصري', NULL, NULL, NULL, 0, NULL, '2022-03-28 09:21:42', '2022-03-28 09:21:42'),
(8, '8', '24635376722-85', 'QNB', NULL, 'مصري', NULL, NULL, NULL, 0, NULL, '2022-03-28 09:21:42', '2022-03-28 09:21:42'),
(9, '9', '26937301120-77', 'QNB', NULL, 'مصري', NULL, NULL, NULL, 0, NULL, '2022-03-28 09:21:42', '2022-03-28 09:21:42'),
(10, '10', '20319661912-15', 'QNB', NULL, 'مصري', NULL, NULL, NULL, 0, NULL, '2022-03-28 09:21:42', '2022-03-28 09:21:42'),
(11, '11', '24639785014-92', 'QNB', NULL, 'مصري', NULL, NULL, NULL, 0, NULL, '2022-03-28 09:21:42', '2022-03-28 09:21:42'),
(12, '12', '27590147687-54', 'QNB', NULL, 'مصري', NULL, NULL, NULL, 0, NULL, '2022-03-28 09:21:42', '2022-03-28 09:21:42'),
(13, '13', '27590147692-54', 'QNB', NULL, 'مصري', NULL, NULL, NULL, 0, NULL, '2022-03-28 09:21:42', '2022-03-28 09:21:42'),
(14, '14', '1383060583499800012', 'البنك الاهلى المصري', NULL, 'دولار', NULL, NULL, NULL, 0, NULL, '2022-03-28 09:21:42', '2022-03-28 09:21:42'),
(15, '15', '1383060583499800023', 'البنك الاهلى المصري', NULL, 'يورو', NULL, NULL, NULL, 0, NULL, '2022-03-28 09:21:42', '2022-03-28 09:21:42'),
(16, '16', '1382330583499800011', 'البنك الاهلى المصري', NULL, 'مصري', NULL, NULL, NULL, 0, NULL, '2022-03-28 09:21:42', '2022-03-28 09:21:42'),
(17, '17', '1383070583499800012', 'البنك الاهلى المصري', NULL, 'مصري', NULL, NULL, NULL, 0, NULL, '2022-03-28 09:21:42', '2022-03-28 09:21:42'),
(18, '18', '1382090583499800014', 'البنك الاهلى المصري', NULL, 'مصري', NULL, NULL, NULL, 0, NULL, '2022-03-28 09:21:42', '2022-03-28 09:21:42'),
(19, '19', '1382080583499800058', 'البنك الاهلى المصري', NULL, 'مصري', NULL, NULL, NULL, 0, NULL, '2022-03-28 09:21:42', '2022-03-28 09:21:42'),
(20, '20', '1382080583499800069', 'البنك الاهلى المصري', NULL, 'مصري', NULL, NULL, NULL, 0, NULL, '2022-03-28 09:21:42', '2022-03-28 09:21:42'),
(21, '21', '1382650583499800019', 'البنك الاهلى المصري', NULL, 'مصري', NULL, NULL, NULL, 0, NULL, '2022-03-28 09:21:42', '2022-03-28 09:21:42'),
(22, '22', '1382630583499800019', 'البنك الاهلى المصري', NULL, 'مصري', NULL, NULL, NULL, 0, NULL, '2022-03-28 09:21:42', '2022-03-28 09:21:42'),
(23, '23', '1382800583499800017', 'البنك الاهلى المصري', NULL, 'مصري', NULL, NULL, NULL, 0, NULL, '2022-03-28 09:21:43', '2022-03-28 09:21:43'),
(24, '24', '1382800583499800028', 'البنك الاهلى المصري', NULL, 'مصري', NULL, NULL, NULL, 0, NULL, '2022-03-28 09:21:43', '2022-03-28 09:21:43'),
(25, '25', '1382070583499800014', 'البنك الاهلى المصري', NULL, 'مصري', NULL, NULL, NULL, 0, NULL, '2022-03-28 09:21:43', '2022-03-28 09:21:43'),
(26, '26', '783070507437700011', 'البنك الاهلى المصري', NULL, 'مصري', NULL, NULL, NULL, 0, NULL, '2022-03-28 09:21:43', '2022-03-28 09:21:43'),
(27, '27', '1382080583499800078', 'البنك الاهلى المصري', NULL, 'مصري', NULL, NULL, NULL, 0, NULL, '2022-03-28 09:21:43', '2022-03-28 09:21:43'),
(28, '28', '6006', 'بنك اسكندرية', NULL, 'مصري', NULL, NULL, NULL, 0, NULL, '2022-03-28 09:21:43', '2022-03-28 09:21:43'),
(29, '29', '6014', 'بنك اسكندرية', NULL, 'مصري', NULL, NULL, NULL, 0, NULL, '2022-03-28 09:21:43', '2022-03-28 09:21:43'),
(30, '30', '6001', 'بنك اسكندرية', NULL, 'دولار', NULL, NULL, NULL, 0, NULL, '2022-03-28 09:21:43', '2022-03-28 09:21:43'),
(31, '31', '6003', 'بنك اسكندرية', NULL, 'يورو', NULL, NULL, NULL, 0, NULL, '2022-03-28 09:21:43', '2022-03-28 09:21:43'),
(32, '32', '1913010000000016', 'بنك مصر', NULL, 'مصري', NULL, NULL, NULL, 0, NULL, '2022-03-28 09:21:43', '2022-03-28 09:21:43'),
(33, '33', '1913000000000028', 'بنك مصر', NULL, 'مصري', NULL, NULL, NULL, 0, NULL, '2022-03-28 09:21:43', '2022-03-28 09:21:43'),
(34, '34', '1910001000005976', 'بنك مصر', NULL, 'دولار', NULL, NULL, NULL, 0, NULL, '2022-03-28 09:21:43', '2022-03-28 09:21:43'),
(35, '35', '1910199000000608', 'بنك مصر', NULL, 'يورو', NULL, NULL, NULL, 0, NULL, '2022-03-28 09:21:43', '2022-03-28 09:21:43');

-- --------------------------------------------------------

--
-- Table structure for table `business_natures`
--

CREATE TABLE `business_natures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `business_natures`
--

INSERT INTO `business_natures` (`id`, `name_ar`, `name_en`, `item_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'اعمال متكامله', 'Integrated works', 1, NULL, '2022-03-28 09:21:44', '2022-03-28 09:21:44'),
(2, 'تركيب منشآت معدنية', 'Installation of metal structures', 1, NULL, '2022-03-28 09:21:44', '2022-03-28 09:21:44'),
(3, 'شبكات صرف + تغذية', 'Drainage networks + feeding', 1, NULL, '2022-03-28 09:21:44', '2022-03-28 09:21:44'),
(4, 'ضيـــافة', 'hospitality', 2, NULL, '2022-03-28 09:21:44', '2022-03-28 09:21:44'),
(5, 'صيـــانة', 'maintenance', 2, NULL, '2022-03-28 09:21:44', '2022-03-28 09:21:44'),
(6, 'تصويــر', 'photography', 2, NULL, '2022-03-28 09:21:45', '2022-03-28 09:21:45'),
(7, 'بريد سريع ', 'Fast mail', 2, NULL, '2022-03-28 09:21:45', '2022-03-28 09:21:45'),
(8, 'نظافـــة', 'cleanliness', 2, NULL, '2022-03-28 09:21:45', '2022-03-28 09:21:45'),
(9, 'تبرعــات', 'Donations', 2, NULL, '2022-03-28 09:21:45', '2022-03-28 09:21:45'),
(10, 'مناقصات', 'Tenders', 2, NULL, '2022-03-28 09:21:45', '2022-03-28 09:21:45'),
(11, 'صندوق الخدمات الاجتماعية', 'Social Services Fund', 2, NULL, '2022-03-28 09:21:45', '2022-03-28 09:21:45'),
(12, 'كهربــاء', 'Electricity', 2, NULL, '2022-03-28 09:21:45', '2022-03-28 09:21:45'),
(13, 'أ مكتبية ومطبوعات', 'A stationery and publications', 2, NULL, '2022-03-28 09:21:45', '2022-03-28 09:21:45'),
(14, 'غـــاز', 'gas', 2, NULL, '2022-03-28 09:21:45', '2022-03-28 09:21:45'),
(15, 'انتقـالات ', 'transitions', 2, NULL, '2022-03-28 09:21:45', '2022-03-28 09:21:45'),
(16, 'سفر للخارج', 'travel abroad', 2, NULL, '2022-03-28 09:21:45', '2022-03-28 09:21:45'),
(17, 'تأجير سيارات لنقل العاملين', 'Car rental to transport workers', 2, NULL, '2022-03-28 09:21:45', '2022-03-28 09:21:45'),
(18, 'ايجــارات', 'rent', 2, NULL, '2022-03-28 09:21:45', '2022-03-28 09:21:45'),
(19, 'زي عامليـن ', 'workers uniforms', 2, NULL, '2022-03-28 09:21:45', '2022-03-28 09:21:45'),
(20, 'رسوم واشتراكات', 'Fees and subscriptions', 2, NULL, '2022-03-28 09:21:45', '2022-03-28 09:21:45'),
(21, 'تليفونات وانترنت', 'Telephones and the Internet', 2, NULL, '2022-03-28 09:21:45', '2022-03-28 09:21:45'),
(22, 'م . ورسوم عقد تعديل الشركة ', 'M . Company amendment contract fee', 2, NULL, '2022-03-28 09:21:46', '2022-03-28 09:21:46'),
(23, 'اكراميــات', 'perks', 2, NULL, '2022-03-28 09:21:46', '2022-03-28 09:21:46'),
(24, 'اتعاب مهنيه', 'professional fees', 2, NULL, '2022-03-28 09:21:46', '2022-03-28 09:21:46'),
(25, 'دعاية واعلان', 'Advertising', 2, NULL, '2022-03-28 09:21:46', '2022-03-28 09:21:46'),
(26, 'دليل يلوبيدجز ', 'Yellow Pages Guide', 2, NULL, '2022-03-28 09:21:46', '2022-03-28 09:21:46'),
(27, 'عـــلاج', 'treatment', 2, NULL, '2022-03-28 09:21:46', '2022-03-28 09:21:46'),
(28, 'انشطة ومزايا للعاملين', 'Activities and benefits for employees', 2, NULL, '2022-03-28 09:21:46', '2022-03-28 09:21:46'),
(29, 'صحف ومجلات', 'Newspapers and magazines', 2, NULL, '2022-03-28 09:21:46', '2022-03-28 09:21:46'),
(30, 'ميـــاه', 'water', 2, NULL, '2022-03-28 09:21:46', '2022-03-28 09:21:46'),
(31, 'هدايــا', 'gifts', 2, NULL, '2022-03-28 09:21:46', '2022-03-28 09:21:46'),
(32, 'تامينات . اجتماعية ', 'Insurances. social', 2, NULL, '2022-03-28 09:21:46', '2022-03-28 09:21:46'),
(33, 'ايــــزو', 'ISO', 2, NULL, '2022-03-28 09:21:46', '2022-03-28 09:21:46'),
(34, 'تدريبـات', 'training', 2, NULL, '2022-03-28 09:21:46', '2022-03-28 09:21:46'),
(35, 'مصروفات حديقة', 'garden expenses', 2, NULL, '2022-03-28 09:21:46', '2022-03-28 09:21:46'),
(36, 'تامين صحى  ', 'health insurance', 2, NULL, '2022-03-28 09:21:46', '2022-03-28 09:21:46'),
(37, 'م كمبيوتـر', 'm computer', 2, NULL, '2022-03-28 09:21:46', '2022-03-28 09:21:46'),
(38, 'مرتبـــات', 'salaries', 2, NULL, '2022-03-28 09:21:47', '2022-03-28 09:21:47'),
(39, 'طوارئ العاملين', 'workers emergency', 2, NULL, '2022-03-28 09:21:47', '2022-03-28 09:21:47'),
(40, ' م . تغــذية ', 'M . nutrition', 2, NULL, '2022-03-28 09:21:47', '2022-03-28 09:21:47'),
(41, 'سيـــارات', 'cars', 2, NULL, '2022-03-28 09:21:47', '2022-03-28 09:21:47'),
(42, 'برمجة', 'Soft Ware', 2, NULL, '2022-03-28 09:21:47', '2022-03-28 09:21:47'),
(43, 'دمغات حكومية', 'government stamps', 2, NULL, '2022-03-28 09:21:47', '2022-03-28 09:21:47'),
(44, 'أمن و حراسة', 'Security and guarding', 2, NULL, '2022-03-28 09:21:47', '2022-03-28 09:21:47'),
(45, 'فروق فحص', 'Check differences', 2, NULL, '2022-03-28 09:21:47', '2022-03-28 09:21:47'),
(46, 'عينات', 'samples', 2, NULL, '2022-03-28 09:21:47', '2022-03-28 09:21:47'),
(47, 'معارض', 'opposed', 2, NULL, '2022-03-28 09:21:47', '2022-03-28 09:21:47'),
(48, 'تعويضات', 'compensation', 2, NULL, '2022-03-28 09:21:47', '2022-03-28 09:21:47'),
(49, 'تصنيع', 'تصنيع', 1, NULL, '2022-03-29 11:10:06', '2022-03-29 11:10:06');

-- --------------------------------------------------------

--
-- Table structure for table `cheque_item_requests`
--

CREATE TABLE `cheque_item_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cheque_id` bigint(20) UNSIGNED NOT NULL,
  `debit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statement` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cheque_requests`
--

CREATE TABLE `cheque_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cheque_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requester_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `type_ord_okay` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `cheque_value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value_letter` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_debit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_balance` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_number` int(11) DEFAULT NULL,
  `invoice_number` int(11) DEFAULT NULL,
  `operation_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exist_comment` tinyint(1) NOT NULL DEFAULT 0,
  `sent` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_code` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name_ar`, `name_en`, `code`, `phone_code`, `deleted_at`) VALUES
(1, 'افغانستان', 'Afghanistan', 'AF', '93', '2021-08-10 08:00:11'),
(2, 'البانيا', 'Albania', 'AL', '355', '2021-08-10 08:00:11'),
(3, 'الجزائر', 'Algeria', 'DZ', '213', '2021-08-10 08:00:11'),
(4, 'American Samoa', 'American Samoa', 'AS', '1684', '2021-08-10 08:00:11'),
(5, 'اندورا', 'Andorra', 'AD', '376', '2021-08-10 08:00:11'),
(6, 'انجولا', 'Angola', 'AO', '244', '2021-08-10 08:00:11'),
(7, 'Anguilla', 'Anguilla', 'AI', '1264', '2021-08-10 08:00:11'),
(8, 'Antarctica', 'Antarctica', 'AQ', '0', '2021-08-10 08:00:11'),
(9, 'انتيجوا وباربودا	', 'Antigua And Barbuda', 'AG', '1268', '2021-08-10 08:00:11'),
(10, 'الارجنتين', 'Argentina', 'AR', '54', '2021-08-10 08:00:11'),
(11, 'ارمينيا', 'Armenia', 'AM', '374', '2021-08-10 08:00:11'),
(12, 'Aruba', 'Aruba', 'AW', '297', '2021-08-10 08:00:11'),
(13, 'استراليا', 'Australia', 'AU', '61', '2021-08-10 08:00:11'),
(14, 'النمسا', 'Austria', 'AT', '43', '2021-08-10 08:00:11'),
(15, 'اذربيجان', 'Azerbaijan', 'AZ', '994', '2021-08-10 08:00:11'),
(16, 'جزر البهاما', 'Bahamas The', 'BS', '1242', '2021-08-10 08:00:11'),
(17, 'البحرين', 'Bahrain', 'BH', '973', '2021-08-10 08:00:11'),
(18, 'بنجلاديش', 'Bangladesh', 'BD', '880', '2021-08-10 08:00:11'),
(19, 'باربادوس', 'Barbados', 'BB', '1246', '2021-08-10 08:00:11'),
(20, 'بيلا روسيا', 'Belarus', 'BY', '375', '2021-08-10 08:00:11'),
(21, 'بلجيكا', 'Belgium', 'BE', '32', '2021-08-10 08:00:11'),
(22, 'بيليز', 'Belize', 'BZ', '501', '2021-08-10 08:00:11'),
(23, 'بنين', 'Benin', 'BJ', '229', '2021-08-10 08:00:11'),
(24, 'Bermuda', 'Bermuda', 'BM', '1441', '2021-08-10 08:00:11'),
(25, 'بوتان', 'Bhutan', 'BT', '975', '2021-08-10 08:00:11'),
(26, 'بوليفيا', 'Bolivia', 'BO', '591', '2021-08-10 08:00:11'),
(27, 'البوسنة والهرسك', 'Bosnia and Herzegovina', 'BA', '387', '2021-08-10 08:00:11'),
(28, 'بوتسوانا', 'Botswana', 'BW', '267', '2021-08-10 08:00:11'),
(29, 'Bouvet Island', 'Bouvet Island', 'BV', '0', '2021-08-10 08:00:11'),
(30, 'البرازيل', 'Brazil', 'BR', '55', '2021-08-10 08:00:11'),
(31, 'British Indian Ocean Territory', 'British Indian Ocean Territory', 'IO', '246', '2021-08-10 08:00:11'),
(32, 'بروناى', 'Brunei', 'BN', '673', '2021-08-10 08:00:11'),
(33, 'بلغاريا', 'Bulgaria', 'BG', '359', '2021-08-10 08:00:11'),
(34, 'بوركينا فاسو', 'Burkina Faso', 'BF', '226', '2021-08-10 08:00:11'),
(35, 'بوروندى', 'Burundi', 'BI', '257', '2021-08-10 08:00:11'),
(36, 'كمبوديا', 'Cambodia', 'KH', '855', '2021-08-10 08:00:11'),
(37, 'الكاميرون', 'Cameroon', 'CM', '237', '2021-08-10 08:00:11'),
(38, 'كندا', 'Canada', 'CA', '1', '2021-08-10 08:00:11'),
(39, 'الرأس الاخضر', 'Cape Verde', 'CV', '238', '2021-08-10 08:00:11'),
(40, 'Cayman Islands', 'Cayman Islands', 'KY', '1345', '2021-08-10 08:00:11'),
(41, 'جمهورية افريقيا الوسطى', 'Central African Republic', 'CF', '236', '2021-08-10 08:00:11'),
(42, 'تشاد', 'Chad', 'TD', '235', '2021-08-10 08:00:11'),
(43, 'شيلى', 'Chile', 'CL', '56', '2021-08-10 08:00:11'),
(44, 'الصين', 'China', 'CN', '86', '2021-08-10 08:00:11'),
(45, 'Christmas Island', 'Christmas Island', 'CX', '61', '2021-08-10 08:00:11'),
(46, 'Cocos (Keeling) Islands', 'Cocos (Keeling) Islands', 'CC', '672', '2021-08-10 08:00:11'),
(47, 'كولمبيا', 'Colombia', 'CO', '57', '2021-08-10 08:00:11'),
(48, 'جزر الُقمـــر', 'Comoros', 'KM', '269', '2021-08-10 08:00:11'),
(49, 'جمهورية الكونغو', 'Republic Of The Congo', 'CG', '242', '2021-08-10 08:00:11'),
(50, 'جمهورية الكونغو الديمقراطية', 'Democratic Republic Of The Congo', 'CD', '242', '2021-08-10 08:00:11'),
(51, 'Cook Islands', 'Cook Islands', 'CK', '682', '2021-08-10 08:00:11'),
(52, 'كوستاريكا', 'Costa Rica', 'CR', '506', '2021-08-10 08:00:11'),
(53, 'كوت ديفوار', 'Cote D Ivoire (Ivory Coast)', 'CI', '225', '2021-08-10 08:00:11'),
(54, 'كرواتيا', 'Croatia (Hrvatska)', 'HR', '385', '2021-08-10 08:00:11'),
(55, 'كوبا', 'Cuba', 'CU', '53', '2021-08-10 08:00:11'),
(56, 'قبرص', 'Cyprus', 'CY', '357', '2021-08-10 08:00:11'),
(57, 'جمهورية التشيك', 'Czech Republic', 'CZ', '420', '2021-08-10 08:00:11'),
(58, 'الدنمارك', 'Denmark', 'DK', '45', '2021-08-10 08:00:11'),
(59, 'جيبوتى', 'Djibouti', 'DJ', '253', '2021-08-10 08:00:11'),
(60, 'دومينيكا', 'Dominica', 'DM', '1767', '2021-08-10 08:00:11'),
(61, 'الدومينيكان', 'Dominican Republic', 'DO', '1809', '2021-08-10 08:00:11'),
(62, 'تيمور الشرقية', 'East Timor', 'TP', '670', '2021-08-10 08:00:11'),
(63, 'الاكوادور', 'Ecuador', 'EC', '593', '2021-08-10 08:00:11'),
(64, 'مصر', 'Egypt', 'EG', '20', NULL),
(65, 'السلفادور', 'El Salvador', 'SV', '503', '2021-08-10 08:00:11'),
(66, 'غينيا الاستوائية', 'Equatorial Guinea', 'GQ', '240', '2021-08-10 08:00:11'),
(67, 'اريتريا', 'Eritrea', 'ER', '291', '2021-08-10 08:00:11'),
(68, 'استونيا', 'Estonia', 'EE', '372', '2021-08-10 08:00:11'),
(69, 'اثيوبيا', 'Ethiopia', 'ET', '251', '2021-08-10 08:00:11'),
(70, 'External Territories of Australia', 'External Territories of Australia', 'XA', '61', '2021-08-10 08:00:11'),
(71, 'Falkland Islands', 'Falkland Islands', 'FK', '500', '2021-08-10 08:00:11'),
(72, 'Faroe Islands', 'Faroe Islands', 'FO', '298', '2021-08-10 08:00:11'),
(73, 'جزر فيجى', 'Fiji Islands', 'FJ', '679', '2021-08-10 08:00:11'),
(74, 'فنلندا', 'Finland', 'FI', '358', '2021-08-10 08:00:11'),
(75, 'فرنسا', 'France', 'FR', '33', '2021-08-10 08:00:11'),
(76, 'French Guiana', 'French Guiana', 'GF', '594', '2021-08-10 08:00:11'),
(77, 'French Polynesia', 'French Polynesia', 'PF', '689', '2021-08-10 08:00:11'),
(78, 'French Southern Territories', 'French Southern Territories', 'TF', '0', '2021-08-10 08:00:11'),
(79, 'الجابون', 'Gabon', 'GA', '241', '2021-08-10 08:00:11'),
(80, 'جامبيا', 'The Gambia', 'GM', '220', '2021-08-10 08:00:11'),
(81, 'جورجيا', 'Georgia', 'GE', '995', '2021-08-10 08:00:11'),
(82, 'المانيا', 'Germany', 'DE', '49', '2021-08-10 08:00:11'),
(83, 'غانا', 'Ghana', 'GH', '233', '2021-08-10 08:00:11'),
(84, 'Gibraltar', 'Gibraltar', 'GI', '350', '2021-08-10 08:00:11'),
(85, 'اليونان', 'Greece', 'GR', '30', '2021-08-10 08:00:11'),
(86, 'Greenland', 'Greenland', 'GL', '299', '2021-08-10 08:00:11'),
(87, 'جرانادا', 'Grenada', 'GD', '1473', '2021-08-10 08:00:11'),
(88, 'Guadeloupe', 'Guadeloupe', 'GP', '590', '2021-08-10 08:00:11'),
(89, 'Guam', 'Guam', 'GU', '1671', '2021-08-10 08:00:11'),
(90, 'جواتيمالا', 'Guatemala', 'GT', '502', '2021-08-10 08:00:11'),
(91, 'Guernsey and Alderney', 'Guernsey and Alderney', 'XU', '44', '2021-08-10 08:00:11'),
(92, 'غينيا', 'Guinea', 'GN', '224', '2021-08-10 08:00:11'),
(93, 'غينيا بيساو', 'Guinea-Bissau', 'GW', '245', '2021-08-10 08:00:11'),
(94, 'جويانا	', 'Guyana', 'GY', '592', '2021-08-10 08:00:11'),
(95, 'هايتى', 'Haiti', 'HT', '509', '2021-08-10 08:00:11'),
(96, 'Heard and McDonald Islands', 'Heard and McDonald Islands', 'HM', '0', '2021-08-10 08:00:11'),
(97, 'هندوراس', 'Honduras', 'HN', '504', '2021-08-10 08:00:11'),
(98, 'Hong Kong S.A.R.', 'Hong Kong S.A.R.', 'HK', '852', '2021-08-10 08:00:11'),
(99, 'المجر', 'Hungary', 'HU', '36', '2021-08-10 08:00:11'),
(100, 'ايسلندا', 'Iceland', 'IS', '354', '2021-08-10 08:00:11'),
(101, 'الهند', 'India', 'IN', '91', '2021-08-10 08:00:11'),
(102, 'اندونيسيا', 'Indonesia', '', '62', '2021-08-10 08:00:11'),
(103, 'ايران', 'Iran', 'IR', '98', '2021-08-10 08:00:11'),
(104, 'العراق', 'Iraq', 'IQ', '964', '2021-08-10 08:00:11'),
(105, 'ايرلندا', 'Ireland', 'IE', '353', '2021-08-10 08:00:11'),
(106, 'ايطاليا', 'Italy', 'IT', '39', '2021-08-10 08:00:11'),
(107, 'جاميكا', 'Jamaica', 'JM', '1876', '2021-08-10 08:00:11'),
(108, 'اليابان', 'Japan', 'JP', '81', '2021-08-10 08:00:11'),
(109, 'Jersey', 'Jersey', 'XJ', '44', '2021-08-10 08:00:11'),
(110, 'الاردن', 'Jordan', 'JO', '962', '2021-08-10 08:00:11'),
(111, 'كازاخستان', 'Kazakhstan', 'KZ', '7', '2021-08-10 08:00:11'),
(112, 'كينيا', 'Kenya', 'KE', '254', '2021-08-10 08:00:11'),
(113, 'كيريباتى', 'Kiribati', 'KI', '686', '2021-08-10 08:00:11'),
(114, 'كوريا الشمالية', 'Korea North', 'KP', '850', '2021-08-10 08:00:11'),
(115, 'كوريا الجنوبية', 'Korea South', 'KR', '82', '2021-08-10 08:00:11'),
(116, 'الكويت', 'Kuwait', 'KW', '965', '2021-08-10 08:00:11'),
(117, 'قرغيزستان', 'Kyrgyzstan', 'KG', '996', '2021-08-10 08:00:11'),
(118, 'لاوس', 'Laos', 'LA', '856', '2021-08-10 08:00:11'),
(119, 'لاتفيا', 'Latvia', 'LV', '371', '2021-08-10 08:00:11'),
(120, 'لُبنان', 'Lebanon', 'LB', '961', '2021-08-10 08:00:11'),
(121, 'ليسوتو', 'Lesotho', 'LS', '266', '2021-08-10 08:00:11'),
(122, 'ليبيريا', 'Liberia', 'LR', '231', '2021-08-10 08:00:11'),
(123, 'ليبيا', 'Libya', 'LY', '218', '2021-08-10 08:00:11'),
(124, 'ليختنشتاين', 'Liechtenstein', 'LI', '423', '2021-08-10 08:00:11'),
(125, 'ليتوانيا', 'Lithuania', 'LT', '370', '2021-08-10 08:00:11'),
(126, 'لوكسمبورج', 'Luxembourg', 'LU', '352', '2021-08-10 08:00:11'),
(127, 'Macau S.A.R.', 'Macau S.A.R.', 'MO', '853', '2021-08-10 08:00:11'),
(128, 'مقدونيا', 'Macedonia', 'MK', '389', '2021-08-10 08:00:11'),
(129, 'مدغشقر', 'Madagascar', 'MG', '261', '2021-08-10 08:00:11'),
(130, 'مالاوى', 'Malawi', 'MW', '265', '2021-08-10 08:00:11'),
(131, 'ماليزيا', 'Malaysia', 'MY', '60', '2021-08-10 08:00:11'),
(132, 'جزر المالديف', 'Maldives', 'MV', '960', '2021-08-10 08:00:11'),
(133, 'مالى', 'Mali', 'ML', '223', '2021-08-10 08:00:11'),
(134, 'جزيرة مالطا', 'Malta', 'MT', '356', '2021-08-10 08:00:11'),
(135, 'Man (Isle of)', 'Man (Isle of)', 'XM', '44', '2021-08-10 08:00:11'),
(136, 'جزر مارشال', 'Marshall Islands', 'MH', '692', '2021-08-10 08:00:11'),
(137, 'Martinique', 'Martinique', 'MQ', '596', '2021-08-10 08:00:11'),
(138, 'موريتانيا', 'Mauritania', 'MR', '222', '2021-08-10 08:00:11'),
(139, 'موريشيوس', 'Mauritius', 'MU', '230', '2021-08-10 08:00:11'),
(140, 'Mayotte', 'Mayotte', 'YT', '269', '2021-08-10 08:00:11'),
(141, 'المكسيك', 'Mexico', 'MX', '52', '2021-08-10 08:00:11'),
(142, 'جزر مايكرونيزيا', 'Micronesia', 'FM', '691', '2021-08-10 08:00:11'),
(143, 'مولدوفيا', 'Moldova', 'MD', '373', '2021-08-10 08:00:11'),
(144, 'امارة موناكو', 'Monaco', 'MC', '377', '2021-08-10 08:00:11'),
(145, 'منغوليا', 'Mongolia', 'MN', '976', '2021-08-10 08:00:11'),
(146, 'Montserrat', 'Montserrat', 'MS', '1664', '2021-08-10 08:00:11'),
(147, 'المغرب', 'Morocco', 'MA', '212', '2021-08-10 08:00:11'),
(148, 'موزمبيق', 'Mozambique', 'MZ', '258', '2021-08-10 08:00:11'),
(149, 'ميانمار (بورما)', 'Myanmar (Burma)', 'MM', '95', '2021-08-10 08:00:11'),
(150, 'ناميبيا', 'Namibia', 'NA', '264', '2021-08-10 08:00:11'),
(151, 'ناورو', 'Nauru', 'NR', '674', '2021-08-10 08:00:11'),
(152, 'نيبال', 'Nepal', 'NP', '977', '2021-08-10 08:00:11'),
(153, 'Netherlands Antilles', 'Netherlands Antilles', 'AN', '599', '2021-08-10 08:00:11'),
(154, 'هولندا', 'Netherlands', 'NL', '31', '2021-08-10 08:00:11'),
(155, 'New Caledonia', 'New Caledonia', 'NC', '687', '2021-08-10 08:00:11'),
(156, 'نيوزيلندا', 'New Zealand', 'NZ', '64', '2021-08-10 08:00:11'),
(157, 'نيكاراجوا', 'Nicaragua', 'NI', '505', '2021-08-10 08:00:11'),
(158, 'النيجر', 'Niger', 'NE', '227', '2021-08-10 08:00:11'),
(159, 'نيجيريا', 'Nigeria', 'NG', '234', '2021-08-10 08:00:11'),
(160, 'Niue', 'Niue', 'NU', '683', '2021-08-10 08:00:11'),
(161, 'Norfolk Island', 'Norfolk Island', 'NF', '672', '2021-08-10 08:00:11'),
(162, 'Northern Mariana Islands', 'Northern Mariana Islands', 'MP', '1670', '2021-08-10 08:00:11'),
(163, 'النرويج', 'Norway', 'NO', '47', '2021-08-10 08:00:11'),
(164, 'سَلْطَنَة عُمان', 'Oman', 'OM', '968', '2021-08-10 08:00:11'),
(165, 'باكستان', 'Pakistan', 'PK', '92', '2021-08-10 08:00:11'),
(166, 'بالو', 'Palau', 'PW', '680', '2021-08-10 08:00:11'),
(167, 'فلسطين (الأراضي الفلسطينية المحتلة)', 'Palestine (Palestinian Territory Occupied)', 'PS', '970', '2021-08-10 08:00:11'),
(168, 'بنما', 'Panama', 'PA', '507', '2021-08-10 08:00:11'),
(169, 'بابوا غينيا الجديدة', 'Papua new Guinea', 'PG', '675', '2021-08-10 08:00:11'),
(170, 'باراجوى', 'Paraguay', 'PY', '595', '2021-08-10 08:00:11'),
(171, 'بيرو', 'Peru', 'PE', '51', '2021-08-10 08:00:11'),
(172, 'الفلبين', 'Philippines', 'PH', '63', '2021-08-10 08:00:11'),
(173, 'Pitcairn Island', 'Pitcairn Island', 'PN', '0', '2021-08-10 08:00:11'),
(174, 'بولندا', 'Poland', 'PL', '48', '2021-08-10 08:00:11'),
(175, 'البرتغال', 'Portugal', 'PT', '351', '2021-08-10 08:00:11'),
(176, 'Puerto Rico', 'Puerto Rico', 'PR', '1787', '2021-08-10 08:00:11'),
(177, 'قطر', 'Qatar', 'QA', '974', '2021-08-10 08:00:11'),
(178, 'Reunion', 'Reunion', 'RE', '262', '2021-08-10 08:00:11'),
(179, 'رومانيا', 'Romania', 'RO', '40', '2021-08-10 08:00:11'),
(180, 'روسيا الاتحادية', 'Russia', 'RU', '70', '2021-08-10 08:00:11'),
(181, 'رواندا', 'Rwanda', 'RW', '250', '2021-08-10 08:00:11'),
(182, 'Saint Helena', 'Saint Helena', 'SH', '290', '2021-08-10 08:00:11'),
(183, 'سان كيتس اند نيفز', 'Saint Kitts And Nevis', 'KN', '1869', '2021-08-10 08:00:11'),
(184, 'سان لوتشيا', 'Saint Lucia', 'LC', '1758', '2021-08-10 08:00:11'),
(185, 'Saint Pierre and Miquelon', 'Saint Pierre and Miquelon', 'PM', '508', '2021-08-10 08:00:11'),
(186, 'سان فنسن وجرينادينز', 'Saint Vincent And The Grenadines', 'VC', '1784', '2021-08-10 08:00:11'),
(187, 'ساموا', 'Samoa', 'WS', '684', '2021-08-10 08:00:11'),
(188, 'سان مارينو', 'San Marino', 'SM', '378', '2021-08-10 08:00:11'),
(189, 'ساوتومى اند برنسيب', 'Sao Tome and Principe', 'ST', '239', '2021-08-10 08:00:11'),
(190, 'السعودية', 'Saudi Arabia', 'SA', '966', '2021-08-10 08:00:11'),
(191, 'السنغال', 'Senegal', 'SN', '221', '2021-08-10 08:00:11'),
(192, 'صربيا', 'Serbia', 'RS', '381', '2021-08-10 08:00:11'),
(193, 'جزر سيشل', 'Seychelles', 'SC', '248', '2021-08-10 08:00:11'),
(194, 'سيراليون', 'Sierra Leone', 'SL', '232', '2021-08-10 08:00:11'),
(195, 'سنغافورة', 'Singapore', 'SG', '65', '2021-08-10 08:00:11'),
(196, 'سلوفاكيا', 'Slovakia', 'SK', '421', '2021-08-10 08:00:11'),
(197, 'سلوفينيا', 'Slovenia', 'SI', '386', '2021-08-10 08:00:11'),
(198, 'Smaller Territories of the UK', 'Smaller Territories of the UK', 'XG', '44', '2021-08-10 08:00:11'),
(199, 'جزر سولومون', 'Solomon Islands', 'SB', '677', '2021-08-10 08:00:11'),
(200, 'الصومال', 'Somalia', 'SO', '252', '2021-08-10 08:00:11'),
(201, 'جنوب افريقيا', 'South Africa', 'ZA', '27', '2021-08-10 08:00:11'),
(202, 'South Georgia', 'South Georgia', 'GS', '0', '2021-08-10 08:00:11'),
(203, 'South Sudan', 'South Sudan', 'SS', '211', '2021-08-10 08:00:11'),
(204, 'إسبانيا', 'Spain', 'ES', '34', '2021-08-10 08:00:11'),
(205, 'سريلانكا', 'Sri Lanka', 'LK', '94', '2021-08-10 08:00:11'),
(206, 'السودان', 'Sudan', 'SD', '249', '2021-08-10 08:00:11'),
(207, 'سورينام', 'Suriname', 'SR', '597', '2021-08-10 08:00:11'),
(208, 'Svalbard And Jan Mayen Islands', 'Svalbard And Jan Mayen Islands', 'SJ', '47', '2021-08-10 08:00:11'),
(209, 'سوازيلاند', 'Swaziland', 'SZ', '268', '2021-08-10 08:00:11'),
(210, 'السويد', 'Sweden', 'SE', '46', '2021-08-10 08:00:11'),
(211, 'سويسرا', 'Switzerland', 'CH', '41', '2021-08-10 08:00:11'),
(212, 'سوريا', 'Syria', 'SY', '963', '2021-08-10 08:00:11'),
(213, 'تايوان', 'Taiwan', 'TW', '886', '2021-08-10 08:00:11'),
(214, 'طاجكستان', 'Tajikistan', 'TJ', '992', '2021-08-10 08:00:11'),
(215, 'تنزانيا', 'Tanzania', 'TZ', '255', '2021-08-10 08:00:11'),
(216, 'تايلاند', 'Thailand', 'TH', '66', '2021-08-10 08:00:11'),
(217, 'توجو', 'Togo', 'TG', '228', '2021-08-10 08:00:11'),
(218, 'Tokelau', 'Tokelau', 'TK', '690', '2021-08-10 08:00:11'),
(219, 'تونجا', 'Tonga', 'TO', '676', '2021-08-10 08:00:11'),
(220, 'ترينداد وتوباغو', 'Trinad And Tobago', 'TT', '1868', '2021-08-10 08:00:11'),
(221, 'تونِس', 'Tunisia', 'TN', '216', '2021-08-10 08:00:11'),
(222, 'تركيا', 'Turkey', 'TR', '90', '2021-08-10 08:00:11'),
(223, 'تركمانستان', 'Turkmenistan', 'TM', '7370', '2021-08-10 08:00:11'),
(224, 'Turks And Caicos Islands', 'Turks And Caicos Islands', 'TC', '1649', '2021-08-10 08:00:11'),
(225, 'توفالو', 'Tuvalu', 'TV', '688', '2021-08-10 08:00:11'),
(226, 'اوغندا', 'Uganda', 'UG', '256', '2021-08-10 08:00:11'),
(227, 'اوكرانيا', 'Ukraine', 'UA', '380', '2021-08-10 08:00:11'),
(228, 'الامارات العربية المتحدة', 'United Arab Emirates', 'AE', '971', '2021-08-10 08:00:11'),
(229, 'المملكة المتحدة', 'United Kingdom', 'GB', '44', '2021-08-10 08:00:11'),
(230, 'الولايات المتحدة الامريكية', 'United States', 'US', '1', '2021-08-10 08:00:11'),
(231, 'United States Minor Outlying Islands', 'United States Minor Outlying Islands', 'UM', '1', '2021-08-10 08:00:11'),
(232, 'اورجواى', 'Uruguay', 'UY', '598', '2021-08-10 08:00:11'),
(233, 'اوزباكستان', 'Uzbekistan', 'UZ', '998', '2021-08-10 08:00:11'),
(234, 'فانواتو', 'Vanuatu', 'VU', '678', '2021-08-10 08:00:11'),
(235, 'الفاتيكان', 'Vatican City State (Holy See)', 'VA', '39', '2021-08-10 08:00:11'),
(236, 'فنزويلا', 'Venezuela', 'VE', '58', '2021-08-10 08:00:11'),
(237, 'فيتنام', 'Vietnam', 'VN', '84', '2021-08-10 08:00:11'),
(238, 'Virgin Islands (British)', 'Virgin Islands (British)', 'VG', '1284', '2021-08-10 08:00:11'),
(239, 'Virgin Islands (US)', 'Virgin Islands (US)', 'VI', '1340', '2021-08-10 08:00:11'),
(240, 'Wallis And Futuna Islands', 'Wallis And Futuna Islands', 'WF', '681', '2021-08-10 08:00:11'),
(241, 'Western Sahara', 'Western Sahara', 'EH', '212', '2021-08-10 08:00:11'),
(242, 'اليمن', 'Yemen', 'YE', '967', '2021-08-10 08:00:11'),
(243, 'Yugoslavia', 'Yugoslavia', 'YU', '38', '2021-08-10 08:00:11'),
(244, 'زامبيا', 'Zambia', 'ZM', '260', '2021-08-10 08:00:11'),
(245, 'زيمبابوى', 'Zimbabwe', 'ZW', '26', '2021-08-10 08:00:11');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sector_id` bigint(20) UNSIGNED NOT NULL,
  `manager_id` bigint(20) UNSIGNED NOT NULL,
  `delegated_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name_ar`, `name_en`, `sector_id`, `manager_id`, `delegated_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'تكنولوجيا المعلومات', 'Information Technology (IT)', 3, 5, 1, NULL, '2022-03-28 09:21:16', '2022-03-28 09:21:16'),
(2, 'الموارد البشرية', 'Human resources (HR)', 3, 6, 1, NULL, '2022-03-28 09:21:17', '2022-03-28 09:21:17'),
(3, 'شؤون الأفراد', 'Personnel', 3, 7, 1, NULL, '2022-03-28 09:21:17', '2022-03-28 09:21:17'),
(4, 'تسويق', 'Marketing', 3, 8, 1, NULL, '2022-03-28 09:21:17', '2022-03-28 09:21:17'),
(5, 'الحسابات الدائنة', 'Accounts Payable', 4, 9, 1, NULL, '2022-03-28 09:21:18', '2022-03-28 09:21:18'),
(6, 'الحسابات', 'Accounting', 4, 10, 1, NULL, '2022-03-28 09:21:18', '2022-03-28 09:21:18'),
(7, 'الحسابات', 'Cost', 4, 11, 1, NULL, '2022-03-28 09:21:18', '2022-03-28 09:21:18'),
(8, 'المراجعة', 'Audit', 4, 12, 1, NULL, '2022-03-28 09:21:19', '2022-03-28 09:21:19'),
(9, 'غرفة النقدية', 'Cash Room', 4, 13, 1, NULL, '2022-03-28 09:21:19', '2022-03-28 09:21:19'),
(10, 'المرتبات', 'Payroll', 4, 14, 1, NULL, '2022-03-28 09:21:19', '2022-03-28 09:21:19'),
(11, 'الضرائب', 'Taxation', 4, 15, 1, NULL, '2022-03-28 09:21:19', '2022-03-28 09:21:19'),
(12, 'المناقصات', 'Tendering', 5, 17, 1, NULL, '2022-03-28 09:21:20', '2022-03-28 09:21:20'),
(13, 'أعمال جديدة', 'New Business', 5, 18, 1, NULL, '2022-03-28 09:21:20', '2022-03-28 09:21:20'),
(14, 'التصميم', 'Design', 5, 19, 1, NULL, '2022-03-28 09:21:21', '2022-03-28 09:21:21'),
(15, 'المشتريات الداخلية', 'Internal Purchasing', 6, 21, 1, NULL, '2022-03-28 09:21:21', '2022-03-28 09:21:21'),
(16, 'المشتريات الخارجية', 'External Purchasing', 6, 22, 1, NULL, '2022-03-28 09:21:21', '2022-03-28 09:21:21'),
(17, 'المكتب الفني المدني', 'Civil Technical Office', 7, 23, 1, NULL, '2022-03-28 09:21:22', '2022-03-28 09:21:22'),
(18, 'تخطيط و متابعة الإنشاء', 'Construction Planning & Follow Up', 8, 35, 1, NULL, '2022-03-28 09:21:23', '2022-03-28 09:21:23'),
(19, 'المكتب الفني للميكانيكا والكهرباء والسباكة', 'MEP Technical Office', 9, 36, 1, NULL, '2022-03-28 09:21:24', '2022-03-28 09:21:24'),
(20, 'إدارة مقاولي الباطن', 'Subcontractors Management', 10, 44, 1, NULL, '2022-03-28 09:21:25', '2022-03-28 09:21:25'),
(21, 'الإشارة العسكرية', 'Military Signal', 11, 46, 1, NULL, '2022-03-28 09:21:25', '2022-03-28 09:21:25'),
(22, 'تطوير الاعمال', 'Business Development', 20, 74, 1, NULL, '2022-03-28 09:21:31', '2022-03-28 09:21:31');

-- --------------------------------------------------------

--
-- Table structure for table `discount_types`
--

CREATE TABLE `discount_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discount_types`
--

INSERT INTO `discount_types` (`id`, `name_en`, `name_ar`, `code`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'undefined', 'غير محدد', '1', NULL, '2022-03-28 09:21:47', '2022-03-28 09:21:47'),
(2, 'returns', 'مردودات', '2', NULL, '2022-03-28 09:21:47', '2022-03-28 09:21:47'),
(3, 'commercial response', 'رد تجاري', '3', NULL, '2022-03-28 09:21:47', '2022-03-28 09:21:47'),
(4, 'Discount permitted', 'خصم مسموح به', '4', NULL, '2022-03-28 09:21:47', '2022-03-28 09:21:47'),
(5, 'advance payments', 'دفعات مقدمة', '5', NULL, '2022-03-28 09:21:48', '2022-03-28 09:21:48'),
(6, 'Exemption', 'اعفاء', '6', NULL, '2022-03-28 09:21:48', '2022-03-28 09:21:48');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `family_names`
--

CREATE TABLE `family_names` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(355) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(355) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_group_id` bigint(20) UNSIGNED NOT NULL,
  `both` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `family_names`
--

INSERT INTO `family_names` (`id`, `name_ar`, `name_en`, `sub_group_id`, `both`, `deleted_at`) VALUES
(1, 'حديد تسليح أقطار متنوعة', 'Rebar of various diameters', 1, 0, NULL),
(2, 'أسمنت + جبس بأنواعهم', 'Cement + gypsum of all kinds', 1, 0, NULL),
(3, 'عزل رطوبة + منشآت مائية بأنواعهم', 'Moisture insulation + water installations of all kinds', 1, 0, NULL),
(4, 'عزل حرارة', 'heat insulation', 1, 0, NULL),
(5, 'حماية عزل', 'insulation protection', 1, 0, NULL),
(6, 'بلوك + طوب أسمنتي بأنواعها', 'Block + cement bricks of all kinds', 1, 0, NULL),
(7, 'بردورات + إنترلوك بأنواعه', 'Borders + all kinds of interlocks', 1, 0, NULL),
(8, 'كيماويات بناء + إضافات للخرسانة بأنواعها', 'Building chemicals + additives for all kinds of concrete', 1, 0, NULL),
(9, 'دهانات إيبوكسية', 'epoxy paints', 2, 0, NULL),
(10, 'دهانات بلاستيك بأنواعها + معجون', 'Plastic paints of all kinds + putty', 2, 0, NULL),
(11, 'دهانات أسمنتية', 'cement paints', 2, 0, NULL),
(12, 'كرانيش فيوتك + اللاصق', 'Futech crunchy + adhesive', 2, 0, NULL),
(13, 'سيراميك حوائط + أرضيات بأنواعه', 'Ceramic walls + floors of all kinds', 2, 0, NULL),
(14, 'بلاط متنوع شامل الوزر', 'Assorted tiles, including all sizes', 2, 0, NULL),
(15, 'رخام بأنواعه', 'All kinds of marble', 2, 0, NULL),
(16, 'مرابات', 'Marbat', 2, 0, NULL),
(17, 'مواسير حديد سيملس', 'Seamless iron pipes', 3, 0, NULL),
(18, 'وصلات خطوط مكافحة حريق - Grooved', 'Fire Fighting Line Joints - Grooved', 3, 0, NULL),
(19, 'وصلات خطوط مكافحة حريق - لحام', 'Fire Fighting Lines Connections - Welding', 3, 0, NULL),
(20, 'كابينة مكافحة حريق + إكسسوارات متنوعة', 'Fire fighting cabin + various accessories', 3, 0, NULL),
(21, 'نظام إطفاء حريق بالغازات', 'Gas fire extinguishing system', 3, 0, NULL),
(22, 'مواسير EMT + إكسسواراتها', 'EMT Pipes + Accessories', 3, 0, NULL),
(23, 'مواسير كهرباء + إكسسواراتها', 'Electrical pipes + accessories', 4, 0, NULL),
(24, 'أسلاك متنوعة', 'Various wires', 4, 0, NULL),
(25, 'كابلات نحاس', 'copper cables', 4, 0, NULL),
(26, 'كابلات ألومنيوم', 'aluminum cables', 4, 0, NULL),
(27, 'كابلات سماعات + تليفون + كنترول', 'Headphones + phone + control cables', 4, 0, NULL),
(28, 'كشافات ولوازمها', 'Headlights and accessories', 4, 0, NULL),
(29, 'لقم كهرباء + مفاتيح + أوجه', 'Electric bits + switches + faces', 4, 0, NULL),
(30, 'أجهزة كهربائية', 'Electrical devices', 4, 0, NULL),
(31, 'قواطع تيار بأنواعها', 'All kinds of circuit breakers', 4, 0, NULL),
(32, 'حوامل كابلات بأنواعها وإكسسواراتها', 'Cable holders of all kinds and accessories', 4, 0, NULL),
(33, 'أعمدة إنارة', 'lampposts', 4, 0, NULL),
(34, 'مواسير تغذية بولي بروبيلين PR + وصلاتها', 'PR Polypropylene Feeding Pipes + Fittings', 5, 0, NULL),
(35, 'مواسير UPVC + وصلات', 'UPVC Pipes + Couplings', 5, 0, NULL),
(36, 'مواسير HDPE + وصلات', 'HDPE pipes + fittings', 5, 0, NULL),
(37, 'طلمبات مياه', 'water pumps', 5, 0, NULL),
(38, 'أجهزة صحية', 'health appliances', 5, 0, NULL),
(39, 'غرف ولوازم صرف + إكسسواراتها', 'Rooms and exchange supplies + accessories', 5, 0, NULL),
(40, 'أمن وسلامة', 'Security and safety', 8, 0, NULL),
(41, 'كرفانات + أثاث + معدات إعاشة', 'Caravans + furniture + catering equipment', 8, 0, NULL),
(42, 'أجهزة مساحية بمشتملاتها', 'Surveying equipment and its contents', 8, 0, NULL),
(43, 'أمن وسلامة', 'Security and safety', 7, 0, NULL),
(44, 'كرفانات + أثاث + معدات إعاشة', 'Caravans + furniture + catering equipment', 7, 0, NULL),
(45, 'أجهزة مساحية بمشتملاتها', 'Surveying equipment and its contents', 7, 0, NULL),
(46, 'سلك شبك للمباني', 'wire mesh for buildings', 10, 0, NULL),
(47, 'باك رود', 'Back Road', 10, 0, NULL),
(48, 'سلك رباط', 'Wire bond', 10, 0, NULL),
(49, 'بسكوت خرسانة', 'concrete biscuits', 10, 0, NULL),
(50, 'ستيل فايبر', 'steel fiber', 10, 0, NULL),
(51, 'سلك شبك للمباني', 'wire mesh for buildings', 11, 0, NULL),
(52, 'باك رود', 'Back Road', 11, 0, NULL),
(53, 'سلك رباط', 'Wire bond', 11, 0, NULL),
(54, 'بسكوت خرسانة', 'concrete biscuits', 11, 0, NULL),
(55, 'ستيل فايبر', 'steel fiber', 11, 0, NULL),
(56, 'زوايا', 'angles', 12, 0, NULL),
(57, 'مستهلك نحاس', 'copper consumer', 13, 0, NULL),
(58, 'ميكانات', 'mechanics', 14, 0, NULL),
(59, 'ديل', 'dell', 15, 0, NULL),
(60, 'HP', 'HP', 15, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `family_name_suppliers`
--

CREATE TABLE `family_name_suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `family_name_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `family_name_suppliers`
--

INSERT INTO `family_name_suppliers` (`id`, `supplier_id`, `family_name_id`) VALUES
(1, 1, 2),
(2, 1, 6),
(3, 1, 3),
(4, 1, 7),
(5, 1, 4),
(6, 1, 8),
(7, 2, 2),
(8, 2, 6),
(9, 2, 3),
(10, 2, 7),
(11, 2, 4),
(12, 2, 8),
(13, 3, 2),
(14, 3, 6),
(15, 3, 3),
(16, 3, 7),
(17, 3, 4),
(18, 3, 8),
(19, 4, 2),
(20, 4, 6),
(21, 4, 3),
(22, 4, 7),
(23, 4, 4),
(24, 4, 8),
(25, 5, 2),
(26, 5, 6),
(27, 5, 3),
(28, 5, 7),
(29, 5, 4),
(30, 5, 8),
(31, 6, 2),
(32, 6, 6),
(33, 6, 3),
(34, 6, 7),
(35, 6, 4),
(36, 6, 8),
(37, 7, 2),
(38, 7, 6),
(39, 7, 3),
(40, 7, 7),
(41, 7, 4),
(42, 7, 8),
(43, 8, 2),
(44, 8, 6),
(45, 8, 3),
(46, 8, 7),
(47, 8, 4),
(48, 8, 8),
(49, 9, 2),
(50, 9, 6),
(51, 9, 3),
(52, 9, 7),
(53, 9, 4),
(54, 9, 8),
(55, 10, 2),
(56, 10, 6),
(57, 10, 3),
(58, 10, 7),
(59, 10, 4),
(60, 10, 8);

-- --------------------------------------------------------

--
-- Table structure for table `file_purchase_orders`
--

CREATE TABLE `file_purchase_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `file_refused` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_order_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `file_purchase_requests`
--

CREATE TABLE `file_purchase_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_request_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `governorates`
--

CREATE TABLE `governorates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `governorates`
--

INSERT INTO `governorates` (`id`, `name_ar`, `name_en`, `country_id`, `deleted_at`) VALUES
(1, 'الإسكندرية', 'Alexandria', 64, NULL),
(2, 'الإسماعيلية', 'Ismailia', 64, NULL),
(3, 'أسوان', 'Aswan', 64, NULL),
(4, 'أسيوط', 'Asyut', 64, NULL),
(5, 'الأقصر', 'Luxor', 64, NULL),
(6, 'البحر الأحمر', 'Red Sea', 64, NULL),
(7, 'البحيرة', 'Beheira', 64, NULL),
(8, 'بني سويف', 'Beni Suef', 64, NULL),
(9, 'بورسعيد', 'Port Said', 64, NULL),
(10, 'جنوب سيناء', 'South Sinai', 64, NULL),
(11, 'الجيزة', 'Giza', 64, NULL),
(12, 'الدقهلية', 'Dakahlia', 64, NULL),
(13, 'دمياط', 'Damietta', 64, NULL),
(14, 'سوهاج', 'Sohag', 64, NULL),
(15, 'السويس', 'Suez', 64, NULL),
(16, 'الشرقية', 'Sharqia', 64, NULL),
(17, 'شمال سيناء', 'North Sinai', 64, NULL),
(18, 'الغربية', 'Gharbia', 64, NULL),
(19, 'الفيوم', 'Fayoum', 64, NULL),
(20, 'القاهرة', 'Cairo', 64, NULL),
(21, 'القليوبية', 'Qalyubia', 64, NULL),
(22, 'قنا', 'Qena', 64, NULL),
(23, 'كفر الشيخ', 'Kafr el-Sheikh', 64, NULL),
(24, 'مطروح', 'Matruh', 64, NULL),
(25, 'المنوفية', 'Monufia', 64, NULL),
(26, 'المنيا', 'Minya', 64, NULL),
(27, 'الوادي الجديد', 'New Valley', 64, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `both` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name_ar`, `name_en`, `code`, `both`, `deleted_at`) VALUES
(1, 'البناء - المدني', 'Construction - Civil', 'C_Civil', 0, NULL),
(2, 'البناء - الهندسة الكهربائية والميكانيكية', 'Construction - MEP', 'C_MEP', 0, NULL),
(3, 'البناء - المدني & الهندسة الكهربائية والميكانيكية', 'Construction - Civil & MEP', 'C_CivilMEP', 1, NULL),
(4, 'تكنولوجيا المعلومات', 'IT', 'IT-01', 0, NULL),
(5, 'Stationary Ar', 'Stationary', 'stationary', 0, NULL),
(6, 'المكاتب', 'Desks', 'desks', 0, NULL),
(7, 'المصنع', 'factory', 'factory', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inquiry_purchase_requests`
--

CREATE TABLE `inquiry_purchase_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_request_id` bigint(20) UNSIGNED DEFAULT NULL,
  `item_request_id` bigint(20) UNSIGNED DEFAULT NULL,
  `send_message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receive_message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `edit_item` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approve` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `send_id` bigint(20) UNSIGNED DEFAULT NULL,
  `receive_id` bigint(20) UNSIGNED DEFAULT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alternate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `technical_office` int(11) NOT NULL,
  `approve_technical_office` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `aprove_first_date` datetime DEFAULT NULL,
  `aprove_last_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `project_id` bigint(20) UNSIGNED DEFAULT NULL,
  `business_nature_id` bigint(20) UNSIGNED DEFAULT NULL,
  `covenant_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detection_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `po_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date_invoice` date DEFAULT NULL,
  `invoice_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `specifications` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL DEFAULT 1,
  `total` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value_tax_rate` int(11) DEFAULT NULL,
  `value_tax` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `overall_total` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `other_discount` int(11) DEFAULT NULL,
  `total_after_discount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `restrained_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'not_restrained',
  `nature_dealing_id` bigint(20) UNSIGNED DEFAULT NULL,
  `expense_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'cashe',
  `tax_deduction` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_deduction_value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `net_total` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `business_insurance_rate` int(11) DEFAULT NULL,
  `business_insurance_value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `net_total_after_business_insurance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name_en`, `name_ar`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'operating expenses', 'مصروفات تشغليلية', NULL, '2022-03-28 09:21:43', '2022-03-28 09:21:43'),
(2, 'general expenses', 'مصروفات عمومية', NULL, '2022-03-28 09:21:43', '2022-03-28 09:21:43'),
(3, 'charges', 'شحنات', NULL, '2022-03-28 09:21:44', '2022-03-28 09:21:44');

-- --------------------------------------------------------

--
-- Table structure for table `item_orders`
--

CREATE TABLE `item_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_order_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `item_request_id` int(11) NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment_refuse` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT 1,
  `comment_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment_item_refuse` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `used_quantity` int(11) NOT NULL,
  `specification` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_new` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment_change_reason` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_requests`
--

CREATE TABLE `item_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_request_id` bigint(20) UNSIGNED NOT NULL,
  `family_name_id` bigint(20) UNSIGNED NOT NULL,
  `specification` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `stock_quantity` int(11) NOT NULL,
  `actual_quantity` int(11) NOT NULL,
  `used_quantity` int(11) NOT NULL,
  `comment_refuse` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `priority` enum('L','M','H') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'L: Low, M: Medium, H: High',
  `factory_specification` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reserved_quantity` int(11) DEFAULT NULL,
  `max_date_delivery` date DEFAULT NULL,
  `start_date_supply` date DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT 1,
  `edit_specification` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_codes`
--

CREATE TABLE `job_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_codes`
--

INSERT INTO `job_codes` (`id`, `code`, `department_id`, `deleted_at`) VALUES
(1, 'IT1', 1, NULL),
(2, 'IT2', 1, NULL),
(3, 'IT3', 1, NULL),
(4, 'IT4', 1, NULL),
(5, 'IT5', 1, NULL),
(6, 'IT6', 1, NULL),
(7, 'IT7', 1, NULL),
(8, 'IT8', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `job_grades`
--

CREATE TABLE `job_grades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `grade` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `job_code_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_grades`
--

INSERT INTO `job_grades` (`id`, `grade`, `job_code_id`, `deleted_at`) VALUES
(1, '29', 1, NULL),
(2, '28', 1, NULL),
(3, '27', 1, NULL),
(4, '26', 2, NULL),
(5, '25', 2, NULL),
(6, '24', 2, NULL),
(7, '23', 2, NULL),
(8, '22', 2, NULL),
(9, '21', 3, NULL),
(10, '20', 3, NULL),
(11, '19', 3, NULL),
(12, '18', 3, NULL),
(13, '17', 4, NULL),
(14, '16', 4, NULL),
(15, '15', 4, NULL),
(16, '14', 4, NULL),
(17, '13', 4, NULL),
(18, '12', 5, NULL),
(19, '11', 5, NULL),
(20, '10', 5, NULL),
(21, '9', 5, NULL),
(22, '8', 5, NULL),
(23, '7', 6, NULL),
(24, '6', 6, NULL),
(25, '5', 6, NULL),
(26, '4', 6, NULL),
(27, '3', 7, NULL),
(28, '2', 7, NULL),
(29, '1', 7, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `job_names`
--

CREATE TABLE `job_names` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `job_code_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_names`
--

INSERT INTO `job_names` (`id`, `name_ar`, `name_en`, `job_code_id`, `deleted_at`) VALUES
(1, 'أخصائي تكنولوجيا المعلومات المبتدئ', 'Junior IT Specialist', 1, NULL),
(2, 'متخصص في تكنولوجيا المعلومات', 'IT Specialist', 2, NULL),
(3, 'أخصائي أول في تكنولوجيا المعلومات', 'Senior IT Specialist', 3, NULL),
(4, 'قائد فريق تكنولوجيا المعلومات', 'IT Team Leader', 4, NULL),
(5, 'مدير مساعد تكنولوجيا المعلومات', 'IT Assistant Manager', 5, NULL),
(6, 'مدير تكنولوجيا المعلومات', 'IT Manager', 6, NULL),
(7, 'مدير أول لتكنولوجيا المعلومات', 'Senior IT Manager', 7, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `material_receipts`
--

CREATE TABLE `material_receipts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `recipient_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_order_id` bigint(20) UNSIGNED NOT NULL,
  `quantity_received` int(11) DEFAULT NULL,
  `receipt_number` int(11) NOT NULL,
  `recipient_date` datetime NOT NULL,
  `location` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

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
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2021_01_12_095417_create_items_table', 1),
(5, '2021_01_12_131659_create_business_natures_table', 1),
(6, '2021_07_29_110020_create_sectors_table', 1),
(7, '2021_08_01_071155_create_departments_table', 1),
(8, '2021_08_01_084128_add_sector_id_to_users', 1),
(9, '2021_08_01_084217_add_department_id_to_users', 1),
(10, '2021_08_02_070509_create_job_codes_table', 1),
(11, '2021_08_02_072434_create_job_grades_table', 1),
(12, '2021_08_02_072443_create_job_names_table', 1),
(13, '2021_08_02_084446_add_job_name_id_to_users', 1),
(14, '2021_08_02_084521_add_job_grade_id_to_users', 1),
(15, '2021_08_02_141827_create_countries_table', 1),
(16, '2021_08_02_141840_create_governorates_table', 1),
(17, '2021_08_22_090746_create_groups_table', 1),
(18, '2021_08_22_091309_create_sub_groups_table', 1),
(19, '2021_08_22_091448_create_family_names_table', 1),
(20, '2021_08_22_124158_create_projects_table', 1),
(21, '2021_08_22_140621_add_project_id_to_users_table', 1),
(22, '2021_08_23_090002_create_addresses_table', 1),
(23, '2021_08_23_090003_create_suppliers_table', 1),
(24, '2021_08_23_095053_create_person_suppliers_table', 1),
(25, '2021_08_23_101551_create_family_name_supplier_table', 1),
(26, '2021_08_23_102836_create_supplier_bank_transfers_table', 1),
(27, '2021_08_26_070952_create_supplier_cheques_table', 1),
(28, '2021_09_06_073537_create_units_table', 1),
(29, '2021_09_06_092308_create_sites_table', 1),
(30, '2021_09_07_070920_create_purchase_requests_table', 1),
(31, '2021_09_07_072905_create_item_requests_table', 1),
(32, '2021_09_21_074654_create_approval_cycles_table', 1),
(33, '2021_09_21_075124_create_approval_steps_table', 1),
(34, '2021_09_21_080243_create_approval_cycle_approval_steps_table', 1),
(35, '2021_09_21_080749_create_approval_timelines_table', 1),
(36, '2021_10_18_150117_create_approval_timeline_comments_table', 1),
(37, '2021_11_30_084415_create_purchase_orders_table', 1),
(38, '2021_11_30_085647_create_item_orders_table', 1),
(39, '2021_12_12_085959_create_file_purchase_orders_table', 1),
(40, '2022_01_10_090005_create_file_purchase_requests_table', 1),
(41, '2022_01_13_092518_create_discount_types_table', 1),
(42, '2022_01_13_092544_create_nature_dealings_table', 1),
(43, '2022_01_26_140202_create_inquiry_purchase_requests_table', 1),
(44, '2022_01_30_144606_create_permission_tables', 1),
(45, '2022_02_07_093740_create_invoices_table', 1),
(46, '2022_02_08_111414_create_material_receipts_table', 1),
(47, '2022_02_13_092713_create_banks_table', 1),
(48, '2022_02_13_140245_create_payment_invoices_table', 1),
(49, '2022_02_14_102014_create_account_statements_table', 1),
(50, '2022_02_23_090918_create_cheque_requests_table', 1),
(51, '2022_02_23_104606_create_cheque_item_requests_table', 1),
(52, '2022_03_22_125146_create_user_groups_table', 1),
(53, '2022_03_24_124013_add_delegated_to_users_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 77),
(2, 'App\\Models\\User', 78),
(2, 'App\\Models\\User', 79),
(3, 'App\\Models\\User', 80),
(3, 'App\\Models\\User', 81),
(3, 'App\\Models\\User', 82),
(3, 'App\\Models\\User', 83),
(3, 'App\\Models\\User', 84),
(3, 'App\\Models\\User', 85),
(3, 'App\\Models\\User', 86),
(3, 'App\\Models\\User', 87),
(4, 'App\\Models\\User', 21),
(4, 'App\\Models\\User', 22),
(5, 'App\\Models\\User', 20),
(6, 'App\\Models\\User', 12),
(6, 'App\\Models\\User', 88),
(6, 'App\\Models\\User', 89),
(6, 'App\\Models\\User', 90),
(6, 'App\\Models\\User', 91),
(6, 'App\\Models\\User', 92),
(7, 'App\\Models\\User', 11),
(7, 'App\\Models\\User', 93),
(7, 'App\\Models\\User', 94),
(7, 'App\\Models\\User', 95),
(8, 'App\\Models\\User', 47),
(8, 'App\\Models\\User', 48),
(8, 'App\\Models\\User', 49),
(8, 'App\\Models\\User', 54),
(8, 'App\\Models\\User', 59),
(8, 'App\\Models\\User', 62),
(8, 'App\\Models\\User', 76),
(8, 'App\\Models\\User', 96),
(8, 'App\\Models\\User', 97),
(8, 'App\\Models\\User', 98),
(9, 'App\\Models\\User', 63),
(9, 'App\\Models\\User', 64),
(10, 'App\\Models\\User', 24),
(10, 'App\\Models\\User', 25),
(10, 'App\\Models\\User', 26),
(10, 'App\\Models\\User', 27),
(10, 'App\\Models\\User', 28),
(10, 'App\\Models\\User', 29),
(10, 'App\\Models\\User', 30),
(10, 'App\\Models\\User', 31),
(10, 'App\\Models\\User', 32),
(10, 'App\\Models\\User', 33),
(11, 'App\\Models\\User', 37),
(11, 'App\\Models\\User', 38),
(11, 'App\\Models\\User', 39),
(11, 'App\\Models\\User', 40),
(11, 'App\\Models\\User', 41),
(11, 'App\\Models\\User', 42),
(17, 'App\\Models\\User', 2),
(17, 'App\\Models\\User', 4),
(18, 'App\\Models\\User', 23),
(19, 'App\\Models\\User', 36);

-- --------------------------------------------------------

--
-- Table structure for table `nature_dealings`
--

CREATE TABLE `nature_dealings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_type_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nature_dealings`
--

INSERT INTO `nature_dealings` (`id`, `name_en`, `name_ar`, `code`, `discount_type_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'supplies', 'التوريدات', '2', 1, NULL, '2022-03-28 09:21:48', '2022-03-28 09:21:48'),
(2, 'Purchases', 'المشتريات', '3', 1, NULL, '2022-03-28 09:21:48', '2022-03-28 09:21:48'),
(3, 'Unbound', 'غير مقيد', '22', 1, NULL, '2022-03-28 09:21:48', '2022-03-28 09:21:48'),
(4, 'Services', 'الخدمات', '4', 1, NULL, '2022-03-28 09:21:48', '2022-03-28 09:21:48'),
(5, 'professional fees', 'اتعاب مهنية', '10', 1, NULL, '2022-03-28 09:21:48', '2022-03-28 09:21:48'),
(6, 'employment', 'تشغيل', '21', 1, NULL, '2022-03-28 09:21:48', '2022-03-28 09:21:48'),
(7, 'Contracting', 'المقاولات', '1', 2, NULL, '2022-03-28 09:21:48', '2022-03-28 09:21:48'),
(8, 'Amounts paid by motor transport cooperative societies to their members', 'المبالغ التي تدفعها الجمعيات التعاونية للنقل بالسيارات لأعضائها ', '5', 1, NULL, '2022-03-28 09:21:48', '2022-03-28 09:21:48'),
(9, 'Agency with commission and brokerage', 'الوكالة بالعمولة و السمسرة', '6', 1, NULL, '2022-03-28 09:21:48', '2022-03-28 09:21:48'),
(10, 'Additional discounts, grants and incentives granted by tobacco and cement companies', 'الخصومات و المنح و الحوافز الإستثنائية الإضافية التي تمنحها شركات الدخان و الأسمنت', '7', 1, NULL, '2022-03-28 09:21:48', '2022-03-28 09:21:48'),
(11, 'All discounts, grants and commissions granted by petroleum and telecommunications companies and other companies addressed by the discount system', 'جميع الخصومات و المنح و العمولات التي تمنحها شركات البترول و الإتصالات و غيرها من الشركات المخاطبة بنظام الخصم', '8', 1, NULL, '2022-03-28 09:21:48', '2022-03-28 09:21:48'),
(12, 'Export subsidy support granted by the Export Development Fund', 'مساندة دعم الصادرات التي يمنحها صندوق تنمية الصادرات', '9', 1, NULL, '2022-03-28 09:21:48', '2022-03-28 09:21:48'),
(13, 'collect licenses', 'تحصيل تراخيص', '11', 1, NULL, '2022-03-28 09:21:48', '2022-03-28 09:21:48'),
(14, 'collect massacres', 'تحصيل مجازر', '13', 1, NULL, '2022-03-28 09:21:48', '2022-03-28 09:21:48'),
(15, 'Traffic collection', 'تحصيل المرور', '14', 1, NULL, '2022-03-28 09:21:49', '2022-03-28 09:21:49'),
(16, 'Courts Collection - Primary', 'تحصيل محاكم - إبتدائي', '15', 1, NULL, '2022-03-28 09:21:49', '2022-03-28 09:21:49'),
(17, 'Courts Collection - Appeals', 'تحصيل محاكم - إستئناف', '16', 1, NULL, '2022-03-28 09:21:49', '2022-03-28 09:21:49'),
(18, 'Courts Collection - Real Estate Month', 'تحصيل محاكم - شهر عقاري', '17', 1, NULL, '2022-03-28 09:21:49', '2022-03-28 09:21:49'),
(19, 'Courts Collection - Cassation', 'تحصيل محاكم - نقض', '18', 1, NULL, '2022-03-28 09:21:49', '2022-03-28 09:21:49'),
(20, 'Hospitals collecting doctors', 'تحصيل المستشفيات من الأطباء', '19', 1, NULL, '2022-03-28 09:21:49', '2022-03-28 09:21:49');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_invoices`
--

CREATE TABLE `payment_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `po_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method` enum('cashe','cheque','bank_transfer') COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_payment` date NOT NULL,
  `exchange_rate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_bank_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cheque_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_delivery` date DEFAULT NULL,
  `recipient_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `original_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'add-supplier', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(2, 'show-supplier', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(3, 'delete-supplier', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(4, 'edit-supplier', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(5, 'suppliers', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(6, 'supplier-search', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(7, 'restore-supplier', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(8, 'add-purchase-request', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(9, 'show-purchase-request', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(10, 'delete-purchase-request', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(11, 'edit-purchase-request', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(12, 'restore-purchase-request', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(13, 'purchase-requests', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(14, 'show-timeline-purchase-request', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(15, 'timeline-purchase-request', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(16, 'show-acceptable-purchase-request', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(17, 'acceptable-purchase-request', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(18, 'add-expected-tiem', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(19, 'add-inquire', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(20, 'add-purchase-order', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(21, 'edit-purchase-order', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(22, 'purchase-orders', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(23, 'show-purchase-order', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(24, 'restore-purchase-order', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(25, 'delete-purchase-order', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(26, 'add-cheque', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(27, 'edit-cheque', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(28, 'show-cheque', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(29, 'delete-cheque', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(30, 'restore-cheque', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(31, 'send-cheque', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(32, 'cheques', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(33, 'timeline-purchase-order', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(34, 'show-acceptable-purchase-order', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(35, 'delete-acceptable-purchase-order', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(36, 'acceptable-purchase-order', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(37, 'timeline-cheque-request', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(38, 'show-acceptable-cheque-request', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(39, 'acceptable-cheque-request', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(40, 'account_statement', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(41, 'roles-page', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(42, 'user-roles-page', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(43, 'add-bank', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(44, 'edit-bank', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(45, 'delete-bank', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(46, 'restore-bank', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(47, 'banks', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(48, 'add-item', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(49, 'edit-item', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(50, 'delete-item', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(51, 'restore-item', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(52, 'items', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(53, 'add-business-nature', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(54, 'edit-business-nature', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(55, 'delete-business-nature', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(56, 'restore-business-nature', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(57, 'business-natures', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(58, 'add-nature-dealing', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(59, 'edit-nature-dealing', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(60, 'delete-nature-dealing', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(61, 'restore-nature-dealing', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(62, 'nature-dealings', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(63, 'add-discount-type', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(64, 'edit-discount-type', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(65, 'delete-discount-type', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(66, 'restore-discount-type', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(67, 'discount-types', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(68, 'add-invoice', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(69, 'edit-invoice', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(70, 'show-invoice', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(71, 'delete-invoice', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(72, 'restore-invoice', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(73, 'invoices', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(74, 'add-payment', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(75, 'edit-payment', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(76, 'show-payment', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(77, 'delete-payment', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(78, 'restore-payment', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(79, 'payments', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(80, 'add-sector', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(81, 'edit-sector', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(82, 'show-sector', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(83, 'delete-sector', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(84, 'restore-sector', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(85, 'sectors', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(86, 'add-department', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(87, 'edit-department', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(88, 'show-department', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(89, 'delete-department', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(90, 'restore-department', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(91, 'departments', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(92, 'add-project', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(93, 'edit-project', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(94, 'show-project', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(95, 'delete-project', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(96, 'restore-project', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(97, 'complete-project', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(98, 'projects', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(99, 'add-site', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(100, 'edit-site', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(101, 'show-site', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(102, 'delete-site', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(103, 'restore-site', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(104, 'sites', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(105, 'add-job-code', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(106, 'edit-job-code', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(107, 'show-job-code', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(108, 'delete-job-code', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(109, 'restore-job-code', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(110, 'job-codes', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(111, 'add-job-grade', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(112, 'edit-job-grade', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(113, 'show-job-grade', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(114, 'delete-job-grade', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(115, 'restore-job-grade', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(116, 'job-grades', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(117, 'add-job-name', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(118, 'edit-job-name', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(119, 'show-job-name', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(120, 'delete-job-name', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(121, 'restore-job-name', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(122, 'job-names', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(123, 'add-country', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(124, 'edit-country', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(125, 'show-country', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(126, 'delete-country', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(127, 'restore-country', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(128, 'countries', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(129, 'add-governorate', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(130, 'edit-governorate', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(131, 'show-governorate', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(132, 'delete-governorate', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(133, 'restore-governorate', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(134, 'governorates', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(135, 'add-group', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(136, 'edit-group', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(137, 'show-group', 'web', '2022-03-16 19:06:27', '2022-03-16 19:06:27'),
(138, 'delete-group', 'web', '2022-03-16 19:06:28', '2022-03-16 19:06:28'),
(139, 'restore-group', 'web', '2022-03-16 19:06:28', '2022-03-16 19:06:28'),
(140, 'groups', 'web', '2022-03-16 19:06:28', '2022-03-16 19:06:28'),
(141, 'add-sub-group', 'web', '2022-03-16 19:06:28', '2022-03-16 19:06:28'),
(142, 'edit-sub-group', 'web', '2022-03-16 19:06:28', '2022-03-16 19:06:28'),
(143, 'show-sub-group', 'web', '2022-03-16 19:06:28', '2022-03-16 19:06:28'),
(144, 'delete-sub-group', 'web', '2022-03-16 19:06:28', '2022-03-16 19:06:28'),
(145, 'restore-sub-group', 'web', '2022-03-16 19:06:28', '2022-03-16 19:06:28'),
(146, 'sub-groups', 'web', '2022-03-16 19:06:28', '2022-03-16 19:06:28'),
(147, 'add-family-name', 'web', '2022-03-16 19:06:28', '2022-03-16 19:06:28'),
(148, 'edit-family-name', 'web', '2022-03-16 19:06:28', '2022-03-16 19:06:28'),
(149, 'show-family-name', 'web', '2022-03-16 19:06:28', '2022-03-16 19:06:28'),
(150, 'delete-family-name', 'web', '2022-03-16 19:06:28', '2022-03-16 19:06:28'),
(151, 'restore-family-name', 'web', '2022-03-16 19:06:28', '2022-03-16 19:06:28'),
(152, 'family-names', 'web', '2022-03-16 19:06:28', '2022-03-16 19:06:28'),
(153, 'add-employee', 'web', '2022-03-16 19:06:28', '2022-03-16 19:06:28'),
(154, 'show-employee', 'web', '2022-03-16 19:06:28', '2022-03-16 19:06:28'),
(155, 'delete-employee', 'web', '2022-03-16 19:06:28', '2022-03-16 19:06:28'),
(156, 'edit-employee', 'web', '2022-03-16 19:06:28', '2022-03-16 19:06:28'),
(157, 'restore-employee', 'web', '2022-03-16 19:06:28', '2022-03-16 19:06:28'),
(158, 'employees', 'web', '2022-03-16 19:06:28', '2022-03-16 19:06:28'),
(159, 'my_actions', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(160, 'approval_courses', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(161, 'inquiry_edit', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(162, 'timeline-purchase-request-super', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(163, 'acceptable-purchase-request-super', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(164, 'timeline-purchase-order-super', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(165, 'acceptable-purchase-order-super', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(166, 'cheque-super', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(167, 'internal_purchases', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26'),
(168, 'external_purchases', 'web', '2022-03-16 19:06:26', '2022-03-16 19:06:26');

-- --------------------------------------------------------

--
-- Table structure for table `person_suppliers`
--

CREATE TABLE `person_suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `job` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `whatsapp` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `person_suppliers`
--

INSERT INTO `person_suppliers` (`id`, `name`, `job`, `mobile`, `whatsapp`, `email`, `supplier_id`) VALUES
(1, 'Ahmed01', 'Job01', '11111111', '11111111', 'ahmed00@gmail.com', 1),
(2, 'Ahmed02', 'Job02', '11111111', '11111111', 'ahmed01@gmail.com', 1),
(3, 'Ahmed11', 'Job11', '11111111', '11111111', 'ahmed10@gmail.com', 2),
(4, 'Ahmed12', 'Job12', '11111111', '11111111', 'ahmed11@gmail.com', 2),
(5, 'Ahmed21', 'Job21', '11111111', '11111111', 'ahmed20@gmail.com', 3),
(6, 'Ahmed22', 'Job22', '11111111', '11111111', 'ahmed21@gmail.com', 3),
(7, 'Ahmed31', 'Job31', '11111111', '11111111', 'ahmed30@gmail.com', 4),
(8, 'Ahmed32', 'Job32', '11111111', '11111111', 'ahmed31@gmail.com', 4),
(9, 'Ahmed41', 'Job41', '11111111', '11111111', 'ahmed40@gmail.com', 5),
(10, 'Ahmed42', 'Job42', '11111111', '11111111', 'ahmed41@gmail.com', 5),
(11, 'Ahmed51', 'Job51', '11111111', '11111111', 'ahmed50@gmail.com', 6),
(12, 'Ahmed52', 'Job52', '11111111', '11111111', 'ahmed51@gmail.com', 6),
(13, 'Ahmed61', 'Job61', '11111111', '11111111', 'ahmed60@gmail.com', 7),
(14, 'Ahmed62', 'Job62', '11111111', '11111111', 'ahmed61@gmail.com', 7),
(15, 'Ahmed71', 'Job71', '11111111', '11111111', 'ahmed70@gmail.com', 8),
(16, 'Ahmed72', 'Job72', '11111111', '11111111', 'ahmed71@gmail.com', 8),
(17, 'Ahmed81', 'Job81', '11111111', '11111111', 'ahmed80@gmail.com', 9),
(18, 'Ahmed82', 'Job82', '11111111', '11111111', 'ahmed81@gmail.com', 9),
(19, 'Ahmed91', 'Job91', '11111111', '11111111', 'ahmed90@gmail.com', 10),
(20, 'Ahmed92', 'Job92', '11111111', '11111111', 'ahmed91@gmail.com', 10);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `business_nature_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sector_id` bigint(20) UNSIGNED NOT NULL,
  `manager_id` bigint(20) UNSIGNED NOT NULL,
  `delegated_id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name_ar`, `name_en`, `code`, `type`, `item_id`, `business_nature_id`, `description_ar`, `description_en`, `sector_id`, `manager_id`, `delegated_id`, `group_id`, `completed`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'وادى النطرون', 'Wadi El Natrun', NULL, NULL, NULL, NULL, 'وصف وادى النطرون', 'Wadi El Natrun description', 12, 50, 1, 2, 0, NULL, '2022-03-28 09:21:26', '2022-03-28 09:21:26'),
(2, 'EJUST', 'EJUST', NULL, NULL, NULL, NULL, 'وصف EJUST', 'EJUST description', 12, 52, 1, 2, 0, NULL, '2022-03-28 09:21:26', '2022-03-28 09:21:26'),
(3, 'الكليات العسكرية', 'Military Colleges', NULL, NULL, NULL, NULL, 'وصف الكليات العسكرية', 'Military Colleges description', 13, 55, 1, 2, 0, NULL, '2022-03-28 09:21:27', '2022-03-28 09:21:27'),
(4, 'الهايكستب', 'Haikstep', NULL, NULL, NULL, NULL, 'وصف الهايكستب', 'Haikstep description', 13, 57, 1, 2, 0, NULL, '2022-03-28 09:21:27', '2022-03-28 09:21:27'),
(5, 'جامعة المنيا', 'Menia University', NULL, NULL, NULL, NULL, 'وصف جامعة المنيا', 'Menia university description', 14, 60, 1, 2, 0, NULL, '2022-03-28 09:21:28', '2022-03-28 09:21:28'),
(6, 'موبينيل', 'Mobinil', NULL, NULL, NULL, NULL, 'وصف مشروع موبينيل', 'Mobinil project description', 19, 66, 1, 2, 0, NULL, '2022-03-28 09:21:29', '2022-03-28 09:21:29'),
(7, 'إتصالات', 'Etisalat', NULL, NULL, NULL, NULL, 'وصف مشروع إتصالات', 'Etisalat project description', 19, 66, 1, 2, 0, NULL, '2022-03-28 09:21:30', '2022-03-28 09:21:30'),
(8, 'الجامعه اليابانيه', 'japanese university', NULL, NULL, NULL, NULL, 'وصف الجامعه اليابانيه', 'japanese university description', 12, 75, 1, 2, 0, NULL, '2022-03-28 09:21:31', '2022-03-28 09:21:31'),
(49, 'الجامعة اليابانية - المرحلة 3', '', '17', 'شامل', NULL, 1, 'الجامعة اليابانية - المرحلة 3', 'الجامعة اليابانية - المرحلة 3', 12, 15, 1, 2, 0, NULL, '2022-03-29 11:10:17', '2022-03-29 11:10:17'),
(50, 'كباري المشاة', '', '18', 'شامل', NULL, 1, 'كباري المشاة', 'كباري المشاة', 18, 15, 1, 2, 0, NULL, '2022-03-29 11:10:17', '2022-03-29 11:10:17'),
(51, 'مستودعات الكيان', '', '19', 'شامل', NULL, 1, 'مستودعات الكيان', 'مستودعات الكيان', 12, 15, 1, 2, 0, NULL, '2022-03-29 11:10:17', '2022-03-29 11:10:17'),
(52, 'مستودعات الكيان 2', '', '20', 'شامل', NULL, 1, 'مستودعات الكيان 2', 'مستودعات الكيان 2', 13, 15, 1, 2, 0, NULL, '2022-03-29 11:10:17', '2022-03-29 11:10:17'),
(53, 'جمالونات جامعة قنا', '', '21', 'شامل', NULL, 2, 'جمالونات جامعة قنا', 'جمالونات جامعة قنا', 18, 15, 1, 2, 0, NULL, '2022-03-29 11:10:17', '2022-03-29 11:10:17'),
(54, 'الكليات العسكرية - العاصمة الإدارية', '', '22', 'شامل', NULL, 1, 'الكليات العسكرية - العاصمة الإدارية', 'الكليات العسكرية - العاصمة الإدارية', 13, 15, 1, 2, 0, NULL, '2022-03-29 11:10:17', '2022-03-29 11:10:17'),
(55, 'شبكات سيوة', '', '23', 'شامل', NULL, 1, 'شبكات سيوة', 'شبكات سيوة', 12, 15, 1, 2, 0, NULL, '2022-03-29 11:10:17', '2022-03-29 11:10:17'),
(56, 'مصنع الإبداع', '', '24', 'شامل', NULL, 1, 'مصنع الإبداع', 'مصنع الإبداع', 13, 15, 1, 2, 0, NULL, '2022-03-29 11:10:17', '2022-03-29 11:10:17'),
(57, 'جامعة المنيا الأهلية', '', '25', 'شامل', NULL, 1, 'جامعة المنيا الأهلية', 'جامعة المنيا الأهلية', 14, 15, 1, 2, 0, NULL, '2022-03-29 11:10:17', '2022-03-29 11:10:17'),
(58, 'هناجر الهايكستب', '', '26', 'شامل', NULL, 1, 'هناجر الهايكستب', 'هناجر الهايكستب', 12, 15, 1, 2, 0, NULL, '2022-03-29 11:10:17', '2022-03-29 11:10:17'),
(59, 'مسجد رقم 4 - العاصمة الإدارية', '', '27', 'شامل', NULL, 1, 'مسجد رقم 4 - العاصمة الإدارية', 'مسجد رقم 4 - العاصمة الإدارية', 15, 15, 1, 2, 0, NULL, '2022-03-29 11:10:17', '2022-03-29 11:10:17'),
(60, 'مظلات العاصمة الإدارية (محطة الحافلات بالعاصمة الادارية)', '', '28', 'غير شامل', NULL, 3, 'مظلات العاصمة الإدارية (محطة الحافلات بالعاصمة الادارية)', 'مظلات العاصمة الإدارية (محطة الحافلات بالعاصمة الادارية)', 18, 15, 1, 2, 0, NULL, '2022-03-29 11:10:17', '2022-03-29 11:10:17'),
(61, 'نفق طريق السويس', '', '29', 'شامل', NULL, 1, 'نفق طريق السويس', 'نفق طريق السويس', 14, 15, 1, 2, 0, NULL, '2022-03-29 11:10:17', '2022-03-29 11:10:17'),
(62, 'خط الساحل', '', '30', 'شامل', NULL, 1, 'خط الساحل', 'خط الساحل', 12, 15, 1, 2, 0, NULL, '2022-03-29 11:10:17', '2022-03-29 11:10:17'),
(63, 'مجمع الصناعات بجفجافة', '', '31', 'شامل', NULL, 1, 'مجمع الصناعات بجفجافة', 'مجمع الصناعات بجفجافة', 12, 15, 1, 2, 0, NULL, '2022-03-29 11:10:17', '2022-03-29 11:10:17'),
(64, 'اتصالات', '', '1002', 'شامل', NULL, 1, 'اتصالات', 'اتصالات', 19, 15, 1, 2, 0, NULL, '2022-03-29 11:10:17', '2022-03-29 11:10:17'),
(65, 'اسوان', '', '1003', 'شامل', NULL, 1, 'اسوان', 'اسوان', 15, 15, 1, 2, 0, NULL, '2022-03-29 11:10:17', '2022-03-29 11:10:17'),
(66, 'فيلات القرنفل', '', '1004', 'شامل', NULL, 1, 'فيلات القرنفل', 'فيلات القرنفل', 13, 15, 1, 2, 0, NULL, '2022-03-29 11:10:18', '2022-03-29 11:10:18'),
(67, 'المنفذ البحرى', '', '1005', 'شامل', NULL, 1, 'المنفذ البحرى', 'المنفذ البحرى', 13, 15, 1, 2, 0, NULL, '2022-03-29 11:10:18', '2022-03-29 11:10:18'),
(68, 'منتجع الجلالة', '', '1006', 'شامل', NULL, 1, 'منتجع الجلالة', 'منتجع الجلالة', 13, 15, 1, 2, 0, NULL, '2022-03-29 11:10:18', '2022-03-29 11:10:18'),
(69, 'اورانج', '', '1007', 'غير شامل', NULL, 49, 'اورانج', 'اورانج', 19, 15, 1, 2, 0, NULL, '2022-03-29 11:10:18', '2022-03-29 11:10:18'),
(70, 'سوهاج', '', '1008', 'شامل', NULL, 1, 'سوهاج', 'سوهاج', 18, 15, 1, 2, 0, NULL, '2022-03-29 11:10:18', '2022-03-29 11:10:18'),
(71, 'اليابانية 1', '', '1009', 'شامل', NULL, 1, 'اليابانية 1', 'اليابانية 1', 12, 15, 1, 2, 0, NULL, '2022-03-29 11:10:18', '2022-03-29 11:10:18'),
(72, 'مصنع الرخام 6', '', '1010', 'شامل', NULL, 1, 'مصنع الرخام 6', 'مصنع الرخام 6', 13, 15, 1, 2, 0, NULL, '2022-03-29 11:10:18', '2022-03-29 11:10:18'),
(73, 'مصنع الرخام 5', '', '1011', 'شامل', NULL, 1, 'مصنع الرخام 5', 'مصنع الرخام 5', 13, 15, 1, 2, 0, NULL, '2022-03-29 11:10:18', '2022-03-29 11:10:18'),
(74, 'سلاح الاشارة', '', '1012', 'شامل', NULL, 1, 'سلاح الاشارة', 'سلاح الاشارة', 19, 15, 1, 2, 0, NULL, '2022-03-29 11:10:18', '2022-03-29 11:10:18'),
(75, 'وادى النطرون', '', '1013', 'شامل', NULL, 1, 'وادى النطرون', 'وادى النطرون', 12, 15, 1, 2, 0, NULL, '2022-03-29 11:10:18', '2022-03-29 11:10:18'),
(76, 'القوات الجوية', '', '1014', 'شامل', NULL, 1, 'القوات الجوية', 'القوات الجوية', 19, 15, 1, 2, 0, NULL, '2022-03-29 11:10:18', '2022-03-29 11:10:18'),
(77, 'سميح الساحل', '', '1015', 'شامل', NULL, 1, 'سميح الساحل', 'سميح الساحل', 21, 15, 1, 2, 0, NULL, '2022-03-29 11:10:18', '2022-03-29 11:10:18'),
(78, 'فيلا م وحيد', '', '1016', 'شامل', NULL, 1, 'فيلا م وحيد', 'فيلا م وحيد', 21, 15, 1, 2, 0, NULL, '2022-03-29 11:10:18', '2022-03-29 11:10:18'),
(79, 'فيلا 195 ب', '', '1017', 'شامل', NULL, 1, 'فيلا 195 ب', 'فيلا 195 ب', 21, 15, 1, 2, 0, NULL, '2022-03-29 11:10:18', '2022-03-29 11:10:18'),
(80, 'مزرعه م سميح', '', '1018', 'شامل', NULL, 1, 'مزرعه م سميح', 'مزرعه م سميح', 21, 15, 1, 2, 0, NULL, '2022-03-29 11:10:18', '2022-03-29 11:10:18'),
(81, 'الكترو مصانع 5-6', '', '1019', 'شامل', NULL, 1, 'الكترو مصانع 5-6', 'الكترو مصانع 5-6', 13, 15, 1, 2, 0, NULL, '2022-03-29 11:10:18', '2022-03-29 11:10:18'),
(82, 'مخازن بدر', '', '1020', 'شامل', NULL, 1, 'مخازن بدر', 'مخازن بدر', 21, 15, 1, 2, 0, NULL, '2022-03-29 11:10:18', '2022-03-29 11:10:18'),
(83, 'مصنع الجلفنة الجديد', '', '1021', 'شامل', NULL, 1, 'مصنع الجلفنة الجديد', 'مصنع الجلفنة الجديد', 21, 15, 1, 2, 0, NULL, '2022-03-29 11:10:18', '2022-03-29 11:10:18'),
(84, 'مصنع الرخام الصناعى و مستلزمات الانتاج', '', '1022', 'شامل', NULL, 1, 'مصنع الرخام الصناعى و مستلزمات الانتاج', 'مصنع الرخام الصناعى و مستلزمات الانتاج', 15, 15, 1, 2, 0, NULL, '2022-03-29 11:10:18', '2022-03-29 11:10:18'),
(85, 'القمر الصناعى قنا', '', '1023', 'شامل', NULL, 1, 'القمر الصناعى قنا', 'القمر الصناعى قنا', 13, 15, 1, 2, 0, NULL, '2022-03-29 11:10:18', '2022-03-29 11:10:18'),
(86, 'هايكستب', '', '1024', 'شامل', NULL, 1, 'هايكستب', 'هايكستب', 13, 15, 1, 2, 0, NULL, '2022-03-29 11:10:18', '2022-03-29 11:10:18'),
(87, 'اشاره المهندسين العسكريين', '', '1025', 'شامل', NULL, 1, 'اشاره المهندسين العسكريين', 'اشاره المهندسين العسكريين', 19, 15, 1, 2, 0, NULL, '2022-03-29 11:10:18', '2022-03-29 11:10:18'),
(88, 'ابراج الرادار', '', '1026', 'شامل', NULL, 1, 'ابراج الرادار', 'ابراج الرادار', 18, 15, 1, 2, 0, NULL, '2022-03-29 11:10:18', '2022-03-29 11:10:18'),
(89, 'المدينة الصناعية بدر', '', '1027', 'شامل', NULL, 1, 'المدينة الصناعية بدر', 'المدينة الصناعية بدر', 18, 15, 1, 2, 0, NULL, '2022-03-29 11:10:18', '2022-03-29 11:10:18'),
(90, 'المالحه', '', '1028', 'شامل', NULL, 1, 'المالحه', 'المالحه', 13, 15, 1, 2, 0, NULL, '2022-03-29 11:10:18', '2022-03-29 11:10:18'),
(91, 'العبور 1 جامعه عين شمس', '', '1029', 'شامل', NULL, 1, 'العبور 1 جامعه عين شمس', 'العبور 1 جامعه عين شمس', 21, 15, 1, 2, 0, NULL, '2022-03-29 11:10:18', '2022-03-29 11:10:18'),
(92, 'انتركونتينتال', '', '1030', 'شامل', NULL, 1, 'انتركونتينتال', 'انتركونتينتال', 21, 15, 1, 2, 0, NULL, '2022-03-29 11:10:18', '2022-03-29 11:10:18'),
(93, 'المخازن المركزية', '', '1031', 'شامل', NULL, 1, 'المخازن المركزية', 'المخازن المركزية', 21, 15, 1, 2, 0, NULL, '2022-03-29 11:10:18', '2022-03-29 11:10:18'),
(94, 'انشاءات مصنع بلبيس', '', '1032', 'شامل', NULL, 1, 'انشاءات مصنع بلبيس', 'انشاءات مصنع بلبيس', 21, 15, 1, 2, 0, NULL, '2022-03-29 11:10:18', '2022-03-29 11:10:18'),
(95, 'فيلا م فادى', '', '1033', 'شامل', NULL, 1, 'فيلا م فادى', 'فيلا م فادى', 21, 15, 1, 2, 0, NULL, '2022-03-29 11:10:18', '2022-03-29 11:10:18'),
(96, 'ارض بلبيس الجديدة', '', '1034', 'شامل', NULL, 1, 'ارض بلبيس الجديدة', 'ارض بلبيس الجديدة', 21, 15, 1, 2, 0, NULL, '2022-03-29 11:10:18', '2022-03-29 11:10:18'),
(97, 'اعمال مدنى العبور NSF', '', '1035', 'شامل', NULL, 1, 'اعمال مدنى العبور NSF', 'اعمال مدنى العبور NSF', 21, 15, 1, 2, 0, NULL, '2022-03-29 11:10:18', '2022-03-29 11:10:18'),
(98, 'وصلة ام القمر', '', '32', 'شامل', NULL, 1, 'وصلة ام القمر', 'وصلة ام القمر', 13, 15, 1, 2, 0, NULL, '2022-03-29 11:10:18', '2022-03-29 11:10:18'),
(99, 'المبنى الادارى عين شمس', '', '1037', 'شامل', NULL, 1, 'المبنى الادارى عين شمس', 'المبنى الادارى عين شمس', 21, 15, 1, 2, 0, NULL, '2022-03-29 11:10:18', '2022-03-29 11:10:18'),
(100, 'الصوبات الزراعية - وادى الصعايدة (اسوان)', '', '33', 'شامل', NULL, 1, 'الصوبات الزراعية - وادى الصعايدة (اسوان)', 'الصوبات الزراعية - وادى الصعايدة (اسوان)', 13, 15, 1, 2, 0, NULL, '2022-03-29 11:10:18', '2022-03-29 11:10:18');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `place_delivery` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_discount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_terms` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `general_terms` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `requester_id` bigint(20) UNSIGNED NOT NULL,
  `suppling_duration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_gross` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taxes` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `total_after_discount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `with_holding` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `net_total` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exist_comment` tinyint(1) NOT NULL DEFAULT 0,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT 0,
  `sent` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_requests`
--

CREATE TABLE `purchase_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `request_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requester_id` bigint(20) UNSIGNED NOT NULL,
  `sector_id` bigint(20) UNSIGNED DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `project_id` bigint(20) UNSIGNED DEFAULT NULL,
  `site_id` bigint(20) UNSIGNED DEFAULT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT 0,
  `sent` tinyint(1) NOT NULL DEFAULT 0,
  `expected_duration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exist_comment` tinyint(1) NOT NULL DEFAULT 0,
  `manufacturing_order_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'super_admin', 'web', '2022-03-16 19:06:28', '2022-03-16 19:06:28'),
(2, 'Purchasing Accountant', 'web', '2022-03-16 19:06:28', '2022-03-29 08:25:15'),
(3, 'Purchasing officer or manager', 'web', '2022-03-16 19:06:28', '2022-03-29 08:29:38'),
(4, 'Purchasing Department Manager', 'web', '2022-03-16 19:06:28', '2022-03-29 08:34:27'),
(5, 'Head of Procurement Division', 'web', '2022-03-16 19:06:28', '2022-03-29 08:36:36'),
(6, 'Audit department manager', 'web', '2022-03-16 21:19:08', '2022-03-16 21:23:03'),
(7, 'cost', 'web', '2022-03-16 21:35:26', '2022-03-16 21:35:26'),
(8, 'Operations Manager', 'web', '2022-03-17 09:17:45', '2022-03-17 09:17:45'),
(9, 'Deputy Chairman of the Board For Projects / Manufacturing Affairs', 'web', '2022-03-17 09:38:16', '2022-03-17 09:38:16'),
(10, 'Technical office engineer Civil', 'web', '2022-03-20 14:08:31', '2022-03-20 14:08:31'),
(11, 'Technical office engineer MEP', 'web', '2022-03-20 14:09:25', '2022-03-20 14:09:25'),
(12, 'purchase-request-super', 'web', '2022-03-23 08:33:34', '2022-03-23 08:33:34'),
(13, 'purchase-order-super', 'web', '2022-03-23 08:33:50', '2022-03-23 08:33:50'),
(14, 'cheque-super', 'web', '2022-03-23 08:33:58', '2022-03-23 08:33:58'),
(15, 'internal_purchases', 'web', '2022-03-23 08:34:16', '2022-03-23 08:34:16'),
(16, 'external_purchases', 'web', '2022-03-23 08:34:26', '2022-03-23 08:34:26'),
(17, 'super (purchase order & request) & cheque', 'web', '2022-03-28 10:56:23', '2022-03-28 10:56:23'),
(18, 'Technical office manager - civil', 'web', '2022-03-29 09:03:19', '2022-03-29 09:03:19'),
(19, 'Technical Office Manager - MEP', 'web', '2022-03-29 09:05:24', '2022-03-29 09:05:24'),
(20, 'Business Development', 'web', '2022-03-29 11:17:19', '2022-03-29 11:17:19');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 3),
(1, 4),
(1, 5),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(3, 1),
(3, 4),
(3, 5),
(4, 1),
(4, 4),
(4, 5),
(5, 1),
(5, 2),
(5, 3),
(5, 4),
(5, 5),
(6, 1),
(6, 2),
(6, 3),
(6, 4),
(6, 5),
(6, 10),
(6, 11),
(6, 18),
(6, 19),
(7, 1),
(7, 4),
(7, 5),
(8, 1),
(8, 2),
(8, 3),
(8, 4),
(8, 5),
(8, 6),
(8, 7),
(8, 8),
(8, 9),
(8, 10),
(8, 11),
(8, 18),
(8, 19),
(9, 1),
(9, 2),
(9, 3),
(9, 4),
(9, 5),
(9, 6),
(9, 7),
(9, 8),
(9, 9),
(9, 10),
(9, 11),
(9, 18),
(9, 19),
(10, 1),
(10, 2),
(10, 3),
(10, 4),
(10, 5),
(10, 6),
(10, 7),
(10, 8),
(10, 9),
(10, 10),
(10, 11),
(10, 18),
(10, 19),
(11, 1),
(11, 2),
(11, 3),
(11, 4),
(11, 5),
(11, 6),
(11, 7),
(11, 8),
(11, 9),
(11, 10),
(11, 11),
(11, 18),
(11, 19),
(12, 1),
(12, 2),
(12, 3),
(12, 4),
(12, 5),
(12, 6),
(12, 7),
(12, 8),
(12, 9),
(12, 10),
(12, 11),
(12, 18),
(12, 19),
(13, 1),
(13, 2),
(13, 3),
(13, 4),
(13, 5),
(13, 6),
(13, 7),
(13, 8),
(13, 9),
(13, 10),
(13, 11),
(13, 18),
(13, 19),
(14, 1),
(14, 3),
(14, 4),
(14, 5),
(14, 8),
(14, 9),
(14, 17),
(14, 20),
(15, 1),
(15, 3),
(15, 4),
(15, 5),
(15, 8),
(15, 9),
(15, 17),
(15, 20),
(16, 1),
(16, 2),
(16, 3),
(16, 4),
(16, 5),
(16, 8),
(16, 9),
(16, 10),
(16, 11),
(16, 17),
(16, 18),
(16, 19),
(16, 20),
(17, 1),
(17, 2),
(17, 3),
(17, 4),
(17, 5),
(17, 8),
(17, 9),
(17, 10),
(17, 11),
(17, 17),
(17, 18),
(17, 19),
(17, 20),
(18, 1),
(18, 3),
(18, 4),
(18, 5),
(18, 8),
(18, 18),
(18, 19),
(19, 1),
(19, 3),
(19, 4),
(19, 5),
(19, 8),
(19, 18),
(19, 19),
(20, 1),
(20, 2),
(20, 3),
(20, 4),
(21, 1),
(21, 2),
(21, 3),
(21, 4),
(22, 1),
(22, 2),
(22, 3),
(22, 4),
(23, 1),
(23, 2),
(23, 3),
(23, 4),
(24, 1),
(24, 2),
(24, 3),
(24, 4),
(25, 1),
(25, 2),
(25, 3),
(25, 4),
(26, 1),
(26, 2),
(26, 3),
(26, 4),
(27, 1),
(27, 2),
(27, 3),
(27, 4),
(28, 1),
(28, 2),
(28, 3),
(28, 4),
(28, 5),
(29, 1),
(29, 2),
(29, 3),
(29, 4),
(30, 1),
(30, 2),
(30, 3),
(30, 4),
(31, 1),
(31, 2),
(31, 3),
(31, 4),
(32, 1),
(32, 2),
(32, 3),
(32, 4),
(32, 5),
(33, 1),
(33, 2),
(33, 3),
(33, 4),
(33, 5),
(33, 6),
(33, 7),
(33, 8),
(33, 9),
(33, 17),
(34, 1),
(34, 2),
(34, 3),
(34, 4),
(34, 5),
(34, 6),
(34, 7),
(34, 8),
(34, 9),
(34, 10),
(34, 11),
(34, 17),
(34, 18),
(34, 19),
(35, 1),
(35, 4),
(35, 5),
(35, 17),
(36, 1),
(36, 2),
(36, 3),
(36, 4),
(36, 5),
(36, 6),
(36, 7),
(36, 8),
(36, 9),
(36, 10),
(36, 11),
(36, 17),
(36, 18),
(36, 19),
(37, 1),
(37, 2),
(37, 3),
(37, 4),
(37, 5),
(37, 6),
(37, 7),
(37, 8),
(37, 9),
(37, 17),
(38, 1),
(38, 2),
(38, 3),
(38, 4),
(38, 5),
(38, 6),
(38, 7),
(38, 8),
(38, 9),
(38, 17),
(39, 1),
(39, 2),
(39, 3),
(39, 4),
(39, 5),
(39, 6),
(39, 7),
(39, 8),
(39, 9),
(39, 17),
(40, 1),
(40, 2),
(40, 3),
(40, 4),
(40, 5),
(40, 6),
(40, 7),
(40, 9),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(68, 2),
(68, 3),
(68, 4),
(69, 1),
(69, 2),
(69, 3),
(69, 4),
(70, 1),
(70, 2),
(70, 3),
(70, 4),
(70, 5),
(71, 1),
(71, 2),
(71, 3),
(71, 4),
(72, 1),
(72, 2),
(72, 3),
(72, 4),
(73, 1),
(73, 2),
(73, 3),
(73, 4),
(73, 5),
(74, 1),
(74, 6),
(75, 1),
(75, 6),
(76, 1),
(76, 6),
(77, 1),
(77, 6),
(78, 1),
(78, 6),
(79, 1),
(79, 6),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(84, 1),
(85, 1),
(86, 1),
(87, 1),
(88, 1),
(89, 1),
(90, 1),
(91, 1),
(92, 1),
(93, 1),
(94, 1),
(95, 1),
(96, 1),
(97, 1),
(98, 1),
(99, 1),
(100, 1),
(101, 1),
(102, 1),
(103, 1),
(104, 1),
(105, 1),
(106, 1),
(107, 1),
(108, 1),
(109, 1),
(110, 1),
(111, 1),
(112, 1),
(113, 1),
(114, 1),
(115, 1),
(116, 1),
(117, 1),
(118, 1),
(119, 1),
(120, 1),
(121, 1),
(122, 1),
(123, 1),
(124, 1),
(125, 1),
(126, 1),
(127, 1),
(128, 1),
(129, 1),
(130, 1),
(131, 1),
(132, 1),
(133, 1),
(134, 1),
(135, 1),
(136, 1),
(137, 1),
(138, 1),
(139, 1),
(140, 1),
(141, 1),
(142, 1),
(143, 1),
(144, 1),
(145, 1),
(146, 1),
(147, 1),
(148, 1),
(149, 1),
(150, 1),
(151, 1),
(152, 1),
(153, 1),
(154, 1),
(155, 1),
(156, 1),
(157, 1),
(158, 1),
(159, 1),
(160, 1),
(161, 1),
(161, 3),
(161, 4),
(161, 5),
(161, 8),
(161, 18),
(161, 19),
(162, 1),
(162, 2),
(162, 3),
(162, 4),
(162, 5),
(162, 8),
(162, 9),
(162, 12),
(162, 17),
(162, 20),
(163, 1),
(163, 3),
(163, 4),
(163, 5),
(163, 8),
(163, 9),
(163, 10),
(163, 11),
(163, 12),
(163, 17),
(163, 18),
(163, 19),
(163, 20),
(164, 1),
(164, 2),
(164, 3),
(164, 4),
(164, 5),
(164, 6),
(164, 7),
(164, 8),
(164, 9),
(164, 13),
(164, 17),
(165, 1),
(165, 2),
(165, 3),
(165, 4),
(165, 5),
(165, 6),
(165, 7),
(165, 8),
(165, 9),
(165, 13),
(165, 17),
(166, 1),
(166, 2),
(166, 3),
(166, 4),
(166, 5),
(166, 6),
(166, 7),
(166, 8),
(166, 9),
(166, 14),
(166, 17),
(167, 1),
(167, 15),
(167, 17),
(168, 1),
(168, 16),
(168, 17);

-- --------------------------------------------------------

--
-- Table structure for table `sectors`
--

CREATE TABLE `sectors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `head_id` bigint(20) UNSIGNED NOT NULL,
  `delegated_id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sectors`
--

INSERT INTO `sectors` (`id`, `name_ar`, `name_en`, `head_id`, `delegated_id`, `parent_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '  الرئيس التنفيذى ', 'Chief Executive Officer (CEO)', 2, 1, NULL, NULL, '2022-03-28 09:21:15', '2022-03-28 09:21:15'),
(2, 'المدير المالي', 'Chief Financial Officer (CFO)', 3, 1, 1, NULL, '2022-03-28 09:21:16', '2022-03-28 09:21:16'),
(3, 'التخطيط والتطوير المؤسسي', 'Corporate Planning & Development', 4, 1, 1, NULL, '2022-03-28 09:21:16', '2022-03-28 09:21:16'),
(4, 'الحسابات والمراجعة والمخازن', 'Accounts, Audit & Inventory', 3, 1, 1, NULL, '2022-03-28 09:21:17', '2022-03-28 09:21:17'),
(5, 'تطوير الاعمال', 'Business Development', 16, 1, 1, NULL, '2022-03-28 09:21:20', '2022-03-28 09:21:20'),
(6, 'المشتريات', 'Purchasing', 20, 1, 1, NULL, '2022-03-28 09:21:21', '2022-03-28 09:21:21'),
(7, 'المكتب الفني المدني', 'Civil Technical Office', 20, 1, 1, NULL, '2022-03-28 09:21:21', '2022-03-28 09:21:21'),
(8, 'تخطيط الإنشاء', 'Construction Planning', 34, 1, 1, NULL, '2022-03-28 09:21:23', '2022-03-28 09:21:23'),
(9, 'المكتب الفني للميكانيكا والكهرباء والسباكة', 'MEP Technical Office', 34, 1, 1, NULL, '2022-03-28 09:21:23', '2022-03-28 09:21:23'),
(10, 'إدارة مقاولي الباطن', 'Subcontractors Management', 43, 1, 1, NULL, '2022-03-28 09:21:25', '2022-03-28 09:21:25'),
(11, 'الإشارة العسكرية', 'Military Signal', 45, 1, 1, NULL, '2022-03-28 09:21:25', '2022-03-28 09:21:25'),
(12, 'انشاءات #1', 'Construction #1', 47, 1, 1, NULL, '2022-03-28 09:21:26', '2022-03-28 09:21:26'),
(13, 'انشاءات #2', 'Construction #2', 54, 1, 1, NULL, '2022-03-28 09:21:27', '2022-03-28 09:21:27'),
(14, 'انشاءات #3', 'Construction #3', 59, 1, 1, NULL, '2022-03-28 09:21:28', '2022-03-28 09:21:28'),
(15, 'انشاءات #4', 'Construction #4', 62, 1, 1, NULL, '2022-03-28 09:21:28', '2022-03-28 09:21:28'),
(16, 'نائب رئيس مجلس  الإدارة لشئون المشروعات', 'Deputy to CEO - for Projects', 63, 1, 1, NULL, '2022-03-28 09:21:29', '2022-03-28 09:21:29'),
(17, 'نائب رئيس مجلس  الإدارة لشئون التصنيع', 'Deputy to CEO - for Manufacturing', 64, 1, 1, NULL, '2022-03-28 09:21:29', '2022-03-28 09:21:29'),
(18, 'التشييد معدنى', 'Steel Erection', 65, 1, 1, NULL, '2022-03-28 09:21:29', '2022-03-28 09:21:29'),
(19, 'الشبكات', 'Networks', 20, 1, 1, NULL, '2022-03-28 09:21:29', '2022-03-28 09:21:29'),
(20, 'تطوير الاعمال', 'Business Development', 74, 1, 1, NULL, '2022-03-28 09:21:31', '2022-03-28 09:21:31'),
(21, 'مشاريع خاصة', 'Special Projects', 3, 7, 1, NULL, '2022-03-29 11:06:38', '2022-03-29 11:06:38');

-- --------------------------------------------------------

--
-- Table structure for table `sites`
--

CREATE TABLE `sites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sites`
--

INSERT INTO `sites` (`id`, `name_ar`, `name_en`, `project_id`, `deleted_at`) VALUES
(1, 'موقع وادى النطرون', 'Wadi El Natrun site', 1, NULL),
(2, 'موقع EJUST', 'EJUST site', 2, NULL),
(3, 'موقع الكليات العسكرية', 'Military Colleges site', 3, NULL),
(4, 'موقع الهايكستب', 'Haikstep site', 4, NULL),
(5, 'موقع جامعة المنيا', 'Menia University site', 5, NULL),
(6, 'موقع موبينيل', 'Mobinil site', 6, NULL),
(7, 'موقع إتصالات', 'Etisalat site', 7, NULL),
(8, 'موقع برج العرب', 'Burj Al Arab site', 8, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sub_groups`
--

CREATE TABLE `sub_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `both` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_groups`
--

INSERT INTO `sub_groups` (`id`, `name_ar`, `name_en`, `group_id`, `both`, `deleted_at`) VALUES
(1, 'أعمال مدنية', 'civil works', 1, 0, NULL),
(2, 'أعمال تشطيبات', 'Finishing works', 1, 0, NULL),
(3, 'أعمال إنذار ومكافحة حريق', 'Alarm and fire fighting works', 2, 0, NULL),
(4, 'أعمال كهرباء', 'Electricity works', 2, 0, NULL),
(5, 'أعمال ميكانيكية + صرف', 'mechanical work + drainage', 2, 0, NULL),
(6, 'تجهيزات موقع', 'Site Equipment', 3, 0, NULL),
(7, 'تجهيزات موقع', 'Site Equipment', 1, 1, NULL),
(8, 'تجهيزات موقع', 'Site Equipment', 2, 1, NULL),
(9, 'أخري', 'other', 3, 0, NULL),
(10, 'أخري', 'other', 1, 1, NULL),
(11, 'أخري', 'other', 2, 1, NULL),
(12, 'خامات', 'ores', 7, 0, NULL),
(13, 'مستهلكات', 'consumables', 7, 0, NULL),
(14, 'عده ومعدات', 'tools and equipment', 7, 0, NULL),
(15, 'لابتوبات', 'laptops', 4, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_id` bigint(20) UNSIGNED DEFAULT NULL,
  `phone` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website_url` varchar(520) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gmap_url` varchar(520) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `person_note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `family_name_note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accredite_note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_id_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_id_number_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commercial_registeration_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commercial_registeration_number_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value_add_registeration_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value_add_registeration_number_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value_add_tax_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_file_number_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cash` tinyint(1) DEFAULT NULL,
  `system` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name_ar`, `name_en`, `fax`, `address_id`, `phone`, `mobile`, `email`, `website_url`, `gmap_url`, `logo`, `person_note`, `family_name_note`, `accredite_note`, `tax_id_number`, `tax_id_number_file`, `commercial_registeration_number`, `commercial_registeration_number_file`, `value_add_registeration_number`, `value_add_registeration_number_file`, `value_add_tax_number`, `tax_file_number_file`, `cash`, `system`, `deleted_at`) VALUES
(1, 'مورد1', 'Supplier1', 'Supplier0 Fax', 1, '123456', '011123456', 'Supplier1@gmail.com', 'https://Supplier0.com', 'https://Supplier0-gmap.com', NULL, 'Supplier0 person_note', 'Supplier0 family_name_note', 'Supplier0 accredite_note', '000-000-000', NULL, '12345', NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
(2, 'مورد2', 'Supplier2', 'Supplier1 Fax', 2, '123456', '011123456', 'Supplier2@gmail.com', 'https://Supplier1.com', 'https://Supplier1-gmap.com', NULL, 'Supplier1 person_note', 'Supplier1 family_name_note', 'Supplier1 accredite_note', '000-000-000', NULL, '12345', NULL, NULL, NULL, NULL, NULL, 1, 0, '2021-08-02 12:31:10'),
(3, 'مورد3', 'Supplier3', 'Supplier2 Fax', 3, '123456', '011123456', 'Supplier3@gmail.com', 'https://Supplier2.com', 'https://Supplier2-gmap.com', NULL, 'Supplier2 person_note', 'Supplier2 family_name_note', 'Supplier2 accredite_note', '000-000-000', NULL, '12345', NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
(4, 'مورد4', 'Supplier4', 'Supplier3 Fax', 1, '123456', '011123456', 'Supplier4@gmail.com', 'https://Supplier3.com', 'https://Supplier3-gmap.com', NULL, 'Supplier3 person_note', 'Supplier3 family_name_note', 'Supplier3 accredite_note', '000-000-000', NULL, '12345', NULL, NULL, NULL, NULL, NULL, 1, 0, '2021-08-02 12:31:10'),
(5, 'مورد5', 'Supplier5', 'Supplier4 Fax', 2, '123456', '011123456', 'Supplier5@gmail.com', 'https://Supplier4.com', 'https://Supplier4-gmap.com', NULL, 'Supplier4 person_note', 'Supplier4 family_name_note', 'Supplier4 accredite_note', '000-000-000', NULL, '12345', NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
(6, 'مورد6', 'Supplier6', 'Supplier5 Fax', 3, '123456', '011123456', 'Supplier6@gmail.com', 'https://Supplier5.com', 'https://Supplier5-gmap.com', NULL, 'Supplier5 person_note', 'Supplier5 family_name_note', 'Supplier5 accredite_note', '000-000-000', NULL, '12345', NULL, NULL, NULL, NULL, NULL, 1, 0, '2021-08-02 12:31:10'),
(7, 'مورد7', 'Supplier7', 'Supplier6 Fax', 1, '123456', '011123456', 'Supplier7@gmail.com', 'https://Supplier6.com', 'https://Supplier6-gmap.com', NULL, 'Supplier6 person_note', 'Supplier6 family_name_note', 'Supplier6 accredite_note', '000-000-000', NULL, '12345', NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
(8, 'مورد8', 'Supplier8', 'Supplier7 Fax', 2, '123456', '011123456', 'Supplier8@gmail.com', 'https://Supplier7.com', 'https://Supplier7-gmap.com', NULL, 'Supplier7 person_note', 'Supplier7 family_name_note', 'Supplier7 accredite_note', '000-000-000', NULL, '12345', NULL, NULL, NULL, NULL, NULL, 1, 0, '2021-08-02 12:31:10'),
(9, 'مورد9', 'Supplier9', 'Supplier8 Fax', 3, '123456', '011123456', 'Supplier9@gmail.com', 'https://Supplier8.com', 'https://Supplier8-gmap.com', NULL, 'Supplier8 person_note', 'Supplier8 family_name_note', 'Supplier8 accredite_note', '000-000-000', NULL, '12345', NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
(10, 'مورد10', 'Supplier10', 'Supplier9 Fax', 1, '123456', '011123456', 'Supplier10@gmail.com', 'https://Supplier9.com', 'https://Supplier9-gmap.com', NULL, 'Supplier9 person_note', 'Supplier9 family_name_note', 'Supplier9 accredite_note', '000-000-000', NULL, '12345', NULL, NULL, NULL, NULL, NULL, 1, 0, '2021-08-02 12:31:10');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_bank_transfers`
--

CREATE TABLE `supplier_bank_transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bank_account_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_branch` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_ibn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_swift` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplier_bank_transfers`
--

INSERT INTO `supplier_bank_transfers` (`id`, `bank_account_number`, `bank_name`, `bank_branch`, `bank_currency`, `bank_ibn`, `bank_swift`, `supplier_id`) VALUES
(1, '1234560', 'Bank0', 'bank_branch00', 'pound0', NULL, NULL, 1),
(2, '1234561', 'Bank1', 'bank_branch11', 'pound1', NULL, NULL, 2),
(3, '1234562', 'Bank2', 'bank_branch22', 'pound2', NULL, NULL, 3),
(4, '1234563', 'Bank3', 'bank_branch33', 'pound3', NULL, NULL, 4),
(5, '1234564', 'Bank4', 'bank_branch44', 'pound4', NULL, NULL, 5),
(6, '1234565', 'Bank5', 'bank_branch55', 'pound5', NULL, NULL, 6),
(7, '1234566', 'Bank6', 'bank_branch66', 'pound6', NULL, NULL, 7),
(8, '1234567', 'Bank7', 'bank_branch77', 'pound7', NULL, NULL, 8),
(9, '1234568', 'Bank8', 'bank_branch88', 'pound8', NULL, NULL, 9),
(10, '1234569', 'Bank9', 'bank_branch99', 'pound9', NULL, NULL, 10);

-- --------------------------------------------------------

--
-- Table structure for table `supplier_cheques`
--

CREATE TABLE `supplier_cheques` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_on_cheque` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplier_cheques`
--

INSERT INTO `supplier_cheques` (`id`, `name_on_cheque`, `supplier_id`) VALUES
(1, 'name_on_cheque Supplier1', 1),
(2, 'name_on_cheque Supplier2', 2),
(3, 'name_on_cheque Supplier3', 3),
(4, 'name_on_cheque Supplier4', 4),
(5, 'name_on_cheque Supplier5', 5),
(6, 'name_on_cheque Supplier6', 6),
(7, 'name_on_cheque Supplier7', 7),
(8, 'name_on_cheque Supplier8', 8),
(9, 'name_on_cheque Supplier9', 9),
(10, 'name_on_cheque Supplier10', 10);

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `code`, `name_en`, `name_ar`, `deleted_at`) VALUES
(1, '2Z', 'Millivolt ( mV )', 'Millivolt ( mV )', '2021-09-01 07:38:52'),
(2, '4K', 'Milliampere ( mA )', 'Milliampere ( mA )', '2021-09-01 07:38:52'),
(3, '4O', 'Microfarad ( microF )', 'Microfarad ( microF )', '2021-09-01 07:38:52'),
(4, 'A87', 'Gigaohm ( GOhm )', 'Gigaohm ( GOhm )', '2021-09-01 07:38:52'),
(5, 'A93', 'Gram/Cubic meter ( g/m3 )', 'Gram/Cubic meter ( g/m3 )', '2021-09-01 07:38:52'),
(6, 'A94', 'Gram/cubic centimeter ( g/cm3 )', 'Gram/cubic centimeter ( g/cm3 )', '2021-09-01 07:38:52'),
(7, 'AMP', 'Ampere ( A )', 'Ampere ( A )', '2021-09-01 07:38:52'),
(8, 'ANN', 'Years ( yr )', 'Years ( yr )', '2021-09-01 07:38:52'),
(9, 'B22', 'Kiloampere ( kA )', 'Kiloampere ( kA )', '2021-09-01 07:38:52'),
(10, 'B49', 'Kiloohm ( kOhm )', 'Kiloohm ( kOhm )', '2021-09-01 07:38:52'),
(11, 'B75', 'Megohm ( MOhm )', 'Megohm ( MOhm )', '2021-09-01 07:38:52'),
(12, 'B78', 'Megavolt ( MV )', 'Megavolt ( MV )', '2021-09-01 07:38:52'),
(13, 'B84', 'Microampere ( microA )', 'Microampere ( microA )', '2021-09-01 07:38:52'),
(14, 'BAR', 'bar ( bar )', 'bar ( bar )', '2021-09-01 07:38:52'),
(15, 'BBL', 'Barrel (oil 42 gal.)', 'برميل', '2021-09-01 07:38:52'),
(16, 'BG', 'Bag ( Bag )', 'Bag ( Bag )', '2021-09-01 07:38:52'),
(17, 'BO', 'Bottle ( Bt. )', 'Bottle ( Bt. )', '2021-09-01 07:38:52'),
(18, 'BOX', 'Box', 'صندوق', '2021-09-01 07:38:52'),
(19, 'C10', 'Millifarad ( mF )', 'Millifarad ( mF )', '2021-09-01 07:38:52'),
(20, 'C39', 'Nanoampere ( nA )', 'Nanoampere ( nA )', '2021-09-01 07:38:52'),
(21, 'C41', 'Nanofarad ( nF )', 'Nanofarad ( nF )', '2021-09-01 07:38:52'),
(22, 'C45', 'Nanometer ( nm )', 'Nanometer ( nm )', '2021-09-01 07:38:52'),
(23, 'C62', 'Activity unit ( AU )', 'عدد', NULL),
(24, 'CA', 'Canister ( Can )', 'Canister ( Can )', '2021-09-01 07:38:52'),
(25, 'CMK', 'Square centimeter ( cm2 )', 'Square centimeter ( cm2 )', '2021-09-01 07:38:52'),
(26, 'CMQ', 'Cubic centimeter ( cm3 )', 'Cubic centimeter ( cm3 )', '2021-09-01 07:38:52'),
(27, 'CMT', 'Centimeter ( cm )', 'سم', NULL),
(28, 'CS', 'Case ( Case )', 'Case ( Case )', '2021-09-01 07:38:52'),
(29, 'CT', 'Carton ( Car )', 'Carton ( Car )', '2021-09-01 07:38:52'),
(30, 'CTL', 'Centiliter ( Cl )', 'Centiliter ( Cl )', '2021-09-01 07:38:52'),
(31, 'D10', 'Siemens per meter ( S/m )', 'Siemens per meter ( S/m )', '2021-09-01 07:38:52'),
(32, 'D33', 'Tesla ( D )', 'Tesla ( D )', '2021-09-01 07:38:52'),
(33, 'D41', 'Ton/Cubic meter ( t/m3 )', 'Ton/Cubic meter ( t/m3 )', '2021-09-01 07:38:52'),
(34, 'DAY', 'Days ( d )', 'Days ( d )', '2021-09-01 07:38:52'),
(35, 'DMT', 'Decimeter ( dm )', 'Decimeter ( dm )', '2021-09-01 07:38:52'),
(36, 'DRM', 'DRUM', 'أسطوانة', '2021-09-01 07:38:52'),
(37, 'EA', 'each (ST) ( ST )', 'each (ST) ( ST )', '2021-09-01 07:38:52'),
(38, 'FAR', 'Farad ( F )', 'Farad ( F )', '2021-09-01 07:38:52'),
(39, 'FOT', 'Foot ( Foot )', 'Foot ( Foot )', '2021-09-01 07:38:52'),
(40, 'FTK', 'Square foot ( ft2 )', 'Square foot ( ft2 )', '2021-09-01 07:38:52'),
(41, 'FTQ', 'Cubic foot ( ft3 )', 'Cubic foot ( ft3 )', '2021-09-01 07:38:52'),
(42, 'G42', 'Microsiemens per centimeter ( microS/cm )', 'Microsiemens per centimeter ( microS/cm )', '2021-09-01 07:38:52'),
(43, 'GL', 'Gram/liter ( g/l )', 'Gram/liter ( g/l )', '2021-09-01 07:38:52'),
(44, 'GLL', 'gallon ( gal )', 'gallon ( gal )', '2021-09-01 07:38:52'),
(45, 'GM', 'Gram/square meter ( g/m2 )', 'Gram/square meter ( g/m2 )', '2021-09-01 07:38:52'),
(46, 'GPT', 'Gallon per thousand', 'جالون/الف', '2021-09-01 07:38:52'),
(47, 'GRM', 'Gram ( g )', 'Gram ( g )', '2021-09-01 07:38:52'),
(48, 'H63', 'Milligram/Square centimeter ( mg/cm2 )', 'Milligram/Square centimeter ( mg/cm2 )', '2021-09-01 07:38:52'),
(49, 'HHP', 'Hydraulic Horse Power', 'قوة حصان هيدروليكي', '2021-09-01 07:38:52'),
(50, 'HLT', 'Hectoliter ( hl )', 'Hectoliter ( hl )', '2021-09-01 07:38:52'),
(51, 'HTZ', 'Hertz (1/second) ( Hz )', 'Hertz (1/second) ( Hz )', '2021-09-01 07:38:52'),
(52, 'HUR', 'Hours ( hrs )', 'Hours ( hrs )', '2021-09-01 07:38:52'),
(53, 'IE', 'Number of Persons ( PRS )', 'Number of Persons ( PRS )', '2021-09-01 07:38:52'),
(54, 'INH', 'Inch ( “” )', 'Inch ( “” )', '2021-09-01 07:38:52'),
(55, 'INK', 'Square inch ( Inch2 )', 'Square inch ( Inch2 )', '2021-09-01 07:38:52'),
(56, 'IVL', 'Interval', 'فترة', '2021-09-01 07:38:52'),
(57, 'JOB', 'JOB', 'وظيفة', '2021-09-01 07:38:52'),
(58, 'KGM', 'Kilogram ( KG )', 'كجم', NULL),
(59, 'KHZ', 'Kilohertz ( kHz )', 'Kilohertz ( kHz )', '2021-09-01 07:38:52'),
(60, 'KMH', 'Kilometer/hour ( km/h )', 'Kilometer/hour ( km/h )', '2021-09-01 07:38:52'),
(61, 'KMK', 'Square kilometer ( km2 )', 'Square kilometer ( km2 )', '2021-09-01 07:38:52'),
(62, 'KMQ', 'Kilogram/cubic meter ( kg/m3 )', 'Kilogram/cubic meter ( kg/m3 )', '2021-09-01 07:38:52'),
(63, 'KMT', 'Kilometer ( km )', 'Kilometer ( km )', '2021-09-01 07:38:52'),
(64, 'KSM', 'Kilogram/Square meter ( kg/m2 )', 'Kilogram/Square meter ( kg/m2 )', '2021-09-01 07:38:52'),
(65, 'KVT', 'Kilovolt ( kV )', 'Kilovolt ( kV )', '2021-09-01 07:38:52'),
(66, 'KWT', 'Kilowatt ( KW )', 'Kilowatt ( KW )', '2021-09-01 07:38:52'),
(67, 'LB', 'pounds ', 'رطل', '2021-09-01 07:38:52'),
(68, 'LTR', 'Liter ( l )', 'Liter ( l )', '2021-09-01 07:38:52'),
(69, 'LVL', 'Level', 'مستوي', '2021-09-01 07:38:52'),
(70, 'M', 'Meter ( m )', 'م.ط', NULL),
(71, 'MAN', 'Man', 'رجل', '2021-09-01 07:38:52'),
(72, 'MAW', 'Megawatt ( VA )', 'Megawatt ( VA )', '2021-09-01 07:38:52'),
(73, 'MGM', 'Milligram ( mg )', 'Milligram ( mg )', '2021-09-01 07:38:52'),
(74, 'MHZ', 'Megahertz ( MHz )', 'Megahertz ( MHz )', '2021-09-01 07:38:52'),
(75, 'MIN', 'Minute ( min )', 'Minute ( min )', '2021-09-01 07:38:52'),
(76, 'MMK', 'Square millimeter ( mm2 )', 'Square millimeter ( mm2 )', '2021-09-01 07:38:52'),
(77, 'MMQ', 'Cubic millimeter ( mm3 )', 'Cubic millimeter ( mm3 )', '2021-09-01 07:38:52'),
(78, 'MMT', 'Millimeter ( mm )', 'Millimeter ( mm )', '2021-09-01 07:38:52'),
(79, 'MON', 'Months ( Months )', 'Months ( Months )', '2021-09-01 07:38:52'),
(80, 'MTK', 'Square meter ( m2 )', 'م۲', NULL),
(81, 'MTQ', 'Cubic meter ( m3 )', 'م۳', NULL),
(82, 'OHM', 'Ohm ( Ohm )', 'Ohm ( Ohm )', '2021-09-01 07:38:52'),
(83, 'ONZ', 'Ounce ( oz )', 'Ounce ( oz )', '2021-09-01 07:38:52'),
(84, 'PAL', 'Pascal ( Pa )', 'Pascal ( Pa )', '2021-09-01 07:38:52'),
(85, 'PF', 'Pallet ( PAL )', 'Pallet ( PAL )', '2021-09-01 07:38:52'),
(86, 'PK', 'Pack ( PAK )', 'Pack ( PAK )', '2021-09-01 07:38:52'),
(87, 'PMP', 'pump', 'مضخة', '2021-09-01 07:38:52'),
(88, 'RUN', 'run', 'ركض', '2021-09-01 07:38:52'),
(89, 'SH', 'Shrink ( Shrink )', 'Shrink ( Shrink )', '2021-09-01 07:38:52'),
(90, 'SK', 'Sack', 'كيس', '2021-09-01 07:38:52'),
(91, 'SMI', 'Mile ( mile )', 'Mile ( mile )', '2021-09-01 07:38:52'),
(92, 'ST', 'Ton (short,2000 lb)', 'طن (قصير,2000)', '2021-09-01 07:38:52'),
(93, 'TNE', 'Tonne ( t )', 'طن', NULL),
(94, 'TON', 'Ton (metric)', 'طن (متري)', '2021-09-01 07:38:52'),
(95, 'VLT', 'Volt ( V )', 'Volt ( V )', '2021-09-01 07:38:52'),
(96, 'WEE', 'Weeks ( Weeks )', 'Weeks ( Weeks )', '2021-09-01 07:38:52'),
(97, 'WTT', 'Watt ( W )', 'Watt ( W )', '2021-09-01 07:38:52'),
(98, 'X03', 'Meter/Hour ( m/h )', 'Meter/Hour ( m/h )', '2021-09-01 07:38:52'),
(99, 'YDQ', 'Cubic yard ( yd3 )', 'Cubic yard ( yd3 )', '2021-09-01 07:38:52'),
(100, 'YRD', 'Yards ( yd )', 'Yards ( yd )', '2021-09-01 07:38:52');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '$2y$10$h9F/8WrWhxxXwWCxy80tF.Bp5vKDyVVh6LGNQjsJdqkJDY03fpCi6',
  `manager_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sector_id` bigint(20) UNSIGNED DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `project_id` bigint(20) UNSIGNED DEFAULT NULL,
  `job_name_id` bigint(20) UNSIGNED DEFAULT NULL,
  `job_grade_id` bigint(20) UNSIGNED DEFAULT NULL,
  `position_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `profile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `board_member` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `delegated_at` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name_ar`, `name_en`, `username`, `email`, `code`, `email_verified_at`, `password`, `manager_id`, `sector_id`, `department_id`, `project_id`, `job_name_id`, `job_grade_id`, `position_ar`, `position_en`, `active`, `profile`, `board_member`, `remember_token`, `deleted_at`, `created_at`, `updated_at`, `delegated_at`) VALUES
(1, 'وحيد عدلى اسكندر', 'Waheed Adly Iskandar', 'waheed.adly', 'Chief.Executive.Officer.fake@eecegypt.com', '1', NULL, '$2y$10$JQxRrsFW5TfV0zljxN8wte0ZjatE3iv5fk9TxXjpaSNdzmXStqwfu', NULL, NULL, NULL, NULL, NULL, NULL, 'رئيس مجلس الادارة العضو المنتدب', 'Chairman & CEO', 1, NULL, 1, NULL, NULL, '2022-03-21 07:17:10', '2022-03-21 07:17:10', 4),
(2, 'سميح وحيد عدلى ', 'Sameeh Waheed Adly Iskandar', 'sameeh.waheed', 'Chief.Operating.Officer.fake@eecegypt.com', '2', NULL, '$2y$10$Bdqt29aSRqvnFphDIZS2buJemogy.mTmQYgTwq0fDmJT/Evh4o7hO', NULL, 1, NULL, NULL, NULL, NULL, 'رئيس مجلس الادارة العضو المنتدب', 'Chairman & COO', 1, NULL, 1, NULL, NULL, '2022-03-21 07:17:11', '2022-03-21 07:17:11', 4),
(3, 'اميرة انور عوض الله', 'Amira Anwar Awadallah', 'amira.anwar', 'amira.anwar.awadallah.fake@eecegypt.com', '23', NULL, '$2y$10$FYf7w1zh1PpMqDFk13h9W.KubHpGBrGjnumFBwRQm.0eGUTsu1E2e', NULL, 4, NULL, NULL, NULL, NULL, 'رئيس قطاع الحسابات والمراجعة والمخازن', 'Head of Accounts, Audit & Inventory', 1, NULL, 1, NULL, NULL, '2022-03-21 07:17:11', '2022-03-21 07:17:13', 4),
(4, 'فادى سمير مرقص يوسف', 'Fady Samir Morcos Youssef', 'fady.samir', 'corporate.planning.development.fake@eecegypt.com', '3', NULL, '$2y$10$/eac6XaeEI51O53B5.BdNuAqYBO12uWi3Q.N4dVDyjWAZeoBO1EMa', NULL, 3, NULL, NULL, NULL, NULL, 'نائبا لرئيس مجلس الادارة للتطوير والمشروعات الجديدة', 'Vice President, Corporate Planning & Development', 1, NULL, 1, NULL, NULL, '2022-03-21 07:17:12', '2022-03-21 07:17:12', 4),
(5, 'احمد سمير بيومى', 'Ahmed Samir Bayoumi', 'ahmed.samir', 'ahmed.samir.fake@eecegypt.com', '372', NULL, '$2y$10$Hq3M.2/tzzX1RiNiWV7Voeq8omaTeOGoqZay3DJzMddvTpnIdtJH6', 5, 3, 1, NULL, NULL, NULL, 'مدير تكنولوجيا المعلومات', 'Information Technology Manager', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:12', '2022-03-21 07:17:12', 4),
(6, 'كريستينا توبليان جرس', 'Christina Toplian Bell', 'christina.toplian', 'christina.toplian.fake@eecegypt.com', '1315', NULL, '$2y$10$Xnc0KIi8x2MwuZ4O8xLKAueIr1pSSArnY3rk/oc29Hwky3n8U2.x6', 4, 3, 2, NULL, NULL, NULL, 'مدير الموارد البشرية', 'Human resources Manager', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:12', '2022-03-21 07:17:12', 4),
(7, 'منى فؤاد صادق', 'Mona Fouad Sadiq', 'mona.fouad', 'mona.fouad.fake@eecegypt.com', '7', NULL, '$2y$10$m4e7GrgixpYcZAjFgwcO.usRWZEHxu5C23XstaJmL3BLzNeXewYFm', 4, 3, 3, NULL, NULL, NULL, 'مدير شؤون الأفراد', 'Personnel Manager', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:13', '2022-03-21 07:17:13', 4),
(8, '?1', '?1', '?1', '?1.fake@eecegypt.com', '0000-0009', NULL, '$2y$10$Y/RMp6W5sbh8PNGTo/zqa.6i8POLuU/./4/L49oLAUwsdlDSESsDO', 4, 3, 4, NULL, NULL, NULL, 'مدير تسويق', 'Marketing Manager', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:13', '2022-03-21 07:17:13', 4),
(9, 'كريم محمد على صالح', 'karim Mohamed Ali Saleh', 'karim.mohamed', 'karim.mohamed.fake@eecegypt.com', '313', NULL, '$2y$10$lTwHViSLc8FE.4hGIykHOejXGUgt4aVz7OuHx3ry/UU47wzrgqJWy', 3, 4, 5, NULL, NULL, NULL, 'مدير مساعد حسابات ( العملاء )', 'Accounts Assistant Manager (Customers)', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:14', '2022-03-21 07:17:14', 4),
(10, 'سمير', 'Samer', 'samer', 'samer.fake@eecegypt.com', '0000', NULL, '$2y$10$A4CyPIyHaAncCTpkpPiY4e10NdKfPs1QiX8reiwE1XACu.o./h/sa', 3, 4, 6, NULL, NULL, NULL, 'مدير حسابات', 'Accounting Manager', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:14', '2022-03-21 07:17:14', 4),
(11, 'ريمون جورج', 'Remon George', 'remon', 'remon.george@eecegypt.com', NULL, NULL, '$2y$10$4EpMAsIe0uIC.G8b.OYxgOoSh834shtvesnwK5YR.2jBymUH.vS.m', 3, 4, 7, NULL, NULL, NULL, 'مدير التكاليف', 'Cost Manager', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:14', '2022-03-23 10:16:48', 4),
(12, 'وائل سمير', 'Wael Samir', 'wael', 'wael.fake@eecegypt.com', NULL, NULL, '$2y$10$2emDiJKONOl3RkJulf4YheXZcEgQLlpEfRoX3autLvIX3wRCcjDtu', 3, 4, 8, NULL, NULL, NULL, 'مدير المراجعة', 'Audit Manager', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:15', '2022-03-23 10:15:06', 4),
(13, 'مينا', 'Mina', 'mina', 'mina.fake@eecegypt.com', '0000-003', NULL, '$2y$10$TpvAig.MqABUtYW0C/dBu.kjgrgxYnIw6EbUSGzrWz8qyUJrfxoPe', 3, 4, 9, NULL, NULL, NULL, 'مدير غرفة النقدية', 'Cash Room Manager', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:15', '2022-03-21 07:17:15', 4),
(14, 'فيبى', 'Fiby', 'fiby', 'fiby.fake@eecegypt.com', '0000-004', NULL, '$2y$10$HpcTIJPSi0ewPV7OlQHTvedDYYlsEMmeNv5snPrHWF57f1y80IKw2', 3, 4, 10, NULL, NULL, NULL, 'مدير المرتبات', 'Payroll Manager', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:15', '2022-03-21 07:17:15', 4),
(15, 'نرمين', 'Nermine', 'nermine', 'nermine.fake@eecegypt.com', '0000-005', NULL, '$2y$10$3.2qpiDLnAjERcfCZjZc0.F53YLjqKhYUecjvf9nvhwXTY8SsmQBO', 3, 4, 11, NULL, NULL, NULL, 'مدير الضرائب', 'Taxation Manager', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:16', '2022-03-21 07:17:16', 4),
(16, 'سامر لبيب حليم', 'Samer Labib Halim', 'samer.labib', 'samer.labib.halim.fake@eecegypt.com', '214', NULL, '$2y$10$HDbmtNljlyJFLHgU8lbtvuPm66y9Gx03NxwIzp6iVOPyX6rWffkEK', NULL, 5, NULL, NULL, NULL, NULL, 'رئيس قطاع تطوير الاعمال', 'Head of Business Development', 1, NULL, 1, NULL, NULL, '2022-03-21 07:17:16', '2022-03-21 07:17:16', 4),
(17, 'فادى', 'Fady', 'fady', 'fady.fake@eecegypt.com', '0000-006', NULL, '$2y$10$hXSYsOl/8hLN2o7KfS3p7Owzgq0ZoayO1H6V2e/z3E10/veuqn9DG', 16, 5, 12, NULL, NULL, NULL, 'مدير المناقصات', 'Tendering Manager', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:16', '2022-03-21 07:17:16', 4),
(18, '؟', '؟', '؟', '؟.fake@eecegypt.com', '0000-007', NULL, '$2y$10$1a1YiEFJWJrjfbw2FXlyCubqccfagNEDur9m9GWuZ.JjO7WyDzqr6', 16, 5, 13, NULL, NULL, NULL, 'مدير أعمال جديدة', 'New Business Manager', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:16', '2022-03-21 07:17:17', 4),
(19, 'ايهاب', 'Ehab', 'ehab', 'ehab.fake@eecegypt.com', '0000-008', NULL, '$2y$10$.7jARHeSyJnP1n6f7cpAEOmCbpxT7THTTgeBHBHMhY4Q1SgAp.4fK', 16, 5, 14, NULL, NULL, NULL, 'مدير التصميم', 'Design Manager', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:17', '2022-03-21 07:17:17', 4),
(20, 'ميشيل جرجس ميخائيل تادرس', 'Michel Gerges Michael Tadros', 'michel.gerges', 'michel.gerges.michael.tadros.fake@eecegypt.com', NULL, NULL, '$2y$10$oAh53bL8kprwYURAKYyFfecJyQgbTGZiKys033OOtvVU91eQya4Am', NULL, 6, NULL, NULL, NULL, NULL, 'نائب رئيس مجلس الادارة شئون المشتريات الداخلية والخارجية وتعاقدات مقاولى الباطن، المشروعات الداخلية والمكتب الفنى للأعمال المدنية', 'Vice President - Procurement, Subcontractor Management, Internal Projects & Technical office (Civil)', 1, NULL, 1, NULL, NULL, '2022-03-21 07:17:17', '2022-03-23 10:11:56', 4),
(21, 'عاطف راضى تقاوى', 'Atef Rady Taqawy', 'atef.rady', 'atef.rady.fake@eecegypt.com', NULL, NULL, '$2y$10$RfOvoDcb0Z0yz.SroMSVs.GRebUZye3hocUwsjQkv8.eul62ZQA/m', 20, 6, 15, NULL, NULL, NULL, 'مدير المشتريات الداخلية', 'Internal Purchasing Manager', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:17', '2022-03-23 10:10:40', 4),
(22, 'بيتر ماهر جرجس عبيد', 'Peter Maher Gerges Obaid', 'peter.maher', 'peter.maher@eecegypt.com', NULL, NULL, '$2y$10$.uioO1nmllJntE6GsyAZSuqqC1wAOWx2Y0ysNgv3UPIFuKxCs1s2e', 20, 6, 16, NULL, NULL, NULL, 'مدير المشتريات الخارجية', 'External Purchasing Manager', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:17', '2022-03-23 10:11:01', 4),
(23, 'سالى عادل انور مسعد', 'Sally Adel Anwar Massad', 'sally.adel', 'sally.adel.fake@eecegypt.com', NULL, NULL, '$2y$10$l3.J4OCqTcLhFj5Nnm2iSOfqZ6SFSIcuNzu9znAv4H9JTM.Dmra5O', 20, 7, 17, NULL, NULL, NULL, 'مدير المكتب الفني المدني', 'Civil Technical Office Manager', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:18', '2022-03-23 10:33:15', 4),
(24, 'مارينا عيد', 'marina eid', 'marina.eid', 'marina.eid.fake@eecegypt.com', NULL, NULL, '$2y$10$VHIRLu9Sp232vGwZZiwhieDQO3z5f4kW7exILwRxUchlVfUX5QZme', 23, 7, 17, NULL, NULL, NULL, 'مهندس مكتب فني - مهندس معماري', 'Technical Office Engineer - Architect', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:18', '2022-03-23 10:29:06', 1),
(25, 'احمد محسن', 'ahmed mohsen', 'ahmed.mohsen', 'ahmed.mohsen.fake@eecegypt.com', NULL, NULL, '$2y$10$6aWzScbOA02EfcwWyCO.F.x1ZSZhtyj8Fqou19.MLA5n6iAVj9CO.', 23, 7, 17, NULL, NULL, NULL, 'هندسة المكاتب الفنية العليا - مدني', 'Senior Technical Office Engineering - Civil', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:18', '2022-03-23 10:30:37', 1),
(26, 'بولا يعقوب', 'poula yacoub', 'poula.yacoub', 'poula.yacoub.fake@eecegypt.com', NULL, NULL, '$2y$10$zKcspaL0IqNnqHQI1GlFt.7syoX.0iOBMUkjyGgBjQiXgM6DZ8Lym', 23, 7, 17, NULL, NULL, NULL, 'مهندس مكتب فني', 'Technical Office Engineer', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:18', '2022-03-23 10:31:12', 1),
(27, 'مارينا كوزمان', 'marina kozman', 'marina.kozman', 'marina.kozman.fake@eecegypt.com', NULL, NULL, '$2y$10$igS8QajU6DazM/AQtHRBTObylDhtakOhEgnUnT0/8DjmqoN15PyBi', 23, 7, 17, NULL, NULL, NULL, 'مهندس مكتب فني مبتدئ', 'Junior Technical Office Engineer', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:18', '2022-03-23 10:31:27', 1),
(28, 'مارينا وديع', 'marina wadie', 'marina.wadie', 'marina.wadie.fake@eecegypt.com', NULL, NULL, '$2y$10$x9rbxBGFZlmR3irLxut3GOC4fhEMQsND5JfVxdATX8km1H4wSEABG', 23, 7, 17, NULL, NULL, NULL, 'مهندس مكتب فني', 'Technical Office Engineer', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:19', '2022-03-23 10:28:36', 1),
(29, 'كريستين رضا', 'christine reda', 'christine.reda', 'christine.reda.fake@eecegypt.com', NULL, NULL, '$2y$10$SQJQJR06zAgYjI.TCMAVwei46HS16PnK/RbwS6N21h/WHCQ1W5NhC', 23, 7, 17, NULL, NULL, NULL, 'مهندس مكتب فني', 'Technical Office Engineer', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:19', '2022-03-23 10:31:46', 1),
(30, 'ميرنا وجدي', 'merna wagdy', 'merna.wagdy', 'merna.wagdy.fake@eecegypt.com', NULL, NULL, '$2y$10$EL1c0Intq1lYBVAlD4q32e4h2v19/NBHX2xptbJa2Avp3XAH0oiF6', 23, 7, 17, NULL, NULL, NULL, 'مهندس مكتب فني', 'Technical Office Engineer', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:19', '2022-03-23 10:32:04', 1),
(31, 'ميرا محسن', 'mira mohsen', 'mira.mohsen', 'mira.mohsen.fake@eecegypt.com', NULL, NULL, '$2y$10$D6i3ulxrjT0QcZFOjGhOcOE82aboGykfzJVipIqYuIWLf5.bogJfe', 23, 7, 17, NULL, NULL, NULL, 'مهندس مكتب فني', 'Technical Office Engineer', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:19', '2022-03-23 10:30:55', 1),
(32, 'مارفي  فايق', 'marvy fayek', 'marvy.fayek', 'marvy.fayek.fake@eecegypt.com', NULL, NULL, '$2y$10$jQ540pAgj0Ypg/TfjGw/eedlCaSFTdWZ1Caw6f7uZXDzc1iPdu4qW', 23, 7, 17, NULL, NULL, NULL, 'مهندس مكتب فني', 'Technical Office Engineer', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:19', '2022-03-23 10:32:58', 1),
(33, 'كيرلس  وجيه', 'kirillos wagih', 'kirillos.wagih', 'kirillos.wagih.fake@eecegypt.com', NULL, NULL, '$2y$10$EtQA0mPjJRyAmS41bJtZV.cEIwQRyqHJNmwy8pVmJB6FqkTLnnLEe', 23, 7, 17, NULL, NULL, NULL, 'مهندس مكتب فني', 'Technical Office Engineer', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:19', '2022-03-23 10:30:13', 1),
(34, 'شريف فؤاد فرج الخناجرى', 'Sherif Fouad Farag Al-Khanajry', 'sherif.fouad', 'sherif.fouad.fake@eecegypt.com', '2787', NULL, '$2y$10$TWQ8Wk.OXAgA5dHg8yTCv.ve6YKvPxUuAu1BZeD9BfGYFIEp0Yej6', NULL, 8, NULL, NULL, NULL, NULL, 'رئيسا لقطاع التخطيط ومتابعة الاداء والمكتب الفنى الكتروميكانيكال ', 'Head of the Planning and Performance Follow-up Sector and the Electromechanical Technical Office', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:20', '2022-03-21 07:17:20', 4),
(35, 'توانسى', 'Tawansy', 'tawansy', 'tawansy.fake@eecegypt.com', '0000-015', NULL, '$2y$10$AlN3pUgbq0Xzf99fxm1F..JKzr/RIrAcaXdBBNx6HcjoJPa2aSkp.', 34, 8, 18, NULL, NULL, NULL, 'مدير المشتريات الداخلية', 'Internal Purchasing Manager', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:20', '2022-03-21 07:17:20', 4),
(36, 'ايمن وليم', 'Aiman', 'aiman', 'aiman.fake@eecegypt.com', NULL, NULL, '$2y$10$J43wAuN0egyIHyGWJ/lhreN8mHQRsc84zoNyq9L9eyfzSYGFwGVu.', 34, 9, 19, NULL, NULL, NULL, 'مدير المكتب الفني للميكانيكا والكهرباء والسباكة', 'MEP Technical Office Manager', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:20', '2022-03-23 10:36:49', 4),
(37, 'ابرام زكريا', 'ibram zakaria', 'ibram.zakaria', 'ibram.zakaria.fake@eecegypt.com', NULL, NULL, '$2y$10$qbSNfMfihA4dDD2BD1nttetb6SznKUumpRXbAdRsAH2yizC9S5aAy', 36, 9, 19, NULL, NULL, NULL, 'المكتب الفني للميكانيكا والكهرباء والسباكة', 'MEP Technical Office', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:20', '2022-03-23 10:34:40', 2),
(38, 'كيرلس  هلال', 'kirillos helal', 'kirillos.helal', 'kirillos.helal.fake@eecegypt.com', NULL, NULL, '$2y$10$ptx6veCFFRJEDNTGxZaJmuIyxNSLQ9vUkCzKMzRCaA98wnFkEW88W', 36, 9, 19, NULL, NULL, NULL, 'المكتب الفني للميكانيكا والكهرباء والسباكة', 'MEP Technical Office', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:21', '2022-03-23 10:34:21', 2),
(39, 'عمرو  عبد التواب', 'amr tawab', 'amr.tawab', 'amr.tawab.fake@eecegypt.com', NULL, NULL, '$2y$10$/cpF7Iwf8xlLIG.GEKs.0eYR1sajeJrTX4q.ZN.cIqhRsP44RCteu', 36, 9, 19, NULL, NULL, NULL, 'المكتب الفني للميكانيكا والكهرباء والسباكة', 'MEP Technical Office', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:21', '2022-03-23 10:33:54', 2),
(40, 'ايمانويل', 'emanule', 'emanule', 'emanule.fake@eecegypt.com', NULL, NULL, '$2y$10$ass7ftqbeVq1D7kbCjolLuNg2TmtfedjDrWnucZW6C2Aya8DolNVW', 36, 9, 19, NULL, NULL, NULL, 'المكتب الفني للميكانيكا والكهرباء والسباكة', 'MEP Technical Office', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:21', '2022-03-23 10:35:24', 2),
(41, 'مكسيموس', 'maximous', 'maximous', 'maximous.fake@eecegypt.com', NULL, NULL, '$2y$10$zQH5M6/Im0LQtL/oBlkq6uRganx.z6u0e7m6aO7uN2NxQjdbiIVtq', 36, 9, 19, NULL, NULL, NULL, 'المكتب الفني للميكانيكا والكهرباء والسباكة', 'MEP Technical Office', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:21', '2022-03-23 10:35:52', 2),
(42, 'مي خالد', 'mai khaled', 'mai.khaled', 'mai.khaled.fake@eecegypt.com', NULL, NULL, '$2y$10$u0Bc6Wj3YUB5C7hNLmjkROTa0nlSrp/a/O2FIGsgLVnI4OhHYHkiu', 36, 9, 19, NULL, NULL, NULL, 'المكتب الفني للميكانيكا والكهرباء والسباكة', 'MEP Technical Office', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:21', '2022-03-23 10:36:08', 2),
(43, 'طارق', 'Tarek', 'tarek', 'tarek.fake@eecegypt.com', '0000-017', NULL, '$2y$10$mpBosnSXIX5IG3OCmtLhJe6G4ltQbEOVa/fZy2g5rknPcFpJw.tii', NULL, 10, NULL, NULL, NULL, NULL, 'رئيسا لقطاع إدارة مقاولي الباطن', 'Head of Subcontractors Management', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:21', '2022-03-21 07:17:22', 4),
(44, 'باسم', 'Bassem', 'bassem', 'bassem.fake@eecegypt.com', '0000-018', NULL, '$2y$10$60zTQBy1sNCFY1Lsw2xkx.u83ZVKma1FhPJ4mMx7u8xEqpoZUp.E2', 43, 10, 20, NULL, NULL, NULL, 'مدير إدارة مقاولي الباطن', 'Subcontractors Management Manager', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:22', '2022-03-21 07:17:22', 4),
(45, 'اسحاق', 'Eshak', 'eshak', 'eshak.fake@eecegypt.com', '0000-019', NULL, '$2y$10$C2YyaF8j83ysbyQ/RB449ey8L.8TDyvF5oagVwyHMY8aHORgDCwry', NULL, 11, NULL, NULL, NULL, NULL, 'رئيسا لقطاع الإشارة العسكرية', 'Head of Military Signal', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:22', '2022-03-21 07:17:22', 4),
(46, 'جوزيف عطية', 'Joseph', 'joseph', 'joseph.fake@eecegypt.com', NULL, NULL, '$2y$10$OWmRoZaADWsf2dBbvFj17.xu7IlCh2ThFQmGFxu5sJHc5BQkIH5j2', 45, 11, 21, NULL, NULL, NULL, 'مدير الإشارة العسكرية', 'Military Signal Manager', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:23', '2022-03-24 09:55:31', 4),
(47, 'طارق جميل وهيب', 'Tariq Jamil Wahib', 'tariq.jamil', 'tariq.jamil@eecegypt.com', NULL, NULL, '$2y$10$oMBJ9StFWurfP0IR38U5ROc9mupydAAGUtDoNyscS6J0/BEmWime6', NULL, 12, NULL, NULL, NULL, NULL, 'رئيس قطاع غرب ( عضو مجلس الادارة )   رئيسا للادارة المركزية للتعاقدات مع مقاولى الباطن )', 'Head of West Region & the Central Department for Contracting with Subcontractors', 1, NULL, 1, NULL, NULL, '2022-03-21 07:17:23', '2022-03-23 10:23:13', 4),
(48, 'كاثرين عطية', 'catherine.attia', 'catherine.attia', 'catherine.attia.fake@eecegypt.com', NULL, NULL, '$2y$10$wQFnABnxOHL2WB.AbA8jgO4YWjQMiWomTegeItKevbFeXjN9fM6PG', 54, 13, NULL, NULL, NULL, NULL, 'مساعد مدير المكتب الفني', 'Technical Office Assistant Manager', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:23', '2022-03-23 10:20:05', 4),
(49, 'مارينا نشأت', 'marina.nashaat', 'marina.nashaat', 'marina.nashaat.fake@eecegypt.com', NULL, NULL, '$2y$10$E7FMkzEx/hgrRxrf86brWupFPEBihcKFb8DOmkQHJZsidzCFJqXoq', 54, 13, NULL, NULL, NULL, NULL, 'مهندس المكتب الفني', 'Technical Office Engineer', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:23', '2022-03-23 10:19:35', 4),
(50, '?3', '?3', '?3', '?3.fake@eecegypt.com', NULL, NULL, '$2y$10$U2F1YngQ8J1JB/36GRzW7u/WGJRyzgfZ9Rv1WiS6QEW1l4sPznfkq', 47, 12, NULL, NULL, NULL, NULL, 'مدير مشروع وادى النطرون', 'Wadi El Natrun project manager', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:24', '2022-03-23 11:51:45', 4),
(51, 'موظف اختبار مشروع وادى النطرون', 'Employee Test Wadi El Natrun', 'employee.test.WadiElNatrun', 'employee.test.WadiElNatrun.fake@eecegypt.com', '0000-100', NULL, '$2y$10$1wtYkKjghpde/XbXTg06Je8yRi7X1v16NnNa9kal5Urvf5o4au8Mi', 50, 12, NULL, 1, NULL, NULL, 'موظف', 'Employee', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:24', '2022-03-21 07:17:24', 4),
(52, '?4', '?4', '?4', '?4.fake@eecegypt.com', '0000-013', NULL, '$2y$10$V0KFZzGHNotjIi1v4ZL7uejn0Ea410/Aq4FwA4rROtPt67f8ODI12', 47, 1, NULL, NULL, NULL, NULL, 'مدير مشروع EJUST', 'Military Colleges project manager', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:24', '2022-03-21 07:17:24', 4),
(53, 'موظف اختبار مشروع EJUST', 'Employee Test EJUST', 'employee.test.EJUST', 'employee.test.EJUST.fake@eecegypt.com', '0000-101', NULL, '$2y$10$fV.PLlblejgJRKQu.nCNsuifHyC9h54bHdN23fy0YShmfZewEjD2G', 52, 12, NULL, 2, NULL, NULL, 'موظف', 'Employee', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:24', '2022-03-21 07:17:24', 4),
(54, 'نشأت مكين قلدس', 'Nashaat Makeen Qaldas', 'nashaat.makeen', 'nashaat.makeen@eecegypt.com', NULL, NULL, '$2y$10$AmPhh1p.d6ku5X1hH4NusOv92nJtZ7eox9qsckROTQ3J4N8t7m/SK', NULL, 13, NULL, NULL, NULL, NULL, 'رئيس قطاع شرق ( عضو مجلس الادارة )   رئيسا للادارة المركزية للتعاقدات مع مقاولى الباطن )', 'Head of East Region & the Central Department for Contracting with Subcontractors', 1, NULL, 1, NULL, NULL, '2022-03-21 07:17:25', '2022-03-23 10:24:26', 4),
(55, 'الديب', 'El Dieb', 'eldieb', 'eldieb.fake@eecegypt.com', '0000-014', NULL, '$2y$10$apOsbsnJoTNCWrmM9c5IZeo9pN6kJinZvJ7Z/2Q1NxVpWlzJx0I/K', 54, 1, NULL, NULL, NULL, NULL, 'مدير مشروع الكليات العسكرية', 'Military Colleges project manager', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:25', '2022-03-21 07:17:25', 4),
(56, 'موظف اختبار مشروع military Colleges', 'Employee Test military Colleges', 'employee.test.militaryColleges', 'employee.test.militaryColleges.fake@eecegypt.com', '0000-102', NULL, '$2y$10$iJnUc98KU8/rS1R.O9bmPuPVvsNOoM0BvrHI.SD0mpVixC8BC.kvi', 55, 13, NULL, 3, NULL, NULL, 'موظف', 'Employee', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:25', '2022-03-21 07:17:25', 4),
(57, 'شريف', 'Sherif', 'sherif', 'sherif.fake@eecegypt.com', '0000-011', NULL, '$2y$10$KZ56xm4q3CFz0l9zvmOUiODbQKyPVxI/lSNNsjBO8kw9T9OR9mQ4S', 54, 1, NULL, NULL, NULL, NULL, 'مدير مشروع الهايكستب', 'Haikstep project manager', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:25', '2022-03-21 07:17:25', 4),
(58, 'موظف اختبار مشروع haikstep', 'Employee Test haikstep', 'employee.test.$haikstep', 'employee.test.haikstep.fake@eecegypt.com', '0000-103', NULL, '$2y$10$8KJ/aE7WxzuSAd98sUdPGOOruJonxWyDpJ9iUc6hQIhSKe.n6nOPq', 57, 13, NULL, 4, NULL, NULL, 'موظف', 'Employee', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:25', '2022-03-21 07:17:25', 4),
(59, 'احمد محمود امين حسنين', 'Ahmed Mahmoud Amin Hassanein', 'ahmed.mahmoud', 'ahmed.mahmoud@eecegypt.com', NULL, NULL, '$2y$10$JFat3Ej.H4dvgRXieela6us6RhBxUghr014cbAqdMWK4cboFNk6Ey', NULL, 14, NULL, NULL, NULL, NULL, 'رئيس قطاع جنوب', 'Head of South Region', 1, NULL, 1, NULL, NULL, '2022-03-21 07:17:26', '2022-03-23 10:26:16', 4),
(60, '?2', '?2', '?2', '?2.fake@eecegypt.com', '0000-010', NULL, '$2y$10$McU2IuDaMKS004A0vnwjD.tRrkpdoFKcFUFLALUBFy7nkE5Rzmz6y', 59, 1, NULL, NULL, NULL, NULL, '?2', '?2', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:26', '2022-03-21 07:17:26', 4),
(61, 'موظف اختبار مشروع meniaUniversity', 'Employee Test meniaUniversity', 'employee.test.meniaUniversity', 'employee.test.meniaUniversity.fake@eecegypt.com', '0000-104', NULL, '$2y$10$OrJYZT1rw1TQq697eo2l/OMORViI0DjKkRhPJ1KG94EQbAz2MvvM6', 60, 14, NULL, 5, NULL, NULL, 'موظف', 'Employee', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:26', '2022-03-21 07:17:26', 4),
(62, 'هشام عبد الفاضل', 'Hesham Abd El Fadel', 'hesham.fadel', 'hesham.fadel@eecegypt.com', NULL, NULL, '$2y$10$MM3rUoZTi7altEJhmoxDaOJqDF3GSukm22ybuZhMXtQSaFdeyATuq', NULL, 15, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:26', '2022-03-23 10:27:41', 4),
(63, 'إنجي حشمت', 'Ingy Heshmat', 'ingy.heshmat', 'ingy.heshmat@eecegypt.com', NULL, NULL, '$2y$10$yry4shpdhJL0auPs/NJOAOA4ZHmxy0nLKGCCx6aqXfXABwOPah9PS', 2, 16, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:26', '2022-03-28 11:02:19', 1),
(64, 'كارمن رفعت', 'Karmen Refaat', 'karmen.refaat', 'karmen.refaat@eecegypt.com', NULL, NULL, '$2y$10$17RifJuGpokImfszogvvbesfapmcBpDt2We5CpgWJ0fJkXzBCI1XO', 2, 17, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:27', '2022-03-28 11:02:34', 1),
(65, 'عبد القادر محمد احمد هيكل', 'Abdel Qader Mohamed Ahmed Heikal', 'abdelqader.mohamed', 'abdelqader.mohamed.fake@eecegypt.com', '2868', NULL, '$2y$10$TIzzxoRVsGWgfiCK4Yu1deiBvAupZ6Cd6sti.Qem7cQsykaW6jAMu', NULL, 18, NULL, NULL, NULL, NULL, 'رئيس قطاع التشييد معدنى', 'Head of Steel Erection', 1, NULL, 1, NULL, NULL, '2022-03-21 07:17:27', '2022-03-21 07:17:27', 4),
(66, 'امجد حليم غبريال', 'Amjad Halim Ghobriel', 'Amjad.halim', 'Amjad.halim.fake@eecegypt.com', '614', NULL, '$2y$10$JhlyKj55w11fBgoz5eLEP.mshQAWxtxQ5vSGZnq0ivi4ilZtCZ82u', 20, 19, NULL, NULL, NULL, NULL, 'مدير الشبكات والتركيبات', 'External Purchasing Manager', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:28', '2022-03-21 07:17:28', 4),
(67, 'موظف اختبار مشروع mobinil', 'Employee Test mobinil', 'employee.test.mobinil', 'employee.test.mobinil.fake@eecegypt.com', '0000-105', NULL, '$2y$10$V3TwR5fhGTEfOxMIAnW9NOn1J.SGl.pNW2nobhd8TY/gLru4VNfhW', 66, 19, NULL, 6, NULL, NULL, 'موظف', 'Employee', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:28', '2022-03-21 07:17:28', 4),
(68, 'موظف اختبار مشروع etisalat', 'Employee Test etisalat', 'employee.test.etisalat', 'employee.test.etisalat.fake@eecegypt.com', '0000-106', NULL, '$2y$10$2Lc8T7ob8VHW3b0YyLGBX.Nn1XPnuzgzRThcFjIncCMRjKmiaqtj6', 66, 19, NULL, 7, NULL, NULL, 'موظف', 'Employee', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:29', '2022-03-21 07:17:29', 4),
(69, 'امجد عفيف', 'amjad', 'amjad', 'amjad@gmail.com', '2022-100', NULL, '$2y$10$aa8gA/bDyjQb63p1vQZtDOVPG3ASeAUTDcNM8dqRHEDlYRZ7hGcwe', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:29', '2022-03-21 07:17:29', 4),
(70, 'رفيق عيد', 'rafiq', 'rafiq', 'rafiq@gmail.com', '2022-101', NULL, '$2y$10$m52SnI7rG1oizPhzHsanN.1y/itIqsqDYOHGtJUj3TXDE0OXmneRW', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:29', '2022-03-21 07:17:29', 4),
(71, 'منشىء مصنع', 'factory builder', 'factory.builder', 'factory.builder@gmail.com', '2022-121', NULL, '$2y$10$YUbmtBRVRgxw6NwIvwz0Yu12qinrb7AQImu0h2fQmY47ndoSnnu8K', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:29', '2022-03-21 07:17:29', 4),
(73, ' واصف اسكندر ', 'wasf', 'wasf', 'wasf@gmail.com', '2022-103', NULL, '$2y$10$p3TGP9cI4LIheGIayoo1re8kEo5dDj1cspR3gD3GiaUolRtZEjc.S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:29', '2022-03-21 07:17:29', 4),
(74, 'ايمان محمود ', 'eman mahmoud ', 'eman.mahmoud', 'eman.mahmoud.fake@eecegypt.com', '3416', NULL, '$2y$10$qCfiG3FKS/tpAS7asOoD2OpgaescPuAJS9Df/5XadmplPRZ2C/LoW', NULL, 20, NULL, NULL, NULL, NULL, 'تطوير الاعمال', 'Business Development', 1, NULL, 1, NULL, NULL, '2022-03-21 07:17:30', '2022-03-21 07:17:30', 4),
(75, 'وسيم جيمى', 'Wasem jemy', 'wasem.jemy', 'wasem.jemy@eecegypt.com', '0000-115', NULL, '$2y$10$1atyYgwcSuBcnUav86evSOlDmoVunRNQk2IKNU7tvnli6jSRxRsC6', 47, 12, NULL, NULL, NULL, NULL, 'مدير مشروع الجامعه اليابانيه', 'japanese university project manager', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:30', '2022-03-21 07:17:30', 4),
(76, 'باسم انيس', 'Basem Anis', 'basem.anis', 'basem.anis@eecegypt.com', NULL, NULL, '$2y$10$ur8FfIq2D6eFHe5PpIkRN.UMVeaLFvhhx9XZPBvhetZeJKbrzx/M2', 47, 12, NULL, NULL, NULL, NULL, 'موظف', 'Employee', 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:30', '2022-03-28 10:57:53', 1),
(77, 'فريق الويب', 'Web Team', 'web.team', 'web.team@eecegypt.com', NULL, NULL, '$2y$10$sQlJq1vZgRodfQup08brAukVbEsJZVxPzM2cBlf2A5lFMUaHs4XWW', NULL, 3, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:51', '2022-03-24 10:57:57', 4),
(78, 'مايكل عبدالملاك', 'Michael Abd El Malak', 'michael.malak', 'michael.malak@eecegypt.com', NULL, NULL, '$2y$10$Gfwu7T7P6YZbiJfvuCm8EeFffZYqxqSLeLbiOYwlx1ycp12j2lI02', NULL, 6, 6, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:51', '2022-03-23 10:06:33', 4),
(79, 'جورج سمير', 'George Samir', 'george.samir', 'george.samir@eecegypt.com', NULL, NULL, '$2y$10$YmjlKsKCD7m6cFELZjUmOefUQ2OS7LFP1rfWpFDuqudyzF568YhTG', NULL, 6, 6, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:52', '2022-03-23 10:05:27', 4),
(80, 'بيشوي عياد', 'Beshoy Aiad', 'beshoy.aiad', 'beshoy.aiad@eecegypt.com', NULL, NULL, '$2y$10$83MM4maB33Zk2n.rITSrOOloQsXiYiB.S7DdlitN2ktAXVAs1uy7e', NULL, 6, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:52', '2022-03-23 10:07:24', 4),
(81, 'ملاك حنا', 'Malak Hanna', 'malak.hanna', 'malak.hanna@eecegypt.com', NULL, NULL, '$2y$10$kgU1LlTA6jSjNHFj1AuRU.VLUb83wS1NwLpgCBrxlgEW7CjbyCvii', NULL, 6, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:52', '2022-03-23 10:37:50', 4),
(82, 'ريمون شوقى', 'Remon Shawky', 'remon.shawky', 'remon.shawky@eecegypt.com', NULL, NULL, '$2y$10$aalk6Nq9OmpYh.vyybLNr.lwJwrREnxKefmo9XP7VR2mBuD/gwjeW', NULL, 6, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:52', '2022-03-23 10:08:08', 4),
(83, 'امير ثروت', 'Amir Tharwat', 'amir.tharwat', 'amir.tharwat@eecegypt.com', NULL, NULL, '$2y$10$4k8S3RJ1KLgLwcvmUnW83uKQmDdDxDCSfAZwROpOdKTLDLhZUIbWi', NULL, 6, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:52', '2022-03-23 10:08:37', 4),
(84, 'الفريد سمير', 'Alfred Samir', 'alfred.samir', 'alfred.samir@eecegypt.com', NULL, NULL, '$2y$10$z6cxecV9DeHHp.edmJy2LOqqilgmkLQtuiVdNsgPavZ0J42gurcp.', NULL, 6, 16, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:52', '2022-03-23 10:10:20', 4),
(85, 'بانوب سمير', 'Banob Samir', 'banob.samir', 'banob.samir@eecegypt.com', NULL, NULL, '$2y$10$H64nKlC654tVUjaNZ3cmFOvCuCryQHEVtdMrm8rZkUnPzyNw0i5Qu', NULL, 6, 16, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:52', '2022-03-23 10:09:58', 4),
(86, 'مايكل عطا', 'Michael Atta', 'michael.atta', 'michael.atta@eecegypt.com', NULL, NULL, '$2y$10$BRgLOhYI/gst1bJGgW0FhOTlfLLX/6J.GjE0o89Rjc9cpWq6cHaxK', NULL, 6, 16, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:53', '2022-03-23 10:09:26', 4),
(87, 'جوليانا عماد', 'Juliana emad', 'juliana.emad', 'juliana.emad@eecegypt.com', NULL, NULL, '$2y$10$lC58tX/vpYCeXTEujTIG/OwSwKkPG8rsMHhue2BIIUKSyBlw61FPG', NULL, 6, 16, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:53', '2022-03-23 10:09:06', 4),
(88, 'ايليا عاطف', 'Elia Atef', 'elia.atef', 'elia.atef@eecegypt.com', NULL, NULL, '$2y$10$ASSwK3FtTYhtDBklxrBSKe8o8FMtocPwQ3muIKsuiMXTmftCyfkhO', NULL, 4, 8, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:53', '2022-03-23 10:13:26', 4),
(89, 'بيتر مكرم', 'Peter Makram', 'peter.makram', 'peter.makram@eecegypt.com', NULL, NULL, '$2y$10$mtaQ5Qd7IVueStkTvutk0Oj8EguN2SCVpSA35QQ1UxRtCf55ikHY.', NULL, 4, 8, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:53', '2022-03-23 10:13:09', 4),
(90, 'محسن فتحي', 'Mohsen fathy', 'mohsen.fathy', 'mohsen.fathy@eecegypt.com', NULL, NULL, '$2y$10$8Ih2SFW5.Tvvhf4CcABDT.8LfrURK7bKX0V1IORu9FPn//8ZKrmcm', NULL, 4, 8, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:53', '2022-03-23 10:12:54', 4),
(91, 'وليد صادق', 'Walid Sadek', 'walid.sadek', 'walid.sadek@eecegypt.com', NULL, NULL, '$2y$10$6Fjyi7Xk3OCxMZhrgYwbrOcxUfDjR7tB2VO6UsXzqKOhWv0cgvOky', NULL, 4, 8, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:54', '2022-03-23 10:12:35', 4),
(92, 'محمد عبد الحليم', 'Mohamed Abd El halim', 'mohamed.halim', 'mohamed.halim@eecegypt.com', NULL, NULL, '$2y$10$91Hhluejj8GhF2EX62p1xOENYo56GUOWXYHC91lIlQyD6asP3sJE6', NULL, 4, 8, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:54', '2022-03-23 10:12:19', 4),
(93, 'هانى حلمى', 'Hany Helmy', 'hany.helmy', 'hany.helmy@eecegypt.com', NULL, NULL, '$2y$10$TLBXOaUjETU61LZsA9Prp.P52eZriMhmGbfSlnnlh4JnGt0pwYmnW', NULL, 4, 7, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:54', '2022-03-23 10:15:57', 4),
(94, 'مريم حسين', 'Mariam Hussien', 'mariam.hussien', 'mariam.hussien@eecegypt.com', NULL, NULL, '$2y$10$gBVY0OVKljNV0LsSD4v4p.hTiWqBmbwYpccCBensUFy3RTQXnZ0GC', NULL, 4, 7, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:54', '2022-03-23 10:15:41', 4),
(95, 'اشرف مسعد', 'Ashraf Mosaad', 'ashraf.mosaad', 'ashraf.mosaad@eecegypt.com', NULL, NULL, '$2y$10$b405OSo7rahs2rIQWz9a6utNhWKnpR6XQ.tXPP3DXECKdmDGTLpUG', NULL, 4, 7, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:54', '2022-03-23 10:15:25', 4),
(96, 'يوسف محمود', 'Youssef Mahmoud', 'youssef.mahmoud', 'youssef.mahmoud@eecegypt.com', NULL, NULL, '$2y$10$K44kCG84MZZmavCy961jIO2wTIezgzergTo.lrSjqeBOJsM7nmgnK', 54, 13, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:54', '2022-03-28 10:58:12', 1),
(97, 'فيفيان فهمي', 'Vivian Fahmy', 'vivian.fahmy', 'vivian.fahmy@eecegypt.com', NULL, NULL, '$2y$10$OYYhCEDj7xWwabK/OCUqh.6.HSqsfhyIXoUtvhgyIGCHvcJUO11O6', 59, 14, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:55', '2022-03-28 10:58:35', 1),
(98, 'جورج ابو الخير', 'George Abu El Kheir', 'george.kheir', 'george.kheir@eecegypt.com', NULL, NULL, '$2y$10$gNJdFgxnW53Yjbv1Q.zzAusvzcQqBoDx.qnCuqzKILmyQIhAzyD0y', 62, 15, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, NULL, '2022-03-21 07:17:55', '2022-03-28 10:58:52', 1),
(99, 'احمد الفرماوي', 'ahmed.elfarmawy', 'ahmed.elfarmawy', 'ahmed.farmawy@eecegypt.com', '4000000000', NULL, '$2y$10$PhnKcKaw2rV47OV3zV2oduosjnig2qS8dXdjSmjpvkvphnKcS9vfK', 47, 12, NULL, NULL, NULL, NULL, 'مهندس مكتب فني', 'Engineer', 1, NULL, 0, NULL, NULL, '2022-03-23 11:01:31', '2022-03-23 11:01:31', 0),
(100, 'منار الهامي', 'Manar Elhamy', 'manar.elhamy', 'manar.elhamy@gmail.com', '394', NULL, '$2y$10$h9F/8WrWhxxXwWCxy80tF.Bp5vKDyVVh6LGNQjsJdqkJDY03fpCi6', 20, 6, NULL, NULL, NULL, NULL, 'نائب الرئيس التنفيذي لمساعد المشاريع', 'Deputy of CEO for projects Assistant', 1, NULL, 0, NULL, NULL, '2022-03-28 11:07:33', '2022-03-28 11:07:33', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`id`, `group_id`, `user_id`, `created_at`, `updated_at`) VALUES
(9, 5, 79, '2022-03-23 10:05:27', '2022-03-23 10:05:27'),
(10, 6, 79, '2022-03-23 10:05:27', '2022-03-23 10:05:27'),
(11, 5, 78, '2022-03-23 10:06:33', '2022-03-23 10:06:33'),
(12, 6, 78, '2022-03-23 10:06:33', '2022-03-23 10:06:33'),
(13, 5, 80, '2022-03-23 10:07:24', '2022-03-23 10:07:24'),
(14, 6, 80, '2022-03-23 10:07:24', '2022-03-23 10:07:24'),
(15, 5, 82, '2022-03-23 10:08:08', '2022-03-23 10:08:08'),
(16, 6, 82, '2022-03-23 10:08:08', '2022-03-23 10:08:08'),
(17, 5, 83, '2022-03-23 10:08:37', '2022-03-23 10:08:37'),
(18, 6, 83, '2022-03-23 10:08:37', '2022-03-23 10:08:37'),
(19, 5, 87, '2022-03-23 10:09:06', '2022-03-23 10:09:06'),
(20, 6, 87, '2022-03-23 10:09:06', '2022-03-23 10:09:06'),
(21, 5, 86, '2022-03-23 10:09:26', '2022-03-23 10:09:26'),
(22, 6, 86, '2022-03-23 10:09:26', '2022-03-23 10:09:26'),
(23, 5, 85, '2022-03-23 10:09:58', '2022-03-23 10:09:58'),
(24, 6, 85, '2022-03-23 10:09:58', '2022-03-23 10:09:58'),
(25, 5, 84, '2022-03-23 10:10:20', '2022-03-23 10:10:20'),
(26, 6, 84, '2022-03-23 10:10:20', '2022-03-23 10:10:20'),
(27, 5, 21, '2022-03-23 10:10:40', '2022-03-23 10:10:40'),
(28, 6, 21, '2022-03-23 10:10:40', '2022-03-23 10:10:40'),
(29, 5, 22, '2022-03-23 10:11:01', '2022-03-23 10:11:01'),
(30, 6, 22, '2022-03-23 10:11:01', '2022-03-23 10:11:01'),
(31, 1, 20, '2022-03-23 10:11:56', '2022-03-23 10:11:56'),
(32, 2, 20, '2022-03-23 10:11:56', '2022-03-23 10:11:56'),
(33, 3, 20, '2022-03-23 10:11:56', '2022-03-23 10:11:56'),
(34, 5, 20, '2022-03-23 10:11:56', '2022-03-23 10:11:56'),
(35, 6, 20, '2022-03-23 10:11:56', '2022-03-23 10:11:56'),
(36, 5, 92, '2022-03-23 10:12:19', '2022-03-23 10:12:19'),
(37, 6, 92, '2022-03-23 10:12:19', '2022-03-23 10:12:19'),
(38, 5, 91, '2022-03-23 10:12:35', '2022-03-23 10:12:35'),
(39, 6, 91, '2022-03-23 10:12:35', '2022-03-23 10:12:35'),
(40, 5, 90, '2022-03-23 10:12:54', '2022-03-23 10:12:54'),
(41, 6, 90, '2022-03-23 10:12:54', '2022-03-23 10:12:54'),
(42, 5, 89, '2022-03-23 10:13:09', '2022-03-23 10:13:09'),
(43, 6, 89, '2022-03-23 10:13:09', '2022-03-23 10:13:09'),
(44, 5, 88, '2022-03-23 10:13:26', '2022-03-23 10:13:26'),
(45, 6, 88, '2022-03-23 10:13:26', '2022-03-23 10:13:26'),
(46, 5, 12, '2022-03-23 10:15:06', '2022-03-23 10:15:06'),
(47, 6, 12, '2022-03-23 10:15:06', '2022-03-23 10:15:06'),
(48, 5, 95, '2022-03-23 10:15:25', '2022-03-23 10:15:25'),
(49, 6, 95, '2022-03-23 10:15:25', '2022-03-23 10:15:25'),
(50, 5, 94, '2022-03-23 10:15:41', '2022-03-23 10:15:41'),
(51, 6, 94, '2022-03-23 10:15:41', '2022-03-23 10:15:41'),
(52, 5, 93, '2022-03-23 10:15:57', '2022-03-23 10:15:57'),
(53, 6, 93, '2022-03-23 10:15:57', '2022-03-23 10:15:57'),
(54, 5, 11, '2022-03-23 10:16:48', '2022-03-23 10:16:48'),
(55, 6, 11, '2022-03-23 10:16:48', '2022-03-23 10:16:48'),
(66, 1, 49, '2022-03-23 10:19:35', '2022-03-23 10:19:35'),
(67, 2, 49, '2022-03-23 10:19:35', '2022-03-23 10:19:35'),
(68, 3, 49, '2022-03-23 10:19:35', '2022-03-23 10:19:35'),
(69, 5, 49, '2022-03-23 10:19:35', '2022-03-23 10:19:35'),
(70, 6, 49, '2022-03-23 10:19:35', '2022-03-23 10:19:35'),
(71, 1, 48, '2022-03-23 10:20:05', '2022-03-23 10:20:05'),
(72, 2, 48, '2022-03-23 10:20:05', '2022-03-23 10:20:05'),
(73, 3, 48, '2022-03-23 10:20:05', '2022-03-23 10:20:05'),
(74, 5, 48, '2022-03-23 10:20:05', '2022-03-23 10:20:05'),
(75, 6, 48, '2022-03-23 10:20:05', '2022-03-23 10:20:05'),
(81, 1, 47, '2022-03-23 10:23:13', '2022-03-23 10:23:13'),
(82, 2, 47, '2022-03-23 10:23:13', '2022-03-23 10:23:13'),
(83, 3, 47, '2022-03-23 10:23:13', '2022-03-23 10:23:13'),
(84, 5, 47, '2022-03-23 10:23:13', '2022-03-23 10:23:13'),
(85, 6, 47, '2022-03-23 10:23:13', '2022-03-23 10:23:13'),
(91, 1, 54, '2022-03-23 10:24:26', '2022-03-23 10:24:26'),
(92, 2, 54, '2022-03-23 10:24:26', '2022-03-23 10:24:26'),
(93, 3, 54, '2022-03-23 10:24:26', '2022-03-23 10:24:26'),
(94, 5, 54, '2022-03-23 10:24:26', '2022-03-23 10:24:26'),
(95, 6, 54, '2022-03-23 10:24:26', '2022-03-23 10:24:26'),
(101, 1, 59, '2022-03-23 10:26:16', '2022-03-23 10:26:16'),
(102, 2, 59, '2022-03-23 10:26:16', '2022-03-23 10:26:16'),
(103, 3, 59, '2022-03-23 10:26:16', '2022-03-23 10:26:16'),
(104, 5, 59, '2022-03-23 10:26:16', '2022-03-23 10:26:16'),
(105, 6, 59, '2022-03-23 10:26:16', '2022-03-23 10:26:16'),
(111, 1, 62, '2022-03-23 10:27:41', '2022-03-23 10:27:41'),
(112, 2, 62, '2022-03-23 10:27:41', '2022-03-23 10:27:41'),
(113, 3, 62, '2022-03-23 10:27:41', '2022-03-23 10:27:41'),
(114, 5, 62, '2022-03-23 10:27:41', '2022-03-23 10:27:41'),
(115, 6, 62, '2022-03-23 10:27:41', '2022-03-23 10:27:41'),
(116, 5, 28, '2022-03-23 10:28:36', '2022-03-23 10:28:36'),
(117, 6, 28, '2022-03-23 10:28:36', '2022-03-23 10:28:36'),
(118, 5, 24, '2022-03-23 10:29:06', '2022-03-23 10:29:06'),
(119, 6, 24, '2022-03-23 10:29:06', '2022-03-23 10:29:06'),
(120, 5, 33, '2022-03-23 10:30:13', '2022-03-23 10:30:13'),
(121, 6, 33, '2022-03-23 10:30:13', '2022-03-23 10:30:13'),
(122, 5, 25, '2022-03-23 10:30:37', '2022-03-23 10:30:37'),
(123, 6, 25, '2022-03-23 10:30:37', '2022-03-23 10:30:37'),
(124, 5, 31, '2022-03-23 10:30:55', '2022-03-23 10:30:55'),
(125, 6, 31, '2022-03-23 10:30:55', '2022-03-23 10:30:55'),
(126, 5, 26, '2022-03-23 10:31:12', '2022-03-23 10:31:12'),
(127, 6, 26, '2022-03-23 10:31:12', '2022-03-23 10:31:12'),
(128, 5, 27, '2022-03-23 10:31:27', '2022-03-23 10:31:27'),
(129, 6, 27, '2022-03-23 10:31:27', '2022-03-23 10:31:27'),
(130, 5, 29, '2022-03-23 10:31:46', '2022-03-23 10:31:46'),
(131, 6, 29, '2022-03-23 10:31:46', '2022-03-23 10:31:46'),
(132, 5, 30, '2022-03-23 10:32:04', '2022-03-23 10:32:04'),
(133, 6, 30, '2022-03-23 10:32:04', '2022-03-23 10:32:04'),
(135, 5, 32, '2022-03-23 10:32:58', '2022-03-23 10:32:58'),
(136, 6, 32, '2022-03-23 10:32:58', '2022-03-23 10:32:58'),
(137, 5, 23, '2022-03-23 10:33:15', '2022-03-23 10:33:15'),
(138, 6, 23, '2022-03-23 10:33:15', '2022-03-23 10:33:15'),
(139, 5, 39, '2022-03-23 10:33:54', '2022-03-23 10:33:54'),
(140, 6, 39, '2022-03-23 10:33:54', '2022-03-23 10:33:54'),
(141, 5, 38, '2022-03-23 10:34:21', '2022-03-23 10:34:21'),
(142, 6, 38, '2022-03-23 10:34:21', '2022-03-23 10:34:21'),
(143, 5, 37, '2022-03-23 10:34:40', '2022-03-23 10:34:40'),
(144, 6, 37, '2022-03-23 10:34:40', '2022-03-23 10:34:40'),
(145, 5, 40, '2022-03-23 10:35:24', '2022-03-23 10:35:24'),
(146, 6, 40, '2022-03-23 10:35:24', '2022-03-23 10:35:24'),
(147, 5, 41, '2022-03-23 10:35:52', '2022-03-23 10:35:52'),
(148, 6, 41, '2022-03-23 10:35:52', '2022-03-23 10:35:52'),
(149, 5, 42, '2022-03-23 10:36:08', '2022-03-23 10:36:08'),
(150, 6, 42, '2022-03-23 10:36:08', '2022-03-23 10:36:08'),
(151, 5, 36, '2022-03-23 10:36:49', '2022-03-23 10:36:49'),
(152, 6, 36, '2022-03-23 10:36:49', '2022-03-23 10:36:49'),
(161, 5, 81, '2022-03-23 10:37:50', '2022-03-23 10:37:50'),
(162, 6, 81, '2022-03-23 10:37:50', '2022-03-23 10:37:50'),
(163, 1, 99, '2022-03-23 11:01:31', '2022-03-23 11:01:31'),
(164, 2, 99, '2022-03-23 11:01:31', '2022-03-23 11:01:31'),
(165, 3, 99, '2022-03-23 11:01:31', '2022-03-23 11:01:31'),
(166, 5, 99, '2022-03-23 11:01:31', '2022-03-23 11:01:31'),
(167, 6, 99, '2022-03-23 11:01:31', '2022-03-23 11:01:31'),
(183, 1, 50, '2022-03-23 11:51:45', '2022-03-23 11:51:45'),
(184, 2, 50, '2022-03-23 11:51:45', '2022-03-23 11:51:45'),
(190, 5, 46, '2022-03-24 09:55:31', '2022-03-24 09:55:31'),
(191, 6, 46, '2022-03-24 09:55:31', '2022-03-24 09:55:31'),
(192, 1, 77, '2022-03-24 10:57:57', '2022-03-24 10:57:57'),
(193, 2, 77, '2022-03-24 10:57:57', '2022-03-24 10:57:57'),
(194, 4, 77, '2022-03-24 10:57:57', '2022-03-24 10:57:57'),
(195, 5, 77, '2022-03-24 10:57:57', '2022-03-24 10:57:57'),
(211, 1, 76, '2022-03-28 10:57:53', '2022-03-28 10:57:53'),
(212, 2, 76, '2022-03-28 10:57:53', '2022-03-28 10:57:53'),
(213, 3, 76, '2022-03-28 10:57:53', '2022-03-28 10:57:53'),
(214, 5, 76, '2022-03-28 10:57:53', '2022-03-28 10:57:53'),
(215, 6, 76, '2022-03-28 10:57:53', '2022-03-28 10:57:53'),
(216, 1, 96, '2022-03-28 10:58:12', '2022-03-28 10:58:12'),
(217, 2, 96, '2022-03-28 10:58:12', '2022-03-28 10:58:12'),
(218, 3, 96, '2022-03-28 10:58:12', '2022-03-28 10:58:12'),
(219, 5, 96, '2022-03-28 10:58:12', '2022-03-28 10:58:12'),
(220, 6, 96, '2022-03-28 10:58:12', '2022-03-28 10:58:12'),
(221, 1, 97, '2022-03-28 10:58:35', '2022-03-28 10:58:35'),
(222, 2, 97, '2022-03-28 10:58:35', '2022-03-28 10:58:35'),
(223, 3, 97, '2022-03-28 10:58:35', '2022-03-28 10:58:35'),
(224, 5, 97, '2022-03-28 10:58:35', '2022-03-28 10:58:35'),
(225, 6, 97, '2022-03-28 10:58:35', '2022-03-28 10:58:35'),
(226, 1, 98, '2022-03-28 10:58:52', '2022-03-28 10:58:52'),
(227, 2, 98, '2022-03-28 10:58:52', '2022-03-28 10:58:52'),
(228, 3, 98, '2022-03-28 10:58:52', '2022-03-28 10:58:52'),
(229, 5, 98, '2022-03-28 10:58:52', '2022-03-28 10:58:52'),
(230, 6, 98, '2022-03-28 10:58:52', '2022-03-28 10:58:52'),
(236, 1, 63, '2022-03-28 11:02:19', '2022-03-28 11:02:19'),
(237, 2, 63, '2022-03-28 11:02:19', '2022-03-28 11:02:19'),
(238, 3, 63, '2022-03-28 11:02:19', '2022-03-28 11:02:19'),
(239, 5, 63, '2022-03-28 11:02:19', '2022-03-28 11:02:19'),
(240, 6, 63, '2022-03-28 11:02:19', '2022-03-28 11:02:19'),
(241, 5, 64, '2022-03-28 11:02:34', '2022-03-28 11:02:34'),
(242, 6, 64, '2022-03-28 11:02:34', '2022-03-28 11:02:34'),
(243, 7, 64, '2022-03-28 11:02:34', '2022-03-28 11:02:34'),
(244, 1, 100, '2022-03-28 11:07:33', '2022-03-28 11:07:33'),
(245, 2, 100, '2022-03-28 11:07:33', '2022-03-28 11:07:33'),
(246, 3, 100, '2022-03-28 11:07:33', '2022-03-28 11:07:33'),
(247, 5, 100, '2022-03-28 11:07:33', '2022-03-28 11:07:33'),
(248, 6, 100, '2022-03-28 11:07:33', '2022-03-28 11:07:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_statements`
--
ALTER TABLE `account_statements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_statements_user_id_foreign` (`user_id`),
  ADD KEY `account_statements_supplier_id_foreign` (`supplier_id`),
  ADD KEY `account_statements_invoice_id_foreign` (`invoice_id`),
  ADD KEY `account_statements_payment_id_foreign` (`payment_id`);

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_country_id_foreign` (`country_id`),
  ADD KEY `addresses_governorate_id_foreign` (`governorate_id`);

--
-- Indexes for table `approval_cycles`
--
ALTER TABLE `approval_cycles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `approval_cycle_approval_steps`
--
ALTER TABLE `approval_cycle_approval_steps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `approval_cycle_approval_steps_approval_cycle_id_foreign` (`approval_cycle_id`),
  ADD KEY `approval_cycle_approval_steps_approval_step_id_foreign` (`approval_step_id`),
  ADD KEY `approval_cycle_approval_steps_next_id_foreign` (`next_id`),
  ADD KEY `approval_cycle_approval_steps_previous_id_foreign` (`previous_id`);

--
-- Indexes for table `approval_steps`
--
ALTER TABLE `approval_steps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `approval_timelines`
--
ALTER TABLE `approval_timelines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `approval_timelines_approval_cycle_approval_step_id_foreign` (`approval_cycle_approval_step_id`),
  ADD KEY `approval_timelines_user_id_foreign` (`user_id`);

--
-- Indexes for table `approval_timeline_comments`
--
ALTER TABLE `approval_timeline_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `approval_timeline_comments_approval_timeline_id_foreign` (`approval_timeline_id`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `banks_bank_code_unique` (`bank_code`);

--
-- Indexes for table `business_natures`
--
ALTER TABLE `business_natures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `business_natures_item_id_foreign` (`item_id`);

--
-- Indexes for table `cheque_item_requests`
--
ALTER TABLE `cheque_item_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cheque_item_requests_cheque_id_foreign` (`cheque_id`);

--
-- Indexes for table `cheque_requests`
--
ALTER TABLE `cheque_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cheque_requests_requester_id_foreign` (`requester_id`),
  ADD KEY `cheque_requests_supplier_id_foreign` (`supplier_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departments_sector_id_foreign` (`sector_id`),
  ADD KEY `departments_manager_id_foreign` (`manager_id`),
  ADD KEY `departments_delegated_id_foreign` (`delegated_id`);

--
-- Indexes for table `discount_types`
--
ALTER TABLE `discount_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `family_names`
--
ALTER TABLE `family_names`
  ADD PRIMARY KEY (`id`),
  ADD KEY `family_names_sub_group_id_foreign` (`sub_group_id`);

--
-- Indexes for table `family_name_suppliers`
--
ALTER TABLE `family_name_suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `family_name_suppliers_supplier_id_foreign` (`supplier_id`),
  ADD KEY `family_name_suppliers_family_name_id_foreign` (`family_name_id`);

--
-- Indexes for table `file_purchase_orders`
--
ALTER TABLE `file_purchase_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `file_purchase_orders_purchase_order_id_foreign` (`purchase_order_id`);

--
-- Indexes for table `file_purchase_requests`
--
ALTER TABLE `file_purchase_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `file_purchase_requests_purchase_request_id_foreign` (`purchase_request_id`);

--
-- Indexes for table `governorates`
--
ALTER TABLE `governorates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `governorates_country_id_foreign` (`country_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inquiry_purchase_requests`
--
ALTER TABLE `inquiry_purchase_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inquiry_purchase_requests_purchase_request_id_foreign` (`purchase_request_id`),
  ADD KEY `inquiry_purchase_requests_item_request_id_foreign` (`item_request_id`),
  ADD KEY `inquiry_purchase_requests_send_id_foreign` (`send_id`),
  ADD KEY `inquiry_purchase_requests_receive_id_foreign` (`receive_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoices_item_id_foreign` (`item_id`),
  ADD KEY `invoices_project_id_foreign` (`project_id`),
  ADD KEY `invoices_business_nature_id_foreign` (`business_nature_id`),
  ADD KEY `invoices_supplier_id_foreign` (`supplier_id`),
  ADD KEY `invoices_po_id_foreign` (`po_id`),
  ADD KEY `invoices_nature_dealing_id_foreign` (`nature_dealing_id`),
  ADD KEY `invoices_user_id_foreign` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_orders`
--
ALTER TABLE `item_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_orders_purchase_order_id_foreign` (`purchase_order_id`),
  ADD KEY `item_orders_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `item_requests`
--
ALTER TABLE `item_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_requests_purchase_request_id_foreign` (`purchase_request_id`),
  ADD KEY `item_requests_family_name_id_foreign` (`family_name_id`),
  ADD KEY `item_requests_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `job_codes`
--
ALTER TABLE `job_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_codes_department_id_foreign` (`department_id`);

--
-- Indexes for table `job_grades`
--
ALTER TABLE `job_grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_grades_job_code_id_foreign` (`job_code_id`);

--
-- Indexes for table `job_names`
--
ALTER TABLE `job_names`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_names_job_code_id_foreign` (`job_code_id`);

--
-- Indexes for table `material_receipts`
--
ALTER TABLE `material_receipts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `material_receipts_item_order_id_foreign` (`item_order_id`);

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
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `nature_dealings`
--
ALTER TABLE `nature_dealings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nature_dealings_discount_type_id_foreign` (`discount_type_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment_invoices`
--
ALTER TABLE `payment_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_invoices_item_id_foreign` (`item_id`),
  ADD KEY `payment_invoices_project_id_foreign` (`project_id`),
  ADD KEY `payment_invoices_supplier_id_foreign` (`supplier_id`),
  ADD KEY `payment_invoices_bank_id_foreign` (`bank_id`),
  ADD KEY `payment_invoices_supplier_bank_id_foreign` (`supplier_bank_id`),
  ADD KEY `payment_invoices_user_id_foreign` (`user_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `person_suppliers`
--
ALTER TABLE `person_suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `person_suppliers_supplier_id_foreign` (`supplier_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projects_item_id_foreign` (`item_id`),
  ADD KEY `projects_business_nature_id_foreign` (`business_nature_id`),
  ADD KEY `projects_sector_id_foreign` (`sector_id`),
  ADD KEY `projects_manager_id_foreign` (`manager_id`),
  ADD KEY `projects_delegated_id_foreign` (`delegated_id`),
  ADD KEY `projects_group_id_foreign` (`group_id`);

--
-- Indexes for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_orders_requester_id_foreign` (`requester_id`),
  ADD KEY `purchase_orders_supplier_id_foreign` (`supplier_id`);

--
-- Indexes for table `purchase_requests`
--
ALTER TABLE `purchase_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_requests_requester_id_foreign` (`requester_id`),
  ADD KEY `purchase_requests_sector_id_foreign` (`sector_id`),
  ADD KEY `purchase_requests_department_id_foreign` (`department_id`),
  ADD KEY `purchase_requests_project_id_foreign` (`project_id`),
  ADD KEY `purchase_requests_site_id_foreign` (`site_id`),
  ADD KEY `purchase_requests_group_id_foreign` (`group_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sectors`
--
ALTER TABLE `sectors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sectors_head_id_foreign` (`head_id`),
  ADD KEY `sectors_delegated_id_foreign` (`delegated_id`),
  ADD KEY `sectors_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `sites`
--
ALTER TABLE `sites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sites_project_id_foreign` (`project_id`);

--
-- Indexes for table `sub_groups`
--
ALTER TABLE `sub_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_groups_group_id_foreign` (`group_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `suppliers_name_ar_unique` (`name_ar`),
  ADD UNIQUE KEY `suppliers_name_en_unique` (`name_en`),
  ADD KEY `suppliers_address_id_foreign` (`address_id`);

--
-- Indexes for table `supplier_bank_transfers`
--
ALTER TABLE `supplier_bank_transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_bank_transfers_supplier_id_foreign` (`supplier_id`);

--
-- Indexes for table `supplier_cheques`
--
ALTER TABLE `supplier_cheques`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_cheques_supplier_id_foreign` (`supplier_id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `units_code_unique` (`code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_code_unique` (`code`),
  ADD KEY `users_manager_id_foreign` (`manager_id`),
  ADD KEY `users_sector_id_foreign` (`sector_id`),
  ADD KEY `users_department_id_foreign` (`department_id`),
  ADD KEY `users_job_name_id_foreign` (`job_name_id`),
  ADD KEY `users_job_grade_id_foreign` (`job_grade_id`),
  ADD KEY `users_project_id_foreign` (`project_id`);

--
-- Indexes for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_groups_group_id_foreign` (`group_id`),
  ADD KEY `user_groups_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_statements`
--
ALTER TABLE `account_statements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `approval_cycles`
--
ALTER TABLE `approval_cycles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `approval_cycle_approval_steps`
--
ALTER TABLE `approval_cycle_approval_steps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `approval_steps`
--
ALTER TABLE `approval_steps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `approval_timelines`
--
ALTER TABLE `approval_timelines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `approval_timeline_comments`
--
ALTER TABLE `approval_timeline_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `business_natures`
--
ALTER TABLE `business_natures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `cheque_item_requests`
--
ALTER TABLE `cheque_item_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cheque_requests`
--
ALTER TABLE `cheque_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=246;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `discount_types`
--
ALTER TABLE `discount_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `family_names`
--
ALTER TABLE `family_names`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `family_name_suppliers`
--
ALTER TABLE `family_name_suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `file_purchase_orders`
--
ALTER TABLE `file_purchase_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `file_purchase_requests`
--
ALTER TABLE `file_purchase_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `governorates`
--
ALTER TABLE `governorates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `inquiry_purchase_requests`
--
ALTER TABLE `inquiry_purchase_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `item_orders`
--
ALTER TABLE `item_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_requests`
--
ALTER TABLE `item_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `job_codes`
--
ALTER TABLE `job_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `job_grades`
--
ALTER TABLE `job_grades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `job_names`
--
ALTER TABLE `job_names`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `material_receipts`
--
ALTER TABLE `material_receipts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `nature_dealings`
--
ALTER TABLE `nature_dealings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `payment_invoices`
--
ALTER TABLE `payment_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=169;

--
-- AUTO_INCREMENT for table `person_suppliers`
--
ALTER TABLE `person_suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_requests`
--
ALTER TABLE `purchase_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `sectors`
--
ALTER TABLE `sectors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `sites`
--
ALTER TABLE `sites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sub_groups`
--
ALTER TABLE `sub_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `supplier_bank_transfers`
--
ALTER TABLE `supplier_bank_transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `supplier_cheques`
--
ALTER TABLE `supplier_cheques`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=249;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account_statements`
--
ALTER TABLE `account_statements`
  ADD CONSTRAINT `account_statements_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`),
  ADD CONSTRAINT `account_statements_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payment_invoices` (`id`),
  ADD CONSTRAINT `account_statements_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
  ADD CONSTRAINT `account_statements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `addresses_governorate_id_foreign` FOREIGN KEY (`governorate_id`) REFERENCES `governorates` (`id`);

--
-- Constraints for table `approval_cycle_approval_steps`
--
ALTER TABLE `approval_cycle_approval_steps`
  ADD CONSTRAINT `approval_cycle_approval_steps_approval_cycle_id_foreign` FOREIGN KEY (`approval_cycle_id`) REFERENCES `approval_cycles` (`id`),
  ADD CONSTRAINT `approval_cycle_approval_steps_approval_step_id_foreign` FOREIGN KEY (`approval_step_id`) REFERENCES `approval_steps` (`id`),
  ADD CONSTRAINT `approval_cycle_approval_steps_next_id_foreign` FOREIGN KEY (`next_id`) REFERENCES `approval_cycle_approval_steps` (`id`),
  ADD CONSTRAINT `approval_cycle_approval_steps_previous_id_foreign` FOREIGN KEY (`previous_id`) REFERENCES `approval_cycle_approval_steps` (`id`);

--
-- Constraints for table `approval_timelines`
--
ALTER TABLE `approval_timelines`
  ADD CONSTRAINT `approval_timelines_approval_cycle_approval_step_id_foreign` FOREIGN KEY (`approval_cycle_approval_step_id`) REFERENCES `approval_cycle_approval_steps` (`id`),
  ADD CONSTRAINT `approval_timelines_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `approval_timeline_comments`
--
ALTER TABLE `approval_timeline_comments`
  ADD CONSTRAINT `approval_timeline_comments_approval_timeline_id_foreign` FOREIGN KEY (`approval_timeline_id`) REFERENCES `approval_timelines` (`id`);

--
-- Constraints for table `business_natures`
--
ALTER TABLE `business_natures`
  ADD CONSTRAINT `business_natures_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`);

--
-- Constraints for table `cheque_item_requests`
--
ALTER TABLE `cheque_item_requests`
  ADD CONSTRAINT `cheque_item_requests_cheque_id_foreign` FOREIGN KEY (`cheque_id`) REFERENCES `cheque_requests` (`id`);

--
-- Constraints for table `cheque_requests`
--
ALTER TABLE `cheque_requests`
  ADD CONSTRAINT `cheque_requests_requester_id_foreign` FOREIGN KEY (`requester_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cheque_requests_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`);

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_delegated_id_foreign` FOREIGN KEY (`delegated_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `departments_manager_id_foreign` FOREIGN KEY (`manager_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `departments_sector_id_foreign` FOREIGN KEY (`sector_id`) REFERENCES `sectors` (`id`);

--
-- Constraints for table `family_names`
--
ALTER TABLE `family_names`
  ADD CONSTRAINT `family_names_sub_group_id_foreign` FOREIGN KEY (`sub_group_id`) REFERENCES `sub_groups` (`id`);

--
-- Constraints for table `family_name_suppliers`
--
ALTER TABLE `family_name_suppliers`
  ADD CONSTRAINT `family_name_suppliers_family_name_id_foreign` FOREIGN KEY (`family_name_id`) REFERENCES `family_names` (`id`),
  ADD CONSTRAINT `family_name_suppliers_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`);

--
-- Constraints for table `file_purchase_orders`
--
ALTER TABLE `file_purchase_orders`
  ADD CONSTRAINT `file_purchase_orders_purchase_order_id_foreign` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`);

--
-- Constraints for table `file_purchase_requests`
--
ALTER TABLE `file_purchase_requests`
  ADD CONSTRAINT `file_purchase_requests_purchase_request_id_foreign` FOREIGN KEY (`purchase_request_id`) REFERENCES `purchase_requests` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `governorates`
--
ALTER TABLE `governorates`
  ADD CONSTRAINT `governorates_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`);

--
-- Constraints for table `inquiry_purchase_requests`
--
ALTER TABLE `inquiry_purchase_requests`
  ADD CONSTRAINT `inquiry_purchase_requests_item_request_id_foreign` FOREIGN KEY (`item_request_id`) REFERENCES `item_requests` (`id`),
  ADD CONSTRAINT `inquiry_purchase_requests_purchase_request_id_foreign` FOREIGN KEY (`purchase_request_id`) REFERENCES `purchase_requests` (`id`),
  ADD CONSTRAINT `inquiry_purchase_requests_receive_id_foreign` FOREIGN KEY (`receive_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `inquiry_purchase_requests_send_id_foreign` FOREIGN KEY (`send_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_business_nature_id_foreign` FOREIGN KEY (`business_nature_id`) REFERENCES `business_natures` (`id`),
  ADD CONSTRAINT `invoices_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `invoices_nature_dealing_id_foreign` FOREIGN KEY (`nature_dealing_id`) REFERENCES `nature_dealings` (`id`),
  ADD CONSTRAINT `invoices_po_id_foreign` FOREIGN KEY (`po_id`) REFERENCES `purchase_orders` (`id`),
  ADD CONSTRAINT `invoices_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  ADD CONSTRAINT `invoices_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
  ADD CONSTRAINT `invoices_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `item_orders`
--
ALTER TABLE `item_orders`
  ADD CONSTRAINT `item_orders_purchase_order_id_foreign` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `item_orders_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`);

--
-- Constraints for table `item_requests`
--
ALTER TABLE `item_requests`
  ADD CONSTRAINT `item_requests_family_name_id_foreign` FOREIGN KEY (`family_name_id`) REFERENCES `family_names` (`id`),
  ADD CONSTRAINT `item_requests_purchase_request_id_foreign` FOREIGN KEY (`purchase_request_id`) REFERENCES `purchase_requests` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `item_requests_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`);

--
-- Constraints for table `job_codes`
--
ALTER TABLE `job_codes`
  ADD CONSTRAINT `job_codes_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `job_grades`
--
ALTER TABLE `job_grades`
  ADD CONSTRAINT `job_grades_job_code_id_foreign` FOREIGN KEY (`job_code_id`) REFERENCES `job_codes` (`id`);

--
-- Constraints for table `job_names`
--
ALTER TABLE `job_names`
  ADD CONSTRAINT `job_names_job_code_id_foreign` FOREIGN KEY (`job_code_id`) REFERENCES `job_codes` (`id`);

--
-- Constraints for table `material_receipts`
--
ALTER TABLE `material_receipts`
  ADD CONSTRAINT `material_receipts_item_order_id_foreign` FOREIGN KEY (`item_order_id`) REFERENCES `item_orders` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `nature_dealings`
--
ALTER TABLE `nature_dealings`
  ADD CONSTRAINT `nature_dealings_discount_type_id_foreign` FOREIGN KEY (`discount_type_id`) REFERENCES `discount_types` (`id`);

--
-- Constraints for table `payment_invoices`
--
ALTER TABLE `payment_invoices`
  ADD CONSTRAINT `payment_invoices_bank_id_foreign` FOREIGN KEY (`bank_id`) REFERENCES `banks` (`id`),
  ADD CONSTRAINT `payment_invoices_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `payment_invoices_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  ADD CONSTRAINT `payment_invoices_supplier_bank_id_foreign` FOREIGN KEY (`supplier_bank_id`) REFERENCES `supplier_bank_transfers` (`id`),
  ADD CONSTRAINT `payment_invoices_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
  ADD CONSTRAINT `payment_invoices_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `person_suppliers`
--
ALTER TABLE `person_suppliers`
  ADD CONSTRAINT `person_suppliers_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_business_nature_id_foreign` FOREIGN KEY (`business_nature_id`) REFERENCES `business_natures` (`id`),
  ADD CONSTRAINT `projects_delegated_id_foreign` FOREIGN KEY (`delegated_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `projects_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  ADD CONSTRAINT `projects_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `projects_manager_id_foreign` FOREIGN KEY (`manager_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `projects_sector_id_foreign` FOREIGN KEY (`sector_id`) REFERENCES `sectors` (`id`);

--
-- Constraints for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD CONSTRAINT `purchase_orders_requester_id_foreign` FOREIGN KEY (`requester_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `purchase_orders_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`);

--
-- Constraints for table `purchase_requests`
--
ALTER TABLE `purchase_requests`
  ADD CONSTRAINT `purchase_requests_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `purchase_requests_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  ADD CONSTRAINT `purchase_requests_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  ADD CONSTRAINT `purchase_requests_requester_id_foreign` FOREIGN KEY (`requester_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `purchase_requests_sector_id_foreign` FOREIGN KEY (`sector_id`) REFERENCES `sectors` (`id`),
  ADD CONSTRAINT `purchase_requests_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`);

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sectors`
--
ALTER TABLE `sectors`
  ADD CONSTRAINT `sectors_delegated_id_foreign` FOREIGN KEY (`delegated_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `sectors_head_id_foreign` FOREIGN KEY (`head_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `sectors_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `sectors` (`id`);

--
-- Constraints for table `sites`
--
ALTER TABLE `sites`
  ADD CONSTRAINT `sites_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_groups`
--
ALTER TABLE `sub_groups`
  ADD CONSTRAINT `sub_groups_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);

--
-- Constraints for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `suppliers_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `supplier_bank_transfers`
--
ALTER TABLE `supplier_bank_transfers`
  ADD CONSTRAINT `supplier_bank_transfers_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `supplier_cheques`
--
ALTER TABLE `supplier_cheques`
  ADD CONSTRAINT `supplier_cheques_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `users_job_grade_id_foreign` FOREIGN KEY (`job_grade_id`) REFERENCES `job_grades` (`id`),
  ADD CONSTRAINT `users_job_name_id_foreign` FOREIGN KEY (`job_name_id`) REFERENCES `job_names` (`id`),
  ADD CONSTRAINT `users_manager_id_foreign` FOREIGN KEY (`manager_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `users_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  ADD CONSTRAINT `users_sector_id_foreign` FOREIGN KEY (`sector_id`) REFERENCES `sectors` (`id`);

--
-- Constraints for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD CONSTRAINT `user_groups_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  ADD CONSTRAINT `user_groups_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
