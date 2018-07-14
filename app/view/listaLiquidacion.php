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
					<th>Año</th>
					<th>Mes</th>
					<th>Dia</th>
					<th>Fecha Completa</th>
					<th>Informe Mensual</th>
                  
				</tr>
				<?php
				//TODO: Por cada liquidacion mostrar lista de gastos. (no tan importante)
				
				//$sql = mysqli_query($conexion, "SELECT * FROM liquidacion JOIN liquidaciongasto on liquidacion.idLiquidacion=liquidaciongasto.idLiquidacion
				//JOIN gasto on liquidaciongasto.idGasto=gasto.idGasto ORDER BY gasto.fecha DESC");

				$sql = mysqli_query($conexion, "SELECT * FROM liquidacion ORDER BY idLiquidacion DESC");

				if (mysqli_num_rows($sql) == 0) {
					echo '<tr><td colspan="8">No hay liquidaciones a listar.</td></tr>';
				} else {
					while ($row = mysqli_fetch_assoc($sql)) {
						echo '
						<tr>
							<td>'.$row['idLiquidacion'].'</td>
							<td>'.date("Y", strtotime($row['periodo'])).'</td>
							<td>'.date("F", strtotime($row['periodo'])).'</td>
							<td>'.date("l", strtotime($row['periodo'])).'</td>
							<td>'.$row['fecha'].'</td>
							<td>
							 	<a href="informeMensual.php?year='.date("Y",strtotime($row['fecha'])).'&month='.date("m",strtotime($row['fecha'])).'" title="Ver Liquidación" class="btn btn-primary btn-sm"><span class="fas fa-list-ul" aria-hidden="true"></span></a>
							</td>
							 ';
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