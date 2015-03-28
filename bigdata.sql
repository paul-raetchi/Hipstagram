SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE IF NOT EXISTS `bigdata` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT NULL,
  `location` int(10) unsigned DEFAULT NULL,
  `image` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `white` tinyint(3) unsigned DEFAULT NULL,
  `black` tinyint(3) unsigned DEFAULT NULL,
  `navyblue` tinyint(3) unsigned DEFAULT NULL,
  `green` tinyint(3) unsigned DEFAULT NULL,
  `red` tinyint(3) unsigned DEFAULT NULL,
  `darkred` tinyint(3) unsigned DEFAULT NULL,
  `purple` tinyint(3) unsigned DEFAULT NULL,
  `orange` tinyint(3) unsigned DEFAULT NULL,
  `yellow` tinyint(3) unsigned DEFAULT NULL,
  `limegreen` tinyint(3) unsigned DEFAULT NULL,
  `teal` tinyint(3) unsigned DEFAULT NULL,
  `aqualight` tinyint(3) unsigned DEFAULT NULL,
  `royalblue` tinyint(3) unsigned DEFAULT NULL,
  `hotpink` tinyint(3) unsigned DEFAULT NULL,
  `darkgrey` tinyint(3) unsigned DEFAULT NULL,
  `lightgrey` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;
