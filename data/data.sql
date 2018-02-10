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

DROP TABLE IF EXISTS `geo_palier`;
CREATE TABLE `geo_palier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coef` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  `serie_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `palier_serie_id_foreign` (`serie_id`),
  CONSTRAINT `palier_serie_id_foreign` FOREIGN KEY (`serie_id`) REFERENCES `geo_serie` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `geo_palier` (`id`, `coef`, `points`, `serie_id`) VALUES
(61,	1,	5,	23),
(62,	2,	3,	23),
(63,	3,	1,	23);

DROP TABLE IF EXISTS `geo_photo`;
CREATE TABLE `geo_photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `lat` varchar(255) NOT NULL,
  `lng` varchar(255) NOT NULL,
  `serie_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `photo_serie_id_foreign` (`serie_id`),
  CONSTRAINT `photo_serie_id_foreign` FOREIGN KEY (`serie_id`) REFERENCES `geo_serie` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `geo_photo` (`id`, `url`, `description`, `lat`, `lng`, `serie_id`) VALUES
(80,	'9156b130-0e4d-11e8-88a3-0242ac170006.png',	'Basilique Saint Epvre',	'48.695718123367',	'6.1801046133041',	23),
(81,	'9f8869ba-0e4d-11e8-91df-0242ac170006.png',	'Saint Sebastien',	'48.688077415705',	'6.1809065937996',	23),
(82,	'a90b05ce-0e4d-11e8-a50f-0242ac170006.png',	'Gare',	'48.688649823399',	'6.1759579181671',	23),
(83,	'b78bb044-0e4d-11e8-9ed0-0242ac170006.png',	'Musee de l&#39;ecole de nancy',	'48.680568992846',	'6.1661437153816',	23),
(84,	'bfe14da8-0e4d-11e8-8f72-0242ac170006.png',	'iut charlemagne',	'48.682892556948',	'6.160983145237',	23),
(85,	'd4f4abcc-0e4d-11e8-91ba-0242ac170006.png',	'kinepolis',	'48.691696023315',	'6.1959511041641',	23),
(86,	'fa954d50-0e4d-11e8-9942-0242ac170006.png',	'Prefecture',	'48.694107891012',	'6.1847099661827',	23),
(87,	'05367a04-0e4e-11e8-a737-0242ac170006.png',	'Porte de la Craffe',	'48.699029599471',	'6.1777630448341',	23),
(88,	'12dbe0cc-0e4e-11e8-9934-0242ac170006.png',	'Porte de la Craffe',	'48.698997724345',	'6.1777791380882',	23),
(89,	'1c1cb940-0e4e-11e8-a168-0242ac170006.png',	'Parc de la pepiniere',	'48.697906469263',	'6.1846965551376',	23),
(90,	'2471b7bc-0e4e-11e8-bd5b-0242ac170006.png',	'Place Stanislas',	'48.693541364705',	'6.1832776665688',	23),
(91,	'31a78e2a-0e4e-11e8-8d4a-0242ac170006.png',	'Villa Majorelle',	'48.685460233426',	'6.1638906598091',	23);

DROP TABLE IF EXISTS `geo_serie`;
CREATE TABLE `geo_serie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `distance` varchar(255) NOT NULL DEFAULT '',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `city_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `serie_city_id_foreign` (`city_id`),
  CONSTRAINT `serie_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `geo_city` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `geo_serie` (`id`, `distance`, `updated_at`, `created_at`, `city_id`, `image`, `name`) VALUES
(23,	'70',	'2018-02-10 10:30:29',	'0000-00-00 00:00:00',	1,	'6aa9309e-0e4d-11e8-9363-0242ac170006.png',	'Découvre ma ville');

DROP TABLE IF EXISTS `geo_temps`;
CREATE TABLE `geo_temps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nb_seconds` int(11) NOT NULL,
  `coef` int(11) NOT NULL,
  `serie_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `temps_serie_id_foreign` (`serie_id`),
  CONSTRAINT `temps_serie_id_foreign` FOREIGN KEY (`serie_id`) REFERENCES `geo_serie` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `geo_temps` (`id`, `nb_seconds`, `coef`, `serie_id`) VALUES
(58,	5,	4,	23),
(59,	10,	2,	23),
(60,	20,	1,	23);

-- 2018-02-10 10:46:44