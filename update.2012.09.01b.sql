 
ALTER TABLE `users_main` ADD `SeedHoursDaily` DOUBLE( 11, 2 ) NOT NULL DEFAULT '0.00' AFTER `personal_freeleech`,  
ADD INDEX ( `SeedHoursDaily` ),
DROP INDEX `SeedHours` ;

ALTER TABLE `users_info` ADD `SeedHistory` TEXT NOT NULL AFTER `AdminComment` ;
