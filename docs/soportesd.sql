-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-07-2023 a las 18:15:10
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `soportesd`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_d_usuario_01` (IN `xusu_id` INT)   BEGIN
	UPDATE tm_usuario 
	SET 
		est='0',
		fech_elim = now() 
	where usu_id=xusu_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_i_ticketdetalle_01` (IN `xtick_id` INT, IN `xusu_id` INT)   BEGIN
	INSERT INTO td_ticketdetalle 
    (tickd_id,tick_id,usu_id,tickd_descrip,fech_crea,est) 
    VALUES 
    (NULL,xtick_id,xusu_id,'Ticket Cerrado...',now(),'1');
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_l_usuario_01` ()   BEGIN
	SELECT * FROM tm_usuario where est='1';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_l_usuario_02` (IN `xusu_id` INT)   BEGIN
	SELECT * FROM tm_usuario where usu_id=xusu_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_l_usuario_rol` ()   BEGIN
	SELECT * FROM tm_usuario where est=1 and rol_id=2;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_l_usuario_rol_sup` ()   BEGIN
	SELECT * FROM tm_usuario where est=1 and rol_id=3;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_l_usuario_total_x_id` (IN `xusu_id` INT)   BEGIN
	SELECT COUNT(*) as TOTAL FROM tm_ticket where usu_id = xusu_id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `td_documento`
--

CREATE TABLE `td_documento` (
  `doc_id` int(11) NOT NULL,
  `tick_id` int(11) NOT NULL,
  `doc_nom` varchar(400) NOT NULL,
  `fech_crea` datetime NOT NULL,
  `est` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `td_documento`
--

INSERT INTO `td_documento` (`doc_id`, `tick_id`, `doc_nom`, `fech_crea`, `est`) VALUES
(1, 2, 'relacion laptops occidente.xlsx', '2023-01-22 09:57:57', 1),
(2, 6, 'SOLICITUD DE EQUIPO  (2) (1) (1) (2).xlsx', '2023-05-04 16:40:31', 1),
(3, 10, 'Soporte SDConsultar Ticket.pdf', '2023-05-04 17:33:23', 1),
(4, 13, 'Soporte SDConsultar Ticket (1).xlsx', '2023-05-04 18:04:51', 1),
(5, 20, 'Manual de traslado de equipo (1).pdf', '2023-05-06 10:20:29', 1),
(6, 20, 'Manual de traslado de equipo (1).pdf', '2023-05-06 10:20:29', 1),
(7, 21, 'Manual de traslado de equipo (1).pdf', '2023-05-06 10:20:29', 1),
(8, 22, 'Soporte SDConsultar Ticket.pdf', '2023-05-06 10:21:26', 1),
(9, 23, 'Soporte SDConsultar Ticket.pdf', '2023-05-06 10:21:26', 1),
(10, 23, 'Soporte SDConsultar Ticket.pdf', '2023-05-06 10:21:26', 1),
(11, 29, 'carta.pdf', '2023-05-06 18:16:43', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `td_ticketdetalle`
--

CREATE TABLE `td_ticketdetalle` (
  `tickd_id` int(11) NOT NULL,
  `tick_id` int(11) NOT NULL,
  `usu_id` int(11) NOT NULL,
  `tickd_descrip` mediumtext NOT NULL,
  `fech_crea` datetime NOT NULL,
  `est` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `td_ticketdetalle`
--

INSERT INTO `td_ticketdetalle` (`tickd_id`, `tick_id`, `usu_id`, `tickd_descrip`, `fech_crea`, `est`) VALUES
(1, 1, 3, '<p>aun no recibo respuesta</p>', '2023-05-06 13:16:34', 1),
(2, 29, 3, '<p>no me han atendido urge</p>', '2023-05-06 18:18:03', 1),
(3, 1, 3, '<p>sigo sin recibir ayuda</p>', '2023-05-06 18:47:26', 1),
(4, 1, 3, 'Ticket Cerrado...', '2023-05-06 18:49:30', 1),
(5, 30, 1, '<p>ticket en atencion</p>', '2023-07-01 10:20:36', 1),
(6, 30, 3, '<p>solicitud resuelta</p>', '2023-07-01 10:22:17', 1),
(7, 30, 3, 'Ticket Cerrado...', '2023-07-01 10:22:22', 1),
(8, 32, 1, '<p>se atiende el ticket</p>', '2023-07-01 10:34:57', 1),
(9, 32, 1, '<p>ticket atendido resuelto</p>', '2023-07-01 10:35:35', 1),
(10, 32, 1, 'Ticket Cerrado...', '2023-07-01 10:35:48', 1),
(11, 33, 1, '<p>se comienza con la atencion</p>', '2023-07-01 13:16:03', 1),
(12, 33, 1, '<p>necesitamos mas informacion</p>', '2023-07-01 13:16:20', 1),
(13, 33, 1, 'Ticket Cerrado...', '2023-07-01 13:17:06', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_area`
--

