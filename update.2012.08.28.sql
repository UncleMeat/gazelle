
-- optimisation --

-- Add indexes to columns used in joins/clauses 
 
ALTER TABLE `badges` ADD INDEX ( `Badge` ), ADD INDEX ( `Rank` ) ;
ALTER TABLE `users_badges` ADD INDEX ( `UserID` ) , ADD INDEX ( `BadgeID` ) ;
ALTER TABLE `pm_messages` ADD INDEX ( `SenderID` ) ;

-- Remove unused indexes from users_info

ALTER TABLE `users_info` DROP INDEX `BitcoinAddress`, DROP INDEX `BitcoinAddress_2` ;
  
-- Remove indexes from low-cardinality cols in write heavy pm_conversations_users table
-- (remove userID as its the left hand index of compound primary key so seperate index is unnessacary)

ALTER TABLE `pm_conversations_users` DROP INDEX `ForwardedTo`,
DROP INDEX `Sticky`, 
DROP INDEX `InInBox`,
DROP INDEX `InSentbox`,
DROP INDEX `UserID`,
DROP INDEX `SentDate`,
DROP INDEX `ReceivedDate` ;
	

