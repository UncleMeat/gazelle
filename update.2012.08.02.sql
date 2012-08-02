DROP TABLE `users_freeleeches` ;

CREATE TABLE IF NOT EXISTS `users_slots` (
  `UserID` int(11) NOT NULL,
  `TorrentID` int(11) NOT NULL,
  `FreeLeech` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `DoubleSeed` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`UserID`,`TorrentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
