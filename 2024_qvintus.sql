-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2024 at 01:51 PM
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
  `bok_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `table_category`
--

CREATE TABLE `table_category` (
  `id_kategori` int(11) NOT NULL,
  `kategori_namn` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_category`
--

INSERT INTO `table_category` (`id_kategori`, `kategori_namn`) VALUES
(7, 'kategori1'),
(8, 'kategori2');

-- --------------------------------------------------------

--
-- Table structure for table `table_forfattare`
--

CREATE TABLE `table_forfattare` (
  `id_forfattare` int(11) NOT NULL,
  `forfattare_namn` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_forfattare`
--

INSERT INTO `table_forfattare` (`id_forfattare`, `forfattare_namn`) VALUES
(1, 'forfattare'),
(2, 'forfattare2'),
(3, 'forfattare3');

-- --------------------------------------------------------

--
-- Table structure for table `table_forlag`
--

CREATE TABLE `table_forlag` (
  `id_forlag` int(11) NOT NULL,
  `forlag_namn` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_forlag`
--

INSERT INTO `table_forlag` (`id_forlag`, `forlag_namn`) VALUES
(1, 'forlag');

-- --------------------------------------------------------

--
-- Table structure for table `table_form`
--

CREATE TABLE `table_form` (
  `id_form_eller_illu` int(11) NOT NULL,
  `form_eller_illu_namn` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_form`
--

INSERT INTO `table_form` (`id_form_eller_illu`, `form_eller_illu_namn`) VALUES
(1, 'form_eller_illu_namn');

-- --------------------------------------------------------

--
-- Table structure for table `table_genre`
--

CREATE TABLE `table_genre` (
  `id_genre` int(11) NOT NULL,
  `genre_namn` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_genre`
--

INSERT INTO `table_genre` (`id_genre`, `genre_namn`) VALUES
(2, 'genre85345'),
(3, 'gen43re');

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
  `serie_namn` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_serie`
--

INSERT INTO `table_serie` (`id_serie`, `serie_namn`) VALUES
(1, 'serie'),
(2, 'seri324'),
(3, 'serie4435678');

-- --------------------------------------------------------

--
-- Table structure for table `table_spark`
--

CREATE TABLE `table_spark` (
  `id_sprak` int(11) NOT NULL,
  `sprak_namn` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_spark`
--

INSERT INTO `table_spark` (`id_sprak`, `sprak_namn`) VALUES
(1, 'Svenska');

-- --------------------------------------------------------

--
-- Table structure for table `table_status`
--

CREATE TABLE `table_status` (
  `id_status` int(11) NOT NULL,
  `status_namn` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_status`
--

INSERT INTO `table_status` (`id_status`, `status_namn`) VALUES
(1, 'Rare'),
(2, 'Popular'),
(3, 'Popular right now!');

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
(2, 'kevin', '$2y$10$hvC3Lt5CXX8OzYOC22c7LeMBT/VujjzkxGPVTUJd/De864mBoUgfW', 'apa233@gmail.com', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `table_bocker`
--
ALTER TABLE `table_bocker`
  ADD PRIMARY KEY (`id_bok`),
  ADD KEY `serie_fk` (`serie_fk`,`forfattare_fk`,`form_eller_illu_fk`,`kategori_fk`,`genre_fk`,`sprak_fk`,`forlag_fk`,`status_fk`,`skapad_av_fk`),
  ADD KEY `fk2` (`kategori_fk`),
  ADD KEY `fk3` (`forfattare_fk`),
  ADD KEY `fk5` (`sprak_fk`),
  ADD KEY `fk7` (`skapad_av_fk`),
  ADD KEY `fk9` (`forlag_fk`),
  ADD KEY `fk10` (`status_fk`),
  ADD KEY `fk11` (`form_eller_illu_fk`),
  ADD KEY `fk4` (`genre_fk`);

--
-- Indexes for table `table_category`
--
ALTER TABLE `table_category`
  ADD PRIMARY KEY (`id_kategori`);

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
  ADD PRIMARY KEY (`id_form_eller_illu`);

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
  ADD PRIMARY KEY (`u_id`),
  ADD KEY `fk34` (`u_role_fk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `table_bocker`
--
ALTER TABLE `table_bocker`
  MODIFY `id_bok` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `table_category`
--
ALTER TABLE `table_category`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `table_forfattare`
--
ALTER TABLE `table_forfattare`
  MODIFY `id_forfattare` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `table_forlag`
--
ALTER TABLE `table_forlag`
  MODIFY `id_forlag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `table_form`
--
ALTER TABLE `table_form`
  MODIFY `id_form_eller_illu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `table_genre`
--
ALTER TABLE `table_genre`
  MODIFY `id_genre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `table_roles`
--
ALTER TABLE `table_roles`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `table_serie`
--
ALTER TABLE `table_serie`
  MODIFY `id_serie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `table_spark`
--
ALTER TABLE `table_spark`
  MODIFY `id_sprak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `table_status`
--
ALTER TABLE `table_status`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `table_users`
--
ALTER TABLE `table_users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `table_bocker`
--
ALTER TABLE `table_bocker`
  ADD CONSTRAINT `fk1` FOREIGN KEY (`serie_fk`) REFERENCES `table_serie` (`id_serie`),
  ADD CONSTRAINT `fk10` FOREIGN KEY (`status_fk`) REFERENCES `table_status` (`id_status`),
  ADD CONSTRAINT `fk11` FOREIGN KEY (`form_eller_illu_fk`) REFERENCES `table_form` (`id_form_eller_illu`),
  ADD CONSTRAINT `fk2` FOREIGN KEY (`kategori_fk`) REFERENCES `table_category` (`id_kategori`),
  ADD CONSTRAINT `fk3` FOREIGN KEY (`forfattare_fk`) REFERENCES `table_forfattare` (`id_forfattare`),
  ADD CONSTRAINT `fk4` FOREIGN KEY (`genre_fk`) REFERENCES `table_genre` (`id_genre`),
  ADD CONSTRAINT `fk5` FOREIGN KEY (`sprak_fk`) REFERENCES `table_spark` (`id_sprak`),
  ADD CONSTRAINT `fk6` FOREIGN KEY (`status_fk`) REFERENCES `table_status` (`id_status`),
  ADD CONSTRAINT `fk7` FOREIGN KEY (`skapad_av_fk`) REFERENCES `table_users` (`u_id`),
  ADD CONSTRAINT `fk8` FOREIGN KEY (`forlag_fk`) REFERENCES `table_forlag` (`id_forlag`),
  ADD CONSTRAINT `fk9` FOREIGN KEY (`forlag_fk`) REFERENCES `table_forlag` (`id_forlag`);

--
-- Constraints for table `table_users`
--
ALTER TABLE `table_users`
  ADD CONSTRAINT `fk34` FOREIGN KEY (`u_role_fk`) REFERENCES `table_roles` (`r_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
