<?php
require_once '../config/Conexion.php'; 
session_start();
// Permisos
if(!isset($_SESSION['admin'])){
	if(!isset($_SESSION['operador'])){
		header("Location: ../index.php");}} 

?>
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
					<select name="filter" class="form-control" onchange="form.submit()" id="filtro">
						<option value="0">Filtros de datos de usuarios</option>
						<?php $filter = (isset($_GET['filter']) ? $_GET['filter'] : NULL);  ?>
						<option value="Activo" <?php if($filter == 'Activo'){ echo 'selected'; } ?>>Activo</option>
						<option value="Inactivo" <?php if($filter == 'Inactivo'){ echo 'selected'; } ?>>Inactivo</option>
                        <option value="Pendiente" <?php if($filter == 'Pendiente'){ echo 'selected'; } ?>>Pendiente</option>
					</select><button onclick="document.getElementById('filtro').selectedIndex = 0;" role="button" aria-pressed="true" class="btn btn-secondary btn-sm">Ver Todos</button>
				</div>
			</form>
			<br />
			<div class="table-responsive">
			<table class="table table-striped table-hover">
				<tr>
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
					$sql = mysqli_query($conexion, "SELECT * FROM usuarios JOIN roles ON usuarios.idRol=roles.idRoles WHERE estado='$filter' ORDER BY idUsuarios ASC");
				}else{
					$sql = mysqli_query($conexion, "SELECT * FROM usuarios JOIN roles ON usuarios.idRol=roles.idRoles ORDER BY idUsuarios ASC");
				}
				if(mysqli_num_rows($sql) == 0){
					echo '<tr><td colspan="8">No hay datos.</td></tr>';
				}else{
					while($row = mysqli_fetch_assoc($sql)){
						echo '
						<tr>
							<td>'.$row['idUsuarios'].'</td>
                            <td><a href="perfil.php?nik='.$row['idUsuarios'].'"><span class="fas fa-user" aria-hidden="true"></span> '.$row['apellido'].'</a></td>
                            <td>'.$row['nombre'].'</td>
                            <td>'.$row['cuil'].'</td>
                            <td>'.$row['email'].'</td>
                            <td>'.$row['dni'].'</td>
							<td>'.$row['telefono'].'</td>
                            <td>'.$row['descripcion'].'</td>   
							<td>';
							if($row['estado'] == 'Activo'){
								echo '<span class="badge badge-success">Activo</span>';
							}
                            else if ($row['estado'] == 'Inactivo' ){
								echo '<span class="badge badge-danger">Inactivo</span>';
							}
                            else if ($row['estado'] == 'Pendiente' ){
								echo '<span class="badge badge-warning">Pendiente</span>';
							}if(isset($_SESSION['admin'])){
								echo '
							</td>
							<td>
								<a href="abm/editarUsuario.php?nik='.$row['idUsuarios'].'" title="Editar datos" class="btn btn-primary btn-sm"><span class="fas fa-edit" aria-hidden="true"></span></a>
								<a href="listaUsuario.php?aksi=delete&nik='.$row['idUsuarios'].'" title="Eliminar" onclick="return confirm(\'Esta seguro de borrar los datos de: '.$row['apellido'].' '.$row['nombre'].'?\')" class="btn btn-danger btn-sm"><span class="fas fa-trash" aria-hidden="true"></span></a>
							</td>
						</tr>
						';
							}if(isset($_SESSION['operador'])){
								echo '
							</td>
							<td>
								<a href="abm/editarRolyEstado.php?nik='.$row['idUsuarios'].'" title="Editar datos" class="btn btn-primary btn-sm"><span class="fas fa-edit" aria-hidden="true"></span></a>
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