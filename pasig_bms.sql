-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2026 at 11:58 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pasig_bms`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `resident_id` bigint(20) UNSIGNED NOT NULL,
  `service_type` varchar(255) NOT NULL,
  `reference_number` varchar(255) NOT NULL,
  `scheduled_time` datetime NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appointment_notes`
--

CREATE TABLE `appointment_notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `appointment_id` bigint(20) UNSIGNED NOT NULL,
  `note` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `asset_name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` enum('working','maintenance','disposal','inactive') NOT NULL DEFAULT 'working',
  `acquisition_date` date DEFAULT NULL,
  `last_maintenance_date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`id`, `asset_name`, `category`, `quantity`, `status`, `acquisition_date`, `last_maintenance_date`, `description`, `location`, `created_at`, `updated_at`) VALUES
(1, 'test1', 'Sports', 2, 'disposal', '2026-01-30', '2026-01-29', 'asdas', 'asdad', '2026-01-07 06:30:28', '2026-01-07 06:37:00');

-- --------------------------------------------------------

--
-- Table structure for table `asset_logs`
--

CREATE TABLE `asset_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `asset_id` bigint(20) UNSIGNED NOT NULL,
  `log_type` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `date_performed` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(255) NOT NULL,
  `details` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `details`, `created_at`, `updated_at`) VALUES
(1, 3, 'login', 'User logged in from IP: 127.0.0.1', '2026-01-07 06:10:23', '2026-01-07 06:10:23'),
(2, 3, 'login', 'User logged in from IP: 127.0.0.1', '2026-01-07 06:15:54', '2026-01-07 06:15:54'),
(3, 3, 'created', 'Created Asset (ID: 1)', '2026-01-07 06:30:28', '2026-01-07 06:30:28'),
(4, 3, 'updated', 'Updated Asset (ID: 1) - Modified: status, updated_at', '2026-01-07 06:37:00', '2026-01-07 06:37:00'),
(5, 3, 'created', 'Created Resident (ID: 1)', '2026-01-07 06:39:10', '2026-01-07 06:39:10'),
(6, 3, 'created', 'Created Resident (ID: 2)', '2026-01-07 06:46:46', '2026-01-07 06:46:46'),
(7, 3, 'login', 'User logged in from IP: 127.0.0.1', '2026-01-07 22:12:21', '2026-01-07 22:12:21'),
(8, 3, 'created', 'Created BlotterRecord (ID: 5)', '2026-01-07 22:13:17', '2026-01-07 22:13:17'),
(9, 3, 'login', 'User logged in from IP: 127.0.0.1', '2026-01-08 00:47:15', '2026-01-08 00:47:15'),
(10, 3, 'created', 'Created Resident (ID: 3)', '2026-01-08 01:07:08', '2026-01-08 01:07:08'),
(11, 3, 'created', 'Created Resident (ID: 4)', '2026-01-08 01:12:59', '2026-01-08 01:12:59'),
(12, 3, 'login', 'User logged in from IP: 127.0.0.1', '2026-01-08 01:13:59', '2026-01-08 01:13:59'),
(13, 3, 'created', 'Created Resident (ID: 5)', '2026-01-08 01:21:38', '2026-01-08 01:21:38'),
(14, 3, 'login', 'User logged in from IP: 127.0.0.1', '2026-01-08 01:38:35', '2026-01-08 01:38:35'),
(15, 3, 'created', 'Created Resident (ID: 6)', '2026-01-08 01:39:53', '2026-01-08 01:39:53'),
(16, 3, 'login', 'User logged in from IP: 127.0.0.1', '2026-01-08 19:14:11', '2026-01-08 19:14:11'),
(17, 3, 'created', 'Created Resident (ID: 7)', '2026-01-08 19:42:51', '2026-01-08 19:42:51');

-- --------------------------------------------------------

--
-- Table structure for table `blotter_records`
--

CREATE TABLE `blotter_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `case_number` varchar(255) NOT NULL,
  `complainant_name` varchar(255) NOT NULL,
  `complainant_contact` varchar(255) DEFAULT NULL,
  `respondent_name` varchar(255) DEFAULT NULL,
  `respondent_contact` varchar(255) DEFAULT NULL,
  `incident_type` varchar(255) NOT NULL,
  `incident_location` varchar(255) NOT NULL,
  `severity` enum('low','medium','high','critical') NOT NULL DEFAULT 'medium',
  `status` enum('pending','investigating','resolved') NOT NULL DEFAULT 'pending',
  `witnesses` int(11) NOT NULL DEFAULT 0,
  `notes` text DEFAULT NULL,
  `details` text DEFAULT NULL,
  `incident_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blotter_records`
--

