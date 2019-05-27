-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 27 2019 г., 18:23
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
-- Структура таблицы `authors`
--

CREATE TABLE `authors` (
  `AuthorID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `authors`
--

INSERT INTO `authors` (`AuthorID`, `Name`) VALUES
(4, 'Гоголь Н. В.'),
(14, 'Греков В. Ф.'),
(7, 'Извеков И. Г.'),
(15, 'Крючков С. Е.'),
(3, 'Лермонтов М. Ю.'),
(1, 'Пушкин А. С.'),
(5, 'Тургенев И. С.'),
(2, 'Чехов А. П.'),
(16, 'Чешко Л. А.');

-- --------------------------------------------------------

--
-- Структура таблицы `books`
--

CREATE TABLE `books` (
  `BookID` int(11) NOT NULL,
  `BookName` varchar(255) NOT NULL,
  `BookYear` smallint(4) NOT NULL,
  `Description` text NOT NULL,
  `PathToFile` varchar(255) NOT NULL,
  `PathToCover` varchar(255) NOT NULL DEFAULT 'Img/BookDefault.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `books`
--

INSERT INTO `books` (`BookID`, `BookName`, `BookYear`, `Description`, `PathToFile`, `PathToCover`) VALUES
(71, 'Капитанская дочка', 1836, '«Капита́нская до́чка» — исторический роман Александра Пушкина, действие которого происходит во время восстания Емельяна Пугачёва. Впервые опубликован без указания имени автора в 4-й книжке журнала «Современник», поступившей в продажу в последней декаде 1836 года', 'Files/Капитанская дочка1836.txt', 'Img/BookDefault.png'),
(72, 'Отцы и дети', 1862, '«Отцы́ и де́ти» — роман русского писателя Ивана Сергеевича Тургенева, написанный в 60-е годы XIX века. Роман стал знаковым для своего времени, а образ главного героя Евгения Базарова был воспринят молодёжью как пример для подражания', 'Files/Отцы и дети1862.txt', 'Img/BookDefault.png'),
(73, 'Пособие для занятий по русскому языку в старших классах', 2002, 'Пособие поможет учащимся систематизировать и обобщить полученные знания по русскому языку.\r\nВ книге значительное место отводится работе с текстами из художественных произведений, которые в настоящее время изучаются на уроках литературы и входят в школьную программу. ', 'Files/Пособие для занятий по русскому языку в старших классах2002.docx', 'Img/BookDefault.png'),
(74, 'Руслан и Людмила', 1820, '«Русла́н и Людми́ла» — первая законченная поэма Александра Сергеевича Пушкина; волшебная сказка, вдохновлённая древнерусскими былинами.', 'Files/Руслан и Людмила1820.html', 'Img/BookDefault.png'),
(75, 'Пиковая дама', 1834, '«Пи́ковая да́ма» — повесть Александра Сергеевича Пушкина с мистическими элементами, послужившая источником сюжета одноимённой оперы П. И. Чайковского.', 'Files/Пиковая дама1834.pdf', 'Covers/Пиковая дама1834.png');

-- --------------------------------------------------------

--
-- Структура таблицы `books_and_authors`
--

CREATE TABLE `books_and_authors` (
  `BookID` int(11) NOT NULL,
  `AuthorID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `books_and_authors`
--

INSERT INTO `books_and_authors` (`BookID`, `AuthorID`) VALUES
(71, 1),
(72, 5),
(73, 14),
(73, 15),
(73, 16),
(74, 1),
(75, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `books_and_categories`
--

CREATE TABLE `books_and_categories` (
  `BookID` int(11) NOT NULL,
  `CategoryID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `books_and_categories`
--

INSERT INTO `books_and_categories` (`BookID`, `CategoryID`) VALUES
(71, 1),
(72, 1),
(73, 28),
(73, 29),
(74, 30),
(75, 1),
(75, 29);

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `CategoryID` int(11) NOT NULL,
  `Category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`CategoryID`, `Category`) VALUES
(1, 'Роман'),
(2, 'Рассказ'),
(3, 'Повесть'),
(4, 'Новелла'),
(5, 'Очерк'),
(6, 'Пьеса'),
(7, 'Эпос'),
(8, 'Эссе'),
(28, 'Учебник'),
(29, '1 курс'),
(30, 'Поэма');

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
(1, 'admin', '1', 1),
(2, 'izvekov', '6WKpAJ3IKj', 1),
(10, 'lox', 'IduHGtGGrY', 1),
(11, 'lox-sequel', 'utVlg0AwBo', 0);

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

-- --------------------------------------------------------

--
-- Структура таблицы `users_and_books`
--

CREATE TABLE `users_and_books` (
  `id` int(11) NOT NULL,
  `BookID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users_and_books`
--

INSERT INTO `users_and_books` (`id`, `BookID`) VALUES
(1, 71);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`AuthorID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Индексы таблицы `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`BookID`),
  ADD UNIQUE KEY `BookName` (`BookName`);

--
-- Индексы таблицы `books_and_authors`
--
ALTER TABLE `books_and_authors`
  ADD KEY `BookID` (`BookID`),
  ADD KEY `AuthorID` (`AuthorID`),
  ADD KEY `BookID_2` (`BookID`,`AuthorID`);

--
-- Индексы таблицы `books_and_categories`
--
ALTER TABLE `books_and_categories`
  ADD KEY `BookID` (`BookID`,`CategoryID`),
  ADD KEY `books_and_categories_ibfk_2` (`CategoryID`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Индексы таблицы `loginparol`
--
ALTER TABLE `loginparol`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- Индексы таблицы `users_and_books`
--
ALTER TABLE `users_and_books`
  ADD KEY `id` (`id`),
  ADD KEY `BookID` (`BookID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `authors`
--
ALTER TABLE `authors`
  MODIFY `AuthorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `books`
--
ALTER TABLE `books`
  MODIFY `BookID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT для таблицы `loginparol`
--
ALTER TABLE `loginparol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `books_and_authors`
--
ALTER TABLE `books_and_authors`
  ADD CONSTRAINT `books_and_authors_ibfk_1` FOREIGN KEY (`BookID`) REFERENCES `books` (`BookID`) ON DELETE CASCADE,
  ADD CONSTRAINT `books_and_authors_ibfk_2` FOREIGN KEY (`AuthorID`) REFERENCES `authors` (`AuthorID`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `books_and_categories`
--
ALTER TABLE `books_and_categories`
  ADD CONSTRAINT `books_and_categories_ibfk_1` FOREIGN KEY (`BookID`) REFERENCES `books` (`BookID`) ON DELETE CASCADE,
  ADD CONSTRAINT `books_and_categories_ibfk_2` FOREIGN KEY (`CategoryID`) REFERENCES `categories` (`CategoryID`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users_and_books`
--
ALTER TABLE `users_and_books`
  ADD CONSTRAINT `users_and_books_ibfk_1` FOREIGN KEY (`id`) REFERENCES `loginparol` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_and_books_ibfk_2` FOREIGN KEY (`BookID`) REFERENCES `books` (`BookID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
