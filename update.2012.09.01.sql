 
ALTER TABLE `users_main` ADD `CreditsDaily` DOUBLE( 11, 2 ) NOT NULL DEFAULT '0.00' AFTER `SeedHours` ;

ALTER TABLE `users_seedhours_history` ADD `Credits` DOUBLE( 11, 2 ) NOT NULL DEFAULT '0.00';
