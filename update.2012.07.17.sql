
ALTER TABLE `friends` ADD `Type` enum('friends','blocked') NOT NULL ;
ALTER TABLE `users_info` ADD `BlockPMs` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `SaveSentPMs` ;

UPDATE `friends` SET `Type`='friends';


