-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 09 juin 2021 à 10:33
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projetinfo1`
--

-- --------------------------------------------------------

--
-- Structure de la table `evenements`
--

DROP TABLE IF EXISTS `evenements`;
CREATE TABLE IF NOT EXISTS `evenements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prix` varchar(10) NOT NULL,
  `dateDebut` datetime DEFAULT NULL,
  `lien_image` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `lieu` text NOT NULL,
  `dateFin` datetime DEFAULT NULL,
  `nombreParticipants` int(10) NOT NULL,
  `dateLimiteInscription` datetime DEFAULT NULL,
  `placesRestantes` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `evenements`
--

INSERT INTO `evenements` (`id`, `nom`, `prix`, `dateDebut`, `lien_image`, `description`, `lieu`, `dateFin`, `nombreParticipants`, `dateLimiteInscription`, `placesRestantes`) VALUES
(1, 'Uno nouvelle generation', '2', '2021-06-10 17:00:00', 'images/uno.jpeg', 'Nous organisons des parties de Uno sous forme de tournois par quatre. Celui-ci ce deroulera en 4 parties. Les regles seront celles de bases, avec l\'ajout de la volee et d\'une bonne pioche.', 'CY 201', '2021-06-10 19:45:00', 20, '2021-06-09 23:59:59', 19),
(2, 'Loup-garou', '5', '2021-06-08 17:00:00', 'images/loupGarou.jpeg', 'Tout le monde connait ce guessing incontournable qu\'est le loup-garou, venez vous amuser, tout les coups seront permis.', 'TG 201', '2021-06-08 19:30:00', 30, '2021-06-07 23:59:59', 27),
(3, 'Donjons et Dragons', '20', '2021-06-24 17:30:00', 'images/donjonDragon.jpg', 'Nous voulons vous faire decouvrir un univers unique du Role play plateau, un classique dans ce genre, Donjons et Dragons ont conquis bien des coeurs, a vous de le faire.', 'CT 201', '2021-06-24 19:45:00', 10, '2021-06-23 23:59:59', 10);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prix` int(10) NOT NULL,
  `stock` int(10) NOT NULL,
  `lien_image` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id`, `nom`, `prix`, `stock`, `lien_image`) VALUES
(1, 'Mug La Guilde', 10, 147, 'images/mugGuilde.jpg'),
(2, 'Tshirt La Guilde', 25, 67, 'images/tshirtGuilde.jpg'),
(3, 'Pull La Guilde', 45, 85, 'images/pullGuilde.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `produitvendu`
--

DROP TABLE IF EXISTS `produitvendu`;
CREATE TABLE IF NOT EXISTS `produitvendu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `idProduit` int(10) NOT NULL,
  `idUtilisateur` int(10) NOT NULL,
  `date_ajout` date NOT NULL,
  `montant` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idUtilisateurs` (`idUtilisateur`),
  KEY `idProduit` (`idProduit`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `produitvendu`
--

INSERT INTO `produitvendu` (`id`, `idProduit`, `idUtilisateur`, `date_ajout`, `montant`) VALUES
(8, 1, 6, '2021-06-06', 10),
(9, 1, 6, '2021-06-06', 10),
(10, 1, 6, '2021-06-06', 10),
(11, 2, 6, '2021-06-06', 25);

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idEvenements` int(10) NOT NULL,
  `idUtilisateur` int(11) NOT NULL,
  `date_ajout` date NOT NULL,
  `montant` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`id`, `idEvenements`, `idUtilisateur`, `date_ajout`, `montant`) VALUES
(1, 2, 6, '2021-06-06', 5),
(2, 2, 6, '2021-06-06', 5),
(3, 2, 6, '2021-06-06', 5),
(4, 2, 6, '2021-06-06', 5),
(5, 1, 6, '2021-06-07', 2);

-- --------------------------------------------------------

--
-- Structure de la table `typeutilisateurs`
--

DROP TABLE IF EXISTS `typeutilisateurs`;
CREATE TABLE IF NOT EXISTS `typeutilisateurs` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `typeutilisateurs`
--

INSERT INTO `typeutilisateurs` (`id`, `type`) VALUES
(1, 'admin'),
(2, 'membre');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `age` int(10) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `mdp` varchar(100) NOT NULL,
  `pseudo` varchar(100) NOT NULL,
  `idtypeUtilisateurs` int(10) NOT NULL DEFAULT '2',
  `adresse` varchar(100) DEFAULT NULL,
  `ville` varchar(100) DEFAULT NULL,
  `codePostale` int(10) DEFAULT NULL,
  `telephone` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mail` (`mail`),
  KEY `idtypeutilisateurs` (`idtypeUtilisateurs`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `prenom`, `age`, `mail`, `mdp`, `pseudo`, `idtypeUtilisateurs`, `adresse`, `ville`, `codePostale`, `telephone`) VALUES
(1, 'ap', 'mathéo', 20, 'test@gmail.com', 'test', 'test', 1, '16 RUE DE LA FORGE', 'ST LEU LA FORET', 95320, '0672291212'),
(6, 'apcher', 'matheo', 22, 'mat.apcher@gmail.com', '8cb2237d0679ca88db6464eac60da96345513964', 'Aki', 1, '00400', 'St Leu La ForÃªt', 95320, '07 82 16 71 47');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `produitvendu`
--
ALTER TABLE `produitvendu`
  ADD CONSTRAINT `idProduit` FOREIGN KEY (`idProduit`) REFERENCES `produit` (`id`),
  ADD CONSTRAINT `idUtilisateurs` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateurs` (`id`);

--
-- Contraintes pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD CONSTRAINT `idtypeutilisateurs` FOREIGN KEY (`idtypeUtilisateurs`) REFERENCES `typeutilisateurs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
