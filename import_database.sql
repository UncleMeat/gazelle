TRUNCATE TABLE `gazelle`.`api_applications`;
TRUNCATE TABLE `gazelle`.`api_users`;
TRUNCATE TABLE `gazelle`.`artists_alias`;
TRUNCATE TABLE `gazelle`.`artists_group`;
TRUNCATE TABLE `gazelle`.`artists_similar`;
TRUNCATE TABLE `gazelle`.`artists_similar_scores`;
TRUNCATE TABLE `gazelle`.`artists_tags`;
TRUNCATE TABLE `gazelle`.`bad_passwords`;
TRUNCATE TABLE `gazelle`.`blog`;
TRUNCATE TABLE `gazelle`.`bookmarks_artists`;
TRUNCATE TABLE `gazelle`.`bookmarks_collages`;
TRUNCATE TABLE `gazelle`.`bookmarks_requests`;
TRUNCATE TABLE `gazelle`.`bookmarks_torrents`;
TRUNCATE TABLE `gazelle`.`collages`;
TRUNCATE TABLE `gazelle`.`collages_comments`;
TRUNCATE TABLE `gazelle`.`collages_torrents`;
TRUNCATE TABLE `gazelle`.`comments_edits`;
TRUNCATE TABLE `gazelle`.`donations`;
TRUNCATE TABLE `gazelle`.`do_not_upload`;
TRUNCATE TABLE `gazelle`.`drives`;
TRUNCATE TABLE `gazelle`.`dupe_groups`;
TRUNCATE TABLE `gazelle`.`email_blacklist`;
TRUNCATE TABLE `gazelle`.`featured_albums`;
TRUNCATE TABLE `gazelle`.`forums`;
TRUNCATE TABLE `gazelle`.`forums_categories`;
TRUNCATE TABLE `gazelle`.`forums_last_read_topics`;
TRUNCATE TABLE `gazelle`.`forums_polls`;
TRUNCATE TABLE `gazelle`.`forums_polls_votes`;
TRUNCATE TABLE `gazelle`.`forums_posts`;
TRUNCATE TABLE `gazelle`.`forums_specific_rules`;
TRUNCATE TABLE `gazelle`.`forums_topics`;
TRUNCATE TABLE `gazelle`.`friends`;
TRUNCATE TABLE `gazelle`.`geoip_country`;
TRUNCATE TABLE `gazelle`.`group_log`;
TRUNCATE TABLE `gazelle`.`invites`;
TRUNCATE TABLE `gazelle`.`invite_tree`;
TRUNCATE TABLE `gazelle`.`ip_bans`;
TRUNCATE TABLE `gazelle`.`library_contest`;
TRUNCATE TABLE `gazelle`.`log`;
TRUNCATE TABLE `gazelle`.`login_attempts`;
TRUNCATE TABLE `gazelle`.`news`;
TRUNCATE TABLE `gazelle`.`ocelot_query_times`;
TRUNCATE TABLE `gazelle`.`pm_conversations`;
TRUNCATE TABLE `gazelle`.`pm_conversations_users`;
TRUNCATE TABLE `gazelle`.`pm_messages`;
TRUNCATE TABLE `gazelle`.`reports`;
TRUNCATE TABLE `gazelle`.`reportsv2`;
TRUNCATE TABLE `gazelle`.`requests`;
TRUNCATE TABLE `gazelle`.`requests_artists`;
TRUNCATE TABLE `gazelle`.`requests_comments`;
TRUNCATE TABLE `gazelle`.`requests_tags`;
TRUNCATE TABLE `gazelle`.`requests_votes`;
TRUNCATE TABLE `gazelle`.`schedule`;
TRUNCATE TABLE `gazelle`.`sphinx_delta`;
TRUNCATE TABLE `gazelle`.`sphinx_hash`;
TRUNCATE TABLE `gazelle`.`sphinx_requests`;
TRUNCATE TABLE `gazelle`.`sphinx_requests_delta`;
TRUNCATE TABLE `gazelle`.`staff_blog`;
TRUNCATE TABLE `gazelle`.`staff_blog_visits`;
TRUNCATE TABLE `gazelle`.`staff_pm_conversations`;
TRUNCATE TABLE `gazelle`.`staff_pm_messages`;
TRUNCATE TABLE `gazelle`.`staff_pm_responses`;
TRUNCATE TABLE `gazelle`.`tags`;
TRUNCATE TABLE `gazelle`.`top10_history`;
TRUNCATE TABLE `gazelle`.`top10_history_torrents`;
TRUNCATE TABLE `gazelle`.`top_snatchers`;
TRUNCATE TABLE `gazelle`.`torrents_artists`;
TRUNCATE TABLE `gazelle`.`torrents_bad_files`;
TRUNCATE TABLE `gazelle`.`torrents_bad_folders`;
TRUNCATE TABLE `gazelle`.`torrents_bad_tags`;
TRUNCATE TABLE `gazelle`.`torrents_balance_history`;
TRUNCATE TABLE `gazelle`.`torrents_cassette_approved`;
TRUNCATE TABLE `gazelle`.`torrents_comments`;
TRUNCATE TABLE `gazelle`.`torrents_files`;
TRUNCATE TABLE `gazelle`.`torrents_group`;
TRUNCATE TABLE `gazelle`.`torrents_groups_log`;
TRUNCATE TABLE `gazelle`.`torrents_logs_new`;
TRUNCATE TABLE `gazelle`.`torrents_lossymaster_approved`;
TRUNCATE TABLE `gazelle`.`torrents_peerlists`;
TRUNCATE TABLE `gazelle`.`torrents_peerlists_compare`;
TRUNCATE TABLE `gazelle`.`torrents_recommended`;
TRUNCATE TABLE `gazelle`.`torrents_tags`;
TRUNCATE TABLE `gazelle`.`torrents_tags_votes`;
TRUNCATE TABLE `gazelle`.`users_collage_subs`;
TRUNCATE TABLE `gazelle`.`users_downloads`;
TRUNCATE TABLE `gazelle`.`users_dupes`;
TRUNCATE TABLE `gazelle`.`users_freeleeches`;
TRUNCATE TABLE `gazelle`.`users_geodistribution`;
TRUNCATE TABLE `gazelle`.`users_history_emails`;
TRUNCATE TABLE `gazelle`.`users_history_ips`;
TRUNCATE TABLE `gazelle`.`users_history_passkeys`;
TRUNCATE TABLE `gazelle`.`users_history_passwords`;
TRUNCATE TABLE `gazelle`.`users_info`;
TRUNCATE TABLE `gazelle`.`users_main`;
TRUNCATE TABLE `gazelle`.`users_notify_filters`;
TRUNCATE TABLE `gazelle`.`users_notify_torrents`;
TRUNCATE TABLE `gazelle`.`users_points`;
TRUNCATE TABLE `gazelle`.`users_points_requests`;
TRUNCATE TABLE `gazelle`.`users_sessions`;
TRUNCATE TABLE `gazelle`.`users_subscriptions`;
TRUNCATE TABLE `gazelle`.`users_torrent_history`;
TRUNCATE TABLE `gazelle`.`users_torrent_history_snatch`;
TRUNCATE TABLE `gazelle`.`users_torrent_history_temp`;
TRUNCATE TABLE `gazelle`.`wiki_aliases`;
TRUNCATE TABLE `gazelle`.`wiki_articles`;
TRUNCATE TABLE `gazelle`.`wiki_artists`;
TRUNCATE TABLE `gazelle`.`wiki_revisions`;
TRUNCATE TABLE `gazelle`.`wiki_torrents`;
TRUNCATE TABLE `gazelle`.`xbt_announce_log`;
TRUNCATE TABLE `gazelle`.`xbt_cheat`;
TRUNCATE TABLE `gazelle`.`xbt_client_whitelist`;
TRUNCATE TABLE `gazelle`.`xbt_config`;
TRUNCATE TABLE `gazelle`.`xbt_deny_from_hosts`;
TRUNCATE TABLE `gazelle`.`xbt_files`;
TRUNCATE TABLE `gazelle`.`xbt_files_users`;
TRUNCATE TABLE `gazelle`.`xbt_scrape_log`;
TRUNCATE TABLE `gazelle`.`xbt_snatched`;
TRUNCATE TABLE `gazelle`.`xbt_users`;

