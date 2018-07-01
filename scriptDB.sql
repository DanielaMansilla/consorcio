-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-06-2018 a las 03:05:44
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
  `idConsorcio` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `cuit` varchar(13) NOT NULL,
  `codigoPostal` int(11) NOT NULL,
  `telefono` int(11) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `direccion` varchar(70) NOT NULL,
  `googlexy` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `departamento` int(11) NOT NULL,
  `unidadFuncionalLote` varchar(50) NOT NULL,
  `idConsorcio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `idProveedor` int(11) NOT NULL,
  `cuit` varchar(13) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `idRoles` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuarios` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `cuil` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `dni` int(11) NOT NULL,
  `telefono` int(11) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `idRol` int(11) DEFAULT NULL,
  `pass` varchar(50) NOT NULL
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
  MODIFY `idConsorcio` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `idPropiedad` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `idProveedor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reclamo`
--
ALTER TABLE `reclamo`
  MODIFY `idReclamo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `idRoles` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuarios` int(11) NOT NULL AUTO_INCREMENT;

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


-- Agregada 1 columna para vericar si entro por primera vez
ALTER TABLE `usuarios` ADD `primeraVez` TINYINT(1) NOT NULL AFTER `pass`;