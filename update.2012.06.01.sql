

DROP TABLE IF EXISTS `badges`;
CREATE TABLE IF NOT EXISTS `badges` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `Type` enum('Shop','Single','Multiple','Unique') NOT NULL,
  `Sort` int(10) NOT NULL,
  `Cost` int(20) NOT NULL DEFAULT '0',
  `Name` varchar(64) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Image` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Type` (`Type`),
  KEY `Sort` (`Sort`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `badges`
--

INSERT IGNORE INTO `badges` (`ID`, `Type`, `Sort`, `Cost`, `Name`, `Description`, `Image`) VALUES
(1, 'Unique', 0, 0, 'The USB Award', 'Awarded to USB for services to users above and beyond the call of duty.', 'usb_award.png'),
(2, 'Shop', 1, 30000, 'Red Star', 'Red Star. This is a placeholder! we need better text & gfx!', 'star_red.png'),
(3, 'Shop', 2, 30000, 'Blue Star', 'Blue Star. This is a placeholder! we need better text & gfx!', 'star_blue.png'),
(4, 'Shop', 3, 40000, 'Green Star', 'Green Star. This is a placeholder! we need better text & gfx!', 'star_green.png'),
(5, 'Shop', 4, 40000, 'Yellow Star', 'Yellow Star. This is a placeholder! we need better text & gfx!', 'star_yellow.png'),
(6, 'Shop', 5, 60000, 'Bronze Star', 'Bronze Star. This is a placeholder! we need better text & gfx!', 'bronze-icon.png'),
(7, 'Shop', 6, 70000, 'Silver Star', 'Silver Star. This is a placeholder! we need better text & gfx!', 'silver-icon.png'),
(8, 'Shop', 7, 80000, 'Gold Star', 'Gold Star. This is a placeholder! we need better text & gfx!', 'gold-icon.png'),
(9, 'Shop', 8, 100000, 'Diamond', 'Diamond. This is a placeholder! we need better text & gfx!', 'diamond-icon.png'),
(10, 'Multiple', 9, 0, 'Bronze Heart', 'Awarded for XXXXXX. This is a placeholder! we need better text & gfx!', 'award_bronze.png'),
(11, 'Multiple', 10, 0, 'Silver Heart', 'Awarded for XXXXXX. This is a placeholder! we need better text & gfx!', 'award_silver.png'),
(12, 'Multiple', 11, 0, 'Gold Heart', 'Awarded for XXXXXX. This is a placeholder! we need better text & gfx!', 'award_gold.png'),
(13, 'Multiple', 12, 0, 'Bronze Cup', 'Awarded for XXXXXX. This is a placeholder! we need better text & gfx!', 'bronze_small.png'),
(14, 'Multiple', 13, 0, 'Silver Cup', 'Awarded for XXXXXX. This is a placeholder! we need better text & gfx!', 'silver_small.png'),
(15, 'Multiple', 14, 0, 'Gold Cup', 'Awarded for XXXXXX. This is a placeholder! we need better text & gfx!', 'gold_small.png'),
(16, 'Single', 15, 0, 'Bronze Medal', 'Awarded for XXXXXX. This is a placeholder! we need better text & gfx!', 'medalbronze.png'),
(17, 'Single', 16, 0, 'Silver Medal', 'Awarded for XXXXXX. This is a placeholder! we need better text & gfx!', 'medalsilver.png'),
(18, 'Single', 17, 0, 'Gold Medal', 'Awarded for XXXXXX. This is a placeholder! we need better text & gfx!', 'medalgold.png'),
(19, 'Shop', 18, 200000, 'Wealthy Wanker', 'Plaque of Wealth. This user is a wealthy wanker. This is a placeholder! we need better text & gfx!', 'wealthy_wanker.png'),
(20, 'Shop', 19, 400000, 'Filthy Rich', 'Plaque of Richness. This user is filthy rich. This is a placeholder! we need better text & gfx!', 'filthy_rich.png'),
(21, 'Shop', 20, 770000, 'Awesome Muthafucka', 'Plaque of Awesomeness. This user is an awesome muthafucka. This is a placeholder! we need better text & gfx!', 'awesome_mutha.png'),
(22, 'Shop', 21, 1000000, 'Millionaires Club', 'Millionaires Plaque. This user is a millionaire. This is a placeholder! we need better text & gfx!', 'mill_club.png');



-- --------------------------------------------------------

--
-- Table structure for table `bonus_shop_actions`
--

DROP TABLE IF EXISTS `bonus_shop_actions`;
CREATE TABLE IF NOT EXISTS `bonus_shop_actions` (
  `ID` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `Title` varchar(256) NOT NULL,
  `Description` varchar(1024) NOT NULL,
  `Action` varchar(32) NOT NULL,
  `Value` int(10) NOT NULL DEFAULT '0',
  `Cost` int(9) unsigned NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=88 ;

--
-- Dumping data for table `bonus_shop_actions`
--

INSERT INTO `bonus_shop_actions` (`ID`, `Title`, `Description`, `Action`, `Value`, `Cost`) VALUES
(3, 'Give Away 500 Credits', 'If you have more credit than you could possibly have a use for, then why not share it with a friend? Give away 500 credits.', 'givecredits', 500, 600),
(4, 'Give Away 2000 Credits', 'If you have more credit than you could possibly have a use for, then why not share it with a friend? Give away 2000 credits.', 'givecredits', 2000, 2200),
(6, 'Give away 5000 credits', 'If you have more credit than you could possibly have a use for, then why not share it with a friend? Give away 5000 credits.', 'givecredits', 5000, 5500),
(10, '-1 GB', 'Do you have a bad ratio? Here you can improve it dramatically by buying 1GB away from what you''ve downloaded!', 'gb', 1, 1000),
(12, '-5GB', 'Do you have a bad ratio? Here you can improve it dramatically by buying 5GB away from what you''ve downloaded!', 'gb', 5, 4500),
(18, '-10GB', 'Do you have a bad ratio? Here you can improve it dramatically by buying 10GB away from what you''ve downloaded!', 'gb', 10, 8000),
(20, '-1GB to other', 'Do you know a friend or perhaps someone else who has a shitty ratio? Here you can give someone a happy surprise by taking away 1GB from the person''s downloaded traffic!', 'givegb', 1, 1100),
(22, '-5GB to other', 'Do you know a friend or perhaps someone else who has a shitty ratio? Here you can give someone a happy surprise by taking away 5GB from the person''s downloaded traffic!', 'givegb', 5, 4750),
(25, '-10 GB to other', 'Do you know a friend or perhaps someone else who has a shitty ratio? Here you can give someone a happy surprise by taking away 10GB from the person''s downloaded traffic!', 'givegb', 10, 8500),
(30, '1 Slot', 'A slot will give you the option to either freeleech or doubleseed a torrent. Freeleech will allow you to download the torrent without counting the downloaded amount, while doubleseed will count the uploaded amount times 2.', 'slot', 1, 11000),
(31, '2 Slots', 'A slot will give you the option to either freeleech or doubleseed a torrent. Freeleech will allow you to download the torrent without counting the downloaded amount, while doubleseed will count the uploaded amount times 2.', 'slot', 2, 21000),
(50, 'Custom Title', 'A super seeder like you deserves a custom title on the tracker!', 'title', 1, 20000),
(76, 'Red Star', 'Red Star. This is a placeholder! we need better text &amp; gfx!', 'badge', 2, 30000),
(77, 'Blue Star', 'Blue Star. This is a placeholder! we need better text &amp; gfx!', 'badge', 3, 30000),
(78, 'Green Star', 'Green Star. This is a placeholder! we need better text &amp; gfx!', 'badge', 4, 40000),
(79, 'Yellow Star', 'Yellow Star. This is a placeholder! we need better text &amp; gfx!', 'badge', 5, 40000),
(80, 'Bronze Star', 'Bronze Star. This is a placeholder! we need better text &amp; gfx!', 'badge', 6, 60000),
(81, 'Silver Star', 'Silver Star. This is a placeholder! we need better text &amp; gfx!', 'badge', 7, 70000),
(82, 'Gold Star', 'Gold Star. This is a placeholder! we need better text &amp; gfx!', 'badge', 8, 80000),
(83, 'Diamond', 'Diamond. This is a placeholder! we need better text &amp; gfx!', 'badge', 9, 100000),
(84, 'Wealthy Wanker', 'Plaque of Wealth. This user is a wealthy wanker. This is a placeholder! we need better text &amp; gfx!', 'badge', 19, 200000),
(85, 'Filthy Rich', 'Plaque of Richness. This user is filthy rich. This is a placeholder! we need better text &amp; gfx!', 'badge', 20, 400000),
(86, 'Awesome Muthafucka', 'Plaque of Awesomeness. This user is an awesome muthafucka. This is a placeholder! we need better text &amp; gfx!', 'badge', 21, 600000),
(87, 'Millionaires Club', 'Millionaires Plaque. This user is a millionaire. This is a placeholder! we need better text &amp; gfx!', 'badge', 22, 1000000);



-- --------------------------------------------------------

--
-- Table structure for table `users_badges`
--

CREATE TABLE IF NOT EXISTS `users_badges` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `UserID` int(10) NOT NULL,
  `BadgeID` int(10) NOT NULL,
  `Title` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



