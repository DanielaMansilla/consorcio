<?php
require_once '../config/Conexion.php'; 
session_start();
if (!isset($_SESSION['propietario'])) {
    header("Location: index.php");
} 
?>

<!DOCTYPE html>
<html lang="es">
<?php include('template/head.php'); ?>
    <body>
    <?php 
        include('template/nav.php');  
        include('template/header.php'); ?>
    
    <title>Consorcios del Valle - Informe Mensual</title>

<!-- /* Mensualmente se le enviara a cada integrante de cada consorcio, una minuta detallada de la liquidación 
mensual integrada por los gastos realizados por la administración y los pagos de cada participante en el 
consorcio, con un resumen final indicando el estado de la liquidación (ganancia / perdida). En la 
liquidación debe constar si algún propietario en particular posee deuda y a cuánto asciende.  
*/ -->
    <div class="container">
        <div class="content">
            <h2>Informe Mensual</h2>
            <hr />
            
            <label><b>Periodo de Liquidación:</b></label>
            <?php
                // Valores por defecto 
                $year = $month = 0;
                if (isset($_GET["year"])) {
                    $year = mysqli_real_escape_string($conexion, (strip_tags($_GET["year"], ENT_QUOTES)));
                }
                if (isset($_GET["month"])) {
                    $month = mysqli_real_escape_string($conexion, (strip_tags($_GET["month"], ENT_QUOTES)));
                }
                if ($year != 0 && $month != 0) {
                    $periodoLiquidacion = "$year-$month-01";
                }
            ?>
            
            <form class="form-inline" method="GET">
                <div class="form-group mb-2">
                    <select name="year" class="form-control" onchange="this.form.submit()">
                        <option disabled <?php if ($year == 0) echo 'selected'; ?>>- Año -</option>
                        <option value='2018' <?php if ($year == "2018" ) echo 'selected'; ?>>2018</option>
                        <option value='2019' <?php if ($year == "2019" ) echo 'selected'; ?>>2019</option>
                        <option value='2020' <?php if ($year == "2020" ) echo 'selected'; ?>>2020</option>
                        <option value='2021' <?php if ($year == "2021" ) echo 'selected'; ?>>2021</option>
                        <option value='2022' <?php if ($year == "2022" ) echo 'selected'; ?>>2022</option>
                        <option value='2023' <?php if ($year == "2023" ) echo 'selected'; ?>>2023</option>
                        <option value='2024' <?php if ($year == "2024" ) echo 'selected'; ?>>2024</option>
                        <option value='2025' <?php if ($year == "2025" ) echo 'selected'; ?>>2025</option>
                    </select>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <select name="month" class="form-control" onchange="this.form.submit()">
                        <option disabled <?php if ($month == 0) echo 'selected'; ?>>- Mes -</option>
                        <option value='01' <?php if ($month == "01" ) echo 'selected'; ?>>Enero</option>
                        <option value='02' <?php if ($month == "02" ) echo 'selected'; ?>>Febrero</option>
                        <option value='03' <?php if ($month == "03" ) echo 'selected'; ?>>Marzo</option>
                        <option value='04' <?php if ($month == "04" ) echo 'selected'; ?>>Abril</option>
                        <option value='05' <?php if ($month == "05" ) echo 'selected'; ?>>Mayo</option>
                        <option value='06' <?php if ($month == "06" ) echo 'selected'; ?>>Junio</option>
                        <option value='07' <?php if ($month == "07" ) echo 'selected'; ?>>Julio</option>
                        <option value='08' <?php if ($month == "08" ) echo 'selected'; ?>>Agosto</option>
                        <option value='09' <?php if ($month == "09" ) echo 'selected'; ?>>Septiembre</option>
                        <option value='10' <?php if ($month == "10" ) echo 'selected'; ?>>Octubre</option>
                        <option value='11' <?php if ($month == "11" ) echo 'selected'; ?>>Noviembre</option>
                        <option value='12' <?php if ($month == "12" ) echo 'selected'; ?>>Diciembre</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mb-2">Actualizar</button>
            </form>

            <hr/>
					<?php
                    if (isset($periodoLiquidacion)) {
                        $queryLiquidacionExistente = mysqli_query($conexion,
                        "SELECT *
                        FROM liquidacion
                        WHERE liquidacion.periodo = '$periodoLiquidacion'") or die(mysqli_error($conexion));
                        
                        // Verifico que en el periodo seleccionado exista una liquidación
                        if (mysqli_num_rows($queryLiquidacionExistente) == 0) {
                            echo '<div class="alert alert-warning alert-dismissable">Aviso: No existe una liquidación para el periodo seleccionado.</div>';
                        } else {
                            ?>
                            <label class=""><b>Gastos de la administración:</b></label>
                            <br>

                            <?php
                                $queryTotalGastosAdministracion = mysqli_query($conexion,
                                "SELECT SUM(gasto.importe) as total
                                FROM liquidaciongasto
                                JOIN liquidacion ON liquidaciongasto.idLiquidacion = liquidacion.idLiquidacion
                                JOIN gasto ON liquidaciongasto.idGasto = gasto.idGasto
                                WHERE liquidacion.periodo = '$periodoLiquidacion'") or die(mysqli_error($conexion));
                                
                                $totalGastosAdministracion = (float) 0.0;
                                if ($queryTotalGastosAdministracion) {
                                    $totalGastosAdministracion = number_format((float)mysqli_fetch_assoc($queryTotalGastosAdministracion)["total"], 2, '.', '');
                                }
                                echo "<strong>TOTAL:</strong> $ $totalGastosAdministracion";
                            ?>

                            <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <th>Id</th>
                                    <th>Fecha</th>
                                    <th>Reclamo</th>
                                    <th>Nro Factura</th>
                                    <th>Proveedor</th>
                                    <th>Concepto</th>
                                    <th>Importe</th>
                                </tr>
                    <?php
                        $queryGastosAdministracion = mysqli_query($conexion,
                        "SELECT *, reclamo.fecha as fechaReclamo, gasto.fecha as fechaGasto, reclamo.estado as estadoReclamo, gasto.estado as estadoGasto
                        FROM liquidaciongasto
                        JOIN liquidacion ON liquidaciongasto.idLiquidacion = liquidacion.idLiquidacion
                        JOIN gasto ON liquidaciongasto.idGasto = gasto.idGasto
                        JOIN proveedor ON gasto.idProveedor = proveedor.idProveedor
                        LEFT JOIN reclamo ON reclamo.idReclamo = gasto.idReclamo 
                        LEFT JOIN propiedad ON reclamo.idPropiedad = propiedad.idPropiedad
                        WHERE liquidacion.periodo = '$periodoLiquidacion'
                        ORDER BY liquidacion.idLiquidacion ASC") or die(mysqli_error($conexion));
    
                        if (mysqli_num_rows($queryGastosAdministracion) == 0) {
                            echo '<tr><td colspan="8">No hay gastos para listar.</td></tr>';
                        } else {
                            while ($row = mysqli_fetch_assoc($queryGastosAdministracion)) {
                                echo '
                                <!-- Modal -->
                                <div class="modal fade" id="modal-reclamo-'.$row['idReclamo'].'" role="dialog">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Reclamo Nro: '.$row['idReclamo'].'</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p><b>Fecha:</b> '.$row['fechaReclamo'].'</p>
                                            <p><b>Estado:</b> '.$row['estadoReclamo'].'</p>
                                            <p><b>Propiedad (Id):</b> '.$row['idPropiedad'].'</b></p>
                                            <p><b>Piso:</b> '.$row['piso'].' - <b>Departamento:</b> '.$row['departamento'].'</p>
                                            <p><b>Descripción:</b> '.$row['descripcion'].'</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
    
                                <div class="modal fade" id="modal-proveedor-'.$row['idProveedor'].'" role="dialog">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Proveedor Nro: '.$row['idProveedor'].'</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p><b>Nombre:</b> '.$row['nombre'].'</p>
                                        <p><b>CUIT:</b> '.$row['cuit'].'</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                                </div>
                            </div>
    
                                <tr>
                                    <td>'.$row['idGasto'].'</td>
                                    <td>'.$row['fechaGasto'].'</td>
                                    <td><a href="#" data-toggle="modal" data-target="#modal-reclamo-'.$row['idReclamo'].'"><span class="fas fa-info-circle" aria-hidden="true"></span> '.$row['idReclamo'].'</a></td>
                                    <td>'.$row['nroFactura'].'</td>
                                    <td><a href="#" data-toggle="modal" data-target="#modal-proveedor-'.$row['idProveedor'].'"><span class="fas fa-info-circle" aria-hidden="true"></span> '.$row['nombre'].'</a></td>
                                    <td>'.$row['concepto'].'</td>
                                    <td>$ '.$row['importe'].'</td>
                                </tr>';
                            }
                        }
                        echo '</table>';

                        ?>
                            <hr />
                            <label class=""><b>Pagos de los propietarios:</b></label>
                            <br>

                            <?php
                                $queryTotalPagosPropietarios = mysqli_query($conexion,
                                "SELECT SUM(ordenpago.importe) as total
                                FROM ordenpago
                                JOIN expensa ON ordenpago.idExpensa = expensa.idExpensa
                                JOIN liquidacion ON expensa.idLiquidacion = liquidacion.idLiquidacion
                                WHERE liquidacion.periodo = '$periodoLiquidacion'") or die(mysqli_error($conexion));
                                
                                $totalPagosPropietarios = (float) 0.0;
                                if ($queryTotalPagosPropietarios) {
                                    $totalPagosPropietarios = number_format((float)mysqli_fetch_assoc($queryTotalPagosPropietarios)["total"], 2, '.', '');
                                }
                                echo "<strong>TOTAL:</strong> $ $totalPagosPropietarios";
                            ?>

                            <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <th>Id</th>
                                    <th>Fecha</th>
                                    <th>Propietario</th>
                                    <th>Propiedad</th>
                                    <th>Forma de Pago</th>
                                    <th>Importe</th>
                                </tr>
                    <?php
                        $queryPagosPropietarios = mysqli_query($conexion,
                        "SELECT *, ordenpago.fecha as fechaOrdenPago, ordenpago.importe as importeOrdenPago, formasdepago.descripcion as descripcionFormaPago
                        FROM ordenpago
                        JOIN formasdepago ON ordenpago.idFormaPago = formasdepago.idFormaPago
                        JOIN expensa ON ordenpago.idExpensa = expensa.idExpensa
                        JOIN liquidacion ON expensa.idLiquidacion = liquidacion.idLiquidacion
                        JOIN propiedad ON expensa.idPropiedad = propiedad.idPropiedad
                        JOIN usuarios ON propiedad.idUsuarios = usuarios.IdUsuarios
                        WHERE liquidacion.periodo = '$periodoLiquidacion'
                        ORDER BY ordenpago.idOperacion ASC") or die(mysqli_error($conexion));

                        $cantidadPagosPropietarios = mysqli_num_rows($queryPagosPropietarios);
                        if ($cantidadPagosPropietarios == 0) {
                            echo '<tr><td colspan="8">No hay pagos para listar.</td></tr>';
                        } else {
                            while ($pagoPropietario = mysqli_fetch_assoc($queryPagosPropietarios)) {
                                echo '<tr>
                                <td>'.$pagoPropietario['idOperacion'].'</td>
                                <td>'.$pagoPropietario['fechaOrdenPago'].'</td>
                                <td><a href="#" data-toggle="modal" data-target="#modal-propietario-'.$pagoPropietario['idUsuarios'].'"><span class="fas fa-info-circle" aria-hidden="true"></span> '.$pagoPropietario['apellido']. ' '.$pagoPropietario['nombre'].'</a></td>
                                <td><a href="#" data-toggle="modal" data-target="#modal-propiedad-'.$pagoPropietario['idPropiedad'].'"><span class="fas fa-info-circle" aria-hidden="true"></span> Piso: '.$pagoPropietario['piso'].' - Dpto: '.$pagoPropietario['departamento'].'</a></td>
                                <td>'.$pagoPropietario['descripcionFormaPago'].'</td>
                                <td>$ '.$pagoPropietario['importeOrdenPago'].'</td>
                                </tr>';

                                echo '
                                <!-- Modal Propietario-->
                                <div class="modal fade" id="modal-propietario-'.$pagoPropietario['idUsuarios'].'" role="dialog">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Propietario Nro: '.$pagoPropietario['idUsuarios'].'</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p><b>Apellido:</b> '.$pagoPropietario['apellido'].'</p>
                                            <p><b>Nombre:</b> '.$pagoPropietario['nombre'].'</p>
                                            <p><b>DNI:</b> '.$pagoPropietario['dni'].'</b></p>
                                            <p><b>CUIL:</b> '.$pagoPropietario['cuil'].'</b></p>
                                            <p><b>E-mail:</b> '.$pagoPropietario['email'].'</b></p>
                                            <p><b>Teléfono:</b> '.$pagoPropietario['telefono'].'</b></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>';

                                echo '
                                <!-- Modal Propiedad-->
                                <div class="modal fade" id="modal-propiedad-'.$pagoPropietario['idPropiedad'].'" role="dialog">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Propiedad Nro: '.$pagoPropietario['idPropiedad'].'</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p><b>Piso:</b> '.$pagoPropietario['piso'].'</b></p>
                                            <p><b>Departamento:</b> '.$pagoPropietario['departamento'].'</b></p>
                                            <p><b>Lote Unidad Funcional:</b> '.$pagoPropietario['unidadFuncionalLote'].'</p>
                                            <p><b>Porcentaje Participación:</b> '.$pagoPropietario['porcentajeParticipacion'].' %</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>';
                            }
                        }
                        echo '</table>';

                    ?>
                        <hr />
                        <label class=""><b>Propietarios con Deudas:</b></label>

                        <?php
                            $queryTotalDeudasPropietarios = mysqli_query($conexion,
                            "SELECT SUM(expensa.importe) as total
                            FROM expensa 
                            JOIN liquidacion ON expensa.idLiquidacion = liquidacion.idLiquidacion
                            JOIN propiedad ON expensa.idPropiedad = propiedad.idPropiedad
                            JOIN usuarios ON propiedad.idUsuarios = usuarios.IdUsuarios
                            WHERE liquidacion.periodo = '$periodoLiquidacion'
                            AND expensa.estado = 'Impago'") or die(mysqli_error($conexion));
                            
                            $totalDeudasPropietarios = (float) 0.0;
                            if ($queryTotalDeudasPropietarios) {
                                $totalDeudasPropietarios = number_format((float)mysqli_fetch_assoc($queryTotalDeudasPropietarios)["total"], 2, '.', '');
                            }
                            echo "<br><strong>TOTAL:</strong> $ $totalDeudasPropietarios";
                        ?>

                        <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <tr>
                                <th>Id</th>
                                <th>Propietario</th>
                                <th>Propiedad</th>
                                <th>Vencimiento</th>
                                <th>Importe</th>
                            </tr>
                    <?php
                        $queryPropietariosDeudores = mysqli_query($conexion,
                        "SELECT *, expensa.importe as importeExpensa
                        FROM expensa 
                        JOIN liquidacion ON expensa.idLiquidacion = liquidacion.idLiquidacion
                        JOIN propiedad ON expensa.idPropiedad = propiedad.idPropiedad
                        JOIN usuarios ON propiedad.idUsuarios = usuarios.IdUsuarios
                        WHERE liquidacion.periodo = '$periodoLiquidacion'
                        AND expensa.estado = 'Impago'") or die(mysqli_error($conexion));

                        $cantidadPropietariosDeudores = mysqli_num_rows($queryPropietariosDeudores);
                        if ($cantidadPropietariosDeudores == 0) {
                            echo '<tr><td colspan="8">No hay propietarios con deudas para listar.</td></tr>';
                        } else {
                            while ($propietarioDeudor = mysqli_fetch_assoc($queryPropietariosDeudores)) {
                                ?>
                                    <tr>
                                        <td><?php echo $propietarioDeudor['idExpensa'] ?></td>
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#modal-propietario-<?php echo $propietarioDeudor['idUsuarios'] ?>">
                                                <span class="fas fa-info-circle" aria-hidden="true"></span> <?php echo $propietarioDeudor['apellido'] ?> <?php echo $propietarioDeudor['nombre'] ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#modal-propiedad-<?php echo $propietarioDeudor['idPropiedad']?>">
                                                <span class="fas fa-info-circle" aria-hidden="true"></span> Piso: <?php echo $propietarioDeudor['piso'] ?> - Dpto: <?php echo $propietarioDeudor['departamento'] ?>
                                            </a>
                                        </td>
                                        <td><?php echo $propietarioDeudor['vencimiento'] ?></td>
                                        <td>$ <?php echo $propietarioDeudor['importeExpensa'] ?></td>
                                    </tr>

                                    <!-- Modal Propietario-->
                                    <div class="modal fade" id="modal-propietario-<?php echo $propietarioDeudor['idUsuarios'] ?>" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Propietario Nro: <?php echo $propietarioDeudor['idUsuarios'] ?></h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p><b>Apellido:</b> <?php echo $propietarioDeudor['apellido'] ?></p>
                                                    <p><b>Nombre:</b> <?php echo $propietarioDeudor['nombre'] ?></p>
                                                    <p><b>DNI:</b> <?php echo $propietarioDeudor['dni'] ?></b></p>
                                                    <p><b>CUIL:</b> <?php echo $propietarioDeudor['cuil'] ?></b></p>
                                                    <p><b>E-mail:</b> <?php echo $propietarioDeudor['email'] ?></b></p>
                                                    <p><b>Teléfono:</b> <?php echo $propietarioDeudor['telefono'] ?></b></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Propiedad-->
                                    <div class="modal fade" id="modal-propiedad-<?php echo $propietarioDeudor['idPropiedad'] ?>" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Propiedad Nro: <?php echo $propietarioDeudor['idPropiedad'] ?></h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p><b>Piso:</b> <?php echo $propietarioDeudor['piso'] ?></b></p>
                                                    <p><b>Departamento:</b> <?php echo $propietarioDeudor['departamento'] ?></b></p>
                                                    <p><b>Lote Unidad Funcional:</b> <?php echo $propietarioDeudor['unidadFuncionalLote'] ?></p>
                                                    <p><b>Porcentaje Participación:</b> <?php echo $propietarioDeudor['porcentajeParticipacion'] ?> %</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                            }
                        }
                        ?>
                            </table>

                            <?php
                                if (isset($totalPagosPropietarios) && isset($totalGastosAdministracion) && isset($totalDeudasPropietarios)) {
                                    ?>
                                        <hr />
                                        <h2 class="text-center"><b>Resumen:</b></h2>
                                        <br>
                                        <div class="card text-center bg-light mb-3 mx-auto" style="max-width: 18rem;">
                                            <div class="card-header"><strong>Liquidación</strong></div>
                                            <div class="card-body">
                                                <p style="color: green;">Ganancia: + $ <?php echo $totalPagosPropietarios ?></p>
                                                <p style="color: red;">Perdida: - $ <?php echo number_format((float)($totalGastosAdministracion + $totalDeudasPropietarios), 2, '.', '') ?></p>
                                                <p><strong>Neto: $ <?php echo number_format((float)($totalPagosPropietarios - ($totalGastosAdministracion + $totalDeudasPropietarios)), 2, '.', '') ?></strong></p>
                                            </div>
                                        </div>
                                    <?php
                                }
                            ?>

                        <?php
                        }
                    } else {
                        echo '<div class="alert alert-info alert-dismissable">Seleccione un <b>Año</b> y un <b>Mes</b> para visualizar un informe mensual.</div>';
                    }
					?>
        </div>
	</div>         
    
    <div class="corte">
    </div>
        <?php include('template/footer.php'); ?>
    </body>
</html>