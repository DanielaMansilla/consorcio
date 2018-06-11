<?php
require_once '../../config/Conexion.php';
session_start();
if(isset($_SESSION['username'])){} ?>

<!DOCTYPE html>
<html lang="es">
<?php include('../template/head.php'); ?>

    <body>
    <?php 
        include('../template/nav.php');  
        include('../template/header.php'); ?>

        <title>Consorcios del Valle - Agregar Usuario</title>

        <div class="container">
		<div class="content">
			<h2>Datos del usuario &raquo; Agregar datos</h2>
			<hr />

			<?php
			if(isset($_POST['add'])){
                $apellido		     = mysqli_real_escape_string($conexion,(strip_tags($_POST["apellido"],ENT_QUOTES)));//Escanpando caracteres 
                $nombre		     = mysqli_real_escape_string($conexion,(strip_tags($_POST["nombre"],ENT_QUOTES)));//Escanpando caracteres 
                $cuil		     = mysqli_real_escape_string($conexion,(strip_tags($_POST["cuil"],ENT_QUOTES)));//Escanpando caracteres     
                $email		     = mysqli_real_escape_string($conexion,(strip_tags($_POST["email"],ENT_QUOTES)));//Escanpando caracteres     
                $dni		     = mysqli_real_escape_string($conexion,(strip_tags($_POST["dni"],ENT_QUOTES)));//Escanpando caracteres 
				$telefono		 = mysqli_real_escape_string($conexion,(strip_tags($_POST["telefono"],ENT_QUOTES)));//Escanpando caracteres 
				$idRol          = mysqli_real_escape_string($conexion,(strip_tags($_POST["idRol"],ENT_QUOTES)));//Escanpando caracteres 
				$estado			 = mysqli_real_escape_string($conexion,(strip_tags($_POST["estado"],ENT_QUOTES)));//Escanpando caracteres 
		
				$cek = mysqli_query($conexion, "SELECT * FROM usuarios WHERE idUsuarios='$idUsuarios'");
				if(mysqli_num_rows($cek) == 0){
						$insert = mysqli_query($conexion, "INSERT INTO usuarios(apellido, nombre, cuil, email, dni, telefono, idRol, estado)
															VALUES('$apellido', '$nombre', '$cuil', '$email', '$dni', '$telefono', '$idRol', '$estado')") or die(mysqli_error());
						if($insert){
							echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Bien hecho! Los datos han sido guardados con éxito.</div>';
						}else{
							echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. No se pudo guardar los datos !</div>';
						}
					 
				}else{
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. código exite!</div>';
				}
			}
			?>

			<form class="form-horizontal" action="" method="post">
                <div class="form-group">
					<label class="col-sm-3 control-label">Apellido</label>
					<div class="col-sm-4">
						<input type="text" name="apellido" class="form-control" placeholder="Apellido" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Nombre</label>
					<div class="col-sm-4">
						<input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
					</div>
				</div>
                <div class="form-group">
					<label class="col-sm-3 control-label">Cuil</label>
					<div class="col-sm-4">
						<input type="number" name="cuil" class="form-control" placeholder="Cuil" required>
					</div>
				</div>
                <div class="form-group">
					<label class="col-sm-3 control-label">Correo Electrónico</label>
					<div class="col-sm-4">
						<input type="text" name="email" class="form-control" placeholder="E-mail" required>
					</div>
				</div>
                <div class="form-group">
					<label class="col-sm-3 control-label">Dni</label>
					<div class="col-sm-4">
						<input type="text" name="dni" class="form-control" placeholder="Dni" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Teléfono</label>
					<div class="col-sm-3">
						<input type="text" name="telefono" class="form-control" placeholder="Teléfono" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">idRol</label>
					<div class="col-sm-3">
						<input type="text" name="idRol" class="form-control" placeholder="idRol" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Estado</label>
					<div class="col-sm-3">
						<select name="estado" class="form-control">
							<option value=""> ----- </option>
                            <option value="Activo">Activo</option>
							<option value="Inactivo">Inactivo</option>
							<option value="Pendiente">Pendiente</option>
						</select>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">&nbsp;</label>
					<div class="col-sm-6">
						<input type="submit" name="add" class="btn btn-sm btn-primary" value="Guardar datos">
						<a href="listaUsuario.php" class="btn btn-sm btn-danger">Cancelar</a>
					</div>
				</div>
			</form>
		</div>
	</div>

	<div class="corte">
    </div>
    <?php include('../template/footer.php'); ?>
    </body>

</html>