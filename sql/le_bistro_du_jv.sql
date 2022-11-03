-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 10 jan. 2022 à 13:52
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `le_bistro_du_jv`
--

-- --------------------------------------------------------

--
-- Structure de la table `a_venir`
--

DROP TABLE IF EXISTS `a_venir`;
CREATE TABLE IF NOT EXISTS `a_venir` (
  `jeu` varchar(255) NOT NULL,
  `console` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `stock_prevu` int(11) NOT NULL,
  `sortie` varchar(255) NOT NULL,
  PRIMARY KEY (`jeu`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `a_venir`
--

INSERT INTO `a_venir` (`jeu`, `console`, `genre`, `description`, `stock_prevu`, `sortie`) VALUES
('Resident_Evil_Village_(PlayStation_4)', 'PlayStation 4', 'Horreur', 'Resident Evil Village est un survival-horror. Se déroulant quelques années après Resident Evil 7 Biohazard, il met en scène Ethan Winters, sa femme Mia et Chris Redfield, le héros légendaire de la série Resident Evil. L\'action est en vue à la première personne et le joueur incarne un Ethan désemparé et brisé qui se retrouve confronté à des monstruosités dans un village.', 5, '13-01-2022');

-- --------------------------------------------------------

--
-- Structure de la table `classiques`
--

DROP TABLE IF EXISTS `classiques`;
CREATE TABLE IF NOT EXISTS `classiques` (
  `jeu` varchar(255) NOT NULL,
  PRIMARY KEY (`jeu`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `classiques`
--

INSERT INTO `classiques` (`jeu`) VALUES
('GTA_V_(Xbox_One)'),
('Mario_Kart_8_Deluxe_(Nintendo_Switch)'),
('Rayman_Legends_(Xbox_One)');

-- --------------------------------------------------------

--
-- Structure de la table `jeux`
--

DROP TABLE IF EXISTS `jeux`;
CREATE TABLE IF NOT EXISTS `jeux` (
  `jeu` varchar(255) NOT NULL,
  `console` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `stock` int(11) NOT NULL,
  PRIMARY KEY (`jeu`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `jeux`
--

INSERT INTO `jeux` (`jeu`, `console`, `genre`, `description`, `stock`) VALUES
('Rayman_Legends_(Xbox_One)', 'Xbox One', 'Plates-formes', 'Jeu de plates-formes de la célèbre série française, Rayman Legends permet au joueur de partir à la recherche des Ptizêtres dans divers environnements. On retrouve le fameux Rayman, mais aussi d\'autres personnages jouables à débloquer ainsi qu\'un mode trois joueurs. Il est également possible d’interagir avec le décor.', 0),
('Rayman_Legends_Definitive_Edition_(Nintendo_Switch)', 'Nintendo Switch', 'Plates-formes', 'Jeu de plates-formes de la célèbre série française, Rayman Legends permet au joueur de partir à la recherche des Ptizêtres dans divers environnements. On retrouve le fameux Rayman, mais aussi d\'autres personnages jouables à débloquer ainsi qu\'un mode trois joueurs. Il est également possible d’interagir avec le décor.', 0),
('Pokémon_Diamant_Etincelant_(Nintendo_Switch)', 'Nintendo Switch', 'Aventure', 'Pokémon Diamant Étincelant / Perle Scintillante est un remake de Pokémon Version Diamant / Perle sorti sur Nintendo DS. Avec un nouveau style graphique plutôt enfantin, les joueurs peuvent découvrir ou redécouvrir la région de Sinnoh et retrouver les Pokémons de la quatrième génération.', 5),
('Pokémon_Perle_Scintillante_(Nintendo_Switch)', 'Nintendo Switch', 'Aventure', 'Pokémon Diamant Étincelant / Perle Scintillante est un remake de Pokémon Version Diamant / Perle sorti sur Nintendo DS. Avec un nouveau style graphique plutôt enfantin, les joueurs peuvent découvrir ou redécouvrir la région de Sinnoh et retrouver les Pokémons de la quatrième génération.', 5),
('Mario_Kart_8_Deluxe_(Nintendo_Switch)', 'Nintendo Switch', 'Course', 'Mario Kart 8 sur Switch est un jeu de course coloré et délirant qui reprend les personnages phares des grandes licences Nintendo. Le joueur peut y affronter ses amis dans différents modes et types de coupes et a accès à 32 circuits aux environnements variés. Il est possible de jouer jusqu\'à 12 simultanément en ligne et 4 en local.', 5),
('The_Legend_of_Zelda_Breath_of_the_Wild_(Nintendo_Switch)', 'Nintendo Switch', 'Aventure', 'The Legend of Zelda : Breath of the Wild est un jeu d\'action/aventure. Link se réveille d\'un sommeil de 100 ans dans un royaume d\'Hyrule dévasté. Il lui faudra percer les mystères du passé et vaincre Ganon, le fléau. L\'aventure prend place dans un gigantesque monde ouvert et accorde ainsi une part importante à l\'exploration. Le titre a été pensé pour que le joueur puisse aller où il veut dès le début, s\'éloignant de la linéarité habituelle de la série.', 6),
('FIFA_22_(PlayStation_4)', 'PlayStation 4', 'Simulation', 'FIFA 22 est une simulation de football éditée par Electronic Arts. Comme chaque saison, le jeu offre son lot d\'améliorations techniques pour toujours plus de réalisme ainsi que des animations et des comportements toujours plus poussés. Les modes carrière et Ultimate Team disposent également de nouveaux ajouts.', 5),
('FIFA_22_(Xbox_One)', 'Xbox One', 'Simulation', 'FIFA 22 est une simulation de football éditée par Electronic Arts. Comme chaque saison, le jeu offre son lot d\'améliorations techniques pour toujours plus de réalisme ainsi que des animations et des comportements toujours plus poussés. Les modes carrière et Ultimate Team disposent également de nouveaux ajouts.', 4),
('Halo_Infinite_(Xbox_One)', 'Xbox One', 'Tir à la première personne', 'Halo Infinite est un FPS développé par 343 Industries. L\'épisode fait la suite directe de Halo 5. On suit les aventures de Master Chief, qui est récupéré dans l\'espace par un personnage, avant de découvrir le Halo détruit.', 2),
('Call_of_Duty_Vanguard_(PlayStation_4)', 'PlayStation 4', 'Tir à la première personne', 'Call of Duty : Vanguard est le dernier ajout de la célèbre licence de jeux de tirs, Call of Duty. Celui-ci nous plonge au coeur des affrontements de la Seconde Guerre mondiale, et particulièrement ceux ayant lieu en Europe et dans le Pacifique.', 5),
('Call_Of_Duty_Vanguard_(Xbox_One)', 'Xbox One', 'Tir à la première personne', 'Call of Duty : Vanguard est le dernier ajout de la célèbre licence de jeux de tirs, Call of Duty. Celui-ci nous plonge au coeur des affrontements de la Seconde Guerre mondiale, et particulièrement ceux ayant lieu en Europe et dans le Pacifique.', 3),
('Dragon_Ball_Xenoverse_2_(PlayStation_4)', 'PlayStation 4', 'Combat', 'Un an après le premier opus, Dragon Ball Xenoverse revient dans un nouveau jeu qui revendique l\'univers le plus détaillé de tous les jeux Dragon Ball. Le jeu reprend la recette du premier Dragon Ball Xenoverse avec des bases de MMORPG et le retour des policiers du temps qui doivent protéger l\'histoire.', 7),
('GTA_V_(Xbox_One)', 'Xbox One', 'Aventure', 'Jeu d\'action-aventure en monde ouvert, Grand Theft Auto (GTA) V vous place dans la peau de trois personnages inédits : Michael, Trevor et Franklin. Ces derniers ont élu domicile à Los Santos, ville de la région de San Andreas. Braquages et missions font partie du quotidien du joueur qui pourra également cohabiter avec 15 autres utilisateurs dans cet univers persistant s\'il joue sur PS3/Xbox 360 ou 29 s\'il joue sur PS4/Xbox One/PC.', 6),
('Animal_Crossing_New_Horizons_(Nintendo_Switch)', 'Nintendo Switch', 'Simulation', 'Animal Crossing : New Horizons vous emmène de nouveau dans le monde mignon d\'Animal Crossing, sur Nintendo Switch. Cultivez votre potager, pêchez, et faites votre vie avec vos compagnons en temps réel grâce à l\'horloge de la console.', 3),
('Super_Mario_Odyssey_(Nintendo_Switch)', 'Nintendo Switch', 'Aventure', 'Super Mario Odyssey est un jeu de plate-forme sur Switch où la princesse Peach a été enlevée par Bowser. Pour la sauver, Mario quitte le royaume Champignon à bord de l\'Odyssey. Accompagné de Chappy, son chapeau vivant, il doit parcourir différents royaumes et faire tout pour vaincre, une nouvelle fois, le terrible Bowser.', 5),
('Luigi\'s_Mansion_3_(Nintendo_Switch)', 'Nintendo Switch', 'Aventure', 'Luigi\'s Mansion 3 est la prochaine aventure du frère de Mario. Luigi doit une nouvelle fois affronter ses peurs les plus profondes dans un terrifiant manoir hanté. Il peut pour cela compter sur son aspirateur à fantômes pour l\'aider. Un nouveau personnage sera ajouté : Gluigi, un Luigi tout vert, possédant des capacités particulières. Le jeu sera jouable en coopération jusqu\'à 8 joueurs.', 4),
('Forza_Horizon_5_(Xbox_One)', 'Xbox One', 'Course', 'Forza Horizon 5 est un jeu de course en monde ouvert développé par Playground Games. Il prend place dans les villes et magnifiques décors du Mexique. Le jeu propose aussi bien des courses solo que des épreuves compétitives et collaboratives en ligne.', 3),
('Super_Mario_Party_(Nintendo_Switch)', 'Nintendo Switch', 'Simulation', 'Super Mario Party est la nouvelle itération du célèbre représentant des party-games. Ce dernier introduira l\'expérience entre amis que nous connaissons bien avec sa flopée de mini-jeux, mais également, un mode en ligne inédit. Il se composera de 5 épreuves consécutives, déterminant, à son issue, un vainqueur et permettant de grimper dans le classement des joueurs.', 5);

-- --------------------------------------------------------

--
-- Structure de la table `jeux_du_moment`
--

DROP TABLE IF EXISTS `jeux_du_moment`;
CREATE TABLE IF NOT EXISTS `jeux_du_moment` (
  `jeu` varchar(255) NOT NULL,
  PRIMARY KEY (`jeu`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `jeux_du_moment`
--

INSERT INTO `jeux_du_moment` (`jeu`) VALUES
('Animal_Crossing_New_Horizons_(Nintendo_Switch)'),
('FIFA_22_(PlayStation_4)'),
('Rayman_Legends_(Xbox_One)');

-- --------------------------------------------------------

--
-- Structure de la table `les_mieux_notes`
--

DROP TABLE IF EXISTS `les_mieux_notes`;
CREATE TABLE IF NOT EXISTS `les_mieux_notes` (
  `jeu` varchar(255) NOT NULL,
  PRIMARY KEY (`jeu`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `les_mieux_notes`
--

INSERT INTO `les_mieux_notes` (`jeu`) VALUES
('Animal_Crossing_New_Horizons_(Nintendo_Switch)'),
('GTA_V_(Xbox_One)'),
('Rayman_Legends_(Xbox_One)'),
('The_Legend_of_Zelda_Breath_of_the_Wild_(Nintendo_Switch)');

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

DROP TABLE IF EXISTS `membres`;
CREATE TABLE IF NOT EXISTS `membres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prenom` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `motdepasse` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `membres`
--

INSERT INTO `membres` (`id`, `prenom`, `nom`, `email`, `motdepasse`) VALUES
(1, 'Axel', 'Villeret', 'axel_villeret@orange.fr', '7d3a99ec566ff4237a9647d87c28a119da3775a5'),
(0, 'Maria', 'DB', 'maria.db@gmail.com', '3420fc629658aadb163bc30d231d3c37417d2466');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `numero` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `jeu` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `rendu` int(11) NOT NULL,
  PRIMARY KEY (`numero`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`numero`, `id`, `jeu`, `date`, `rendu`) VALUES
(14, 1, 'The_Legend_of_Zelda_Breath_of_the_Wild_(Nintendo_Switch)', '14-10-2020', 0),
(46, 1, 'Super_Mario_Party_(Nintendo_Switch)', '08-01-2022', 1),
(47, 1, 'Call_Of_Duty_Vanguard_(Xbox_One)', '08-01-2022', 1),
(48, 1, 'GTA_V_(Xbox_One)', '08-01-2022', 0),
(41, 1, 'The_Legend_of_Zelda_Breath_of_the_Wild_(Nintendo_Switch)', '01-01-2022', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
