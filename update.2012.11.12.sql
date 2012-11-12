    
 
  ALTER TABLE `users_main` CHANGE `UploadedLast` `UploadedDaily` BIGINT( 20 ) UNSIGNED NOT NULL DEFAULT '0',
CHANGE `DownloadedLast` `DownloadedDaily` BIGINT( 20 ) UNSIGNED NOT NULL DEFAULT '0';



