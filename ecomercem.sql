-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-03-2022 a las 23:59:59
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ecomerce`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'Primera categoria'),
(3, 'Otra Categoria');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `fecha` varchar(20) NOT NULL,
  `total` varchar(255) NOT NULL,
  `estatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `fecha`, `total`, `estatus`) VALUES
(8, '16/08/2021', '150', 1),
(9, '16/08/2021', '24', 0),
(10, '17/08/2021', '2371', 0),
(11, '17/08/2021', '12', 0),
(12, '17/08/2021', '12', 0),
(13, '17/08/2021', '12', 0),
(14, '17/08/2021', '12', 0),
(15, '17/08/2021', '12', 0),
(16, '17/08/2021', '12', 0),
(17, '17/08/2021', '12', 0),
(18, '17/08/2021', '25', 0),
(19, '17/08/2021', '12', 0),
(20, '17/08/2021', '12', 0),
(21, '17/08/2021', '12', 0),
(22, '17/08/2021', '12', 0),
(23, '17/08/2021', '12', 0),
(24, '17/08/2021', '12', 0),
(25, '17/08/2021', '12', 0),
(26, '17/08/2021', '25', 0),
(27, '17/08/2021', '75', 0),
(28, '17/08/2021', '37', 0),
(29, '18/08/2021', '144', 0),
(30, '18/08/2021', '107', 0),
(31, '18/08/2021', '12', 0),
(32, '18/08/2021', '33', 0),
(33, '18/08/2021', '12', 0),
(34, '18/08/2021', '12', 0),
(35, '18/08/2021', '12', 0),
(36, '18/08/2021', '216', 0),
(37, '19/08/2021', '12', 0),
(38, '17/08/2021', '25', 0),
(39, '17/08/2021', '343.50', 0),
(40, '17/08/2021', '63.50', 0),
(41, '17/08/2021', '68.5', 1),
(42, '17/08/2021', '2110', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presupuesto`
--

CREATE TABLE `presupuesto` (
  `id` int(11) NOT NULL,
  `presupuesto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `presupuesto`
--

INSERT INTO `presupuesto` (`id`, `presupuesto`) VALUES
(1, '2890');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `precio` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `unidades` int(11) NOT NULL,
  `img` varchar(255) NOT NULL,
  `idCat` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `precio`, `nombre`, `unidades`, `img`, `idCat`) VALUES
(22, '19', 'Gatorade', 50, '1640213129576x627-limon.png', 1),
(23, '25', 'Jugo Manzana', 50, '293519357bebibleManzana_big.png', 1),
(24, '12', 'Agua 600ml', 50, '544656199botellas_1_L.png', 1),
(25, '80', 'Cafe', 50, '697941077cafe.jpeg', 1),
(26, '22', 'Cepillo de dientes', 50, '1185109865cepillo de dientes.jpeg', 1),
(27, '114', 'six de cerveza', 50, '914057085cervezas.jpeg', 1),
(28, '18', 'Platanos Fritos', 50, '35906266D6.png', 1),
(29, '15', 'Chicharrones', 50, '1076307424D12.png', 1),
(30, '32', 'Leche deslactosada', 50, '1909156169deslactosada_big.png', 1),
(31, '12.50', 'Doritos nacho', 50, '1228127252doritos.jpeg', 1),
(32, '11', 'REFRESCO DE COLA 600ML', 50, '401131858EMPRESA-500ml-light.png', 1),
(33, '11', 'Refresco de naranja', 50, '775229212EMPRESA-600ml.png', 1),
(34, '8', 'Jugo de naranja', 50, '1079350241jumex fresh botella.png', 1),
(35, '8', 'Jugo de uva', 50, '388568838juvo uva.png', 1),
(36, '33', 'Mayonesa', 50, '1921875310mayonesa.jpeg', 1),
(37, '18', 'Leche Helado de menta', 50, '1575839000menta_big.png', 1),
(38, '24', 'Papel de baño', 50, '478406241papel de baño.jpeg', 1),
(39, '6', 'sopa', 50, '2000383001sopa.jpeg', 1),
(41, '85', 'Nutella', 50, '957826467nutella.jpeg', 1),
(45, '500', 'Televisora', 2, '1910933931TELEMUNDO_LOGO_CMYK_COLOR_WITH_WHITE_TEXT.png', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productospedido`
--

CREATE TABLE `productospedido` (
  `id` int(11) NOT NULL,
  `idPedido` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `productospedido`
--

INSERT INTO `productospedido` (`id`, `idPedido`, `idProducto`, `cantidad`) VALUES
(24, 8, 23, 2),
(25, 8, 22, 1),
(26, 8, 24, 1),
(27, 8, 31, 3),
(28, 8, 36, 1),
(29, 9, 24, 2),
(30, 10, 23, 31),
(31, 10, 27, 14),
(32, 11, 24, 1),
(33, 12, 24, 1),
(34, 13, 24, 1),
(35, 14, 24, 1),
(36, 15, 24, 1),
(37, 16, 24, 1),
(38, 17, 24, 1),
(39, 18, 23, 1),
(40, 19, 24, 1),
(41, 20, 24, 1),
(42, 21, 24, 1),
(43, 22, 24, 1),
(44, 23, 24, 1),
(45, 24, 24, 1),
(46, 25, 24, 1),
(47, 26, 23, 1),
(48, 27, 23, 3),
(49, 28, 24, 1),
(50, 28, 23, 1),
(51, 29, 23, 1),
(52, 29, 32, 1),
(53, 29, 35, 1),
(54, 29, 41, 1),
(55, 29, 29, 1),
(56, 30, 32, 2),
(57, 30, 26, 1),
(58, 30, 29, 2),
(59, 30, 36, 1),
(60, 31, 24, 1),
(61, 32, 36, 1),
(62, 33, 24, 1),
(63, 34, 24, 1),
(64, 35, 24, 1),
(65, 36, 39, 1),
(66, 36, 32, 1),
(67, 36, 27, 1),
(68, 36, 24, 2),
(69, 36, 23, 1),
(70, 36, 28, 2),
(71, 37, 24, 1),
(72, 38, 23, 1),
(73, 39, 31, 1),
(74, 39, 30, 1),
(75, 39, 34, 1),
(76, 39, 36, 1),
(77, 39, 37, 1),
(78, 39, 41, 1),
(79, 39, 39, 1),
(80, 39, 38, 1),
(81, 39, 23, 1),
(82, 39, 25, 1),
(83, 39, 22, 1),
(84, 40, 23, 2),
(85, 40, 31, 1),
(86, 41, 22, 1),
(87, 41, 23, 1),
(88, 41, 24, 1),
(89, 41, 31, 1),
(90, 42, 22, 1),
(91, 42, 23, 4),
(92, 42, 25, 1),
(93, 42, 29, 21),
(94, 42, 28, 2),
(95, 42, 27, 6),
(96, 42, 26, 1),
(97, 42, 30, 6),
(98, 42, 31, 2),
(99, 42, 32, 2),
(100, 42, 33, 2),
(101, 42, 37, 1),
(102, 42, 36, 7),
(103, 42, 35, 2),
(104, 42, 34, 1),
(105, 42, 38, 6),
(106, 42, 39, 1),
(107, 42, 41, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `presupuesto`
--
ALTER TABLE `presupuesto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productospedido`
--
ALTER TABLE `productospedido`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `presupuesto`
--
ALTER TABLE `presupuesto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `productospedido`
--
ALTER TABLE `productospedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
