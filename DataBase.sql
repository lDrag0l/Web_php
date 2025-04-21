-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Хост: mysql
-- Время создания: Апр 21 2025 г., 15:49
-- Версия сервера: 8.0.41
-- Версия PHP: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `Тренажерный_зал`
--

-- --------------------------------------------------------

--
-- Структура таблицы `Абонементы`
--

CREATE TABLE `Абонементы` (
  `Код_абонемента` int NOT NULL,
  `Название` varchar(100) NOT NULL,
  `Описание` text,
  `Цена` decimal(10,2) NOT NULL,
  `Срок_действия` int NOT NULL COMMENT 'В днях',
  `Количество_посещений` int DEFAULT NULL COMMENT 'NULL - безлимитный'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Абонементы`
--

INSERT INTO `Абонементы` (`Код_абонемента`, `Название`, `Описание`, `Цена`, `Срок_действия`, `Количество_посещений`) VALUES
(1, 'Стандарт', 'Дневной абонемент (с 8:00 до 17:00)', 3000.00, 30, 12),
(2, 'Полный', 'Полный доступ в любое время', 5000.00, 30, NULL),
(3, 'Индивидуальный', 'Персональные тренировки с тренером', 8000.00, 30, 8);

-- --------------------------------------------------------

--
-- Структура таблицы `Группы`
--

CREATE TABLE `Группы` (
  `Код_группы` int NOT NULL,
  `Количество_клиентов` int NOT NULL DEFAULT '0',
  `Номер_секции` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Группы`
--

INSERT INTO `Группы` (`Код_группы`, `Количество_клиентов`, `Номер_секции`) VALUES
(1, 10, 1),
(2, 8, 2),
(3, 12, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `Клиенты`
--

CREATE TABLE `Клиенты` (
  `Код_клиента` int NOT NULL,
  `Фамилия` varchar(50) NOT NULL,
  `Имя` varchar(50) NOT NULL,
  `Отчество` varchar(50) DEFAULT NULL,
  `Дата_рождения` date NOT NULL,
  `Адрес_проживания` varchar(100) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Телефон` varchar(20) DEFAULT NULL,
  `Пароль` varchar(255) DEFAULT NULL,
  `Дата_регистрации` date DEFAULT NULL,
  `Наличие_справки_о_здоровье` tinyint(1) DEFAULT '0',
  `Код_абонемента` int DEFAULT NULL,
  `Начало_действия` date DEFAULT NULL,
  `Конец_действия` date DEFAULT NULL,
  `Код_группы` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Клиенты`
--

INSERT INTO `Клиенты` (`Код_клиента`, `Фамилия`, `Имя`, `Отчество`, `Дата_рождения`, `Адрес_проживания`, `Email`, `Телефон`, `Пароль`, `Дата_регистрации`, `Наличие_справки_о_здоровье`, `Код_абонемента`, `Начало_действия`, `Конец_действия`, `Код_группы`) VALUES
(1, 'Смирнов', 'Михаил', 'Александрович', '1985-07-12', 'ул. Ленина, 10, кв. 5', 'smirnov@example.com', '+7 (111) 222-33-44', '$2y$10$ПримерХэша', '2025-01-01', 1, 1, '2025-10-01', '2026-04-01', 1),
(2, 'Козлова', 'Екатерина', 'Сергеевна', '1990-11-25', 'пр. Победы, 25, кв. 12', 'kozlova@example.com', '+7 (222) 333-44-55', '$2y$10$ПримерХэша', '2025-01-01', 1, 2, '2025-10-15', '2026-10-15', 1),
(3, 'Новиков', 'Артем', NULL, '1995-03-18', 'ул. Гагарина, 5, кв. 3', 'novikov@example.com', '+7 (333) 444-55-66', '$2y$10$ПримерХэша', '2025-01-01', 0, 3, '2025-11-01', '2026-02-01', 3),
(4, 'Андриец', 'Руслан', 'Владимирович', '2004-01-08', 'Пр-кт Маршала Жукова 24', 'user@mail.ru', '89999999999', '$2y$10$VAweh0/lKGOXAcbzyXy6AeJjjCUTkGAdn6IZNKE1loRwgm9u8acmC', '2025-04-21', 1, 1, '2025-04-21', '2025-05-21', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `Клиенты_Тренировки`
--

CREATE TABLE `Клиенты_Тренировки` (
  `Код_клиента` int NOT NULL,
  `Код_тренировки` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Клиенты_Тренировки`
--

INSERT INTO `Клиенты_Тренировки` (`Код_клиента`, `Код_тренировки`) VALUES
(1, 1),
(2, 1),
(2, 2),
(3, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `Тренеры`
--

CREATE TABLE `Тренеры` (
  `Код_тренера` int NOT NULL,
  `Фамилия` varchar(50) NOT NULL,
  `Имя` varchar(50) NOT NULL,
  `Отчество` varchar(50) DEFAULT NULL,
  `Телефон` varchar(20) NOT NULL,
  `Разряд` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Тренеры`
--

INSERT INTO `Тренеры` (`Код_тренера`, `Фамилия`, `Имя`, `Отчество`, `Телефон`, `Разряд`) VALUES
(1, 'Иванов', 'Алексей', 'Сергеевич', '+7 (900) 111-22-33', 'Мастер спорта'),
(2, 'Петрова', 'Ольга', 'Игоревна', '+7 (900) 222-33-44', 'Кандидат в мастера спорта'),
(3, 'Сидоров', 'Дмитрий', 'Анатольевич', '+7 (900) 333-44-55', 'Мастер спорта международного класса');

-- --------------------------------------------------------

--
-- Структура таблицы `Тренировки`
--

CREATE TABLE `Тренировки` (
  `Код_тренировки` int NOT NULL,
  `Дата` date NOT NULL,
  `Время` time NOT NULL,
  `Код_группы` int DEFAULT NULL,
  `Код_тренера` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Тренировки`
--

INSERT INTO `Тренировки` (`Код_тренировки`, `Дата`, `Время`, `Код_группы`, `Код_тренера`) VALUES
(1, '2025-11-15', '09:00:00', 1, 1),
(2, '2025-11-16', '18:00:00', 2, 2),
(3, '2025-11-17', '08:00:00', NULL, 3),
(4, '2025-11-18', '17:00:00', 3, 3);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `Абонементы`
--
ALTER TABLE `Абонементы`
  ADD PRIMARY KEY (`Код_абонемента`);

--
-- Индексы таблицы `Группы`
--
ALTER TABLE `Группы`
  ADD PRIMARY KEY (`Код_группы`);

--
-- Индексы таблицы `Клиенты`
--
ALTER TABLE `Клиенты`
  ADD PRIMARY KEY (`Код_клиента`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `Код_абонемента` (`Код_абонемента`),
  ADD KEY `Код_группы` (`Код_группы`);

--
-- Индексы таблицы `Клиенты_Тренировки`
--
ALTER TABLE `Клиенты_Тренировки`
  ADD PRIMARY KEY (`Код_клиента`,`Код_тренировки`),
  ADD KEY `Клиенты_Тренировки_ibfk_2` (`Код_тренировки`);

--
-- Индексы таблицы `Тренеры`
--
ALTER TABLE `Тренеры`
  ADD PRIMARY KEY (`Код_тренера`);

--
-- Индексы таблицы `Тренировки`
--
ALTER TABLE `Тренировки`
  ADD PRIMARY KEY (`Код_тренировки`),
  ADD KEY `Код_группы` (`Код_группы`),
  ADD KEY `Код_тренера` (`Код_тренера`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `Абонементы`
--
ALTER TABLE `Абонементы`
  MODIFY `Код_абонемента` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `Группы`
--
ALTER TABLE `Группы`
  MODIFY `Код_группы` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `Клиенты`
--
ALTER TABLE `Клиенты`
  MODIFY `Код_клиента` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `Тренеры`
--
ALTER TABLE `Тренеры`
  MODIFY `Код_тренера` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `Тренировки`
--
ALTER TABLE `Тренировки`
  MODIFY `Код_тренировки` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `Клиенты`
--
ALTER TABLE `Клиенты`
  ADD CONSTRAINT `Клиенты_ibfk_1` FOREIGN KEY (`Код_абонемента`) REFERENCES `Абонементы` (`Код_абонемента`),
  ADD CONSTRAINT `Клиенты_ibfk_2` FOREIGN KEY (`Код_группы`) REFERENCES `Группы` (`Код_группы`);

--
-- Ограничения внешнего ключа таблицы `Клиенты_Тренировки`
--
ALTER TABLE `Клиенты_Тренировки`
  ADD CONSTRAINT `Клиенты_Тренировки_ibfk_1` FOREIGN KEY (`Код_клиента`) REFERENCES `Клиенты` (`Код_клиента`) ON DELETE CASCADE,
  ADD CONSTRAINT `Клиенты_Тренировки_ibfk_2` FOREIGN KEY (`Код_тренировки`) REFERENCES `Тренировки` (`Код_тренировки`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `Тренировки`
--
ALTER TABLE `Тренировки`
  ADD CONSTRAINT `Тренировки_ibfk_1` FOREIGN KEY (`Код_группы`) REFERENCES `Группы` (`Код_группы`) ON DELETE SET NULL,
  ADD CONSTRAINT `Тренировки_ibfk_2` FOREIGN KEY (`Код_тренера`) REFERENCES `Тренеры` (`Код_тренера`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
