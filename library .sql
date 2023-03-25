-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Мар 25 2023 г., 22:31
-- Версия сервера: 10.4.25-MariaDB
-- Версия PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `library`
--

-- --------------------------------------------------------

--
-- Структура таблицы `book`
--

CREATE TABLE `book` (
  `bookId` bigint(20) UNSIGNED NOT NULL,
  `bookName` varchar(200) NOT NULL,
  `numberOfPages` bigint(255) NOT NULL,
  `author` varchar(140) NOT NULL,
  `categoryId` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `book`
--

INSERT INTO `book` (`bookId`, `bookName`, `numberOfPages`, `author`, `categoryId`) VALUES
(1, 'Кров і попіл: Війна двох королев', 752, 'Дженніфер Л. Арментраут', 1),
(2, 'Воскреситель. Анатомія фантастичних істот', 192, 'Ерік Б. Гадспет', 7),
(3, 'П’ять ночей із Фредді. Книга 1: Срібні очі', 368, 'Скотт Коутон', 3),
(4, 'Розум убивці', 400, 'Майк Омер', 4),
(5, 'Спаси себя', 352, 'Мона Кастен', 2),
(6, 'Богатир. Книга 1: Сталеве жезло', 464, 'Юрай Червенак', 1),
(7, 'Говорить тиша', 136, 'Екгарт Толле', 7),
(8, 'Начерки сталі: Битва безсмертних', 360, 'Аркадій Саульський', 3),
(9, 'Шифр', 384, 'Ізабелла Мальдонадо', 5),
(10, 'Корона опівночі', 528, 'Дж. Маас Сара', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `borrowbook`
--

CREATE TABLE `borrowbook` (
  `borrowBookId` bigint(20) UNSIGNED NOT NULL,
  `visitorId` bigint(20) UNSIGNED NOT NULL,
  `librarianId` bigint(20) UNSIGNED NOT NULL,
  `bookId` bigint(20) UNSIGNED NOT NULL,
  `dateGiven` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `borrowbook`
--

INSERT INTO `borrowbook` (`borrowBookId`, `visitorId`, `librarianId`, `bookId`, `dateGiven`) VALUES
(1, 3, 6, 2, '2023-01-17'),
(2, 10, 8, 2, '2023-01-23'),
(3, 4, 2, 4, '2023-03-05'),
(4, 6, 10, 3, '2023-01-21'),
(7, 9, 5, 4, '2023-02-01'),
(8, 9, 8, 9, '2023-02-01'),
(9, 7, 6, 1, '2023-01-12'),
(10, 8, 9, 2, '2023-03-24'),
(11, 1, 5, 8, '2023-01-17'),
(12, 2, 1, 8, '2023-01-23');

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `categoryId` bigint(20) UNSIGNED NOT NULL,
  `categoryName` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`categoryId`, `categoryName`) VALUES
(1, 'Фентезі'),
(2, 'Романтика'),
(3, 'Фантастика'),
(4, 'Трилер'),
(5, 'Детектив'),
(6, 'Бойовик'),
(7, 'Містика/Жахи');

-- --------------------------------------------------------

--
-- Структура таблицы `librarian`
--

CREATE TABLE `librarian` (
  `librarianId` bigint(20) UNSIGNED NOT NULL,
  `Name` varchar(140) NOT NULL,
  `DateOfBirth` date NOT NULL,
  `PhoneNumber` int(10) NOT NULL,
  `Wage` float NOT NULL,
  `Email` varchar(32) CHARACTER SET utf8mb4 NOT NULL,
  `Password` varchar(32) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `librarian`
--

INSERT INTO `librarian` (`librarianId`, `Name`, `DateOfBirth`, `PhoneNumber`, `Wage`, `Email`, `Password`) VALUES
(1, 'Князев Ф. А.', '1997-09-12', 992980081, 9000, 'bautizo@gmail.com', 'vi4AC99aE5'),
(2, 'Кондратев Т. Р.', '1997-10-16', 918202343, 8000, 'potensialene@gmail.com', '9cnnX65N8T'),
(3, 'Волкова Е. А.', '1999-07-22', 937328425, 8000, 'bekendmaak@gmail.com', 'G8bc7iHH32'),
(4, 'Круглова К. А.', '1991-03-17', 967307231, 8000, 'ruzycki@gmail.com', '3837BebyPA'),
(5, 'Фомичев І. П.', '1997-05-16', 932307414, 8000, 'unhoardi@gmail.com', '4sEx5B9P7z'),
(6, 'Попов А. І.', '1995-12-26', 915675090, 8000, 'bergkloven@gmail.com', '8f8eZL7d7E'),
(7, 'Тихонова В. П.', '1996-11-16', 985940892, 9000, 'hexametrist@gmail.com', 'k9L2R57enM'),
(8, 'Садий О. К.', '1989-10-06', 567480270, 8000, 'dgwhefhfh@gmail.com', '49846783603'),
(9, 'Мудрик . О. Ж.', '1999-04-04', 634554450, 9000, 'fgfweywry@gmail.com', '436365365356'),
(10, 'Щедрик Б. В.', '1999-09-19', 524252525, 8000, '634rgr5y@gmail.com', '653hgr535rg'),
(12, '2', '2000-10-10', 2, 8000, '2@gmail.com', '2');

-- --------------------------------------------------------

--
-- Структура таблицы `visitor`
--

CREATE TABLE `visitor` (
  `visitorId` bigint(20) UNSIGNED NOT NULL,
  `Name` varchar(140) NOT NULL,
  `DateOfBirth` date NOT NULL,
  `PhoneNumber` int(10) DEFAULT NULL,
  `Email` varchar(32) CHARACTER SET utf8mb4 NOT NULL,
  `Password` varchar(32) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `visitor`
--

INSERT INTO `visitor` (`visitorId`, `Name`, `DateOfBirth`, `PhoneNumber`, `Email`, `Password`) VALUES
(1, 'Острихін Д. О.', '1993-03-13', 567876761, 'rootg456@gmail.com', '56789034ghj'),
(2, 'Зеленский Д. К.', '1991-01-11', 123980045, 'gdfsggs@gmail.com', 'dgdwgwfhefah'),
(3, 'Окуркін С. Т.', '1997-09-12', 325264666, 'dolfi@gmail.com', '666444555gh'),
(4, 'Круглова К. А.', '1999-07-22', 566677890, 'fengy@gmail.com', 'qweertyyyy1'),
(5, 'Орлик П. І.', '1998-08-18', 117123567, 'your1234@gmail.com', '12343656fghfhfh'),
(6, 'Омар Д. К.', '1997-10-12', 456532770, '45646367gor@gmail.com', 'rttyyyyy455544'),
(7, 'Вінчестер Д.Д', '1997-05-16', 666666123, 'DW12345@gmail.com', 'impala1967'),
(8, 'Вінчестер С. Д.', '1996-06-16', 666666136, 'SW85959598@gmail.com', 'sam12345'),
(9, 'Вінник О.І.', '1999-08-19', 878694499, '23434346gr@gmail.com', '25rhfh45yh'),
(10, 'Огієнко А. Д.', '1997-07-17', 452526636, 'fbhefut3ygh@gmail.com', '466456753735'),
(12, 'Острихін Д. 1', '1993-03-01', 567876111, '111@gmail.com', '1111');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`bookId`),
  ADD UNIQUE KEY `bookId` (`bookId`),
  ADD KEY `authorId` (`categoryId`),
  ADD KEY `categoryId` (`categoryId`);

--
-- Индексы таблицы `borrowbook`
--
ALTER TABLE `borrowbook`
  ADD PRIMARY KEY (`borrowBookId`),
  ADD UNIQUE KEY `borrowBookId` (`borrowBookId`),
  ADD KEY `visitorId` (`visitorId`),
  ADD KEY `librarianId` (`librarianId`),
  ADD KEY `bookId` (`bookId`);

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`categoryId`);

--
-- Индексы таблицы `librarian`
--
ALTER TABLE `librarian`
  ADD PRIMARY KEY (`librarianId`);

--
-- Индексы таблицы `visitor`
--
ALTER TABLE `visitor`
  ADD UNIQUE KEY `visitorId` (`visitorId`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `book`
--
ALTER TABLE `book`
  MODIFY `bookId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `borrowbook`
--
ALTER TABLE `borrowbook`
  MODIFY `borrowBookId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `categoryId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `librarian`
--
ALTER TABLE `librarian`
  MODIFY `librarianId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `visitor`
--
ALTER TABLE `visitor`
  MODIFY `visitorId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_2` FOREIGN KEY (`categoryId`) REFERENCES `category` (`categoryId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `borrowbook`
--
ALTER TABLE `borrowbook`
  ADD CONSTRAINT `borrowbook_ibfk_1` FOREIGN KEY (`visitorId`) REFERENCES `visitor` (`visitorId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `borrowbook_ibfk_2` FOREIGN KEY (`librarianId`) REFERENCES `librarian` (`librarianId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `borrowbook_ibfk_3` FOREIGN KEY (`bookId`) REFERENCES `book` (`bookId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
