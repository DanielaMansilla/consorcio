<?php
require_once '../config/Conexion.php'; 
session_start();
// Permisos
if(!isset($_SESSION['admin']) && !isset($_SESSION['operador']) && !isset($_SESSION['propietario'])) {
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

		<title>Consorcios del Valle - Lista de Reclamos</title>

        <div class="container">
		<div class="content">
			<h2>Lista de Reclamos</h2>
			<hr />
			<!-- Filtro -->
			<form class="form-inline" method="get">
				<div class="input-group">
					<select name="filter" class="custom-select" onchange="form.submit()" id="filtro">
						<option value="0">Filtros de reclamos</option>
						<?php $filter = (isset($_GET['filter']) ? $_GET['filter'] : NULL);  ?>
						<option value="Activo" <?php if($filter == 'Activo'){ echo 'selected'; } ?>>Activo</option>
						<option value="Resuelto" <?php if($filter == 'Resuelto'){ echo 'selected'; } ?>>Resuelto</option>
					</select>
					<button onclick="document.getElementById('filtro').selectedIndex = 0;" role="button" aria-pressed="true" class="btn btn-outline-secondary">Ver Todos</button>
				</div>
			</form>

			<br/>
			<div class="table-responsive">
			<table class="table table-striped table-hover">
				<tr>
					<th>Id</th>
					<th>Fecha</th>
					<th>Propiedad</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th style="text-align:center;">Acciones</th>
				</tr>
				<?php

					$idUsuario = $_SESSION['idUsuario'];
					$sql = mysqli_query($conexion, 
					"SELECT * 
					FROM reclamo 
					JOIN propiedad ON reclamo.idPropiedad = propiedad.idPropiedad
					WHERE propiedad.idPropiedad='$idUsuario'") or die(mysqli_error($conexion));

				//Filtro
				if($filter){
					$sql = mysqli_query($conexion, "SELECT * FROM reclamo JOIN propiedad ON reclamo.idPropiedad=propiedad.idPropiedad
					WHERE idReclamo <> 1 AND estado='$filter'
					ORDER BY reclamo.idReclamo DESC");
				}else{
					$sql = mysqli_query($conexion, "SELECT * FROM reclamo JOIN propiedad ON reclamo.idPropiedad=propiedad.idPropiedad
					WHERE idReclamo <> 1
					ORDER BY reclamo.idReclamo DESC");
				}
				
				// Para los roles admin y operador se muestran todos los reclamos
				if (isset($_SESSION['admin']) || isset($_SESSION['operador'])) {
					if ($filter) {
						$sql = mysqli_query($conexion, 
						"SELECT * 
						FROM reclamo 
						JOIN propiedad ON reclamo.idPropiedad = propiedad.idPropiedad
						WHERE reclamo.estado='$filter'
						ORDER BY reclamo.idReclamo DESC") or die(mysqli_error($conexion));
					} else {
						$sql = mysqli_query($conexion, 
						"SELECT * 
						FROM reclamo
						JOIN propiedad ON reclamo.idPropiedad = propiedad.idPropiedad
						ORDER BY reclamo.idReclamo DESC") or die(mysqli_error($conexion));
					}
				} else { // Si es propietario
					if ($filter) {
						$sql = mysqli_query($conexion, 
						"SELECT * 
						FROM reclamo
						JOIN propiedad ON reclamo.idPropiedad = propiedad.idPropiedad
						WHERE propiedad.idUsuarios = '$idUsuario'
						AND reclamo.estado = '$filter'
						ORDER BY reclamo.idReclamo DESC") or die(mysqli_error($conexion));
					} else {
						$sql = mysqli_query($conexion, 
						"SELECT * 
						FROM reclamo
						JOIN propiedad ON reclamo.idPropiedad = propiedad.idPropiedad
						WHERE propiedad.idUsuarios = '$idUsuario'
						ORDER BY reclamo.idReclamo DESC") or die(mysqli_error($conexion));
					}
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