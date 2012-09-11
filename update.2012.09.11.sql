 
ALTER TABLE `articles` ADD `MinClass` SMALLINT( 4 ) NOT NULL DEFAULT '0' AFTER `Hidden` ,
ADD INDEX ( `MinClass` )  ;
