
ALTER TABLE `badges` ADD `Badge` VARCHAR( 12 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ;
ALTER TABLE `badges` ADD `Rank` TINYINT( 3 ) UNSIGNED NOT NULL DEFAULT '1';

ALTER TABLE `users_badges` CHANGE `Title` `Description` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ;