CREATE TABLE `tm_area` (
  `id_area` int(11) NOT NULL,
  `nombre_area` varchar(150) NOT NULL,
  `est` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tm_area`
--

INSERT INTO `tm_area` (`id_area`, `nombre_area`, `est`) VALUES
(1, 'Recepcion Imagen', 1),
(2, 'Laboratorio', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_articulo`
--

CREATE TABLE `tm_articulo` (
  `id_articulo_sub` int(11) NOT NULL,
  `id_subcategoria` int(11) NOT NULL,
  `articulo_subcat` varchar(150) NOT NULL,
  `est` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tm_articulo`
--

INSERT INTO `tm_articulo` (`id_articulo_sub`, `id_subcategoria`, `articulo_subcat`, `est`) VALUES
(1, 2, 'Mover Imagenes', 1),
(2, 2, 'Fusion Imagenes', 1),
(3, 1, 'Mantenimiento Preventivo', 1),
(4, 1, 'Destruccion', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_categoria`
--

CREATE TABLE `tm_categoria` (
  `cat_id` int(11) NOT NULL,
  `cat_nom` varchar(150) NOT NULL,
  `est` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tm_categoria`
--

INSERT INTO `tm_categoria` (`cat_id`, `cat_nom`, `est`) VALUES
(1, 'Soporte tecnico 1.0', 1),
(2, 'CNR 1.0', 1),
(3, 'CNR 2.0', 1),
(4, 'Telerad', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_subcategoria`
--

CREATE TABLE `tm_subcategoria` (
  `id_subcategoria` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `subcat_nom` varchar(150) NOT NULL,
  `est` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tm_subcategoria`
--

INSERT INTO `tm_subcategoria` (`id_subcategoria`, `cat_id`, `subcat_nom`, `est`) VALUES
(1, 1, 'Equipo de computo', 1),
(2, 2, 'Telerad- Synapse', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_sucursal`
--

CREATE TABLE `tm_sucursal` (
  `id_sucursal` int(11) NOT NULL,
  `nombre_sucursal` varchar(150) NOT NULL,
  `est` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tm_sucursal`
--

INSERT INTO `tm_sucursal` (`id_sucursal`, `nombre_sucursal`, `est`) VALUES
(1, 'Monterrey la fe', 1),
(2, 'Monterrey Centro', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_ticket`
--

CREATE TABLE `tm_ticket` (
  `tick_id` int(11) NOT NULL,
  `usu_id` int(11) NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_area` int(11) NOT NULL,
  `tick_prioridad` varchar(150) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `id_subcat` int(11) NOT NULL,
  `id_articulo_sub` int(11) NOT NULL,
  `tick_titulo` varchar(250) NOT NULL,
  `tickd_descrip` mediumtext NOT NULL,
  `usu_asig` int(11) DEFAULT NULL,
  `supervisor` int(11) NOT NULL,
  `tick_estado` varchar(15) DEFAULT NULL,
  `fech_crea` datetime DEFAULT NULL,
  `fech_asig` datetime DEFAULT NULL,
  `est` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tm_ticket`
--

INSERT INTO `tm_ticket` (`tick_id`, `usu_id`, `id_tipo`, `id_sucursal`, `id_area`, `tick_prioridad`, `cat_id`, `id_subcat`, `id_articulo_sub`, `tick_titulo`, `tickd_descrip`, `usu_asig`, `supervisor`, `tick_estado`, `fech_crea`, `fech_asig`, `est`) VALUES
(1, 3, 1, 1, 1, 'Baja', 1, 1, 3, 'no sirve', '<p>nosirve</p>', 4, 4, 'Cerrado', '2023-01-04 12:46:20', '2023-05-24 15:51:40', 1),
(2, 3, 2, 1, 2, 'Normal', 2, 1, 3, 'sdfsdf', '<p>asdasdasdasdaaasas</p><p>dasd</p><p>asd</p><p>a</p>', 2, 5, 'Abierto', '2023-01-22 09:57:57', '2023-07-01 13:18:56', 1),
(3, 3, 1, 1, 1, 'Normal', 1, 1, 3, 'correo prueba1', '<p>correo prueba1<br></p>', 2, 4, 'Abierto', '2023-05-04 16:19:13', '2023-07-01 10:37:42', 1),
(4, 3, 1, 1, 1, 'Normal', 1, 1, 3, 'correo prueba1', '<p>correo prueba1<br></p>', 1, 4, 'Abierto', '2023-05-04 16:19:19', '2023-05-04 16:19:19', 1),
(5, 3, 1, 1, 1, 'Normal', 1, 1, 3, 'correo prueba1', '<p>correo prueba1<br></p>', 1, 4, 'Abierto', '2023-05-04 16:19:53', '2023-05-04 16:19:53', 1),
(6, 3, 2, 2, 1, 'Baja', 2, 2, 2, 'equipo', '<p>equipo</p>', 2, 4, 'Abierto', '2023-05-04 16:40:31', '2023-05-04 16:40:31', 1),
(7, 3, 1, 1, 1, 'Baja', 1, 1, 4, 'reset inputs', '<p>reset inputs<br></p>', 1, 5, 'Abierto', '2023-05-04 17:27:46', '2023-05-04 17:27:46', 1),
(8, 3, 0, 0, 1, 'Normal', 2, 2, 1, 'sada', '<p>asdas</p>', 1, 5, 'Abierto', '2023-05-04 17:29:32', '2023-05-04 17:29:32', 1),
(9, 3, 2, 1, 2, 'Normal', 1, 1, 3, 'aaaaaaaaaaaaaaaaaaaa', '<p>aaaaaaaaaaaaaaaaaaaa</p>', 2, 5, 'Abierto', '2023-05-04 17:31:00', '2023-05-04 17:31:00', 1),
(10, 3, 0, 0, 0, 'Normal', 1, 1, 3, 'aa', '<p>a</p>', 2, 4, 'Abierto', '2023-05-04 17:33:23', '2023-05-04 17:33:23', 1),
(11, 3, 2, 2, 2, 'Normal', 1, 1, 4, 'aaa', '<p>ssssss</p>', 2, 4, 'Abierto', '2023-05-04 17:34:00', '2023-05-04 17:34:00', 1),
(12, 3, 1, 1, 2, 'Baja', 2, 2, 1, 'qqqqqqqq', '<p>qqqqqqqq</p>', 2, 5, 'Abierto', '2023-05-04 18:04:33', '2023-05-04 18:04:33', 1),
(13, 3, 1, 1, 2, 'Baja', 2, 2, 1, 'qqqqqqqq', '<p>qqqqqqqq</p>', 2, 5, 'Abierto', '2023-05-04 18:04:51', '2023-05-04 18:04:51', 1),
(14, 3, 1, 2, 1, 'Baja', 2, 2, 1, '112', '<p>123</p>', 1, 4, 'Abierto', '2023-05-05 13:05:32', '2023-05-05 13:05:32', 1),
(15, 3, 1, 1, 1, 'Baja', 1, 1, 3, '1', '<p>1.1</p>', 2, 5, 'Abierto', '2023-05-05 13:13:36', '2023-05-05 13:13:36', 1),
(16, 3, 1, 1, 1, 'Alta', 1, 1, 3, '1.2', '<p>1.2</p>', 1, 0, 'Abierto', '2023-05-05 13:16:04', '2023-05-05 13:16:04', 1),
(17, 3, 1, 1, 1, 'Media', 1, 1, 3, 'aa', '<p>wwwwwwwwwwww</p>', 1, 5, 'Abierto', '2023-05-05 13:19:42', '2023-05-05 13:19:42', 1),
(18, 3, 1, 1, 1, 'Normal', 2, 2, 1, 'no sirve', '<p>no sirve</p>', 1, 4, 'Abierto', '2023-05-06 10:19:50', '2023-05-06 10:19:50', 1),
(19, 3, 1, 1, 1, 'Normal', 2, 2, 1, 'no sirve', '<p>no sirve</p>', 1, 4, 'Abierto', '2023-05-06 10:19:50', '2023-05-06 10:19:50', 1),
(20, 3, 1, 1, 1, 'Normal', 2, 2, 1, 'no sirve', '<p>no sirve</p>', 1, 4, 'Abierto', '2023-05-06 10:20:29', '2023-05-06 10:20:29', 1),
(21, 3, 1, 1, 1, 'Normal', 2, 2, 1, 'no sirve', '<p>no sirve</p>', 1, 4, 'Abierto', '2023-05-06 10:20:29', '2023-05-06 10:20:29', 1),
(22, 3, 1, 1, 1, 'Normal', 2, 2, 1, 'correo prueba1', '<p>correo pruen</p>', 1, 4, 'Abierto', '2023-05-06 10:21:26', '2023-05-06 10:21:26', 1),
(23, 3, 1, 1, 1, 'Normal', 2, 2, 1, 'correo prueba1', '<p>correo pruen</p>', 1, 4, 'Abierto', '2023-05-06 10:21:26', '2023-05-06 10:21:26', 1),
(24, 3, 1, 1, 1, 'Normal', 2, 2, 1, 'prueba con archivo vacio', '<p>prueba con archivo vacio<br></p>', 1, 5, 'Abierto', '2023-05-06 10:41:27', '2023-05-06 10:41:27', 1),
(25, 3, 1, 1, 1, 'Normal', 2, 2, 1, 'prueba con archivo vacio', '<p>prueba con archivo vacio<br></p>', 1, 5, 'Abierto', '2023-05-06 10:41:27', '2023-05-06 10:41:27', 1),
(26, 3, 2, 1, 1, 'Normal', 1, 1, 3, 'prueba de registro tickets sin archivo seleccionado2', '<p>prueba de registro tickets sin archivo seleccionado2<br></p>', 2, 4, 'Abierto', '2023-05-06 10:44:44', '2023-05-06 10:44:44', 1),
(27, 3, 2, 1, 1, 'Normal', 1, 1, 3, 'prueba de registro tickets sin archivo seleccionado2', '<p>prueba de registro tickets sin archivo seleccionado2<br></p>', 2, 4, 'Abierto', '2023-05-06 10:44:44', '2023-05-06 10:44:44', 1),
(28, 3, 1, 1, 1, 'Baja', 1, 1, 3, 'prueba 3 archivo vacio', '<p>prueba 3 archivo vacio<br></p>', 1, 5, 'Abierto', '2023-05-06 10:51:00', '2023-05-06 10:51:00', 1),
(29, 3, 1, 2, 1, 'Normal', 2, 2, 1, 'demo dosi', '<p>demo dosi</p>', 1, 4, 'Abierto', '2023-05-06 18:16:43', '2023-05-06 18:16:43', 1),
(30, 3, 2, 1, 2, 'Media', 1, 1, 3, 'prueba falla1', '<p>prueba falla1<br></p>', 1, 4, 'Cerrado', '2023-07-01 10:19:35', '2023-07-01 10:19:35', 1),
(31, 3, 1, 1, 1, 'Media', 1, 1, 3, 'prueba falla2', '<p>prueba falla2<br></p>', 2, 5, 'Abierto', '2023-07-01 10:26:29', '2023-07-01 10:26:29', 1),
(32, 3, 2, 2, 1, 'Normal', 2, 2, 1, 'falla 3 prueba', '<p>falla 3 prueba<br></p>', 1, 4, 'Cerrado', '2023-07-01 10:32:44', '2023-07-01 10:32:44', 1),
(33, 3, 2, 2, 1, 'Alta', 2, 2, 1, 'prueba falla4', '<p>prueba falla4<br></p>', 2, 5, 'Cerrado', '2023-07-01 13:12:53', '2023-07-01 13:12:53', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_tiposolicitud`
--

CREATE TABLE `tm_tiposolicitud` (
  `id_tipo` int(11) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `est` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tm_tiposolicitud`
--

INSERT INTO `tm_tiposolicitud` (`id_tipo`, `descripcion`, `est`) VALUES
(1, 'Checklist', 1),
(2, 'Incidencia', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_usuario`
--

CREATE TABLE `tm_usuario` (
  `usu_id` int(11) NOT NULL,
  `usu_nom` varchar(150) DEFAULT NULL,
  `usu_ape` varchar(150) DEFAULT NULL,
  `usu_correo` varchar(150) NOT NULL,
  `usu_pass` varchar(150) NOT NULL,
  `rol_id` int(11) DEFAULT NULL,
  `fech_crea` datetime DEFAULT NULL,
  `fech_modi` datetime DEFAULT NULL,
  `fech_elim` datetime DEFAULT NULL,
  `est` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Tabla Mantenedor de Usuarios';

--
-- Volcado de datos para la tabla `tm_usuario`
--

INSERT INTO `tm_usuario` (`usu_id`, `usu_nom`, `usu_ape`, `usu_correo`, `usu_pass`, `rol_id`, `fech_crea`, `fech_modi`, `fech_elim`, `est`) VALUES
(1, 'Jose Luis', 'Baena', 'sistemas.sannicolas@salud-digna.org', '32d740a443fe5819e3e7a6bd9e18b089', 2, '2020-12-14 19:46:22', NULL, NULL, 1),
(2, 'Soporte', 'Tecnico', 'sistemas.sannicolas@salud-digna.org', '32d740a443fe5819e3e7a6bd9e18b089', 2, '2020-12-14 19:46:22', NULL, NULL, 1),
(3, 'Demo', 'Demo', 'soportesd-test@outlook.com', 'fe01ce2a7fbac8fafaed7c982a04e229', 1, '2020-12-14 19:46:22', NULL, '2021-01-21 22:04:50', 1),
(4, 'Angel Eustogio', 'Valdez Valdez', 'sistemas.sannicolas@salud-digna.org', '32d740a443fe5819e3e7a6bd9e18b089', 3, '2021-01-21 22:52:17', NULL, NULL, 1),
(5, 'Jose de Jesus', 'Camacho', 'sistemas.sannicolas@salud-digna.org', '32d740a443fe5819e3e7a6bd9e18b089', 3, '2021-01-21 22:52:53', NULL, '2021-01-21 22:53:27', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `td_documento`
--
ALTER TABLE `td_documento`
  ADD PRIMARY KEY (`doc_id`);

--
-- Indices de la tabla `td_ticketdetalle`
--
ALTER TABLE `td_ticketdetalle`
  ADD PRIMARY KEY (`tickd_id`);

--
-- Indices de la tabla `tm_area`
--
ALTER TABLE `tm_area`
  ADD PRIMARY KEY (`id_area`);

--
-- Indices de la tabla `tm_articulo`
--
ALTER TABLE `tm_articulo`
  ADD PRIMARY KEY (`id_articulo_sub`);

--
-- Indices de la tabla `tm_categoria`
--
ALTER TABLE `tm_categoria`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indices de la tabla `tm_subcategoria`
--
ALTER TABLE `tm_subcategoria`
  ADD PRIMARY KEY (`id_subcategoria`);

--
-- Indices de la tabla `tm_sucursal`
--
ALTER TABLE `tm_sucursal`
  ADD PRIMARY KEY (`id_sucursal`);

--
-- Indices de la tabla `tm_ticket`
--
ALTER TABLE `tm_ticket`
  ADD PRIMARY KEY (`tick_id`);

--
-- Indices de la tabla `tm_tiposolicitud`
--
ALTER TABLE `tm_tiposolicitud`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `tm_usuario`
--
ALTER TABLE `tm_usuario`
  ADD PRIMARY KEY (`usu_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `td_documento`
--
ALTER TABLE `td_documento`
  MODIFY `doc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `td_ticketdetalle`
--
ALTER TABLE `td_ticketdetalle`
  MODIFY `tickd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `tm_area`
--
ALTER TABLE `tm_area`
  MODIFY `id_area` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tm_articulo`
--
ALTER TABLE `tm_articulo`
  MODIFY `id_articulo_sub` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tm_categoria`
--
ALTER TABLE `tm_categoria`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tm_subcategoria`
--
ALTER TABLE `tm_subcategoria`
  MODIFY `id_subcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tm_sucursal`
--
ALTER TABLE `tm_sucursal`
  MODIFY `id_sucursal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tm_ticket`
--
ALTER TABLE `tm_ticket`
  MODIFY `tick_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `tm_tiposolicitud`
--
ALTER TABLE `tm_tiposolicitud`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tm_usuario`
--
ALTER TABLE `tm_usuario`
  MODIFY `usu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
