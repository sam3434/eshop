-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Апр 09 2013 г., 20:37
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `eshop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_category` smallint(5) unsigned DEFAULT NULL,
  `name` varchar(350) DEFAULT NULL,
  `small_descr` varchar(1024) DEFAULT NULL,
  `descr` text,
  `small_image` varchar(512) DEFAULT NULL,
  `image` varchar(512) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `date_add` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`id`, `id_category`, `name`, `small_descr`, `descr`, `small_image`, `image`, `price`, `date_add`) VALUES
(1, 1, 'qw', 'qw', 'qw', 'qw', 'qw', 0, '2013-04-09 16:31:23'),
(2, 1, 'qwd', 'qwd', 'qwd', 'qwd', 'qwd', 0, '2013-04-09 16:42:14'),
(3, 1, 'qwd', 'qwd', 'qwd', 'qwd', 'qwd', 0, '2013-04-09 16:44:27'),
(4, 1, 'qwd', 'qwd', 'qwd', 'qwd', 'qwd', 0, '2013-04-09 16:45:49'),
(5, 4, 'we', 'we', 'we', 'we', 'we', 0, '2013-04-09 18:44:08'),
(6, 5, '&Ntilde;', '&Ntilde;', '&Ntilde;', '&Ntilde;', '&Ntilde;', 0, '2013-04-09 20:17:59'),
(7, 5, '&ETH;&deg;&ETH;&sup2;', '&ETH;&deg;&ETH;&sup2;', '&ETH;&deg;&ETH;&sup2;', '&ETH;&sup2;&ETH;&deg;', '&ETH;&sup2;&ETH;&deg;', 0, '2013-04-09 20:20:02'),
(8, 5, '&Ntilde;', '&Ntilde;', '&Ntilde;', '&ETH;&sup1;&Ntilde;', '&Ntilde;', 0, '2013-04-09 20:20:40'),
(9, 5, '&Ntilde;', '&Ntilde;', '&Ntilde;', '&Ntilde;', '&Ntilde;', 0, '2013-04-09 20:21:26'),
(10, 5, '&Ntilde;', '&Ntilde;', '&ETH;&sup1;&Ntilde;', '&ETH;&deg;&Ntilde;', '&ETH;&sup1;&Ntilde;', 0, '2013-04-09 20:24:59'),
(11, 5, '&Ntilde;„&Ntilde;ѓ', '&ETH;&sup1;&Ntilde;', '&ETH;&deg;&ETH;&sup1;', '&ETH;&sup1;&Ntilde;', '&ETH;&sup1;&Ntilde;', 0, '2013-04-09 20:28:21'),
(12, 5, '&Ntilde;‹&Ntilde;Ѓ&Ntilde;‹', '&Ntilde;', '&Ntilde;', '&Ntilde;', '&ETH;&sup2;&Ntilde;', 0, '2013-04-09 20:30:41'),
(13, 5, '&Ntilde;', '&Ntilde;', '&Ntilde;', '&Ntilde;', '&Ntilde;', 0, '2013-04-09 20:32:56');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
