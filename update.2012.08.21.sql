


DROP TABLE IF EXISTS `staff_checking`;
CREATE TABLE IF NOT EXISTS `staff_checking` (
  `UserID` int(10) unsigned NOT NULL,
  `TimeOut` int(10) unsigned NOT NULL,
  `TimeStarted` datetime NOT NULL,
  `Location` varchar(128) NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


	

