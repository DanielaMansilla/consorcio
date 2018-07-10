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

		<title>Consorcios del Valle - Lista de Consorcios</title>

        <div class="container">
		<div class="content">
			<h2>Lista de Consorcios</h2>
			<hr />

			<?php
			if(isset($_GET['aksi']) == 'delete'){
				$nik = mysqli_real_escape_string($conexion,(strip_tags($_GET["nik"],ENT_QUOTES)));
				$cek = mysqli_query($conexion, "SELECT * FROM consorcio WHERE idConsorcio='$nik'");
				if(mysqli_num_rows($cek) == 0){
					echo '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> No se encotraron datos.</div>';
				}else{
					$delete = mysqli_query($conexion, "DELETE FROM consorcio WHERE idConsorcio='$nik'");
					if($delete){
						echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Datos eliminado correctamente.</div>';
					}else{
						echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Error, no se pudo eliminar los datos.</div>';
					}
				}
			}
			?>

			<br />
			<div class="table-responsive">
			<table class="table table-striped table-hover">
				<tr>
					<th>Id</th>
                    <th>Nombre</th>
                    <th>CUIT</th>
                    <th>Código Postal</th>
                    <th>Teléfono</th>
                    <th>Correo Electrónico</th>
                    <th>Dirección</th>
                    <th>Acciones</th>
				</tr>
				<?php
					$sql = mysqli_query($conexion, "SELECT * FROM consorcio ORDER BY idConsorcio ASC");
				if(mysqli_num_rows($sql) == 0){
					echo '<tr><td colspan="8">No hay datos.</td></tr>';
				}else{
					//$no = 1;
					while($row = mysqli_fetch_assoc($sql)){
						echo '
						<tr>
                            <td>'.$row['idConsorcio'].'</td>
                            <td>'.$row['nombre'].'</td>
                            <td>'.$row['cuit'].'</td>
                            <td>'.$row['codigoPostal'].'</td>
                            <td>'.$row['telefono'].'</td>
                            <td>'.$row['correo'].'</td>
                            <td>'.$row['direccion'].'</td>
                            ';
                            
                            if(isset($_SESSION['admin'])){
								echo '
							</td>
							<td>
								<a href="abm/editarConsorcio.php?nik='.$row['idConsorcio'].'" title="Editar datos" class="btn btn-primary btn-sm"><span class="fas fa-edit" aria-hidden="true"></span></a>
								<a href="listaConsorcio.php?aksi=delete&nik='.$row['idConsorcio'].'" title="Eliminar" onclick="return confirm(\'Esta seguro de borrar el consorcio: '.$row['nombre'].' con CUIT '.$row['cuit'].'?\')" class="btn btn-danger btn-sm"><span class="fas fa-trash" aria-hidden="true"></span></a>
								<a href="mapaConsorcio.php?id='.$row['idConsorcio'].'" title="Ver Ubicación" class="btn btn-success btn-sm"><span class="fas fa-map-marker-alt" aria-hidden="true"></span></a>
							</td>
						</tr>
						';
							}if(isset($_SESSION['operador'])){
								echo '
							</td>
							<td>
								<a href="abm/editarConsorcio.php?nik='.$row['idConsorcio'].'" title="Editar datos" class="btn btn-primary btn-sm"><span class="fas fa-edit" aria-hidden="true"></span></a>
								<a href="mapaConsorcio.php?id='.$row['idConsorcio'].'" title="Ver Ubicación" class="btn btn-success btn-sm"><span class="fas fa-map-marker-alt" aria-hidden="true"></span></a>
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