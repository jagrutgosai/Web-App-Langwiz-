-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2021 at 05:58 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `langwiz`
--
CREATE DATABASE langwiz;
use langwiz;
-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `UserID` int(11) NOT NULL,
  `PasswordID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='For security';

-- --------------------------------------------------------

--
-- Table structure for table `badges`
--

CREATE TABLE `badges` (
  `BadgeID` int(11) NOT NULL COMMENT 'The number of the badge',
  `BadgeDesc` varchar(20) NOT NULL COMMENT 'Description of the Badge'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `connections`
--

CREATE TABLE `connections` (
  `UserFollowID` int(11) NOT NULL,
  `UserFollowedID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Eelations betwen accounts';

-- --------------------------------------------------------

--
-- Table structure for table `geolocalization`
--

CREATE TABLE `geolocalization` (
  `GeopositioningID` int(11) NOT NULL COMMENT 'GeopositioningID',
  `GeoLat` float NOT NULL COMMENT 'User latitude ',
  `GeoLong` float NOT NULL COMMENT 'User longitude'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Stores the Geopositioning from a user';

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `LangID` int(11) NOT NULL COMMENT 'Language ID',
  `LangName` varchar(30) NOT NULL COMMENT 'Language Name'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `languagespeak`
--

CREATE TABLE `languagespeak` (
  `LangID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Connects the users and languages';

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `LocationID` int(11) NOT NULL,
  `Country` varchar(35) NOT NULL,
  `State` varchar(35) DEFAULT NULL,
  `City` varchar(35) DEFAULT NULL,
  `GeopositioningID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Stores the locatization from users';

-- --------------------------------------------------------

--
-- Table structure for table `passwords`
--

CREATE TABLE `passwords` (
  `PasswordID` int(11) NOT NULL,
  `Password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='It Stores the passwords';

-- --------------------------------------------------------

--
-- Table structure for table `rewardtable`
--

CREATE TABLE `rewardtable` (
  `RewardID` int(11) NOT NULL,
  `BadgeID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='connects rewards and users';

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(30) NOT NULL COMMENT 'User name',
  `FName` varchar(50) NOT NULL COMMENT 'First Name',
  `LName` varchar(50) NOT NULL COMMENT 'Last Name',
  `Photo` varchar(255) DEFAULT NULL COMMENT 'Photo Path',
  `LocationID` int(11) NOT NULL COMMENT 'Location',
  `EmailAddress` varchar(62) NOT NULL COMMENT 'Email'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='StoresUserInfo';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`UserID`,`PasswordID`),
  ADD KEY `accounts_PassID_FK` (`PasswordID`);

--
-- Indexes for table `badges`
--
ALTER TABLE `badges`
  ADD PRIMARY KEY (`BadgeID`),
  ADD UNIQUE KEY `BadgeDesc` (`BadgeDesc`);

--
-- Indexes for table `connections`
--
ALTER TABLE `connections`
  ADD PRIMARY KEY (`UserFollowID`,`UserFollowedID`),
  ADD KEY `connections_UserFollowedID_FK` (`UserFollowedID`);

--
-- Indexes for table `geolocalization`
--
ALTER TABLE `geolocalization`
  ADD PRIMARY KEY (`GeopositioningID`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`LangID`),
  ADD UNIQUE KEY `LangName` (`LangName`);

--
-- Indexes for table `languagespeak`
--
ALTER TABLE `languagespeak`
  ADD PRIMARY KEY (`LangID`,`UserID`),
  ADD KEY `languagespeak_UserID_FK` (`UserID`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`LocationID`),
  ADD KEY `location_geolocalizationID_FK` (`GeopositioningID`);

--
-- Indexes for table `passwords`
--
ALTER TABLE `passwords`
  ADD PRIMARY KEY (`PasswordID`);

--
-- Indexes for table `rewardtable`
--
ALTER TABLE `rewardtable`
  ADD PRIMARY KEY (`RewardID`),
  ADD KEY `rewardTable_BadgeID_FK` (`BadgeID`),
  ADD KEY `rewardTable_UserID_FK` (`UserID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `EmailAddress` (`EmailAddress`),
  ADD KEY `users_LocationID_FK` (`LocationID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `badges`
--
ALTER TABLE `badges`
  MODIFY `BadgeID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'The number of the badge', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `LangID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Language ID';

--
-- AUTO_INCREMENT for table `passwords`
--
ALTER TABLE `passwords`
  MODIFY `PasswordID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_PassID_FK` FOREIGN KEY (`PasswordID`) REFERENCES `passwords` (`PasswordID`),
  ADD CONSTRAINT `accounts_UserID_FK` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `connections`
--
ALTER TABLE `connections`
  ADD CONSTRAINT `connections_UserFollowID_FK` FOREIGN KEY (`UserFollowID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `connections_UserFollowedID_FK` FOREIGN KEY (`UserFollowedID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `languagespeak`
--
ALTER TABLE `languagespeak`
  ADD CONSTRAINT `languagespeak_LangID_FK` FOREIGN KEY (`LangID`) REFERENCES `languages` (`LangID`),
  ADD CONSTRAINT `languagespeak_UserID_FK` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `location`
--
ALTER TABLE `location`
  ADD CONSTRAINT `location_geolocalizationID_FK` FOREIGN KEY (`GeopositioningID`) REFERENCES `geolocalization` (`GeopositioningID`);

--
-- Constraints for table `rewardtable`
--
ALTER TABLE `rewardtable`
  ADD CONSTRAINT `rewardTable_BadgeID_FK` FOREIGN KEY (`BadgeID`) REFERENCES `badges` (`BadgeID`),
  ADD CONSTRAINT `rewardTable_UserID_FK` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_LocationID_FK` FOREIGN KEY (`LocationID`) REFERENCES `location` (`LocationID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
