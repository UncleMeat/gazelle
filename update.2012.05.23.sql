


-- --------------------------------------------------------

--
-- Table structure for table `torrents_reviews`
--

CREATE TABLE IF NOT EXISTS `torrents_reviews` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `GroupID` int(10) NOT NULL,
  `Time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ReasonID` int(10) NOT NULL,
  `UserID` int(10) NOT NULL,
  `ConvID` int(10) DEFAULT NULL,
  `Status` enum('None','Okay','Warned','Pending') NOT NULL DEFAULT 'None',
  `Reason` varchar(255) DEFAULT NULL,
  `KillTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `GroupID` (`GroupID`),
  KEY `Time` (`Time`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



-- --------------------------------------------------------

--
-- Table structure for table `review_reasons`
--

CREATE TABLE IF NOT EXISTS `review_reasons` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `Sort` int(5) NOT NULL DEFAULT '0',
  `Name` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Sort` (`Sort`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `review_reasons`
--

INSERT IGNORE INTO `review_reasons` (`Sort`, `Name`, `Description`) VALUES
(2, 'Screenshots', 'Not enough screenshots.'),
(4, 'Description', 'Lack of text description.'),
(8, 'Screenshots & Description', 'Not enough screenshots, lack of text description.');


