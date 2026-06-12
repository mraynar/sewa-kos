-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 12, 2026 at 12:28 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sewa_kos`
--

-- --------------------------------------------------------

--
-- Table structure for table `additional_services`
--

CREATE TABLE `additional_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `duration_type` enum('Harian','Mingguan','Bulanan') NOT NULL DEFAULT 'Mingguan',
  `service_price` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `additional_services`
--

INSERT INTO `additional_services` (`id`, `service_name`, `duration_type`, `service_price`, `created_at`, `updated_at`) VALUES
(1, 'Catering Makanan 2x Sehari', 'Harian', 25000, '2026-06-04 03:44:43', '2026-06-04 03:44:43'),
(2, 'Laundry Express', 'Mingguan', 40000, '2026-06-04 03:44:43', '2026-06-04 03:44:43'),
(3, 'Cleaning Service', 'Mingguan', 40000, '2026-06-04 03:44:43', '2026-06-04 03:44:43');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` varchar(50) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `total_price` int(11) NOT NULL,
  `status` enum('pending','paid','expired','canceled') NOT NULL,
  `payment_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `room_id`, `check_in`, `check_out`, `total_price`, `status`, `payment_token`, `created_at`, `updated_at`) VALUES
('BKG-1CLSZBRARK', 3, 9, '2026-06-17', '2026-08-17', 2400000, 'canceled', NULL, '2026-06-14 16:33:27', '2026-06-04 03:44:43'),
('BKG-2YT2BORW52', 4, 5, '2026-05-12', '2027-02-12', 7355000, 'pending', 'PbHlr7WOTMTc3XgDUB1w', '2026-05-07 11:17:34', '2026-06-04 03:44:43'),
('BKG-4DHMP1H6QG', 4, 7, '2026-05-10', '2026-12-10', 8400000, 'pending', 'm3l3AfFfiChtvi2jMe1G', '2026-05-06 05:37:00', '2026-06-04 03:44:43'),
('BKG-8WTTOPEL1R', 4, 2, '2026-05-30', '2027-04-30', 8900000, 'expired', NULL, '2026-05-29 12:34:26', '2026-06-04 03:44:43'),
('BKG-9TZ33KMPNR', 4, 13, '2026-05-05', '2027-02-05', 13500000, 'pending', '2pBx8KYWUwVqswiUPEwz', '2026-05-01 07:43:11', '2026-06-04 03:44:43'),
('BKG-A977KV1OFZ', 4, 7, '2026-05-05', '2027-02-05', 11000000, 'expired', NULL, '2026-05-03 19:48:09', '2026-06-04 03:44:43'),
('BKG-KDUFWQ4MK5', 3, 1, '2026-05-30', '2027-03-30', 8220000, 'pending', 'e7Es7Shh40gGxApCyRF7', '2026-05-28 00:41:03', '2026-06-04 03:44:43'),
('BKG-NRXLFGLUNH', 4, 16, '2026-05-27', '2027-03-27', 20000000, 'canceled', NULL, '2026-05-25 03:12:46', '2026-06-04 03:44:43'),
('BKG-PRKXTZEMYX', 4, 16, '2026-05-21', '2026-06-21', 2050000, 'paid', NULL, '2026-05-18 17:07:14', '2026-06-04 03:44:43'),
('BKG-WLUQD5TCYA', 4, 2, '2026-05-28', '2026-12-28', 5760000, 'pending', 'LqLuVq3F3TGNqBfJmKte', '2026-05-26 07:59:42', '2026-06-04 03:44:43'),
('KOS-1780827671', 5, 11, '2026-06-07', '2026-07-08', 2695000, 'paid', '9f60df0e-cc7c-4806-81ef-1f5871387686', '2026-06-07 03:21:11', '2026-06-07 03:22:27');

-- --------------------------------------------------------

--
-- Table structure for table `booking_service`
--

CREATE TABLE `booking_service` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` varchar(50) NOT NULL,
  `additional_service_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price_at_purchase` int(11) NOT NULL,
  `service_status` enum('pending','on_progress','done') NOT NULL DEFAULT 'pending',
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking_service`
--

