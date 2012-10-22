    
-- --------------------------------------------------------

--
-- Table structure for table `users_watch_list`
--

CREATE TABLE IF NOT EXISTS `users_watch_list` (
  `UserID` int(10) NOT NULL,
  `StaffID` int(10) NOT NULL,
  `Time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `KeepTorrents` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
