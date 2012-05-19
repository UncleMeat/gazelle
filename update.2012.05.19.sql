DROP TABLE  `torrents_lossymaster_approved`;
DROP TABLE  `torrents_cassette_approved`;
ALTER TABLE  `torrents_group` CHANGE  `SearchText`  `SearchText` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ;
ALTER TABLE  `sphinx_delta` ADD  `SearchText` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER  `FileList` ;
ALTER TABLE  `sphinx_hash` ADD  `SearchText` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER  `FileList` ;