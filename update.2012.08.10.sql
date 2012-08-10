 
ALTER TABLE `articles` ADD `SubCat` INT( 4 ) NOT NULL DEFAULT '1' AFTER `Category` ,
ADD INDEX ( `SubCat` ), 
ADD INDEX ( `Category` ) ; 

	

