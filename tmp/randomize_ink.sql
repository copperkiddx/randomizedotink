# ************************************************************
# Sequel Ace SQL dump
# Version 20062
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: localhost (MySQL 8.0.31)
# Database: lorcana
# Generation Time: 2024-03-21 14:23:35 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE='NO_AUTO_VALUE_ON_ZERO', SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table decks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `decks`;

CREATE TABLE `decks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `draft_id` int DEFAULT NULL,
  `player_number` int DEFAULT NULL,
  `player_code` int DEFAULT NULL,
  `card_01` int DEFAULT NULL,
  `card_02` int DEFAULT NULL,
  `card_03` int DEFAULT NULL,
  `card_04` int DEFAULT NULL,
  `card_05` int DEFAULT NULL,
  `card_06` int DEFAULT NULL,
  `card_07` int DEFAULT NULL,
  `card_08` int DEFAULT NULL,
  `card_09` int DEFAULT NULL,
  `card_10` int DEFAULT NULL,
  `card_11` int DEFAULT NULL,
  `card_12` int DEFAULT NULL,
  `card_13` int DEFAULT NULL,
  `card_14` int DEFAULT NULL,
  `card_15` int DEFAULT NULL,
  `card_16` int DEFAULT NULL,
  `card_17` int DEFAULT NULL,
  `card_18` int DEFAULT NULL,
  `card_19` int DEFAULT NULL,
  `card_20` int DEFAULT NULL,
  `card_21` int DEFAULT NULL,
  `card_22` int DEFAULT NULL,
  `card_23` int DEFAULT NULL,
  `card_24` int DEFAULT NULL,
  `card_25` int DEFAULT NULL,
  `card_26` int DEFAULT NULL,
  `card_27` int DEFAULT NULL,
  `card_28` int DEFAULT NULL,
  `card_29` int DEFAULT NULL,
  `card_30` int DEFAULT NULL,
  `card_31` int DEFAULT NULL,
  `card_32` int DEFAULT NULL,
  `card_33` int DEFAULT NULL,
  `card_34` int DEFAULT NULL,
  `card_35` int DEFAULT NULL,
  `card_36` int DEFAULT NULL,
  `card_37` int DEFAULT NULL,
  `card_38` int DEFAULT NULL,
  `card_39` int DEFAULT NULL,
  `card_40` int DEFAULT NULL,
  `card_41` int DEFAULT NULL,
  `card_42` int DEFAULT NULL,
  `card_43` int DEFAULT NULL,
  `card_44` int DEFAULT NULL,
  `card_45` int DEFAULT NULL,
  `card_46` int DEFAULT NULL,
  `card_47` int DEFAULT NULL,
  `card_48` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
