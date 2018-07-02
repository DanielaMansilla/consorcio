-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-07-2018 a las 22:31:55
-- Versión del servidor: 10.1.31-MariaDB
-- Versión de PHP: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `consorcio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consorcio`
--

CREATE TABLE `consorcio` (
  `idConsorcio` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `cuit` varchar(11) NOT NULL,
  `codigoPostal` int(4) NOT NULL,
  `telefono` int(11) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `direccion` varchar(70) NOT NULL,
  `googlexy` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `consorcio`
--

INSERT INTO `consorcio` (`idConsorcio`, `nombre`, `cuit`, `codigoPostal`, `telefono`, `correo`, `direccion`, `googlexy`) VALUES
(1, 'consorcio1', '64334621232', 1230, 12412410, 'a@hotmail.com', 'geijgisaje53353', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expensa`
--

CREATE TABLE `expensa` (
  `idExpensa` int(11) NOT NULL,
  `idLiquidacion` int(11) DEFAULT NULL,
  `idPropiedad` int(11) DEFAULT NULL,
  `importe` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `vencimiento` date DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formasdepago`
--

CREATE TABLE `formasdepago` (
  `idFormaPago` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gasto`
--

CREATE TABLE `gasto` (
  `idGasto` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `importe` int(11) NOT NULL,
  `concepto` varchar(100) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `idReclamo` int(11) DEFAULT NULL,
  `nroFactura` int(11) NOT NULL,
  `idProveedor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `liquidacion`
--

CREATE TABLE `liquidacion` (
  `idLiquidacion` int(11) NOT NULL,
  `periodo` date NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `liquidaciongasto`
--

CREATE TABLE `liquidaciongasto` (
  `idLiquidacion` int(11) DEFAULT NULL,
  `idGasto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenpago`
--

CREATE TABLE `ordenpago` (
  `idOperacion` int(11) NOT NULL,
  `idGasto` int(11) DEFAULT NULL,
  `importe` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `idFormaPago` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `idPago` int(11) NOT NULL,
  `idPropiedad` int(11) DEFAULT NULL,
  `importe` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `idLiquidacion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `propiedad`
--

CREATE TABLE `propiedad` (
  `idPropiedad` int(11) NOT NULL,
  `idUsuarios` int(11) DEFAULT NULL,
  `porcentajeParticipacion` int(11) DEFAULT NULL,
  `piso` int(11) NOT NULL,
  `departamento` varchar(1) NOT NULL,
  `unidadFuncionalLote` varchar(50) NOT NULL,
  `idConsorcio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `propiedad`
--

INSERT INTO `propiedad` (`idPropiedad`, `idUsuarios`, `porcentajeParticipacion`, `piso`, `departamento`, `unidadFuncionalLote`, `idConsorcio`) VALUES
(1, 21, 20, 1, 'a', '1', 1),
(7, 21, 24, 1, 'b', '42', 1),
(10, NULL, 2, 1, 'a', '2', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `idProveedor` int(11) NOT NULL,
  `cuit` varchar(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`idProveedor`, `cuit`, `nombre`) VALUES
(1, '12312312222', 'Limpieza22'),
(2, '12312332', 'Los Tipitos'),
(4, '512512', 'La beriso'),
(5, '123124124', 'OTROS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reclamo`
--

CREATE TABLE `reclamo` (
  `idReclamo` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `idPropiedad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `reclamo`
--

INSERT INTO `reclamo` (`idReclamo`, `fecha`, `descripcion`, `estado`, `idPropiedad`) VALUES
(1, '2018-07-01', 'Rotura de caÃ±o', 'Activo', 1),
(2, '2018-07-02', 'probando', 'Activo', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `idRoles` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`idRoles`, `descripcion`) VALUES
(0, 'sinrol'),
(1, 'admin'),
(2, 'propietario'),
(3, 'operador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuarios` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `cuil` varchar(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `dni` int(8) NOT NULL,
  `telefono` int(11) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `idRol` int(11) DEFAULT NULL,
  `pass` varchar(50) NOT NULL,
  `primeraVez` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuarios`, `nombre`, `apellido`, `cuil`, `email`, `dni`, `telefono`, `estado`, `idRol`, `pass`, `primeraVez`) VALUES
(17, 'fedes', 'fefeass', '12312542312', 'fede@hotmail.com', 12312332, 123123123, 'Activo', 1, 'da39a3ee5e6b4b0d3255bfef95601890afd80709\r\n', 0),
(18, 'Fede', 'Rico', '123123', 'fede2@hotmail.com', 123123, 123123, 'Activo', 1, '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 0),
(20, 'seba', 'esa', '123123', 'fede23@hotmail.com', 123123, 123123, 'Activo', 1, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0),
(21, 'jose', 'sesa', '123123', 'fede23@hotmail.com', 123123, 123123, 'Activo', 3, '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 0),
(26, 'Adry', 'Guid', '35412412', '2@hotmail.com', 12312312, 1421419, 'Activo', 1, '7c222fb2927d828af22f592134e8932480637c0d', 0),
(34, 'asdasq', 'qweqw', '24512546541', 'qwqw2@hotmail.com', 12345678, 12345678, 'Activo', 2, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0),
(36, 'Fede', 'nuevooYU', '21474836471', 'tesuiuhut@hotmail.com', 12345978, 12345678, 'Activo', 2, 'd4fc3dbc817626b9db0c73cefd86129df782519e', 1),
(37, 'Limpiezaa', 'qweqw', '21474836471', 'tesqwddqwt@hotmail.com', 12345678, 12345678, 'Activo', 0, '7c222fb2927d828af22f592134e8932480637c0d', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `consorcio`
--
ALTER TABLE `consorcio`
  ADD PRIMARY KEY (`idConsorcio`);

--
-- Indices de la tabla `expensa`
--
ALTER TABLE `expensa`
  ADD PRIMARY KEY (`idExpensa`),
  ADD KEY `FK_idLiquidacion` (`idLiquidacion`),
  ADD KEY `FK_idPropiedad` (`idPropiedad`);

--
-- Indices de la tabla `formasdepago`
--
ALTER TABLE `formasdepago`
  ADD PRIMARY KEY (`idFormaPago`);

--
-- Indices de la tabla `gasto`
--
ALTER TABLE `gasto`
  ADD PRIMARY KEY (`idGasto`),
  ADD KEY `FK_idReclamo` (`idReclamo`),
  ADD KEY `FK_idProvedor` (`idProveedor`);

--
-- Indices de la tabla `liquidacion`
--
ALTER TABLE `liquidacion`
  ADD PRIMARY KEY (`idLiquidacion`);

--
-- Indices de la tabla `liquidaciongasto`
--
ALTER TABLE `liquidaciongasto`
  ADD KEY `FK_idLiquidacionGasto` (`idLiquidacion`),
  ADD KEY `FK_idGastoLiquidacion` (`idGasto`);

--
-- Indices de la tabla `ordenpago`
--
ALTER TABLE `ordenpago`
  ADD PRIMARY KEY (`idOperacion`),
  ADD KEY `FK_idGasto` (`idGasto`),
  ADD KEY `FK_idFormaPago` (`idFormaPago`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`idPago`),
  ADD KEY `FK_idPropiedadPago` (`idPropiedad`),
  ADD KEY `FK_idLiquidacionPago` (`idLiquidacion`);

--
-- Indices de la tabla `propiedad`
--
ALTER TABLE `propiedad`
  ADD PRIMARY KEY (`idPropiedad`),
  ADD KEY `FK_idUsuariosPropiedad` (`idUsuarios`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`idProveedor`);

--
-- Indices de la tabla `reclamo`
--
ALTER TABLE `reclamo`
  ADD PRIMARY KEY (`idReclamo`),
  ADD KEY `FK_idPropiedadReclamo` (`idPropiedad`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idRoles`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuarios`),
  ADD KEY `FK_idRolesUsuario` (`idRol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `consorcio`
--
ALTER TABLE `consorcio`
  MODIFY `idConsorcio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `expensa`
--
ALTER TABLE `expensa`
  MODIFY `idExpensa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `formasdepago`
--
ALTER TABLE `formasdepago`
  MODIFY `idFormaPago` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `gasto`
--
ALTER TABLE `gasto`
  MODIFY `idGasto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `liquidacion`
--
ALTER TABLE `liquidacion`
  MODIFY `idLiquidacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ordenpago`
--
ALTER TABLE `ordenpago`
  MODIFY `idOperacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `idPago` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `propiedad`
--
ALTER TABLE `propiedad`
  MODIFY `idPropiedad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `idProveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `reclamo`
--
ALTER TABLE `reclamo`
  MODIFY `idReclamo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `idRoles` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `expensa`
--
ALTER TABLE `expensa`
  ADD CONSTRAINT `FK_idLiquidacion` FOREIGN KEY (`idLiquidacion`) REFERENCES `liquidacion` (`idLiquidacion`),
  ADD CONSTRAINT `FK_idPropiedad` FOREIGN KEY (`idPropiedad`) REFERENCES `propiedad` (`idPropiedad`);

--
-- Filtros para la tabla `gasto`
--
ALTER TABLE `gasto`
  ADD CONSTRAINT `FK_idProvedor` FOREIGN KEY (`idProveedor`) REFERENCES `proveedor` (`idProveedor`),
  ADD CONSTRAINT `FK_idReclamo` FOREIGN KEY (`idReclamo`) REFERENCES `reclamo` (`idReclamo`);

--
-- Filtros para la tabla `liquidaciongasto`
--
ALTER TABLE `liquidaciongasto`
  ADD CONSTRAINT `FK_idGastoLiquidacion` FOREIGN KEY (`idGasto`) REFERENCES `gasto` (`idGasto`),
  ADD CONSTRAINT `FK_idLiquidacionGasto` FOREIGN KEY (`idLiquidacion`) REFERENCES `liquidacion` (`idLiquidacion`);

--
-- Filtros para la tabla `ordenpago`
--
ALTER TABLE `ordenpago`
  ADD CONSTRAINT `FK_idFormaPago` FOREIGN KEY (`idFormaPago`) REFERENCES `formasdepago` (`idFormaPago`),
  ADD CONSTRAINT `FK_idGasto` FOREIGN KEY (`idGasto`) REFERENCES `gasto` (`idGasto`);

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `FK_idLiquidacionPago` FOREIGN KEY (`idLiquidacion`) REFERENCES `liquidacion` (`idLiquidacion`),
  ADD CONSTRAINT `FK_idPropiedadPago` FOREIGN KEY (`idPropiedad`) REFERENCES `propiedad` (`idPropiedad`);

--
-- Filtros para la tabla `propiedad`
--
ALTER TABLE `propiedad`
  ADD CONSTRAINT `FK_idUsuariosPropiedad` FOREIGN KEY (`idUsuarios`) REFERENCES `usuarios` (`idUsuarios`);

--
-- Filtros para la tabla `reclamo`
--
ALTER TABLE `reclamo`
  ADD CONSTRAINT `FK_idPropiedadReclamo` FOREIGN KEY (`idPropiedad`) REFERENCES `propiedad` (`idPropiedad`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `FK_idRolesUsuario` FOREIGN KEY (`idRol`) REFERENCES `roles` (`idRoles`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
