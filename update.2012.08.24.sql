


CREATE TABLE IF NOT EXISTS `site_stats_history` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `TimeAdded` datetime NOT NULL,
  `Users` int(10) unsigned NOT NULL,
  `Torrents` int(10) unsigned NOT NULL,
  `Seeders` int(10) unsigned NOT NULL,
  `Leechers` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `TimeAdded` (`TimeAdded`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



	

