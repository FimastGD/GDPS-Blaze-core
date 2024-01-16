-- Adminer 4.8.1 MySQL 5.5.5-10.5.22-MariaDB-1:10.5.22+maria~ubu1804 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `acccomments`;
CREATE TABLE `acccomments` (
  `userID` int(11) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `comment` longtext NOT NULL,
  `secret` varchar(10) NOT NULL DEFAULT 'unused',
  `commentID` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` int(11) NOT NULL,
  `likes` int(11) NOT NULL DEFAULT 0,
  `isSpam` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`commentID`),
  KEY `userID` (`userID`),
  KEY `timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `accounts`;
CREATE TABLE `accounts` (
  `userName` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gjp2` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `accountID` int(11) NOT NULL AUTO_INCREMENT,
  `isAdmin` int(11) NOT NULL DEFAULT 0,
  `mS` int(11) NOT NULL DEFAULT 0,
  `frS` int(11) NOT NULL DEFAULT 0,
  `cS` int(11) NOT NULL DEFAULT 0,
  `youtubeurl` varchar(255) NOT NULL DEFAULT '',
  `twitter` varchar(255) NOT NULL DEFAULT '',
  `twitch` varchar(255) NOT NULL DEFAULT '',
  `salt` varchar(255) NOT NULL DEFAULT '',
  `registerDate` int(11) NOT NULL DEFAULT 0,
  `friendsCount` int(11) NOT NULL DEFAULT 0,
  `discordID` bigint(20) NOT NULL DEFAULT 0,
  `discordLinkReq` bigint(20) NOT NULL DEFAULT 0,
  `isActive` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`accountID`),
  UNIQUE KEY `userName` (`userName`),
  KEY `isAdmin` (`isAdmin`),
  KEY `frS` (`frS`),
  KEY `discordID` (`discordID`),
  KEY `discordLinkReq` (`discordLinkReq`),
  KEY `friendsCount` (`friendsCount`),
  KEY `isActive` (`isActive`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


SET NAMES utf8mb4;

DROP TABLE IF EXISTS `accpanel`;
CREATE TABLE `accpanel` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(255) NOT NULL COMMENT 'Никнейм в панели',
  `Password` varchar(255) NOT NULL COMMENT 'Пароль в панели ',
  `isMOD` int(11) NOT NULL DEFAULT 0 COMMENT '0 - обычная панель 1 - Elder Moderator-панель, 2 - Owner-панель',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `accpanel` (`ID`, `Username`, `Password`, `isMOD`) VALUES
(1,	'Fimtest01',	'd41d8cd98f00b204e9800998ecf8427e',	0);

DROP TABLE IF EXISTS `actions`;
CREATE TABLE `actions` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT 0,
  `value` varchar(255) NOT NULL DEFAULT '0',
  `timestamp` int(11) NOT NULL DEFAULT 0,
  `value2` varchar(255) NOT NULL DEFAULT '0',
  `value3` int(11) NOT NULL DEFAULT 0,
  `value4` int(11) NOT NULL DEFAULT 0,
  `value5` int(11) NOT NULL DEFAULT 0,
  `value6` int(11) NOT NULL DEFAULT 0,
  `account` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ID`),
  KEY `type` (`type`),
  KEY `value` (`value`),
  KEY `value2` (`value2`),
  KEY `timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `actions_downloads`;
CREATE TABLE `actions_downloads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `levelID` int(11) NOT NULL,
  `ip` varbinary(16) NOT NULL,
  `uploadDate` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `levelID` (`levelID`,`ip`,`uploadDate`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `actions_downloads` (`id`, `levelID`, `ip`, `uploadDate`) VALUES
(1,	1,	UNHEX('B29F7D9B'),	'2023-01-22 11:54:11');

DROP TABLE IF EXISTS `actions_likes`;
CREATE TABLE `actions_likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemID` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `isLike` tinyint(4) NOT NULL,
  `ip` varbinary(16) NOT NULL,
  `uploadDate` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `levelID` (`itemID`,`type`,`isLike`,`ip`,`uploadDate`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `actions_likes` (`id`, `itemID`, `type`, `isLike`, `ip`, `uploadDate`) VALUES
(1,	1,	1,	1,	UNHEX('B29F7D9B'),	'2023-01-22 11:54:13');

DROP TABLE IF EXISTS `bannedips`;
CREATE TABLE `bannedips` (
  `IP` varchar(255) NOT NULL DEFAULT '127.0.0.1',
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `blocks`;
CREATE TABLE `blocks` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `person1` int(11) NOT NULL,
  `person2` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`),
  KEY `person1` (`person1`),
  KEY `person2` (`person2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `userID` int(11) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `comment` longtext NOT NULL,
  `secret` varchar(10) NOT NULL DEFAULT 'none',
  `levelID` int(11) NOT NULL,
  `commentID` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` int(11) NOT NULL,
  `likes` int(11) NOT NULL DEFAULT 0,
  `percent` int(11) NOT NULL DEFAULT 0,
  `isSpam` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`commentID`),
  KEY `levelID` (`levelID`),
  KEY `userID` (`userID`),
  KEY `likes` (`likes`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `cpshares`;
CREATE TABLE `cpshares` (
  `shareID` int(11) NOT NULL AUTO_INCREMENT,
  `levelID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  PRIMARY KEY (`shareID`),
  KEY `levelID` (`levelID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `dailyfeatures`;
CREATE TABLE `dailyfeatures` (
  `feaID` int(11) NOT NULL AUTO_INCREMENT,
  `levelID` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `type` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`feaID`),
  KEY `type` (`type`),
  KEY `timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `friendreqs`;
CREATE TABLE `friendreqs` (
  `accountID` int(11) NOT NULL,
  `toAccountID` int(11) NOT NULL,
  `comment` varchar(1000) NOT NULL,
  `uploadDate` int(11) NOT NULL,
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `isNew` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`ID`),
  KEY `toAccountID` (`toAccountID`),
  KEY `accountID` (`accountID`),
  KEY `uploadDate` (`uploadDate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `friendships`;
CREATE TABLE `friendships` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `person1` int(11) NOT NULL,
  `person2` int(11) NOT NULL,
  `isNew1` int(11) NOT NULL,
  `isNew2` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `person1` (`person1`),
  KEY `person2` (`person2`),
  KEY `isNew1` (`isNew1`),
  KEY `isNew2` (`isNew2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `gauntlets`;
CREATE TABLE `gauntlets` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `level1` int(11) NOT NULL,
  `level2` int(11) NOT NULL,
  `level3` int(11) NOT NULL,
  `level4` int(11) NOT NULL,
  `level5` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `level5` (`level5`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `levels`;
CREATE TABLE `levels` (
  `gameVersion` int(11) NOT NULL,
  `binaryVersion` int(11) NOT NULL DEFAULT 0,
  `userName` mediumtext NOT NULL,
  `levelID` int(11) NOT NULL AUTO_INCREMENT,
  `levelName` varchar(255) NOT NULL,
  `levelDesc` mediumtext NOT NULL,
  `levelVersion` int(11) NOT NULL,
  `levelLength` int(11) NOT NULL DEFAULT 0,
  `audioTrack` int(11) NOT NULL,
  `auto` int(11) NOT NULL,
  `password` int(11) NOT NULL,
  `original` int(11) NOT NULL,
  `twoPlayer` int(11) NOT NULL DEFAULT 0,
  `songID` int(11) NOT NULL DEFAULT 0,
  `objects` int(11) NOT NULL DEFAULT 0,
  `coins` int(11) NOT NULL DEFAULT 0,
  `requestedStars` int(11) NOT NULL DEFAULT 0,
  `extraString` mediumtext NOT NULL,
  `levelString` longtext DEFAULT NULL,
  `levelInfo` mediumtext NOT NULL,
  `secret` mediumtext NOT NULL,
  `starDifficulty` int(11) NOT NULL DEFAULT 0 COMMENT '0=N/A 10=EASY 20=NORMAL 30=HARD 40=HARDER 50=INSANE 50=AUTO 50=DEMON',
  `downloads` int(11) NOT NULL DEFAULT 0,
  `likes` int(11) NOT NULL DEFAULT 0,
  `starDemon` int(1) NOT NULL DEFAULT 0,
  `starAuto` tinyint(4) NOT NULL DEFAULT 0,
  `starStars` int(11) NOT NULL DEFAULT 0,
  `uploadDate` bigint(20) NOT NULL,
  `updateDate` bigint(20) NOT NULL,
  `rateDate` bigint(20) NOT NULL DEFAULT 0,
  `starCoins` int(11) NOT NULL DEFAULT 0,
  `starFeatured` int(11) NOT NULL DEFAULT 0,
  `starHall` int(11) NOT NULL DEFAULT 0,
  `starEpic` int(11) NOT NULL DEFAULT 0,
  `starDemonDiff` int(11) NOT NULL DEFAULT 0,
  `userID` int(11) NOT NULL,
  `extID` varchar(255) NOT NULL,
  `unlisted` int(11) NOT NULL,
  `originalReup` int(11) NOT NULL DEFAULT 0 COMMENT 'used for levelReupload.php',
  `hostname` varchar(255) NOT NULL,
  `isCPShared` int(11) NOT NULL DEFAULT 0,
  `isDeleted` int(11) NOT NULL DEFAULT 0,
  `isLDM` int(11) NOT NULL DEFAULT 0,
  `unlisted2` int(11) NOT NULL DEFAULT 0,
  `wt` int(11) NOT NULL DEFAULT 0,
  `wt2` int(11) NOT NULL DEFAULT 0,
  `settingsString` mediumtext NOT NULL,
  PRIMARY KEY (`levelID`),
  KEY `levelID` (`levelID`),
  KEY `levelName` (`levelName`),
  KEY `starDifficulty` (`starDifficulty`),
  KEY `starFeatured` (`starFeatured`),
  KEY `starEpic` (`starEpic`),
  KEY `starDemonDiff` (`starDemonDiff`),
  KEY `userID` (`userID`),
  KEY `likes` (`likes`),
  KEY `downloads` (`downloads`),
  KEY `starStars` (`starStars`),
  KEY `songID` (`songID`),
  KEY `audioTrack` (`audioTrack`),
  KEY `levelLength` (`levelLength`),
  KEY `twoPlayer` (`twoPlayer`),
  KEY `starDemon` (`starDemon`),
  KEY `starAuto` (`starAuto`),
  KEY `extID` (`extID`),
  KEY `uploadDate` (`uploadDate`),
  KEY `updateDate` (`updateDate`),
  KEY `starCoins` (`starCoins`),
  KEY `coins` (`coins`),
  KEY `password` (`password`),
  KEY `originalReup` (`originalReup`),
  KEY `original` (`original`),
  KEY `unlisted` (`unlisted`),
  KEY `isCPShared` (`isCPShared`),
  KEY `gameVersion` (`gameVersion`),
  KEY `rateDate` (`rateDate`),
  KEY `objects` (`objects`),
  KEY `unlisted2` (`unlisted2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `levelscores`;
CREATE TABLE `levelscores` (
  `scoreID` int(11) NOT NULL AUTO_INCREMENT,
  `accountID` int(11) NOT NULL,
  `levelID` int(11) NOT NULL,
  `percent` int(11) NOT NULL,
  `uploadDate` int(11) NOT NULL,
  `attempts` int(11) NOT NULL DEFAULT 0,
  `coins` int(11) NOT NULL DEFAULT 0,
  `clicks` int(11) NOT NULL DEFAULT 0,
  `time` int(11) NOT NULL DEFAULT 0,
  `progresses` text NOT NULL,
  `dailyID` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`scoreID`),
  KEY `levelID` (`levelID`),
  KEY `accountID` (`accountID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `links`;
CREATE TABLE `links` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `accountID` int(11) NOT NULL,
  `targetAccountID` int(11) NOT NULL,
  `server` varchar(255) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `targetUserID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `targetUserID` (`targetUserID`),
  KEY `targetAccountID` (`targetAccountID`),
  KEY `server` (`server`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `mappacks`;
CREATE TABLE `mappacks` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `levels` varchar(512) NOT NULL COMMENT 'entered as "ID of level 1, ID of level 2, ID of level 3" for example "13,14,15" (without the "s)',
  `stars` int(11) NOT NULL,
  `coins` int(11) NOT NULL,
  `difficulty` int(11) NOT NULL,
  `rgbcolors` varchar(11) NOT NULL COMMENT 'entered as R,G,B',
  `colors2` varchar(11) NOT NULL DEFAULT 'none',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `userID` int(11) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `body` longtext NOT NULL,
  `subject` longtext NOT NULL,
  `accID` int(11) NOT NULL,
  `messageID` int(11) NOT NULL AUTO_INCREMENT,
  `toAccountID` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `secret` varchar(25) NOT NULL DEFAULT 'unused',
  `isNew` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`messageID`),
  KEY `toAccountID` (`toAccountID`),
  KEY `accID` (`accID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `modactions`;
CREATE TABLE `modactions` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT 0,
  `value` varchar(255) NOT NULL DEFAULT '0',
  `timestamp` int(11) NOT NULL DEFAULT 0,
  `value2` varchar(255) NOT NULL DEFAULT '0',
  `value3` int(11) NOT NULL DEFAULT 0,
  `value4` varchar(255) NOT NULL DEFAULT '0',
  `value5` int(11) NOT NULL DEFAULT 0,
  `value6` int(11) NOT NULL DEFAULT 0,
  `account` int(11) NOT NULL DEFAULT 0,
  `value7` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `account` (`account`),
  KEY `type` (`type`),
  KEY `value3` (`value3`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `modactions` (`ID`, `type`, `value`, `timestamp`, `value2`, `value3`, `value4`, `value5`, `value6`, `account`, `value7`) VALUES
(1,	25,	'1',	1699640078,	'1',	3,	'err1',	0,	0,	8283,	'0');

DROP TABLE IF EXISTS `modipperms`;
CREATE TABLE `modipperms` (
  `categoryID` int(11) NOT NULL AUTO_INCREMENT,
  `actionFreeCopy` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`categoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `modips`;
CREATE TABLE `modips` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `IP` varchar(69) NOT NULL,
  `isMod` int(11) NOT NULL,
  `accountID` int(11) NOT NULL,
  `modipCategory` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `accountID` (`accountID`),
  KEY `IP` (`IP`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `modips` (`ID`, `IP`, `isMod`, `accountID`, `modipCategory`) VALUES
(1,	'178.159.125.52',	1,	5,	1),
(2,	'178.159.125.11',	1,	6,	1);

DROP TABLE IF EXISTS `quests`;
CREATE TABLE `quests` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `reward` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `reports`;
CREATE TABLE `reports` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `levelID` int(11) NOT NULL,
  `hostname` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `levelID` (`levelID`),
  KEY `hostname` (`hostname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `roleassign`;
CREATE TABLE `roleassign` (
  `assignID` bigint(20) NOT NULL AUTO_INCREMENT,
  `roleID` bigint(20) NOT NULL,
  `accountID` bigint(20) NOT NULL,
  PRIMARY KEY (`assignID`),
  KEY `roleID` (`roleID`),
  KEY `accountID` (`accountID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `roleID` bigint(11) NOT NULL AUTO_INCREMENT,
  `priority` int(11) NOT NULL DEFAULT 0,
  `roleName` varchar(255) NOT NULL,
  `commandRate` int(11) NOT NULL DEFAULT 0,
  `commandFeature` int(11) NOT NULL DEFAULT 0,
  `commandEpic` int(11) NOT NULL DEFAULT 0,
  `commandUnepic` int(11) NOT NULL DEFAULT 0,
  `commandVerifycoins` int(11) NOT NULL DEFAULT 0,
  `commandDaily` int(11) NOT NULL DEFAULT 0,
  `commandWeekly` int(11) NOT NULL DEFAULT 0,
  `commandDelete` int(11) NOT NULL DEFAULT 0,
  `commandSetacc` int(11) NOT NULL DEFAULT 0,
  `commandRenameOwn` int(11) NOT NULL DEFAULT 1,
  `commandRenameAll` int(11) NOT NULL DEFAULT 0,
  `commandPassOwn` int(11) NOT NULL DEFAULT 1,
  `commandPassAll` int(11) NOT NULL DEFAULT 0,
  `commandDescriptionOwn` int(11) NOT NULL DEFAULT 1,
  `commandDescriptionAll` int(11) NOT NULL DEFAULT 0,
  `commandPublicOwn` int(11) NOT NULL DEFAULT 1,
  `commandPublicAll` int(11) NOT NULL DEFAULT 0,
  `commandUnlistOwn` int(11) NOT NULL DEFAULT 1,
  `commandUnlistAll` int(11) NOT NULL DEFAULT 0,
  `commandSharecpOwn` int(11) NOT NULL DEFAULT 1,
  `commandSharecpAll` int(11) NOT NULL DEFAULT 0,
  `commandSongOwn` int(11) NOT NULL DEFAULT 1,
  `commandSongAll` int(11) NOT NULL DEFAULT 0,
  `profilecommandDiscord` int(11) NOT NULL DEFAULT 1,
  `actionRateDemon` int(11) NOT NULL DEFAULT 0,
  `actionRateStars` int(11) NOT NULL DEFAULT 0,
  `actionRateDifficulty` int(11) NOT NULL DEFAULT 0,
  `actionRequestMod` int(11) NOT NULL DEFAULT 0,
  `actionSuggestRating` int(11) NOT NULL DEFAULT 0,
  `actionDeleteComment` int(11) NOT NULL DEFAULT 0,
  `toolLeaderboardsban` int(11) NOT NULL DEFAULT 0,
  `toolPackcreate` int(11) NOT NULL DEFAULT 0,
  `toolQuestsCreate` int(11) NOT NULL DEFAULT 0,
  `toolModactions` int(11) NOT NULL DEFAULT 0,
  `toolSuggestlist` int(11) NOT NULL DEFAULT 0,
  `dashboardModTools` int(11) NOT NULL DEFAULT 0,
  `modipCategory` int(11) NOT NULL DEFAULT 0,
  `isDefault` int(11) NOT NULL DEFAULT 0,
  `commentColor` varchar(11) NOT NULL DEFAULT '000,000,000',
  `modBadgeLevel` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`roleID`),
  KEY `priority` (`priority`),
  KEY `toolModactions` (`toolModactions`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `roles` (`roleID`, `priority`, `roleName`, `commandRate`, `commandFeature`, `commandEpic`, `commandUnepic`, `commandVerifycoins`, `commandDaily`, `commandWeekly`, `commandDelete`, `commandSetacc`, `commandRenameOwn`, `commandRenameAll`, `commandPassOwn`, `commandPassAll`, `commandDescriptionOwn`, `commandDescriptionAll`, `commandPublicOwn`, `commandPublicAll`, `commandUnlistOwn`, `commandUnlistAll`, `commandSharecpOwn`, `commandSharecpAll`, `commandSongOwn`, `commandSongAll`, `profilecommandDiscord`, `actionRateDemon`, `actionRateStars`, `actionRateDifficulty`, `actionRequestMod`, `actionSuggestRating`, `actionDeleteComment`, `toolLeaderboardsban`, `toolPackcreate`, `toolQuestsCreate`, `toolModactions`, `toolSuggestlist`, `dashboardModTools`, `modipCategory`, `isDefault`, `commentColor`, `modBadgeLevel`) VALUES
(1,	9999,	'Owner',	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	0,	1,	1,	1,	1,	1,	1,	1,	1,	0,	'255,165,0',	2),
(2,	200,	'Elder Moderator',	1,	1,	0,	0,	1,	0,	0,	0,	0,	1,	0,	1,	0,	1,	0,	1,	0,	1,	0,	1,	1,	1,	0,	1,	1,	1,	1,	1,	0,	1,	0,	0,	0,	1,	1,	1,	1,	0,	'10,253,253',	2),
(3,	100,	'Moderator',	0,	0,	0,	0,	0,	0,	0,	0,	0,	1,	0,	1,	0,	1,	0,	1,	0,	1,	0,	1,	0,	1,	0,	1,	0,	0,	1,	1,	1,	0,	0,	0,	0,	0,	0,	0,	0,	0,	'255,255,0',	1);

DROP TABLE IF EXISTS `songs`;
CREATE TABLE `songs` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `authorID` int(11) NOT NULL,
  `authorName` varchar(100) NOT NULL,
  `size` varchar(100) NOT NULL,
  `download` varchar(1337) NOT NULL,
  `hash` varchar(256) NOT NULL DEFAULT '',
  `isDisabled` int(11) NOT NULL DEFAULT 0,
  `levelsCount` int(11) NOT NULL DEFAULT 0,
  `reuploadTime` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ID`),
  KEY `name` (`name`),
  KEY `authorName` (`authorName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `songs` (`ID`, `name`, `authorID`, `authorName`, `size`, `download`, `hash`, `isDisabled`, `levelsCount`, `reuploadTime`) VALUES
(5000000,	'filler',	0,	'0',	'0',	'0',	'0',	0,	0,	0);

DROP TABLE IF EXISTS `suggest`;
CREATE TABLE `suggest` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `suggestBy` int(11) NOT NULL DEFAULT 0,
  `suggestLevelId` int(11) NOT NULL DEFAULT 0,
  `suggestDifficulty` int(11) NOT NULL DEFAULT 0 COMMENT '0 - NA 10 - Easy 20 - Normal 30 - Hard 40 - Harder 50 - Insane/Demon/Auto',
  `suggestStars` int(11) NOT NULL DEFAULT 0,
  `suggestFeatured` int(11) NOT NULL DEFAULT 0,
  `suggestAuto` int(11) NOT NULL DEFAULT 0,
  `suggestDemon` int(11) NOT NULL DEFAULT 0,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `timestamp` (`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `isRegistered` int(11) NOT NULL,
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `extID` varchar(100) NOT NULL,
  `userName` varchar(69) NOT NULL DEFAULT 'undefined',
  `stars` int(11) NOT NULL DEFAULT 0,
  `demons` int(11) NOT NULL DEFAULT 0,
  `icon` int(11) NOT NULL DEFAULT 0,
  `color1` int(11) NOT NULL DEFAULT 0,
  `color2` int(11) NOT NULL DEFAULT 3,
  `iconType` int(11) NOT NULL DEFAULT 0,
  `coins` int(11) NOT NULL DEFAULT 0,
  `userCoins` int(11) NOT NULL DEFAULT 0,
  `special` int(11) NOT NULL DEFAULT 0,
  `gameVersion` int(11) NOT NULL DEFAULT 0,
  `secret` varchar(69) NOT NULL DEFAULT 'none',
  `accIcon` int(11) NOT NULL DEFAULT 0,
  `accShip` int(11) NOT NULL DEFAULT 0,
  `accBall` int(11) NOT NULL DEFAULT 0,
  `accBird` int(11) NOT NULL DEFAULT 0,
  `accDart` int(11) NOT NULL DEFAULT 0,
  `accRobot` int(11) DEFAULT 0,
  `accGlow` int(11) NOT NULL DEFAULT 0,
  `creatorPoints` double NOT NULL DEFAULT 0,
  `IP` varchar(69) NOT NULL DEFAULT '127.0.0.1',
  `lastPlayed` int(11) NOT NULL DEFAULT 0,
  `diamonds` int(11) NOT NULL DEFAULT 0,
  `moons` int(11) NOT NULL DEFAULT 0,
  `orbs` int(11) NOT NULL DEFAULT 0,
  `completedLvls` int(11) NOT NULL DEFAULT 0,
  `accSpider` int(11) NOT NULL DEFAULT 0,
  `accExplosion` int(11) NOT NULL DEFAULT 0,
  `chest1time` int(11) NOT NULL DEFAULT 0,
  `chest2time` int(11) NOT NULL DEFAULT 0,
  `chest1count` int(11) NOT NULL DEFAULT 0,
  `chest2count` int(11) NOT NULL DEFAULT 0,
  `isBanned` int(11) NOT NULL DEFAULT 0,
  `isCreatorBanned` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`userID`),
  KEY `userID` (`userID`),
  KEY `userName` (`userName`),
  KEY `stars` (`stars`),
  KEY `demons` (`demons`),
  KEY `coins` (`coins`),
  KEY `userCoins` (`userCoins`),
  KEY `gameVersion` (`gameVersion`),
  KEY `creatorPoints` (`creatorPoints`),
  KEY `diamonds` (`diamonds`),
  KEY `orbs` (`orbs`),
  KEY `completedLvls` (`completedLvls`),
  KEY `isBanned` (`isBanned`),
  KEY `isCreatorBanned` (`isCreatorBanned`),
  KEY `extID` (`extID`),
  KEY `IP` (`IP`),
  KEY `isRegistered` (`isRegistered`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- 2023-11-17 12:45:11
