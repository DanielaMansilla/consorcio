

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


CREATE TABLE `expensa` (
  `idExpensa` int(11) NOT NULL,
  `idLiquidacion` int(11) DEFAULT NULL,
  `idPropiedad` int(11) DEFAULT NULL,
  `importe` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `vencimiento` date DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE `formasdepago` (
  `idFormaPago` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



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



CREATE TABLE `liquidacion` (
  `idLiquidacion` int(11) NOT NULL,
  `periodo` date NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `liquidaciongasto` (
  `idLiquidacion` int(11) DEFAULT NULL,
  `idGasto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE `ordenpago` (
  `idOperacion` int(11) NOT NULL,
  `idGasto` int(11) DEFAULT NULL,
  `importe` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `idFormaPago` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `pago` (
  `idPago` int(11) NOT NULL,
  `idPropiedad` int(11) DEFAULT NULL,
  `importe` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `idLiquidacion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE `propiedad` (
  `idPropiedad` int(11) NOT NULL,
  `idUsuarios` int(11) DEFAULT NULL,
  `porcentajeParticipacion` int(11) DEFAULT NULL,
  `piso` int(11) NOT NULL,
  `deposito` int(11) NOT NULL,
  `unidadFuncionalLote` varchar(50) NOT NULL,
  `idConsorcio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `proveedor` (
  `idProveedor` int(11) NOT NULL,
  `cuit` varchar(13) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE `reclamo` (
  `idReclamo` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `idPropiedad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE `roles` (
  `idRoles` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



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


ALTER TABLE `consorcio`
  ADD PRIMARY KEY (`idConsorcio`);


ALTER TABLE `expensa`
  ADD PRIMARY KEY (`idExpensa`),
  ADD KEY `FK_idLiquidacion` (`idLiquidacion`),
  ADD KEY `FK_idPropiedad` (`idPropiedad`);


ALTER TABLE `formasdepago`
  ADD PRIMARY KEY (`idFormaPago`);


ALTER TABLE `gasto`
  ADD PRIMARY KEY (`idGasto`),
  ADD KEY `FK_idReclamo` (`idReclamo`),
  ADD KEY `FK_idProvedor` (`idProveedor`);


ALTER TABLE `liquidacion`
  ADD PRIMARY KEY (`idLiquidacion`);

ALTER TABLE `liquidaciongasto`
  ADD KEY `FK_idLiquidacionGasto` (`idLiquidacion`),
  ADD KEY `FK_idGastoLiquidacion` (`idGasto`);


ALTER TABLE `ordenpago`
  ADD PRIMARY KEY (`idOperacion`),
  ADD KEY `FK_idGasto` (`idGasto`),
  ADD KEY `FK_idFormaPago` (`idFormaPago`);


ALTER TABLE `pago`
  ADD PRIMARY KEY (`idPago`),
  ADD KEY `FK_idPropiedadPago` (`idPropiedad`),
  ADD KEY `FK_idLiquidacionPago` (`idLiquidacion`);


ALTER TABLE `propiedad`
  ADD PRIMARY KEY (`idPropiedad`),
  ADD KEY `FK_idUsuariosPropiedad` (`idUsuarios`);


ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`idProveedor`);


ALTER TABLE `reclamo`
  ADD PRIMARY KEY (`idReclamo`),
  ADD KEY `FK_idPropiedadReclamo` (`idPropiedad`);


ALTER TABLE `roles`
  ADD PRIMARY KEY (`idRoles`);

ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuarios`),
  ADD KEY `FK_idRolesUsuario` (`idRol`);


ALTER TABLE `consorcio`
  MODIFY `idConsorcio` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `expensa`
  MODIFY `idExpensa` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `formasdepago`
  MODIFY `idFormaPago` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `gasto`
  MODIFY `idGasto` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `liquidacion`
  MODIFY `idLiquidacion` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ordenpago`
  MODIFY `idOperacion` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `pago`
  MODIFY `idPago` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `propiedad`
  MODIFY `idPropiedad` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `proveedor`
  MODIFY `idProveedor` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `reclamo`
  MODIFY `idReclamo` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `roles`
  MODIFY `idRoles` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `usuarios`
  MODIFY `idUsuarios` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `expensa`
  ADD CONSTRAINT `FK_idLiquidacion` FOREIGN KEY (`idLiquidacion`) REFERENCES `liquidacion` (`idLiquidacion`),
  ADD CONSTRAINT `FK_idPropiedad` FOREIGN KEY (`idPropiedad`) REFERENCES `propiedad` (`idPropiedad`);


ALTER TABLE `gasto`
  ADD CONSTRAINT `FK_idProvedor` FOREIGN KEY (`idProveedor`) REFERENCES `proveedor` (`idProveedor`),
  ADD CONSTRAINT `FK_idReclamo` FOREIGN KEY (`idReclamo`) REFERENCES `reclamo` (`idReclamo`);


ALTER TABLE `liquidaciongasto`
  ADD CONSTRAINT `FK_idGastoLiquidacion` FOREIGN KEY (`idGasto`) REFERENCES `gasto` (`idGasto`),
  ADD CONSTRAINT `FK_idLiquidacionGasto` FOREIGN KEY (`idLiquidacion`) REFERENCES `liquidacion` (`idLiquidacion`);


ALTER TABLE `ordenpago`
  ADD CONSTRAINT `FK_idFormaPago` FOREIGN KEY (`idFormaPago`) REFERENCES `formasdepago` (`idFormaPago`),
  ADD CONSTRAINT `FK_idGasto` FOREIGN KEY (`idGasto`) REFERENCES `gasto` (`idGasto`);


ALTER TABLE `pago`
  ADD CONSTRAINT `FK_idLiquidacionPago` FOREIGN KEY (`idLiquidacion`) REFERENCES `liquidacion` (`idLiquidacion`),
  ADD CONSTRAINT `FK_idPropiedadPago` FOREIGN KEY (`idPropiedad`) REFERENCES `propiedad` (`idPropiedad`);


ALTER TABLE `propiedad`
  ADD CONSTRAINT `FK_idUsuariosPropiedad` FOREIGN KEY (`idUsuarios`) REFERENCES `usuarios` (`idUsuarios`);


ALTER TABLE `reclamo`
  ADD CONSTRAINT `FK_idPropiedadReclamo` FOREIGN KEY (`idPropiedad`) REFERENCES `propiedad` (`idPropiedad`);


ALTER TABLE `usuarios`
  ADD CONSTRAINT `FK_idRolesUsuario` FOREIGN KEY (`idRol`) REFERENCES `roles` (`idRoles`);
COMMIT;
