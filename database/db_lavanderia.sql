-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 30-Abr-2017 às 14:22
-- Versão do servidor: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_lavanderia`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `clients`
--

CREATE TABLE `clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `clients`
--

INSERT INTO `clients` (`id`, `code`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '43', 'marlene Neves', '2017-04-28 03:08:25', '2017-04-28 03:08:25', NULL),
(2, '41', 'Paulo', '2017-04-28 03:08:25', '2017-04-28 03:08:25', NULL),
(3, 'JOE', 'Joel', '2017-04-28 03:08:25', '2017-04-28 03:08:25', NULL),
(4, 'MO', 'Moita', '2017-04-28 03:08:25', '2017-04-28 03:08:25', NULL),
(5, 'DY', 'Disney', '2017-04-28 03:08:25', '2017-04-28 03:08:25', NULL),
(6, 'IN', 'Inara', '2017-04-28 03:08:25', '2017-04-28 03:08:25', NULL),
(7, 'CLA', 'Claudio', '2017-04-28 03:08:25', '2017-04-28 03:08:25', NULL),
(8, 'JCO', 'Jânio', '2017-04-28 03:08:25', '2017-04-28 03:08:25', NULL),
(9, 'MT', 'Maria Cristina', '2017-04-28 03:08:25', '2017-04-28 03:08:25', NULL),
(10, 'VR', 'Vera', '2017-04-28 03:08:25', '2017-04-28 03:08:25', NULL),
(11, 'JM', 'José Maria', '2017-04-28 03:08:25', '2017-04-28 03:08:25', NULL),
(12, '42', 'Marcos ', '2017-04-28 03:08:25', '2017-04-28 03:08:25', NULL),
(13, 'CL', 'Cláudia', '2017-04-28 03:08:25', '2017-04-28 03:08:25', NULL),
(14, 'PL', 'Poliana', '2017-04-28 03:08:25', '2017-04-28 03:08:25', NULL),
(15, 'MC', 'Marilize Caldas', '2017-04-28 03:08:25', '2017-04-28 03:08:25', NULL),
(16, 'ED', 'Eduardo', '2017-04-28 03:08:25', '2017-04-28 03:08:25', NULL),
(17, 'T3', 'Thiago Cachorro', '2017-04-28 03:08:25', '2017-04-28 03:08:25', NULL),
(18, 'NT', 'Neto', '2017-04-28 03:08:25', '2017-04-28 03:08:25', NULL),
(19, 'MHCP', 'Maria Helena', '2017-04-28 03:08:25', '2017-04-28 03:08:25', NULL),
(20, 'ALX', 'Alex', '2017-04-28 03:08:25', '2017-04-28 03:08:25', NULL),
(21, 'R5', 'Santana', '2017-04-28 03:08:25', '2017-04-28 03:08:25', NULL),
(22, 'GIS', 'Gislaine', '2017-04-28 03:08:25', '2017-04-28 03:08:25', NULL),
(23, 'DR', 'Dinora', '2017-04-28 03:08:25', '2017-04-28 03:08:25', NULL),
(24, 'FCL', 'Silvia', '2017-04-28 03:08:25', '2017-04-28 03:08:25', NULL),
(25, 'TL', 'Maria Tereza Lotumulo', '2017-04-28 03:08:26', '2017-04-28 03:08:26', NULL),
(26, 'R7', 'Roseli', '2017-04-28 03:08:26', '2017-04-28 03:08:26', NULL),
(27, 'BA', 'Bruno Alves', '2017-04-28 03:08:26', '2017-04-28 03:08:26', NULL),
(28, '10', 'Ivete', '2017-04-28 03:08:26', '2017-04-28 03:08:26', NULL),
(29, 'CR', 'Cristiane', '2017-04-28 03:08:26', '2017-04-28 03:08:26', NULL),
(30, 'E', 'Elizabete', '2017-04-28 03:08:26', '2017-04-28 03:08:26', NULL),
(31, 'AL', 'Alfredo', '2017-04-28 03:08:26', '2017-04-28 03:08:26', NULL),
(32, 'PED', 'Eliane', '2017-04-28 03:08:26', '2017-04-28 03:08:26', NULL),
(33, 'MM', 'Maria Amélia', '2017-04-28 03:08:26', '2017-04-28 03:08:26', NULL),
(34, 'JC', 'Jacira', '2017-04-28 03:08:26', '2017-04-28 03:08:26', NULL),
(35, '6', 'Marco Aurelio', '2017-04-28 03:08:26', '2017-04-28 03:08:26', NULL),
(36, 'HB', 'Hernane Bruna', '2017-04-28 03:08:26', '2017-04-28 03:08:26', NULL),
(37, 'Arlei', 'Arlei', '2017-04-28 03:08:26', '2017-04-28 03:08:26', NULL),
(38, 'RP', 'Ricardo Policial', '2017-04-28 03:08:26', '2017-04-28 03:08:26', NULL),
(39, '1311', 'Odeibler', '2017-04-28 03:08:26', '2017-04-28 03:08:26', NULL),
(40, '8A', '8A', '2017-04-28 03:08:26', '2017-04-28 03:08:26', NULL),
(41, 'CRV', 'Luciana', '2017-04-28 03:08:26', '2017-04-28 03:08:26', NULL),
(42, 'FC', 'Francisco', '2017-04-28 03:08:26', '2017-04-28 03:08:26', NULL),
(43, '1', 'Fernanda ', '2017-04-28 03:08:26', '2017-04-28 03:08:26', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `items`
--

CREATE TABLE `items` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `items`
--

INSERT INTO `items` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Dia a dia', '2017-04-28 03:08:26', '2017-04-28 03:08:26', NULL),
(2, 'Roupa social', '2017-04-28 03:08:26', '2017-04-28 03:08:26', NULL),
(3, 'Vestidos longos', '2017-04-28 03:08:26', '2017-04-28 03:08:26', NULL),
(4, 'Vestidos curtos', '2017-04-28 03:08:26', '2017-04-28 03:08:26', NULL),
(5, 'Terno', '2017-04-28 03:08:26', '2017-04-28 03:08:26', NULL),
(6, 'Paletó', '2017-04-28 03:08:26', '2017-04-28 03:08:26', NULL),
(7, 'Jaqueta de couro', '2017-04-28 03:08:26', '2017-04-28 03:08:26', NULL),
(8, 'Jaqueta comum', '2017-04-28 03:08:26', '2017-04-28 03:08:26', NULL),
(9, 'Sobretudo', '2017-04-28 03:08:26', '2017-04-28 03:08:26', NULL),
(10, 'Tênis', '2017-04-28 03:08:26', '2017-04-28 03:08:26', NULL),
(11, 'Cobre leito', '2017-04-28 03:08:26', '2017-04-28 03:08:26', NULL),
(12, 'Edredon solteiro', '2017-04-28 03:08:26', '2017-04-28 03:08:26', NULL),
(13, 'Edredon casal', '2017-04-28 03:08:27', '2017-04-28 03:08:27', NULL),
(14, 'Edredon king', '2017-04-28 03:08:27', '2017-04-28 03:08:27', NULL),
(15, 'Avulsos', '2017-04-28 03:08:27', '2017-04-28 03:08:27', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `item_values`
--

CREATE TABLE `item_values` (
  `id` int(10) UNSIGNED NOT NULL,
  `item_id` int(10) UNSIGNED NOT NULL,
  `laundry_price` decimal(5,2) NOT NULL,
  `ironing_price` decimal(5,2) NOT NULL,
  `both_price` decimal(5,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `item_values`
--

INSERT INTO `item_values` (`id`, `item_id`, `laundry_price`, `ironing_price`, `both_price`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '0.00', '12.00', '15.00', '2017-04-28 03:10:58', '2017-04-28 03:18:40', NULL),
(2, 2, '0.00', '18.00', '30.00', '2017-04-28 03:10:58', '2017-04-28 03:18:40', NULL),
(3, 3, '0.00', '0.00', '40.00', '2017-04-28 03:10:58', '2017-04-28 03:18:41', NULL),
(4, 4, '0.00', '0.00', '20.00', '2017-04-28 03:10:58', '2017-04-28 03:18:41', NULL),
(5, 5, '0.00', '0.00', '25.00', '2017-04-28 03:10:59', '2017-04-28 03:18:41', NULL),
(6, 6, '0.00', '0.00', '18.00', '2017-04-28 03:10:59', '2017-04-28 03:18:41', NULL),
(7, 7, '0.00', '0.00', '30.00', '2017-04-28 03:10:59', '2017-04-28 03:18:41', NULL),
(8, 8, '0.00', '0.00', '18.00', '2017-04-28 03:10:59', '2017-04-28 03:18:41', NULL),
(9, 9, '0.00', '0.00', '20.00', '2017-04-28 03:10:59', '2017-04-28 03:18:41', NULL),
(10, 10, '15.00', '0.00', '0.00', '2017-04-28 03:10:59', '2017-04-28 03:18:41', NULL),
(11, 11, '0.00', '0.00', '20.00', '2017-04-28 03:10:59', '2017-04-28 03:18:41', NULL),
(12, 12, '0.00', '0.00', '20.00', '2017-04-28 03:10:59', '2017-04-28 03:18:41', NULL),
(13, 13, '0.00', '0.00', '25.00', '2017-04-28 03:10:59', '2017-04-28 03:18:41', NULL),
(15, 14, '0.00', '0.00', '30.00', '2017-04-28 03:18:41', '2017-04-28 03:18:41', NULL),
(16, 15, '0.00', '0.00', '8.00', '2017-04-28 03:18:41', '2017-04-28 03:18:41', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(10, '2014_10_12_000000_create_users_table', 1),
(11, '2014_10_12_100000_create_password_resets_table', 1),
(12, '2017_04_25_003417_create_clients_table', 1),
(13, '2017_04_25_003556_create_services_table', 1),
(14, '2017_04_25_003719_create_items_table', 1),
(15, '2017_04_25_003809_create_service_items_table', 1),
(16, '2017_04_25_003850_create_sub_items_table', 1),
(17, '2017_04_25_004000_create_item_values_table', 1),
(18, '2017_04_25_004042_create_payments_table', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `payments`
--

CREATE TABLE `payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `value` decimal(5,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `services`
--

CREATE TABLE `services` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `delivery_at` timestamp NOT NULL,
  `delivered_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `service_items`
--

CREATE TABLE `service_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `service_id` int(10) UNSIGNED NOT NULL,
  `item_id` int(10) UNSIGNED NOT NULL,
  `type` enum('LAVAR','PASSAR','AMBOS') COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` decimal(5,3) NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sub_items`
--

CREATE TABLE `sub_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `service_item_id` int(10) UNSIGNED NOT NULL,
  `desc` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Joca', 'jcsbaldini@gmail.com', '$2a$06$u0UfzYw.kUPXSIxEdSZ1eeO9FFgqPvgXfEwsKYyY2LnOGwAeKQvyS', NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_values`
--
ALTER TABLE `item_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_values_item_id_foreign` (`item_id`);

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
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_client_id_foreign` (`client_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_client_id_foreign` (`client_id`);

--
-- Indexes for table `service_items`
--
ALTER TABLE `service_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_items_service_id_foreign` (`service_id`),
  ADD KEY `service_items_item_id_foreign` (`item_id`);

--
-- Indexes for table `sub_items`
--
ALTER TABLE `sub_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_items_service_item_id_foreign` (`service_item_id`);

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
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `item_values`
--
ALTER TABLE `item_values`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `service_items`
--
ALTER TABLE `service_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sub_items`
--
ALTER TABLE `sub_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `item_values`
--
ALTER TABLE `item_values`
  ADD CONSTRAINT `item_values_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`);

--
-- Limitadores para a tabela `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `service_items` (`id`);

--
-- Limitadores para a tabela `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`);

--
-- Limitadores para a tabela `service_items`
--
ALTER TABLE `service_items`
  ADD CONSTRAINT `service_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `service_items_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`);

--
-- Limitadores para a tabela `sub_items`
--
ALTER TABLE `sub_items`
  ADD CONSTRAINT `sub_items_service_item_id_foreign` FOREIGN KEY (`service_item_id`) REFERENCES `service_items` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
