-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Sam 28 Février 2015 à 18:40
-- Version du serveur: 5.6.12-log
-- Version de PHP: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `optiplace`
--
CREATE DATABASE IF NOT EXISTS `optiplace` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `optiplace`;

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

CREATE TABLE IF NOT EXISTS `etudiant` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `prenom` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `id_groupe` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `etudiant`
--

INSERT INTO `etudiant` (`ID`, `nom`, `prenom`, `id_groupe`) VALUES
(1, 'Azzoug', 'Erwan', 'Informatique-INFO 2 G1'),
(2, 'Gueron', 'Antoine', 'Informatique-INFO 2 G1');

-- --------------------------------------------------------

--
-- Structure de la table `groupe`
--

CREATE TABLE IF NOT EXISTS `groupe` (
  `nom` varchar(250) COLLATE utf8_bin NOT NULL,
  `departement` varchar(250) COLLATE utf8_bin NOT NULL,
  `id_pere` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `id` varchar(250) COLLATE utf8_bin NOT NULL COMMENT '<nom>-<departement>',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `groupe`
--

INSERT INTO `groupe` (`nom`, `departement`, `id_pere`, `id`) VALUES
('INFO 2 G1', 'Informatique', 'Informatique-INFO 2', 'Informatique-INFO 2 G1');

-- --------------------------------------------------------

--
-- Structure de la table `place`
--

CREATE TABLE IF NOT EXISTS `place` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key place',
  `id_salle` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'ID de la salle à laquelle il appartient',
  `numero` int(11) NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `level_attribution` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `place`
--

INSERT INTO `place` (`ID`, `id_salle`, `numero`, `x`, `y`, `level_attribution`) VALUES
(5, 'Joffre-F2/22', 1, 0, 0, -1),
(6, 'Joffre-F2/22', 2, 0, 1, 0),
(7, 'Joffre-F2/22', 3, 0, 2, 1),
(8, 'Joffre-F2/22', 4, 1, 0, 2),
(9, 'Joffre-F2/22', 5, 1, 1, -1),
(10, 'Joffre-F2/22', 6, 1, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

CREATE TABLE IF NOT EXISTS `salle` (
  `ID` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'numero et site',
  `numero` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `site` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `salle`
--

INSERT INTO `salle` (`ID`, `numero`, `site`) VALUES
('Joffre-F2/22', 'F2/22', 'Joffre');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
