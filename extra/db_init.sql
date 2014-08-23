-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.6.16 - MySQL Community Server (GPL)
-- ОС Сервера:                   Win32
-- HeidiSQL Версия:              8.2.0.4675
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры базы данных quote
DROP DATABASE IF EXISTS `quote`;
CREATE DATABASE IF NOT EXISTS `quote` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `quote`;


-- Дамп структуры для таблица quote.authors
DROP TABLE IF EXISTS `authors`;
CREATE TABLE IF NOT EXISTS `authors` (
  `a_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `a_name` varchar(255) NOT NULL DEFAULT '0',
  `a_bio` varchar(32) DEFAULT NULL,
  `a_fullname` varchar(32) DEFAULT NULL,
  `a_died` varchar(32) DEFAULT NULL,
  `a_born` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`a_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы quote.authors: ~1 rows (приблизительно)
DELETE FROM `authors`;
/*!40000 ALTER TABLE `authors` DISABLE KEYS */;
INSERT INTO `authors` (`a_id`, `a_name`, `a_bio`, `a_fullname`, `a_died`, `a_born`) VALUES
	(1, 'Архимед', 'Жил был ', 'Архимед', 'e90281302', '90r823 04r');
/*!40000 ALTER TABLE `authors` ENABLE KEYS */;


-- Дамп структуры для таблица quote.quotes
DROP TABLE IF EXISTS `quotes`;
CREATE TABLE IF NOT EXISTS `quotes` (
  `q_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `q_active` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `author_id` int(10) unsigned NOT NULL DEFAULT '0',
  `q_text` text NOT NULL,
  PRIMARY KEY (`q_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы quote.quotes: ~1 rows (приблизительно)
DELETE FROM `quotes`;
/*!40000 ALTER TABLE `quotes` DISABLE KEYS */;
INSERT INTO `quotes` (`q_id`, `q_active`, `author_id`, `q_text`) VALUES
	(1, 1, 1, 'fsdfasdfsdaf sdaf kjsadlkjf asdjfl s'),
	(2, 1, 1, 'Жил бы пёс!');
/*!40000 ALTER TABLE `quotes` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
