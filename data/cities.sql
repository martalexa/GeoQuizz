-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `geo_city`;
CREATE TABLE `geo_city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `lat` varchar(255) NOT NULL,
  `lng` varchar(255) NOT NULL,
  `zoom_level` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `geo_city` (`id`, `name`, `lat`, `lng`, `zoom_level`) VALUES
(1,	'Nancy',	'48.6843900',	'6.1849600',	13),
(2,	'Paris',	'48.856406',	'2.3521452',	13),
(3,	'New York',	'40.7127753',	'-74.0059728',	11),
(4,	'London',	'51.5073509',	'-0.12775829999998223',	11),
(5,	'Berlin',	'52.52000659999999',	'13.404953999999975',	11),
(6,	'Moscou',	'55.755826',	'37.617299900000035',	11),
(7,	'Rome',	'41.9027835',	'12.496365500000024',	11),
(8,	'Beijing',	'39.90419989999999',	'116.40739630000007',	11);

-- 2018-02-10 10:10:55