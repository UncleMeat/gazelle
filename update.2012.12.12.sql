     

ALTER TABLE `permissions` ADD `Color` CHAR( 6 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '000000' AFTER `MaxAvatarHeight` ;


--
-- Dumping data for table `permissions`
--

UPDATE `permissions` SET `Color` = '660066' WHERE `permissions`.`ID` = 1;
UPDATE `permissions` SET `Color` = '92a5c2' WHERE `permissions`.`ID` = 2;
UPDATE `permissions` SET `Color` = '4ec89b' WHERE `permissions`.`ID` = 3;
UPDATE `permissions` SET `Color` = '33cc33' WHERE `permissions`.`ID` = 4;
UPDATE `permissions` SET `Color` = 'ff8000' WHERE `permissions`.`ID` = 5;
UPDATE `permissions` SET `Color` = '0000ff' WHERE `permissions`.`ID` = 6;
UPDATE `permissions` SET `Color` = '000000' WHERE `permissions`.`ID` = 11;
UPDATE `permissions` SET `Color` = '8b0000' WHERE `permissions`.`ID` = 15;
UPDATE `permissions` SET `Color` = '000000' WHERE `permissions`.`ID` = 16;
UPDATE `permissions` SET `Color` = 'cfb53b' WHERE `permissions`.`ID` = 17;



