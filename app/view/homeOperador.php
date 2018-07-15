<?php
require_once '../config/Conexion.php'; 
session_start();
if(!isset($_SESSION['operador'])){  // verificar si es operador
    header("Location: index.php");} ?>

<!DOCTYPE html>
<html lang="es">
<?php include('template/head.php'); ?>

    <body>
    <?php 
        include('template/nav.php');  
        include('template/header.php'); ?>
    
 		<title>Consorcios del Valle - Lista de Reclamos Pendientes</title>

        <div class="container">
		<div class="content">
			<h2>Lista de Reclamos</h2>
			<hr />

			<br/>
			<div class="table-responsive">
			<table class="table table-striped table-hover">
				<tr>
					<th>Nro. Reclamo</th>
					<th>Fecha</th>
					<th>Propiedad</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th style="text-align:center;">Acciones</th>
				</tr>
				<?php



				
				// Para los roles admin y operador se muestran todos los reclamos
				if (isset($_SESSION['admin']) || isset($_SESSION['operador'])) {
						$sql = mysqli_query($conexion, 
						"SELECT * 
						FROM reclamo 
						JOIN propiedad ON reclamo.idPropiedad = propiedad.idPropiedad
						WHERE reclamo.estado='Activo'
						ORDER BY reclamo.idReclamo DESC") or die(mysqli_error($conexion));
				}
				if (mysqli_num_rows($sql) == 0) {
					echo '<tr><td colspan="8">No hay reclamos a listar.</td></tr>';
				} else {
					while ($row = mysqli_fetch_assoc($sql)) {
						echo '
						<tr>
							<td>'.$row['idReclamo'].'</td>
							<td>'.$row['fecha'].'</td>
							<td>Piso: '.$row['piso'].' - Dpto: '.$row['departamento'].'</td>
							<td>'.$row['descripcion'].'</td>
							<td>';
							
							$estado = $row['estado'];
							switch ($estado) {
								case "Activo":
									$badgeColor = "success";
									break;
								case "Resuelto":
									$badgeColor = "info";
									break;
							}
							echo '<span class="badge badge-'.$badgeColor.'">'.$estado.'</span></td>';

							echo '<td>';
							 if (isset($_SESSION['admin']) || isset($_SESSION['operador'])) {
								if ($row['estado'] == 'Activo') {
							 		echo '<a href="abm/editarReclamo.php?nik='.$row['idReclamo'].'" title="Editar datos" class="btn btn-primary btn-sm btn-block"><span class="fas fa-edit" aria-hidden="true"></span></a>';
								}
							 }
							echo '</td>
							</tr>';
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