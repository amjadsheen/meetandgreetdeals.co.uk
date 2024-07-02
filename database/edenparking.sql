-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2019 at 08:38 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `edenparking`
--

-- --------------------------------------------------------

--
-- Table structure for table `airports`
--

CREATE TABLE `airports` (
  `id` int(11) NOT NULL,
  `nick` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `directions` varchar(255) NOT NULL,
  `disable` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `airports`
--

INSERT INTO `airports` (`id`, `nick`, `name`, `directions`, `disable`, `created_at`, `updated_at`) VALUES
(1, 'LHR', 'London Heathrow', '?page_id=3683', 0, '2019-06-25 18:26:07', '2019-06-25 18:24:57'),
(6, 'LGW', 'London Gatwick', '', 1, '2019-06-25 18:26:07', '2019-06-25 18:24:57'),
(7, 'LTN', 'London Luton', '', 1, '2019-06-25 18:26:07', '2019-06-25 18:24:57'),
(8, 'STN', 'London Stansted', '', 1, '2019-06-25 18:26:07', '2019-06-25 18:24:57'),
(9, 'LCY', 'London city', '', 1, '2019-06-25 18:26:07', '2019-06-25 18:24:57'),
(19, 'ee', 'eee', 'eee', 1, '2019-06-26 01:28:08', '2019-06-26 01:28:08'),
(20, 'sas', 'DSD', 'EWEWE', 1, '2019-06-26 02:16:31', '2019-06-26 02:16:31'),
(21, 'SD', 'DDD', 'SDSD', 1, '2019-06-26 02:16:42', '2019-06-26 02:16:42');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` int(11) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_id` int(11) DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `phone`, `state`, `email`, `role`, `email_verified_at`, `password`, `status_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(4, 'Guiseppe Reinger', '+6981587515794', 'Mississippi', 'admin@admin.com', 2, '2019-06-16 02:46:09', '$2y$10$kcHuRfZVfOYaDA6SmDgDv.gW1Q7JbF8NkRQ04jJoRSjycNUU.pf2W', NULL, 'p5qWeRclyndK6R2qI3EqgOuhI2qpCLYdqVixJjUH2GSX5Bm9qOqGNz6RnKjb', '2019-06-16 02:46:10', '2019-06-16 02:46:10'),
(5, 'Queen Dietrich', '+4860335108532', 'North Dakota', 'superadmin@admin.com', 1, '2019-06-16 02:46:09', '$2y$10$kcHuRfZVfOYaDA6SmDgDv.gW1Q7JbF8NkRQ04jJoRSjycNUU.pf2W', NULL, 'xBVbLrMJH6npH2pmIyZvSjelXVCh6oUV6HSJKJfjFaMDHoNNt0LqDW7wOWEM', '2019-06-16 02:46:10', '2019-06-16 02:46:10'),
(6, 'Prof. Bobbie Bashirian', '+3169912584454', 'Rhode Island', 'user@user.com', 3, '2019-06-16 02:46:09', '$2y$10$kcHuRfZVfOYaDA6SmDgDv.gW1Q7JbF8NkRQ04jJoRSjycNUU.pf2W', NULL, 'TK9UjbEZxbJMgnUkZGVKcUwYJEUP8mWO1vwBwIek13cLjezUIHPLlWEfxfoX', '2019-06-16 02:46:10', '2019-06-16 02:46:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `airports`
--
ALTER TABLE `airports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

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
-- AUTO_INCREMENT for table `airports`
--
ALTER TABLE `airports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
