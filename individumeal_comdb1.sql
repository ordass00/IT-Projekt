-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Erstellungszeit: 12. Okt 2021 um 09:42
-- Server-Version: 10.4.18-MariaDB
-- PHP-Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `individumeal_comdb1`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ingredients`
--

CREATE TABLE `ingredients` (
  `ID` int(11) NOT NULL,
  `IngredientsAtHome` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `User_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `meals`
--

CREATE TABLE `meals` (
  `ID` int(11) NOT NULL,
  `MealID` int(11) NOT NULL,
  `MealType` varchar(164) NOT NULL,
  `Title` varchar(164) NOT NULL,
  `Image` varchar(164) NOT NULL,
  `UsedIngredients` varchar(1024) DEFAULT NULL,
  `MissedIngredients` varchar(1024) DEFAULT NULL,
  `User_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `preferences`
--

CREATE TABLE `preferences` (
  `ID` int(11) NOT NULL,
  `DietType` varchar(20) NOT NULL,
  `Intolerances` varchar(200) NOT NULL,
  `Calories` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `ID` int(11) NOT NULL,
  `FirstName` varchar(45) NOT NULL,
  `LastName` varchar(45) NOT NULL,
  `Username` varchar(45) NOT NULL,
  `Gender` varchar(16) NOT NULL,
  `Password` varchar(64) NOT NULL,
  `EMail` varchar(45) NOT NULL,
  `DateOfBirth` date NOT NULL,
  `PasswordReset` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `BreakfastNr` int(11) NOT NULL,
  `LunchNr` int(11) NOT NULL,
  `DinnerNr` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indizes für die Tabelle `meals`
--
ALTER TABLE `meals`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_meals_user1_idx` (`User_ID`);

--
-- Indizes für die Tabelle `preferences`
--
ALTER TABLE `preferences`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_Preferences_User_idx` (`User_ID`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `E-Mail` (`EMail`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT für Tabelle `meals`
--
ALTER TABLE `meals`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=925;

--
-- AUTO_INCREMENT für Tabelle `preferences`
--
ALTER TABLE `preferences`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `ingredients`
--
ALTER TABLE `ingredients`
  ADD CONSTRAINT `Ingredients_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `user` (`ID`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `meals`
--
ALTER TABLE `meals`
  ADD CONSTRAINT `fk_meals_user1` FOREIGN KEY (`User_ID`) REFERENCES `user` (`ID`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `preferences`
--
ALTER TABLE `preferences`
  ADD CONSTRAINT `fk_Preferences_User` FOREIGN KEY (`User_ID`) REFERENCES `user` (`ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
