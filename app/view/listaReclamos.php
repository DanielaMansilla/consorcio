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

				$sql = mysqli_query($conexion, "SELECT * FROM reclamo JOIN propiedad ON reclamo.idPropiedad=propiedad.idPropiedad ORDER BY reclamo.idReclamo DESC");

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
							
							echo '<td></td>';

							// if(isset($_SESSION['admin'])){
							// 	echo '
							// </td>
							// <td>
							// 	<a href="abm/editarUsuario.php?nik='.$row['idUsuarios'].'" title="Editar datos" class="btn btn-primary btn-sm"><span class="fas fa-edit" aria-hidden="true"></span></a>
							// 	<a href="listaUsuario.php?aksi=delete&nik='.$row['idUsuarios'].'" title="Eliminar" onclick="return confirm(\'Esta seguro de borrar los datos de: '.$row['idReclamo'].' '.$row['idReclamo'].'?\')" class="btn btn-danger btn-sm"><span class="fas fa-trash" aria-hidden="true"></span></a>
							// </td>
							// </tr>
							// ';
							// }

							// if (isset($_SESSION['operador'])) {
							// 	echo '
							// </td>
							// <td>
							// 	<a href="abm/editarRolyEstado.php?nik='.$row['idUsuarios'].'" title="Editar datos" class="btn btn-primary btn-sm"><span class="fas fa-edit" aria-hidden="true"></span></a>
							// </td>
							// </tr>
							// ';
							// }
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