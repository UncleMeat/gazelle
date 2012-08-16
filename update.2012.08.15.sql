
ALTER TABLE `permissions` ADD `IsUserClass` ENUM( '0', '1' ) NOT NULL DEFAULT '1', ADD INDEX ( `IsUserClass` ) ;

ALTER TABLE `permissions` DROP INDEX `Level` , ADD INDEX `Level` ( `Level` )  ;

ALTER TABLE `users_main` ADD `GroupPermissionID` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `PermissionID` ;


	

