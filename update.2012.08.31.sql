 

-- --------------------------------------------------------

--
-- Table structure for table `users_seedhours_history`
--

DROP TABLE IF EXISTS `users_seedhours_history`;
CREATE TABLE IF NOT EXISTS `users_seedhours_history` (
  `UserID` int(10) NOT NULL,
  `Time` date NOT NULL DEFAULT '0000-00-00',
  `TimeAdded` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `SeedHours` double(11,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`UserID`,`Time`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `users_main` ADD INDEX ( `SeedHours` ) ;
