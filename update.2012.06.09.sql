ALTER TABLE  `users_main` DROP  `pass` ,
DROP  `torrent_pass_secret` ,
DROP  `fid_end` ,
DROP  `name` ,
DROP  `Class` ;

DROP TABLE `categories` ;

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
(14, 'Gang Bang / Orgy', 'cat_gangbang.png', 'gang.bang'),
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
(40, 'Megapack', 'cat_megapack.png', 'mega.packs'),
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
