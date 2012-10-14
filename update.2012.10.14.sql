 
 
ALTER TABLE `users_connectable_status` ADD `IP` varchar(15) NOT NULL DEFAULT '' AFTER `UserID` ;

ALTER TABLE `users_connectable_status` DROP INDEX `UserID`;

ALTER TABLE `users_connectable_status` ADD PRIMARY KEY ( `UserID` , `IP` ) 



 
 

