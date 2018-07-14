<?php
require_once '../config/Conexion.php'; 
session_start();
// Permisos
if(!isset($_SESSION['admin'])){
	if(!isset($_SESSION['operador'])){
		header("Location: ../index.php");}} ?>

<!DOCTYPE html>
<html lang="es">
<?php include('template/head.php'); ?>

    <body>
    <?php 
        include('template/nav.php');  
        include('template/header.php'); ?>
    
    <title>Consorcios del Valle - Estadística</title>

    <div class="container">
    <div class="content">
    <h2>Estadística de consorcios</h2>
    <hr />
			<br />
			<div class="table-responsive">
			<table class="table table-bordered table-hover">
                <tr class="table-active" style="text-align:center;">
                    <th rowspan="2">ID</th>
                    <th rowspan="2"><a href="listaConsorcio.php">Consorcios</a></th>
                    <th rowspan="2"><a href="listaUf.php">N° Unidades Funcionales</a></th>
                    <th colspan="2"><a href="listaExpensas.php">Cobranzas</a></th>
                    <th colspan="2"><a href="listaReclamos.php">Reclamos</a></th>
                </tr>

				<tr style="text-align:center;">
                    <td class="table-active">Realizadas</td>
                    <td class="table-active">Faltantes</td>
                    <td class="table-active">Abiertos</td>
					<td class="table-active">Cerrados</td>
				</tr>

				<?php
                    //Expensa
                    $sql5 = mysqli_query($conexion, "SELECT COUNT(*) AS Cfaltantes FROM expensa WHERE estado like 'Impago'");
                    $sql4 = mysqli_query($conexion, "SELECT COUNT(*) AS Crealizadas FROM expensa WHERE estado like 'Pago'");
                    //Reclamos
                    $sql3 = mysqli_query($conexion, "SELECT COUNT(*) AS Rcerrados FROM reclamo WHERE estado like 'Resuelto'");
                    $sql2 = mysqli_query($conexion, "SELECT COUNT(*) AS Rabiertos FROM reclamo WHERE estado like 'Activo'");
                    //Consorcio + Propiedad
					$sql = mysqli_query($conexion, "SELECT C.idConsorcio,C.nombre,COUNT(*) AS Cantidad FROM consorcio AS C JOIN propiedad AS P ON P.idConsorcio = C.idConsorcio GROUP BY C.idConsorcio ORDER BY idConsorcio ASC");
                

                if(mysqli_num_rows($sql) == 0 || mysqli_num_rows($sql2) == 0 || mysqli_num_rows($sql3) == 0 || mysqli_num_rows($sql4) == 0 || mysqli_num_rows($sql5) == 0){
					echo '<tr><td colspan="8">No hay consorcios para mostrar.</td></tr>';
				}else{
					while(($row = mysqli_fetch_assoc($sql) )&& ($row2 = mysqli_fetch_assoc($sql2)) && ($row3 = mysqli_fetch_assoc($sql3)) && ($row4 = mysqli_fetch_assoc($sql4)) && ($row5 = mysqli_fetch_assoc($sql5))){
                        echo '
                        <tr style="text-align:center;">
                            <td>'.$row['idConsorcio'].'</td>
                            <td>'.$row['nombre'].'</td>
                            <td>'.$row['Cantidad'].'</td>
                            <td>'.$row4['Crealizadas'].'</td>
                            <td>'.$row5['Cfaltantes'].'</td>
                            <td>'.$row2['Rabiertos'].'</td>
							<td>'.$row3['Rcerrados'].'</td>  
						</tr>
						';
					}
				}
				?>
			</table>
			</div>
		</div>
	</div>         
    <div class="corte">
    </div>
    <?php include('template/footer.php'); ?>
    </body>
</html>