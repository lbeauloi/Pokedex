-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 20 nov. 2023 à 11:17
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
-- Structure de la table `pokemonfutureevolution`
--

DROP TABLE IF EXISTS `pokemonfutureevolution`;
CREATE TABLE IF NOT EXISTS `pokemonfutureevolution` (
  `pokFuture` int NOT NULL AUTO_INCREMENT,
  `pokemonID` int NOT NULL,
  `futureEvolution` int NOT NULL,
  `level` int NOT NULL,
  PRIMARY KEY (`pokFuture`),
  KEY `fk_pokemonFutureEvolution_pokemonID` (`pokemonID`),
  KEY `fk_pokemonFutureEvolution_futureEvolution` (`futureEvolution`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `pokemonfutureevolution`
--

INSERT INTO `pokemonfutureevolution` (`pokFuture`, `pokemonID`, `futureEvolution`, `level`) VALUES
(1, 1, 2, 1),
(2, 1, 3, 2),
(3, 2, 3, 1),
(4, 4, 5, 1),
(5, 4, 6, 2),
(6, 5, 6, 1),
(7, 7, 8, 1),
(8, 7, 9, 2),
(9, 8, 9, 1),
(10, 10, 11, 1),
(11, 10, 12, 2),
(12, 11, 12, 1),
(13, 13, 14, 1),
(14, 13, 15, 2),
(15, 14, 15, 1),
(16, 16, 17, 1),
(17, 16, 18, 2),
(18, 17, 18, 1),
(19, 19, 20, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
