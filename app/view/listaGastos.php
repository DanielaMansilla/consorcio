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

		<title>gastos del Valle - Lista de Gastos</title>

        <div class="container">
		<div class="content">
			<h2>Lista de Gastos</h2>
			<hr />

			<?php
			if(isset($_GET['aksi']) == 'delete'){
				$nik = mysqli_real_escape_string($conexion,(strip_tags($_GET["nik"],ENT_QUOTES)));
				$cek = mysqli_query($conexion, "SELECT * FROM gasto WHERE idGasto='$nik'");
				if(mysqli_num_rows($cek) == 0){
					echo '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> No se encotraron Gastos.</div>';
				}else{
					$delete = mysqli_query($conexion, "DELETE FROM gasto WHERE idGasto='$nik'");
					if($delete){
						echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Gasto eliminado correctamente.</div>';
					}else{
						echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Error, no se pudo eliminar el Gasto.</div>';
					}
				}
			}
			?>

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
				LEFT JOIN propiedad ON reclamo.idPropiedad=propiedad.idPropiedad 
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
							
							if(isset($_SESSION['admin'])){
								echo '
							</td>
							<td>
								<a href="abm/editarGasto.php?nik='.$row['idGasto'].'" title="Editar datos" class="btn btn-primary btn-sm"><span class="fas fa-edit" aria-hidden="true"></span></a>
								<a href="listaGastos.php?aksi=delete&nik='.$row['idGasto'].'" title="Eliminar" onclick="return confirm(\'Esta seguro de borrar el gasto: '.$row['concepto'].' con monto: '.$row['importe'].'?\')" class="btn btn-danger btn-sm"><span class="fas fa-trash" aria-hidden="true"></span></a>
							</td>
						</tr>
						';
							}if(isset($_SESSION['operador'])){
								echo '
							</td>
							<td>
								<a href="abm/editarGasto.php?nik='.$row['idGasto'].'" title="Editar datos" class="btn btn-primary btn-sm"><span class="fas fa-edit" aria-hidden="true"></span></a>
							</td>
						</tr>
						';
							}

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