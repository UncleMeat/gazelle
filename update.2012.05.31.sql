 
-- --------------------------------------------------------

--
-- Table structure for table `tag_synomyns`
--

CREATE TABLE IF NOT EXISTS `tag_synomyns` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `Synomyn` varchar(100) NOT NULL,
  `TagID` int(10) NOT NULL,
  `UserID` int(10) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Synomyn` (`Synomyn`),
  KEY `TagID` (`TagID`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;




