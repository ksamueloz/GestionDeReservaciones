-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-05-2022 a las 17:27:52
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `novasec`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservation`
--

CREATE TABLE `reservation` (
  `id` int(10) NOT NULL,
  `rooms_type_id` int(10) NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `admin_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `reservation`
--

INSERT INTO `reservation` (`id`, `rooms_type_id`, `startdate`, `enddate`, `admin_id`) VALUES
(1, 1, '2017-04-29', '2017-05-01', 1),
(2, 2, '2017-04-29', '2017-05-01', 1),
(3, 3, '2017-04-29', '2017-05-01', 2),
(4, 2, '2017-05-02', '2017-05-05', 2),
(5, 1, '2017-05-06', '2017-05-10', 1),
(6, 3, '2017-05-26', '2017-05-29', 2),
(7, 2, '2017-05-26', '2017-05-29', 2),
(8, 2, '2017-05-06', '2017-05-10', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservation_user`
--

CREATE TABLE `reservation_user` (
  `user_id` int(10) NOT NULL,
  `reservation_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `reservation_user`
--

INSERT INTO `reservation_user` (`user_id`, `reservation_id`) VALUES
(1, 1),
(1, 5),
(2, 2),
(2, 6),
(3, 3),
(3, 7),
(4, 4),
(4, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rooms_type`
--

CREATE TABLE `rooms_type` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `nof` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rooms_type`
--

INSERT INTO `rooms_type` (`id`, `name`, `nof`) VALUES
(1, 'Single', 2),
(2, 'Double', 1),
(3, 'Shared', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(10) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `phonenumber` int(50) NOT NULL,
  `birthdate` date NOT NULL,
  `email` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `phonenumber`, `birthdate`, `email`) VALUES
(1, 'Jhon', 'Doe', 1451395160, '1980-09-28', 'jdone@gmail.com'),
(2, 'Jane', 'Jackson', 1709896062, '1985-05-01', 'jjackson@yahoo.com'),
(3, 'Alex', 'Smith', 1742823999, '1990-05-28', 'jasmith@oul.com'),
(4, 'Johana', 'Roll', 1806460961, '1981-10-31', 'jkrolling@uk.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reservation_rooms_type1_idx` (`rooms_type_id`);

--
-- Indices de la tabla `reservation_user`
--
ALTER TABLE `reservation_user`
  ADD PRIMARY KEY (`user_id`,`reservation_id`),
  ADD KEY `fk_reservation_has_user_user1_idx` (`user_id`),
  ADD KEY `fk_reservation_has_user_reservation_idx` (`reservation_id`);

--
-- Indices de la tabla `rooms_type`
--
ALTER TABLE `rooms_type`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `rooms_type`
--
ALTER TABLE `rooms_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `fk_reservation_rooms_type1` FOREIGN KEY (`rooms_type_id`) REFERENCES `rooms_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `reservation_user`
--
ALTER TABLE `reservation_user`
  ADD CONSTRAINT `fk_reservation_has_user_reservation` FOREIGN KEY (`reservation_id`) REFERENCES `reservation` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_reservation_has_user_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
