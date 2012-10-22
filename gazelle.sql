-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- Värd: localhost
-- Skapad: 22 mars 2012 kl 22:30
-- Serverversion: 5.1.61
-- PHP-version: 5.3.6-13ubuntu3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `gazelle`
--
CREATE DATABASE IF NOT EXISTS gazelle;

USE gazelle;

-- --------------------------------------------------------

--
-- Tabellstruktur `api_applications`
--

CREATE TABLE IF NOT EXISTS `api_applications` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `UserID` int(10) NOT NULL,
  `Token` char(32) NOT NULL,
  `Name` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `api_users`
--

CREATE TABLE IF NOT EXISTS `api_users` (
  `UserID` int(10) NOT NULL,
  `AppID` int(10) NOT NULL,
  `Token` char(32) NOT NULL,
  `State` enum('0','1','2') NOT NULL DEFAULT '0',
  `Time` datetime NOT NULL,
  `Access` text,
  PRIMARY KEY (`UserID`,`AppID`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Category` int(11) NOT NULL,
  `SubCat` INT( 4 ) NOT NULL DEFAULT '1',
  `TopicID` varchar(20) CHARACTER SET utf8 NOT NULL,  
  `MinClass` SMALLINT(4) NOT NULL DEFAULT '0',
  `Title` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Description` varchar(100) CHARACTER SET utf8 NOT NULL,
  `Body` text CHARACTER SET utf8 NOT NULL,
  `Time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `TopicID` (`TopicID`),
  KEY `Category` (`Category`),
  KEY `SubCat` (`SubCat`),
  KEY `MinClass` (`MinClass`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Dumpning av Data i tabell `articles`
--

INSERT INTO `articles` (`ID`, `Category`, `TopicID`, `Title`, `Description`, `Body`, `Time`) VALUES
(1, 0, 'rules', 'Golden Rules', 'These are important rules, breaking these will result in unwanted consequences.', '[color=#0261a3][size=5][font=Arial Black]GENERAL SITE RULES[/font][/size][/color]\r\n\r\n\r\n[b]Please note that breaking any of these rules is not advised and can lead to a warning or even a banning in extreme cases. [/b]\r\n\r\n[*]  You are allowed ONE account only. If we find you have more than one account, all will be disabled.  Access to this website is a privilege, not a right, and it can be taken away from you for any reason.\r\n[*]  Do not defy the staff member''s expressed wishes.  We are not dicks, but can become one very quickly.  All staff decisions must be respected. If you take issue with a decision, you must do so privately with the staff member who issued the decision or with an administrator of the site. Complaining about staff decisions in public or otherwise disrespecting staff members will not be taken lightly.\r\n[*]  Do not upload our torrents to other trackers.  Your .torrent file has your unique passkey so sharing it is not advisable.\r\n[*]  Any behavior that we deem unacceptable in the forums or on torrent comments will not be tolerated.  Refrain from comment sniping or being a smart ass.  If you choose to do so, a warning and possible ban will be forthcoming.\r\n[*]  All forum posts and torrent comments must be in English only.\r\n[*]  If you have a suggestion that you think might improve the site, please use the "Suggestions" forum.  Please be polite and try to understand that any decisions made, are made in the best interest of the site.\r\n[*]  It is your responsibility to keep up to date with any changes in site policy. Make sure you read the "Old Announcements" before you ask any questions regarding these matters.\r\n[*]  Please make sure you read the FAQ before asking any questions.\r\n[*]  Please direct all questions to the "Help and Support" section of the forums.\r\n[*]  Please do not act as a "Mini-Mod" by posting comments on other member''s torrents if you spot any rule violations. Always use the report function if you spot anything untoward.\r\n[*] If you feel you have any input that could help an uploader improve their torrent in any way, then by all means post a comment and tell them, but please be polite. Starting the comment by saying thanks for the upload would be a good place to start. Anything other than polite constructive criticism would be deemed as ''comment sniping'' and would be severely frowned upon.  You will only get one warning! After that it''s bye bye!  So please don''t be a "Dick" dude...\r\n[*]  We''re a community, a family. Working together is what makes this place what it is. There are new torrents uploaded every day and sadly the staff aren''t psychic. If you come across something which violates a rule, please report it! Ignoring it is only damaging the community.\r\n[*]  We respect the wishes of other sites here, as we wish for them to do the same. Please refrain from posting links or full names of sites that want not to be mentioned.\r\n\r\n\r\n', '2012-06-06 23:44:16'),
(2, 0, 'ratio', 'Ratio Rules', 'These are the rules for seeding/leeching activity on this site.', 'Your ratio is the amount you''ve uploaded divided by the amount you''ve downloaded. \r\n\r\nTo maintain leeching privileges, we require that you maintain a ratio above a minimum ratio. This is called your "required ratio". If your upload/download ratio goes below your required ratio, your account will be given a two week period to fix it before you lose your ability to download. This is called "ratio watch". \r\n\r\nThe required ratio is [b]NOT the extra amount of ratio you need to gain[/b]. It is the [b]minimum[/b] required ratio you must maintain. \r\n\r\nYour required ratio is unique, and is calculated from the amount you''ve downloaded, and the percentage of your snatched torrents which you are still seeding. \r\n\r\n[b]It is not necessary to know how this ratio is calculated. What you need to know is that downloading makes the required ratio go up (bad) and seeding your snatches forever makes your required ratio go down (good). You can view your required ratio in the site header (it is the "Required" value). You want a high ratio, and a low required ratio.[/b]\r\n\r\nThe exact formula for calculating the required ratio is provided merely for the curious. It is done in three steps. \r\n\r\nThe first step is by determining how high and how low your required ratio can be. This is determined by looking up how much you''ve downloaded from the following table:\r\n[ratiolist]\r\n\r\nSo for example, if you''ve downloaded 25GB, your required ratio will be somewhere between 0.05 and 0.30. \r\n\r\nTo get this range of requirements to a more precise number, what we do is take the required ratio (0% seeded) for your download band, multiply it by: [tex]1-\\frac{Seeding}{Snatched}[/tex], and round it up to the required ratio (100% seeded) if need be. Therefore, your required ratio will always lie between the 0% seeded and 100% seeded requirements, depending on the percentage of torrents you are seeding. \r\n		\r\nIn the formula, "snatched" is the number of [b]non-deleted unique snatches[/b] (complete downloads) you have made (so if you snatch a torrent twice, it only counts once, and if it is then deleted, it''s not counted at all). "Seeding" is the average number of torrents you''ve seeded over at least 72 hours in the past week. If you''ve seeded less than 72 hours in the past week, the "seeding" value will go down (which is bad). \r\n		\r\nThus, if you have downloaded less than 20GB, and you are seeding 100% of your snatches, you will have [b]no required ratio[/b]. If you have downloaded less than 5GB, then no matter what percentage of snatches you are seeding, you will again have no required ratio. \r\n\r\nIf you stop seeding for an entire week, your required ratio will be the "required ratio (0% seeded)" for your download band. Your required ratio will go down once you start seeding again. \r\n\r\nTake note how, as your download increases, the [b]0% seeded and 100% seeded required ratios begin to taper together[/b]. They meet at 100GB of download, meaning that after you''ve downloaded 100GB, your ratio requirement will be 0.60, no matter what percentage of your snatches you''re seeding. \r\n		\r\n[b][size=4]Important information you should know[/size][/b]\r\n\r\nIf your ratio does not meet your required ratio, you will be put on ratio watch. You will have [b]two weeks[/b] to get your ratio above your required ratio - [b]failure to do so will result in your downloading privileges being automatically disabled[/b]. \r\n\r\nIf you download over 10GB while you''re on ratio watch, you will be instantly disabled. \r\n\r\nEveryone gets to download their first 5GB before ratio watch kicks in.\r\n\r\n[b]To get out of ratio watch, you must either raise your ratio by uploading more, or lower your required ratio by seeding more. Your ratio MUST be above your required ratio.[/b]\r\n\r\nIf you have lost your downloading privileges, your new required ratio will be the 0% seeded ratio. You will re-gain \r\nyour downloading privileges once your ratio is above that required ratio. \r\n\r\nThe ratio watch system is completely automatic, and cannot be altered by staff. ', '2012-05-20 00:23:39'),
(12, 0, 'requests', 'Requests', 'These are the rules that govern requests.', '[*][b]Do not make requests for torrents that break the rules.[/b] It is your responsibility that the request follows the rules. Your request will be deleted and you will not get your bounty back. Requests cannot be more specific than the upload (and trumping) rules.\r\n\r\n[*][b]Do Not request Forbidden Content! It will just get you a warning or your account will be disabled in extreme cases.\r\n\r\n[*][b]You must be a Good Perv with a ratio of at least 1.0 to be able to make a Request.\r\n\r\n[*][b]Do a search before posting a request! Make sure the torrent isn''t already on the tracker or requested by someone else. \r\n\r\n[*][b]The request section is not for re-seed requests.\r\n\r\n[*][b]Please give as much information as you can, pervs will not search the net to find what/who you are looking for! Please provide titles/images/names, it will increase the chances of your request being filled.\r\n\r\n[*][b]Only one title per request.\r\n\r\n[*][b]Do not unfill requests for trivial reasons.[/b] If you did not specify in your request what you wanted (such as bitrates or a particular edition), do not unfill and later change the description. Do not unfill requests if you are unsure of what you are doing (e.g. the filled torrent may be a transcode, but you don''t know how to tell). Ask for help from <a href="/staff.php">staff</a> in that case. You may unfill if the torrent doesn''t fit your specifications stated clearly in the request.\r\n\r\n[*][b]All users must have an equal chance to fill a request.[/b] Trading upload credit is not allowed. Abusing the request system to exchange favors for other users is not tolerated. That includes making specific requests for certain users (whether explicitly named or not). Making requests for releases, and then unfilling so that one particular user can fill the request is not allowed. If reported, both the requester and user filling the request will receive a warning and lose the request bounty.\r\n\r\n[*][b]No manipulation of the requester for bounty.[/b] The bounty is a reward for helping other usersâ€”it should not be a ransom. Any user who refuses to fill a request unless the bounty is increased will face harsh punishment.\r\n\r\n[*][b]Please be patient once you have made your request. Impatient pervs will probably just get their requests ignored.\r\n\r\n[*][b]Last but not least, please remember and say THANKS if your request is successful!', '2012-06-07 00:23:15'),
(13, 0, 'collages', 'Collages', 'These are the rules that govern collages.', '[*]Collages in the Discography, Staff Picks, Label, and Charts categories must be based on fact, and not opinion. If something is a published Best Of (for instance, "Pitchfork''s Best Albums of the 1990''s") then it should go in the Charts category.</li>\r\n[*]Collages in the Personal, Theme, and Genre Introductions categories may be based on opinion. You must respect others'' opinions whilst creating and populating Theme and Genre Introduction collages.\r\n[*]Vandalizing of collages will be taken very seriously, resulting in collage editing privileges being removed (at a minimum).\r\n[*]Personal Best Of collages are only allowed in the new Personal Collages category. You must be a Power User+ or Donor to create one.\r\n[*]A well-defined group of people, for instance Torrent Masters, or Interviewers, may create a Group Picks Theme collage with one pick per person, after having gained permission for the collage from Staff.\r\n[*]There may only be one collage per Genre Introduction/Theme. Dupe collages will be deleted.\r\n[*]Theme/Genre Introduction collages must be sensible, and reasonably broad. Those that do not fit this description will be deleted.\r\n[*]Collages are not an alternative to the tagging system. A collage such as ''mathcore torrents'' wouldn''t be allowed, because it is far more appropriate to just tag the torrents as mathcore. Of course, an ''xysite.com worst 50 mathcore albums'' collage would be looked upon differently.\r\n[*]Collages should not be used to create artist discographies, as the artist pages already exist for this purpose. However, for an artist who has a multitude of side projects, it is allowed to create a collage containing all of the projects, to be placed in the Discography category.\r\n[*]Power Users and Donors get one personal collage.  Elites can have two, Torrent Masters can have up to three, Power TMs up to four and Elite TM+ up to five. Donors always receive one more than the class maximum.\r\n[*]Every collage must have at least 3 albums in it.\r\n[*]Please check to see that a similar collage does not already exist. If a similar collage does exist, please contribute to the existing collage.\r\n[*]Please give your collage an appropriate title and a decent description explaining its purpose.\r\n[*]Please attempt to add album art to every torrent in your collage.\r\n', '2012-05-11 20:34:36'),
(14, 0, 'clients', 'Clients', 'These are the clients we allow to connect to our tracker and rules specific to them.', 'Client rules are how we maintain the integrity of our swarms. This allows us to filter out disruptive and dishonest clients that may hurt the performance of either the tracker or individual peers.\r\n\r\n[clientlist]\r\n\r\n[b]Further Rules[/b]\r\nThe modification of clients to bypass our client requirements (spoofing) is explicitly forbidden. People caught doing this will be instantly and permanently banned. This is your only warning.\r\n\r\nThe use of clients or proxies which have been modified to report incorrect stats to the tracker (cheating) is not allowed, and will result in a permanent ban. Additionally, your information will be passed on to representatives of other trackers, where you are liable to be banned as well. \r\n\r\nThe testing of unstable clients by developers is not allowed unless approved by a staff member. \r\n\r\n[b]Further Details[/b]\r\n\r\nIf someone you invited to the site breaks the above rules you will receive a 2 month warning and lose the right to invite people to this site.\r\n\r\nIf you were invited by someone who broke the above rules, your account will be disabled without warning. \r\n', '2012-05-11 21:36:48'),
(15, 0, 'upload', 'Upload', 'This is the section of the rules regarding any and all content which is allowed on this site.', '[color=#0261a3][size=5][font=Arial Black]UPLOADING RULES[/font][/size][/color]\r\n\r\n\r\n[b]Torrents in violation of these rules may be deleted without notice![/b]\r\n\r\n\r\nFailure to follow these rules can result in a warning, having your uploading privileges revoked or having your account disabled.\r\n\r\nIf a staff member tells you to fix something on your upload, you should do so immediately or your torrent will be deleted.\r\n\r\nAll new uploads must include a proper English description and at least one tag. Adding more tags will obviously help members find your torrent much easier thus possibly giving you more leechers.\r\n\r\nDo not add tags that reflect what is not included, such as "No.Anal" if its the only tag you are adding. Tags and filters work on positive results. Search results will show you what is there, not what isn''t.\r\n\r\nAll presentations must have pics/screen shots that describes the content.\r\n-If you post a siterip/mega-pak you have to post screen shots of all videos, or post a good amount\r\nand Include screens to all videos in a separate folder inside your torrent for separate download!!\r\n\r\nDescribe the torrent!!,simply posting a screen shot or a pic is not enough!\r\n-Any torrent with a presentation with less than 2 sentences risk deletion!!\r\n\r\n\r\nAll users must use an APPROVED image host!\r\n\r\n\r\nThe following image hosts have been approved:\r\n\r\n\r\n[b][size=2]APPROVED IMAGE HOSTS[/size][/b]\r\n\r\n\r\nhotchyx.com\r\nimgbox.com\r\nstooorage.com\r\nxxx.freeimage.us\r\n\r\n\r\n\r\n\r\n[b][size=2]Private IMAGE Hosts[/size][/b]\r\n\r\n\r\nbringthescreencaps.com.\r\n\r\n\r\n\r\n\r\nAlways check that your image host isn''t on the banned list!\r\n\r\nDo not use them here at EMPornium or your torrent will be deleted and you will receive a warning.\r\n\r\n\r\nThe following image hosts are banned:\r\n\r\n\r\n[b][size=2]BANNED IMAGE HOSTS[/size][/b]\r\n\r\n\r\nblackassfest.info\r\nfunkyimg.com\r\nimagebam.com\r\nimageporter.com\r\nimageshack.us\r\nimagetwist.com\r\nimgchili.com\r\npiclambo.net\r\npixroute.com\r\ntinypic.com\r\n\r\nAnd all other pay-per-click and POPUP img hosts.\r\n\r\n\r\n\r\n\r\nIf you want to have a pic host approved post a link in this topic, and Staff will take a look at it! [b]-LINK HERE-[/b]\r\n\r\nWe encourage members to use [b][url=http://xxx.freeimage.us/]http://xxx.freeimage.us/[/url][/b] as a host for screens and pics here.  [b]-Tutorial link here-[/b]\r\n\r\nDO NOT try to "slip one by" -ALL Torrents are checked on a daily basis!!\r\n\r\nAlways do a search to make sure that what you want to share isn''t already posted here!\r\n\r\nDuped torrents will be deleted!\r\n\r\n\r\n\r\n\r\nDUPES\r\n\r\nAn upload is considered a dupe if a file of the same size and format has already been posted either as a single file upload or as part of a larger torrent. If the original torrent is no longer active please create a reseed request using the "Request / Reseed" forums, if a reseed request hasn''t been filled within 2 weeks you are allowed to repost the content.\r\n\r\n\r\nPosting a megapack or site rip that includes content that has already been posted (for the sake of completeness) is allowed as long as it contains a proportional amount of new material as well. When in doubt you can always consult a staff member for a pre-emptive ruling using the Contact link.\r\n\r\n*Split-scenes of previously uploaded full movies are not considered dupes.\r\n\r\n\r\nAlways add an anonymizer (http://anonym.to/http://your link here) in front of direct links to porn sites.\r\n\r\nMake sure your torrents are well-seeded,at least 3-4 other seeders before you stop.\r\n\r\nUse the BBCode Sandbox before uploading if you are unsure about how to use bbcodes.\r\n-Basic bbcode tutorial can be found - [b]HERE[/b]\r\n\r\nDO NOT add commentary to your uploads making veiled threats that you will not upload unless you get comments or something else you seek...  If you don''t want to upload, then don''t do so...  Making veiled threats only cause more problems than they are worth...  So don''t do it...!!!!\r\n\r\n\r\nMultiple resolution versions of a file are welcome at EMPornium but must be uploaded separately from now on. Since very few peers will want to download the same vid in multiple resolution these kind of torrents suffer from a unnecessary short lifespan. Furthermore no bonus credits are awarded to the users seeding just one version of the video(s) contained in such torrents. We know this creates some extra work for uploaders but after long consideration we have decided to do what we think is best for the tracker. We are sorry for any inconvenience this causes but honestly think this will be for the better.\r\n\r\n\r\n\r\n\r\n[color=#0261a3][size=5][font=Arial Black]FORBIDDEN CONTENT[/font][/size][/color]\r\n\r\n\r\n[b][size=2]Forbidden list[/size][/b]\r\n\r\n\r\n[b]NO Underage (below 18) content.\r\nNO Child Porn.\r\nNO True Rape.\r\nNO Beast.\r\nNo Snuff.\r\nNo Main Stream Content Allowed.\r\nNO Child Birth.\r\nNO Programs/.exe Files except for porn games.\r\nNO Password protected files or folders.\r\nNo Archived media except for large pictorrents.+250 pics.(uploaders choice)\r\nNo rar Scene releases,you need to unrar them to make screens anyway.[/b]\r\n\r\n\r\n[b][size=2]UNDER NO CIRCUMSTANCES POST OR REQUEST ANY OF THIS MATERIAL[/size][/b]\r\n\r\n\r\n[b]1) NO Child/Underage Porn (under 18).\r\nThis includes drawings/hentai such as lolicon & similar, anything that is overtly underage is strictly not allowed.\r\nDon''t push it, don''t even think about it, just don''t do it.\r\nStaff decisions at this private site are final, you can accept it or leave, do not argue.\r\n\r\n2) NO True Rape.\r\n\r\n3) NO Beast or Snuff.\r\nYes this also includes drawing & animation, with some hentai, tentacle etc, being an obvious exception.\r\nHowever they MUST be genuine hentai titles, that is the title/s is primarily concerned with sex.\r\nSome anime titles contain sexual elements/scenes but it''s not the prime focus, they have no place here.\r\nAny deaths or serious injury in such content should be incidental & not part of or due to sexual acts.\r\n\r\n4) NO Underage models or incidental by-standers (non-nude or otherwise).\r\n\r\n5) NO Child Birth.\r\n\r\n6) NO Password protected files or folders unless password is provided... Don''t waste everyone''s time and don''t charge anyone for the damn password...\r\n\r\n7) NO video files packed in a .rar or .zip extension\r\n\r\n\r\n\r\n\r\nAlexandra Quinn pre-dating 1991/2. All of Alexandra''s legal titles star her with D-cup breast implants so anything else must not be uploaded here.\r\n\r\nBeach Cabin series or similar originating from dubious Russian/Ukrainian websites.\r\nbest-teens.com\r\n\r\nBieyanka Moore - ALL scenes/titles\r\n\r\nChristina Model - Anything from 05 or earlier.  She was under 18 at the time.\r\n\r\nColor Climax / Vicom / Blue Vanities / Filmfare: - All titles.\r\n\r\nGalitsin content, ALL\r\n\r\nGirls Gone Wild: Ultimate Spring Break, On Campus Uncensored, Totally Exposed UNcensored & Beyond, College Girls Exposed/Sexy Sorority Sweethearts, Spring Break 2003 or any GGW titles starring Ashley Alexandra Dupre/Eliot Spitzer scandal call girl.\r\n\r\nHannah/hannah-fans.com/Hannah_UK/Hannah motel room etc, etc.\r\n\r\nlolitanetworks/lolitasex.com\r\n\r\nMisty Regan titles pre-dating 1981: Champagne Orgy; Diamond Collection original series #2,#3,#9,#11; Inside Desiree Cousteau; Rolls Royce #6; Sound Of Love; Three Ripening Cherries; Udderly Fantastic; Urban Cowgirls; Velvet High; High School memories\r\n\r\nMuntinlupa Philippines scandal - ALL videos\r\n\r\nSebastian Bleisch - ALL titles\r\n\r\nteenfuns/angelfuns/fallenangelfuns/fm-teens etc\r\n\r\nTraci Lords Titles, ALL.\r\n\r\n\r\nNOTE:\r\n\r\n--All content from LittleLupe.com--\r\n\r\n\r\n**New**\r\n\r\nls models (ls barbie, ls land, ls valentine, ls little guests, ls batman, ls forbidden fruit, ls Little Pearl,\r\nls stunning dolls, ls builder, ls show, ls stars, ls dream, ls Lively Pers)\r\nvideo2000\r\nbd company\r\nlolitas holiday\r\nhotlols\r\nsundolls\r\nsunlolitas\r\ndark company\r\nlittle agency\r\nteenfuns\r\nangelfuns\r\nukraine angels\r\nlolitashouse\r\nmylola.info\r\npreteen agency\r\nKarina World\r\nPink-Teens\r\n\r\nThis list is not exhaustive.[/b]\r\n\r\n\r\n\r\nIf you see any rule violations please use the "Report" function.\r\n\r\nLeaving a comment on the posted torrent isnt going to help staff deal with it. \r\n\r\nIf you dont know how to upload or make/upload and post screenshots then check the Tutorial Forum - [b]HERE[/b]\r\n\r\nA topic to check before uploading: [b]***Beginners guide to presentations***[/b]\r\n\r\nAlways check these rules before uploading,as they are subject to change.\r\n\r\nIt is your responsibility to keep updated about the rules!\r\n\r\nNo rules lawyering! Any wannabe rule lawyers will be banned.\r\n\r\n', '2012-06-07 17:55:47'),
(16, 0, 'chat', 'Chat', 'Read this before posting in our forums or talking on the IRC.', '[*]Many forums (Tutorials, The Library, etc.) have their own set of rules. Make sure you read and take note of these rules before you attempt to post in one of these forums.\r\n[*]Don''t use all capital letters, excessive !!! (exclamation marks) or ??? (question marks), it seems like you''re shouting!\r\n[*]No lame referral schemes. This includes freeipods.com, freepsps.com, or any other similar scheme in which the poster gets personal gain from users clicking a link.\r\n[*]No asking for money for any reason whatsoever. We don''t know or care about your friend who lost everything, or dying relative who wants to enjoy their last few moments alive by being given lots of money.\r\n[*]No advertising your uploads. \r\n[*]No posting torrent requests in forums, there''s a request link on the top bar, please use that instead.\r\n[*]No flaming, be pleasant and polite. Don''t use offensive language, and don''t be confrontational for the sake of confrontation.\r\n[*]Don''t point out or attack other members'' share ratios. A higher ratio does not make you better than someone else.\r\n[*]Try not to ask stupid questions. A stupid question is one that you could have found the answer to yourself with a little research, or one that you''re asking in the wrong place. If you do the basic research suggested (i.e., read the rules/wiki) or search the forums and don''t find the answer to your question, then go ahead and ask. Staff/FLS are not here to hand-feed you the answers you could have found on your own with a little bit of effort.\r\n[*]Be sure you read all the stickies.\r\n[*]Use descriptive and specific subject lines. This helps others decide whether your particular words of wisdom relate to a topic they care about.\r\n[*]Try not to post comments that don''t add anything to the discussion. When you''re just cruising through a thread in a leisurely manner, it''s not too annoying to read through a lot of "hear, hear"''s and "I agree"''s. But if you''re actually trying to find information, it''s a pain in the neck. So save those one-word responses for threads that have degenerated to the point where none but true aficionados are following them any more.\r\n\r\nOr short: [b]NO spamming[/b]\r\n\r\n[*]Refrain from quoting excessively. When quoting someone, use only the portion of the quote that is absolutely necessary. This includes quoting pictures!\r\n[*]No posting of requests for serials or cracks. No links to warez or crack sites in the forums.\r\n[*]No political or religious discussions. These types of discussions lead to arguments and flaming users, something that will not be tolerated. The only exception to this rule is The Library forum, which exists solely for the purpose of intellectual discussion and civilized debate.\r\n[*]Don''t waste other people''s bandwidth by posting images of a large file size.\r\n[*]Be patient with newcomers. Once you have become an expert, it is easy to forget that you started out as a newbie too.\r\n[*]No requesting invites to any sites anywhere on the site or IRC. Invites may be <strong>offered</strong> in the invite forum, and nowhere else.\r\n[*]No language other than English is permitted in the forums. If we can''t understand it, we can''t moderate it. \r\n', '2012-06-07 00:12:54'),
(17, 0, 'tag', 'Tagging', 'These rules govern what tags can and can not be added.', '[*]Tags should be separated by a space, and you should use a period (''.'') to separate words inside a tag - eg. [b][color=green]big.boobs[/color][/b]. \r\n[*]There is a list of official tags and synomyns [url=http://trackerdev.mooo.com/torrents.php?action=tag_synomyns]listed here[/url]. Please use these tags instead of ''unofficial'' tags (eg. use the official [b][color=green]big.boobs[/color][/b] tag, instead of an unofficial [b][color=red]big.knockers[/color][/b] tag.)\r\n[*]Avoid using multiple synonymous tags. The synomyn replacer will swap many for an official tag anyway, and if not then using both [b][color=red]redhair[/color][/b] and [b][color=green]red.head[/color][/b] is redundant and annoying - just use the official [b][color=green]redhead[/color][/b] tag. \r\n[*][b]Do[/b] add or vote up tags that describe the content well, and vote down tags that are inappropriate for that upload.\r\n[*][b]Don''t[/b] use useless tags, such as [b][color=red]amazing.body[/color][/b], [b][color=red]awesome[/color][/b], [b][color=red]must.see[/color][/b]. Tags should describe the content of the upload in searchable keywords, not pervs opinions about the content. \r\n[*][b]Don''t[/b] vote for tags because you like or dislike the content, voting should be about whether the tag is appropriate, not whether you like the scene.\r\n\r\n[url=http://trackerdev.mooo.com/torrents.php?action=tag_synomyns][font=Arial Black][size=3]Official tag list & synomyns[/size][/font][/url]\r\n\r\n[hide]\r\n// I dont think we want this bit\r\n[*]Avoid abbreviations when appropriate. So instead of tagging an upload as ''[b][color=red]alt[/color][/b]'', tag it as ''[b][color=green]alternative[/color][/b]''. Make sure that you use correct spelling. [/hide]\r\n', '2012-06-05 21:08:02'),
(25, 1, 'tutorials', 'Tutorials be here they will /yoda', 'The dark side is strong young padawan', 'Here be noobs', '2012-05-11 22:53:52'),
(26, 1, 'utorrent', 'Uploading with uTorrent for Dummies', 'A small guide on how to download with uTorrent', '[b]Start uTorrent\r\n\r\n\r\n1. Click "File" > "Create new Torrent" (uTorrent menu > File > Create a New torrent)\r\n[img]http://main.makeuseoflimited.netdna-cdn.com/wp-content/uploads/2010/06/09_Create_New_Torrent_in_uTorrent.png[/img]\r\n\r\n\r\n2. Select the files and or directories (Select "Add a File" or "Add a directory.(folder)")\r\n[img]http://img411.imageshack.us/img411/2741/utorrentuploadtut2ob8.jpg[/img]\r\n\r\n\r\n3. On tracker add the tracker''s announce url: \r\nhttp://torrents.empornium.me/announce.php\r\n\r\n\r\n\r\n4. Tick the private torrent box!!!!\r\n (tick ''Preserve file order'' if uTorrent have that feature - recommended)\r\n\r\n\r\n5. Click create and save as\r\n\r\n\r\n6. Upload the torrent on the site\r\nTorrent file: chose the new created file\r\n\r\nTorrent name: enter a name or will be added as name of your folder / file\r\n\r\nDescription: Fileformat/Screenshot/Cover/Actors/Length\r\n\r\nType: choose the category\r\n\r\nNote: If the category that you want is not available, just use "Other"\r\n\r\nNote: Please refrain from using bbcodes when naming your file or folder.\r\n\r\n\r\n***AFTER UPLOADING TO THE SITE DELETE THE TORRENTFILE YOU CREATED!!***\r\n\r\n--THEN DOWNLOAD THE ONE FROM EMP!!--\r\n\r\n[color=red][size=4]This is where many get stuck-so read and follow these instructions.[/size][/color]\r\n\r\n\r\nYou download the torrentfile..Dont start it..uncheck start!\r\n\r\nIf its started-stop it in your client.\r\n\r\nThen rightclick-choose Advanced and "set download location" -choose your file/folder\r\n\r\nAfter that is done rightclick it in your client again and choose "force recheck"\r\n\r\n[img]http://www.online-tech-tips.com/wp-content/uploads/2009/04/changeutorrentdownloadlocation-thumb.png[/img]\r\n\r\nNow your torrent should check at 100% if everything is right.\r\n\r\nIf so-Start and seed! [/b]', '2012-05-11 22:56:50'),
(27, 1, 'search', 'Boolean Search', 'A guide on how to use boolean operators for a more refined search', '[b]Where does the term Boolean originate from?[/b]\r\nBoolean searching is built on a method of symbolic logic developed by George Boole, a 19th century English mathematician. Most online databases and search engines support Boolean searches. Boolean search techniques can be used to carry out effective searches, cutting out many unrelated documents.\r\n\r\n[b]Is Boolean Search Complicated?[/b]\r\nUsing Boolean Logic to broaden and/or narrow your search is not as complicated as it sounds; in fact, you might already be doing it. Boolean logic is just the term used to describe certain logical operations that are used to combine search terms in many search engine databases and directories on the Net. It''s not rocket science, but it sure sounds fancy (try throwing this phrase out in common conversation!).\r\n\r\n[b]Basic Boolean Search Operators - AND (&)[/b]\r\nUsing AND narows a search by combining terms; it will retrieve documents that use both the search terms you specify, as in this example:\r\n\r\nblowjob and facial, can also be written as blowjob & facial.\r\n\r\nThere is always an implicit AND operator, so "hello world" query actually means "hello and world".\r\n\r\n[b]Basic Boolean Search Operators - OR (|)[/b]\r\nUsing OR broadens a search to include results that contain either of the words you type in. OR is a good tool to use when there are several common spellings or synonyms of a word, as in this example:\r\n\r\nhardcore or softcore, can also be written as hardcore | softcore.\r\n\r\n[b]Basic Boolean Search Operators - NOT (!,-)[/b]\r\nUsing NOT will narrow a search by excluding certain search terms. NOT retrieves documents that contain one, but not the other, of the search terms you enter, as in this example:\r\n\r\nhardcore not facial, can also be written as hardcore -facial or even hardcore !facial.\r\n\r\n[b]Boolean Grouping - ( )[/b]\r\nWith parentheses you can group different statements together, like in this example:\r\n\r\n(cat not dog) or (cat not mouse), or as (cat -dog ) | (cat -mouse).', '2012-05-19 22:20:04'),
(28, 0, 'download', 'Download', 'These are the rules that govern downloading', '[color=#0261a3][size=5][font=Arial Black]DOWNLOADING RULES[/font][/size][/color] \r\n\r\n[b]Please note that by not following these rules there is a strong chance you will lose your downloading privileges![/b]\r\n\r\nDownloading torrents is conditional upon you maintaining a good ratio!\r\n\r\nHaving a low ratio could result in your account being disabled in some extreme cases.\r\n\r\nIf you have downloaded more than 10GB and have a ratio of below 0.5 and you have not seeded back what you have taken, then you will be leech warned and your downloading privileges will be disabled. You will then have 3 weeks to improve your ratio by seeding back what you have taken or by uploading something of your own.\r\n\r\nAlways check your stats BEFORE you download anything. If you have a low ratio then you could grab a freeleech torrent (which is donated by a gold spinning coin), or you could try downloading something new. Always grabbing what you want might not be a good idea as it may already be overseeded. It''s a good idea to try and build a good healthy ratio rather than just downloading everything you want right away.\r\n\r\nDo not complain to the Staff or blame the tracker if your stats or bonus credits aren''t correct. If you have checked that you are connectable and you are using a proper client, then check the [b][url=http://trackerdev.mooo.com/articles.php?topic=faq]FAQ[/url][/b] and the Help And Support section of the forums. \r\n\r\n', '2012-06-07 17:26:26'),
(29, 0, 'avatar', 'Avatar', 'This is the section of the rules regarding avatars.', 'AVATAR GUIDELINES \r\n\r\nPlease try to follow these guidelines\r\n\r\nThe following image formats are allowed .gif, .jpg and .png.\r\n\r\nHow do i add an Avatar to my profile? CLICK HERE\r\n\r\nAvatars must not exceed 512kB or be vertically longer than 400px.\r\n\r\nDo not use potentially offensive material involving religious material, animal / human cruelty or ideologically charged images.', '2012-06-09 06:36:32');
INSERT INTO `articles` (`ID`, `Category`, `TopicID`, `Title`, `Description`, `Body`, `Time`) VALUES
(30, 0, 'faq', 'FAQ', 'This is the FAQ for the site.', '[br][br]\r\n[color=#0261a3][size=6][font=Arial Black]Welcome to torrents.empornium.me ![/font][/size][/color]\r\n\r\n[*]Our goal is to bring the former empornium and puretna community back to its former glory, and make the biggest worldwide porn sharing site. \r\n[*]With the demise of yet another large porntracker (Cheggit) we wish to welcome all the new members who migrated from there.\r\n[*]We now have a unique opportunity to build a new community of pornlovers! This will however require patience from members from all the three old sites, and a positive attitude that we along the way can find the best solutions for the whole community.\r\n[*]Do keep in mind that this site sometimes are upgraded and to keep up with whats going on (bugs/updates-functionality) be sure to regularly check the [u]Current upgrades, Fixes and bugs Topic[/u] in the Forums.\r\n\r\n\r\n\r\n\r\n[color=#0261a3][size=6][font=Arial Black]Before you do anything here at empornium[/font][/size][/color]\r\n\r\n[*]You have to read and understand the [u]- rules![/u]\r\n[*]And the torrents.empornium.me [u]user agreement.[/u]\r\n[*]There are only a few rules to abide by, but we do enforce them!\r\n[*]Please take notice that the FAQ is subject to regular updates!\r\n[*]In case you are not sure about something use the [u]- Help and Support Forum[/u]\r\n[*]Do not pm staff for support - it will be ignored and deleted!\r\n[*]Why? - Well if everyone sends pms to the staff we end up answering the same questions over and over.\r\n[*]Questions should be in the [b]Help & Support[/b] forum as they may help others, make sure you search the forum before you post as most questions have been asked before.\r\n\r\n\r\n\r\n\r\n[color=#0261a3][size=6][font=Arial Black]Faq Topics[/font][/size][/color]\r\n\r\n\r\n\r\n[size=4][font=Arial Black]Site information:[/font][/size]\r\n\r\n\r\nWhat is this bittorrent all about anyway? How do I get the files?[spoiler= ]BitTorrent it''s about sharing and exchanging files. \r\nYou need a torrent client like utorrent to download files from others.[/spoiler]\r\n\r\n[b]Check out[/b] [url=http://www.utorrent.com/help/guides/beginners-guide]utorrent beginners guide[/url]\r\n\r\n\r\nWhere does the donated money go?[spoiler= ]All donations go to server bills. \r\nWe still havent opened a donation page.\r\nIf you want to donate now send a PM to Sysop.[/spoiler]\r\n\r\nWhere can I get a copy of the source code?[spoiler= ]This site is based on the gazelle code. \r\nPlease note:\r\nWe do not give any kind of support on the source code. \r\nYou can find it on the internet; at your own risk![/spoiler]\r\n\r\n\r\n\r\n[size=4][font=Arial Black]User information:[/font][/size]\r\n\r\nWhat does the letters and numbers on the top bar mean?[spoiler= ]Up: =Total upload amount\r\n    Down: =Total Download amount\r\n    Slots: =the amount of freeleech/doubleseed slots you have left\r\n    Credits: =The amount of bonuscredits you have accumulated and are at your disposal right now\r\n    Ratio: =This is what your current ratio is.-Total Upload/Total Download = Your Ratio\r\n    Required: = It is the minimum required ratio you must maintain\r\n[/spoiler]\r\n\r\nSo, what''s MY ratio?[spoiler= ]Your ratio is the amount you''ve uploaded divided by the amount you''ve downloaded. [/spoiler]\r\n\r\n[url=http://trackerdev.mooo.com/articles.php?topic=ratio] Link to more info about the Ratio rules[/url]\r\n\r\nWhat are the bonus credits and "slots" for and how can it be used?[spoiler= ]\r\nBonuscredits gives you 2 more download/seeding alternatives.!\r\n\r\nRegular Download:\r\n\r\n(Always available with a good ratio)\r\nUse this download link to download the torrent in the normal way.\r\nAll download / upload activity will be reported normally to the tracker.\r\n\r\n\r\nFree Leech/Double Upload Slots\r\nCan be purchased with your collected bonuscredits.\r\n\r\n***Notice!***\r\nThe Freeleech and Doubleseed Download buttons are only displayed\r\nnext to the regular download button after purchasing a Free/Double slot.\r\n\r\n\r\n\r\nFreeleech Slot:\r\n\r\nOnce chosen this torrent will be Freeleech for 14 days\r\nand can be resumed or started over using the regular download link.\r\nDoing so will result in one Freeleech Slot being taken away from your total.\r\n\r\nWhen you use this slot your download activity (for the choosen torrent)\r\n-will not be reported to the tracker\r\nOnly the upload activity would be reported.\r\n\r\n\r\nDoubleseed Slot:\r\n\r\nOnce chosen this torrent will be Doubleseed for 14 days\r\nand can be resumed or started over using the regular download link.\r\nDoing so will result in one Freeleech Slot being taken away from your total.\r\n\r\nWhen you use this download link it will report your download activity\r\nnormally to the tracker,but this time, your uploaded amount \r\n(on the choosen torrent) will be reported 2 times of the actual uploaded amount to the tracker.\r\n\r\n\r\nYou can also give away bonuspoints,or improve your own or others ratios.\r\nA custom title and some forum bling can also be purchased.\r\n[/spoiler]\r\n\r\nBonuscredits,How does it work?[spoiler= ]What is a credit?\r\n\r\nCredits are distributed as a bonus to people who are seeding torrents. \r\nYou can find your total credit amount at the top of this page,\r\nor on your user details page.[/spoiler]\r\n\r\nHow is the credit calculated?[spoiler= ]You get 0.25 credits for every 15 minutes of every torrent you seed. Every torrent is counted, so 2 torrents seeded for 1 hour will give you 2 credits etc.\r\nNo credits are awarded for leeching torrents.\r\nOkay!\r\nIf you seed...\r\n...1 torrent for 10 hours, you will get 10 credits.\r\n...5 torrents for 20 hours, you will get 100 credits.\r\n...10 torrents 24/7 for a week, you will get 1680 credits.\r\n...60 torrents 24/7 for a week, you will get 10,080 credits.\r\nbut no more than 60 torrents at once are counted; some users may abuse :P[/spoiler]\r\n\r\nI am seeding a partially downloaded torrent,but im not getting any credits?[spoiler]Remember that with partially downloaded torrents,\r\nwhen seeding them you wont get credited with bonus,\r\nBecause the tracker will only see you as a leech!!\r\nWe recommend downloading the full torrent if you want to get credited.[/spoiler]\r\n\r\nI registered an account but did not receive the confirmation e-mail![spoiler]All accounts are auto confirmed. \r\nYou will receive an email only if you reset your password. \r\nNote though that if you didn''t receive the email the first time \r\nit will probably not succeed the second time either \r\nso you should really try another email address.[/spoiler]\r\n\r\nCan you rename my account?[spoiler= ](you need a good reason)- [url=http://trackerdev.mooo.com/staffpm.php?action=user_inbox&show=1&assign=admin&msg=changeusername]Send a message to admin[/url][/spoiler]\r\n\r\nCan you delete my (confirmed) account?[spoiler= ]Yes, ask admin.[/spoiler]\r\n\r\nWhy is my IP displayed on my details page?[spoiler= ]Only you and the site moderators can view your IP address and email. \r\nRegular users do not see that information.[/spoiler]\r\n\r\nHelp! I cannot login!? (a.k.a. Login of Death)[spoiler]This problem sometimes occurs with MSIE. \r\nClose all Internet Explorer windows and open Internet Options in the control panel. \r\nClick the Delete Cookies button. \r\nYou should now be able to login.[/spoiler]\r\n\r\nMy IP address is dynamic. How do I stay logged in?[spoiler]You do not have to anymore. \r\nAll you have to do is make sure you are logged in with your actual IP \r\nwhen starting a torrent session. After that, even if the IP changes mid-session, \r\nthe seeding or leeching will continue and the statistics will update without any problem.[/spoiler]\r\n\r\nWhy am I listed as not connectable? (And why should I care?)[spoiler]The tracker has determined that you are firewalled or NATed and cannot accept incoming connections.\r\n\r\nThis means that other peers in the swarm will be unable to connect to you, only you to them. \r\nEven worse, if two peers are both in this state they will not be able to connect at all.\r\nThis has obviously a detrimental effect on the overall speed.\r\n\r\nThe way to solve the problem involves opening the ports used for incoming connections \r\n(the same range you defined in your client) on the firewall \r\nand/or configuring your NAT server to use a basic form of NAT for that range instead of NAPT \r\n(the actual process differs widely between different router models. \r\nCheck your router documentation and/or support forum. \r\nYou will also find lots of information on the subject at http://portforward.com[/spoiler]\r\n\r\nHow do I add an avatar to my profile?[spoiler= ]First, find an image that you like, and that is within the rules.\r\nThen you will have to find a place to host it, \r\nsuch as our own image hosting xxx.freeimage.us. \r\nAll that is left to do is to copy the image location to the avatar field in your profile.[/spoiler]\r\n\r\nWhat are the different user classes?[spoiler= ]\r\n\r\n[color=#737CA1]The Empornium Apprentice[/color]\r\n - The default class of new members.\r\n\r\n[color=green]Good Perv[/color] \r\n- Your average "good ratio" perv,can view Top10.\r\n\r\n[color=#FF3300]Sextreme Perv[/color] \r\n- Same privileges as Good Perv but is considered an Elite Member of Empornium.\r\nImmune to automatic demotion.\r\n\r\n[color=blue]Pimp[/color] \r\n- Highly respected and trusted members of The Porn peddler class.\r\nAlso the class of retired Staffmembers.\r\nSame privileges as the others.\r\nImmune to automatic demotion.\r\n\r\n\r\nOther\r\n\r\n[img]http://torrents.empornium.me/pic/star.gif[/img] - Has donated money to torrents.empornium.me.\r\n\r\nCustomised title. - Bought from bonus credit or given by Mods.\r\n\r\n\r\nStaff Classes\r\n\r\nMod Perv - Can edit and delete any uploaded torrents.\r\nCan also moderate user comments in forums and torrent presentations and disable accounts.\r\n\r\n[color=#7D0552]Admin Perv[/color] - Can do just about anything.\r\n\r\n[color=#7D0552]Sysop[/color] - (site owner).[/spoiler]\r\n\r\nHow does this promotion thing work anyway?[spoiler]\r\n\r\n[color=green]Good Perv[/color]\r\n\r\n- Must have been be a member for at least 4 weeks,\r\nhave uploaded at least 25GB and have a ratio at or above 1.05.\r\nThe promotion is automatic when these conditions are met.\r\nNote that you will be automatically demoted from\r\nthis status if your ratio drops below 0.95 at any time.\r\n\r\n\r\n[color=#FF3300]Sextreme Perv[/color]\r\n \r\n- Assigned by mods at their discretion to users \r\nthey feel are more active and contribute and/or help out more \r\nthan the average members at empornium.\r\n- If an uploader: Expected to maintain good presentation standards.\r\n(Anyone begging for Sextreme status will be automatically disqualified.)\r\n\r\n\r\n[color=blue]Pimp[/color]\r\n\r\n - The much respected long time pornpeddlers of the site,\r\ncontributing with lots of quality uploads and living legends within the community.\r\nAssigned by mods at their discretion.\r\n- If an uploader: Expected to maintain excellent presentation standards.\r\nThis title could also be granted members who contributed in any other extraordinary way.\r\n(Anyone begging for pimp status will be automatically disqualified.)\r\n\r\n\r\nOther\r\n\r\n[img]http://torrents.empornium.me/pic/star.gif[/img] - Just donate, and send Sysop - and only Sysop - the details.\r\n\r\nCustom Title - Conferred by mods at their discretion or bought from bonus credits.\r\n\r\nMod Perv - You don''t ask us, we''ll ask you![/spoiler]\r\n\r\nMy question is not posted above?[spoiler]First-Check if its posted below here,if not use the Help and Support forum.[/spoiler]\r\n\r\n\r\n\r\n[size=4][font=Arial Black]Uploading:[/font][/size]\r\n\r\n\r\nIs everyone allowed to upload?[spoiler]Yes,make sure that you have read and understood the RULES first!!\r\nOr you might loose that privilege.[/spoiler]\r\n\r\nWhat pichosts are allowed/banned?\r\nAll users must use an APPROVED picture host!\r\n**************************Add whitelist tag here*******************************\r\n\r\n\r\n\r\n\r\nCan i Edit my torrents?[spoiler][/spoiler]not done\r\n\r\nI have a question about uploading?[spoiler]Check the tutorial forum first,then post in the Help and Support forum.[/spoiler]\r\n\r\nWhat is The BBcode Sandbox?[spoiler]This is where you can test your bbcodes before uploading.\r\nIf tags arent closed properly,the whole presentation can get lost.[/spoiler]\r\n\r\nWhere do i report a problem?[spoiler]Use the Help and Support forum-make sure your question havent been asked there before.\r\n[/spoiler]\r\n\r\nWhen uploading a torrentfile i get the message "Invalid Filename"[spoiler]Make sure you havent got either a space at the beginning or end of the file name,\r\nor are using a special character that cannot be recognized.\r\nKeep the name simple!!\r\nIt is also recommended to not use Internet Explorer when transferring files,\r\nand check if there is any corrupted files within your torrent.\r\nAvoid many directories,keep it simple.[/spoiler]\r\n\r\nCan I upload your torrents to other trackers?[spoiler]No. \r\n\r\nWe are a closed community. Only registered users can use the torrents.empornium tracker.\r\n\r\nPosting our torrents on other trackers is useless, \r\nsince most people who attempt to download them will be unable to connect with us. \r\nThis generates a lot of frustration and bad-will against us at torrents.empornium.me, \r\nand will therefore not be tolerated.\r\n\r\nComplaints from other sites administrative staff\r\nabout our torrents being posted on their sites \r\nwill result in the banning of the users responsible.\r\n\r\nHowever, the files you download from us are yours to do as you please. \r\nYou can always create another torrent, pointing to some other tracker, \r\nand upload it to the site of your choice.\r\n[/spoiler]\r\n\r\nIs there any content thats not allowed to be Uploaded?[spoiler]NO Child/Beast/Snuff porn!\r\nKeep it legal. If in doubt, don''t post it.\r\nAnd check the rules concerning forbidden content.\r\n[/spoiler]\r\n\r\n\r\n\r\n[size=4][font=Arial Black]Stats:[/font][/size]\r\n\r\n\r\nMost common reasons for stats not updating[spoiler]The user is cheating. (a.k.a. "Summary Ban")\r\nThe server is overloaded and unresponsive. \r\nJust try to keep the session open until the server responds again. \r\n(Flooding the server with consecutive manual updates is not recommended.)\r\nYou are using a faulty client. \r\nIf you want to use an experimental or CVS version you do it at your own risk.\r\nYou should also check which clients have been reported \r\nas "not supported" in the forums.[/spoiler]\r\n\r\nBest practices[spoiler]If a torrent you are currently leeching/seeding is not listed on your profile, \r\njust wait or force a manual update.\r\nMake sure you exit your client properly, so that the tracker receives "event=completed"!!!.\r\nIf the tracker is down, do not stop seeding. \r\nAs long as the tracker is back up before you exit the client the stats should update properly.\r\n[/spoiler]\r\n\r\nMay I use any bittorrent client?[spoiler]No!\r\n\r\nThe following clients are banned for various reasons(cheating e.t.c)\r\n\r\n*Bitlord\r\n*Bitcomet\r\n*Torrentstorm\r\n\r\n\r\nAlso,make sure that you check the often updated list\r\nof malfunctioning/not supported clients/client versions in the forums.\r\n\r\nAlso, any clients in alpha or beta version should be avoided.\r\n\r\nWe recommend the following clients in Stable versions:\r\n\r\nÂµTorrent\r\nVuze/Azureus\r\nrTorrent\r\n\r\nHowever,even these clients go through updates that creates bugs!\r\nSo you need to keep up to date with the latest reported client problems and fixes![/spoiler]\r\n\r\nWhy is a torrent I''m leeching/seeding listed several times in my profile?[spoiler]If for some reason (e.g. pc crash, or frozen client) your client exits improperly\r\nand you restart it, it will have a new peer_id, so it will show as a new torrent.\r\nThe old one will never receive a "event=completed" or "event=stopped" \r\nand will be listed until some tracker timeout. \r\nJust ignore it, it will eventually go away.\r\n[/spoiler]\r\n\r\nI''ve finished or cancelled a torrent. Why is it still listed in my profile?[spoiler]Some clients, notably TorrentStorm and Nova Torrent, \r\ndo not report properly to the tracker when canceling or finishing a torrent. \r\nIn that case the tracker will keep waiting for some message \r\n- and thus listing the torrent as seeding or leeching - until some timeout occurs. \r\nJust ignore it, it will eventually go away.\r\n[/spoiler]\r\n\r\nWhy do I sometimes see torrents I''m not leeching in my profile!?[spoiler]When a torrent is first started, the tracker uses the IP to identify the user.\r\nTherefore the torrent will become associated \r\nwith the user who last accessed the site from that IP. \r\n\r\nIf you share your IP in some way (you are behind NAT/ICS, or using a proxy),\r\nand some of the persons you share it with are also users, \r\nyou may occasionally see their torrents listed in your profile. \r\n(If they start a torrent session from that IP \r\nand you were the last one to visit the site the torrent will be associated with you). \r\nNote that now torrents listed in your profile will always count towards your total stats.\r\n\r\nTo make sure your torrents show up in your profile \r\nyou should visit the site immediately before starting a session.\r\n\r\n(The only way to completely stop foreign torrents from showing in profiles \r\nis to forbid users without an individual IP from accessing the site. \r\nYes, that means you. Complain at your own risk.)[/spoiler]\r\n\r\nMultiple IPs (Can I login from different computers?)[spoiler]Yes, our tracker is using the passkey system, so the ip of the user is of no relevance,\r\nas the identification of the user is being done by the means\r\nof checking the user''s passkey and not the ip.\r\n[/spoiler]\r\n\r\nHow does NAT/ICS change the picture?[spoiler]This is a very particular case in that all computers in the LAN \r\nwill appear to the outside world as having the same IP. \r\n\r\nWe must distinguish between two cases:\r\n\r\n1. You are the single torrents.empornium.me users in the LAN\r\n\r\nYou should use the same torrents.empornium.me account in all the computers.\r\n\r\nNote also that in the ICS case it is preferable to run the BT client on the ICS gateway. \r\nClients running on the other computers will be unconnectable \r\n(they will be listed as such, as explained elsewhere in the FAQ) \r\nunless you specify the appropriate services in your ICS configuration \r\n(a good explanation of how to do this for Windows XP can be found here). \r\n\r\nIn the NAT case you should configure different ranges for clients\r\non different computers and create appropriate NAT rules in the router. \r\n(Details vary widely from router to router and are outside the scope of this FAQ. \r\nCheck your router documentation and/or support forum.)\r\n\r\n\r\n\r\n2. There are multiple torrents.empornium.me users in the LAN\r\n\r\nAt present there is no way of making this setup\r\nalways work properly with torrents.empornium.me. \r\nEach torrent will be associated with the user who last accessed the site\r\n from within the LAN before the torrent was started. \r\n\r\nUnless there is cooperation between the users mixing of statistics is possible.\r\n(User A accesses the site, downloads a .torrent file, \r\nbut does not start the torrent immediately. \r\n\r\nMeanwhile, user B accesses the site. \r\nUser A then starts the torrent. \r\nThe torrent will count towards user B''s statistics, not user A''s.)\r\n\r\nIt is your LAN, the responsibility is yours. \r\nDo not ask us to ban other users with the same IP, we will not do that. \r\n(Why should we ban him instead of you?)\r\n\r\n\r\n[/spoiler]\r\n\r\n\r\n\r\n[size=4][font=Arial Black]Downloading:[/font][/size]\r\n\r\n\r\nHow can I improve my download speed?[spoiler]\r\n1.Do not immediately jump on new torrents\r\nWait until the seeder/leecher ratio improves a bit.\r\n\r\n2.Make yourself connectable\r\nMany have connectability issues that affects their upload/download speed and stats.\r\n\r\n3.Limit your upload speed\r\nLimit your upload speed\r\n\r\nThe upload speed affects the download speed in essentially two ways:\r\n\r\n    Bittorrent peers tend to favour those other peers that upload to them. This means that if A and B are leeching the same torrent and A is sending data to B at high speed then B will try to reciprocate. So due to this effect high upload speeds lead to high download speeds.\r\n    Due to the way TCP works, when A is downloading something from B it has to keep telling B that it received the data sent to him. (These are called acknowledgements - ACKs -, a sort of "got it!" messages). If A fails to do this then B will stop sending data and wait. If A is uploading at full speed there may be no bandwidth left for the ACKs and they will be delayed. So due to this effect excessively high upload speeds lead to low download speeds.\r\n\r\nThe full effect is a combination of the two. The upload should be kept as high as possible while allowing the ACKs to get through without delay. A good thumb rule is keeping the upload at about 80% of the theoretical upload speed. You will have to fine tune yours to find out what works best for you. (Remember that keeping the upload high has the additional benefit of helping with your ratio.)\r\n\r\nIf you are running more than one instance of a client it is the overall upload speed that you must take into account. Some clients limit global upload speed, others do it on a per torrent basis. Know your client. The same applies if you are using your connection for anything else (e.g. browsing or ftp), always think of the overall upload speed.\r\n\r\n4.Limit the number of simultaneous connections\r\nSome operating systems (like Windows 9x) do not deal well with a large number of connections, and may even crash. Also some home routers (particularly when running NAT and/or firewall with stateful inspection services) tend to become slow or crash when having to deal with too many connections. There are no fixed values for this, you may try 60 or 100 and experiment with the value. Note that these numbers are additive, if you have two instances of a client running the numbers add up.\r\n\r\n5.Limit the number of simultaneous uploads\r\nIsn''t this the same as above? No. Connections limit the number of peers your client is talking to and/or downloading from. Uploads limit the number of peers your client is actually uploading to. The ideal number is typically much lower than the number of connections, and highly dependent on your (physical) connection.\r\n\r\n\r\n6.Just give it some time\r\nAs explained above peers favour other peers that upload to them. When you start leeching a new torrent you have nothing to offer to other peers and they will tend to ignore you. This makes the starts slow, in particular if, by change, the peers you are connected to include few or no seeders. The download speed should increase as soon as you have some pieces to share.\r\n[/spoiler]\r\n\r\nWhy can''t I connect? Is the site blocking me?[spoiler]The tracker has determined that you are firewalled or NATed and cannot accept incoming connections.\r\n\r\nThis means that other peers in the swarm will be unable to connect to you, only you to them. Even worse, if two peers are both in this state they will not be able to connect at all. This has obviously a detrimental effect on the overall speed.\r\n\r\nThe way to solve the problem involves opening the ports used for incoming connections (the same range you defined in your client) on the firewall and/or configuring your NAT server to use a basic form of NAT for that range instead of NAPT (the actual process differs widely between different router models. Check your router documentation and/or support forum. You will also find lots of information on the subject at http://portforward.com/\r\n[/spoiler]\r\n\r\nMy ISP uses a transparent proxy. What should I do?[spoiler]\r\nCaveat: This is a large and complex topic. It is not possible to cover all variations here.\r\n\r\nShort reply: change to an ISP that does not force a proxy upon you. If you cannot or do not want to then read on.\r\n\r\nWhat is a proxy?\r\n\r\nBasically a middleman. When you are browsing a site through a proxy your requests are sent to the proxy and the proxy forwards them to the site instead of you connecting directly to the site. There are several classifications (the terminology is far from standard):\r\n\r\nTransparent   A transparent proxy is one that needs no configuration on the clients. It works by automatically redirecting all port 80 traffic to the proxy. (Sometimes used as synonymous for non-anonymous.)\r\nExplicit/Voluntary   Clients must configure their browsers to use them.\r\nAnonymous   The proxy sends no client identification to the server. (HTTP_X_FORWARDED_FOR header is not sent; the server does not see your IP.)\r\nHighly Anonymous   The proxy sends no client nor proxy identification to the server. (HTTP_X_FORWARDED_FOR, HTTP_VIA and HTTP_PROXY_CONNECTION headers are not sent; the server doesn''t see your IP and doesn''t even know you''re using a proxy.)\r\nPublic   (Self explanatory)\r\n\r\nA transparent proxy may or may not be anonymous, and there are several levels of anonymity.\r\n\r\n\r\nHow do I find out if I''m behind a (transparent/anonymous) proxy?\r\n\r\nTry ProxyJudge. It lists the HTTP headers that the server where it is running received from you. The relevant ones are HTTP_CLIENT_IP, HTTP_X_FORWARDED_FOR and REMOTE_ADDR.\r\n\r\n\r\nWhy am I listed as not connectable even though I''m not NAT/Firewalled?\r\n\r\nThe torrents.empornium.me tracker is quite smart at finding your real IP, but it does need the proxy to send the HTTP header HTTP_X_FORWARDED_FOR. If your ISP''s proxy does not then what happens is that the tracker will interpret the proxy''s IP address as the client''s IP address. So when you login and the tracker tries to connect to your client to see if you are NAT/firewalled it will actually try to connect to the proxy on the port your client reports to be using for incoming connections. Naturally the proxy will not be listening on that port, the connection will fail and the tracker will think you are NAT/firewalled.\r\n\r\n\r\nCan I bypass my ISP''s proxy?\r\n\r\nIf your ISP only allows HTTP traffic through port 80 or blocks the usual proxy ports then you would need to use something like socks and that is outside the scope of this FAQ.\r\n\r\nThe site accepts connections on port 81 besides the usual 80, and using them may be enough to fool some proxies. So the first thing to try should be connecting to http://torrents.empornium.me:81. Note that even if this works your bt client will still try to connect to port 80 unless you edit the announce url in the .torrent file.\r\n\r\nOtherwise you may try the following:\r\n\r\n   Choose any public non-anonymous proxy that does not use port 80 (e.g. from this, this or this list).\r\n   Configure your computer to use that proxy. For Windows XP, do Start, Control Panel, Internet Options, Connections, LAN Settings, Use a Proxy server, Advanced and type in the IP and port of your chosen proxy. Or from Internet Explorer use Tools, Internet Options, ...\r\n   (Facultative) Visit ProxyJudge. If you see an HTTP_X_FORWARDED_FOR in the list followed by your IP then everything should be ok, otherwise choose another proxy and try again.\r\n   Visit torrents.empornium.me. Hopefully the tracker will now pickup your real IP (check your profile to make sure).\r\n\r\n\r\nNotice that now you will be doing all your browsing through a public proxy, which are typically quite slow. Communications between peers do not use port 80 so their speed will not be affected by this, and should be better than when you were "unconnectable".\r\n\r\n\r\nHow do I make my bittorrent client use a proxy?\r\n\r\nJust configure Windows XP as above. When you configure a proxy for Internet Explorer you''re actually configuring a proxy for all HTTP traffic (thank Microsoft and their "IE as part of the OS policy" ). On the other hand if you use another browser (Opera/Mozilla/Firefox) and configure a proxy there you''ll be configuring a proxy just for that browser. We don''t know of any BT client that allows a proxy to be specified explicitly.\r\n\r\n\r\nWhy can''t I signup from behind a proxy?\r\nIt is our policy not to allow new accounts to be opened from behind a proxy.\r\n\r\n\r\nDoes this apply to other torrent sites?\r\n\r\nThis section was written for torrents.empornium.me, a closed, port 80-81 tracker. Other trackers may be open or closed, and many listen on e.g. ports 6868 or 6969. The above does not necessarily apply to other trackers.[/spoiler]\r\n\r\n\r\nWhy can''t I connect? Is the site blocking me?[spoiler]\r\n\r\nFirst of all don''t assume you are connectable.\r\n \r\nMany people assume they are connectable, because they are successfully torrenting. That however is not always the case.\r\n \r\nWhat does it mean to be connectable?\r\n \r\nBeing connectable means other peers in the swarm can make connections to you, you can make connections to other peers without being connectable your self, if the other peers in your swarm are good enough torrent citizens to be connectable.\r\n \r\n\r\nWhy does it matter?\r\n \r\nWell, Many private trackers restrict people who aren''t connectable, and even on some sites no seed bonuses are credited to people who aren''t. most importantly people who aren''t connectable hurt the swarm. Each peer that isn''t connectable is limited to sharing with only peers who are connectable. If the number of peers who aren''t connectable is low the result is unnoticeable, But the higher the percentage goes the slower the swarm becomes until it dies at the point when all peers are unconnectable. There''s no one left to connect to.\r\n \r\n\r\nWhy am I unconnectable? Well maybe...\r\n \r\n -Lack of proper port forwarding.\r\n -TURN OFF DHT, PEER EXCHANGE, LOCAL PEER DISCOVERY\r\n -Bandwidth oversaturation, incoming or outgoing.\r\n -Too many torrents started at once.\r\n -Too many connections per torrent, or total.\r\n -ISP blocking chosen port\r\n -Router not P2P friendly\r\n -ISP modem contains router features\r\n -ISP proxying or firewalling your connection\r\n \r\n\r\nWhat can I do about it?\r\n \r\nSometimes nothing. for instance if your ISP has you behind a proxy server that blocks incoming requests. If their only blocking certain ports you can change the port you use, and if their throttling (this has nothing to do with becoming connectable.) you could use uTorrent or \r\nAzureus and enable encryption. It may be that you are trying to torrent from a place of business with routers, proxy servers, firewalls, and/or traffic shaping software, or appliances like websense. If your even lucky enough to get a torrent running at all, but being connectable is out of the question.However, most cases being connectable is fun, easy and can be done without spending any money at all.\r\n \r\n\r\nFirst, make sure any anti-virus software you use isn''t blocking any ports you use for torrenting\r\n \r\nSecond, set your firewall to give full access to your torrent program, don''t block it in any way.\r\n \r\nThird, set your bandwidth limits in your torrent software, if you let it use all your bandwidth to share information with your peers there may not be enough to browse the internet or communicate with the tracker. Not being able to communicate with the tracker in a timely fashion may cause the tracker to list you as unconnectable when you are in fact connectable. Run a speed test at Speedtest.net - The Global Broadband Speed Test to find your up and down speeds, set your client for around 80% outgoing and 90% to 95% incoming. These numbers aren''t set in stone so feel free to play a little but make sure you are connectable first and be prepared to change them back if you run into problems.\r\n \r\nFourth, Don''t shutdown or start your software with a lot of torrents running. whats a lot? I think 3 would be OK, but 10 is out. The point is shut down and start your torrents individually or groups of 2 or 3 with a pause between, and if you shutdown your computer wait for your start up programs to finish before starting your torrents back up.\r\n \r\nFifth, limit the number of connections per torrent and total connections. defaults will usually work but maybe shrink it down more if your still showing up unconnectable.\r\n \r\nSixth, make sure your modem doesnt have routing features. Some newer modems have features but are not heavily configurable so the easiest thing to do is to turn these features off if possable.\r\n \r\nSeventh, Your router may just not be good at handling P2P protocalls like bitorrent which require many connections made over a short time. \r\n\r\nAll routers have a limited number of connections they can handle being open at any one time, some leave connections open for too long, most notably LINKSYS WRT54G/GL/GS routers. There are fixes for this but it involves upgrading to beta or possibly third-party firmware, which always carries risks. If you think this applies to you follow the faq on uTorrent''s or whatever client you are using site but proceed with the utmost caution.\r\n \r\nEighth, Try using ports between 65,000 and 65,500 this works better for most people, and do not use software like PeerGuardian2. TURN OFF DHT, PEER EXCHANGE, and LOCAL PEER DISCOVERY\r\n \r\nFinally, and this can be the hardest part for most people, follow one of many very good guides concerning port forwarding.Port Forwarding Guides Listed by Manufacturer and Model - PortForward.com is a good place to start.\r\n \r\n1. Setup your computer to a static ip there are very good guides for this at portforward select your operating system and follow the guide.\r\n \r\n2. Next you need to setup your router to forward the correct ports to your computer. A step by step guide for just about every router is located at PortForward''s Other Guides - PortForward.com , scroll down and select port forwarding guides by router. Just select your router, and \r\nthen click on your bit-torrent client for specific steps on how to correctly configure your setup. Remember to use the IP address you assigned your computer in step one. Also, the port number can be almost anything you want, but I suggest using something over 50,000. \r\n\r\n3. If you run a firewall you''ll need to set it up to allow the correct traffic. go to Port Forwarding Guides Listed by Manufacturer and Model - PortForward.com select the firewall you have and follow the steps.\r\n \r\n4. Once you''ve set up all of that, make sure your client is running, then go to Open Port Check Tool\r\nenter in the port you''re using.This page will tell you whether your port is open, stealthed, or closed.If it is open, then you should be Connectable.\r\n \r\nWhats the reason for all this?\r\n \r\nWhy have your computer set to a static IP?\r\n\r\nOn networks where DCHP (Dynamic Host Configuration Protocol) is running you get an IP address issued automatically when you connect.In theory this is great but until you connect you donâ€™t know what this IP address will be. Most routers have a set range of IP addresses to use \r\nbut how these are issued depends on the make/model of the router.So if you set up port forwarding for the IP currently issued to your PC today, will it work tomorrow or even after a reboot? Maybe but if the PC gets issued a different IP address your PC will never see the data on the ports you forwarded.How can you be sure of always having the port forwarded to the right computer port â€“ simple set up a static IP address. That way every timethe computer restarts it will be the same IP address and the port forwarding will work perfectly.\r\n \r\nWhy be connectable (or what happens when you are not?)\r\n \r\nA 1gig torrent is uploaded. The uploader starts seeding. 9 leechers jump on to the torrent. The torrent is going very slow. He has already seeded 5GB but no one has completed. Turns out they are all unconnectable. This means that the uploader needs to send 1gig of data to each of them. If he stops seeding before they have completed the torrent it will dry up and no more data will be transferred.\r\n \r\nAnother example:\r\n\r\nYou find the torrent. There''s 10 seeders. You''re hopeful for good speeds. Your PC starts looking for bits. The speed is slow and you only seem to be connecting to 1 seeder.... WTH!!! Well if 9 are not connectable this means you''ll not be able to leech very much from them and at very slow speeds. \r\n\r\nThe essence of this guide is not to get you individually faster download speeds but the reverse; faster upload speeds. The more people that are directed to this guide and follow it properly the faster the swarm will become which means faster download speeds for everyone.\r\n \r\n\r\n****this may not pertain to everyone but when setting up the router i had 3 different settings to choose from for my forwarding service; TCP or UDP or BOTH but when setting the firewall i had to set 2 exceptions 1 for each so i back tracked and setup my router with 2 services as well. Also i found a setting on the WAN settings page for the router to accept ping''s from the internet....\r\n \r\nThe reason for this when i finished setting the router i downloaded the port checker available at portforward and ran the test but couldnt get both TCP and UDP to work and i couldnt ping my router.\r\n\r\nYour failure to connect may be due to several reasons.\r\n\r\n\r\nMaybe my address is blacklisted?\r\n\r\nThe site blocks addresses listed in the (former) PeerGuardian database, as well as addresses of banned users. This works at Apache/PHP level, it''s just a script that blocks logins from those addresses. It should not stop you from reaching the site. In particular it does not block lower level protocols, you should be able to ping/traceroute the server even if your address is blacklisted. If you cannot then the reason for the problem lies elsewhere.\r\n\r\nIf somehow your address is indeed blocked in the PG database do not contact us about it, it is not our policy to open ad hoc exceptions. You should clear your IP with the database maintainers instead.\r\n\r\n\r\nYour ISP blocks the site''s address\r\n\r\n(In first place, it''s unlikely your ISP is doing so. DNS name resolution and/or network problems are the usual culprits.)\r\nThere''s nothing we can do. You should contact your ISP (or get a new one). Note that you can still visit the site via a proxy, follow the instructions in the relevant section. In this case it doesn''t matter if the proxy is anonymous or not, or which port it listens to.\r\n\r\nNotice that you will always be listed as an "unconnectable" client because the tracker will be unable to check that you''re capable of accepting incoming connections.\r\n\r\n\r\nAlternate port (81)\r\n\r\nSome of our torrents use ports other than the usual HTTP port 80. This may cause problems for some users, for instance those behind some firewall or proxy configurations. You can easily solve this by editing the .torrent file yourself with any torrent editor, e.g. MakeTorrent, and replacing the announce url http://torrents.empornium.me:81 with torrents.empornium.me:80 or just torrents.empornium.me.\r\n\r\nEditing the .torrent with Notepad is not recommended. It may look like a text file, but it is in fact a bencoded file. If for some reason you must use a plain text editor, change the announce url to torrents.empornium.me:80, not torrents.empornium.me. (If you''re thinking about changing the number before the announce url instead, you know too much to be reading this.)[/spoiler]\r\n\r\nTroubleshooting your connection.[spoiler]\r\nIf you are having problems connecting,\r\n please try the following steps one at a time and then attempt to connect again,\r\n as each step has the potential of solving the connection issue.\r\nFirst of all: Make sure you arent using a bad client.Check the [url=http://www.emporniumforums.com/viewtopic.php?f=91&t=1091]Faq![/url]\r\n\r\n\r\n1. Refresh your connection\r\n\r\nRenewing your IP address and flushing your DNS cache\r\n can often help resolve connection issues.\r\n\r\nFor Windows:\r\n\r\n    Click Start then Run\r\n    Type cmd in the run box and press Enter (a Command Console window should appear)\r\n    In the Command Console window, type ipconfig /release and press Enter\r\n    Wait for a few seconds for a reply that the IP address has been released\r\n    In the Command Console window, type ipconfig /renew and press Enter\r\n    Wait for a few seconds for a reply that the IP address has been re-established\r\n    In the Command Console window, type ipconfig /flushdns and press Enter\r\n    Close the Command Console window and attempt to play the game\r\n\r\nIf you are using Windows Vista or 7, you will need to load the Command Console differently:\r\n\r\n    Go to Start, then Programs, then Accessories and locate Command Prompt\r\n    Right-click on Command Prompt and select Run as Administrator from the drop down menu\r\n    Now continue from Step 3 of the Windows instructions above\r\n\r\n\r\nFor Macintosh Apple OS-X:\r\n\r\n    Click Apple, then System Preferences, then Network and finally Network Status\r\n    Select Built-in Ethernet from the Network Status menu and click Configure\r\n    Click Renew DHCP Lease (this process may take a few minutes)\r\n    Close the Network Status window\r\n    Open the Terminal\r\n\r\n    If using Mac OS X 10.5.8 or 10.6.x, type dscacheutil -flushcache\r\n\r\n\r\n2. Resetting your modem and/or router\r\n\r\nIf the connection difficulties persist, please Power Cycle your modem and router to reset them and allow them to re-establish a connection to your ISP. \r\nPlease follow these steps to completely power cycle the devices in your network connection:\r\n\r\n    Shut down all computers connected to the modem/router\r\n    Power down/unplug the router if you use one\r\n    Power down/unplug the modem\r\n    Allow to sit for 60 seconds, unplugged\r\n    Turn on the modem, allow to completely boot up till the front panel connection lights show a steady connection\r\n    Turn on the router, if you have one, and allow to completely boot up as well\r\n    Start the computer and allow to completely boot up\r\n\r\n\r\n3. Check that there are no issues with the tracker\r\n\r\nCheck the forums, if there are any known issues with the tracker,\r\nyou can often find more information here.\r\n\r\n\r\n4. Firewalls, routers, and internet connection sharing\r\n\r\nWhatever client you''re using, find out what listening port you''re client is using and visit http://portforward.com/\r\nand make sure your home network is forwarding ports\r\ncorrectly from your router to your computer.\r\n\r\n\r\nYour firewall can block ports - try disabling your own firewall\r\n and using the windows firewall to test whether or not this is the problem"\r\n\r\n\r\nIf you are using any type of firewall, router, or you are sharing your internet connection between multiple computers, you may need to set your system up to allow access to the tracker.\r\n\r\nThe firewall or router will need to allow unrestricted communication on TCP ports 6881-6889. You may find assistance in configuring your firewall and/or router in Brian''s BitTorrent FAQ and Guide http://btfaq.com/serve/cache\r\n\r\nIf possible, try uninstalling any firewall applications on your computer, and physically removing the router from your internet connection (by having your computer connect directly to your modem). This will allow you to identify whether the firewall or router is responsible for the connection problem. If this turns out to be the case, please consult the documentation that came with that networking product, or contact the manufacturer for further assistance setting it up properly.\r\n\r\n5. Check for updates\r\n\r\nOut-of-date drivers or operating system files can cause connection issues. Please check for the following updates:\r\n\r\nOperating System Updates:\r\n\r\n    Be sure that you have the latest updates for your operating system.\r\n Windows updates are available at http://windowsupdate.microsoft.com\r\n\r\n    Mac OS X updates can be obtained by clicking on the Apple icon\r\n and choosing Software Update...\r\n\r\n\r\nBroadband users:\r\n\r\nThere are several drivers that, if out-of-date, could cause issues for broadband users. If you need more help in locating drivers for your hardware, please contact the hardware manufacturer or a qualified technician. If you access the internet through an external broadband modem, be sure you have the latest firmware and drivers available for your modem. If your computer connects to the modem via USB, be sure you have the latest drivers for your motherboard or your USB PCI card. If your computer connects to the modem via Ethernet, be sure that your network card has the latest drivers installed.\r\n\r\nPort Forward Tutorial:\r\n\r\n[img]http://hostingb.hotchyx.com/adult-image-hosting-03/1306PF-guide.gif[/img]\r\n\r\nyes, we know it speaks of ptna, but the info is still valid...\r\n\r\nhttp://portforward.com/\r\n\r\n\r\n[u]What if I can''t find the answer to my problem here?[/u]\r\n\r\n[spoiler]\r\nPost in the Forums, by all means.\r\nYou''ll find they are usually a friendly and helpful place,\r\nprovided you follow a few basic guidelines:\r\n\r\nMake sure your problem is not really in this FAQ.\r\nThere''s no point in posting just to be sent back here.\r\n\r\nBefore posting read the sticky topics (the ones at the top).\r\nMany times new information that still hasn''t been incorporated in the FAQ can be found there.\r\n\r\nHelp us in helping you.\r\nDo not just say ''it doesn''t work!''.\r\n\r\nProvide details so that we don''t have to guess or waste time asking.\r\nWhat client do you use? What''s your OS? What''s your network setup?\r\nWhat''s the exact error message you get, if any?\r\nWhat are the torrents you are having problems with?\r\n\r\nThe more you tell the easiest it will be for us,\r\nand the more probable your post will get a reply.\r\nAnd needless to say: be polite. Demanding help rarely works, asking for it usually does the trick.\r\n\r\nLinks:\r\n\r\nI have a suggestion-where do i put it?\r\nIn the - Suggestion forum.Be polite.\r\n\r\nI couldnt find the answer to my question here.\r\nUse the - Help and Support Forum -make sure your question havent been asked there before.[/spoiler]\r\n', '2012-06-08 21:10:19'),
(31, 0, 'forum_guidelines', 'General Forum Guidelines', 'These are the general forum guidelines', '[color=#0261a3][size=5][font=Arial Black]GENERAL FORUM GUIDELINES[/font][/size][/color]\r\n\r\n\r\n\r\n[b]Please follow these guidelines or else you might end up with a warning![/b]\r\n\r\nNo aggressive behaviour or flaming in the forums.(Trial exception- FUCK YOU FORUM Topic)\r\n\r\nDO NOT trash other members topics (i.e. SPAM)\r\n\r\nDO NOT post links to warez or crack sites in the forums\r\n\r\nNo double posting. If your post is the last in a thread and you wish to post again, use the EDIT function or you will have to wait until someone else posts in that thread.\r\n\r\nPlease make sure you read the [b][url=http://trackerdev.mooo.com/articles.php?topic=faq]FAQ[/url][/b] before asking any questions!\r\n\r\nThe Off-Topic forum is less Moderated than any other place and is the place to whore it up!  But keep it civil.\r\n\r\nAny requests you make in the ''request forum'' may only be bumped once a week. Please be patient.\r\n\r\nAny current site issues or upgrades are always posted here. HERE\r\n\r\nRatio cheaters are not welcome here and the Staff will find you and ban you! \r\n\r\n', '2012-06-09 06:37:06'),
(38, 1, 'connchecker', 'Connectability Checker', 'How to use the Connectability Checker to check you are connectable through your torrent client', 'The Connectability Checker is used to check you are connectable through your torrent client.\r\n\r\nYou must enter your external IP address and the port you are [b]currently connected[/b] on with your torrent client.\r\n\r\n\r\n[imsert images of how to find the port you are using with various torrent clients.]', '2012-06-03 23:22:17');
INSERT INTO `articles` (`ID`, `Category`, `TopicID`, `Title`, `Description`, `Body`, `Time`) VALUES
(39, 0, 'getting out of troub', 'Getting Out Of Trouble', 'These are suggestions for getting out of trouble.', '[color=#0261a3][size=5][font=Arial Black]GETTING OUT OF TROUBLE[/font][/size][/color]\r\n\r\n\r\n[b]Here are some ways for you to get yourself out of ratio trouble.[/b]\r\n\r\nIf you have dug yourself into a hole and wish to better yourself by addressing your ratio, then check out the ''begging thread'' at the forums and MAYBE someone in our community will take pity on you. Some of the generous pervs might want to give you a second chance by using his/her bonus credits to buy away some of your download amount or give you some credits if you ask nicely. [b]Click Here[/b]\r\n\r\n Do not ask for help if you have enough bonus credits to buy yourself off the limiter.\r\n\r\n\r\n\r\n\r\n[color=#0261a3][size=3][font=Arial Black]CONTESTS[/font][/size][/color]\r\n\r\n\r\n There are also various contests in the forums that give away credits. Perhaps you should check them out if you are in ratio trouble.  [b]Click Here[/b] \r\n\r\n\r\n\r\n\r\n[color=#0261a3][size=3][font=Arial Black]DONATIONS[/font][/size][/color]\r\n\r\n\r\n Donating to the site is also a quick way to fix and improve your ratio, if you are flush of course.  [b]Click Here[/b]\r\n\r\n\r\n\r\n\r\n[color=#0261a3][size=3][font=Arial Black]UPLOADING[/font][/size][/color]\r\n\r\n\r\nIf all else fails, you can always upload something of your own to build ratio and dig yourself out of the hole you have dug.\r\n\r\nCheck the [b][url=http://trackerdev.mooo.com/articles.php?topic=upload]UPLOADING RULES[/url][/b] here for more information.\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n', '2012-06-07 17:40:39');


-- --------------------------------------------------------

--
-- Tabellstruktur `bad_passwords`
--

CREATE TABLE IF NOT EXISTS `bad_passwords` (
  `Password` char(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `badges`
--

CREATE TABLE IF NOT EXISTS `badges` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `Badge` varchar( 12 ) NOT NULL,
  `Rank` int(10) NOT NULL,
  `Type` enum('Shop','Single','Multiple','Unique') NOT NULL,
  `Display` INT( 3 ) NOT NULL DEFAULT '0',
  `Sort` int(10) NOT NULL,
  `Cost` int(20) NOT NULL DEFAULT '0',
  `Title` varchar(64) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Image` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Badge` (`Badge`),
  KEY `Rank` (`Rank`),
  KEY `Type` (`Type`),
  KEY `Display` (`Display`),
  KEY `Sort` (`Sort`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



-- --------------------------------------------------------

--
-- Table structure for table `badges_auto`
--

CREATE TABLE IF NOT EXISTS `badges_auto` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `BadgeID` int(10) NOT NULL,
  `Action` enum('NumPosts','NumComments','NumUploaded','NumNewTags','NumTags','NumTagVotes','RequestsFilled','UploadedTB','DownloadedTB','MaxSnatches') NOT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '0',
  `SendPM` tinyint(1) NOT NULL,
  `Value` int(10) NOT NULL,
  `CategoryID` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `Action` (`Action`),
  KEY `Active` (`Active`),
  KEY `BadgeID` (`BadgeID`),
  KEY `SendPM` (`SendPM`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Tabellstruktur `blog`
--

CREATE TABLE IF NOT EXISTS `blog` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `UserID` int(10) unsigned NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Body` text NOT NULL,
  `Time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ThreadID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `UserID` (`UserID`),
  KEY `Time` (`Time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `bonus_shop_actions`
--

CREATE TABLE IF NOT EXISTS `bonus_shop_actions` (
  `ID` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `Title` varchar(256) NOT NULL,
  `Description` varchar(1024) NOT NULL,
  `Action` enum('gb','givegb','givecredits','slot','title','badge') NOT NULL,
  `Value` int(10) NOT NULL DEFAULT '0',
  `Cost` int(9) unsigned NOT NULL,
  `Sort` int(6) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Sort` (`Sort`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `bonus_shop_actions`
--

INSERT INTO `bonus_shop_actions` (`ID`, `Title`, `Description`, `Action`, `Value`, `Cost`, `Sort`) VALUES
(1, 'Give Away 500 Credits', 'If you have more credit than you could possibly have a use for, then why not share it with a friend? Give away 500 credits.', 'givecredits', 500, 600, 3),
(2, 'Give Away 2000 Credits', 'If you have more credit than you could possibly have a use for, then why not share it with a friend? Give away 2000 credits.', 'givecredits', 2000, 2200, 4),
(3, 'Give away 5000 credits', 'If you have more credit than you could possibly have a use for, then why not share it with a friend? Give away 5000 credits.', 'givecredits', 5000, 5500, 6),
(4, '-1 GB', 'Do you have a bad ratio? Here you can improve it dramatically by buying 1GB away from what you''ve downloaded!', 'gb', 1, 1000, 10),
(5, '-5GB', 'Do you have a bad ratio? Here you can improve it dramatically by buying 5GB away from what you''ve downloaded!', 'gb', 5, 4500, 12),
(6, '-10GB', 'Do you have a bad ratio? Here you can improve it dramatically by buying 10GB away from what you''ve downloaded!', 'gb', 10, 8000, 18),
(7, '-1GB to other', 'Do you know a friend or perhaps someone else who has a shitty ratio? Here you can give someone a happy surprise by taking away 1GB from the person''s downloaded traffic!', 'givegb', 1, 1100, 20),
(8, '-5GB to other', 'Do you know a friend or perhaps someone else who has a shitty ratio? Here you can give someone a happy surprise by taking away 5GB from the person''s downloaded traffic!', 'givegb', 5, 4750, 22),
(9, '-10 GB to other', 'Do you know a friend or perhaps someone else who has a shitty ratio? Here you can give someone a happy surprise by taking away 10GB from the person''s downloaded traffic!', 'givegb', 10, 8500, 25),
(10, '1 Slot', 'A slot will give you the option to either freeleech or doubleseed a torrent. Freeleech will allow you to download the torrent without counting the downloaded amount, while doubleseed will count the uploaded amount times 2.', 'slot', 1, 11000, 30),
(11, '2 Slots', 'A slot will give you the option to either freeleech or doubleseed a torrent. Freeleech will allow you to download the torrent without counting the downloaded amount, while doubleseed will count the uploaded amount times 2.', 'slot', 2, 21000, 31),
(12, 'Custom Title', 'A super seeder like you deserves a custom title on the tracker!', 'title', 1, 20000, 50);


-- --------------------------------------------------------

--
-- Tabellstruktur `bookmarks_collages`
--

CREATE TABLE IF NOT EXISTS `bookmarks_collages` (
  `UserID` int(10) NOT NULL,
  `CollageID` int(10) NOT NULL,
  `Time` datetime NOT NULL,
  KEY `UserID` (`UserID`),
  KEY `CollageID` (`CollageID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `bookmarks_requests`
--

CREATE TABLE IF NOT EXISTS `bookmarks_requests` (
  `UserID` int(10) NOT NULL,
  `RequestID` int(10) NOT NULL,
  `Time` datetime NOT NULL,
  KEY `UserID` (`UserID`),
  KEY `RequestID` (`RequestID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `bookmarks_torrents`
--

CREATE TABLE IF NOT EXISTS `bookmarks_torrents` (
  `UserID` int(10) NOT NULL,
  `GroupID` int(10) NOT NULL,
  `Time` datetime NOT NULL,
  KEY `UserID` (`UserID`),
  KEY `GroupID` (`GroupID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tag` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No Description',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=56 ;

--
-- Dumpning av Data i tabell `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `tag`) VALUES
(1, 'Amateur', 'cat_amateur.png', 'amature'),
(2, 'Anal', 'cat_anal.png', 'anal'),
(3, 'Hentai / 3D', 'cat_animated_3d.jpg', 'hentai'),
(5, 'Asian', 'cat_asian.png', 'asian'),
(6, 'BBW', 'cat_bbw.png', 'bbw'),
(7, 'Black', 'cat_black.png', 'black'),
(8, 'Big Tits', 'cat_bigboobs.png', 'big.tits'),
(9, 'Classic', 'cat_classic.png', 'classic'),
(10, 'Cumshot', 'cat_cumshot.png', 'cumshot'),
(11, 'DVD-R', 'cat_dvd_r.png', 'dvdr'),
(12, 'Fetish', 'cat_fetish.png', 'fetish'),
(13, 'XXX Games / Apps', 'cat_xxxgames.png', 'games.apps'),
(14, 'Gang Bang / Orgy', 'cat_gangbang.png', 'gangbang'),
(15, 'Shemale / TS', 'cat_shemale.png', 'shemale'),
(16, 'Latina', 'cat_latina.png', 'latina'),
(17, 'Oral', 'cat_oral.png', 'oral'),
(18, 'Masturbation', 'cat_masturbation.png', 'masturbation'),
(19, 'Teen', 'cat_teen.png', 'teen'),
(20, 'Softcore', 'cat_softcore.png', 'softcore'),
(21, 'Pictures / Images', 'cat_pictures.jpg', 'images'),
(22, 'Siterip', 'cat_siterip.png', 'siterip'),
(23, 'Lesbian', 'cat_lesbian.png', 'lesbian'),
(24, 'Paysite', 'cat_paysite.png', 'paysite'),
(25, 'Homemade', 'cat_homemade.png', 'homemade'),
(26, 'Mature', 'cat_mature.png', 'mature'),
(27, 'Magazines', 'cat_magazines.png', 'magazines'),
(29, 'Other', 'cat_other.png', 'other'),
(30, 'BDSM', 'cat_bdsm.png', 'bdsm'),
(34, 'Straight', 'cat_straight.png', 'straight'),
(35, 'Hardcore', 'cat_hardcore.png', 'hardcore'),
(36, 'Big Ass', 'cat_big_ass.png', 'big.ass'),
(37, 'Creampie', 'cat_creampie.png', 'creampie'),
(39, 'Gay / Bi', 'cat_gay.png', 'gay'),
(40, 'Megapack', 'cat_megapack.png', 'mega.pack'),
(41, 'Natural Tits', 'cat_naturalboobs.png', 'natural.tits'),
(43, 'Interracial', 'cat_interracial.png', 'interracial'),
(44, 'HD Porn', 'cat_hd.jpg', 'hd'),
(45, 'Voyeur', 'cat_Voyeur.png', 'voyeur'),
(46, 'Pregnant / Preggo', 'cat_pregnant.jpg', 'pregnant'),
(47, 'Parody', 'cat_parody.png', 'parody'),
(49, 'Squirt', 'cat_squirt.png', 'squirting'),
(50, 'Piss', 'cat_piss.png', 'piss'),
(51, 'Scat/Puke', 'cat_scatpuke.png', 'scat'),
(52, 'Lingerie', 'cat_lingerie.png', 'lingerie'),
(53, 'Manga / Comic', 'cat_mangacomic.png', 'manga'),
(55, 'Porn Music Videos', 'cat_misc.gif', 'music.videos');

-- --------------------------------------------------------

--
-- Tabellstruktur `collages`
--

CREATE TABLE IF NOT EXISTS `collages` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL DEFAULT '',
  `Description` text NOT NULL,
  `UserID` int(10) NOT NULL DEFAULT '0',
  `Permissions` INT(4) NOT NULL DEFAULT '0', 
  `NumTorrents` int(4) NOT NULL DEFAULT '0',
  `Deleted` enum('0','1') DEFAULT '0',
  `Locked` enum('0','1') NOT NULL DEFAULT '0',
  `CategoryID` int(2) NOT NULL DEFAULT '1',
  `TagList` varchar(500) NOT NULL DEFAULT '',
  `MaxGroups` int(10) NOT NULL DEFAULT '0',
  `MaxGroupsPerUser` int(10) NOT NULL DEFAULT '0',
  `Featured` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Name` (`Name`),
  KEY `UserID` (`UserID`),
  KEY `CategoryID` (`CategoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `collages_comments`
--

CREATE TABLE IF NOT EXISTS `collages_comments` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `CollageID` int(10) NOT NULL,
  `Body` mediumtext NOT NULL,
  `UserID` int(10) NOT NULL DEFAULT '0',
  `Time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `CollageID` (`CollageID`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `collages_torrents`
--

CREATE TABLE IF NOT EXISTS `collages_torrents` (
  `CollageID` int(10) NOT NULL,
  `GroupID` int(10) NOT NULL,
  `UserID` int(10) NOT NULL,
  `Sort` int(10) NOT NULL DEFAULT '0',
  `AddedOn` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`CollageID`,`GroupID`),
  KEY `UserID` (`UserID`),
  KEY `Sort` (`Sort`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `comments_edits`
--

CREATE TABLE IF NOT EXISTS `comments_edits` (
  `Page` enum('forums','collages','requests','torrents') DEFAULT NULL,
  `PostID` int(10) DEFAULT NULL,
  `EditUser` int(10) DEFAULT NULL,
  `EditTime` datetime DEFAULT NULL,
  `Body` mediumtext,
  KEY `Page` (`Page`,`PostID`),
  KEY `EditUser` (`EditUser`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `donations`
--

CREATE TABLE IF NOT EXISTS `donations` (
  `UserID` int(10) NOT NULL,
  `Amount` decimal(6,2) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Time` datetime NOT NULL,
  `Currency` varchar(5) NOT NULL DEFAULT 'USD',
  KEY `UserID` (`UserID`),
  KEY `Time` (`Time`),
  KEY `Amount` (`Amount`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `do_not_upload`
--

CREATE TABLE IF NOT EXISTS `do_not_upload` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Comment` varchar(255) NOT NULL,
  `UserID` int(10) NOT NULL,
  `Time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `Time` (`Time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `drives`
--

CREATE TABLE IF NOT EXISTS `drives` (
  `DriveID` int(10) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `Offset` varchar(10) NOT NULL,
  PRIMARY KEY (`DriveID`),
  KEY `Name` (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `dupe_groups`
--

CREATE TABLE IF NOT EXISTS `dupe_groups` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Comments` text,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `email_blacklist`
--

CREATE TABLE IF NOT EXISTS `email_blacklist` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `UserID` int(10) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Time` datetime NOT NULL,
  `Comment` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `featured_albums`
--

CREATE TABLE IF NOT EXISTS `featured_albums` (
  `GroupID` int(10) NOT NULL DEFAULT '0',
  `ThreadID` int(10) NOT NULL DEFAULT '0',
  `Title` varchar(35) NOT NULL DEFAULT '',
  `Started` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Ended` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `forums`
--

CREATE TABLE IF NOT EXISTS `forums` (
  `ID` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `CategoryID` tinyint(2) NOT NULL DEFAULT '0',
  `Sort` int(6) unsigned NOT NULL,
  `Name` varchar(40) NOT NULL DEFAULT '',
  `Description` varchar(255) DEFAULT '',
  `MinClassRead` int(4) NOT NULL DEFAULT '0',
  `MinClassWrite` int(4) NOT NULL DEFAULT '0',
  `MinClassCreate` int(4) NOT NULL DEFAULT '0',
  `NumTopics` int(10) NOT NULL DEFAULT '0',
  `NumPosts` int(10) NOT NULL DEFAULT '0',
  `LastPostID` int(10) NOT NULL DEFAULT '0',
  `LastPostAuthorID` int(10) NOT NULL DEFAULT '0',
  `LastPostTopicID` int(10) NOT NULL DEFAULT '0',
  `LastPostTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `AutoLock` enum('0','1') DEFAULT '1',
  PRIMARY KEY (`ID`),
  KEY `Sort` (`Sort`),
  KEY `MinClassRead` (`MinClassRead`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `forums_categories`
--

CREATE TABLE IF NOT EXISTS `forums_categories` (
  `ID` tinyint(2) NOT NULL AUTO_INCREMENT,
  `Name` varchar(40) NOT NULL DEFAULT '',
  `Sort` int(6) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `Sort` (`Sort`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO forums_categories (ID, Sort, Name) VALUES (1,1,'Site');

INSERT INTO forums_categories (ID, Sort, Name) VALUES (5,5,'Community');

INSERT INTO forums_categories (ID, Sort, Name) VALUES (10,10,'Help');

INSERT INTO forums_categories (ID, Sort, Name) VALUES (15,15,'Trash');

-- --------------------------------------------------------

--
-- Tabellstruktur `forums_last_read_topics`
--

CREATE TABLE IF NOT EXISTS `forums_last_read_topics` (
  `UserID` int(10) NOT NULL,
  `TopicID` int(10) NOT NULL,
  `PostID` int(10) NOT NULL,
  PRIMARY KEY (`UserID`,`TopicID`),
  KEY `TopicID` (`TopicID`),
  KEY `UserID` (`UserID`),
  KEY `TopicID_2` (`TopicID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `forums_polls`
--

CREATE TABLE IF NOT EXISTS `forums_polls` (
  `TopicID` int(10) unsigned NOT NULL,
  `Question` varchar(255) NOT NULL,
  `Answers` text NOT NULL,
  `Featured` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Closed` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`TopicID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `forums_polls_votes`
--

CREATE TABLE IF NOT EXISTS `forums_polls_votes` (
  `TopicID` int(10) unsigned NOT NULL,
  `UserID` int(10) unsigned NOT NULL,
  `Vote` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`TopicID`,`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `forums_posts`
--

CREATE TABLE IF NOT EXISTS `forums_posts` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `TopicID` int(10) NOT NULL,
  `AuthorID` int(10) NOT NULL,
  `AddedTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Body` mediumtext,
  `EditedUserID` int(10) DEFAULT NULL,
  `EditedTime` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `TopicID` (`TopicID`),
  KEY `AuthorID` (`AuthorID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `forums_specific_rules`
--

CREATE TABLE IF NOT EXISTS `forums_specific_rules` (
  `ForumID` int(6) unsigned DEFAULT NULL,
  `ThreadID` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `forums_topics`
--

CREATE TABLE IF NOT EXISTS `forums_topics` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `Title` varchar(150) NOT NULL,
  `AuthorID` int(10) NOT NULL,
  `IsLocked` enum('0','1') NOT NULL DEFAULT '0',
  `IsSticky` enum('0','1') NOT NULL DEFAULT '0',
  `ForumID` int(3) NOT NULL,
  `NumPosts` int(10) NOT NULL DEFAULT '0',
  `NumViews` INT( 7 ) NOT NULL DEFAULT '0',
  `LastPostID` int(10) NOT NULL,
  `LastPostTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `LastPostAuthorID` int(10) NOT NULL,
  `StickyPostID` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `AuthorID` (`AuthorID`),
  KEY `ForumID` (`ForumID`),
  KEY `IsSticky` (`IsSticky`),
  KEY `LastPostID` (`LastPostID`),
  KEY `Title` (`Title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `UserID` int(10) unsigned NOT NULL,
  `FriendID` int(10) unsigned NOT NULL,
  `Comment` text NOT NULL,
  `Type` enum('friends','blocked') NOT NULL,
  PRIMARY KEY (`UserID`,`FriendID`),
  KEY `Type` (`Type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `geoip_country`
--

CREATE TABLE IF NOT EXISTS `geoip_country` (
  `StartIP` int(11) unsigned NOT NULL,
  `EndIP` int(11) unsigned NOT NULL,
  `Code` varchar(2) NOT NULL,
  PRIMARY KEY (`StartIP`,`EndIP`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(64) NOT NULL,
  `Comment` text NOT NULL,
  `Log` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE IF NOT EXISTS `users_groups` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `GroupID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `AddedTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `AddedBy` int(11) NOT NULL,
  `Comment` text NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `GroupID_2` (`GroupID`,`UserID`),
  KEY `GroupID` (`GroupID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;



-- --------------------------------------------------------

--
-- Tabellstruktur `group_log`
--

CREATE TABLE IF NOT EXISTS `group_log` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `GroupID` int(10) NOT NULL,
  `TorrentID` int(10) NOT NULL,
  `UserID` int(10) NOT NULL DEFAULT '0',
  `Info` mediumtext,
  `Time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Hidden` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `GroupID` (`GroupID`),
  KEY `TorrentID` (`TorrentID`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumpning av Data i tabell `group_log`
--

INSERT INTO `group_log` (`ID`, `GroupID`, `TorrentID`, `UserID`, `Info`, `Time`, `Hidden`) VALUES
(1, 11820, 14, 1243, '', '2012-03-19 10:01:39', 0),
(2, 11821, 15, 1243, 'uploaded (7.99 MB)', '2012-03-19 10:22:27', 0),
(3, 11821, 15, 1243, 'marked as freeleech type 2!', '2012-03-19 10:37:15', 0),
(4, 11821, 15, 1243, 'marked as freeleech type 0!', '2012-03-19 10:38:06', 0);


-- --------------------------------------------------------

--
-- Tabellstruktur `imagehost_whitelist`
--

CREATE TABLE IF NOT EXISTS `imagehost_whitelist` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `Imagehost` varchar(255) NOT NULL,
  `Link` varchar(255) NOT NULL,
  `Comment` varchar(255) NOT NULL,
  `UserID` int(10) NOT NULL,
  `Time` datetime NOT NULL,
  `Hidden` ENUM( '0', '1' ) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `Time` (`Time`),
  KEY `Hidden` ( `Hidden` )
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumpning av Data i tabell `imagehost_whitelist`
--

INSERT INTO `imagehost_whitelist` (`ID`, `Imagehost`, `Link`, `Comment`, `UserID`, `Time`) VALUES
(1, 'xxx.freeimage.us', 'http://xxx.freeimage.us/', 'The recommended image host to use', 1243, '2012-06-09 14:01:37'),
(2, 'bringthescreencaps.com', '', 'Private image host', 1243, '2012-06-09 14:03:40'),
(3, 'cdnpic.com', 'http://cdnpic.com', '', 1243, '2012-06-09 14:03:59'),
(4, 'emporniumforums.com', '', 'Private image host', 1243, '2012-06-09 14:04:30'),
(5, 'freeporndumpster.com', 'http://freeporndumpster.com/', '', 1243, '2012-06-09 14:05:02'),
(6, 'hotchyx.com', 'http://hotchyx.com/', '', 1243, '2012-06-09 14:05:25'),
(7, 'iceimg.com', 'http://iceimg.com/', '', 1243, '2012-06-09 14:05:45'),
(8, 'imgbox.com', 'http://imgbox.com/', '', 1243, '2012-06-09 14:06:17'),
(9, 'imagecross.com', 'http://www.imagecross.com/', '', 1243, '2012-06-09 14:07:15'),
(10, 'imgnook.com', 'http://imgnook.com/', '', 1243, '2012-06-09 14:07:38'),
(11, 'imageshost.ru', 'http://imageshost.ru/', '', 1243, '2012-06-09 14:07:59'),
(12, 'rjm.web44.net', '', 'Private image host', 1243, '2012-06-09 14:09:23'),
(13, 'spanknet.info', 'http://spanknet.info/', '', 1243, '2012-06-09 14:10:34'),
(14, 'stooorage.com', 'http://www.stooorage.com/', '', 1243, '2012-06-09 14:10:53');


-- --------------------------------------------------------

--
-- Tabellstruktur `invites`
--

CREATE TABLE IF NOT EXISTS `invites` (
  `InviterID` int(10) NOT NULL DEFAULT '0',
  `InviteKey` char(32) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Expires` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`InviteKey`),
  KEY `Expires` (`Expires`),
  KEY `InviterID` (`InviterID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `invite_tree`
--

CREATE TABLE IF NOT EXISTS `invite_tree` (
  `UserID` int(10) NOT NULL DEFAULT '0',
  `InviterID` int(10) NOT NULL DEFAULT '0',
  `TreePosition` int(8) NOT NULL DEFAULT '1',
  `TreeID` int(10) NOT NULL DEFAULT '1',
  `TreeLevel` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserID`),
  KEY `InviterID` (`InviterID`),
  KEY `TreePosition` (`TreePosition`),
  KEY `TreeID` (`TreeID`),
  KEY `TreeLevel` (`TreeLevel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `ip_bans`
--

CREATE TABLE IF NOT EXISTS `ip_bans` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `FromIP` int(11) unsigned NOT NULL,
  `ToIP` int(11) unsigned NOT NULL,
  `Reason` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `FromIP_2` (`FromIP`,`ToIP`),
  KEY `FromIP` (`FromIP`,`ToIP`),
  KEY `ToIP` (`ToIP`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `library_contest`
--

CREATE TABLE IF NOT EXISTS `library_contest` (
  `UserID` int(10) NOT NULL,
  `TorrentID` int(10) NOT NULL,
  PRIMARY KEY (`UserID`,`TorrentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Message` TEXT NOT NULL,
  `Time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `Message` (`Message`(255)),
  KEY `Time` (`Time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `UserID` int(10) unsigned NOT NULL,
  `IP` varchar(15) NOT NULL,
  `LastAttempt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Attempts` int(10) unsigned NOT NULL,
  `BannedUntil` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Bans` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `UserID` (`UserID`),
  KEY `IP` (`IP`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `UserID` int(10) unsigned NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Body` text NOT NULL,
  `Time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `UserID` (`UserID`),
  KEY `Time` (`Time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `ocelot_query_times`
--

CREATE TABLE IF NOT EXISTS `ocelot_query_times` (
  `buffer` enum('users','torrents','snatches','peers') NOT NULL,
  `starttime` datetime NOT NULL,
  `ocelotinstance` datetime NOT NULL,
  `querylength` int(11) NOT NULL,
  `timespent` int(11) NOT NULL,
  UNIQUE KEY `starttime` (`starttime`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Level` int(10) unsigned NOT NULL,
  `Name` varchar(25) CHARACTER SET latin1 NOT NULL,
  `MaxSigLength` smallint(4) unsigned NOT NULL DEFAULT '0',
  `MaxAvatarWidth` smallint(4) unsigned NOT NULL DEFAULT '100',
  `MaxAvatarHeight` smallint(4) unsigned NOT NULL DEFAULT '100',
  `Values` text CHARACTER SET latin1 NOT NULL,
  `DisplayStaff` enum('0','1') CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `IsUserClass` enum( '0', '1' ) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`),
  KEY `Level` (`Level`),
  KEY `DisplayStaff` (`DisplayStaff`),
  KEY `IsUserClass` (`IsUserClass`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Dumpning av Data i tabell `permissions`
--

INSERT INTO `permissions` (`ID`, `Level`, `Name`, `MaxSigLength`, `MaxAvatarWidth`, `MaxAvatarHeight`, `Values`, `DisplayStaff`) VALUES
(1, 600, 'Admin', 4096, 150, 250, 'a:112:{s:10:"site_leech";i:1;s:11:"site_upload";i:1;s:9:"site_vote";i:1;s:20:"site_submit_requests";i:1;s:21:"site_see_old_requests";i:1;s:20:"site_advanced_search";i:1;s:10:"site_top10";i:1;s:20:"site_torrents_notify";i:1;s:20:"site_collages_create";i:1;s:20:"site_collages_manage";i:1;s:20:"site_collages_delete";i:1;s:23:"site_collages_subscribe";i:1;s:22:"site_collages_personal";i:1;s:28:"site_collages_renamepersonal";i:1;s:19:"site_advanced_top10";i:1;s:19:"site_make_bookmarks";i:1;s:22:"site_can_invite_always";i:1;s:27:"site_send_unlimited_invites";i:1;s:18:"site_advanced_tags";i:1;s:22:"site_moderate_requests";i:1;s:19:"forums_polls_create";i:1;s:21:"forums_polls_moderate";i:1;s:20:"site_moderate_forums";i:1;s:17:"site_admin_forums";i:1;s:14:"site_view_flow";i:1;s:18:"site_view_full_log";i:1;s:28:"site_view_torrent_snatchlist";i:1;s:13:"site_vote_tag";i:1;s:12:"site_add_tag";i:1;s:15:"site_delete_tag";i:1;s:23:"site_disable_ip_history";i:1;s:14:"zip_downloader";i:1;s:10:"site_debug";i:1;s:16:"site_search_many";i:1;s:21:"site_collages_recover";i:1;s:23:"site_forums_double_post";i:1;s:12:"project_team";i:1;s:20:"users_edit_usernames";i:1;s:16:"users_edit_ratio";i:1;s:20:"users_edit_own_ratio";i:1;s:17:"users_edit_tokens";i:1;s:21:"users_edit_own_tokens";i:1;s:18:"users_edit_credits";i:1;s:22:"users_edit_own_credits";i:1;s:17:"users_edit_titles";i:1;s:18:"users_edit_avatars";i:1;s:17:"users_edit_badges";i:1;s:18:"users_edit_invites";i:1;s:22:"users_edit_watch_hours";i:1;s:21:"users_edit_reset_keys";i:1;s:19:"users_edit_profiles";i:1;s:18:"users_view_friends";i:1;s:20:"users_reset_own_keys";i:1;s:19:"users_edit_password";i:1;s:19:"users_promote_below";i:1;s:16:"users_promote_to";i:1;s:16:"users_give_donor";i:1;s:10:"users_warn";i:1;s:19:"users_disable_users";i:1;s:19:"users_disable_posts";i:1;s:17:"users_disable_any";i:1;s:18:"users_delete_users";i:1;s:18:"users_view_invites";i:1;s:20:"users_view_seedleech";i:1;s:19:"users_view_bonuslog";i:1;s:19:"users_view_uploaded";i:1;s:15:"users_view_keys";i:1;s:14:"users_view_ips";i:1;s:16:"users_view_email";i:1;s:23:"users_override_paranoia";i:1;s:20:"users_make_invisible";i:1;s:12:"users_logout";i:1;s:9:"users_mod";i:1;s:13:"torrents_edit";i:1;s:15:"torrents_review";i:1;s:24:"torrents_review_override";i:1;s:22:"torrents_review_manage";i:1;s:15:"torrents_delete";i:1;s:20:"torrents_delete_fast";i:1;s:18:"torrents_freeleech";i:1;s:20:"torrents_search_fast";i:1;s:13:"edit_unknowns";i:1;s:13:"site_add_logs";i:1;s:17:"torrents_hide_dnu";i:1;s:24:"torrents_hide_imagehosts";i:1;s:23:"admin_manage_categories";i:1;s:17:"admin_manage_news";i:1;s:21:"admin_manage_articles";i:1;s:17:"admin_manage_blog";i:1;s:18:"admin_manage_polls";i:1;s:19:"admin_manage_forums";i:1;s:16:"admin_manage_fls";i:1;s:16:"site_manage_tags";i:1;s:17:"site_convert_tags";i:1;s:18:"site_manage_badges";i:1;s:18:"site_manage_awards";i:1;s:16:"site_manage_shop";i:1;s:13:"admin_reports";i:1;s:26:"admin_advanced_user_search";i:1;s:18:"admin_create_users";i:1;s:15:"admin_donor_log";i:1;s:19:"admin_manage_ipbans";i:1;s:9:"admin_dnu";i:1;s:16:"admin_imagehosts";i:1;s:17:"admin_clear_cache";i:1;s:15:"admin_whitelist";i:1;s:24:"admin_manage_permissions";i:1;s:14:"admin_schedule";i:1;s:17:"admin_login_watch";i:1;s:17:"admin_manage_wiki";i:1;s:18:"admin_update_geoip";i:1;s:11:"MaxCollages";s:3:"100";}', '1'),
(2, 100, 'Apprentice', 0, 75, 75, 'a:4:{s:10:"site_leech";i:1;s:11:"site_upload";i:1;s:20:"site_advanced_search";i:1;s:11:"MaxCollages";s:1:"0";}', '0'),
(3, 150, 'Perv', 128, 100, 100, 'a:8:{s:10:"site_leech";i:1;s:11:"site_upload";i:1;s:20:"site_advanced_search";i:1;s:10:"site_top10";i:1;s:28:"site_collages_renamepersonal";i:1;s:19:"site_make_bookmarks";i:1;s:13:"site_vote_tag";i:1;s:11:"MaxCollages";s:1:"0";}', ''),
(4, 200, 'Good Perv', 256, 125, 125, 'a:14:{s:10:"site_leech";i:1;s:11:"site_upload";i:1;s:9:"site_vote";i:1;s:20:"site_submit_requests";i:1;s:20:"site_advanced_search";i:1;s:10:"site_top10";i:1;s:20:"site_torrents_notify";i:1;s:20:"site_collages_create";i:1;s:20:"site_collages_manage";i:1;s:19:"site_make_bookmarks";i:1;s:18:"site_advanced_tags";i:1;s:13:"site_vote_tag";i:1;s:12:"site_add_tag";i:1;s:11:"MaxCollages";s:1:"2";}', ''),
(5, 250, 'Sextreme Perv', 512, 150, 200, 'a:20:{s:10:"site_leech";i:1;s:11:"site_upload";i:1;s:9:"site_vote";i:1;s:20:"site_submit_requests";i:1;s:21:"site_see_old_requests";i:1;s:20:"site_advanced_search";i:1;s:10:"site_top10";i:1;s:20:"site_torrents_notify";i:1;s:20:"site_collages_create";i:1;s:20:"site_collages_manage";i:1;s:22:"site_collages_personal";i:1;s:19:"site_advanced_top10";i:1;s:19:"site_make_bookmarks";i:1;s:18:"site_advanced_tags";i:1;s:19:"forums_polls_create";i:1;s:13:"site_vote_tag";i:1;s:12:"site_add_tag";i:1;s:14:"zip_downloader";i:1;s:23:"site_forums_double_post";i:1;s:11:"MaxCollages";s:1:"5";}', ''),
(6, 300, 'Smut Peddler', 1024, 150, 250, 'a:24:{s:10:"site_leech";i:1;s:11:"site_upload";i:1;s:9:"site_vote";i:1;s:20:"site_submit_requests";i:1;s:21:"site_see_old_requests";i:1;s:20:"site_advanced_search";i:1;s:10:"site_top10";i:1;s:20:"site_torrents_notify";i:1;s:20:"site_collages_create";i:1;s:20:"site_collages_manage";i:1;s:23:"site_collages_subscribe";i:1;s:22:"site_collages_personal";i:1;s:28:"site_collages_renamepersonal";i:1;s:19:"site_advanced_top10";i:1;s:19:"site_make_bookmarks";i:1;s:27:"site_send_unlimited_invites";i:1;s:18:"site_advanced_tags";i:1;s:19:"forums_polls_create";i:1;s:28:"site_view_torrent_snatchlist";i:1;s:13:"site_vote_tag";i:1;s:12:"site_add_tag";i:1;s:16:"site_search_many";i:1;s:23:"site_forums_double_post";i:1;s:11:"MaxCollages";s:2:"10";}', ''),
(11, 500, 'Mod Perv', 4096, 150, 250, 'a:86:{s:10:"site_leech";i:1;s:11:"site_upload";i:1;s:9:"site_vote";i:1;s:20:"site_submit_requests";i:1;s:21:"site_see_old_requests";i:1;s:20:"site_advanced_search";i:1;s:10:"site_top10";i:1;s:20:"site_torrents_notify";i:1;s:20:"site_collages_create";i:1;s:20:"site_collages_manage";i:1;s:20:"site_collages_delete";i:1;s:23:"site_collages_subscribe";i:1;s:22:"site_collages_personal";i:1;s:28:"site_collages_renamepersonal";i:1;s:19:"site_advanced_top10";i:1;s:19:"site_make_bookmarks";i:1;s:22:"site_can_invite_always";i:1;s:18:"site_advanced_tags";i:1;s:22:"site_moderate_requests";i:1;s:19:"forums_polls_create";i:1;s:21:"forums_polls_moderate";i:1;s:20:"site_moderate_forums";i:1;s:17:"site_admin_forums";i:1;s:14:"site_view_flow";i:1;s:18:"site_view_full_log";i:1;s:28:"site_view_torrent_snatchlist";i:1;s:13:"site_vote_tag";i:1;s:12:"site_add_tag";i:1;s:15:"site_delete_tag";i:1;s:16:"site_manage_tags";i:1;s:17:"site_convert_tags";i:1;s:23:"site_disable_ip_history";i:1;s:16:"site_search_many";i:1;s:21:"site_collages_recover";i:1;s:23:"site_forums_double_post";i:1;s:20:"users_edit_usernames";i:1;s:16:"users_edit_ratio";i:1;s:20:"users_edit_own_ratio";i:1;s:17:"users_edit_tokens";i:1;s:21:"users_edit_own_tokens";i:1;s:18:"users_edit_credits";i:1;s:22:"users_edit_own_credits";i:1;s:17:"users_edit_titles";i:1;s:18:"users_edit_avatars";i:1;s:17:"users_edit_badges";i:1;s:18:"users_edit_invites";i:1;s:22:"users_edit_watch_hours";i:1;s:21:"users_edit_reset_keys";i:1;s:19:"users_edit_profiles";i:1;s:18:"users_view_friends";i:1;s:20:"users_reset_own_keys";i:1;s:19:"users_edit_password";i:1;s:19:"users_promote_below";i:1;s:16:"users_promote_to";i:1;s:10:"users_warn";i:1;s:19:"users_disable_users";i:1;s:19:"users_disable_posts";i:1;s:17:"users_disable_any";i:1;s:18:"users_view_invites";i:1;s:20:"users_view_seedleech";i:1;s:19:"users_view_bonuslog";i:1;s:19:"users_view_uploaded";i:1;s:15:"users_view_keys";i:1;s:14:"users_view_ips";i:1;s:16:"users_view_email";i:1;s:23:"users_override_paranoia";i:1;s:12:"users_logout";i:1;s:9:"users_mod";i:1;s:13:"torrents_edit";i:1;s:15:"torrents_review";i:1;s:24:"torrents_review_override";i:1;s:22:"torrents_review_manage";i:1;s:15:"torrents_delete";i:1;s:18:"torrents_freeleech";i:1;s:20:"torrents_search_fast";i:1;s:13:"site_add_logs";i:1;s:17:"admin_manage_news";i:1;s:21:"admin_manage_articles";i:1;s:17:"admin_manage_blog";i:1;s:18:"admin_manage_polls";i:1;s:19:"admin_manage_forums";i:1;s:13:"admin_reports";i:1;s:26:"admin_advanced_user_search";i:1;s:9:"admin_dnu";i:1;s:16:"admin_imagehosts";i:1;s:11:"MaxCollages";s:2:"10";}', '1'),
(15, 1000, 'Sysop', 4096, 150, 250, 'a:112:{s:10:"site_leech";i:1;s:11:"site_upload";i:1;s:9:"site_vote";i:1;s:20:"site_submit_requests";i:1;s:21:"site_see_old_requests";i:1;s:20:"site_advanced_search";i:1;s:10:"site_top10";i:1;s:20:"site_torrents_notify";i:1;s:20:"site_collages_create";i:1;s:20:"site_collages_manage";i:1;s:20:"site_collages_delete";i:1;s:23:"site_collages_subscribe";i:1;s:22:"site_collages_personal";i:1;s:28:"site_collages_renamepersonal";i:1;s:19:"site_advanced_top10";i:1;s:19:"site_make_bookmarks";i:1;s:22:"site_can_invite_always";i:1;s:27:"site_send_unlimited_invites";i:1;s:18:"site_advanced_tags";i:1;s:22:"site_moderate_requests";i:1;s:19:"forums_polls_create";i:1;s:21:"forums_polls_moderate";i:1;s:20:"site_moderate_forums";i:1;s:17:"site_admin_forums";i:1;s:14:"site_view_flow";i:1;s:18:"site_view_full_log";i:1;s:28:"site_view_torrent_snatchlist";i:1;s:13:"site_vote_tag";i:1;s:12:"site_add_tag";i:1;s:15:"site_delete_tag";i:1;s:23:"site_disable_ip_history";i:1;s:14:"zip_downloader";i:1;s:10:"site_debug";i:1;s:16:"site_search_many";i:1;s:21:"site_collages_recover";i:1;s:23:"site_forums_double_post";i:1;s:12:"project_team";i:1;s:20:"users_edit_usernames";i:1;s:16:"users_edit_ratio";i:1;s:20:"users_edit_own_ratio";i:1;s:17:"users_edit_tokens";i:1;s:21:"users_edit_own_tokens";i:1;s:18:"users_edit_credits";i:1;s:22:"users_edit_own_credits";i:1;s:17:"users_edit_titles";i:1;s:18:"users_edit_avatars";i:1;s:17:"users_edit_badges";i:1;s:18:"users_edit_invites";i:1;s:22:"users_edit_watch_hours";i:1;s:21:"users_edit_reset_keys";i:1;s:19:"users_edit_profiles";i:1;s:18:"users_view_friends";i:1;s:20:"users_reset_own_keys";i:1;s:19:"users_edit_password";i:1;s:19:"users_promote_below";i:1;s:16:"users_promote_to";i:1;s:16:"users_give_donor";i:1;s:10:"users_warn";i:1;s:19:"users_disable_users";i:1;s:19:"users_disable_posts";i:1;s:17:"users_disable_any";i:1;s:18:"users_delete_users";i:1;s:18:"users_view_invites";i:1;s:20:"users_view_seedleech";i:1;s:19:"users_view_bonuslog";i:1;s:19:"users_view_uploaded";i:1;s:15:"users_view_keys";i:1;s:14:"users_view_ips";i:1;s:16:"users_view_email";i:1;s:23:"users_override_paranoia";i:1;s:20:"users_make_invisible";i:1;s:12:"users_logout";i:1;s:9:"users_mod";i:1;s:13:"torrents_edit";i:1;s:15:"torrents_review";i:1;s:24:"torrents_review_override";i:1;s:22:"torrents_review_manage";i:1;s:15:"torrents_delete";i:1;s:20:"torrents_delete_fast";i:1;s:18:"torrents_freeleech";i:1;s:20:"torrents_search_fast";i:1;s:13:"edit_unknowns";i:1;s:13:"site_add_logs";i:1;s:17:"torrents_hide_dnu";i:1;s:24:"torrents_hide_imagehosts";i:1;s:23:"admin_manage_categories";i:1;s:17:"admin_manage_news";i:1;s:21:"admin_manage_articles";i:1;s:17:"admin_manage_blog";i:1;s:18:"admin_manage_polls";i:1;s:19:"admin_manage_forums";i:1;s:16:"admin_manage_fls";i:1;s:16:"site_manage_tags";i:1;s:17:"site_convert_tags";i:1;s:18:"site_manage_badges";i:1;s:18:"site_manage_awards";i:1;s:16:"site_manage_shop";i:1;s:13:"admin_reports";i:1;s:26:"admin_advanced_user_search";i:1;s:18:"admin_create_users";i:1;s:15:"admin_donor_log";i:1;s:19:"admin_manage_ipbans";i:1;s:9:"admin_dnu";i:1;s:16:"admin_imagehosts";i:1;s:17:"admin_clear_cache";i:1;s:15:"admin_whitelist";i:1;s:24:"admin_manage_permissions";i:1;s:14:"admin_schedule";i:1;s:17:"admin_login_watch";i:1;s:17:"admin_manage_wiki";i:1;s:18:"admin_update_geoip";i:1;s:11:"MaxCollages";s:1:"2";}', '1'),
(20, 202, 'Donor', 512, 150, 150, 'a:12:{s:10:"site_leech";i:1;s:11:"site_upload";i:1;s:9:"site_vote";i:1;s:20:"site_submit_requests";i:1;s:21:"site_see_old_requests";i:1;s:20:"site_advanced_search";i:1;s:10:"site_top10";i:1;s:20:"site_torrents_notify";i:1;s:20:"site_collages_create";i:1;s:20:"site_collages_manage";i:1;s:19:"forums_polls_create";i:1;s:11:"MaxCollages";s:1:"2";}', '0');


-- --------------------------------------------------------

--
-- Tabellstruktur `pm_conversations`
--

CREATE TABLE IF NOT EXISTS `pm_conversations` (
  `ID` int(12) NOT NULL AUTO_INCREMENT,
  `Subject` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `pm_conversations_users`
--

CREATE TABLE IF NOT EXISTS `pm_conversations_users` (
  `UserID` int(10) NOT NULL DEFAULT '0',
  `ConvID` int(12) NOT NULL DEFAULT '0',
  `InInbox` enum('1','0') NOT NULL,
  `InSentbox` enum('1','0') NOT NULL,
  `SentDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ReceivedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `UnRead` enum('1','0') NOT NULL DEFAULT '1',
  `Sticky` enum('1','0') NOT NULL DEFAULT '0',
  `ForwardedTo` int(12) NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserID`,`ConvID`),
  KEY `ConvID` (`ConvID`),
  KEY `SentDate` (`SentDate`),
  KEY `ReceivedDate` (`ReceivedDate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `pm_messages`
--

CREATE TABLE IF NOT EXISTS `pm_messages` (
  `ID` int(12) NOT NULL AUTO_INCREMENT,
  `ConvID` int(12) NOT NULL DEFAULT '0',
  `SentDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `SenderID` int(10) NOT NULL DEFAULT '0',
  `Body` text,
  PRIMARY KEY (`ID`),
  KEY `ConvID` (`ConvID`),
  KEY `SenderID` (`SenderID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `reports`
--

CREATE TABLE IF NOT EXISTS `reports` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `UserID` int(10) unsigned NOT NULL DEFAULT '0',
  `ThingID` int(10) unsigned NOT NULL DEFAULT '0',
  `Type` varchar(30) DEFAULT NULL,
  `Comment` text,
  `ResolverID` int(10) unsigned NOT NULL DEFAULT '0',
  `Status` enum('New','InProgress','Resolved') DEFAULT 'New',
  `ResolvedTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ReportedTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Reason` text NOT NULL,,
  `ConvID` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `Status` (`Status`),
  KEY `Type` (`Type`),
  KEY `ResolvedTime` (`ResolvedTime`),
  KEY `ResolverID` (`ResolverID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `reportsv2`
--

CREATE TABLE IF NOT EXISTS `reportsv2` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ReporterID` int(10) unsigned NOT NULL DEFAULT '0',
  `TorrentID` int(10) unsigned NOT NULL DEFAULT '0',
  `Type` varchar(20) DEFAULT '',
  `UserComment` text NOT NULL,
  `ResolverID` int(10) unsigned NOT NULL DEFAULT '0',
  `Status` enum('New','InProgress','Resolved') DEFAULT 'New',
  `ReportedTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `LastChangeTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ModComment` text NOT NULL,
  `Track` text,
  `Image` text,
  `ExtraID` text,
  `Link` text,
  `LogMessage` text,
  PRIMARY KEY (`ID`),
  KEY `Status` (`Status`),
  KEY `Type` (`Type`(1)),
  KEY `LastChangeTime` (`LastChangeTime`),
  KEY `TorrentID` (`TorrentID`),
  KEY `ResolverID` (`ResolverID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `requests`
--

CREATE TABLE IF NOT EXISTS `requests` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `UserID` int(10) unsigned NOT NULL DEFAULT '0',
  `TimeAdded` datetime NOT NULL,
  `LastVote` datetime DEFAULT NULL,
  `CategoryID` int(3) NOT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `Image` varchar(255) DEFAULT NULL,
  `Description` text NOT NULL,
  `ReleaseType` tinyint(2) DEFAULT NULL,
  `FillerID` int(10) unsigned NOT NULL DEFAULT '0',
  `TorrentID` int(10) unsigned NOT NULL DEFAULT '0',
  `TimeFilled` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Visible` binary(1) NOT NULL DEFAULT '1',
  `GroupID` int(10) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `Userid` (`UserID`),
  KEY `Name` (`Title`),
  KEY `Filled` (`TorrentID`),
  KEY `FillerID` (`FillerID`),
  KEY `TimeAdded` (`TimeAdded`),
  KEY `TimeFilled` (`TimeFilled`),
  KEY `LastVote` (`LastVote`),
  KEY `GroupID` (`GroupID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `requests_comments`
--

CREATE TABLE IF NOT EXISTS `requests_comments` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `RequestID` int(10) NOT NULL,
  `AuthorID` int(10) NOT NULL,
  `AddedTime` datetime DEFAULT NULL,
  `Body` mediumtext,
  `EditedUserID` int(10) DEFAULT NULL,
  `EditedTime` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `requests_tags`
--

CREATE TABLE IF NOT EXISTS `requests_tags` (
  `TagID` int(10) NOT NULL DEFAULT '0',
  `RequestID` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`TagID`,`RequestID`),
  KEY `TagID` (`TagID`),
  KEY `RequestID` (`RequestID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `requests_votes`
--

CREATE TABLE IF NOT EXISTS `requests_votes` (
  `RequestID` int(10) NOT NULL DEFAULT '0',
  `UserID` int(10) NOT NULL DEFAULT '0',
  `Bounty` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`RequestID`,`UserID`),
  KEY `RequestID` (`RequestID`),
  KEY `UserID` (`UserID`),
  KEY `Bounty` (`Bounty`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




-- --------------------------------------------------------

--
-- Table structure for table `review_reasons`
--

CREATE TABLE IF NOT EXISTS `review_reasons` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `Sort` int(5) NOT NULL DEFAULT '0',
  `Name` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Sort` (`Sort`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `review_reasons`
--

INSERT IGNORE INTO `review_reasons` (`Sort`, `Name`, `Description`) VALUES
(2, 'Screenshots', 'Not enough screenshots.'),
(4, 'Description', 'Lack of text description.'),
(8, 'Screenshots & Description', 'Not enough screenshots, lack of text description.');


-- --------------------------------------------------------

--
-- Tabellstruktur `schedule`
--

CREATE TABLE IF NOT EXISTS `schedule` (
  `NextHour` int(2) NOT NULL DEFAULT '0',
  `NextDay` int(2) NOT NULL DEFAULT '0',
  `NextBiWeekly` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumpning av Data i tabell `schedule`
--

INSERT INTO `schedule` (`NextHour`, `NextDay`, `NextBiWeekly`) VALUES
(0, 0, 0);


-- --------------------------------------------------------

--
-- Table structure for table `site_options`
--

CREATE TABLE IF NOT EXISTS `site_options` (
  `ReviewHours` int(4) NOT NULL,
  `AutoDelete` tinyint(1) NOT NULL,
  `DeleteRecordsMins` int(8) NOT NULL,
  `KeepSpeed` bigint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `site_options`
--

INSERT IGNORE INTO `site_options` (`ReviewHours`, `AutoDelete`, `DeleteRecordsMins`, `KeepSpeed`) VALUES
(24, 0, 720, 1048576);

-- --------------------------------------------------------

--
-- Table structure for table `site_stats_history`
--

CREATE TABLE IF NOT EXISTS `site_stats_history` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `TimeAdded` datetime NOT NULL,
  `Users` int(10) unsigned NOT NULL,
  `Torrents` int(10) unsigned NOT NULL,
  `Seeders` int(10) unsigned NOT NULL,
  `Leechers` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `TimeAdded` (`TimeAdded`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sm_results`
--

CREATE TABLE IF NOT EXISTS `sm_results` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `Spins` smallint(1) NOT NULL,
  `Won` int(11) NOT NULL,
  `Bet` mediumint(5) NOT NULL,
  `Result` varchar(12) CHARACTER SET utf8 NOT NULL,
  `Time` datetime NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `UserID` (`UserID`),
  KEY `Won` (`Won`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `sphinx_delta`
--

CREATE TABLE IF NOT EXISTS `sphinx_delta` (
  `ID` int(10) NOT NULL,
  `GroupName` varchar(255) DEFAULT NULL,
  `TagList` varchar(728) DEFAULT NULL,
  `NewCategoryID` int(11) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Time` int(12) DEFAULT NULL,
  `Size` bigint(20) DEFAULT NULL,
  `Snatched` int(10) DEFAULT NULL,
  `Seeders` int(10) DEFAULT NULL,
  `Leechers` int(10) DEFAULT NULL,
  `FreeTorrent` tinyint(1) DEFAULT NULL,
  `FileList` mediumtext,
  `SearchText` text,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Tabellstruktur `sphinx_hash`
--

CREATE TABLE IF NOT EXISTS `sphinx_hash` (
  `ID` int(10) NOT NULL,
  `GroupName` varchar(255) DEFAULT NULL,
  `TagList` varchar(728) DEFAULT NULL,
  `NewCategoryID` int(11) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Time` int(12) DEFAULT NULL,
  `Size` bigint(20) DEFAULT NULL,
  `Snatched` int(10) DEFAULT NULL,
  `Seeders` int(10) DEFAULT NULL,
  `Leechers` int(10) DEFAULT NULL,
  `FreeTorrent` tinyint(1) DEFAULT NULL,
  `FileList` mediumtext,
  `SearchText` text,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `sphinx_requests`
--

CREATE TABLE IF NOT EXISTS `sphinx_requests` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `UserID` int(10) unsigned NOT NULL DEFAULT '0',
  `TimeAdded` int(12) unsigned NOT NULL,
  `LastVote` int(12) unsigned NOT NULL,
  `CategoryID` int(3) NOT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `ReleaseType` tinyint(2) DEFAULT NULL,
  `FillerID` int(10) unsigned NOT NULL DEFAULT '0',
  `TorrentID` int(10) unsigned NOT NULL DEFAULT '0',
  `TimeFilled` int(12) unsigned NOT NULL,
  `Visible` binary(1) NOT NULL DEFAULT '1',
  `Bounty` bigint(20) unsigned NOT NULL DEFAULT '0',
  `Votes` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `Userid` (`UserID`),
  KEY `Name` (`Title`),
  KEY `Filled` (`TorrentID`),
  KEY `FillerID` (`FillerID`),
  KEY `TimeAdded` (`TimeAdded`),
  KEY `TimeFilled` (`TimeFilled`),
  KEY `LastVote` (`LastVote`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `sphinx_requests_delta`
--

CREATE TABLE IF NOT EXISTS `sphinx_requests_delta` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `UserID` int(10) unsigned NOT NULL DEFAULT '0',
  `TimeAdded` int(12) unsigned DEFAULT NULL,
  `LastVote` int(12) unsigned DEFAULT NULL,
  `CategoryID` int(3) NOT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `ReleaseType` tinyint(2) DEFAULT NULL,
  `FillerID` int(10) unsigned NOT NULL DEFAULT '0',
  `TorrentID` int(10) unsigned NOT NULL DEFAULT '0',
  `TimeFilled` int(12) unsigned DEFAULT NULL,
  `Visible` binary(1) NOT NULL DEFAULT '1',
  `Bounty` bigint(20) unsigned NOT NULL DEFAULT '0',
  `Votes` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `Userid` (`UserID`),
  KEY `Name` (`Title`),
  KEY `Filled` (`TorrentID`),
  KEY `FillerID` (`FillerID`),
  KEY `TimeAdded` (`TimeAdded`),
  KEY `TimeFilled` (`TimeFilled`),
  KEY `LastVote` (`LastVote`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `staff_blog`
--

CREATE TABLE IF NOT EXISTS `staff_blog` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `UserID` int(10) unsigned NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Body` text NOT NULL,
  `Time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `UserID` (`UserID`),
  KEY `Time` (`Time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `staff_blog_visits`
--

CREATE TABLE IF NOT EXISTS `staff_blog_visits` (
  `UserID` int(10) unsigned NOT NULL,
  `Time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  UNIQUE KEY `UserID` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



--
-- Table structure for table `staff_checking`
--

CREATE TABLE IF NOT EXISTS `staff_checking` (
  `UserID` int(10) unsigned NOT NULL,
  `TimeOut` int(10) unsigned NOT NULL,
  `TimeStarted` datetime NOT NULL,
  `Location` varchar(128) NOT NULL,
  `IsChecking` ENUM( '0', '1' ) NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserID`),
  KEY ( `IsChecking` )
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Tabellstruktur `staff_pm_conversations`
--


CREATE TABLE IF NOT EXISTS `staff_pm_conversations` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Subject` text,
  `UserID` int(11) DEFAULT NULL,
  `Status` enum('Open','Unanswered','Resolved') DEFAULT NULL,
  `Level` int(11) DEFAULT NULL,
  `AssignedToUser` int(11) DEFAULT NULL,
  `Date` datetime DEFAULT NULL,
  `Unread` tinyint(1) DEFAULT NULL,
  `ResolverID` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `staff_pm_messages`
--

CREATE TABLE IF NOT EXISTS `staff_pm_messages` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) DEFAULT NULL,
  `SentDate` datetime DEFAULT NULL,
  `Message` text,
  `ConvID` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `staff_pm_responses`
--

CREATE TABLE IF NOT EXISTS `staff_pm_responses` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Message` text,
  `Name` text,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `stylesheets`
--

CREATE TABLE IF NOT EXISTS `stylesheets` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Default` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
 
--
-- Dumping data for table `stylesheets`
--

INSERT INTO `stylesheets` (`ID`, `Name`, `Description`, `Default`) VALUES
(1, 'empornium', 'empornium stylesheet', '0'),
(2, 'light', 'light empornium stylesheet', '0'),
(3, 'modern', 'modern empornium stylesheet', '1');

-- --------------------------------------------------------

--
-- Tabellstruktur `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) DEFAULT NULL,
  `TagType` enum('genre','other') NOT NULL DEFAULT 'other',
  `Uses` int(12) NOT NULL DEFAULT '1',
  `UserID` int(10) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Name_2` (`Name`),
  KEY `TagType` (`TagType`),
  KEY `Uses` (`Uses`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tag_synomyns`
--

CREATE TABLE IF NOT EXISTS `tag_synomyns` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `Synomyn` varchar(100) NOT NULL,
  `TagID` int(10) NOT NULL,
  `UserID` int(10) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Synomyn` (`Synomyn`),
  KEY `TagID` (`TagID`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `top10_history`
--

CREATE TABLE IF NOT EXISTS `top10_history` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `Date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Type` enum('Daily','Weekly') DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `top10_history_torrents`
--

CREATE TABLE IF NOT EXISTS `top10_history_torrents` (
  `HistoryID` int(10) NOT NULL DEFAULT '0',
  `Rank` tinyint(2) NOT NULL DEFAULT '0',
  `TorrentID` int(10) NOT NULL DEFAULT '0',
  `TitleString` varchar(150) NOT NULL DEFAULT '',
  `TagString` varchar(100) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `top_snatchers`
--

CREATE TABLE IF NOT EXISTS `top_snatchers` (
  `UserID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `torrents`
--

CREATE TABLE IF NOT EXISTS `torrents` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `GroupID` int(10) NOT NULL,
  `UserID` int(10) DEFAULT NULL,
  `info_hash` blob NOT NULL,
  `InfoHash` char(40) NOT NULL DEFAULT '',
  `FileCount` int(6) NOT NULL,
  `FileList` mediumtext NOT NULL,
  `FilePath` varchar(255) NOT NULL DEFAULT '',
  `Size` bigint(12) NOT NULL,
  `Leechers` int(6) NOT NULL DEFAULT '0',
  `Seeders` int(6) NOT NULL DEFAULT '0',
  `last_action` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `FreeTorrent` enum('0','1','2') NOT NULL DEFAULT '0',
  `FreeLeechType` enum('0','1','2','3') NOT NULL DEFAULT '0',
  `double_seed` enum('0','1') NOT NULL DEFAULT '0',
  `Dupable` enum('0','1') NOT NULL DEFAULT '0',
  `DupeReason` varchar(40) DEFAULT NULL,
  `Time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Anonymous` enum('0','1') NOT NULL DEFAULT '0',
  `Thanks` text NOT NULL,
  `Snatched` int(10) unsigned NOT NULL DEFAULT '0',
  `completed` int(11) NOT NULL,
  `announced_http` int(11) NOT NULL,
  `announced_http_compact` int(11) NOT NULL,
  `announced_http_no_peer_id` int(11) NOT NULL,
  `announced_udp` int(11) NOT NULL,
  `scraped_http` int(11) NOT NULL,
  `scraped_udp` int(11) NOT NULL,
  `started` int(11) NOT NULL,
  `stopped` int(11) NOT NULL,
  `flags` int(11) NOT NULL,
  `mtime` int(11) NOT NULL,
  `ctime` int(11) NOT NULL,
  `balance` bigint(20) NOT NULL DEFAULT '0',
  `LastLogged` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pid` int(5) NOT NULL DEFAULT '0',
  `LastReseedRequest` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ExtendedGrace` enum('0','1') NOT NULL DEFAULT '0',
  `Tasted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `InfoHash` (`info_hash`(40)),
  KEY `GroupID` (`GroupID`),
  KEY `UserID` (`UserID`),
  KEY `FileCount` (`FileCount`),
  KEY `Size` (`Size`),
  KEY `Seeders` (`Seeders`),
  KEY `Leechers` (`Leechers`),
  KEY `Snatched` (`Snatched`),
  KEY `last_action` (`last_action`),
  KEY `Time` (`Time`),
  KEY `flags` (`flags`),
  KEY `LastLogged` (`LastLogged`),
  KEY `FreeTorrent` (`FreeTorrent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `torrents_bad_files`
--

CREATE TABLE IF NOT EXISTS `torrents_bad_files` (
  `TorrentID` int(11) NOT NULL DEFAULT '0',
  `UserID` int(11) NOT NULL DEFAULT '0',
  `TimeAdded` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `torrents_bad_folders`
--

CREATE TABLE IF NOT EXISTS `torrents_bad_folders` (
  `TorrentID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `TimeAdded` datetime NOT NULL,
  PRIMARY KEY (`TorrentID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `torrents_bad_tags`
--

CREATE TABLE IF NOT EXISTS `torrents_bad_tags` (
  `TorrentID` int(10) NOT NULL DEFAULT '0',
  `UserID` int(10) NOT NULL DEFAULT '0',
  `TimeAdded` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `TimeAdded` (`TimeAdded`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `torrents_balance_history`
--

CREATE TABLE IF NOT EXISTS `torrents_balance_history` (
  `TorrentID` int(10) NOT NULL,
  `GroupID` int(10) NOT NULL,
  `balance` bigint(20) NOT NULL,
  `Time` datetime NOT NULL,
  `Last` enum('0','1','2') DEFAULT '0',
  UNIQUE KEY `TorrentID_2` (`TorrentID`,`Time`),
  UNIQUE KEY `TorrentID_3` (`TorrentID`,`balance`),
  KEY `TorrentID` (`TorrentID`),
  KEY `Time` (`Time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `torrents_comments`
--

CREATE TABLE IF NOT EXISTS `torrents_comments` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `GroupID` int(10) NOT NULL,
  `TorrentID` int(10) unsigned NOT NULL,
  `AuthorID` int(10) NOT NULL,
  `AddedTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Body` mediumtext,
  `EditedUserID` int(10) DEFAULT NULL,
  `EditedTime` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `TopicID` (`GroupID`),
  KEY `AuthorID` (`AuthorID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `torrents_files`
--

CREATE TABLE IF NOT EXISTS `torrents_files` (
  `TorrentID` int(10) NOT NULL,
  `File` mediumblob NOT NULL,
  PRIMARY KEY (`TorrentID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `torrents_group`
--

CREATE TABLE IF NOT EXISTS `torrents_group` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `NewCategoryID` int(11) NOT NULL,
  `Name` varchar(300) DEFAULT NULL,
  `ReleaseType` tinyint(2) DEFAULT '21',
  `TagList` varchar(500) NOT NULL,
  `Time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Body` mediumtext NOT NULL,
  `Image` varchar(255) NOT NULL,
  `SearchText` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `NewCategoryID` (`NewCategoryID`),
  KEY `Name` (`Name`(255)),
  KEY `Time` (`Time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `torrents_groups_log`
--

CREATE TABLE IF NOT EXISTS `torrents_groups_log` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `GroupID` int(10) NOT NULL,
  `TorrentID` int(10) NOT NULL DEFAULT '0',
  `UserID` int(10) NOT NULL,
  `Info` mediumtext,
  `Time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Hidden` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `TorrentID` (`TorrentID`),
  KEY `GroupID` (`GroupID`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `torrents_logs_new`
--

CREATE TABLE IF NOT EXISTS `torrents_logs_new` (
  `LogID` int(10) NOT NULL AUTO_INCREMENT,
  `TorrentID` int(10) NOT NULL DEFAULT '0',
  `Log` mediumtext NOT NULL,
  `Details` mediumtext NOT NULL,
  `Score` int(3) NOT NULL,
  `Revision` int(3) NOT NULL,
  `Adjusted` enum('1','0') NOT NULL DEFAULT '0',
  `AdjustedBy` int(10) NOT NULL DEFAULT '0',
  `NotEnglish` enum('1','0') NOT NULL DEFAULT '0',
  `AdjustmentReason` text,
  PRIMARY KEY (`LogID`),
  KEY `TorrentID` (`TorrentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Tabellstruktur `torrents_peerlists`
--

CREATE TABLE IF NOT EXISTS `torrents_peerlists` (
  `GroupID` int(10) NOT NULL,
  `SeedersList` varchar(512) DEFAULT NULL,
  `LeechersList` varchar(512) DEFAULT NULL,
  `SnatchedList` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`GroupID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `torrents_peerlists_compare`
--

CREATE TABLE IF NOT EXISTS `torrents_peerlists_compare` (
  `GroupID` int(10) NOT NULL,
  `SeedersList` varchar(512) DEFAULT NULL,
  `LeechersList` varchar(512) DEFAULT NULL,
  `SnatchedList` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`GroupID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `torrents_recommended`
--

CREATE TABLE IF NOT EXISTS `torrents_recommended` (
  `GroupID` int(10) NOT NULL,
  `UserID` int(10) NOT NULL,
  `Time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`GroupID`),
  KEY `Time` (`Time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `torrents_reviews`
--

CREATE TABLE IF NOT EXISTS `torrents_reviews` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `GroupID` int(10) NOT NULL,
  `Time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ReasonID` int(10) NOT NULL,
  `UserID` int(10) NOT NULL,
  `ConvID` int(10) DEFAULT NULL,
  `Status` enum('None','Okay','Warned','Pending') NOT NULL DEFAULT 'None',
  `Reason` varchar(255) DEFAULT NULL,
  `KillTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `GroupID` (`GroupID`),
  KEY `Time` (`Time`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Tabellstruktur `torrents_tags`
--

CREATE TABLE IF NOT EXISTS `torrents_tags` (
  `TagID` int(10) NOT NULL DEFAULT '0',
  `GroupID` int(10) NOT NULL DEFAULT '0',
  `PositiveVotes` int(6) NOT NULL DEFAULT '1',
  `NegativeVotes` int(6) NOT NULL DEFAULT '1',
  `UserID` int(10) DEFAULT NULL,
  PRIMARY KEY (`TagID`,`GroupID`),
  KEY `TagID` (`TagID`),
  KEY `GroupID` (`GroupID`),
  KEY `PositiveVotes` (`PositiveVotes`),
  KEY `NegativeVotes` (`NegativeVotes`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `torrents_tags_votes`
--

CREATE TABLE IF NOT EXISTS `torrents_tags_votes` (
  `GroupID` int(10) NOT NULL,
  `TagID` int(10) NOT NULL,
  `UserID` int(10) NOT NULL,
  `Way` enum('up','down') NOT NULL DEFAULT 'up',
  PRIMARY KEY (`GroupID`,`TagID`,`UserID`,`Way`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `torrents_watch_list`
--

CREATE TABLE IF NOT EXISTS `torrents_watch_list` (
  `TorrentID` int(10) NOT NULL,
  `StaffID` int(10) NOT NULL,
  `Time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Comment` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`TorrentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `upload_templates`
--

CREATE TABLE IF NOT EXISTS `upload_templates` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `UserID` int(10) unsigned NOT NULL,
  `TimeAdded` date NOT NULL DEFAULT '0000-00-00',
  `Name` varchar(64) NOT NULL,
  `Public` enum('0','1') NOT NULL DEFAULT '0',
  `Title` varchar(255) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Body` mediumtext NOT NULL,
  `CategoryID` int(10) NOT NULL,
  `Taglist` text NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `UserID` (`UserID`),
  KEY `TimeAdded` (`TimeAdded`),
  KEY `Public` (`Public`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users_badges`
--

CREATE TABLE IF NOT EXISTS `users_badges` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `UserID` int(10) NOT NULL,
  `BadgeID` int(10) NOT NULL,
  `Description` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `UserID` (`UserID`),
  KEY `BadgeID` (`BadgeID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `users_collage_subs`
--

CREATE TABLE IF NOT EXISTS `users_collage_subs` (
  `UserID` int(10) NOT NULL,
  `CollageID` int(10) NOT NULL,
  `LastVisit` datetime DEFAULT NULL,
  PRIMARY KEY (`UserID`,`CollageID`),
  KEY `CollageID` (`CollageID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `users_connectable_status`
--

CREATE TABLE IF NOT EXISTS `users_connectable_status` (
 `UserID` int(10) unsigned NOT NULL,
 `IP` varchar(15) NOT NULL DEFAULT '',
 `Status` enum('0','1') NOT NULL DEFAULT '1',
 `Time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserID`,`IP`),
  KEY `Status` (`Status`) ,
  KEY `Time` (`Time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Tabellstruktur `users_downloads`
--

CREATE TABLE IF NOT EXISTS `users_downloads` (
  `UserID` int(10) NOT NULL,
  `TorrentID` int(1) NOT NULL,
  `Time` datetime NOT NULL,
  PRIMARY KEY (`UserID`,`TorrentID`,`Time`),
  KEY `TorrentID` (`TorrentID`),
  KEY `UserID` (`UserID`),
  KEY `UserID_2` (`UserID`),
  KEY `TorrentID_2` (`TorrentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `users_dupes`
--

CREATE TABLE IF NOT EXISTS `users_dupes` (
  `GroupID` int(10) unsigned NOT NULL,
  `UserID` int(10) unsigned NOT NULL,
  UNIQUE KEY `UserID` (`UserID`),
  KEY `GroupID` (`GroupID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- table structure `users_freeleeches`
--
 
CREATE TABLE IF NOT EXISTS `users_freeleeches` (
  `UserID` int(11) NOT NULL,
  `TorrentID` int(11) NOT NULL,
  `Downloaded` bigint(20) unsigned NOT NULL DEFAULT '0',
  `Uploaded` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserID`,`TorrentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `users_geodistribution`
--

CREATE TABLE IF NOT EXISTS `users_geodistribution` (
  `Code` varchar(2) NOT NULL,
  `Users` int(10) NOT NULL,
  PRIMARY KEY (`Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `users_history_emails`
--

CREATE TABLE IF NOT EXISTS `users_history_emails` (
  `UserID` int(10) NOT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Time` datetime DEFAULT NULL,
  `IP` varchar(15) DEFAULT NULL,
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `users_history_ips`
--

CREATE TABLE IF NOT EXISTS `users_history_ips` (
  `UserID` int(10) NOT NULL,
  `IP` varchar(15) NOT NULL DEFAULT '0.0.0.0',
  `StartTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `EndTime` datetime DEFAULT NULL,
  PRIMARY KEY (`UserID`,`IP`,`StartTime`),
  KEY `UserID` (`UserID`),
  KEY `IP` (`IP`),
  KEY `StartTime` (`StartTime`),
  KEY `EndTime` (`EndTime`),
  KEY `IP_2` (`IP`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `users_history_passkeys`
--

CREATE TABLE IF NOT EXISTS `users_history_passkeys` (
  `UserID` int(10) NOT NULL,
  `OldPassKey` varchar(32) DEFAULT NULL,
  `NewPassKey` varchar(32) DEFAULT NULL,
  `ChangeTime` datetime DEFAULT NULL,
  `ChangerIP` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `users_history_passwords`
--

CREATE TABLE IF NOT EXISTS `users_history_passwords` (
  `UserID` int(10) NOT NULL,
  `ChangeTime` datetime DEFAULT NULL,
  `ChangerIP` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `users_info`
--

CREATE TABLE IF NOT EXISTS `users_info` (
  `UserID` int(10) unsigned NOT NULL,
  `StyleID` int(10) unsigned NOT NULL,
  `StyleURL` varchar(255) DEFAULT NULL,
  `Info` text NOT NULL,
  `Avatar` varchar(255) NOT NULL,
  `Country` int(10) unsigned NOT NULL,
  `TimeZone` VARCHAR( 128 ) NOT NULL,
  `AdminComment` text NOT NULL,
  `SeedHistory` TEXT NOT NULL,
  `SiteOptions` text NOT NULL,
  `ViewAvatars` enum('0','1') NOT NULL DEFAULT '1',
  `Donor` enum('0','1') NOT NULL DEFAULT '0',
  `DownloadAlt` enum('0','1') NOT NULL DEFAULT '0',
  `Warned` datetime NOT NULL,
  `MessagesPerPage` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `DeletePMs` enum('0','1') NOT NULL DEFAULT '1',
  `SaveSentPMs` enum('0','1') NOT NULL DEFAULT '0',
  `BlockPMs` enum('0','1','2') NOT NULL DEFAULT '0', 
  `CommentsNotify` enum('0','1') NOT NULL DEFAULT '1', 
  `SupportFor` varchar(255) NOT NULL,
  `TorrentGrouping` enum('0','1','2') NOT NULL COMMENT '0=Open,1=Closed,2=Off',
  `ShowTags` enum('0','1') NOT NULL DEFAULT '1',
  `AuthKey` varchar(32) NOT NULL,
  `ResetKey` varchar(32) NOT NULL,
  `ResetExpires` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `JoinDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Inviter` int(10) DEFAULT NULL,
  `BitcoinAddress` tinytext,
  `WarnedTimes` int(2) NOT NULL DEFAULT '0',
  `DisableAvatar` enum('0','1') NOT NULL DEFAULT '0',
  `DisableInvites` enum('0','1') NOT NULL DEFAULT '0',
  `DisablePosting` enum('0','1') NOT NULL DEFAULT '0',
  `DisableForums` enum('0','1') NOT NULL DEFAULT '0',
  `DisableIRC` enum('0','1') DEFAULT '0',
  `DisableTagging` enum('0','1') NOT NULL DEFAULT '0',
  `DisableUpload` enum('0','1') NOT NULL DEFAULT '0',
  `DisablePM` enum('0','1') NOT NULL DEFAULT '0',
  `RatioWatchEnds` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `RatioWatchDownload` bigint(20) unsigned NOT NULL DEFAULT '0',
  `RatioWatchTimes` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `BanDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `BanReason` enum('0','1','2','3','4') NOT NULL DEFAULT '0',
  `CatchupTime` datetime DEFAULT NULL,
  `LastReadNews` int(10) NOT NULL DEFAULT '0',
  `HideCountryChanges` enum('0','1') NOT NULL DEFAULT '0',
  `RestrictedForums` varchar(150) NOT NULL DEFAULT '',
  `DisableRequests` enum('0','1') NOT NULL DEFAULT '0',
  `PermittedForums` varchar(150) NOT NULL DEFAULT '',
  `UnseededAlerts` enum('0','1') NOT NULL DEFAULT '0',
  `BonusLog` text NOT NULL,
  UNIQUE KEY `UserID` (`UserID`),
  KEY `SupportFor` (`SupportFor`),
  KEY `DisableInvites` (`DisableInvites`),
  KEY `Donor` (`Donor`),
  KEY `Warned` (`Warned`),
  KEY `JoinDate` (`JoinDate`),
  KEY `Inviter` (`Inviter`),
  KEY `RatioWatchEnds` (`RatioWatchEnds`),
  KEY `RatioWatchDownload` (`RatioWatchDownload`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `users_main`
--

CREATE TABLE IF NOT EXISTS `users_main` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Username` varchar(30) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `PassHash` char(40) NOT NULL,
  `Secret` char(32) NOT NULL,
  `TorrentKey` char(32) NOT NULL,
  `IRCKey` char(32) DEFAULT NULL,
  `LastLogin` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `LastAccess` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `IP` varchar(15) NOT NULL DEFAULT '0.0.0.0',
  `Uploaded` bigint(20) unsigned NOT NULL DEFAULT '0',
  `Downloaded` bigint(20) unsigned NOT NULL DEFAULT '0',
  `UploadedLast` bigint(20) unsigned NOT NULL DEFAULT '0',
  `DownloadedLast` bigint(20) unsigned NOT NULL DEFAULT '0',
  `Title` varchar(128) NOT NULL,
  `Enabled` enum('0','1','2') NOT NULL DEFAULT '0',
  `Paranoia` text,
  `Visible` enum('1','0') NOT NULL DEFAULT '1',
  `Invites` int(10) unsigned NOT NULL DEFAULT '0',
  `PermissionID` int(10) unsigned NOT NULL,
  `GroupPermissionID` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0' ,
  `CustomPermissions` text,
  `LastSeed` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `can_leech` tinyint(4) NOT NULL DEFAULT '1',
  `wait_time` int(11) NOT NULL,
  `peers_limit` int(11) DEFAULT '1000',
  `torrents_limit` int(11) DEFAULT '1000',
  `torrent_pass` char(32) NOT NULL,
  `OldPassHash` char(32) DEFAULT NULL,
  `Cursed` enum('1','0') NOT NULL DEFAULT '0',
  `CookieID` varchar(32) DEFAULT NULL,
  `RequiredRatio` double(10,8) NOT NULL DEFAULT '0.00000000',
  `RequiredRatioWork` double(10,8) NOT NULL DEFAULT '0.00000000',
  `Language` char(2) NOT NULL DEFAULT '',
  `ipcc` char(2) NOT NULL DEFAULT '',
  `FLTokens` int(10) NOT NULL DEFAULT '0',
  `personal_freeleech` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `SeedHoursDaily` DOUBLE( 11, 2 ) NOT NULL DEFAULT '0.00',
  `SeedHours` DOUBLE( 11, 2 ) NOT NULL DEFAULT '0.00',
  `CreditsDaily` DOUBLE( 11, 2 ) NOT NULL DEFAULT '0.00',
  `Credits` double(11,2) NOT NULL DEFAULT '0.00',
  `Signature` text,
  `Flag` VARCHAR( 50 ) NOT NULL DEFAULT '??',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Username` (`Username`),
  KEY `Email` (`Email`),
  KEY `PassHash` (`PassHash`),
  KEY `LastAccess` (`LastAccess`),
  KEY `IP` (`IP`),
  KEY `Uploaded` (`Uploaded`),
  KEY `Downloaded` (`Downloaded`),
  KEY `Enabled` (`Enabled`),
  KEY `Invites` (`Invites`),
  KEY `Cursed` (`Cursed`),
  KEY `torrent_pass` (`torrent_pass`),
  KEY `RequiredRatio` (`RequiredRatio`),
  KEY `cc_index` (`ipcc`),
  KEY `SeedHoursDaily` (`SeedHoursDaily`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=119928 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `users_notify_filters`
--

CREATE TABLE IF NOT EXISTS `users_notify_filters` (
  `ID` int(12) NOT NULL AUTO_INCREMENT,
  `UserID` int(10) NOT NULL,
  `Label` varchar(128) NOT NULL DEFAULT '',
  `Users` mediumtext NOT NULL,
  `Tags` varchar(500) NOT NULL DEFAULT '',
  `NotTags` varchar(500) NOT NULL DEFAULT '',
  `Categories` varchar(500) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `users_notify_torrents`
--

CREATE TABLE IF NOT EXISTS `users_notify_torrents` (
  `UserID` int(10) NOT NULL,
  `FilterID` int(10) NOT NULL,
  `GroupID` int(10) NOT NULL,
  `TorrentID` int(10) NOT NULL,
  `UnRead` enum('1','0') NOT NULL DEFAULT '1',
  PRIMARY KEY (`UserID`,`TorrentID`),
  KEY `UnRead` (`UnRead`),
  KEY `UserID` (`UserID`),
  KEY `TorrentID` (`TorrentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `users_points`
--

CREATE TABLE IF NOT EXISTS `users_points` (
  `UserID` int(10) NOT NULL,
  `GroupID` int(10) NOT NULL,
  `Points` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`UserID`,`GroupID`),
  KEY `UserID` (`UserID`),
  KEY `GroupID` (`GroupID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `users_points_requests`
--

CREATE TABLE IF NOT EXISTS `users_points_requests` (
  `UserID` int(10) NOT NULL,
  `RequestID` int(10) NOT NULL,
  `Points` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`RequestID`),
  KEY `UserID` (`UserID`),
  KEY `RequestID` (`RequestID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `users_seedhours_history`
--

CREATE TABLE IF NOT EXISTS `users_seedhours_history` (
  `UserID` int(10) NOT NULL,
  `Time` date NOT NULL DEFAULT '0000-00-00',
  `TimeAdded` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `SeedHours` double(11,2) NOT NULL DEFAULT '0.00',
  `Credits` double(11,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`UserID`,`Time`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Tabellstruktur `users_sessions`
--

CREATE TABLE IF NOT EXISTS `users_sessions` (
  `UserID` int(10) NOT NULL,
  `SessionID` char(32) NOT NULL,
  `KeepLogged` enum('0','1') NOT NULL DEFAULT '0',
  `Browser` varchar(40) DEFAULT NULL,
  `OperatingSystem` varchar(8) DEFAULT NULL,
  `IP` varchar(15) NOT NULL,
  `LastUpdate` datetime NOT NULL,
  `Active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`UserID`,`SessionID`),
  KEY `UserID` (`UserID`),
  KEY `LastUpdate` (`LastUpdate`),
  KEY `Active` (`Active`),
  KEY `ActiveAgeKeep` (`Active`,`LastUpdate`,`KeepLogged`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `users_slots`
--


CREATE TABLE IF NOT EXISTS `users_slots` (
  `UserID` int(11) NOT NULL,
  `TorrentID` int(11) NOT NULL,
  `FreeLeech` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `DoubleSeed` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`UserID`,`TorrentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `users_subscriptions`
--

CREATE TABLE IF NOT EXISTS `users_subscriptions` (
  `UserID` int(10) NOT NULL,
  `TopicID` int(10) NOT NULL,
  PRIMARY KEY (`UserID`,`TopicID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `users_torrent_history`
--

CREATE TABLE IF NOT EXISTS `users_torrent_history` (
  `UserID` int(10) unsigned NOT NULL,
  `NumTorrents` int(6) unsigned NOT NULL,
  `Date` int(8) unsigned NOT NULL,
  `Time` int(11) unsigned NOT NULL DEFAULT '0',
  `LastTime` int(11) unsigned NOT NULL DEFAULT '0',
  `Finished` enum('1','0') NOT NULL DEFAULT '1',
  `Weight` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserID`,`NumTorrents`,`Date`),
  KEY `Finished` (`Finished`),
  KEY `Date` (`Date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `users_torrent_history_snatch`
--

CREATE TABLE IF NOT EXISTS `users_torrent_history_snatch` (
  `UserID` int(10) unsigned NOT NULL,
  `NumSnatches` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserID`),
  KEY `NumSnatches` (`NumSnatches`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `users_torrent_history_temp`
--

CREATE TABLE IF NOT EXISTS `users_torrent_history_temp` (
  `UserID` int(10) unsigned NOT NULL,
  `NumTorrents` int(6) unsigned NOT NULL DEFAULT '0',
  `SumTime` bigint(20) unsigned NOT NULL DEFAULT '0',
  `SeedingAvg` int(6) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users_watch_list`
--

CREATE TABLE IF NOT EXISTS `users_watch_list` (
  `UserID` int(10) NOT NULL,
  `StaffID` int(10) NOT NULL,
  `Time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Comment` varchar(255) CHARACTER SET utf8 NOT NULL,
  `KeepTorrents` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `users_exclude_watchlist`
--

CREATE TABLE IF NOT EXISTS `users_exclude_watchlist` (
  `UserID` int(10) NOT NULL,
  `StaffID` int(10) NOT NULL,
  `Time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Comment` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Tabellstruktur `xbt_announce_log`
--

CREATE TABLE IF NOT EXISTS `xbt_announce_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ipa` int(10) unsigned NOT NULL,
  `port` int(11) NOT NULL,
  `event` int(11) NOT NULL,
  `info_hash` blob NOT NULL,
  `peer_id` blob NOT NULL,
  `downloaded` bigint(20) NOT NULL,
  `left0` bigint(20) NOT NULL,
  `uploaded` bigint(20) NOT NULL,
  `uid` int(11) NOT NULL,
  `mtime` int(11) NOT NULL,
  `useragent` varchar(51) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `xbt_cheat`
--

CREATE TABLE IF NOT EXISTS `xbt_cheat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `ipa` int(10) unsigned NOT NULL,
  `upspeed` bigint(20) NOT NULL,
  `tstamp` int(11) NOT NULL,
  `uploaded` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `xbt_client_blacklist`
--

CREATE TABLE IF NOT EXISTS `xbt_client_blacklist` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `peer_id` varchar(20) DEFAULT NULL,
  `vstring` varchar(200) DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `peer_id` (`peer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `xbt_config`
--

CREATE TABLE IF NOT EXISTS `xbt_config` (
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `xbt_deny_from_hosts`
--

CREATE TABLE IF NOT EXISTS `xbt_deny_from_hosts` (
  `begin` int(11) NOT NULL,
  `end` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `xbt_files`
--

CREATE TABLE IF NOT EXISTS `xbt_files` (
  `fid` int(11) NOT NULL AUTO_INCREMENT,
  `info_hash` blob NOT NULL,
  `leechers` int(11) NOT NULL,
  `seeders` int(11) NOT NULL,
  `completed` int(11) NOT NULL,
  `announced_http` int(11) NOT NULL,
  `announced_http_compact` int(11) NOT NULL,
  `announced_http_no_peer_id` int(11) NOT NULL,
  `announced_udp` int(11) NOT NULL,
  `scraped_http` int(11) NOT NULL,
  `scraped_udp` int(11) NOT NULL,
  `started` int(11) NOT NULL,
  `stopped` int(11) NOT NULL,
  `flags` int(11) NOT NULL,
  `mtime` int(11) NOT NULL,
  `ctime` int(11) NOT NULL,
  `balance` int(11) NOT NULL,
  `freetorrent` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`fid`),
  UNIQUE KEY `info_hash` (`info_hash`(20))
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `xbt_files_users`
--

CREATE TABLE IF NOT EXISTS `xbt_files_users` (
  `uid` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `announced` int(11) NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `downloaded` bigint(20) NOT NULL,
  `remaining` bigint(20) NOT NULL,
  `uploaded` bigint(20) NOT NULL,
  `upspeed` bigint(20) NOT NULL,
  `downspeed` bigint(20) NOT NULL,
  `corrupt` bigint(20) NOT NULL DEFAULT '0',
  `timespent` bigint(20) NOT NULL,
  `useragent` varchar(51) NOT NULL,
  `connectable` tinyint(4) NOT NULL DEFAULT '1',
  `peer_id` binary(20) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `fid` int(11) NOT NULL,
  `mtime` int(11) NOT NULL,
  `ip` varchar(15) NOT NULL DEFAULT '',
  `port` int(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`peer_id`,`fid`),
  KEY `remaining_idx` (`remaining`),
  KEY `fid_idx` (`fid`),
  KEY `mtime_idx` (`mtime`),
  KEY `uid_active` (`uid`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure `xbt_peers_history`
--

CREATE TABLE `xbt_peers_history` (  
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `downloaded` bigint(20) NOT NULL,
  `remaining` bigint(20) NOT NULL,
  `uploaded` bigint(20) NOT NULL,
  `upspeed` bigint(20) NOT NULL,
  `downspeed` bigint(20) NOT NULL,
  `timespent` bigint(20) NOT NULL,
  `peer_id` binary(20) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `fid` int(11) NOT NULL,
  `mtime` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `mtime` (`mtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `xbt_scrape_log`
--

CREATE TABLE IF NOT EXISTS `xbt_scrape_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ipa` int(11) NOT NULL,
  `info_hash` blob,
  `uid` int(11) NOT NULL,
  `mtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `xbt_snatched`
--

CREATE TABLE IF NOT EXISTS `xbt_snatched` (
  `uid` int(11) NOT NULL DEFAULT '0',
  `tstamp` int(11) NOT NULL,
  `fid` int(11) NOT NULL,
  `IP` varchar(15) NOT NULL,
  KEY `fid` (`fid`),
  KEY `uid` (`uid`),
  KEY `tstamp` (`tstamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `xbt_users`
--

CREATE TABLE IF NOT EXISTS `xbt_users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(8) NOT NULL,
  `pass` blob NOT NULL,
  `can_leech` tinyint(4) NOT NULL DEFAULT '1',
  `wait_time` int(11) NOT NULL,
  `peers_limit` int(11) NOT NULL,
  `torrents_limit` int(11) NOT NULL,
  `torrent_pass` char(32) NOT NULL,
  `torrent_pass_secret` bigint(20) NOT NULL,
  `downloaded` bigint(20) NOT NULL,
  `uploaded` bigint(20) NOT NULL,
  `fid_end` int(11) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Restriktioner för dumpade tabeller
--

--
-- Restriktioner för tabell `staff_blog_visits`
--
ALTER TABLE `staff_blog_visits`
  ADD CONSTRAINT `staff_blog_visits_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users_main` (`ID`) ON DELETE CASCADE;

--
-- Restriktioner för tabell `users_dupes`
--
ALTER TABLE `users_dupes`
  ADD CONSTRAINT `users_dupes_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users_main` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_dupes_ibfk_2` FOREIGN KEY (`GroupID`) REFERENCES `dupe_groups` (`ID`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
