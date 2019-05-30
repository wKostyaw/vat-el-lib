-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 30 2019 г., 22:39
-- Версия сервера: 10.3.13-MariaDB
-- Версия PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `vat`
--

-- --------------------------------------------------------

--
-- Структура таблицы `slideroptions`
--

CREATE TABLE `slideroptions` (
  `sliderId` int(11) NOT NULL,
  `amount` int(5) NOT NULL,
  `whatToDo` int(1) NOT NULL DEFAULT 0,
  `categoryOrAuthorID` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `slideroptions`
--

INSERT INTO `slideroptions` (`sliderId`, `amount`, `whatToDo`, `categoryOrAuthorID`) VALUES
(1, 10, 0, 0),
(2, 10, 1, 1),
(3, 10, 2, 1),
(13, 5, 1, 4);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `slideroptions`
--
ALTER TABLE `slideroptions`
  ADD PRIMARY KEY (`sliderId`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `slideroptions`
--
ALTER TABLE `slideroptions`
  MODIFY `sliderId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
