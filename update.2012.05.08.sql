ALTER TABLE  `torrents_group` 
DROP  `Year` ,
DROP  `CatalogueNumber` ,
DROP  `RecordLabel` ,
DROP  `ReleaseType` ,
DROP  `VanityHouse` ,
DROP  `RevisionID` ,
DROP  `ArtistID` ,
DROP  `NumArtists` ;

ALTER TABLE  `sphinx_delta` 
DROP  `Year` ,
DROP  `Media` ,
DROP  `Format` ,
DROP  `RemasterYear` ,
DROP  `RemasterTitle` ,
DROP  `RemasterRecordLabel` ,
DROP  `RemasterCatalogueNumber` ,
DROP  `LogScore` ,
DROP  `HasLog` ,
DROP  `HasCue` ,
DROP  `CatalogueNumber` ,
DROP  `RecordLabel` ,
DROP  `ReleaseType` ,
DROP  `VanityHouse` ,
DROP  `Scene` ,
DROP  `ArtistName` ;

ALTER TABLE  `sphinx_hash` 
DROP  `Year` ,
DROP  `Media` ,
DROP  `Format` ,
DROP  `RemasterYear` ,
DROP  `RemasterTitle` ,
DROP  `RemasterRecordLabel` ,
DROP  `RemasterCatalogueNumber` ,
DROP  `LogScore` ,
DROP  `HasLog` ,
DROP  `HasCue` ,
DROP  `CatalogueNumber` ,
DROP  `RecordLabel` ,
DROP  `ReleaseType` ,
DROP  `VanityHouse` ,
DROP  `Scene` ,
DROP  `ArtistName` ;

ALTER TABLE  `torrents` 
DROP  `Media` ,
DROP  `Format` ,
DROP  `Remastered` ,
DROP  `RemasterYear` ,
DROP  `RemasterTitle` ,
DROP  `RemasterCatalogueNumber` ,
DROP  `RemasterRecordLabel` ,
DROP  `HasLog` ,
DROP  `HasCue` ,
DROP  `LogScore` ,
DROP  `Scene` ,
CHANGE  `WikiBody`  `Body` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
CHANGE  `WikiImage`  `Image` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
DROP  `TranscodedFrom` ;

ALTER TABLE  `requests` 
DROP  `CatalogueNumber` ,
DROP  `ReleaseType` ,
DROP  `RecordLabel` ,
DROP  `Year` ,
DROP  `BitrateList` ,
DROP  `FormatList` ,
DROP  `MediaList` ,
DROP  `LogCue` ;

ALTER TABLE  `sphinx_requests` 
DROP  `CatalogueNumber` ,
DROP  `RecordLabel` ,
DROP  `ArtistList` ,
DROP  `Year` ,
DROP  `ReleaseType` ,
DROP  `BitrateList` ,
DROP  `FormatList` ,
DROP  `MediaList` ,
DROP  `LogCue` ;

ALTER TABLE  `sphinx_requests_delta` 
DROP  `CatalogueNumber` ,
DROP  `RecordLabel` ,
DROP  `ArtistList` ,
DROP  `Year` ,
DROP  `ReleaseType` ,
DROP  `BitrateList` ,
DROP  `FormatList` ,
DROP  `MediaList` ,
DROP  `LogCue` ;

ALTER TABLE  `users_info` 
DROP  `Artist` ;

ALTER TABLE  `users_notify_filters` 
DROP  `FromYear` ,
DROP  `ToYear` ,
DROP  `RecordLabels` ,
DROP  `Artists` ,
DROP  `ExcludeVA` ;

DROP TABLE  `artists_alias`;
DROP TABLE  `artists_group`;
DROP TABLE  `artists_similar`;
DROP TABLE `artists_similar_scores`;
DROP TABLE `artists_similar_votes`;
DROP TABLE  `artists_tags`;
DROP TABLE  `bookmarks_artists`;
DROP TABLE  `requests_artists`;
DROP TABLE  `torrents_artists`;
DROP TABLE  `wiki_artists`;
DROP TABLE  `wiki_aliases`;
DROP TABLE  `wiki_articles`;
DROP TABLE  `wiki_torrents`;