INSERT INTO `blotter_records` (`id`, `case_number`, `complainant_name`, `complainant_contact`, `respondent_name`, `respondent_contact`, `incident_type`, `incident_location`, `severity`, `status`, `witnesses`, `notes`, `details`, `incident_date`, `created_at`, `updated_at`) VALUES
(1, 'BLT-000001', 'Juan Dela Cruz', '+63 9123456789', 'John Doe', '+63 9987654321', 'noise-complaint', 'Barangay Kalawaan, Pasig City', 'low', 'pending', 3, 'Follow up needed', 'Loud noise from construction site at night hours', '2025-12-28 06:05:40', '2026-01-07 06:05:40', '2026-01-07 06:05:40'),
(2, 'BLT-000002', 'Maria Santos', '+63 9111111111', 'Pedro Reyes', '+63 9222222222', 'property-dispute', 'Community Hall, Pasig', 'medium', 'investigating', 2, 'Surveyor to be contacted', 'Boundary dispute between two properties', '2026-01-02 06:05:40', '2026-01-07 06:05:40', '2026-01-07 06:05:40'),
(3, 'BLT-000003', 'Pedro Reyes', '+63 9333333333', 'Unknown Person', NULL, 'theft', 'Market Area, Pasig', 'high', 'investigating', 1, 'Security footage being reviewed', 'Motorcycle stolen from parking area', '2026-01-05 06:05:40', '2026-01-07 06:05:40', '2026-01-07 06:05:40'),
(4, 'BLT-000004', 'Ana Garcia', '+63 9444444444', NULL, NULL, 'vandalism', 'School Wall, Pasig', 'medium', 'pending', 0, 'School principal notified', 'Graffiti painted on school wall', '2026-01-06 06:05:40', '2026-01-07 06:05:40', '2026-01-07 06:05:40'),
(5, 'BLT-370353', 'asd', '09123132321', 'asda', '091231321321', 'noise-complaint', 'kalawaan', 'high', 'pending', 23, 'asdsad', 'kasdoask', '2026-01-07 16:00:00', '2026-01-07 22:13:17', '2026-01-07 22:13:17');

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
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cases`
--

CREATE TABLE `cases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `case_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `resident_id` bigint(20) UNSIGNED NOT NULL,
  `reference_number` varchar(255) NOT NULL,
  `type` enum('barangay_clearance','certificate_of_indigency','certificate_of_residency','business_permit','community_tax_certificate','other') NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `purpose_details` text DEFAULT NULL,
  `status` enum('pending','processing','approved','ready','released','cancelled') NOT NULL DEFAULT 'pending',
  `pickup_or_delivery` enum('pickup','delivery') NOT NULL DEFAULT 'pickup',
  `delivery_address` varchar(255) DEFAULT NULL,
  `approved_date` date DEFAULT NULL,
  `released_date` date DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `released_by` bigint(20) UNSIGNED DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clans`
--

CREATE TABLE `clans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `clan_name` varchar(255) NOT NULL,
  `head_of_family` varchar(255) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clans`
--

INSERT INTO `clans` (`id`, `clan_name`, `head_of_family`, `address`, `contact_number`, `email`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'sakyoln', NULL, '#12, Del Pilar St., Purok Purok 2, Barangay Kalawaan, Metro Manila, 1234', NULL, NULL, NULL, '2026-01-08 19:42:51', '2026-01-08 19:42:51');

-- --------------------------------------------------------

--
-- Table structure for table `directories`
--

