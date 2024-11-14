-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2024 at 01:54 PM
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
-- Database: `2024_qvintus`
--

-- --------------------------------------------------------

--
-- Table structure for table `table_bocker`
--

CREATE TABLE `table_bocker` (
  `id_bok` int(11) NOT NULL,
  `titel` varchar(255) NOT NULL,
  `beskrivning` varchar(510) NOT NULL,
  `aldersrekommendation` varchar(255) NOT NULL,
  `utgiven` date NOT NULL,
  `sidor` varchar(255) NOT NULL,
  `pris` decimal(10,0) NOT NULL,
  `serie_fk` int(11) NOT NULL,
  `forfattare_fk` int(11) NOT NULL,
  `form_eller_illu_fk` int(11) NOT NULL,
  `kategori_fk` int(11) NOT NULL,
  `genre_fk` int(11) NOT NULL,
  `sprak_fk` int(11) NOT NULL,
  `forlag_fk` int(11) NOT NULL,
  `status_fk` int(11) NOT NULL,
  `skapad_av_fk` int(11) NOT NULL,
  `bok_img` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `table_forfattare`
--

CREATE TABLE `table_forfattare` (
  `id_forfattare` int(11) NOT NULL,
  `forfattare_namn` varchar(255) NOT NULL,
  `id_bok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `table_forlag`
--

CREATE TABLE `table_forlag` (
  `id_forlag` int(11) NOT NULL,
  `forlag_namn` varchar(255) NOT NULL,
  `id_bok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `table_form`
--

CREATE TABLE `table_form` (
  `id_kategori` int(11) NOT NULL,
  `kategori_namn` varchar(255) NOT NULL,
  `id_bok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `table_genre`
--

CREATE TABLE `table_genre` (
  `id_genre` int(11) NOT NULL,
  `genre_namn` varchar(255) NOT NULL,
  `id_bok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `table_roles`
--

CREATE TABLE `table_roles` (
  `r_id` int(11) NOT NULL,
  `r_name` varchar(255) NOT NULL,
  `r_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_roles`
--

INSERT INTO `table_roles` (`r_id`, `r_name`, `r_level`) VALUES
(1, 'Försäljare', 10),
(2, 'ButiksChef', 100),
(3, 'Admin', 300),
(4, 'Disable', 1);

-- --------------------------------------------------------

--
-- Table structure for table `table_serie`
--

CREATE TABLE `table_serie` (
  `id_serie` int(11) NOT NULL,
  `serie_namn` varchar(255) NOT NULL,
  `id_bok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `table_spark`
--

CREATE TABLE `table_spark` (
  `id_sprak` int(11) NOT NULL,
  `sprak_namn` varchar(255) NOT NULL,
  `id_bok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `table_status`
--

CREATE TABLE `table_status` (
  `id_status` int(11) NOT NULL,
  `status_namn` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `table_users`
--

CREATE TABLE `table_users` (
  `u_id` int(11) NOT NULL,
  `u_name` varchar(255) NOT NULL,
  `u_password` varchar(255) NOT NULL,
  `u_email` varchar(255) NOT NULL,
  `u_role_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_users`
--

INSERT INTO `table_users` (`u_id`, `u_name`, `u_password`, `u_email`, `u_role_fk`) VALUES
(1, 'kevin', '$2y$10$V.6uwJoS5AqCYGLCNsQ1ouBSSNqs3doQd18w1T6xcf8VIG79A//3W', 'kevin@admin.fi', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `table_bocker`
--
ALTER TABLE `table_bocker`
  ADD PRIMARY KEY (`id_bok`),
  ADD KEY `serie_fk` (`serie_fk`,`forfattare_fk`,`form_eller_illu_fk`,`kategori_fk`,`genre_fk`,`sprak_fk`,`forlag_fk`,`status_fk`,`skapad_av_fk`);

--
-- Indexes for table `table_forfattare`
--
ALTER TABLE `table_forfattare`
  ADD PRIMARY KEY (`id_forfattare`);

--
-- Indexes for table `table_forlag`
--
ALTER TABLE `table_forlag`
  ADD PRIMARY KEY (`id_forlag`);

--
-- Indexes for table `table_form`
--
ALTER TABLE `table_form`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `table_genre`
--
ALTER TABLE `table_genre`
  ADD PRIMARY KEY (`id_genre`);

--
-- Indexes for table `table_roles`
--
ALTER TABLE `table_roles`
  ADD PRIMARY KEY (`r_id`);

--
-- Indexes for table `table_serie`
--
ALTER TABLE `table_serie`
  ADD PRIMARY KEY (`id_serie`);

--
-- Indexes for table `table_spark`
--
ALTER TABLE `table_spark`
  ADD PRIMARY KEY (`id_sprak`);

--
-- Indexes for table `table_status`
--
ALTER TABLE `table_status`
  ADD PRIMARY KEY (`id_status`);

--
-- Indexes for table `table_users`
--
ALTER TABLE `table_users`
  ADD PRIMARY KEY (`u_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `table_bocker`
--
ALTER TABLE `table_bocker`
  MODIFY `id_bok` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `table_forfattare`
--
ALTER TABLE `table_forfattare`
  MODIFY `id_forfattare` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `table_forlag`
--
ALTER TABLE `table_forlag`
  MODIFY `id_forlag` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `table_form`
--
ALTER TABLE `table_form`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `table_roles`
--
ALTER TABLE `table_roles`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `table_serie`
--
ALTER TABLE `table_serie`
  MODIFY `id_serie` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `table_spark`
--
ALTER TABLE `table_spark`
  MODIFY `id_sprak` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `table_status`
--
ALTER TABLE `table_status`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `table_users`
--
ALTER TABLE `table_users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `table_bocker`
--
ALTER TABLE `table_bocker`
  ADD CONSTRAINT `fk1` FOREIGN KEY (`serie_fk`) REFERENCES `table_serie` (`id_serie`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
