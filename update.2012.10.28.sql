    
 
 

-- --------------------------------------------------------

-- Use RENAME TABLE to atomically move the original table out of the way and rename the copy to the original name:

RENAME TABLE `users_history_emails` TO `users_history_emails_old`;
 
DROP TABLE IF EXISTS `users_history_emails`;
CREATE TABLE IF NOT EXISTS `users_history_emails` (
  `UserID` int(10) NOT NULL,
  `Email` varchar(255) NOT NULL DEFAULT '',
  `Time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `IP` varchar(15) NOT NULL DEFAULT '0.0.0.0',
  `ChangedbyID` int(10) NOT NULL,
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users_history_emails` (`UserID`, `Email`, `Time`, `IP`, `ChangedbyID`)
                    SELECT `UserID`, `Email`, `Time`, `IP`, '0' FROM `users_history_emails_old`;

DROP TABLE `users_history_emails_old`;