CREATE TABLE `directories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `office_name` varchar(255) NOT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `office_hours` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
-- Table structure for table `families`
--

CREATE TABLE `families` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `family_name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ids`
--

CREATE TABLE `ids` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `resident_id` bigint(20) UNSIGNED NOT NULL,
  `id_type` varchar(255) NOT NULL,
  `id_number` varchar(255) NOT NULL,
  `issued_by` varchar(255) DEFAULT NULL,
  `issued_date` date DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `qr_code` longtext DEFAULT NULL,
  `qr_code_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ids`
--

INSERT INTO `ids` (`id`, `resident_id`, `id_type`, `id_number`, `issued_by`, `issued_date`, `expiration_date`, `qr_code`, `qr_code_url`, `created_at`, `updated_at`) VALUES
(1, 2, 'barangay', 'BRGY-2026-QQKJY5', NULL, '2026-01-07', '2031-01-07', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2Fa1gFR05wIahDsvKQFpjbLbfjvRoONi5RUKFZlrKJ', NULL, '2026-01-07 06:47:02', '2026-01-07 06:47:02'),
(2, 1, 'barangay', 'BRGY-2026-S9AL9R', NULL, '2026-01-08', '2031-01-08', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2FvFrP4vkPf1goFTBjNnbz1zkAeRij0nBU07QZ2T4a', NULL, '2026-01-07 22:16:08', '2026-01-07 22:16:08'),
(3, 1, 'barangay', 'BRGY-2026-QDQ0QY', NULL, '2026-01-08', '2031-01-08', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2FvFrP4vkPf1goFTBjNnbz1zkAeRij0nBU07QZ2T4a', NULL, '2026-01-07 22:18:24', '2026-01-07 22:18:24'),
(4, 1, 'barangay', 'BRGY-2026-DFZZWN', NULL, '2026-01-08', '2031-01-08', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2FvFrP4vkPf1goFTBjNnbz1zkAeRij0nBU07QZ2T4a', NULL, '2026-01-07 22:21:28', '2026-01-07 22:21:28'),
(5, 1, 'barangay', 'BRGY-2026-FNCPAT', NULL, '2026-01-08', '2031-01-08', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2FvFrP4vkPf1goFTBjNnbz1zkAeRij0nBU07QZ2T4a', NULL, '2026-01-07 22:24:23', '2026-01-07 22:24:23'),
(6, 1, 'barangay', 'BRGY-2026-M3JJ9B', NULL, '2026-01-08', '2031-01-08', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2FvFrP4vkPf1goFTBjNnbz1zkAeRij0nBU07QZ2T4a', NULL, '2026-01-07 22:30:45', '2026-01-07 22:30:45'),
(7, 1, 'barangay', 'BRGY-2026-GZ9ID9', NULL, '2026-01-08', '2031-01-08', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2FvFrP4vkPf1goFTBjNnbz1zkAeRij0nBU07QZ2T4a', NULL, '2026-01-07 22:32:28', '2026-01-07 22:32:28'),
(8, 1, 'barangay', 'BRGY-2026-2KZPVA', NULL, '2026-01-08', '2031-01-08', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2FvFrP4vkPf1goFTBjNnbz1zkAeRij0nBU07QZ2T4a', NULL, '2026-01-07 22:34:07', '2026-01-07 22:34:07'),
(9, 1, 'barangay', 'BRGY-2026-IL3NVI', NULL, '2026-01-08', '2031-01-08', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2FvFrP4vkPf1goFTBjNnbz1zkAeRij0nBU07QZ2T4a', NULL, '2026-01-08 01:14:39', '2026-01-08 01:14:39'),
(10, 1, 'barangay', 'BRGY-2026-ROTKJR', NULL, '2026-01-08', '2031-01-08', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2FvFrP4vkPf1goFTBjNnbz1zkAeRij0nBU07QZ2T4a', NULL, '2026-01-08 01:18:22', '2026-01-08 01:18:22'),
(11, 5, 'barangay', 'BRGY-2026-DXJP74', NULL, '2026-01-08', '2031-01-08', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2FsL9GGZrWfCqAihhM0BSbTIk4fO8SgIuUbGi1lP37', NULL, '2026-01-08 01:21:54', '2026-01-08 01:21:54'),
(12, 1, 'barangay', 'BRGY-2026-5DXD8D', NULL, '2026-01-08', '2031-01-08', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2FvFrP4vkPf1goFTBjNnbz1zkAeRij0nBU07QZ2T4a', NULL, '2026-01-08 01:24:32', '2026-01-08 01:24:32'),
(13, 1, 'barangay', 'BRGY-2026-APFEFN', NULL, '2026-01-08', '2031-01-08', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2FvFrP4vkPf1goFTBjNnbz1zkAeRij0nBU07QZ2T4a', NULL, '2026-01-08 01:31:46', '2026-01-08 01:31:46'),
(14, 5, 'barangay', 'BRGY-2026-APL8P7', NULL, '2026-01-08', '2031-01-08', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2FsL9GGZrWfCqAihhM0BSbTIk4fO8SgIuUbGi1lP37', NULL, '2026-01-08 01:32:03', '2026-01-08 01:32:03'),
(15, 1, 'barangay', 'BRGY-2026-9COSK5', NULL, '2026-01-08', '2031-01-08', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2FvFrP4vkPf1goFTBjNnbz1zkAeRij0nBU07QZ2T4a', NULL, '2026-01-08 01:34:53', '2026-01-08 01:34:53'),
(16, 1, 'barangay', 'BRGY-2026-YWQHLZ', NULL, '2026-01-08', '2031-01-08', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2FvFrP4vkPf1goFTBjNnbz1zkAeRij0nBU07QZ2T4a', NULL, '2026-01-08 01:36:18', '2026-01-08 01:36:18'),
(17, 1, 'barangay', 'BRGY-2026-QWRWEU', NULL, '2026-01-08', '2031-01-08', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2FvFrP4vkPf1goFTBjNnbz1zkAeRij0nBU07QZ2T4a', NULL, '2026-01-08 01:38:01', '2026-01-08 01:38:01'),
(18, 5, 'barangay', 'BRGY-2026-GED0XZ', NULL, '2026-01-08', '2031-01-08', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2FsL9GGZrWfCqAihhM0BSbTIk4fO8SgIuUbGi1lP37', NULL, '2026-01-08 01:38:48', '2026-01-08 01:38:48'),
(19, 6, 'barangay', 'BRGY-2026-NT3BKX', NULL, '2026-01-08', '2031-01-08', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2FgGK8TY8TVvBkwGrvN0C0plkGFsxzi9cupPXjrG6h', NULL, '2026-01-08 01:40:25', '2026-01-08 01:40:25'),
(20, 6, 'barangay', 'BRGY-2026-7BK8PK', NULL, '2026-01-08', '2031-01-08', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2FgGK8TY8TVvBkwGrvN0C0plkGFsxzi9cupPXjrG6h', NULL, '2026-01-08 01:46:13', '2026-01-08 01:46:13'),
(21, 6, 'barangay', 'BRGY-2026-JBLETJ', NULL, '2026-01-08', '2031-01-08', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2FgGK8TY8TVvBkwGrvN0C0plkGFsxzi9cupPXjrG6h', NULL, '2026-01-08 01:48:21', '2026-01-08 01:48:21'),
(22, 6, 'barangay', 'BRGY-2026-QW1NS5', NULL, '2026-01-08', '2031-01-08', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2FgGK8TY8TVvBkwGrvN0C0plkGFsxzi9cupPXjrG6h', NULL, '2026-01-08 01:48:54', '2026-01-08 01:48:54'),
(23, 6, 'barangay', 'BRGY-2026-CTY0YJ', NULL, '2026-01-08', '2031-01-08', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2FgGK8TY8TVvBkwGrvN0C0plkGFsxzi9cupPXjrG6h', NULL, '2026-01-08 01:51:42', '2026-01-08 01:51:42'),
(24, 6, 'barangay', 'BRGY-2026-IHKSU2', NULL, '2026-01-08', '2029-01-08', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2FgGK8TY8TVvBkwGrvN0C0plkGFsxzi9cupPXjrG6h', NULL, '2026-01-08 01:52:07', '2026-01-08 01:52:07'),
(25, 6, 'barangay', 'BRGY-2026-MLUWCW', NULL, '2026-01-08', '2029-01-08', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2FgGK8TY8TVvBkwGrvN0C0plkGFsxzi9cupPXjrG6h', NULL, '2026-01-08 02:01:47', '2026-01-08 02:01:47'),
(26, 6, 'barangay', 'BRGY-2026-VHT0AH', NULL, '2026-01-08', '2029-01-08', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2FgGK8TY8TVvBkwGrvN0C0plkGFsxzi9cupPXjrG6h', NULL, '2026-01-08 02:04:39', '2026-01-08 02:04:39'),
(27, 6, 'barangay', 'BRGY-2026-8PS5GR', NULL, '2026-01-08', '2029-01-08', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2FgGK8TY8TVvBkwGrvN0C0plkGFsxzi9cupPXjrG6h', NULL, '2026-01-08 02:07:09', '2026-01-08 02:07:09'),
(28, 6, 'barangay', 'BRGY-2026-BH85O9', NULL, '2026-01-08', '2029-01-08', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2FgGK8TY8TVvBkwGrvN0C0plkGFsxzi9cupPXjrG6h', NULL, '2026-01-08 02:08:51', '2026-01-08 02:08:51'),
(29, 6, 'barangay', 'BRGY-2026-AVXIL1', NULL, '2026-01-08', '2029-01-08', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2FgGK8TY8TVvBkwGrvN0C0plkGFsxzi9cupPXjrG6h', NULL, '2026-01-08 02:11:20', '2026-01-08 02:11:20'),
(30, 6, 'barangay', 'BRGY-2026-ABPJYK', NULL, '2026-01-08', '2029-01-08', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2FgGK8TY8TVvBkwGrvN0C0plkGFsxzi9cupPXjrG6h', NULL, '2026-01-08 02:13:13', '2026-01-08 02:13:13'),
(31, 6, 'barangay', 'BRGY-2026-2LJH9F', NULL, '2026-01-08', '2029-01-08', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2FgGK8TY8TVvBkwGrvN0C0plkGFsxzi9cupPXjrG6h', NULL, '2026-01-08 02:15:30', '2026-01-08 02:15:30'),
(32, 6, 'barangay', 'BRGY-2026-YQRURO', NULL, '2026-01-08', '2029-01-08', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2FgGK8TY8TVvBkwGrvN0C0plkGFsxzi9cupPXjrG6h', NULL, '2026-01-08 02:18:36', '2026-01-08 02:18:36'),
(33, 6, 'barangay', 'BRGY-2026-U5G0IN', NULL, '2026-01-08', '2029-01-08', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2FgGK8TY8TVvBkwGrvN0C0plkGFsxzi9cupPXjrG6h', NULL, '2026-01-08 02:26:06', '2026-01-08 02:26:06'),
(34, 6, 'barangay', 'BRGY-2026-AAGHOZ', NULL, '2026-01-08', '2029-01-08', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2FgGK8TY8TVvBkwGrvN0C0plkGFsxzi9cupPXjrG6h', NULL, '2026-01-08 02:30:53', '2026-01-08 02:30:53'),
(35, 6, 'barangay', 'BRGY-2026-CWMIZQ', NULL, '2026-01-08', '2029-01-08', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2FgGK8TY8TVvBkwGrvN0C0plkGFsxzi9cupPXjrG6h', NULL, '2026-01-08 02:32:13', '2026-01-08 02:32:13'),
(36, 6, 'barangay', 'BRGY-2026-PLLH4O', NULL, '2026-01-08', '2029-01-08', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2FgGK8TY8TVvBkwGrvN0C0plkGFsxzi9cupPXjrG6h', NULL, '2026-01-08 02:35:37', '2026-01-08 02:35:37'),
(37, 6, 'barangay', 'BRGY-2026-ABAO9S', NULL, '2026-01-08', '2029-01-08', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2FgGK8TY8TVvBkwGrvN0C0plkGFsxzi9cupPXjrG6h', NULL, '2026-01-08 02:38:33', '2026-01-08 02:38:33'),
(38, 6, 'barangay', 'BRGY-2026-AV2Y8P', NULL, '2026-01-08', '2029-01-08', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2FgGK8TY8TVvBkwGrvN0C0plkGFsxzi9cupPXjrG6h', NULL, '2026-01-08 02:39:37', '2026-01-08 02:39:37'),
(39, 7, 'barangay', 'BRGY-2026-3JPZZL', NULL, '2026-01-09', '2029-01-09', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http%3A%2F%2Flocalhost%3A8000%2Fqr%2Fauthenticate%2FwxFPPplwP00dpergPFU2LtarI4B2Tf5nPFyfEQYK', NULL, '2026-01-08 19:43:22', '2026-01-08 19:43:22');

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
(4, '2025_08_26_100418_add_two_factor_columns_to_users_table', 1),
(5, '2025_11_26_174604_initial_schema', 1),
(6, '2025_12_11_041529_add_profile_image_to_residents_table', 1),
(7, '2025_12_11_051518_add_qr_code_to_ids_table', 1),
(8, '2025_12_14_add_resident_fields', 1),
(9, '2025_12_19_add_qr_token_to_resident_accounts', 1),
(10, '2025_12_23_061000_create_clans_table', 1),
(11, '2025_12_23_create_certificates_table', 1),
(12, '2025_12_23_drop_qr_token_expires_at', 1),
(13, '2026_01_06_000000_add_fields_to_blotter_records_table', 1),
(14, '2026_01_06_000001_add_fields_to_assets_table', 1),
(15, '2026_01_08_132914_add_clan_id_to_residents_table', 2),
(16, '2026_01_08_133335_add_unique_index_to_clans_table', 3),
(17, '2026_01_08_141213_make_head_of_family_and_contact_number_nullable_in_clans_table', 4);

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
-- Table structure for table `residents`
--

CREATE TABLE `residents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `civil_status` varchar(255) DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `special_sector` varchar(255) DEFAULT NULL,
  `barangay` varchar(255) DEFAULT NULL,
  `house_no` varchar(255) DEFAULT NULL,
  `street_name` varchar(255) DEFAULT NULL,
  `purok` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `zip_code` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `telephone_no` varchar(255) DEFAULT NULL,
  `blood_type` varchar(255) DEFAULT NULL,
  `emergency_contact_name` varchar(255) DEFAULT NULL,
  `emergency_contact_no` varchar(255) DEFAULT NULL,
  `emergency_contact_relationship` varchar(255) DEFAULT NULL,
  `emergency_contact_address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `family_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `clan_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `residents`
--

INSERT INTO `residents` (`id`, `first_name`, `middle_name`, `last_name`, `gender`, `birth_date`, `civil_status`, `nationality`, `special_sector`, `barangay`, `house_no`, `street_name`, `purok`, `province`, `zip_code`, `address`, `contact_number`, `telephone_no`, `blood_type`, `emergency_contact_name`, `emergency_contact_no`, `emergency_contact_relationship`, `emergency_contact_address`, `email`, `profile_image`, `family_id`, `created_at`, `updated_at`, `clan_id`) VALUES
(1, 'test', 'sadsa', 'sadas', 'Male', '2026-01-30', 'Married', 'Filipino', 'Senior Citizen', 'Kalawaan', '21', 'Osmena St.', 'Purok 2', 'Metro Manila', '1233', '#21, Osmena St., Purok Purok 2, Barangay Kalawaan, Metro Manila, 1233', '09123123123', NULL, 'B+', 'asda', '09123213121', 'Spouse', 'ksoadksao', 'sadas@gmail.com', 'profile_images/test.sadas.jpg', NULL, '2026-01-07 06:39:10', '2026-01-07 06:39:10', NULL),
(2, 'test2', 'kasoda', 'ksado', 'Male', '2026-01-31', 'Widowed', 'Filipino', 'Senior Citizen', 'Kalawaan', '123', 'Osmena St.', 'Purok 1', 'Metro Manila', '1234', '#123, Osmena St., Purok Purok 1, Barangay Kalawaan, Metro Manila, 1234', '0912321321', NULL, 'AB+', 'asd', '091231312312', 'Friend', 'koasdkas', 'sada@gmail.com', 'profile_images/test2.ksado.jpg', NULL, '2026-01-07 06:46:46', '2026-01-07 06:46:46', NULL),
(3, 'testulit', 'asdkoas', 'sadkoas', 'Male', '2026-01-30', 'Married', 'Filipino', 'Senior Citizen', 'Kalawaan', '2134', NULL, 'Purok 2', 'Metro Manila', '1234', '#2134, Purok Purok 2, Barangay Kalawaan, Metro Manila, 1234', '09123132131', NULL, 'AB+', 'asdsa', '0912313213', 'Friend', 'asdkosa', 'asd@gmail.com', 'profile_images/testulit.sadkoas.jpg', NULL, '2026-01-08 01:07:08', '2026-01-08 01:07:08', NULL),
(4, 'testulit2', 'saodksa', 'kdosdosa', 'Female', '2026-01-29', 'Single', 'Filipino', 'PWD', 'Kalawaan', '123', 'Roxas St.', 'Purok 2', 'Metro Manila', '1234', '#123, Roxas St., Purok Purok 2, Barangay Kalawaan, Metro Manila, 1234', '0912313211', '091231321', 'AB+', 'asdp', '09123132131', 'Father', 'asdsa', 'asd@gmail.com', 'profile_images/testulit2.kdosdosa.jpg', NULL, '2026-01-08 01:12:59', '2026-01-08 01:12:59', NULL),
(5, 'pakak', 'asdkoa', 'askoask', 'Male', '2026-01-30', 'Single', 'Filipino', 'Senior Citizen', 'Kalawaan', '1234', 'Roxas St.', 'Purok 3', 'Metro Manila', '1234', '#1234, Roxas St., Purok Purok 3, Barangay Kalawaan, Metro Manila, 1234', '0912313123', NULL, 'AB+', 'askdosa', '0912391321913', 'Mother', 'jiasjadsi', 'agas@gmail.com', 'profile_images/pakak.askoask.jpg', NULL, '2026-01-08 01:21:38', '2026-01-08 01:21:38', NULL),
(6, 'pakak2', 'sadsa', 'asdas', 'Male', '2026-01-23', 'Single', 'Filipino', 'Senior Citizen', 'Kalawaan', '2134', 'Osmena St.', 'Purok 2', 'Metro Manila', '1234', '#2134, Osmena St., Purok Purok 2, Barangay Kalawaan, Metro Manila, 1234', '09123123213', NULL, 'O+', 'aksodsa', '0912321312', 'Father', 'asdoaso', 'sda@gmail.com', 'profile_images/pakak2.asdas.jpg', NULL, '2026-01-08 01:39:53', '2026-01-08 01:39:53', NULL),
(7, 'sakyofn', 'asdji', 'sakyoln', 'Male', '2026-01-29', 'Married', 'Filipino', 'PWD', 'Kalawaan', '12', 'Del Pilar St.', 'Purok 2', 'Metro Manila', '1234', '#12, Del Pilar St., Purok Purok 2, Barangay Kalawaan, Metro Manila, 1234', '091239213218132', NULL, 'AB+', 'asskodas', '091231932112', 'Father', 'sadsaj', 'asdko@gmail.com', 'profile_images/sakyofn.sakyoln.jpg', NULL, '2026-01-08 19:42:51', '2026-01-08 19:42:51', 1);

-- --------------------------------------------------------

--
-- Table structure for table `resident_accounts`
--

CREATE TABLE `resident_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `resident_id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `qr_token` varchar(255) DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `resident_accounts`
--

INSERT INTO `resident_accounts` (`id`, `resident_id`, `username`, `email`, `password_hash`, `qr_token`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 1, 'test.sadas', NULL, '$2y$12$NYB6WHAID8CKiRgoeg.Z4eCNANY1G1tpZQVUbYR9IOmCgJW3kRecy', 'vFrP4vkPf1goFTBjNnbz1zkAeRij0nBU07QZ2T4a', NULL, '2026-01-07 06:39:11', '2026-01-07 22:16:07'),
(2, 2, 'test2.ksado', NULL, '$2y$12$DY.MC4QSj3jqYN8k/y/XPeWyTj2iZcyNzI9USJoyXjuxhlsWZ474e', 'a1gFR05wIahDsvKQFpjbLbfjvRoONi5RUKFZlrKJ', NULL, '2026-01-07 06:46:47', '2026-01-07 06:47:02'),
(3, 3, 'testulit.sadkoas', NULL, '$2y$12$5UiXJzxDNJJ3rAqztc6.ou3CrMB6uvKA6Atg8wJ8V.LEWIveIAfWS', NULL, NULL, '2026-01-08 01:07:08', '2026-01-08 01:07:08'),
(4, 4, 'testulit2.kdosdosa', 'asd@gmail.com', '$2y$12$jOPmNnNIkgSmyQpq1oRMSeyHEntlLMPp.P4.DOxlhdqHWjbRvWi3i', NULL, NULL, '2026-01-08 01:12:59', '2026-01-08 01:12:59'),
(5, 5, 'pakak.askoask', 'agas@gmail.com', '$2y$12$zTj4caVL2raCOpY411Tf.u5X.J4t0R3If4xItSRuluHN7SZVky7NK', 'sL9GGZrWfCqAihhM0BSbTIk4fO8SgIuUbGi1lP37', NULL, '2026-01-08 01:21:39', '2026-01-08 01:21:54'),
(6, 6, 'pakak2.asdas', 'sda@gmail.com', '$2y$12$4b9m9DbrWwpd1moQ0T9.xuj9NTTY6ErqOc9Zm8BoKltSMXdQ6h6.6', 'gGK8TY8TVvBkwGrvN0C0plkGFsxzi9cupPXjrG6h', NULL, '2026-01-08 01:39:53', '2026-01-08 01:40:25'),
(7, 7, 'sakyofn.sakyoln', 'asdko@gmail.com', '$2y$12$jUuzwNY9rziu9dr/jUMOaOsx6jbsUABFNZxYTvwKDl0GXNeheTqAG', 'wxFPPplwP00dpergPFU2LtarI4B2Tf5nPFyfEQYK', NULL, '2026-01-08 19:42:51', '2026-01-08 19:43:22');

-- --------------------------------------------------------

--
-- Table structure for table `resident_cases`
--

CREATE TABLE `resident_cases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `resident_id` bigint(20) UNSIGNED NOT NULL,
  `case_type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resident_family`
