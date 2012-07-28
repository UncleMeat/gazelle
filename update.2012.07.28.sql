
DELETE FROM `torrents_tags_votes`;
ALTER TABLE `gazelle`.`torrents_tags_votes` DROP PRIMARY KEY , ADD PRIMARY KEY ( `GroupID` , `TagID` , `UserID` ) ;
ALTER TABLE `torrents_group` CHANGE `Body` `Body` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ;
