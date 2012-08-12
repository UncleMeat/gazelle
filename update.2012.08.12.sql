 
ALTER TABLE `badges` ADD `Display` INT( 3 ) NOT NULL DEFAULT '0' AFTER `Type` ,
ADD INDEX ( `Display` )  ; 

DELETE FROM `users_badges`;

	