--

CREATE TABLE `resident_family` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `family_id` varchar(255) NOT NULL,
  `leader_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_request_links`
--

CREATE TABLE `service_request_links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `link_name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
('4ztbl5W7b6B8UEl6nDDDtrMykREUGtf3a9qlb8Iv', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYzVkbWp2MGZ1WVJneE9vNThzNUNKdzlIUlhycWRWY2dVWjVraDFkayI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hcHBvaW50bWVudHMiO3M6NToicm91dGUiO3M6MTg6ImFwcG9pbnRtZW50cy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7fQ==', 1767930211),
('TmbarAl9jqponahw1PduLjG4g0O03EsxeGX54GqI', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSTVZMkU3NDdxbVV0eENuR2daV1JlOHd0Qm90NWlCSDduclQ5SHJUTCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9yZXNpZGVudHMiO3M6NToicm91dGUiO3M6MTU6InJlc2lkZW50cy5pbmRleCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7fQ==', 1767868994);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'resident',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `role`, `created_at`, `updated_at`) VALUES
(2, 'test', 'Test User', 'test@example.com', '2026-01-07 06:05:40', '$2y$12$Ss/H3zTQ5cT2Vm2RR2.4S.g6ONXBC9msxab/iEMvnHvux5eYfnO16', NULL, NULL, NULL, 'AQTNbSq8Wy', 'resident', '2026-01-07 06:05:40', '2026-01-07 06:05:40'),
(3, 'admin', 'admin', 'admin@gmail.com', NULL, '$2y$12$FapFj1mah0ppqMmu2eYp2.YTTjsQNDv4nNcgBKFCAAbpF/neaBAV6', NULL, NULL, NULL, NULL, 'admin', NULL, '2026-01-08 00:46:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `announcements_created_by_foreign` (`created_by`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `appointments_reference_number_unique` (`reference_number`),
  ADD KEY `appointments_resident_id_foreign` (`resident_id`);

--
-- Indexes for table `appointment_notes`
--
ALTER TABLE `appointment_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointment_notes_appointment_id_foreign` (`appointment_id`);

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `asset_logs`
--
ALTER TABLE `asset_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asset_logs_asset_id_foreign` (`asset_id`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audit_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `blotter_records`
--
ALTER TABLE `blotter_records`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blotter_records_case_number_unique` (`case_number`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cases`
--
ALTER TABLE `cases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `certificates_reference_number_unique` (`reference_number`),
  ADD KEY `certificates_resident_id_foreign` (`resident_id`),
  ADD KEY `certificates_approved_by_foreign` (`approved_by`),
  ADD KEY `certificates_released_by_foreign` (`released_by`);

--
-- Indexes for table `clans`
--
ALTER TABLE `clans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clans_name_address_unique` (`clan_name`,`address`);

--
-- Indexes for table `directories`
--
ALTER TABLE `directories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `families`
--
ALTER TABLE `families`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ids`
--
ALTER TABLE `ids`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ids_id_number_unique` (`id_number`),
  ADD KEY `ids_resident_id_foreign` (`resident_id`);

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
-- Indexes for table `residents`
--
ALTER TABLE `residents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `residents_family_id_foreign` (`family_id`),
  ADD KEY `residents_clan_id_foreign` (`clan_id`);

--
-- Indexes for table `resident_accounts`
--
ALTER TABLE `resident_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `resident_accounts_username_unique` (`username`),
  ADD UNIQUE KEY `resident_accounts_qr_token_unique` (`qr_token`),
  ADD KEY `resident_accounts_resident_id_foreign` (`resident_id`);

--
-- Indexes for table `resident_cases`
--
ALTER TABLE `resident_cases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resident_cases_resident_id_foreign` (`resident_id`);

--
-- Indexes for table `resident_family`
--
ALTER TABLE `resident_family`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `resident_family_family_id_unique` (`family_id`);

--
-- Indexes for table `service_request_links`
--
ALTER TABLE `service_request_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appointment_notes`
--
ALTER TABLE `appointment_notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `asset_logs`
--
ALTER TABLE `asset_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `blotter_records`
--
ALTER TABLE `blotter_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cases`
--
ALTER TABLE `cases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clans`
--
ALTER TABLE `clans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `directories`
--
ALTER TABLE `directories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `families`
--
ALTER TABLE `families`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ids`
--
ALTER TABLE `ids`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `residents`
--
ALTER TABLE `residents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `resident_accounts`
--
ALTER TABLE `resident_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `resident_cases`
--
ALTER TABLE `resident_cases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resident_family`
--
ALTER TABLE `resident_family`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_request_links`
--
ALTER TABLE `service_request_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_resident_id_foreign` FOREIGN KEY (`resident_id`) REFERENCES `residents` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `appointment_notes`
--
ALTER TABLE `appointment_notes`
  ADD CONSTRAINT `appointment_notes_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `asset_logs`
--
ALTER TABLE `asset_logs`
  ADD CONSTRAINT `asset_logs_asset_id_foreign` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `certificates`
--
ALTER TABLE `certificates`
  ADD CONSTRAINT `certificates_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `certificates_released_by_foreign` FOREIGN KEY (`released_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `certificates_resident_id_foreign` FOREIGN KEY (`resident_id`) REFERENCES `residents` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ids`
--
ALTER TABLE `ids`
  ADD CONSTRAINT `ids_resident_id_foreign` FOREIGN KEY (`resident_id`) REFERENCES `residents` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `residents`
--
ALTER TABLE `residents`
  ADD CONSTRAINT `residents_clan_id_foreign` FOREIGN KEY (`clan_id`) REFERENCES `clans` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `residents_family_id_foreign` FOREIGN KEY (`family_id`) REFERENCES `resident_family` (`id`);

--
-- Constraints for table `resident_accounts`
--
ALTER TABLE `resident_accounts`
  ADD CONSTRAINT `resident_accounts_resident_id_foreign` FOREIGN KEY (`resident_id`) REFERENCES `residents` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `resident_cases`
--
ALTER TABLE `resident_cases`
  ADD CONSTRAINT `resident_cases_resident_id_foreign` FOREIGN KEY (`resident_id`) REFERENCES `residents` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
