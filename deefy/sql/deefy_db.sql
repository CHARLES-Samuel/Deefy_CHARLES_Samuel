SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `user2playlist`;
DROP TABLE IF EXISTS `playlist2track`;
DROP TABLE IF EXISTS `User`;
DROP TABLE IF EXISTS `track`;
DROP TABLE IF EXISTS `playlist`;

CREATE TABLE `playlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_liste` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `playlist` (`id`, `nom_liste`) VALUES
(1, 'Best of Slaughter to Prevail'),
(2, 'Best of Falling In Reverse'),
(3, 'Best of Slipknot'),
(4, 'Best of System Of A Down'),
(5, 'Best of David'),
(6, 'Best of Gojira'),
(7, 'Best of Lorna Shore');

CREATE TABLE `track` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(100) NOT NULL,
  `genre` varchar(30) DEFAULT NULL,
  `duree` int(3) DEFAULT NULL,
  `filename` varchar(100) DEFAULT NULL,
  `type` varchar(30) DEFAULT NULL,
  `artiste_album` varchar(30) DEFAULT NULL,
  `titre_album` varchar(30) DEFAULT NULL,
  `annee_album` int(4) DEFAULT NULL,
  `numero_album` int(11) DEFAULT NULL,
  `auteur_podcast` varchar(100) DEFAULT NULL,
  `date_podcast` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `track` (`id`, `titre`, `genre`, `duree`, `filename`, `type`, `artiste_album`, `titre_album`, `annee_album`, `numero_album`, `auteur_podcast`, `date_podcast`) VALUES
(1, 'Demolisher', 'deathcore', 205, 'demolisher.mp3', 'A', 'Slaughter to Prevail', 'Kostolom', 2021, 1, NULL, NULL),
(2, 'Baba Yaga', 'deathcore', 263, 'baba_yaga.mp3', 'A', 'Slaughter to Prevail', 'Kostolom', 2021, 2, NULL, NULL),
(3, '1984', 'deathcore', 215, '1984.mp3', 'A', 'Slaughter to Prevail', 'Grizzly', 2022, 1, NULL, NULL),
(4, 'Popular Monster', 'metalcore', 220, 'popular_monster.mp3', 'A', 'Falling In Reverse', 'Popular Monster', 2024, 1, NULL, NULL),
(5, 'Watch The World Burn', 'metalcore', 203, 'watch_world_burn.mp3', 'A', 'Falling In Reverse', 'Popular Monster', 2024, 2, NULL, NULL),
(6, 'Ronald', 'metalcore', 198, 'ronald.mp3', 'A', 'Falling In Reverse', 'Popular Monster', 2024, 3, NULL, NULL),
(7, 'Psychosocial', 'nu metal', 284, 'psychosocial.mp3', 'A', 'Slipknot', 'All Hope Is Gone', 2008, 1, NULL, NULL),
(8, 'Duality', 'nu metal', 252, 'duality.mp3', 'A', 'Slipknot', 'Vol. 3', 2004, 1, NULL, NULL),
(9, 'Wait and Bleed', 'nu metal', 147, 'wait_and_bleed.mp3', 'A', 'Slipknot', 'Slipknot', 1999, 1, NULL, NULL),
(10, 'Chop Suey!', 'nu metal', 210, 'chop_suey.mp3', 'A', 'System Of A Down', 'Toxicity', 2001, 1, NULL, NULL),
(11, 'Toxicity', 'nu metal', 219, 'toxicity.mp3', 'A', 'System Of A Down', 'Toxicity', 2001, 2, NULL, NULL),
(12, 'B.Y.O.B.', 'nu metal', 255, 'byob.mp3', 'A', 'System Of A Down', 'Mezmerize', 2005, 1, NULL, NULL),
(13, 'Drapeau', 'rock / alt-metal', 195, 'drapeau.mp3', 'A', 'DaviD', 'Le but du je', 2025, 1, NULL, NULL),
(14, 'Le but du je', 'rock / alt-metal', 210, 'le_but_du_je.mp3', 'A', 'DaviD', 'Le but du je', 2025, 2, NULL, NULL),
(15, 'Petit prince', 'rock / alt-metal', 200, 'petit_prince.mp3', 'A', 'DaviD', 'Le but du je', 2025, 4, NULL, NULL),
(16, 'Stranded', 'groove metal', 269, 'stranded.mp3', 'A', 'Gojira', 'Magma', 2016, 1, NULL, NULL),
(17, 'Silvera', 'groove metal', 213, 'silvera.mp3', 'A', 'Gojira', 'Magma', 2016, 2, NULL, NULL),
(18, 'To the Hellfire', 'deathcore', 369, 'hellfire.mp3', 'A', 'Lorna Shore', 'Return to Nothingness', 2021, 1, NULL, NULL),
(19, 'Sun//Eater', 'deathcore', 370, 'sun_eater.mp3', 'A', 'Lorna Shore', 'Pain Remains', 2022, 1, NULL, NULL);

