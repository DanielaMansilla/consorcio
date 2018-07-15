<?php
require_once '../config/Conexion.php';
session_start();
// poner permiso tambien para operador
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

        <title>Consorcios del Valle - Datos de usuario</title>

        <div class="container">
		<div class="content">
			<h2>Datos del usuario &raquo; Perfil</h2>
			<hr />
			
			<?php
			// escaping, additionally removing everything that could be (html/javascript-) code
			$nik = mysqli_real_escape_string($conexion,(strip_tags($_GET["nik"],ENT_QUOTES)));
			
			$sql = mysqli_query($conexion, "SELECT * FROM usuarios JOIN roles ON usuarios.idRol=roles.idRoles WHERE idUsuarios='$nik'");
			if(mysqli_num_rows($sql) == 0){
				header("Location: listaUsuario.php");
			}else{
				$row = mysqli_fetch_assoc($sql);
			}
			
			if(isset($_GET['aksi']) == 'delete'){
				$delete = mysqli_query($conexion, "DELETE FROM usuarios JOIN roles ON usuarios.idRol=roles.idRoles WHERE idUsuarios='$nik'");
				if($delete){
					echo '<div class="alert alert-danger alert-dismissable">><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Data berhasil dihapus.</div>';
				}else{
					echo '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Data gagal dihapus.</div>';
				}
			}
			?>
			
			<table class="table table-striped table-condensed">
				<tr>
					<th width="20%">Id</th>
					<td><?php echo $row['idUsuarios']; ?></td>
				</tr>
				<tr>
					<th>Apellido del usuario</th>
					<td><?php echo $row['apellido']; ?></td>
				</tr>
                <tr>
					<th>Nombre del usuario</th>
					<td><?php echo $row['nombre']; ?></td>
				</tr>
                <tr>
					<th>Numero de Cuil</th>
					<td><?php echo $row['cuil']; ?></td>
				</tr>
                <tr>
					<th>Correo Electronico</th>
					<td><?php echo $row['email']; ?></td>
				</tr>
                <tr>
					<th>Numero de Dni</th>
					<td><?php echo $row['dni']; ?></td>
				</tr>
				<tr>
					<th>Teléfono</th>
					<td><?php echo $row['telefono']; ?></td>
				</tr>
				<tr>
					<th>Tipo de Rol</th>
					<td><?php echo $row['descripcion']; ?></td>
				</tr>
				<tr>
					<th>Estado</th>
					<td>
						<?php 
							if ($row['estado']== "Activo") {
								echo "Activo";
							} else if ($row['estado']== "Inactivo"){
								echo "Inactivo";
							} else if ($row['estado']== "Pendiente"){
								echo "Pendiente";
							}
						?>
					</td>
				</tr>
			</table>
			
			<a href="listaUsuario.php" class="btn btn-sm btn-info"><span class="fas fa-arrow-left" aria-hidden="true"></span> Regresar</a>

			<?php
				if(isset($_SESSION['admin'])){	
			?>
				<a href="abm/editarUsuario.php?nik=<?php echo $row['idUsuarios']; ?>" class="btn btn-sm btn-success"><span class="fas fa-edit" aria-hidden="true"></span> Editar datos</a>
				<a href="perfil.php?aksi=delete&nik=<?php echo $row['idUsuarios']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Esta seguro de borrar los datos <?php echo $row['apellido']; ?>')"><span class="fas fa-trash" aria-hidden="true"></span> Eliminar</a>
			<?php }?>

			<?php
			if(isset($_SESSION['operador'])){	
			?>
				
			<?php }?>
		</div>
	</div>

    <div class="corte">
    </div>
    <?php include('template/footer.php'); ?>
    </body>

</html>