-- fetch data from emtest.users into gazelle.users_main

insert into `gazelle`.`users_main` (`ID`, `Username`, `Email`, `PassHash`, `Secret`, `Title`, `PermissionID`, `Enabled`, `Uploaded`, `Downloaded`, `LastLogin`, `LastAccess`, `IP`, `torrent_pass`, `Credits`)
SELECT `Id`, `username`, `email`, `passhash`, `secret`, `title`, '2', '1', `uploaded`, `downloaded`, from_unixtime(`last_login`), from_unixtime(`last_access`), `Ip`, `passkey`, `Bonuspoints` FROM emtest.users;

-- fetch data from emtest.users into gazelle.users_info

insert into `gazelle`.`users_info` (`UserID`, `StyleID`, `Avatar`, `JoinDate`, `Inviter`)
select `Id`, '1', `avatar`, from_unixtime(`added`), '0' from `emtest`.`users`;

-- set gazelle.users_main.enabled to 1 where emtest.users.enabled='yes'

UPDATE `gazelle`.`users_main`
SET `enabled` = '1'
WHERE EXISTS (SELECT 1 from `emtest`.`users` WHERE `emtest`.`users`.`id`=`gazelle`.`users_main`.`id` and `enabled`='yes');

-- set gazelle.users_main.enabled to 0 where emtest.users.enabled='no'

UPDATE `gazelle`.`users_main`
SET `enabled` = '0'
WHERE EXISTS (SELECT 1 from `emtest`.`users` WHERE `emtest`.`users`.`id`=`gazelle`.`users_main`.`id` and `enabled`='no');

-- set the correct class for the user

-- Apprentice
UPDATE `gazelle`.`users_main`
SET `PermissionID` = '2'
WHERE EXISTS (SELECT 1 from `emtest`.`users` WHERE `emtest`.`users`.`id`=`gazelle`.`users_main`.`id` and `class`='0');

