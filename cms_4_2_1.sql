-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 22 juil. 2024 à 06:50
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `cms 4.2.1`
--

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) NOT NULL,
  `datetime` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL,
  `aname` varchar(30) NOT NULL,
  `aheadline` varchar(30) NOT NULL,
  `abio` varchar(500) NOT NULL,
  `aimage` varchar(60) NOT NULL DEFAULT 'avatar.png',
  `addedby` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admins`
--

INSERT INTO `admins` (`id`, `datetime`, `username`, `password`, `aname`, `aheadline`, `abio`, `aimage`, `addedby`) VALUES
(2, 'July-18-2024 22:20:58', 'svdd', '1234', 'mhiri', 'ahmed', '2003', 'Capture d’écran (7).png', 'Jazeb'),
(3, 'July-18-2024 22:23:09', 'John', '1234', '', '', 'ezaazffzffze', 'Capture d’écran (7).png', 'Jazeb'),
(4, 'July-19-2024 15:04:37', 'jhjhj', '12345', 'jhhkj', '', '', '', 'qsvdvds'),
(6, 'July-21-2024 12:07:15', 'qfsqqq', 'qqqq', 'qsfqfqq', '', '', 'avatar.png', 'John');

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(10) NOT NULL,
  `title` varchar(50) NOT NULL,
  `author` varchar(50) NOT NULL,
  `datetime` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `title`, `author`, `datetime`) VALUES
(1, 'Technology', 'Jazeb', 'December-01-2018 21:05:43'),
(2, 'News', 'Jazeb', 'December-01-2018 21:06:45'),
(3, 'Fitness', 'Jazeb', 'December-01-2018 21:09:29'),
(4, 'Sports', 'Jazeb', 'December-01-2018 21:12:58'),
(11, 'Politics', 'qsvdvds', 'July-19-2024 14:46:32');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) NOT NULL,
  `datetime` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(60) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `approvedby` varchar(50) NOT NULL,
  `status` varchar(3) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `datetime`, `name`, `email`, `comment`, `approvedby`, `status`, `post_id`) VALUES
(6, 'January-10-2019 13:42:58', 'Jazeb Akram', 'kk@gmail.com', 'dadad', '', 'OFF', 14),
(7, 'January-11-2019 12:23:57', 'Lucifer', 'KK@gmail.com', 'Lorem ipsum dolor sit amet, consectetur adipision', '', 'OFF', 14),
(8, 'January-11-2019 12:24:34', 'Sultan', 'jjsANS.Ja@jj.com', 'Lorem ipsum dolor sit amet, consectetur adipisicin', '', 'OFF', 14),
(9, 'January-11-2018 12:25:28', 'Amin', 'mn@gmail.com', 'How to Test this user credibility, i cant think of...', '', 'OFF', 14),
(11, 'January-11-2019 12.27.28', 'Spider man', 'kk@gmail.com', 'Excepteur sint occaecat cupidatat non proident, su', '', 'OFF', 13),
(12, 'January-11-2019 12:35:22', 'Ranjni Kant', 'Rajni@HAHA.com', 'Lorem ipsum dolor sit amet, consectetur adipisicin...', '', 'OFF', 11),
(13, 'July-20-2024 20:06:25', 'dfvfgfs', 'dggd@jj.vom', 'dsgsdgdsfsfs', '', 'ON', 14),
(15, 'July-20-2024 20:47:51', 'VSFVSS', 'SDVS@SFS.VOM', 'SGSGSGRSRS', '', 'ON', 15),
(16, 'July-20-2024 20:53:10', 'qfqsfs', 'qfqs@jj.com', 'qsfqsf', 'Pending', 'OFF', 7);

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

CREATE TABLE `posts` (
  `id` int(10) NOT NULL,
  `datetime` varchar(50) NOT NULL,
  `title` varchar(300) NOT NULL,
  `category` varchar(50) NOT NULL,
  `author` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL,
  `post` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id`, `datetime`, `title`, `category`, `author`, `image`, `post`) VALUES
(3, '2019-01-06 00:33:14', 'This is a 3rd post on this blog', 'Sports', 'Jazeb', '1984824_4dc5_4.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing...'),
(5, '2019-01-06 00:33:56', 'This is a 5th post on this blog', 'Fitness', 'Jazeb', 'sqorangeb.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing...'),
(6, '2019-01-06 00:34:15', 'This is 6th post on this blog', 'Technology', 'Jazeb', 'HTML5.CSS3.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing...'),
(7, '2019-01-06 00:35:03', 'The New iPhone 2019', 'News', 'Jazeb', 'shutterstock_341707151.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing...'),
(8, '2019-01-06 00:35:22', 'The Laptop is History', 'Technology', 'Jazeb', 'unamed.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing...'),
(9, '2019-01-06 00:35:26', 'The Dining Days', 'Fitness', 'Jazeb', 'safe_image.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing...'),
(10, '2019-01-06 00:35:56', 'The Life of Insect', 'News', 'Jazeb', 'sqfconseptb.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing...'),
(11, 'July-15-2024 20:02:27', ',,:;,:;;:;jhhcjkjgnb ', '1', 'Jazeb', 'Capture d’écran (2).png', '                                Lorem ipsum dolor sit amet, consectetur adipiscing...                            '),
(12, 'July-15-2024 20:03:08', 'efgddsgd', '1', 'Jazeb', '', '                                                                Lorem ipsum dolor sit amet, consectetur adipiscing...                                                        '),
(13, 'July-15-2024 20:04:57', 'gmmagleg', '2', 'Jazeb', 'Capture d’écran (6).png', '                                Loreagagezm ipsum dolor sit amet, consectetur adipiscing...                            '),
(14, 'July-15-2024 20:05:21', 'agerega', '3', 'Jazeb', 'Capture d’écran (6).png', '                                Lorem ipsuaggam dolor sit amet, consectetur adipiscing...                            '),
(15, 'July-19-2024 17:49:25', 'sfsfsdsf', '3', 'qsvdvds', 'Capture d’écran (1).png', 'dsfssfdsf'),
(16, 'July-22-2024 09:49:16', 'sfsfsdsf', '1', 'svdd', 'Capture d’écran (6).png', 'hjkkjkl,');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Index pour la table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `Foreign_Relation` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
