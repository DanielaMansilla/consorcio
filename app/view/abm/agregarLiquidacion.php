<?php
require_once '../../config/Conexion.php'; 
session_start();
// Permisos
if (!isset($_SESSION['admin']) && !isset($_SESSION['operador'])) {
	header("Location: index.php");
} 
?>

<!DOCTYPE html>
<html lang="es"
<?php include('../template/head.php'); ?>

    <body>
    <?php 
        include('../template/nav.php');  
        include('../template/header.php'); ?>

		<title>Consorcios del Valle - Agregar Nueva Liquidación</title>

        <div class="container">
		<div class="content">
			<h2>Pagos &raquo; Agregar Nueva Liquidación</h2>
			<hr />
			<br/>

			<?php
			if (isset($_POST['add'])) {
				// TODO: Validar que se hayan ingresado la fecha y el Mes...
				$yearLiquidacion = mysqli_real_escape_string($conexion,(strip_tags($_POST["yearLiquidacion"],ENT_QUOTES)));
				$mesLiquidacion = mysqli_real_escape_string($conexion,(strip_tags($_POST["mesLiquidacion"],ENT_QUOTES)));
				$periodo = "$yearLiquidacion-$mesLiquidacion-01";

				$selectLiquidacionRepetida = mysqli_query($conexion, 
				"SELECT *
				FROM liquidacion
				WHERE liquidacion.periodo = '$periodo'") or die(mysqli_error($conexion));

				// Si no se encuetra una liquidacion del periodo seleccionado puedo continuar
				if (mysqli_num_rows($selectLiquidacionRepetida) == 0) {
				if (isset($_POST['gastosLiquidacion']) && !empty($_POST['gastosLiquidacion'])) {
					// La fecha se setea desde MySQL a través de la funcion now()
					$insertLiquidacion = mysqli_query($conexion, "INSERT INTO liquidacion(periodo, fecha) 
					VALUES('$periodo', now())") or die(mysqli_error($conexion));

					if ($insertLiquidacion) {
						$idLiquidacion = mysqli_insert_id($conexion);
						$gastosLiquidacion = $_POST['gastosLiquidacion'];
						foreach ($gastosLiquidacion as $idGasto) {
							$insertGasto = mysqli_query($conexion, "INSERT INTO liquidaciongasto(idLiquidacion, idGasto) 
							VALUES('$idLiquidacion', '$idGasto')") or die(mysqli_error($conexion));

							if(!$insertGasto) {
								echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error: No se ha podido crear una nueva liquidación!</div>';
							}
						}
						
						$queryGastoTotalLiquidacion = mysqli_query($conexion, 
						"SELECT SUM(gasto.importe) as gastoTotal 
						FROM liquidaciongasto 
						JOIN gasto ON liquidaciongasto.idGasto = gasto.idGasto 
						WHERE liquidaciongasto.idLiquidacion = '$idLiquidacion';") or die(mysqli_error($conexion));
						
						$gastoTotalLiquidacion = (float) mysqli_fetch_assoc($queryGastoTotalLiquidacion)["gastoTotal"];
						if (!$gastoTotalLiquidacion) {
							die(mysqli_error($conexion));
						}

						// Se le agrega un 20% de comisión al gasto total
						$gastoTotalFinal = $gastoTotalLiquidacion * 1.20;
						$gastoTotalFinalRedondeado = number_format((float)$gastoTotalFinal, 2, '.', '') ;

						$queryPropietarios = mysqli_query($conexion, 
						"SELECT idPropiedad, idUsuarios, porcentajeParticipacion FROM propiedad;") or die(mysqli_error($conexion));

						if (!$queryPropietarios) {
							die(mysqli_error($conexion));
						}

						while ($propietario = mysqli_fetch_assoc($queryPropietarios)) {
							$idPropiedad = $propietario['idPropiedad'];
							$idUsuario = $propietario['idUsuarios'];
							$porcentajeParticipacion = (int) $propietario['porcentajeParticipacion'];
							$importe = $gastoTotalFinal * ($porcentajeParticipacion / 100);
							
							// TODO: Ver si este estado esta bien
							$estado = "Impago";

							// TODO: Ver que vencimiento poner!
							$vencimiento = date("Y-m-d");

							$insertExpensaPropietario = mysqli_query($conexion, 
							"INSERT INTO expensa(idLiquidacion, idPropiedad, importe, fecha, vencimiento, estado) 
							VALUES('$idLiquidacion', '$idPropiedad', '$importe', now(), '$vencimiento', '$estado')") or die(mysqli_error($conexion));

							if (!$insertExpensaPropietario) {
								die(mysqli_error($conexion));
							}
						}
						echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Bien hecho! Se ha creado una nueva liquidación satisfactoriamente.</div>';
					} else {
						echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error: No se ha podido crear una nueva liquidación!</div>';
					}
				} else {
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error: Debe seleccionar por lo menos un gasto para asociar a la liquidación!</div>';
				}
				} else {
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error: Ya existe una liquidación para el periodo seleccionado! </div>';
				}
			}
			?>
			<form class="form-horizontal" action="" method="post" id="reclamoForm">

				<label class="col-sm-3 control-label"><b>Periodo de Liquidación:</b></label>

				<div class="form-group">
					<label class="col-sm-3 control-label">Año</label>
					<div class="col-sm-4">
						<select name="yearLiquidacion" class="form-control">
							<option disabled selected>Seleccione un año...</option>
							<option value='2018'>2018</option>
							<option value='2019'>2019</option>
							<option value='2020'>2020</option>
							<option value='2021'>2021</option>
							<option value='2022'>2022</option>
							<option value='2022'>2023</option>
							<option value='2022'>2024</option>
							<option value='2022'>2025</option>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-3 control-label">Mes</label>
					<div class="col-sm-4">
						<select name="mesLiquidacion" class="form-control">
							<option disabled selected>Seleccione un mes...</option>
							<option value='01'>Enero</option>
							<option value='02'>Febrero</option>
							<option value='03'>Marzo</option>
							<option value='04'>Abril</option>
							<option value='05'>Mayo</option>
							<option value='06'>Junio</option>
							<option value='07'>Julio</option>
							<option value='08'>Agosto</option>
							<option value='09'>Septiembre</option>
							<option value='10'>Octubre</option>
							<option value='11'>Noviembre</option>
							<option value='12'>Diciembre</option>
						</select>
					</div>
				</div>

				<label class="col control-label">Seleccione los gastos a liquidar:</label>
				<div class="table-responsive">
				<table class="table table-striped table-hover">
					<tr>
						<th>Id</th>
						<th>Fecha</th>
						<th>Reclamo</th>
						<th>Concepto</th>
						<th>Importe</th>
						<th>Nro Factura</th>
						<th>Proveedor</th>
						<th>Estado</th>
						<th>Agregar</th>
					</tr>
					<?php
					
					// Obtengo los gastos que no estan asociados a ninguna liquidación
					$sql = mysqli_query($conexion, "SELECT *, reclamo.fecha as fechaReclamo, gasto.fecha as fechaGasto, reclamo.estado as estadoReclamo, gasto.estado as estadoGasto
					FROM gasto JOIN proveedor ON gasto.idProveedor=proveedor.idProveedor 
					LEFT JOIN reclamo ON reclamo.idReclamo=gasto.idReclamo 
					LEFT JOIN propiedad ON reclamo.idPropiedad=propiedad.idPropiedad 
					WHERE gasto.idGasto NOT IN (SELECT idGasto FROM liquidaciongasto)
					ORDER BY gasto.idGasto DESC");

					if (mysqli_num_rows($sql) == 0) {
						echo '<tr><td colspan="8">No hay gastos para listar.</td></tr>';
					} else {
						while ($row = mysqli_fetch_assoc($sql)) {
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
								<td>'.$row['concepto'].'</td>
								<td>$ '.$row['importe'].'</td>
								<td>'.$row['nroFactura'].'</td>
								<td><a href="#" data-toggle="modal" data-target="#modal-proveedor-'.$row['idProveedor'].'"><span class="fas fa-info-circle" aria-hidden="true"></span> '.$row['nombre'].'</a></td>
								<td>';
								
								$estado = $row['estadoGasto'];
								switch ($estado) {
									case "Pago":
										$badgeColor = "success";
										break;
									case "Impago":
										$badgeColor = "info";
										break;
								}
								echo '<span class="badge badge-'.$badgeColor.'">'.$estado.'</span></td>';
								echo '<td><input class="form-check-input" type="checkbox" value="'.$row['idGasto'].'" style="margin-left: 1.5rem;" name="gastosLiquidacion[]"></td>';
						}
					}
					?>
				</table>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label">&nbsp;</label>
				<div class="col-sm-6">
					<a href="../listaLiquidacion.php" class="btn btn-sm btn-danger">Cancelar</a>
					<input type="submit" name="add" class="btn btn-sm btn-primary" value="Enviar Liquidación">
				</div>
			</div>
		</form>
	</div><center>
	
    <div class="corte">
    </div>
    <?php include('../template/footer.php'); ?>
    </body>

</html>