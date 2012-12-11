     

ALTER TABLE `articles` ENGINE = MYISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

ALTER TABLE `gazelle`.`articles` ADD FULLTEXT (`Description`);
ALTER TABLE `gazelle`.`articles` ADD FULLTEXT (`Body`);
ALTER TABLE `gazelle`.`articles` ADD FULLTEXT (`Title`);

 
REPAIR TABLE `articles` QUICK;




