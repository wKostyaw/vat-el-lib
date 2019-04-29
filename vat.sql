-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 29 2019 г., 20:58
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
-- Структура таблицы `autors`
--

CREATE TABLE `autors` (
  `Autors` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `books`
--

CREATE TABLE `books` (
  `BookID` int(9) NOT NULL,
  `BookName` varchar(255) NOT NULL,
  `BookYear` smallint(4) NOT NULL,
  `PathToFile` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `books`
--

INSERT INTO `books` (`BookID`, `BookName`, `BookYear`, `PathToFile`) VALUES
(6, 'Ваня', 2018, 'Files/'),
(7, '43242', 2342, 'Files/'),
(8, '3123', 123, 'Files/3123123.pdf');

-- --------------------------------------------------------

--
-- Структура таблицы `books_and_authors`
--

CREATE TABLE `books_and_authors` (
  `BookID` int(11) NOT NULL,
  `BookAuthor` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Структура таблицы `books_and_categories`
--

CREATE TABLE `books_and_categories` (
  `BookID` int(11) NOT NULL,
  `BookCategory` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `Categories` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `loginparol`
--

CREATE TABLE `loginparol` (
  `id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `loginparol`
--

INSERT INTO `loginparol` (`id`, `login`, `password`, `admin`) VALUES
(1, 'admin', '2', 1),
(2, 'izvekov', '3', 1),
(3, 'common', '1', 0),
(4, '12421412', '4', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `test`
--

CREATE TABLE `test` (
  `tags` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `test`
--

INSERT INTO `test` (`tags`) VALUES
('Толстой'),
('Пушкин'),
('Лермонтов'),
('Чехов'),
('sobaka');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `autors`
--
ALTER TABLE `autors`
  ADD PRIMARY KEY (`Autors`);

--
-- Индексы таблицы `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`BookID`),
  ADD UNIQUE KEY `BookID_3` (`BookID`),
  ADD KEY `BookID` (`BookID`),
  ADD KEY `BookID_2` (`BookID`);

--
-- Индексы таблицы `books_and_authors`
--
ALTER TABLE `books_and_authors`
  ADD KEY `BookID` (`BookID`),
  ADD KEY `BookAuthor` (`BookAuthor`);

--
-- Индексы таблицы `books_and_categories`
--
ALTER TABLE `books_and_categories`
  ADD KEY `BookCategory` (`BookCategory`),
  ADD KEY `BookID` (`BookID`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`Categories`);

--
-- Индексы таблицы `loginparol`
--
ALTER TABLE `loginparol`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `books`
--
ALTER TABLE `books`
  MODIFY `BookID` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `loginparol`
--
ALTER TABLE `loginparol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `books_and_authors`
--
ALTER TABLE `books_and_authors`
  ADD CONSTRAINT `books_and_authors_ibfk_1` FOREIGN KEY (`BookID`) REFERENCES `books` (`BookID`),
  ADD CONSTRAINT `books_and_authors_ibfk_2` FOREIGN KEY (`BookAuthor`) REFERENCES `autors` (`Autors`);

--
-- Ограничения внешнего ключа таблицы `books_and_categories`
--
ALTER TABLE `books_and_categories`
  ADD CONSTRAINT `books_and_categories_ibfk_1` FOREIGN KEY (`BookID`) REFERENCES `books` (`BookID`),
  ADD CONSTRAINT `books_and_categories_ibfk_2` FOREIGN KEY (`BookCategory`) REFERENCES `categories` (`Categories`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
