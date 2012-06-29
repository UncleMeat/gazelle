-- --------------------------------------------------------

--
-- Table structure for table `sm_results`
--

CREATE TABLE IF NOT EXISTS `sm_results` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `Spins` smallint(1) NOT NULL,
  `Won` int(11) NOT NULL,
  `Bet` mediumint(5) NOT NULL,
  `Result` varchar(12) CHARACTER SET utf8 NOT NULL,
  `Time` datetime NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `UserID` (`UserID`),
  KEY `Won` (`Won`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
