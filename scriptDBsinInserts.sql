-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-07-2018 a las 07:13:26
-- Versión del servidor: 10.1.31-MariaDB
-- Versión de PHP: 7.2.3

--
-- Base de datos: `consorcio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consorcio`
--

CREATE TABLE `consorcio` (
  `idConsorcio` int(11) UNSIGNED NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `cuit` bigint(11) UNSIGNED NOT NULL,
  `codigoPostal` int(4) NOT NULL,
  `telefono` int(11) NOT NULL,
  `correo` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(70) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expensa`
--

CREATE TABLE `expensa` (
  `idExpensa` int(11) UNSIGNED NOT NULL,
  `idLiquidacion` int(11) UNSIGNED DEFAULT NULL,
  `idPropiedad` int(11) UNSIGNED DEFAULT NULL,
  `importe` decimal(12,2) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `vencimiento` date DEFAULT NULL,
  `estado` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formasdepago`
--

CREATE TABLE `formasdepago` (
  `idFormaPago` int(11) UNSIGNED NOT NULL,
  `descripcion` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gasto`
--

CREATE TABLE `gasto` (
  `idGasto` int(11) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `importe` decimal(12,2) UNSIGNED NOT NULL,
  `concepto` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `estado` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idReclamo` int(11) UNSIGNED DEFAULT NULL,
  `nroFactura` int(11) UNSIGNED DEFAULT NULL,
  `idProveedor` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `liquidacion`
--

CREATE TABLE `liquidacion` (
  `idLiquidacion` int(11) UNSIGNED NOT NULL,
  `periodo` date NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `liquidaciongasto`
--

CREATE TABLE `liquidaciongasto` (
  `idLiquidacion` int(11) UNSIGNED DEFAULT NULL,
  `idGasto` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenpago`
--

CREATE TABLE `ordenpago` (
  `idOperacion` int(11) UNSIGNED NOT NULL,
  `idExpensa` int(11) UNSIGNED NOT NULL,
  `importe` decimal(12,2) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `idFormaPago` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `propiedad`
--

CREATE TABLE `propiedad` (
  `idPropiedad` int(11) UNSIGNED NOT NULL,
  `idUsuarios` int(11) UNSIGNED DEFAULT NULL,
  `porcentajeParticipacion` int(3) UNSIGNED NOT NULL,
  `piso` int(3) NOT NULL,
  `departamento` varchar(1) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `unidadFuncionalLote` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idConsorcio` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `idProveedor` int(11) UNSIGNED NOT NULL,
  `cuit` bigint(11) NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reclamo`
--

CREATE TABLE `reclamo` (
  `idReclamo` int(11) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `estado` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idPropiedad` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `idRoles` int(11) UNSIGNED NOT NULL,
  `descripcion` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuarios` int(11) UNSIGNED NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `cuil` bigint(11) UNSIGNED NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `dni` int(8) UNSIGNED NOT NULL,
  `telefono` int(11) UNSIGNED NOT NULL,
  `estado` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idRol` int(11) UNSIGNED NOT NULL,
  `pass` varchar(32) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `primeraVez` tinyint(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  ADD KEY `FK_idFormaPago` (`idFormaPago`),
  ADD KEY `FK_idExpensa` (`idExpensa`);

--
-- Indices de la tabla `propiedad`
--
ALTER TABLE `propiedad`
  ADD PRIMARY KEY (`idPropiedad`),
  ADD KEY `FK_idUsuariosPropiedad` (`idUsuarios`),
  ADD KEY `FK_idConsorcio` (`idConsorcio`);

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
  MODIFY `idConsorcio` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `expensa`
--
ALTER TABLE `expensa`
  MODIFY `idExpensa` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `formasdepago`
--
ALTER TABLE `formasdepago`
  MODIFY `idFormaPago` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `gasto`
--
ALTER TABLE `gasto`
  MODIFY `idGasto` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `liquidacion`
--
ALTER TABLE `liquidacion`
  MODIFY `idLiquidacion` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ordenpago`
--
ALTER TABLE `ordenpago`
  MODIFY `idOperacion` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `propiedad`
--
ALTER TABLE `propiedad`
  MODIFY `idPropiedad` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `idProveedor` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reclamo`
--
ALTER TABLE `reclamo`
  MODIFY `idReclamo` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `idRoles` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuarios` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  ADD CONSTRAINT `FK_idExpensa` FOREIGN KEY (`idExpensa`) REFERENCES `expensa` (`idExpensa`),
  ADD CONSTRAINT `FK_idFormaPago` FOREIGN KEY (`idFormaPago`) REFERENCES `formasdepago` (`idFormaPago`);

--
-- Filtros para la tabla `propiedad`
--
ALTER TABLE `propiedad`
  ADD CONSTRAINT `FK_idConsorcio` FOREIGN KEY (`idConsorcio`) REFERENCES `consorcio` (`idConsorcio`),
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