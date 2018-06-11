<?php
require_once '../config/Conexion.php'; 
session_start();
if(isset($_SESSION['username'])){} ?>

<!DOCTYPE html>
<html lang="es">
<?php include('template/head.php'); ?>

    <body>
    <?php 
        include('template/nav.php');  
        include('template/header.php'); ?>

		<title>Consorcios del Valle - Lista de usuarios</title>

        <div class="container">
		<div class="content">
			<h2>Lista de usuarios</h2>
			<hr />

			<?php
			if(isset($_GET['aksi']) == 'delete'){
				// escaping, additionally removing everything that could be (html/javascript-) code
				$nik = mysqli_real_escape_string($conexion,(strip_tags($_GET["nik"],ENT_QUOTES)));
				$cek = mysqli_query($conexion, "SELECT * FROM usuarios WHERE idUsuarios='$nik'");
				if(mysqli_num_rows($cek) == 0){
					echo '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> No se encotraron datos.</div>';
				}else{
					$delete = mysqli_query($conexion, "DELETE FROM usuarios WHERE idUsuarios='$nik'");
					if($delete){
						echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Datos eliminado correctamente.</div>';
					}else{
						echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Error, no se pudo eliminar los datos.</div>';
					}
				}
			}
			?>

			<form class="form-inline" method="get">
				<div class="form-group">
					<select name="filter" class="form-control" onchange="form.submit()">
						<option value="0">Filtros de datos de usuarios</option>
						<?php $filter = (isset($_GET['filter']) ? strtolower($_GET['filter']) : NULL);  ?>
						<option value="Activo" <?php if($filter == 'Activo'){ echo 'selected'; } ?>>Activo</option>
						<option value="Inactivo" <?php if($filter == 'Inactivo'){ echo 'selected'; } ?>>Inactivo</option>
                        <option value="Pendiente" <?php if($filter == 'Pendiente'){ echo 'selected'; } ?>>Pendiente</option>
					</select>
				</div>
			</form>
			<br />
			<div class="table-responsive">
			<table class="table table-striped table-hover">
				<tr>
                    <!--<th>No</th> -->
					<th>Id</th>
					<th>Apellido</th>
                    <th>Nombre</th>
                    <th>Cuil</th>
                    <th>E-mail</th>
                    <th>Dni</th>
					<th>Teléfono</th>
					<th>Rol</th>
					<th>Estado</th>
                    <th>Acciones</th>
				</tr>
				<?php
				if($filter){
					$sql = mysqli_query($conexion, "SELECT * FROM usuarios WHERE estado='$filter' ORDER BY idUsuarios ASC");
				}else{
					$sql = mysqli_query($conexion, "SELECT * FROM usuarios ORDER BY idUsuarios ASC");
				}
				if(mysqli_num_rows($sql) == 0){
					echo '<tr><td colspan="8">No hay datos.</td></tr>';
				}else{
					//$no = 1;
					while($row = mysqli_fetch_assoc($sql)){
                        /* <td>'.$no.'</td> encima del $row */
                        /* Falta linkear unir las tablas idRol para que muestre nombre del rol */
						echo '
						<tr>
							<td>'.$row['idUsuarios'].'</td>
                            <td><a href="perfil.php?nik='.$row['idUsuarios'].'"><span class="fas fa-user" aria-hidden="true"></span> '.$row['apellido'].'</a></td>
                            <td>'.$row['nombre'].'</td>
                            <td>'.$row['cuil'].'</td>
                            <td>'.$row['email'].'</td>
                            <td>'.$row['dni'].'</td>
							<td>'.$row['telefono'].'</td>
                            <td>'.$row['idRol'].'</td>   
							<td>';
							if($row['estado'] == 'Activo'){
								echo '<span class="badge badge-success">Activo</span>';
							}
                            else if ($row['estado'] == 'Inactivo' ){
								echo '<span class="badge badge-danger">Inactivo</span>';
							}
                            else if ($row['estado'] == 'Pendiente' ){
								echo '<span class="badge badge-warning">Pendiente</span>';
							}
						echo '
							</td>
							<td>

								<a href="abm/editarUsuario.php?nik='.$row['idUsuarios'].'" title="Editar datos" class="btn btn-primary btn-sm"><span class="fas fa-edit" aria-hidden="true"></span></a>
								<a href="listaUsuario.php?aksi=delete&nik='.$row['idUsuarios'].'" title="Eliminar" onclick="return confirm(\'Esta seguro de borrar los datos '.$row['apellido'].' '.$row['nombre'].'?\')" class="btn btn-danger btn-sm"><span class="fas fa-trash" aria-hidden="true"></span></a>
							</td>
						</tr>
						';
						//$no++;
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