-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 16 nov. 2023 à 13:01
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
-- Structure de la table `pokemontype`
--

DROP TABLE IF EXISTS `pokemontype`;
CREATE TABLE IF NOT EXISTS `pokemontype` (
  `pokeTypeID` int NOT NULL AUTO_INCREMENT,
  `pokemonID` int NOT NULL,
  `typeID` int NOT NULL,
  PRIMARY KEY (`pokeTypeID`),
  KEY `fk_pokemonType_pokemonID` (`pokemonID`),
  KEY `fk_pokemonType_typeID` (`typeID`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `pokemontype`
--

INSERT INTO `pokemontype` (`pokeTypeID`, `pokemonID`, `typeID`) VALUES
(1, 1, 4),
(2, 1, 8),
(3, 2, 4),
(4, 2, 8),
(5, 3, 4),
(6, 3, 8),
(7, 4, 2),
(8, 5, 2),
(9, 6, 2),
(10, 6, 15),
(11, 7, 3),
(12, 8, 3),
(13, 9, 3),
(14, 10, 12),
(15, 11, 12),
(16, 12, 12),
(17, 12, 10);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;