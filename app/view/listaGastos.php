<?php
require_once '../config/Conexion.php'; 
session_start();
// Permisos
if(!isset($_SESSION['admin']) && !isset($_SESSION['operador'])) {
	header("Location: index.php");
} 
?>

<!DOCTYPE html>
<html lang="es"
<?php include('template/head.php'); ?>

    <body>
    <?php 
        include('template/nav.php');  
        include('template/header.php'); ?>

		<title>Consorcios del Valle - Lista de Gastos</title>

        <div class="container">
		<div class="content">
			<h2>Lista de Gastos</h2>
			<hr />

			<br/>
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
                    <th>Acciones</th>
				</tr>
				<?php

				$sql = mysqli_query($conexion, "SELECT *, reclamo.fecha as fechaReclamo, gasto.fecha as fechaGasto, reclamo.estado as estadoReclamo, gasto.estado as estadoGasto
				FROM gasto JOIN proveedor ON gasto.idProveedor=proveedor.idProveedor 
				JOIN reclamo ON reclamo.idReclamo=gasto.idReclamo 
				JOIN propiedad ON reclamo.idPropiedad=propiedad.idPropiedad 
				ORDER BY gasto.idGasto DESC");

				if (mysqli_num_rows($sql) == 0) {
					echo '<tr><td colspan="8">No hay reclamos a listar.</td></tr>';
				} else {
					while ($row = mysqli_fetch_assoc($sql)) {
						// echo "<script>console.log( 'Debug Objects: " . json_encode($row) . "' );</script>";
						
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
							
							echo '<td></td>';
					}
				}
				?>
			</table>
			</div>
		</div>
	</div><center>
	
    <div class="corte">
    </div>
    <?php include('template/footer.php'); ?>
    </body>

</html>