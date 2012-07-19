
ALTER TABLE `users_info` CHANGE `BlockPMs` `BlockPMs` ENUM( '0', '1', '2' ) NOT NULL DEFAULT '0';
ALTER TABLE `users_info` ADD `CommentsNotify` ENUM( '0', '1' ) NOT NULL DEFAULT '1' AFTER `BlockPMs` ;



