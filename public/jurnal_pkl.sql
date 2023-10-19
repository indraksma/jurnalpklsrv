-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 16, 2023 at 02:50 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jurnal_pkl`
--

-- --------------------------------------------------------

--
-- Table structure for table `dudis`
--

CREATE TABLE `dudis` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_dudi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kec` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kab_kota` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prov` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jurusan_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dudis`
--

INSERT INTO `dudis` (`id`, `nama_dudi`, `alamat`, `kec`, `kab_kota`, `prov`, `jurusan_id`, `created_at`, `updated_at`) VALUES
(1, 'DISKOMINFO WONOSOBO', 'Jl. Sabuk Alu No. 2A, Wonosobo', NULL, 'WONOSOBO', NULL, 1, '2023-09-18 18:03:48', '2023-09-18 18:03:48'),
(2, 'Tokopedia', 'Jakarta, Indonesia', NULL, 'Jakarta', NULL, 1, '2023-09-19 00:46:10', '2023-09-19 00:46:10'),
(3, 'Kidi Wonosobo', 'Wonosobo, Jawa Tengah, Indonesia', NULL, 'Wonosobo', NULL, 1, '2023-10-12 04:24:43', '2023-10-12 05:23:09');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jenis_kegiatans`
--

CREATE TABLE `jenis_kegiatans` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kunci` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenis_kegiatans`
--

INSERT INTO `jenis_kegiatans` (`id`, `kode_kegiatan`, `nama_kegiatan`, `kunci`, `created_at`, `updated_at`) VALUES
(1, 'MOT', 'Monitoring', NULL, '2023-10-03 06:48:39', '2023-10-03 06:48:39'),
(2, 'MET', 'Mentoring', NULL, '2023-10-03 06:48:45', '2023-10-03 06:48:45'),
(3, 'PNK', 'Penarikan', NULL, '2023-10-03 06:49:36', '2023-10-03 06:49:36'),
(4, 'PBK', 'Pemberangkatan', 0, '2023-10-03 06:49:49', '2023-10-11 02:19:09'),
(5, 'UPN', 'Ujian atau Penilaian', 1, '2023-10-03 06:50:08', '2023-10-11 02:19:09');

-- --------------------------------------------------------

--
-- Table structure for table `jurnals`
--

CREATE TABLE `jurnals` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint NOT NULL,
  `tahun_ajaran_id` bigint NOT NULL,
  `dudi_id` bigint NOT NULL,
  `jenis_kegiatan_id` bigint NOT NULL,
  `tanggal` date NOT NULL,
  `link_dokumentasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jurnals`
--

INSERT INTO `jurnals` (`id`, `user_id`, `tahun_ajaran_id`, `dudi_id`, `jenis_kegiatan_id`, `tanggal`, `link_dokumentasi`, `created_at`, `updated_at`) VALUES
(4, 2, 2, 2, 4, '2023-10-06', 'https://google.com', '2023-10-06 02:13:34', '2023-10-06 02:13:34'),
(7, 2, 2, 2, 2, '2023-10-06', 'asd', '2023-10-06 02:25:48', '2023-10-06 02:25:48'),
(11, 1, 2, 1, 4, '2023-10-10', 'https://google.com', '2023-10-10 01:33:52', '2023-10-10 01:33:52'),
(12, 1, 2, 1, 1, '2023-10-10', 'https://google.com', '2023-10-10 01:34:11', '2023-10-10 01:34:11'),
(13, 1, 2, 1, 2, '2023-10-12', 'https://drive.google.com/SkansaBawang', '2023-10-10 03:12:50', '2023-10-10 03:12:50'),
(14, 2, 2, 2, 5, '2023-10-11', 'https://instagram.com/indrakus_', '2023-10-11 03:53:28', '2023-10-11 03:53:28'),
(15, 1, 2, 1, 3, '2023-10-12', 'https://google.com', '2023-10-12 03:20:21', '2023-10-12 03:20:21');

-- --------------------------------------------------------

--
-- Table structure for table `jurnal_details`
--

