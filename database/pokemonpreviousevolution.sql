-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 20 nov. 2023 à 11:16
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `pokedex`
--

-- --------------------------------------------------------

--
-- Structure de la table `pokemonpreviousevolution`
--

DROP TABLE IF EXISTS `pokemonpreviousevolution`;
CREATE TABLE IF NOT EXISTS `pokemonpreviousevolution` (
  `pokPreviousID` int NOT NULL AUTO_INCREMENT,
  `pokemonID` int NOT NULL,
  `previousEvolutionID` int NOT NULL,
  `level` int NOT NULL,
  PRIMARY KEY (`pokPreviousID`),
  KEY `fk_pokemonPreviousEvolution_pokemonID` (`pokemonID`),
  KEY `fk_pokemonPreviousEvolution_previousEvolutionID` (`previousEvolutionID`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `pokemonpreviousevolution`
--

INSERT INTO `pokemonpreviousevolution` (`pokPreviousID`, `pokemonID`, `previousEvolutionID`, `level`) VALUES
(1, 2, 1, 1),
(2, 3, 1, 2),
(3, 3, 2, 1),
(4, 5, 4, 1),
(5, 6, 4, 2),
(6, 6, 5, 1),
(7, 8, 7, 1),
(8, 9, 7, 2),
(9, 9, 8, 1),
(10, 11, 10, 1),
(11, 12, 10, 2),
(12, 12, 11, 1),
(14, 14, 13, 1),
(15, 15, 13, 2),
(16, 15, 14, 1),
(17, 17, 16, 1),
(18, 18, 16, 2),
(19, 18, 17, 1),
(20, 20, 19, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
