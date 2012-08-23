

ALTER TABLE `imagehost_whitelist` ADD `Hidden` ENUM( '0', '1' ) NOT NULL DEFAULT '0',
ADD INDEX ( `Hidden` )  ;



	

