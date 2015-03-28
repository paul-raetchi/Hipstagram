SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE IF NOT EXISTS `bigdata` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT NULL,
  `location` int(10) unsigned DEFAULT NULL,
  `image` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `chocolate` tinyint(3) unsigned DEFAULT NULL,
  `wheat` tinyint(3) unsigned DEFAULT NULL,
  `white` tinyint(3) unsigned DEFAULT NULL,
  `silver` tinyint(3) unsigned DEFAULT NULL,
  `black` tinyint(3) unsigned DEFAULT NULL,
  `navy` tinyint(3) unsigned DEFAULT NULL,
  `skyblue` tinyint(3) unsigned DEFAULT NULL,
  `teal` tinyint(3) unsigned DEFAULT NULL,
  `lime` tinyint(3) unsigned DEFAULT NULL,
  `olive` tinyint(3) unsigned DEFAULT NULL,
  `yellow` tinyint(3) unsigned DEFAULT NULL,
  `gold` tinyint(3) unsigned DEFAULT NULL,
  `orange` tinyint(3) unsigned DEFAULT NULL,
  `red` tinyint(3) unsigned DEFAULT NULL,
  `pink` tinyint(3) unsigned DEFAULT NULL,
  `purple` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;
