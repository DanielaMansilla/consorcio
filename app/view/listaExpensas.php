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

		<title>Consorcios del Valle - Lista de Expensas</title>

        <div class="container">
		<div class="content">
			<h2>Lista de Expensas</h2>
			<hr />

			<br/>
			<div class="table-responsive">
			<table class="table table-striped table-hover">
				<tr>
					<th>Id</th>
					<th>Fecha</th>
					<th>Propiedad</th>
                    <th>Importe</th>
                    <th>Estado</th>
                    <th>Acciones</th>
				</tr>
				<?php

				$idUsuario = $_SESSION['idUsuario'];
				$sql = mysqli_query($conexion, 
				"SELECT * 
				FROM expensa 
				JOIN propiedad ON expensa.idPropiedad = propiedad.idPropiedad
				WHERE propiedad.idPropiedad='$idUsuario'") or die(mysqli_error($conexion));

				if (isset($_SESSION['admin']) || !isset($_SESSION['operador'])) {
					$sql = mysqli_query($conexion, 
					"SELECT * 
					FROM expensa 
					JOIN propiedad ON expensa.idPropiedad = propiedad.idPropiedad
					ORDER BY expensa.idExpensa DESC") or die(mysqli_error($conexion));
				}

				if (mysqli_num_rows($sql) == 0) {
					echo '<tr><td colspan="8">No hay reclamos a listar.</td></tr>';
				} else {
					while ($row = mysqli_fetch_assoc($sql)) {
						echo '
						<tr>
							<td>'.$row['idExpensa'].'</td>
							<td>'.$row['fecha'].'</td>
							<td>Piso: '.$row['piso'].' - Dpto: '.$row['departamento'].'</td>
							<td>$ '.$row['importe'].'</td>
							<td>';
							
							$estado = $row['estado'];
							switch ($estado) {
								case "Pago":
									$badgeColor = "success";
									break;
								case "Impago":
									$badgeColor = "info";
									break;
							}
							echo '<span class="badge badge-'.$badgeColor.'">'.$estado.'</span></td>';
							echo '<td>';
							if ($estado != "Pago") {
								echo '<a href="#" title="Pagar" class="btn btn-primary btn-sm"><span class="fas fa-shopping-cart" aria-hidden="true"></span></a>';
							}
							echo '</td>';
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