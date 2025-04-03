-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 30, 2025 at 03:08 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `marché`
--

-- --------------------------------------------------------

--
-- Table structure for table `commercant`
--

CREATE TABLE `commercant` (
  `id_commercant` int NOT NULL,
  `nom_commercant` varchar(50) DEFAULT NULL,
  `prénom_commercant` varchar(50) DEFAULT NULL,
  `login_profil` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emplacement`
--

CREATE TABLE `emplacement` (
  `id_emplacement` int PRIMARY KEY,
  `longueur_emplacement` decimal(15,2) DEFAULT NULL,
  `largeur_emplacement` decimal(15,2) DEFAULT NULL,
  `taille_emplacement` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jours_marche`
--

CREATE TABLE `jours_marche` (
  `id_jours_marche` int NOT NULL AUTO_INCREMENT,
  `semaines_jours_marche` int DEFAULT NULL,
  `jours_marche` date DEFAULT NULL,
  PRIMARY KEY (`id_jours_marche`)  -- Clé primaire définie ici
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profil`
--

CREATE TABLE `profil` (
  `login_profil` varchar(50) NOT NULL,
  `password_profil` varchar(255) DEFAULT NULL,  -- Modifié en VARCHAR(255)
  `typeprofil_profil` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `id_reservation` int NOT NULL,
  `id_commercant` int NOT NULL,
  `id_jours_marche` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `selectionner`
--

CREATE TABLE `selectionner` (
  `id_emplacement` int NOT NULL,
  `id_reservation` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `commercant`
--
ALTER TABLE `commercant`
  ADD PRIMARY KEY (`id_commercant`),
  ADD UNIQUE KEY `login_profil` (`login_profil`);

--
-- Indexes for table `emplacement`
--
--
-- Indexes for table `jours_marche`
--
-- Supprimez cette ligne car la clé primaire est déjà définie dans la déclaration de la table
-- ALTER TABLE `jours_marche`
--   ADD PRIMARY KEY (`id_jours_marche`);

--
-- Indexes for table `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`login_profil`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id_reservation`),
  ADD KEY `id_commercant` (`id_commercant`),
  ADD KEY `id_jours_marche` (`id_jours_marche`);

--
-- Indexes for table `selectionner`
--
ALTER TABLE `selectionner`
  ADD PRIMARY KEY (`id_emplacement`,`id_reservation`),
  ADD KEY `id_reservation` (`id_reservation`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `commercant`
--
ALTER TABLE `commercant`
  ADD CONSTRAINT `commercant_ibfk_1` FOREIGN KEY (`login_profil`) REFERENCES `profil` (`login_profil`);

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`id_commercant`) REFERENCES `commercant` (`id_commercant`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`id_jours_marche`) REFERENCES `jours_marche` (`id_jours_marche`);

--
-- Constraints for table `selectionner`
--
ALTER TABLE `selectionner`
  ADD CONSTRAINT `selectionner_ibfk_1` FOREIGN KEY (`id_emplacement`) REFERENCES `emplacement` (`id_emplacement`),
  ADD CONSTRAINT `selectionner_ibfk_2` FOREIGN KEY (`id_reservation`) REFERENCES `reservation` (`id_reservation`);

--
-- Modifier la colonne password_profil pour stocker les mots de passe hachés
--
ALTER TABLE `profil` MODIFY `password_profil` VARCHAR(255);  -- Ajout de la commande ALTER TABLE

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;