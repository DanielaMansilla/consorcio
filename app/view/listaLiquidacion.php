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

		<title>Consorcios del Valle - Lista de Liquidaciones</title>

        <div class="container">
		<div class="content">
			<h2>Lista de Liquidaciones</h2>
			<hr />

			<br/>
			<div class="table-responsive">
			<table class="table table-striped table-hover">
				<tr>
					<th>Id</th>
					<th>Periodo</th>
					<th>Fecha</th>
                    <th>Acciones</th>
				</tr>
				<?php

				$sql = mysqli_query($conexion, "SELECT * FROM liquidacion");

				if (mysqli_num_rows($sql) == 0) {
					echo '<tr><td colspan="8">No hay liquidaciones a listar.</td></tr>';
				} else {
					while ($row = mysqli_fetch_assoc($sql)) {
						echo '
						<tr>
							<td>'.$row['idLiquidacion'].'</td>
							<td>'.$row['periodo'].'</td>
							<td>'.$row['fecha'].'</td>
							<td>';
                            
                            

                            //<a href="listaLiquidacion.php?nik='.$row['idLiquidacion'].'" title="Visualizar datos" class="btn btn-primary btn-sm"><span class="fas fa-search" aria-hidden="true"></span></a>

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