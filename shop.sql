-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 01 oct. 2023 à 00:29
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `shop`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Ordering` int(11) DEFAULT NULL,
  `Visibility` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Comment` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `Ordering`, `Visibility`, `Allow_Comment`, `Allow_Ads`) VALUES
(4, 'Hand Made', 'Hand Made Items', 1, 0, 0, 0),
(5, 'Computers', 'Computers Items', 2, 0, 0, 0),
(6, 'Cell Phones', 'Cell Phones Items', 3, 0, 0, 0),
(7, 'Clothing', 'Clothing and Fashion', 4, 0, 0, 0),
(8, 'Tools', 'Home Tools', 5, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `C_ID` int(11) NOT NULL,
  `Comment` text NOT NULL,
  `Status` tinyint(4) NOT NULL,
  `Comment_Date` date NOT NULL DEFAULT current_timestamp(),
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`C_ID`, `Comment`, `Status`, `Comment_Date`, `item_id`, `user_id`) VALUES
(6, 'very nice', 0, '2023-09-16', 11, 68),
(9, 'good item Network cable', 0, '2023-09-24', 13, 67),
(10, 'good item! ', 0, '2023-09-24', 13, 63),
(11, 'good item Network cable', 1, '2023-09-24', 13, 65),
(12, 'Bad item... ', 1, '2023-09-24', 13, 64),
(13, 'good item ', 1, '2023-09-24', 14, 66),
(14, 'goooooood', 1, '2023-09-24', 14, 62),
(39, 'Yes this item is better.', 0, '2023-09-24', 14, 68);

-- --------------------------------------------------------

--
-- Structure de la table `items`
--

CREATE TABLE `items` (
  `Item_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Add_Date` date NOT NULL,
  `Country_Made` varchar(255) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Raiting` smallint(6) NOT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT 0,
  `Cat_ID` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `items`
--

INSERT INTO `items` (`Item_ID`, `Name`, `Description`, `Price`, `Add_Date`, `Country_Made`, `Image`, `Status`, `Raiting`, `Approve`, `Cat_ID`, `Member_ID`) VALUES
(10, 'Speakers', 'Speakers good', '500', '2023-09-11', 'Algérie', '88_speakers.jpeg', '2', 0, 1, 5, 64),
(11, 'Labtop Lenovo', 'Labtop Lenovo I7', '1500', '2023-09-11', 'China', '88_laptob.JPEG', '1', 0, 1, 5, 65),
(12, 'Mouse', 'Majic mouse', '50', '2023-09-11', 'Algérie', '88_mouse.JPEG', '1', 0, 1, 5, 63),
(13, 'Network Cable', 'RJ45 Ntwork Cable', '500', '2023-09-11', 'USA', '88_netcable.JPEG', '1', 0, 1, 5, 68),
(14, 'clavier', 'clavier wifi small', '55', '2023-09-22', 'Algérie', '88_clavier.JPEG', '2', 0, 1, 5, 68),
(15, 'DESK', 'DESK hande desck', '563', '2023-09-25', 'Algeria', '88_desk.JPEG', '3', 0, 1, 4, 62),
(16, 'Phone', 'Phone used', '558', '2023-09-25', 'China', '88_phone.JPEG', '3', 0, 1, 6, 65),
(17, 'Keys', 'Keys for table', '89', '2023-09-25', 'France', '88_keys.JPEG', '4', 0, 1, 8, 68),
(18, 'Cloth', 'Clothing is new item in island', '5896', '2023-09-25', 'Island', '88_cloth.JPEG', '1', 0, 0, 7, 68),
(19, 'Chaise', 'Chaise is used in your house.', '88', '2023-09-30', 'Algeria', '42573_chaise.jpg', '1', 0, 1, 8, 65);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL COMMENT 'user identification',
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Fullname` varchar(144) NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT 0 COMMENT 'user group',
  `TrustStatus` int(11) NOT NULL DEFAULT 0 COMMENT 'seller rank',
  `RegStatus` int(11) NOT NULL DEFAULT 0 COMMENT 'user approval',
  `Date` date DEFAULT current_timestamp(),
  `Avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `Fullname`, `GroupID`, `TrustStatus`, `RegStatus`, `Date`, `Avatar`) VALUES
(1, 'kamel', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'kamelmaaloul@gmail.com', 'kamel maaloul', 1, 0, 1, '2023-08-15', ''),
(61, 'mohamed ahmed', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'mmmm@mm.mm', 'mohamed mohamed39', 0, 0, 1, '2023-08-16', ''),
(62, 'razane', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'razane@gg.gg', 'razane maaloul', 0, 0, 1, '2023-08-18', ''),
(63, 'ilef', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'ilef@ii.ff', 'ilef maaloul', 0, 0, 1, '2023-08-19', ''),
(64, 'montaha', 'd435a6cdd786300dff204ee7c2ef942d3e9034e2', 'mon@mm.oo', 'montaha maaloul', 0, 0, 1, '2023-08-20', ''),
(65, 'Abderrahmae', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'abdou@gmail.com', 'Abderrahmane Maaloul', 0, 0, 1, '2023-08-31', '1_abdo.PNG'),
(66, 'hiba-errahmane', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'hiba@hh.hh', 'hiba Maaloul', 0, 0, 0, '2023-08-31', '11_hiba.PNG'),
(67, 'meriem', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'merm@mm.pp', 'Meriem mer', 0, 0, 1, '2023-08-31', '44_mer.PNG'),
(68, 'aliali', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'ali@gg.vv', 'ali  ali', 0, 0, 0, '2023-09-12', '55_ali.jpeg'),
(69, 'brahim', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'bnbn@oo.hj', 'Brahim brahim', 0, 0, 0, '2023-09-17', '55_brahim.jpeg'),
(76, 'person', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'person@gmail.com', 'person person', 0, 0, 1, '2023-09-30', '12905_person.jpg'),
(77, 'bubaker', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'boubaker@gmail.com', 'boubaker boubaker', 0, 0, 1, '2023-09-30', '34178_person.jpg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`C_ID`),
  ADD KEY `items_comment` (`item_id`),
  ADD KEY `users_comment` (`user_id`);

--
-- Index pour la table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`Item_ID`),
  ADD KEY `member_1` (`Member_ID`),
  ADD KEY `cat_1` (`Cat_ID`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `C_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT pour la table `items`
--
ALTER TABLE `items`
  MODIFY `Item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'user identification', AUTO_INCREMENT=78;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `items_comment` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_comment` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cat_1` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_1` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
