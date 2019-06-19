-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 19 2019 г., 15:40
-- Версия сервера: 10.3.13-MariaDB
-- Версия PHP: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `rest_cars_shop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `rest_brands`
--

CREATE TABLE `rest_brands` (
  `id` int(11) NOT NULL,
  `brand` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `rest_brands`
--

INSERT INTO `rest_brands` (`id`, `brand`) VALUES
(1, 'Mercedes'),
(2, 'BMW'),
(3, 'Volkswagen'),
(4, 'Ford'),
(5, 'Mazda');

-- --------------------------------------------------------

--
-- Структура таблицы `rest_cars`
--

CREATE TABLE `rest_cars` (
  `id` int(11) NOT NULL,
  `model` varchar(255) NOT NULL,
  `year` int(4) NOT NULL,
  `capacity` float NOT NULL,
  `brand_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  `max_speed` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `rest_cars`
--

INSERT INTO `rest_cars` (`id`, `model`, `year`, `capacity`, `brand_id`, `color_id`, `max_speed`, `price`) VALUES
(1, 'C 63', 2016, 1.24, 1, 1, 225, 69000),
(2, 'AMG GT-Class', 2019, 1, 1, 2, 302, 165000),
(3, 'GLA 180', 2018, 2.5, 1, 3, 200, 36500),
(4, 'X3', 2010, 2.3, 2, 4, 250, 59000),
(5, 'X5', 2013, 2.8, 2, 2, 220, 75000),
(6, 'Polo', 2009, 1, 3, 5, 187, 17000),
(7, 'Passat', 2015, 1.4, 3, 1, 232, 26000),
(8, 'Focus', 2019, 1.2, 4, 6, 193, 19000),
(9, 'Mustang', 2017, 2.26, 4, 7, 234, 45800),
(10, '6', 2007, 1.65, 5, 8, 209, 26500);

-- --------------------------------------------------------

--
-- Структура таблицы `rest_cars_orders`
--

CREATE TABLE `rest_cars_orders` (
  `id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `rest_colors`
--

CREATE TABLE `rest_colors` (
  `id` int(11) NOT NULL,
  `color` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `rest_colors`
--

INSERT INTO `rest_colors` (`id`, `color`) VALUES
(1, 'silver'),
(2, 'black'),
(3, 'brown'),
(4, 'blue'),
(5, 'orange'),
(6, 'cyan'),
(7, 'red'),
(8, 'violet');

-- --------------------------------------------------------

--
-- Структура таблицы `rest_orders`
--

CREATE TABLE `rest_orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `rest_payments`
--

CREATE TABLE `rest_payments` (
  `id` int(11) NOT NULL,
  `payment` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `rest_payments`
--

INSERT INTO `rest_payments` (`id`, `payment`) VALUES
(1, 'Credit card'),
(2, 'Cash');

-- --------------------------------------------------------

--
-- Структура таблицы `rest_users`
--

CREATE TABLE `rest_users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `rest_brands`
--
ALTER TABLE `rest_brands`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `rest_cars`
--
ALTER TABLE `rest_cars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brand_id` (`brand_id`),
  ADD KEY `color_id` (`color_id`);

--
-- Индексы таблицы `rest_cars_orders`
--
ALTER TABLE `rest_cars_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_id` (`car_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Индексы таблицы `rest_colors`
--
ALTER TABLE `rest_colors`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `rest_orders`
--
ALTER TABLE `rest_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `payment_id` (`payment_id`);

--
-- Индексы таблицы `rest_payments`
--
ALTER TABLE `rest_payments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `rest_users`
--
ALTER TABLE `rest_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `rest_brands`
--
ALTER TABLE `rest_brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `rest_cars`
--
ALTER TABLE `rest_cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `rest_cars_orders`
--
ALTER TABLE `rest_cars_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `rest_colors`
--
ALTER TABLE `rest_colors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `rest_orders`
--
ALTER TABLE `rest_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `rest_payments`
--
ALTER TABLE `rest_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `rest_users`
--
ALTER TABLE `rest_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `rest_cars`
--
ALTER TABLE `rest_cars`
  ADD CONSTRAINT `brand_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `rest_brands` (`id`),
  ADD CONSTRAINT `color_ibfk_2` FOREIGN KEY (`color_id`) REFERENCES `rest_colors` (`id`);

--
-- Ограничения внешнего ключа таблицы `rest_cars_orders`
--
ALTER TABLE `rest_cars_orders`
  ADD CONSTRAINT `FK_car_orders` FOREIGN KEY (`order_id`) REFERENCES `rest_orders` (`id`),
  ADD CONSTRAINT `cars_orders_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `rest_cars` (`id`);

--
-- Ограничения внешнего ключа таблицы `rest_orders`
--
ALTER TABLE `rest_orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `rest_users` (`id`),
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`payment_id`) REFERENCES `rest_payments` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
