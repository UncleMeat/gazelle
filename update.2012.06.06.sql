

DROP TABLE IF EXISTS `bonus_shop_actions`;
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
(12, 'Custom Title', 'A super seeder like you deserves a custom title on the tracker!', 'title', 1, 20000, 50),
(13, 'Red Star', 'Red Star. This is a placeholder! we need better text &amp; gfx!', 'badge', 2, 30000, 88),
(14, 'Blue Star', 'Blue Star. This is a placeholder! we need better text &amp; gfx!', 'badge', 3, 30000, 89),
(15, 'Green Star', 'Awarded for greenery.', 'badge', 4, 40000, 90),
(16, 'Yellow Star', 'Yellow Star. This is a placeholder! we need better text &amp; gfx!', 'badge', 5, 40000, 91),
(17, 'Bronze Star', 'Bronze Star. This is a placeholder! we need better text &amp; gfx!', 'badge', 6, 60000, 92),
(18, 'Silver Star', 'Silver Star. This is a placeholder! we need better text &amp; gfx!', 'badge', 7, 70000, 93),
(19, 'Gold Star', 'Gold Star. This is a placeholder! we need better text &amp; gfx!', 'badge', 8, 80000, 94),
(20, 'Diamond', 'Diamond. This is a placeholder! we need better text &amp; gfx!', 'badge', 9, 100000, 95),
(21, 'Wealthy Wanker', 'Plaque of Wealth. This user is a wealthy wanker. This is a placeholder! we need better text &amp; gfx!', 'badge', 19, 200000, 96),
(22, 'Filthy Rich', 'Plaque of Richness. This user is filthy rich. This is a placeholder! we need better text &amp; gfx!', 'badge', 20, 400000, 97),
(23, 'Awesome Muthafucka', 'Plaque of Awesomeness. This user is an awesome muthafucka. This is a placeholder! we need better text &amp; gfx!', 'badge', 21, 600000, 98),
(24, 'Millionaires Club', 'Millionaires Plaque. This user is a millionaire. This is a placeholder! we need better text &amp; gfx!', 'badge', 22, 1000000, 99);

