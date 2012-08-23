
ALTER TABLE `staff_checking` ADD `IsChecking` ENUM( '0', '1' ) NOT NULL DEFAULT '0',
ADD INDEX ( `IsChecking` ) ;



	

