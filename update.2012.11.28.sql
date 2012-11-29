     
SET group_concat_max_len = 10140;

ALTER TABLE `collages` CHANGE `TagList` `TagList` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ;
ALTER TABLE `torrents_group` CHANGE `TagList` `TagList` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ;

ALTER TABLE `sphinx_delta` CHANGE `TagList` `TagList` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ;
ALTER TABLE `sphinx_hash` CHANGE `TagList` `TagList` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ;

ALTER TABLE `users_downloads` DROP INDEX `UserID_2`;
ALTER TABLE `users_downloads` DROP INDEX `TorrentID_2`;

