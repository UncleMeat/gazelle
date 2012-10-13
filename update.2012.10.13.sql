 
 
ALTER TABLE `xbt_files_users` ADD `port` INT( 6 ) NOT NULL DEFAULT '0' AFTER `ip` ;


CREATE TABLE IF NOT EXISTS `users_connectable_status` (
 `UserID` int(10) unsigned NOT NULL,
 `Status` enum('0','1') NOT NULL DEFAULT '1',
 `Time` int(10) NOT NULL DEFAULT '0',
 UNIQUE KEY `UserID` (`UserID`),
 KEY `Status` (`Status`) ,
 KEY `Time` (`Time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


 
 

