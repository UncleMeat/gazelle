

-- --------------------------------------------------------

--
-- Table structure for table `badges_auto`
--

CREATE TABLE IF NOT EXISTS `badges_auto` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `BadgeID` int(10) NOT NULL,
  `Action` enum('NumPosts','NumComments','NumUploaded','NumNewTags','NumTags','NumTagVotes','RequestsFilled','UploadedTB','DownloadedTB','MaxSnatches') NOT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '0',
  `SendPM` tinyint(1) NOT NULL DEFAULT '0',
  `Value` int(10) NOT NULL,
  `CategoryID` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `Action` (`Action`),
  KEY `Active` (`Active`),
  KEY `BadgeID` (`BadgeID`),
  KEY `SendPM` (`SendPM`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `badges_auto`
--

INSERT INTO `badges_auto` (`ID`, `BadgeID`, `Action`, `Active`, `SendPM`, `Value`, `CategoryID`) VALUES
(1, 12, 'NumPosts', 0, 0, 10, 0),
(2, 13, 'NumUploaded', 0, 0, 3, 30),
(3, 14, 'UploadedTB', 0, 0, 1, 0);

