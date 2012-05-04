DROP TABLE IF EXIST `stylesheets`;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumpning av Data i tabell `stylesheets`
--

INSERT INTO `stylesheets` (`ID`, `Name`, `Description`, `Default`) VALUES
(1, 'empornium', 'The new stylesheet', '1');

UPDATE users_info SET StyleID =1;