INSERT INTO `booking_service` (`id`, `booking_id`, `additional_service_id`, `quantity`, `price_at_purchase`, `service_status`, `employee_id`, `created_at`, `updated_at`) VALUES
(1, 'BKG-2YT2BORW52', 1, 3, 25000, 'on_progress', 2, '2026-06-04 03:44:43', '2026-06-07 03:23:09'),
(2, 'BKG-2YT2BORW52', 3, 2, 40000, 'on_progress', 2, '2026-06-04 03:44:43', '2026-06-07 03:23:09'),
(3, 'BKG-PRKXTZEMYX', 1, 2, 25000, 'on_progress', 2, '2026-06-04 03:44:43', '2026-06-07 03:23:09'),
(4, 'BKG-KDUFWQ4MK5', 1, 4, 25000, 'on_progress', 2, '2026-06-04 03:44:43', '2026-06-07 03:23:09'),
(5, 'BKG-KDUFWQ4MK5', 3, 3, 40000, 'on_progress', 2, '2026-06-04 03:44:43', '2026-06-07 03:23:09'),
(6, 'BKG-A977KV1OFZ', 2, 5, 40000, 'on_progress', 2, '2026-06-04 03:44:43', '2026-06-07 03:23:09'),
(7, 'BKG-8WTTOPEL1R', 1, 4, 25000, 'on_progress', 2, '2026-06-04 03:44:43', '2026-06-07 03:23:09'),
(8, 'BKG-WLUQD5TCYA', 3, 1, 40000, 'on_progress', 2, '2026-06-04 03:44:43', '2026-06-07 03:23:09'),
(9, 'BKG-WLUQD5TCYA', 2, 3, 40000, 'on_progress', 2, '2026-06-04 03:44:43', '2026-06-07 03:23:09'),
(10, 'KOS-1780827671', 1, 31, 25000, 'on_progress', 2, '2026-06-07 03:21:11', '2026-06-07 03:23:09'),
(11, 'KOS-1780827671', 2, 4, 40000, 'done', 2, '2026-06-07 03:21:11', '2026-06-07 03:24:03'),
(12, 'KOS-1780827671', 3, 4, 40000, 'done', 2, '2026-06-07 03:21:11', '2026-06-07 03:24:00');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `SD` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_requests`
--

CREATE TABLE `maintenance_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` varchar(50) NOT NULL,
  `issue_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `location` varchar(100) NOT NULL,
  `status` enum('pending','on_progress','done') NOT NULL DEFAULT 'pending',
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `maintenance_requests`
--