CREATE TABLE `User` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(256) NOT NULL,
  `passwd` varchar(256) NOT NULL,
  `role` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `User` (`id`, `email`, `passwd`, `role`) VALUES
(1, 'user1@mail.com', '$2y$12$e9DCiDKOGpVs9s.9u2ENEOiq7wGvx7sngyhPvKXo2mUbI3ulGWOdC', 1),
(2, 'user2@mail.com', '$2y$12$4EuAiwZCaMouBpquSVoiaOnQTQTconCP9rEev6DMiugDmqivxJ3AG', 1),
(3, 'user3@mail.com', '$2y$12$5dDqgRbmCN35XzhniJPJ1ejM5GIpBMzRizP730IDEHsSNAu24850S', 1),
(4, 'user4@mail.com', '$2y$12$ltC0A0zZkD87pZ8K0e6TYOJPJeN/GcTSkUbpqq0kBvx6XdpFqzzqq', 1),
(5, 'admin@mail.com', '$2y$12$JtV1W6MOy/kGILbNwGR2lOqBn8PAO3Z6MupGhXpmkeCXUPQ/wzD8a', 100);

CREATE TABLE `playlist2track` (
  `id_pl` int(11) NOT NULL,
  `id_track` int(11) NOT NULL,
  `no_piste_dans_liste` int(3) NOT NULL,
  PRIMARY KEY (`id_pl`, `id_track`),
  KEY `id_track` (`id_track`),
  CONSTRAINT `playlist2track_ibfk_1` FOREIGN KEY (`id_pl`) REFERENCES `playlist` (`id`),
  CONSTRAINT `playlist2track_ibfk_2` FOREIGN KEY (`id_track`) REFERENCES `track` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `playlist2track` (`id_pl`, `id_track`, `no_piste_dans_liste`) VALUES
(1, 1, 1),
(1, 2, 2),
(1, 3, 3),
(2, 4, 1),
(2, 5, 2),
(2, 6, 3),
(3, 7, 1),
(3, 8, 2),
(3, 9, 3),
(4, 10, 1),
(4, 11, 2),
(4, 12, 3),
(5, 13, 1),
(5, 14, 2),
(5, 15, 3),
(6, 16, 1),
(6, 17, 2),
(7, 18, 1),
(7, 19, 2);

CREATE TABLE `user2playlist` (
  `id_user` int(11) NOT NULL,
  `id_pl` int(11) NOT NULL,
  PRIMARY KEY (`id_user`, `id_pl`),
  KEY `id_pl` (`id_pl`),
  CONSTRAINT `user2playlist_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `User` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `user2playlist_ibfk_2` FOREIGN KEY (`id_pl`) REFERENCES `playlist` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user2playlist` (`id_user`, `id_pl`) VALUES
(1, 1),
(1, 2),
(2, 3),
(2, 5),
(3, 4),
(3, 6),
(3, 7);

SET foreign_key_checks = 1;