CREATE TABLE `jurnal_details` (
  `id` bigint UNSIGNED NOT NULL,
  `jurnal_id` bigint NOT NULL,
  `siswa_id` bigint NOT NULL,
  `materi` text COLLATE utf8mb4_unicode_ci,
  `kehadiran` enum('H','I','A') COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jurnal_details`
--

INSERT INTO `jurnal_details` (`id`, `jurnal_id`, `siswa_id`, `materi`, `kehadiran`, `keterangan`, `created_at`, `updated_at`) VALUES
(3, 4, 8, 'Install Server', 'H', '-', '2023-10-06 02:13:34', '2023-10-11 03:39:55'),
(4, 4, 9, 'Konfigurasi Server', 'H', '-', '2023-10-06 02:13:34', '2023-10-11 03:39:55'),
(5, 7, 8, NULL, 'H', '-', '2023-10-06 02:25:48', '2023-10-06 02:25:48'),
(6, 7, 9, NULL, 'H', '-', '2023-10-06 02:25:48', '2023-10-06 02:25:48'),
(11, 11, 10, 'Testing 1', 'H', '-', '2023-10-10 01:33:52', '2023-10-10 03:10:46'),
(12, 11, 1, 'Testing 2', 'H', '-', '2023-10-10 01:33:52', '2023-10-10 03:10:46'),
(13, 12, 10, NULL, 'H', '-', '2023-10-10 01:34:11', '2023-10-10 01:34:11'),
(14, 12, 1, NULL, 'I', '-', '2023-10-10 01:34:11', '2023-10-10 01:34:11'),
(15, 13, 10, 'Test Materi Ad', 'H', '-', '2023-10-10 03:12:50', '2023-10-12 03:17:26'),
(16, 13, 1, 'Test Materi Kaia', 'H', '-', '2023-10-10 03:12:50', '2023-10-10 03:12:50'),
(17, 14, 8, 'Penilaian Project', 'H', '-', '2023-10-11 03:53:28', '2023-10-11 03:53:28'),
(18, 14, 9, 'Penilaian Project', 'H', '-', '2023-10-11 03:53:28', '2023-10-11 03:53:28'),
(19, 15, 10, 'Penarikan 1', 'H', '-', '2023-10-12 03:20:21', '2023-10-12 03:20:21'),
(20, 15, 1, 'Penarikan 2', 'H', '-', '2023-10-12 03:20:21', '2023-10-12 03:20:21');

-- --------------------------------------------------------

--
-- Table structure for table `jurusans`
--

CREATE TABLE `jurusans` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_jurusan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_jurusan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jurusans`
--

INSERT INTO `jurusans` (`id`, `nama_jurusan`, `kode_jurusan`, `created_at`, `updated_at`) VALUES
(1, 'Pemrograman Perangkat Lunak dan Gim', 'PPLG', '2023-09-12 20:36:08', '2023-09-12 20:36:44'),
(2, 'Teknik Jaringan Komputer dan Telekomunikasi', 'TJKT', '2023-09-12 20:36:57', '2023-09-12 20:36:57'),
(4, 'Teknik Elektronika', 'TE', '2023-09-12 20:37:28', '2023-09-12 20:37:28'),
(6, 'Pemasaran', 'PM', '2023-09-12 20:45:49', '2023-09-12 20:45:49');

-- --------------------------------------------------------

--
-- Table structure for table `kelass`
--

CREATE TABLE `kelass` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_kelas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jurusan_id` bigint NOT NULL,
  `tahun_ajaran_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kelass`
--

INSERT INTO `kelass` (`id`, `nama_kelas`, `jurusan_id`, `tahun_ajaran_id`, `created_at`, `updated_at`) VALUES
(1, '2021 PPLG 1', 1, 2, '2023-09-12 21:18:39', '2023-09-14 20:03:03'),
(2, '2021 PPLG 2', 1, 2, '2023-09-18 00:29:35', '2023-09-18 00:29:35');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2020_10_30_072718_create_crud_example_base_table', 1),
(6, '2020_10_30_073614_create_crud_example_try_table', 1),
(7, '2020_11_12_041342_create_permission_tables', 1),
(8, '2023_09_12_013802_create_siswas_table', 1),
(9, '2023_09_12_013828_create_jurusans_table', 1),
(10, '2023_09_12_014006_create_kelass_table', 1),
(11, '2023_09_12_014020_create_tahun_ajarans_table', 1),
(12, '2023_09_12_014244_create_siswa_pkls_table', 1),
(13, '2023_09_12_014255_create_dudis_table', 1),
(14, '2023_09_12_015811_create_jenis_kegiatans_table', 1),
(15, '2023_09_26_154542_create_jurnals_table', 2),
(16, '2023_09_26_155917_create_jurnal_details_table', 2),
(17, '2023_10_11_092437_create_nilai_pkls_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(3, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 3),
(1, 'App\\Models\\User', 6);

-- --------------------------------------------------------

--
-- Table structure for table `nilai_pkls`
--

CREATE TABLE `nilai_pkls` (
  `id` bigint UNSIGNED NOT NULL,
  `tahun_ajaran_id` bigint NOT NULL,
  `siswa_id` bigint NOT NULL,
  `kelas_id` bigint NOT NULL,
  `dudi_id` bigint NOT NULL,
  `nilai` int NOT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nilai_pkls`
--

INSERT INTO `nilai_pkls` (`id`, `tahun_ajaran_id`, `siswa_id`, `kelas_id`, `dudi_id`, `nilai`, `catatan`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 2, 8, 2, 2, 93, 'Coba 1', 1, '2023-10-11 06:33:39', '2023-10-11 06:51:39'),
(2, 2, 9, 2, 2, 87, 'Coba 2', 1, '2023-10-11 06:33:39', '2023-10-11 06:51:39');

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
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2023-09-11 21:05:36', '2023-09-11 21:05:36'),
(2, 'pokja', 'web', '2023-09-11 21:05:36', '2023-09-11 21:05:36'),
(3, 'guru', 'web', '2023-09-11 21:05:36', '2023-09-11 21:05:36'),
(4, 'waka', 'web', '2023-09-20 07:29:37', '2023-09-20 07:29:37');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `siswas`
--

CREATE TABLE `siswas` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jk` enum('L','P') COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelas_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `siswas`
--

INSERT INTO `siswas` (`id`, `nama`, `nis`, `jk`, `kelas_id`, `created_at`, `updated_at`) VALUES
(1, 'Kaia Kusuma', '123321', 'P', 1, NULL, '2023-09-19 01:59:28'),
(8, 'Difarina Indra', '123123', 'P', 2, '2023-09-18 00:33:34', '2023-09-18 00:35:02'),
(9, 'Yeni Inka', '456456', 'P', 2, '2023-09-18 00:33:34', '2023-09-18 00:33:34'),
(10, 'Adrian Dwi Kusuma', '111222', 'L', 1, '2023-09-19 01:38:56', '2023-09-19 01:38:56'),
(11, 'Happy Asmara', '112233', 'P', 2, '2023-10-12 04:22:27', '2023-10-12 04:22:27');

-- --------------------------------------------------------

--
-- Table structure for table `siswa_pkls`
--

CREATE TABLE `siswa_pkls` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint NOT NULL,
  `tahun_ajaran_id` bigint NOT NULL,
  `dudi_id` bigint NOT NULL,
  `siswa_id` bigint NOT NULL,
  `awal_pkl` date NOT NULL,
  `akhir_pkl` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `siswa_pkls`
--

INSERT INTO `siswa_pkls` (`id`, `user_id`, `tahun_ajaran_id`, `dudi_id`, `siswa_id`, `awal_pkl`, `akhir_pkl`, `created_at`, `updated_at`) VALUES
(12, 1, 2, 1, 10, '2023-09-20', '2023-09-27', '2023-09-20 02:31:54', '2023-09-20 02:31:54'),
(14, 2, 2, 2, 8, '2023-10-06', '2024-01-06', '2023-10-06 02:11:23', '2023-10-06 02:11:23'),
(15, 2, 2, 2, 9, '2023-10-06', '2024-01-06', '2023-10-06 02:11:24', '2023-10-06 02:11:24'),
(16, 1, 2, 1, 1, '2023-10-09', '2023-12-10', '2023-10-10 01:32:58', '2023-10-10 01:32:58');

-- --------------------------------------------------------

--
-- Table structure for table `tahun_ajarans`
--

CREATE TABLE `tahun_ajarans` (
  `id` bigint UNSIGNED NOT NULL,
  `tahun_ajaran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kepsek_id` bigint DEFAULT NULL,
  `aktif` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tahun_ajarans`
--

INSERT INTO `tahun_ajarans` (`id`, `tahun_ajaran`, `kepsek_id`, `aktif`, `created_at`, `updated_at`) VALUES
(2, '2023/2024', 6, 1, '2023-09-12 20:00:19', '2023-10-10 01:50:58'),
(3, '2024/2025', NULL, 0, '2023-09-12 20:01:31', '2023-09-20 05:02:03'),
(5, '2025/2026', NULL, 0, '2023-09-12 20:16:15', '2023-09-12 20:16:15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `identity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `nip`, `identity`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Indra Kusuma, S.Kom.', '-', '330406123456789', 'admin@email.com', NULL, '$2y$10$LVLBXTefeiRbW1b/l4qQuuq0a0cT1WFK7nk.M4DaAK2YSiVB78sa2', NULL, NULL, NULL, '2023-09-11 21:07:56', '2023-10-10 01:53:25'),
(2, 'Andrian Kristanto, S.Pd.', '1234567890123457', '330706123456781', 'guru@email.com', NULL, '$2y$10$PCJvmWfkDDq1BkqFF4.3SeO0FrHOZ4TjElL3.1KIlknsspk8k7oM6', NULL, NULL, NULL, '2023-09-11 21:07:56', '2023-10-10 01:46:13'),
(3, 'Irawan Setiadi, S.Pd.', '1234567890123458', '330406123456782', 'pokja@email.com', NULL, '$2y$10$1.ZxZehg6T82k2fOFa.McOvGuWfEvnEaLevmhDwEB9S6jD6ROyNXK', NULL, NULL, NULL, '2023-09-11 21:07:56', '2023-10-10 01:46:37'),
(6, 'Drs. Supriyadi', '196601281993021002', '196601281993021002', 'supriyadi@smkn1bawang.sch.id', NULL, '$2y$10$adReWTLmeKWzByBrfJoA5uyt5c6YlTQPEF1hnOmaQdfBWXI3jMwAC', NULL, NULL, NULL, '2023-10-10 01:50:48', '2023-10-10 01:50:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dudis`
--
ALTER TABLE `dudis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jenis_kegiatans`
--
ALTER TABLE `jenis_kegiatans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jurnals`
--
ALTER TABLE `jurnals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jurnal_details`
--
ALTER TABLE `jurnal_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jurusans`
--
ALTER TABLE `jurusans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelass`
--
ALTER TABLE `kelass`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `nilai_pkls`
--
ALTER TABLE `nilai_pkls`
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `siswas`
--
ALTER TABLE `siswas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `siswa_pkls`
--
ALTER TABLE `siswa_pkls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tahun_ajarans`
--
ALTER TABLE `tahun_ajarans`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `dudis`
--
ALTER TABLE `dudis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jenis_kegiatans`
--
ALTER TABLE `jenis_kegiatans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jurnals`
--
ALTER TABLE `jurnals`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `jurnal_details`
--
ALTER TABLE `jurnal_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `jurusans`
--
ALTER TABLE `jurusans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kelass`
--
ALTER TABLE `kelass`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `nilai_pkls`
--
ALTER TABLE `nilai_pkls`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `siswas`
--
ALTER TABLE `siswas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `siswa_pkls`
--
ALTER TABLE `siswa_pkls`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tahun_ajarans`
--
ALTER TABLE `tahun_ajarans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
