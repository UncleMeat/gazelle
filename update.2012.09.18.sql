 
ALTER TABLE `bonus_shop_actions` CHANGE `Action` `Action` ENUM( 'gb', 'givegb', 'givecredits', 'slot', 'title', 'badge', 'pfl', 'ufl' ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL  ;
 

INSERT INTO `bonus_shop_actions` (`ID` ,`Title` ,`Description` ,`Action` ,`Value` ,`Cost` ,`Sort`)
VALUES (NULL , 'Freeleech torrent', 'Make a torrent of yours freeleech for everyone permanently', 'ufl', '1', '75000', '35');

