
-- Add these indexes back and see how it affects performance in mass send pm
ALTER TABLE `pm_conversations_users` ADD INDEX ( `SentDate` ), ADD INDEX ( `ReceivedDate` ); 
 

 
	

