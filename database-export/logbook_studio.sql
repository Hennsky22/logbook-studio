-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 10, 2026 at 07:50 AM
-- Server version: 8.0.30
-- PHP Version: 8.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `logbook_studio`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `checklist_crew_harians`
--

CREATE TABLE `checklist_crew_harians` (
  `id` bigint UNSIGNED NOT NULL,
  `studio` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `nama_crew` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `checklist_crew_harians`
--

INSERT INTO `checklist_crew_harians` (`id`, `studio`, `tanggal`, `nama_crew`, `keterangan`, `user_id`, `created_at`, `updated_at`) VALUES
(56, 'Studio Master Control Room', '2026-11-05', 'PD', NULL, 3, '2026-11-05 04:19:04', '2026-11-05 04:19:04'),
(57, 'Studio Master Control Room', '2026-11-05', 'TD', NULL, 3, '2026-11-05 04:19:04', '2026-11-05 04:19:04'),
(58, 'Studio Master Control Room', '2026-11-05', 'Maintenance', NULL, 3, '2026-11-05 04:19:04', '2026-11-05 04:19:04'),
(59, 'Studio Master Control Room', '2026-11-05', 'Master Control', NULL, 3, '2026-11-05 04:19:04', '2026-11-05 04:19:04'),
(60, 'Studio Master Control Room', '2026-11-05', 'Recaller 1', NULL, 3, '2026-11-05 04:19:04', '2026-11-05 04:19:04'),
(61, 'Studio Master Control Room', '2026-11-05', 'Recaller 2', NULL, 3, '2026-11-05 04:19:04', '2026-11-05 04:19:04'),
(62, 'Studio Master Control Room', '2026-11-05', 'Ingest', NULL, 3, '2026-11-05 04:19:04', '2026-11-05 04:19:04'),
(63, 'Studio Master Control Room', '2026-11-05', 'Running Text', NULL, 3, '2026-11-05 04:19:04', '2026-11-05 04:19:04'),
(64, 'Studio Master Control Room', '2026-11-09', 'PD', 'Kevin', 3, '2026-11-09 08:32:44', '2026-11-09 08:32:44'),
(65, 'Studio Master Control Room', '2026-11-09', 'TD', 'Julio', 3, '2026-11-09 08:32:44', '2026-11-09 08:32:44'),
(66, 'Studio Master Control Room', '2026-11-09', 'Maintenance', 'Risma', 3, '2026-11-09 08:32:44', '2026-11-09 08:32:44'),
(67, 'Studio Master Control Room', '2026-11-09', 'Master Control', 'Yasha', 3, '2026-11-09 08:32:44', '2026-11-09 08:32:44'),
(68, 'Studio Master Control Room', '2026-11-09', 'Recaller 1', 'Rizal', 3, '2026-11-09 08:32:44', '2026-11-09 08:32:44'),
(69, 'Studio Master Control Room', '2026-11-09', 'Recaller 2', 'RIyan', 3, '2026-11-09 08:32:44', '2026-11-09 08:32:44'),
(70, 'Studio Master Control Room', '2026-11-09', 'Ingest', 'Pahlevi', 3, '2026-11-09 08:32:44', '2026-11-09 08:32:44'),
(71, 'Studio Master Control Room', '2026-11-09', 'Running Text', 'Ilhamm', 3, '2026-11-09 08:32:44', '2026-11-09 08:32:44');

-- --------------------------------------------------------

--
-- Table structure for table `checklist_keterangan_harians`
--

CREATE TABLE `checklist_keterangan_harians` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `studio` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `waktu_submit` datetime DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `foto_tanda_tangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `checklist_keterangan_harians`
--

INSERT INTO `checklist_keterangan_harians` (`id`, `user_id`, `studio`, `tanggal`, `waktu_submit`, `keterangan`, `created_at`, `updated_at`, `foto_tanda_tangan`) VALUES
(9, 3, 'Studio Master Control Room', '2026-11-05', '2026-11-05 14:56:28', NULL, '2026-11-05 04:23:55', '2026-11-05 07:56:28', NULL),
(10, 3, 'Studio Master Control Room', '2026-11-09', '2026-11-09 15:32:44', 'Barang dan Crew Bagus', '2026-11-09 08:32:44', '2026-11-09 08:32:44', 'tanda-tangan/TUONUtsnMjeI74XlYowthrB4IzyQxs6AEGDwYSSu.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `checklist_pemeriksaans`
--

CREATE TABLE `checklist_pemeriksaans` (
  `id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `tanggal_pemeriksaan` date NOT NULL,
  `kondisi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `checklist_pemeriksaans`
--

INSERT INTO `checklist_pemeriksaans` (`id`, `item_id`, `user_id`, `tanggal_pemeriksaan`, `kondisi`, `catatan`, `created_at`, `updated_at`) VALUES
(53, 46, 3, '2026-11-05', 'Baik', NULL, '2026-11-05 04:23:55', '2026-11-05 04:23:55'),
(54, 41, 3, '2026-11-05', 'Error', NULL, '2026-11-05 04:23:55', '2026-11-05 04:23:55'),
(55, 45, 3, '2026-11-05', 'Rusak', NULL, '2026-11-05 04:23:55', '2026-11-05 04:23:55'),
(56, 38, 3, '2026-11-05', 'Baik', NULL, '2026-11-05 07:56:28', '2026-11-05 07:56:28'),
(57, 39, 3, '2026-11-05', 'Baik', NULL, '2026-11-05 07:56:28', '2026-11-05 07:56:28'),
(58, 46, 3, '2026-11-09', 'Baik', NULL, '2026-11-09 08:32:44', '2026-11-09 08:32:44'),
(59, 41, 3, '2026-11-09', 'Error', NULL, '2026-11-09 08:32:44', '2026-11-09 08:32:44'),
(60, 45, 3, '2026-11-09', 'Rusak', NULL, '2026-11-09 08:32:44', '2026-11-09 08:32:44'),
(61, 47, 3, '2026-11-09', 'Error', NULL, '2026-11-09 08:32:44', '2026-11-09 08:32:44'),
(62, 44, 3, '2026-11-09', 'Baik', NULL, '2026-11-09 08:32:44', '2026-11-09 08:32:44'),
(63, 42, 3, '2026-11-09', 'Error', NULL, '2026-11-09 08:32:44', '2026-11-09 08:32:44'),
(64, 43, 3, '2026-11-09', 'Rusak', NULL, '2026-11-09 08:32:44', '2026-11-09 08:32:44'),
(65, 36, 3, '2026-11-09', 'Error', NULL, '2026-11-09 08:32:44', '2026-11-09 08:32:44'),
(66, 34, 3, '2026-11-09', 'Baik', NULL, '2026-11-09 08:32:44', '2026-11-09 08:32:44'),
(67, 35, 3, '2026-11-09', 'Error', NULL, '2026-11-09 08:32:44', '2026-11-09 08:32:44'),
(68, 37, 3, '2026-11-09', 'Rusak', NULL, '2026-11-09 08:32:44', '2026-11-09 08:32:44'),
(69, 28, 3, '2026-11-09', 'Error', NULL, '2026-11-09 08:32:44', '2026-11-09 08:32:44'),
(70, 30, 3, '2026-11-09', 'Baik', NULL, '2026-11-09 08:32:44', '2026-11-09 08:32:44'),
(71, 31, 3, '2026-11-09', 'Error', NULL, '2026-11-09 08:32:44', '2026-11-09 08:32:44'),
(72, 29, 3, '2026-11-09', 'Rusak', NULL, '2026-11-09 08:32:44', '2026-11-09 08:32:44'),
(73, 27, 3, '2026-11-09', 'Error', NULL, '2026-11-09 08:32:44', '2026-11-09 08:32:44'),
(74, 32, 3, '2026-11-09', 'Baik', NULL, '2026-11-09 08:32:44', '2026-11-09 08:32:44'),
(75, 33, 3, '2026-11-09', 'Error', NULL, '2026-11-09 08:32:44', '2026-11-09 08:32:44'),
(76, 40, 3, '2026-11-09', 'Rusak', NULL, '2026-11-09 08:32:44', '2026-11-09 08:32:44'),
(77, 38, 3, '2026-11-09', 'Error', NULL, '2026-11-09 08:32:44', '2026-11-09 08:32:44'),
(78, 39, 3, '2026-11-09', 'Baik', NULL, '2026-11-09 08:32:44', '2026-11-09 08:32:44');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` bigint UNSIGNED NOT NULL,
  `studio` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Studio Master Control Room',
  `nama_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `merk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun_produksi` smallint UNSIGNED DEFAULT NULL,
  `tahun_masuk` smallint UNSIGNED DEFAULT NULL,
  `status_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Tersedia',
  `kondisi_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Baik',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `studio`, `nama_barang`, `serial_number`, `merk`, `kategori`, `foto`, `tahun_produksi`, `tahun_masuk`, `status_barang`, `kondisi_barang`, `created_at`, `updated_at`) VALUES
(27, 'Studio Master Control Room', 'PC Terrestrial', NULL, NULL, 'Hardware', NULL, NULL, NULL, 'Tersedia', 'Error', '2026-11-03 05:47:36', '2026-11-09 08:32:44'),
(28, 'Studio Master Control Room', 'PC OTT', NULL, NULL, 'Hardware', NULL, NULL, NULL, 'Tersedia', 'Error', '2026-11-03 05:48:29', '2026-11-09 08:32:44'),
(29, 'Studio Master Control Room', 'PC Streaming', NULL, NULL, 'Hardware', NULL, NULL, NULL, 'Tersedia', 'Rusak', '2026-11-03 05:48:47', '2026-11-09 08:32:44'),
(30, 'Studio Master Control Room', 'PC Soliton', NULL, NULL, 'Hardware', NULL, NULL, NULL, 'Tersedia', 'Baik', '2026-11-03 05:49:06', '2026-11-09 08:32:44'),
(31, 'Studio Master Control Room', 'PC Soliton Zao X', NULL, NULL, 'Hardware', NULL, NULL, NULL, 'Tersedia', 'Error', '2026-11-03 05:49:23', '2026-11-09 08:32:44'),
(32, 'Studio Master Control Room', 'Speaker JBL', NULL, NULL, 'Audio', NULL, NULL, NULL, 'Tersedia', 'Baik', '2026-11-03 05:49:43', '2026-11-09 08:32:44'),
(33, 'Studio Master Control Room', 'Video Mixer ATEM', NULL, NULL, 'Video', NULL, NULL, NULL, 'Tersedia', 'Error', '2026-11-03 05:50:02', '2026-11-09 08:32:44'),
(34, 'Studio Master Control Room', 'Monitor Multiviewer', NULL, NULL, 'Video', NULL, NULL, NULL, 'Tersedia', 'Baik', '2026-11-03 05:50:19', '2026-11-09 08:32:44'),
(35, 'Studio Master Control Room', 'Monitor On Air', NULL, NULL, 'Video', NULL, NULL, NULL, 'Tersedia', 'Error', '2026-11-03 05:50:35', '2026-11-09 08:32:44'),
(36, 'Studio Master Control Room', 'Monitor Data Video (Bawah)', NULL, NULL, 'Video', NULL, NULL, NULL, 'Tersedia', 'Error', '2026-11-03 05:50:54', '2026-11-09 08:32:44'),
(37, 'Studio Master Control Room', 'Monitor Vector Scope (Atas)', NULL, NULL, 'Video', NULL, NULL, NULL, 'Tersedia', 'Rusak', '2026-11-03 05:51:12', '2026-11-09 08:32:44'),
(38, 'Studio Master Control Room', 'Video Router Blackmagic (Atas)', NULL, NULL, 'Video', NULL, NULL, NULL, 'Tersedia', 'Error', '2026-11-03 05:51:29', '2026-11-09 08:32:44'),
(39, 'Studio Master Control Room', 'Video Router Blackmagic (Bawah)', NULL, NULL, 'Video', NULL, NULL, NULL, 'Tersedia', 'Baik', '2026-11-03 05:51:46', '2026-11-09 08:32:44'),
(40, 'Studio Master Control Room', 'Video Processor AJA F54', NULL, NULL, 'Video', NULL, NULL, NULL, 'Tersedia', 'Rusak', '2026-11-03 05:52:04', '2026-11-09 08:32:44'),
(41, 'Studio Master Control Room', 'Audio Processor', NULL, NULL, 'Audio', NULL, NULL, NULL, 'Tersedia', 'Error', '2026-11-03 05:52:26', '2026-11-09 08:32:44'),
(42, 'Studio Master Control Room', 'Encoder Joglo', NULL, NULL, 'Video', NULL, NULL, NULL, 'Tersedia', 'Error', '2026-11-03 05:52:48', '2026-11-09 08:32:44'),
(43, 'Studio Master Control Room', 'Encoder OTT', NULL, NULL, 'Video', NULL, NULL, NULL, 'Tersedia', 'Rusak', '2026-11-03 05:53:09', '2026-11-09 08:32:44'),
(44, 'Studio Master Control Room', 'Encoder Bayah', NULL, NULL, 'Video', NULL, NULL, NULL, 'Tersedia', 'Baik', '2026-11-03 05:53:29', '2026-11-09 08:32:44'),
(45, 'Studio Master Control Room', 'Cisco Link Publik DKI SWIX', NULL, NULL, 'Jaringan', NULL, NULL, NULL, 'Tersedia', 'Rusak', '2026-11-03 05:53:46', '2026-11-09 08:32:44'),
(46, 'Studio Master Control Room', 'Access Point', NULL, NULL, 'Jaringan', NULL, NULL, NULL, 'Tersedia', 'Baik', '2026-11-03 05:54:02', '2026-11-09 08:32:44'),
(47, 'Studio Master Control Room', 'DA', NULL, NULL, 'Audio', NULL, NULL, NULL, 'Tersedia', 'Error', '2026-11-03 05:54:16', '2026-11-09 08:32:44');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logbooks`
--

CREATE TABLE `logbooks` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `studio` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `jenis_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uraian_kegiatan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `petugas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kendala` text COLLATE utf8mb4_unicode_ci,
  `penyebab` text COLLATE utf8mb4_unicode_ci,
  `penanganan` text COLLATE utf8mb4_unicode_ci,
  `kondisi_akhir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_pelapor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `logbooks`
--

INSERT INTO `logbooks` (`id`, `created_at`, `updated_at`, `user_id`, `studio`, `tanggal`, `jam_mulai`, `jam_selesai`, `jenis_kegiatan`, `nama_kegiatan`, `uraian_kegiatan`, `petugas`, `kendala`, `penyebab`, `penanganan`, `kondisi_akhir`, `nama_pelapor`, `foto`) VALUES
(1, '2026-10-20 02:14:20', '2026-10-20 02:14:20', 4, 'Berita', '2026-10-07', '16:12:00', '18:15:00', 'Produksi', 'Siaran Berita', 'Siaran', 'suep', 'tidak ada', 'tidak ada', 'tidak ada', 'Normal', 'suep', NULL),
(2, '2026-10-20 21:07:31', '2026-10-20 21:07:31', 4, 'penyiaran', '2026-10-22', '11:05:00', '15:09:00', 'Siaran', 'siaran berita', 'melakukan penyiaran', 'muklis', 'mic mati', 'kabel putus', 'ganti kabel', 'Perlu Perbaikan', 'muklis', NULL),
(3, '2026-10-21 00:09:55', '2026-10-21 00:09:55', 4, 'mcr', '2026-10-21', '14:09:00', '15:10:00', 'Produksi', 'Produksi berita', 'Menganalisis berita', 'm', NULL, NULL, NULL, 'Normal', 'm', NULL),
(4, '2026-10-22 03:41:36', '2026-10-22 03:41:36', 4, 'berita', '2026-10-22', '10:40:00', '10:45:00', 'Siaran', 'analisis', 'menganalisis', 'm', NULL, NULL, NULL, 'Normal', 'm', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_10_20_043647_create_logbooks_table', 2),
(5, '2026_10_20_043658_add_role_and_studio_to_users_table', 2),
(6, '2026_10_20_044148_add_role_and_studio_to_users_table', 2),
(7, '2026_10_20_044259_add_role_and_studio_to_users_table', 2),
(8, '2026_10_20_044413_add_role_and_studio_to_users_table', 2),
(9, '2026_10_20_044836_add_role_and_studio_columns_to_users_table', 3),
(10, '2026_10_20_063316_add_role_and_studio_columns_to_users_table', 4),
(11, '2026_10_20_085848_add_logbook_fields_to_logbooks_table', 5),
(12, '2026_10_21_022000_create_items_table', 6),
(13, '2026_10_21_023000_update_items_table_for_inventory', 6),
(14, '2026_10_21_023801_add_inventory_details_to_items_table', 6),
(15, '2026_10_21_031033_create_peminjaman_table', 7),
(16, '2026_10_21_033640_create_pemeliharaan_table', 8),
(17, '2026_10_26_114604_create_checklist_pemeriksaans_table', 9),
(18, '2026_10_27_104548_add_studio_to_items_table', 10),
(19, '2026_10_27_110621_fix_add_studio_column_to_items_table', 11),
(20, '2026_10_30_090813_create_checklist_keterangan_harians_table', 12),
(21, '2026_11_02_090514_create_checklist_crew_harians_table', 13),
(22, '2026_11_02_142900_make_tahun_masuk_nullable_in_items_table', 14),
(23, '2026_11_03_101225_add_foto_tanda_tangan_to_checklist_keterangan_harians_table', 15),
(24, '2026_11_03_133405_add_waktu_submit_to_checklist_keterangan_harians_table', 16);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pemeliharaan`
--

CREATE TABLE `pemeliharaan` (
  `id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `tanggal_rusak` date NOT NULL,
  `tanggal_perbaikan` date DEFAULT NULL,
  `kerusakan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `penanganan` text COLLATE utf8mb4_unicode_ci,
  `foto_awal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_sesudah` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Menunggu Perbaikan',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` bigint UNSIGNED NOT NULL,
  `logbook_id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `kondisi_awal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kondisi_kembali` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_rencana_kembali` date DEFAULT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Dipinjam',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('ji19aePJNSDlnxua3InJ4KhoH1jNsquoXSvsdayY', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJFMTdxVjdRTHBqV1M3b0toU3NRaWdUSU5jNDhpY3BUQ1JISWV4RWI1IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9tb25pdG9yaW5nXC9kYXRhP3RhbmdnYWw9MjAyNi0xMS0xMCIsInJvdXRlIjoibW9uaXRvcmluZy5wdWJsaWMuZGF0YSJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjozLCJwYXNzd29yZF9oYXNoX3dlYiI6IjYwNjE0MDhmMTE2MWE2ODU4ZDhlMjI2YzEzODI0YmIxNGYxMzdhYWRlMTk4YTJkZmQ3ZWQ1ZmU0OTk4NjZkMjEifQ==', 1794297000);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'petugas',
  `studio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `studio`) VALUES
(3, 'Hendy Aji', 'Hendyaji@gmail.com', NULL, '$2y$12$gZUnSGN3A5XYaTHW1cz4p.D8Z4fengaobI7hlnnrPBdlxCy77p2eS', NULL, '2026-10-20 00:04:58', '2026-10-30 07:39:25', 'kepala_studio', NULL),
(4, 'Admin Logbook', 'admin@logbook.test', NULL, '$2y$12$zy.TXKoGxGF2V7JWkd.twOTykxuctBZ7/V2P0r20PdamOlon8dWXm', NULL, '2026-10-20 01:05:23', '2026-10-22 04:31:41', 'admin', NULL);

--
-- Indexes for dumped tables
--

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
-- Indexes for table `checklist_crew_harians`
--
ALTER TABLE `checklist_crew_harians`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `crew_studio_tanggal_unique` (`studio`,`tanggal`,`nama_crew`),
  ADD KEY `checklist_crew_harians_user_id_foreign` (`user_id`);

--
-- Indexes for table `checklist_keterangan_harians`
--
ALTER TABLE `checklist_keterangan_harians`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `studio_tanggal_unique` (`studio`,`tanggal`),
  ADD KEY `checklist_keterangan_harians_user_id_foreign` (`user_id`);

--
-- Indexes for table `checklist_pemeriksaans`
--
ALTER TABLE `checklist_pemeriksaans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `checklist_item_tanggal_unique` (`item_id`,`tanggal_pemeriksaan`),
  ADD KEY `checklist_pemeriksaans_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `logbooks`
--
ALTER TABLE `logbooks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `logbooks_user_id_foreign` (`user_id`);

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
-- Indexes for table `pemeliharaan`
--
ALTER TABLE `pemeliharaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pemeliharaan_item_id_foreign` (`item_id`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peminjaman_logbook_id_foreign` (`logbook_id`),
  ADD KEY `peminjaman_item_id_foreign` (`item_id`),
  ADD KEY `peminjaman_user_id_foreign` (`user_id`);

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
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `checklist_crew_harians`
--
ALTER TABLE `checklist_crew_harians`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `checklist_keterangan_harians`
--
ALTER TABLE `checklist_keterangan_harians`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `checklist_pemeriksaans`
--
ALTER TABLE `checklist_pemeriksaans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logbooks`
--
ALTER TABLE `logbooks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `pemeliharaan`
--
ALTER TABLE `pemeliharaan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `checklist_crew_harians`
--
ALTER TABLE `checklist_crew_harians`
  ADD CONSTRAINT `checklist_crew_harians_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `checklist_keterangan_harians`
--
ALTER TABLE `checklist_keterangan_harians`
  ADD CONSTRAINT `checklist_keterangan_harians_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `checklist_pemeriksaans`
--
ALTER TABLE `checklist_pemeriksaans`
  ADD CONSTRAINT `checklist_pemeriksaans_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `checklist_pemeriksaans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `logbooks`
--
ALTER TABLE `logbooks`
  ADD CONSTRAINT `logbooks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `pemeliharaan`
--
ALTER TABLE `pemeliharaan`
  ADD CONSTRAINT `pemeliharaan_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `peminjaman_logbook_id_foreign` FOREIGN KEY (`logbook_id`) REFERENCES `logbooks` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `peminjaman_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
