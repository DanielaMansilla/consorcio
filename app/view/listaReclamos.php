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

		<title>Consorcios del Valle - Lista de Reclamos</title>

        <div class="container">
		<div class="content">
			<h2>Lista de Reclamos</h2>
			<hr />
			<!-- Filtro -->
			<form class="form-inline" method="get">
				<div class="input-group">
					<select name="filter" class="custom-select" onchange="form.submit()">
						<option value="0">Filtros de reclamos</option>
						<?php $filter = (isset($_GET['filter']) ? strtolower($_GET['filter']) : NULL);  ?>
						<option value="Activo" <?php if($filter == 'Activo'){ echo 'selected'; } ?>>Activo</option>
						<option value="Resuelto" <?php if($filter == 'Resuelto'){ echo 'selected'; } ?>>Resuelto</option>
					</select>
					<div class="input-group-append">
						<button href="listaReclamos.php" role="button" aria-pressed="true" class="btn btn-outline-secondary" type="button">Ver Todos</button>
					</div>
					
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
                    <th>Acciones</th>
				</tr>
				<?php
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
							 		echo '<a href="abm/editarReclamo.php?nik='.$row['idReclamo'].'" title="Editar datos" class="btn btn-primary btn-sm"><span class="fas fa-edit" aria-hidden="true"></span></a>';
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