INSERT INTO `maintenance_requests` (`id`, `user_id`, `booking_id`, `issue_name`, `description`, `photo`, `location`, `status`, `employee_id`, `created_at`) VALUES
(1, 4, 'BKG-NRXLFGLUNH', 'Shower tidak menyala', 'Air di shower tidak keluar', 'MAINT_1775401488_4.jpg', 'Kamar S01', 'done', 2, '2026-06-02 03:44:44'),
(2, 4, 'BKG-4DHMP1H6QG', 'AC Tidak Dingin', 'AC mengalami kebocoran', 'ISSUE_1775401547_8.jpg', 'Kamar L01', 'done', 2, '2026-06-03 22:44:44'),
(3, 4, 'BKG-1CLSZBRARK', 'TV tidak bisa menyala', 'TV Rusak tidak dapat terhubung dengan internet', 'MAINT_1775402006_6.jpg', 'Kamar L02', 'pending', NULL, '2026-06-04 03:14:44');

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_24_134318_create_room_types_table', 1),
(5, '2026_02_24_134324_create_rooms_table', 1),
(6, '2026_02_24_134331_create_additional_services_table', 1),
(7, '2026_02_24_134338_create_bookings_table', 1),
(8, '2026_02_24_135812_create_booking_service_table', 1),
(9, '2026_05_18_231534_add_google_fields_to_users_table', 1),
(10, '2026_05_29_011039_create_maintenance_requests_table', 1),
(11, '2026_05_29_105643_create_settings_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_type_id` bigint(20) UNSIGNED NOT NULL,
  `room_number` varchar(255) NOT NULL,
  `gender_type` enum('Putra','Putri') NOT NULL,
  `price` int(11) NOT NULL,
  `rating` decimal(2,1) NOT NULL DEFAULT 0.0,
  `facilities` text NOT NULL,
  `area_size` varchar(255) NOT NULL,
  `is_electric_included` tinyint(1) NOT NULL DEFAULT 0,
  `is_water_included` tinyint(1) NOT NULL DEFAULT 1,
  `room_rules` text NOT NULL,
  `status` enum('available','occupied','maintenance') NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_type_id`, `room_number`, `gender_type`, `price`, `rating`, `facilities`, `area_size`, `is_electric_included`, `is_water_included`, `room_rules`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'H01', 'Putra', 800000, 4.5, '\"Bed, Lemari, Meja Belajar, Kipas Angin, WiFi\"', '3x4 m', 0, 1, '1. Dilarang membawa lawan jenis ke dalam kamar.\n2. Maksimal bertamu jam 22.00 WIB.\n3. Menjaga kebersihan dan ketenangan.', 'available', '2026-06-04 03:44:43', '2026-06-04 03:44:43'),
(2, 1, 'H02', 'Putri', 800000, 4.7, '\"Bed, Lemari, Meja Belajar, Kipas Angin, WiFi\"', '3x4 m', 0, 1, '1. Dilarang membawa lawan jenis ke dalam kamar.\n2. Maksimal bertamu jam 22.00 WIB.\n3. Menjaga kebersihan dan ketenangan.', 'available', '2026-06-04 03:44:43', '2026-06-04 03:44:43'),
(3, 1, 'H03', 'Putra', 800000, 4.6, '\"Bed, Lemari, Meja Belajar, Kipas Angin, WiFi\"', '3x4 m', 0, 1, '1. Dilarang membawa lawan jenis ke dalam kamar.\n2. Maksimal bertamu jam 22.00 WIB.\n3. Menjaga kebersihan dan ketenangan.', 'available', '2026-06-04 03:44:43', '2026-06-04 03:44:43'),
(4, 1, 'H04', 'Putri', 800000, 4.1, '\"Bed, Lemari, Meja Belajar, Kipas Angin, WiFi\"', '3x4 m', 0, 1, '1. Dilarang membawa lawan jenis ke dalam kamar.\n2. Maksimal bertamu jam 22.00 WIB.\n3. Menjaga kebersihan dan ketenangan.', 'available', '2026-06-04 03:44:43', '2026-06-04 03:44:43'),
(5, 1, 'H05', 'Putra', 800000, 4.6, '\"Bed, Lemari, Meja Belajar, Kipas Angin, WiFi\"', '3x4 m', 0, 1, '1. Dilarang membawa lawan jenis ke dalam kamar.\n2. Maksimal bertamu jam 22.00 WIB.\n3. Menjaga kebersihan dan ketenangan.', 'available', '2026-06-04 03:44:43', '2026-06-04 03:44:43'),
(6, 2, 'S01', 'Putra', 1200000, 4.8, '\"Bed, Lemari, Meja Belajar, AC, Kamar Mandi Dalam, WiFi\"', '3x4 m', 1, 1, '1. Dilarang membawa lawan jenis ke dalam kamar.\n2. Maksimal bertamu jam 22.00 WIB.\n3. Menjaga kebersihan dan ketenangan.', 'available', '2026-06-04 03:44:43', '2026-06-04 03:44:43'),
(7, 2, 'S02', 'Putri', 1200000, 4.7, '\"Bed, Lemari, Meja Belajar, AC, Kamar Mandi Dalam, WiFi\"', '3x4 m', 1, 1, '1. Dilarang membawa lawan jenis ke dalam kamar.\n2. Maksimal bertamu jam 22.00 WIB.\n3. Menjaga kebersihan dan ketenangan.', 'available', '2026-06-04 03:44:43', '2026-06-04 03:44:43'),
(8, 2, 'S03', 'Putra', 1200000, 4.7, '\"Bed, Lemari, Meja Belajar, AC, Kamar Mandi Dalam, WiFi\"', '3x4 m', 1, 1, '1. Dilarang membawa lawan jenis ke dalam kamar.\n2. Maksimal bertamu jam 22.00 WIB.\n3. Menjaga kebersihan dan ketenangan.', 'available', '2026-06-04 03:44:43', '2026-06-04 03:44:43'),
(9, 2, 'S04', 'Putri', 1200000, 4.8, '\"Bed, Lemari, Meja Belajar, AC, Kamar Mandi Dalam, WiFi\"', '3x4 m', 1, 1, '1. Dilarang membawa lawan jenis ke dalam kamar.\n2. Maksimal bertamu jam 22.00 WIB.\n3. Menjaga kebersihan dan ketenangan.', 'available', '2026-06-04 03:44:43', '2026-06-04 03:44:43'),
(10, 2, 'S05', 'Putra', 1200000, 4.9, '\"Bed, Lemari, Meja Belajar, AC, Kamar Mandi Dalam, WiFi\"', '3x4 m', 1, 1, '1. Dilarang membawa lawan jenis ke dalam kamar.\n2. Maksimal bertamu jam 22.00 WIB.\n3. Menjaga kebersihan dan ketenangan.', 'available', '2026-06-04 03:44:43', '2026-06-04 03:44:43'),
(11, 3, 'N01', 'Putra', 1500000, 5.0, '\"Bed Queen, Lemari Besar, Meja Kerja, AC, Kamar Mandi Dalam, WiFi\"', '3x4 m', 1, 1, '1. Dilarang membawa lawan jenis ke dalam kamar.\n2. Maksimal bertamu jam 22.00 WIB.\n3. Menjaga kebersihan dan ketenangan.', 'occupied', '2026-06-04 03:44:43', '2026-06-07 03:22:27'),
(12, 3, 'N02', 'Putri', 1500000, 4.7, '\"Bed Queen, Lemari Besar, Meja Kerja, AC, Kamar Mandi Dalam, WiFi\"', '3x4 m', 1, 1, '1. Dilarang membawa lawan jenis ke dalam kamar.\n2. Maksimal bertamu jam 22.00 WIB.\n3. Menjaga kebersihan dan ketenangan.', 'available', '2026-06-04 03:44:43', '2026-06-04 03:44:43'),
(13, 3, 'N03', 'Putra', 1500000, 4.5, '\"Bed Queen, Lemari Besar, Meja Kerja, AC, Kamar Mandi Dalam, WiFi\"', '3x4 m', 1, 1, '1. Dilarang membawa lawan jenis ke dalam kamar.\n2. Maksimal bertamu jam 22.00 WIB.\n3. Menjaga kebersihan dan ketenangan.', 'available', '2026-06-04 03:44:43', '2026-06-04 03:44:43'),
(14, 3, 'N04', 'Putri', 1500000, 4.9, '\"Bed Queen, Lemari Besar, Meja Kerja, AC, Kamar Mandi Dalam, WiFi\"', '3x4 m', 1, 1, '1. Dilarang membawa lawan jenis ke dalam kamar.\n2. Maksimal bertamu jam 22.00 WIB.\n3. Menjaga kebersihan dan ketenangan.', 'available', '2026-06-04 03:44:43', '2026-06-04 03:44:43'),
(15, 3, 'N05', 'Putra', 1500000, 4.4, '\"Bed Queen, Lemari Besar, Meja Kerja, AC, Kamar Mandi Dalam, WiFi\"', '3x4 m', 1, 1, '1. Dilarang membawa lawan jenis ke dalam kamar.\n2. Maksimal bertamu jam 22.00 WIB.\n3. Menjaga kebersihan dan ketenangan.', 'available', '2026-06-04 03:44:43', '2026-06-04 03:44:43'),
(16, 4, 'L01', 'Putra', 2000000, 4.1, '\"Bed Queen, Lemari Besar, Meja Kerja, AC, Kamar Mandi Dalam, TV, WiFi\"', '4x5 m', 1, 1, '1. Dilarang membawa lawan jenis ke dalam kamar.\n2. Maksimal bertamu jam 22.00 WIB.\n3. Menjaga kebersihan dan ketenangan.', 'occupied', '2026-06-04 03:44:43', '2026-06-04 03:44:43'),
(17, 4, 'L02', 'Putri', 2000000, 4.6, '\"Bed Queen, Lemari Besar, Meja Kerja, AC, Kamar Mandi Dalam, TV, WiFi\"', '4x5 m', 1, 1, '1. Dilarang membawa lawan jenis ke dalam kamar.\n2. Maksimal bertamu jam 22.00 WIB.\n3. Menjaga kebersihan dan ketenangan.', 'available', '2026-06-04 03:44:43', '2026-06-04 03:44:43'),
(18, 4, 'L03', 'Putra', 2000000, 4.9, '\"Bed Queen, Lemari Besar, Meja Kerja, AC, Kamar Mandi Dalam, TV, WiFi\"', '4x5 m', 1, 1, '1. Dilarang membawa lawan jenis ke dalam kamar.\n2. Maksimal bertamu jam 22.00 WIB.\n3. Menjaga kebersihan dan ketenangan.', 'available', '2026-06-04 03:44:43', '2026-06-04 03:44:43'),
(19, 4, 'L04', 'Putri', 2000000, 4.4, '\"Bed Queen, Lemari Besar, Meja Kerja, AC, Kamar Mandi Dalam, TV, WiFi\"', '4x5 m', 1, 1, '1. Dilarang membawa lawan jenis ke dalam kamar.\n2. Maksimal bertamu jam 22.00 WIB.\n3. Menjaga kebersihan dan ketenangan.', 'available', '2026-06-04 03:44:43', '2026-06-04 03:44:43'),
(20, 4, 'L05', 'Putra', 2000000, 4.0, '\"Bed Queen, Lemari Besar, Meja Kerja, AC, Kamar Mandi Dalam, TV, WiFi\"', '4x5 m', 1, 1, '1. Dilarang membawa lawan jenis ke dalam kamar.\n2. Maksimal bertamu jam 22.00 WIB.\n3. Menjaga kebersihan dan ketenangan.', 'available', '2026-06-04 03:44:43', '2026-06-04 03:44:43');

-- --------------------------------------------------------

--
-- Table structure for table `room_types`
--

CREATE TABLE `room_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `facilities` text NOT NULL,
  `base_price_daily` int(11) NOT NULL,
  `base_price_weekly` int(11) NOT NULL,
  `base_price_monthly` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `room_types`
--

INSERT INTO `room_types` (`id`, `name`, `image`, `description`, `facilities`, `base_price_daily`, `base_price_weekly`, `base_price_monthly`, `created_at`, `updated_at`) VALUES
(1, 'Hemat', 'kamar-hemat.jpg', 'Kamar sederhana dan nyaman untuk mahasiswa dengan harga terjangkau.', '\"Bed, Lemari, Meja Belajar, Kipas Angin, WiFi\"', 50000, 300000, 800000, '2026-06-04 03:44:43', '2026-06-04 03:44:43'),
(2, 'Santai', 'kamar-santai.jpg', 'Kamar dengan fasilitas lebih lengkap dan kamar mandi dalam.', '\"Bed, Lemari, Meja Belajar, AC, Kamar Mandi Dalam, WiFi\"', 75000, 450000, 1200000, '2026-06-04 03:44:43', '2026-06-04 03:44:43'),
(3, 'Nyaman', 'kamar-nyaman.jpg', 'Kamar luas cocok untuk mahasiswa tingkat akhir atau pekerja remote.', '\"Bed Queen, Lemari Besar, Meja Kerja, AC, Kamar Mandi Dalam, WiFi\"', 100000, 600000, 1500000, '2026-06-04 03:44:43', '2026-06-04 03:44:43'),
(4, 'Luas', 'kamar-luas.jpg', 'Kamar paling lega dengan fasilitas lengkap dan nyaman untuk jangka panjang.', '\"Bed Queen, Lemari Besar, Meja Kerja, AC, Kamar Mandi Dalam, TV, WiFi\"', 150000, 900000, 2000000, '2026-06-04 03:44:43', '2026-06-04 03:44:43');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('4yB6HIhECWc2sz3yrUwzvGoUG78BoSoa6P0OhTtc', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3 Safari/605.1.15', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVjc5YU1HMUJqaVlBc0tPNTVIWDBMRmFhMDE4MnZHVHJpS2FXVllNTyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hdXRoL2dvb2dsZSI7czo1OiJyb3V0ZSI7czoxMToiYXV0aC5nb29nbGUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjU6InN0YXRlIjtzOjQwOiJyN2V2UjZvWWZyaVZtb052R043dzZBYThRNXBTVGFOQ2dEc0xSaVZyIjt9', 1780825219),
('6dt1yR7sg9WadBvkqlGGM7DXmFdyhmIomqbILcqT', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVFZ3VHNxZzFDVmliQm13WHFYSFJxQm5FUVM3U0FTNWE2Zlp2Yjl5MyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMiI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1780822467),
('7fIhRPnZzv7Nilk6u78LrnbXSmKM7dBh14CVkvOv', 5, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3 Safari/605.1.15', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaEI3NlBvZjlXbGZ2ZmRWZWVHZUV6Y0lyZ2FFczJFdmFTSVJyRWF0cSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC90cmFuc2FjdGlvbnMvcmVjZWlwdC9LT1MtMTc4MDgyNzY3MSI7czo1OiJyb3V0ZSI7czoyMDoidHJhbnNhY3Rpb25zLnJlY2VpcHQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo1O30=', 1780835647),
('AiT9gKcFMM4n6VkYzhDLeoh55zHdFNerj0Rp4F8C', 5, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3 Safari/605.1.15', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieElpVExWNUtoY24zR2NJdE9nVFZEUkpXS200VFdsOFlPTXRjM3NPbSI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NTtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czoyMToiaHR0cDovL2xvY2FsaG9zdDo4MDAwIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1780917185),
('SCMRqkVMmTgGDRX04fubPqGC5j3y5aMOvxLBukMo', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWlE3TzBMYUhnUGFWMTNZa3hxWTluMVZEakVrcjh3Sk02T3NxQUM1eiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi90YXNrIjtzOjU6InJvdXRlIjtzOjE2OiJhZG1pbi50YXNrLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1780827789),
('TlOd0LPwN7MNo7Z9KBcmqpBJbi2lj6i1iaFTYEV0', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3 Safari/605.1.15', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZWZscEhpMXRDd2hFeDlnVlZaeW03amR3VjZ3TVh5cXlMbVdQZ2YweCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly9zZXdhLWtvcy50ZXN0L2F1dGgvZ29vZ2xlIjtzOjU6InJvdXRlIjtzOjExOiJhdXRoLmdvb2dsZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NToic3RhdGUiO3M6NDA6IjQyNjdudmJ4aUhHWEJTRU5mWG1aaUFGVEF1ZTJlcWtzY3BUSHowV1ciO30=', 1780822677),
('YRSrQdxDt8XZpzMc5tR00L61ACjemre9mD5sEYMI', 2, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSnNvaXFlWWhEcndObnpQS1M4bGNEazhkZTYxZHlkRHFtdlRYZTB4aCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZWdhd2FpL3R1Z2FzIjtzOjU6InJvdXRlIjtzOjE5OiJwZWdhd2FpLnRhc2tzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1780827843);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `key` varchar(100) NOT NULL,
  `value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `full_name_ktp` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `ktp_photo` varchar(255) DEFAULT NULL,
  `selfie_photo` varchar(255) DEFAULT NULL,
  `is_verified` enum('pending','verified','rejected') DEFAULT NULL,
  `role` enum('admin','pegawai','penyewa') NOT NULL DEFAULT 'penyewa',
  `gender` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `nickname`, `full_name_ktp`, `email`, `google_id`, `avatar`, `address`, `phone`, `email_verified_at`, `password`, `ktp_photo`, `selfie_photo`, `is_verified`, `role`, `gender`, `birth_date`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Kos', 'admin', NULL, 'admin@gmail.com', NULL, NULL, NULL, '08123456781', NULL, '$2y$12$rTUGXOIhnP.xXVFneBQQxuAmrnCVMgrFA4tTlCIGBnb1jBQLuBB1u', NULL, NULL, NULL, 'admin', NULL, NULL, NULL, '2026-06-04 03:44:43', '2026-06-04 03:44:43'),
(2, 'Pegawai User', 'pegawai', NULL, 'pegawai@gmail.com', NULL, NULL, NULL, '08123456782', NULL, '$2y$12$C33/eWAi225VZ6DFmZWtWusZdaxU/GqfRQPjpwk9dB22LVpXRbVem', NULL, NULL, NULL, 'pegawai', NULL, NULL, NULL, '2026-06-04 03:44:43', '2026-06-04 03:44:43'),
(3, 'Penyewa User', 'penyewa', 'tes', 'penyewa@gmail.com', NULL, NULL, NULL, '08123456783', NULL, '$2y$12$IenKrLoTGAOk3ZGiL11AUuVznRdezNXRdVr5xBcozS/wv2KqZxYCW', NULL, NULL, 'verified', 'penyewa', 'Perempuan', '2011-05-03', NULL, '2026-06-04 03:44:43', '2026-06-04 03:44:43'),
(4, 'hammam', 'hammam', 'Muhammad Raynar Hammam', 'hammam@gmail.com', NULL, NULL, NULL, '08953023232', NULL, '$2y$12$PTIVgF9YnfZdg6AmAPwEa.6h8d1XcQPlbje1cka2DBZ6JUtJnEgYa', NULL, NULL, 'verified', 'penyewa', 'Laki-laki', '2006-05-23', NULL, '2026-06-04 03:44:43', '2026-06-04 03:44:43'),
(5, 'Muhammad Raynar Hammam', 'Muhammad Raynar Hammam', 'Muhammad Raynar Hammam', 'raynarham23@gmail.com', NULL, NULL, 'Jl. Manukan Luhur 5 Blok 2C, No.14', NULL, NULL, '$2y$12$nQtNTOIqbpUF4AVl6R40S.Jm.TpO4M0MPyduCj3CuYFB.UEti/Z7y', 'verifikasi/ktp/XCRZvZ8gOUvQ8nmNS9PK3dx5VeglhlBmYf1wUSpZ.webp', 'verifikasi/selfie/BAGgZZSDCRQn0iT6rRNLMHV6hB32vFDzA56m92Mv.png', 'verified', 'penyewa', 'Laki-laki', '2006-05-23', '1dcYb68Ls33Zz3WM5uKpYoKLUL5Q7v3xfsqIEMtJM9tdJSR5PXIvSLC042lb', '2026-06-07 01:58:20', '2026-06-07 03:18:47'),
(6, '24082010128 MUHAMMAD RAYNAR HAMMAM', '24082010128 MUHAMMAD RAYNAR HAMMAM', NULL, '24082010128@student.upnjatim.ac.id', NULL, NULL, NULL, NULL, NULL, '$2y$12$uM6HU0SX1uandNJwBdesOe5QsC6DfbbIxtzUOF6YiIMSlYa3/W1/K', NULL, NULL, NULL, 'penyewa', NULL, NULL, 'MLi27pts6mxOtp63htmXV2nowyJl9bW72mG1zcRFuFcFKjWkuZmVxk613Tcq', '2026-06-07 01:59:10', '2026-06-07 01:59:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additional_services`
--
ALTER TABLE `additional_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_user_id_foreign` (`user_id`),
  ADD KEY `bookings_room_id_foreign` (`room_id`);

--
-- Indexes for table `booking_service`
--
ALTER TABLE `booking_service`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_service_booking_id_foreign` (`booking_id`),
  ADD KEY `booking_service_additional_service_id_foreign` (`additional_service_id`),
  ADD KEY `booking_service_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maintenance_requests`
--
ALTER TABLE `maintenance_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `maintenance_requests_user_id_foreign` (`user_id`),
  ADD KEY `maintenance_requests_booking_id_foreign` (`booking_id`),
  ADD KEY `maintenance_requests_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rooms_room_type_id_foreign` (`room_type_id`);

--
-- Indexes for table `room_types`
--
ALTER TABLE `room_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_google_id_unique` (`google_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `additional_services`
--
ALTER TABLE `additional_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `booking_service`
--
ALTER TABLE `booking_service`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
-- AUTO_INCREMENT for table `maintenance_requests`
--
ALTER TABLE `maintenance_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `room_types`
--
ALTER TABLE `room_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
  ADD CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `booking_service`
--
ALTER TABLE `booking_service`
  ADD CONSTRAINT `booking_service_additional_service_id_foreign` FOREIGN KEY (`additional_service_id`) REFERENCES `additional_services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_service_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_service_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `maintenance_requests`
--
ALTER TABLE `maintenance_requests`
  ADD CONSTRAINT `maintenance_requests_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `maintenance_requests_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `maintenance_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_room_type_id_foreign` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
