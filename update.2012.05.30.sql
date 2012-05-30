ALTER TABLE `users_main` DROP `LastBonusTime`;
ALTER TABLE `users_main` ADD `Badges` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ;

ALTER TABLE `torrents_reviews` ADD INDEX ( `Status` ) ;



--
-- Table structure for table `bonus_shop_actions`
--

DROP TABLE IF EXISTS `bonus_shop_actions`;
CREATE TABLE `bonus_shop_actions` (
  `ID` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `Title` varchar(256) NOT NULL,
  `Description` varchar(1024) NOT NULL,
  `Action` varchar(32) NOT NULL,
  `Value` varchar(32) NOT NULL DEFAULT '0',
  `Cost` int(9) unsigned NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=76 ;

--
-- Dumping data for table `bonus_shop_actions`
--

INSERT IGNORE INTO `bonus_shop_actions` (`ID`, `Title`, `Description`, `Action`, `Value`, `Cost`) VALUES
(3, 'Give Away 500 Credits', 'If you have more credit than you could possibly have a use for, then why not share it with a friend? Give away 500 credits.', 'givecredits', '500', 600),
(4, 'Give Away 2000 Credits', 'If you have more credit than you could possibly have a use for, then why not share it with a friend? Give away 2000 credits.', 'givecredits', '2000', 2200),
(6, 'Give away 5000 credits', 'If you have more credit than you could possibly have a use for, then why not share it with a friend? Give away 5000 credits.', 'givecredits', '5000', 5500),
(10, '-1 GB', 'Do you have a bad ratio? Here you can improve it dramatically by buying 1GB away from what you''ve downloaded!', 'gb', '1', 1000),
(12, '-5GB', 'Do you have a bad ratio? Here you can improve it dramatically by buying 5GB away from what you''ve downloaded!', 'gb', '5', 4500),
(18, '-10GB', 'Do you have a bad ratio? Here you can improve it dramatically by buying 10GB away from what you''ve downloaded!', 'gb', '10', 8000),
(20, '-1GB to other', 'Do you know a friend or perhaps someone else who has a shitty ratio? Here you can give someone a happy surprise by taking away 1GB from the person''s downloaded traffic!', 'givegb', '1', 1100),
(22, '-5GB to other', 'Do you know a friend or perhaps someone else who has a shitty ratio? Here you can give someone a happy surprise by taking away 5GB from the person''s downloaded traffic!', 'givegb', '5', 4750),
(25, '-10 GB to other', 'Do you know a friend or perhaps someone else who has a shitty ratio? Here you can give someone a happy surprise by taking away 10GB from the person''s downloaded traffic!', 'givegb', '10', 8500),
(30, '1 Slot', 'A slot will give you the option to either freeleech or doubleseed a torrent. Freeleech will allow you to download the torrent without counting the downloaded amount, while doubleseed will count the uploaded amount times 2.', 'slot', '1', 11000),
(31, '2 Slots', 'A slot will give you the option to either freeleech or doubleseed a torrent. Freeleech will allow you to download the torrent without counting the downloaded amount, while doubleseed will count the uploaded amount times 2.', 'slot', '2', 21000),
(50, 'Custom Title', 'A super seeder like you deserves a custom title on the tracker!', 'title', '1', 20000),
(60, 'Red Star', 'This awesome red star will let everyone know just how awesome you really are', 'badge', 'starred', 30000),
(61, 'Blue Star', 'This awesome blue star will let everyone know just how awesome you really are', 'badge', 'starblue', 30000),
(63, 'Green Star', 'This awesome green star will let everyone know just how awesome you really are', 'badge', 'stargreen', 40000),
(64, 'Yellow Star', 'This awesome yellow star will let everyone know just how awesome you really are', 'badge', 'staryellow', 40000),
(67, 'Bronze Star', 'A super seeder like you deserves a bronze star on your profile!', 'badge', 'bronze_star', 60000),
(68, 'Silver Star', 'A super seeder like you deserves a silver star on your profile!', 'badge', 'silver_star', 70000),
(69, 'Gold Star', 'A super seeder like you deserves a gold star on your profile!', 'badge', 'gold_star', 80000),
(70, 'Diamond', 'A super seeder like you deserves a huge diamond on your profile!', 'badge', 'diamond_star', 100000),
(72, 'Plaque of Wealth', 'This superb plaque will let everyone know you are are a perv of substance!', 'badge', 'wealthy_wanker', 200000),
(73, 'Plaque of Richness', 'This stunning plaque will let everyone know you are are a perv of substance!', 'badge', 'filthy_rich', 400000),
(74, 'Plaque of Awesomeness', 'This awesome plaque will let everyone know you are are a perv of substance!', 'badge', 'awesome_mutha', 600000),
(75, 'Millionaires Plaque', 'This plaque is just too much, the owner of this has more credits than sense.', 'badge', 'mill_club', 1000000);



