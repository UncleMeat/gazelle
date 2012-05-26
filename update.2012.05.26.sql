


-- --------------------------------------------------------

--
-- Table structure for table `review_options`
--

CREATE TABLE IF NOT EXISTS `review_options` (
  `Hours` int(4) NOT NULL,
  `AutoDelete` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `review_options`
--

INSERT IGNORE INTO `review_options` (`Hours`, `AutoDelete`) VALUES
(12, 0);

