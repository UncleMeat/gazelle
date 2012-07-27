
UPDATE `categories` SET `tag` = 'gangbang' WHERE `id` =14;

CREATE TABLE IF NOT EXISTS `upload_templates` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `UserID` int(10) unsigned NOT NULL,
  `TimeAdded` date NOT NULL DEFAULT '0000-00-00',
  `Name` varchar(64) NOT NULL,
  `Public` enum('0','1') NOT NULL DEFAULT '0',
  `Title` varchar(255) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Body` mediumtext NOT NULL,
  `CategoryID` int(10) NOT NULL,
  `Taglist` text NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `UserID` (`UserID`),
  KEY `TimeAdded` (`TimeAdded`),
  KEY `Public` (`Public`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

