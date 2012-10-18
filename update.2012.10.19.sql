    
CREATE TABLE IF NOT EXISTS `users_freeleeches` (
  `UserID` int(11) NOT NULL,
  `TorrentID` int(11) NOT NULL,
  `Downloaded` bigint(20) unsigned NOT NULL DEFAULT '0',
  `Uploaded` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserID`,`TorrentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;