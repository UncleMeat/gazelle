
-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(64) NOT NULL,
  `Comment` text NOT NULL,
  `Log` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE IF NOT EXISTS `users_groups` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `GroupID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `AddedTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `AddedBy` int(11) NOT NULL,
  `Comment` text NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `GroupID_2` (`GroupID`,`UserID`),
  KEY `GroupID` (`GroupID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


