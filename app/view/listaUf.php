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

		<title>Consorcios del Valle - Lista de Unidades Funcionales</title>

        <div class="container">
		<div class="content">
			<h2>Lista de Unidades Funcionales.</h2>
            <h3>Asignar Unidades Funcionales a Propietarios.</h3>
			<hr />

			<?php
			if(isset($_GET['aksi']) == 'delete'){
				// escaping, additionally removing everything that could be (html/javascript-) code
				$nik = mysqli_real_escape_string($conexion,(strip_tags($_GET["nik"],ENT_QUOTES)));
				$cek = mysqli_query($conexion, "SELECT * FROM propiedad WHERE idPropiedad='$nik'");
				if(mysqli_num_rows($cek) == 0){
					echo '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> No se encotraron datos.</div>';
				}else{
					$delete = mysqli_query($conexion, "DELETE FROM propiedad WHERE idPropiedad='$nik'");
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
					<th>Id Propiedad</th>
					<th>Id Usuario</th>
                    <th>Porcentaje</th>
                    <th>Piso</th>
                    <th>Departamento</th>
                    <th>Unidad Funcional</th>
					<th>Consorcio</th>
                    <th>Acciones</th>
				</tr>
				<?php
					$sql = mysqli_query($conexion, "SELECT * FROM propiedad JOIN consorcio ON propiedad.idConsorcio=consorcio.idConsorcio ORDER BY idPropiedad ASC");
				if(mysqli_num_rows($sql) == 0){
					echo '<tr><td colspan="8">No hay datos.</td></tr>';
				}else{
					while($row = mysqli_fetch_assoc($sql)){
						echo '
						<tr>
							<td>'.$row['idPropiedad'].'</td>
                            <td><a href="perfil.php?nik='.$row['idUsuarios'].'"><span class="fas fa-user" aria-hidden="true"></span> '.$row['idUsuarios'].'</a></td>
                            <td>'.$row['porcentajeParticipacion'].'</td>
                            <td>'.$row['piso'].'</td>
                            <td>'.$row['departamento'].'</td>
                            <td>'.$row['unidadFuncionalLote'].'</td>
							<td>'.$row['nombre'].'</td>   
							<td>

								<a href="abm/editarUf.php?nik='.$row['idPropiedad'].'" title="Editar Usuario Asignado" class="btn btn-primary btn-sm"><span class="fas fa-edit" aria-hidden="true"></span></a>
								<a href="listaUf.php?aksi=delete&nik='.$row['idPropiedad'].'" title="Eliminar" onclick="return confirm(\'Esta seguro de borrar los datos: N°UnidadFuncional: '.$row['unidadFuncionalLote'].'?\')" class="btn btn-danger btn-sm"><span class="fas fa-trash" aria-hidden="true"></span></a>
							</td>
						</tr>
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