-- Good Perv
UPDATE `gazelle`.`users_main`
SET `PermissionID` = '4'
WHERE EXISTS (SELECT 1 from `emtest`.`users` WHERE `emtest`.`users`.`id`=`gazelle`.`users_main`.`id` and `class`='1');

-- Sextreme Perv
UPDATE `gazelle`.`users_main`
SET `PermissionID` = '5'
WHERE EXISTS (SELECT 1 from `emtest`.`users` WHERE `emtest`.`users`.`id`=`gazelle`.`users_main`.`id` and `class`='2');

-- Smut Peddler
UPDATE `gazelle`.`users_main`
SET `PermissionID` = '6'
WHERE EXISTS (SELECT 1 from `emtest`.`users` WHERE `emtest`.`users`.`id`=`gazelle`.`users_main`.`id` and `class`='3');

--  MODS
UPDATE `gazelle`.`users_main`
SET `PermissionID` = '11'
WHERE EXISTS (SELECT 1 from `emtest`.`users` WHERE `emtest`.`users`.`id`=`gazelle`.`users_main`.`id` and `class`='4');

-- ADMINS
UPDATE `gazelle`.`users_main`
SET `PermissionID` = '1'
WHERE EXISTS (SELECT 1 from `emtest`.`users` WHERE `emtest`.`users`.`id`=`gazelle`.`users_main`.`id` and `class`='5');

-- SYSOP
UPDATE `gazelle`.`users_main`
SET `PermissionID` = '15'
WHERE EXISTS (SELECT 1 from `emtest`.`users` WHERE `emtest`.`users`.`id`=`gazelle`.`users_main`.`id` and `class`='6');

INSERT INTO `gazelle`.`invite_tree` (`UserID`, `InviterID`, `TreePosition`, `TreeID`, `TreeLevel`) VALUES ('0', '0', '1', '0', '1');

-- Import the forum
insert into `gazelle`.`forums_posts` (`ID`, `TopicID`, `AuthorID`, `AddedTime`, `Body`, `EditedUserID`, `EditedTime`)
select `id`, `topicid`, `userid`, from_unixtime(`added`), `body`, `editedby`, from_unixtime(`editedat`) from `emtest`.`posts`;

--

INSERT INTO gazelle.forums_topics (ID, Title, AuthorID, IsLocked, IsSticky, ForumID, NumPosts, LastPostID, LastPostTime, LastPostAuthorID)
SELECT 
id, 
subject, 
userid, 
0, 
if(sticky='yes', 1, 0) as sticky, 
forumid,
(select count(*) as count from emtest.posts where emtest.posts.topicid=emtest.topics.id) as numposts,
lastpost, 
(select from_unixtime(added) as added from emtest.posts where emtest.posts.id=emtest.topics.id) as time,
(select userid from emtest.posts where emtest.posts.id=emtest.topics.lastpost) as authorid
FROM
emtest.topics;

--

insert into gazelle.forums (ID, CategoryID, Sort, Name, Description, NumTopics, NumPosts, LastPostID, LastPostAuthorID, LastPostTopicID, LastPostTime)
select 
id, 
1,
sort, 
Name, 
description, 
topiccount, 
postcount,

(select p.id from emtest.topics as t
inner join emtest.posts as p on t.id=p.topicid
where t.forumid = emtest.forums.id
order by p.added desc limit 1) as LastPostId,

(select p.userid from emtest.topics as t
inner join emtest.posts as p on t.id=p.topicid
where t.forumid = emtest.forums.id
order by p.added desc limit 1) as LastPostAuthorID,

(select p.topicid from emtest.topics as t
inner join emtest.posts as p on t.id=p.topicid
where t.forumid = emtest.forums.id
order by p.added desc limit 1) as LastPostTopicID,

(select from_unixtime(p.added) from emtest.topics as t
inner join emtest.posts as p on t.id=p.topicid
where t.forumid = emtest.forums.id
order by p.added desc limit 1) as LastPostTime

from emtest.forums;

--

insert into gazelle.forums_last_read_topics (UserID, TopicID, PostID)
select userid, topicid, lastpostread
from emtest.readposts
group by userid, topicid

-- Import PM's
insert into gazelle.pm_conversations (ID, Subject)
select id, if(subject<>'', subject, 'no subject') as subject from emtest.messages

insert into gazelle.pm_messages (ConvID, SentDate, SenderID, Body)
select id, from_unixtime(added), sender, msg from emtest.messages;

insert into gazelle.pm_conversations_users (UserID, ConvID, InInbox, InSentbox, SentDate, ReceivedDate, UnRead)
select sender, id, 0, 1, from_unixtime(added), from_unixtime(added), 0 from emtest.messages where sender > 0 and sender <> receiver;

insert into gazelle.pm_conversations_users (UserID, ConvID, InInbox, InSentbox, SentDate, ReceivedDate, UnRead)
select receiver, id, 1, 0, from_unixtime(added), from_unixtime(added), 0 from emtest.messages where sender > 0 and sender <> receiver;