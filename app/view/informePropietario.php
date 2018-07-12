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
                if (isset($_GET["year"]) && isset($_GET["month"])) {
                    $year = mysqli_real_escape_string($conexion, (strip_tags($_GET["year"], ENT_QUOTES)));
                    $month = mysqli_real_escape_string($conexion, (strip_tags($_GET["month"], ENT_QUOTES)));
                    $periodoLiquidacion = "$year-$month-01";
                }
            ?>
            
            <form class="form-inline">
                <div class="form-group mb-2">
                    <select name="year" class="form-control">
                        <option disabled <?php if ($year == 0) echo 'selected'; ?>>- Año -</option>
                        <!-- TODO: Obtener años disponibles de liquidaciones -->
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
                    <select name="month" class="form-control">
                        <option disabled <?php if ($month == 0) echo 'selected'; ?>>- Mes -</option>
                        <!-- TODO: Obtener meses disponibles de liquidaciones en base al año -->
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
                <button type="submit" class="btn btn-primary mb-2">Buscar</button>
            </form>

            <hr/>
					<?php
                    if (isset($periodoLiquidacion)) {
                        ?>
                            <label class=""><b>Gastos de la administración:</b></label>
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
                                        <p><b>Propiedad (Id):</b> '.$row['idPropiedad'].'</b> 
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
                                    <td>$ '.$row['importe'].'</td>';
                            }

                            $queryTotalGastosAdministracion = mysqli_query($conexion,
                            "SELECT SUM(gasto.importe) as total
                            FROM liquidaciongasto
                            JOIN liquidacion ON liquidaciongasto.idLiquidacion = liquidacion.idLiquidacion
                            JOIN gasto ON liquidaciongasto.idGasto = gasto.idGasto
                            WHERE liquidacion.periodo = '$periodoLiquidacion'") or die(mysqli_error($conexion));
                            
                            $totalGastosAdministracion = (float) 0.0;
                            if ($queryTotalGastosAdministracion) {
                                $totalGastosAdministracion = number_format((float)mysqli_fetch_assoc($queryTotalGastosAdministracion)["total"], 2, '.', '') ;
                            } else {
                                // TODO: Mostrar error!
                            }
                            echo "<strong>TOTAL:</strong> $ $totalGastosAdministracion";
                        }
                        echo '</table>';
                    }
					?>
        </div>
	</div>         
    
    <div class="corte">
    </div>
        <?php include('template/footer.php'); ?>
    </body>
</html>