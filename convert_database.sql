ALTER TABLE  `gazelle`.`users_main` CHANGE  `Username`  `Username` VARCHAR( 30 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE  `gazelle`.`users_main` ADD  `Credits` INT( 11 ) NOT NULL DEFAULT  '0';

-- Remove all invalid stylesheets and add the only valid one 'empornium'
TRUNCATE TABLE `gazelle`.`stylesheets`;
INSERT INTO  `gazelle`.`stylesheets` (
`ID`, `Name`, `Description`, `Default`)
VALUES (NULL, 'empornium', 'The new stylesheet', '1');

-- change the class names
UPDATE  `gazelle`.`permissions` SET  `Name` =  'Apprentice' WHERE  `permissions`.`ID` =2;
UPDATE  `gazelle`.`permissions` SET  `Name` =  'Perv' WHERE  `permissions`.`ID` =3;
UPDATE  `gazelle`.`permissions` SET  `Name` =  'Good Perv' WHERE  `permissions`.`ID` =4;
UPDATE  `gazelle`.`permissions` SET  `Name` =  'Sextreme Perv' WHERE  `permissions`.`ID` =5;

INSERT INTO  `gazelle`.`permissions` (`ID`, `Level`, `Name`, `Values`, `DisplayStaff`) VALUES ('6',  '300',  'Smut Peddler', 'a:18:{s:10:"site_leech";i:1;s:11:"site_upload";i:1;s:9:"site_vote";i:1;s:20:"site_submit_requests";i:1;s:20:"site_advanced_search";i:1;s:10:"site_top10";i:1;s:20:"site_torrents_notify";i:1;s:20:"site_collages_create";i:1;s:20:"site_collages_manage";i:1;s:19:"site_advanced_top10";i:1;s:19:"site_make_bookmarks";i:1;s:14:"site_edit_wiki";i:1;s:15:"site_delete_tag";i:1;s:14:"zip_downloader";i:1;s:19:"forums_polls_create";i:1;s:13:"torrents_edit";i:1;s:19:"torrents_add_artist";i:1;s:17:"admin_clear_cache";i:1;}', '0');

INSERT INTO `gazelle`.`permissions` (`ID`, `Level`, `Name`, `Values`, `DisplayStaff`) VALUES ('11', '500', 'Mod Perv', 'a:97:{s:10:"site_leech";i:1;s:11:"site_upload";i:1;s:9:"site_vote";i:1;s:20:"site_submit_requests";i:1;s:21:"site_see_old_requests";i:1;s:20:"site_advanced_search";i:1;s:10:"site_top10";i:1;s:19:"site_advanced_top10";i:1;s:20:"site_torrents_notify";i:1;s:20:"site_collages_create";i:1;s:20:"site_collages_manage";i:1;s:20:"site_collages_delete";i:1;s:23:"site_collages_subscribe";i:1;s:22:"site_collages_personal";i:1;s:28:"site_collages_renamepersonal";i:1;s:19:"site_make_bookmarks";i:1;s:14:"site_edit_wiki";i:1;s:22:"site_can_invite_always";i:1;s:27:"site_send_unlimited_invites";i:1;s:22:"site_moderate_requests";i:1;s:18:"site_delete_artist";i:1;s:20:"site_moderate_forums";i:1;s:17:"site_admin_forums";i:1;s:23:"site_forums_double_post";i:1;s:14:"site_view_flow";i:1;s:18:"site_view_full_log";i:1;s:28:"site_view_torrent_snatchlist";i:1;s:18:"site_recommend_own";i:1;s:27:"site_manage_recommendations";i:1;s:15:"site_delete_tag";i:1;s:23:"site_disable_ip_history";i:1;s:14:"zip_downloader";i:1;s:17:"site_proxy_images";i:1;s:16:"site_search_many";i:1;s:20:"users_edit_usernames";i:1;s:16:"users_edit_ratio";i:1;s:17:"users_edit_titles";i:1;s:18:"users_edit_avatars";i:1;s:18:"users_edit_invites";i:1;s:22:"users_edit_watch_hours";i:1;s:21:"users_edit_reset_keys";i:1;s:19:"users_edit_profiles";i:1;s:18:"users_view_friends";i:1;s:20:"users_reset_own_keys";i:1;s:19:"users_edit_password";i:1;s:16:"users_give_donor";i:1;s:10:"users_warn";i:1;s:19:"users_disable_users";i:1;s:19:"users_disable_posts";i:1;s:17:"users_disable_any";i:1;s:18:"users_view_invites";i:1;s:20:"users_view_seedleech";i:1;s:19:"users_view_uploaded";i:1;s:15:"users_view_keys";i:1;s:14:"users_view_ips";i:1;s:16:"users_view_email";i:1;s:23:"users_override_paranoia";i:1;s:12:"users_logout";i:1;s:20:"users_make_invisible";i:1;s:9:"users_mod";i:1;s:13:"torrents_edit";i:1;s:15:"torrents_delete";i:1;s:20:"torrents_delete_fast";i:1;s:18:"torrents_freeleech";i:1;s:20:"torrents_search_fast";i:1;s:17:"torrents_hide_dnu";i:1;s:21:"site_collages_recover";i:1;s:19:"torrents_add_artist";i:1;s:13:"edit_unknowns";i:1;s:19:"forums_polls_create";i:1;s:21:"forums_polls_moderate";i:1;}', '1');

INSERT INTO `gazelle`.`permissions` (`ID`, `Level`, `Name`, `Values`, `DisplayStaff`) VALUES ('1', '600', 'Admin', 'a:97:{s:10:"site_leech";i:1;s:11:"site_upload";i:1;s:9:"site_vote";i:1;s:20:"site_submit_requests";i:1;s:21:"site_see_old_requests";i:1;s:20:"site_advanced_search";i:1;s:10:"site_top10";i:1;s:19:"site_advanced_top10";i:1;s:20:"site_torrents_notify";i:1;s:20:"site_collages_create";i:1;s:20:"site_collages_manage";i:1;s:20:"site_collages_delete";i:1;s:23:"site_collages_subscribe";i:1;s:22:"site_collages_personal";i:1;s:28:"site_collages_renamepersonal";i:1;s:19:"site_make_bookmarks";i:1;s:14:"site_edit_wiki";i:1;s:22:"site_can_invite_always";i:1;s:27:"site_send_unlimited_invites";i:1;s:22:"site_moderate_requests";i:1;s:18:"site_delete_artist";i:1;s:20:"site_moderate_forums";i:1;s:17:"site_admin_forums";i:1;s:23:"site_forums_double_post";i:1;s:14:"site_view_flow";i:1;s:18:"site_view_full_log";i:1;s:28:"site_view_torrent_snatchlist";i:1;s:18:"site_recommend_own";i:1;s:27:"site_manage_recommendations";i:1;s:15:"site_delete_tag";i:1;s:23:"site_disable_ip_history";i:1;s:14:"zip_downloader";i:1;s:10:"site_debug";i:1;s:17:"site_proxy_images";i:1;s:16:"site_search_many";i:1;s:20:"users_edit_usernames";i:1;s:16:"users_edit_ratio";i:1;s:20:"users_edit_own_ratio";i:1;s:17:"users_edit_titles";i:1;s:18:"users_edit_avatars";i:1;s:18:"users_edit_invites";i:1;s:22:"users_edit_watch_hours";i:1;s:21:"users_edit_reset_keys";i:1;s:19:"users_edit_profiles";i:1;s:18:"users_view_friends";i:1;s:20:"users_reset_own_keys";i:1;s:19:"users_edit_password";i:1;s:19:"users_promote_below";i:1;s:16:"users_promote_to";i:1;s:16:"users_give_donor";i:1;s:10:"users_warn";i:1;s:19:"users_disable_users";i:1;s:19:"users_disable_posts";i:1;s:17:"users_disable_any";i:1;s:18:"users_delete_users";i:1;s:18:"users_view_invites";i:1;s:20:"users_view_seedleech";i:1;s:19:"users_view_uploaded";i:1;s:15:"users_view_keys";i:1;s:14:"users_view_ips";i:1;s:16:"users_view_email";i:1;s:23:"users_override_paranoia";i:1;s:12:"users_logout";i:1;s:20:"users_make_invisible";i:1;s:9:"users_mod";i:1;s:13:"torrents_edit";i:1;s:15:"torrents_delete";i:1;s:20:"torrents_delete_fast";i:1;s:18:"torrents_freeleech";i:1;s:20:"torrents_search_fast";i:1;s:17:"torrents_hide_dnu";i:1;s:17:"admin_manage_news";i:1;s:17:"admin_manage_blog";i:1;s:18:"admin_manage_polls";i:1;s:19:"admin_manage_forums";i:1;s:16:"admin_manage_fls";i:1;s:13:"admin_reports";i:1;s:26:"admin_advanced_user_search";i:1;s:18:"admin_create_users";i:1;s:15:"admin_donor_log";i:1;s:19:"admin_manage_ipbans";i:1;s:9:"admin_dnu";i:1;s:17:"admin_clear_cache";i:1;s:15:"admin_whitelist";i:1;s:24:"admin_manage_permissions";i:1;s:14:"admin_schedule";i:1;s:17:"admin_login_watch";i:1;s:17:"admin_manage_wiki";i:1;s:18:"admin_update_geoip";i:1;s:21:"site_collages_recover";i:1;s:19:"torrents_add_artist";i:1;s:13:"edit_unknowns";i:1;s:19:"forums_polls_create";i:1;s:21:"forums_polls_moderate";i:1;s:12:"project_team";i:1;s:25:"torrents_edit_vanityhouse";i:1;s:23:"artist_edit_vanityhouse";i:1;}', '1');

-- fetch data from emtest.users into gazelle.users_main

insert into `gazelle`.`users_main` (`ID`, `Username`, `Email`, `PassHash`, `Secret`, `Title`, `PermissionID`, `Enabled`, `Uploaded`, `Downloaded`, `LastLogin`, `LastAccess`, `IP`, `torrent_pass`, `Credits`)
SELECT `Id`, `username`, `email`, `passhash`, `secret`, `title`, '2', '1', `uploaded`, `downloaded`, from_unixtime(`last_login`), from_unixtime(`last_access`), `Ip`, `passkey`, `Bonuspoints` FROM emtest.users;

-- fetch data from emtest.users into gazelle.users_info

insert into `gazelle`.`users_info` (`UserID`, `StyleID`, `Avatar`, `JoinDate`, `Inviter`)
select `Id`, '1', `avatar`, from_unixtime(`added`), '0' from `emtest`.`users`;

-- set gazelle.users_main.enabled to 1 where emtest.users.enabled='yes'

UPDATE `gazelle`.`users_main`
SET `enabled` = (SELECT '1' from `emtest`.`users` WHERE `emtest`.`users`.`id`=`gazelle`.`users_main`.`id` and `enabled`='yes')
WHERE EXISTS (SELECT 1 from `emtest`.`users` WHERE `emtest`.`users`.`id`=`gazelle`.`users_main`.`id` and `enabled`='yes');

-- set gazelle.users_main.enabled to 0 where emtest.users.enabled='no'

UPDATE `gazelle`.`users_main`
SET `enabled` = (SELECT '0' from `emtest`.`users` WHERE `emtest`.`users`.`id`=`gazelle`.`users_main`.`id` and `enabled`='no')
WHERE EXISTS (SELECT 1 from `emtest`.`users` WHERE `emtest`.`users`.`id`=`gazelle`.`users_main`.`id` and `enabled`='no');

