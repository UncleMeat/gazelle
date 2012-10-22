    
DROP TABLE IF EXISTS `review_options`;
DROP TABLE IF EXISTS `site_options`;
CREATE TABLE IF NOT EXISTS `site_options` (
  `ReviewHours` int(4) NOT NULL,
  `AutoDelete` tinyint(1) NOT NULL,
  `DeleteRecordsMins` int(8) NOT NULL,
  `KeepSpeed` bigint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `site_options`
--

INSERT IGNORE INTO `site_options` (`ReviewHours`, `AutoDelete`, `DeleteRecordsMins`, `KeepSpeed`) VALUES
(24, 0, 720, 1048576);


ALTER TABLE `users_watch_list` ADD `Comment` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `Time` ;

-- --------------------------------------------------------

--
-- Table structure for table `torrents_watch_list`
--

CREATE TABLE IF NOT EXISTS `torrents_watch_list` (
  `TorrentID` int(10) NOT NULL,
  `StaffID` int(10) NOT NULL,
  `Time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Comment` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`TorrentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- --------------------------------------------------------

--
-- Table structure for table `users_exclude_watchlist`
--

CREATE TABLE IF NOT EXISTS `users_exclude_watchlist` (
  `UserID` int(10) NOT NULL,
  `StaffID` int(10) NOT NULL,
  `Time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Comment` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



