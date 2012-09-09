 
ALTER TABLE `users_main` ADD `UploadedLast` BIGINT( 20 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `Downloaded` ,
ADD `DownloadedLast` BIGINT( 20 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `UploadedLast`  ;


UPDATE `users_main` SET `UploadedLast`=`Uploaded`, `DownloadedLast`=`Downloaded` ;
