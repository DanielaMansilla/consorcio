<?php
require_once '../../config/Conexion.php'; 
require_once '../../clases/Usuario.php';
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: ../index.php");} ?>

<!DOCTYPE html>
<html lang="es">
<?php include('../template/head.php'); ?>

    <body>
    <?php 
        include('../template/nav.php');  
        include('../template/header.php'); ?>

        <title>Consorcios del Valle - Editar Usuario</title>

        <div class="container">
		<div class="content">
			<h2>Datos del usuario &raquo; Editar Datos</h2>
			<hr />
			
			<?php
			if (isset($_GET["nik"])) {
				// escaping, additionally removing everything that could be (html/javascript-) code
				$nik = mysqli_real_escape_string($conexion,(strip_tags($_GET["nik"],ENT_QUOTES)));
				
				$sql = mysqli_query($conexion, "SELECT * FROM usuarios JOIN roles ON usuarios.idRol=roles.idRoles  WHERE idUsuarios='$nik'");
				if (mysqli_num_rows($sql) == 0) {
					echo '<div class="alert alert-danger alert-dismissable">Error: El usuario indicado no existe.</div>';
				} else {
					$row = mysqli_fetch_assoc($sql);

					if (isset($_POST['save'])) {
						$apellido		 = mysqli_real_escape_string($conexion,(strip_tags($_POST["apellido"],ENT_QUOTES)));//Escanpando caracteres 
						$nombre		     = mysqli_real_escape_string($conexion,(strip_tags($_POST["nombre"],ENT_QUOTES)));//Escanpando caracteres 
						$cuil		     = mysqli_real_escape_string($conexion,(strip_tags($_POST["cuil"],ENT_QUOTES)));//Escanpando caracteres     
						$email		     = mysqli_real_escape_string($conexion,(strip_tags($_POST["email"],ENT_QUOTES)));//Escanpando caracteres     
						$dni		     = mysqli_real_escape_string($conexion,(strip_tags($_POST["dni"],ENT_QUOTES)));//Escanpando caracteres 
						$telefono		 = mysqli_real_escape_string($conexion,(strip_tags($_POST["telefono"],ENT_QUOTES)));//Escanpando caracteres 
						$idRol         	 = mysqli_real_escape_string($conexion,(strip_tags($_POST["idRol"],ENT_QUOTES)));//Escanpando caracteres 
						$estado			 = mysqli_real_escape_string($conexion,(strip_tags($_POST["estado"],ENT_QUOTES)));//Escanpando caracteres 
						
						$error = array();
						
						//Validaciones
						if (!(ctype_alpha($nombre) && strlen($nombre) >= 3 && strlen($nombre) <= 20)) {
							$error[] = "Nombre debe tener al menos 3 caracteres, solo alfabeticos";
						}        
						
						if (!(ctype_alpha($apellido) && strlen($apellido) >= 3 && strlen($apellido) <= 20)) {
							$error[] = "Apellido debe tener al menos 3 caracteres, solo alfabeticos";
						}
						
						if (!(ctype_digit($cuil) && strlen($cuil) == 11)) {
							$error[] = "Cuil debe tener 11 digitos sin guiones.";
						}
						
						$usuario = new Usuario();
	
						$cuilValido = $usuario::validarCuil($cuil);
						if (!$cuilValido) {
							$error[] = "Cuil invalido.";
						}
	
						$cek3 = mysqli_query($conexion, "SELECT * FROM usuarios WHERE cuil='$cuil' and idUsuarios<>'$nik'");
						if (!(mysqli_num_rows($cek3) == 0)) {
							$error[] = "Cuil ya utilizado en otro usuario.";
						}
						
						if (!(ctype_digit($dni) && strlen($dni) == 8)) {
							$error[] = "Dni debe tener 8 digitos sin guiones.";
						}
	
						$cek4 = mysqli_query($conexion, "SELECT * FROM usuarios WHERE dni='$dni' and idUsuarios<>'$nik'");
						if (!(mysqli_num_rows($cek4) == 0)) {
							$error[] = "Dni está utilizado en otro usuario.";
						}
		
						if (!(ctype_digit($telefono) && strlen($telefono) >= 8 && strlen($telefono) <= 10)) {
							$error[] = "Teléfono debe tener entre 8 y 10 digitos sin guiones.";
						}
		
						if (!(filter_var($email, FILTER_VALIDATE_EMAIL))) {
							$error[] = "Email incorrecto";
						}
						$cek5 = mysqli_query($conexion, "SELECT * FROM usuarios WHERE email='$email' and idUsuarios<>'$nik'");
						if (!(mysqli_num_rows($cek5) == 0)) {
							$error[] = "Email está utilizado en otro usuario.";
						}
						
						if (sizeof($error) == 0) {
							$update = mysqli_query($conexion, "UPDATE usuarios SET apellido='$apellido', nombre='$nombre', cuil='$cuil', email='$email', dni='$dni', telefono='$telefono', idRol='$idRol', estado='$estado' WHERE idUsuarios='$nik'") or die(mysqli_error($conexion));
							if ($update) {
								//header("Location: editarUsuario.php?nik=".$nik."&pesan=sukses");
								echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Bien hecho! Los datos han sido modificados con éxito.</div>';
							} else {
								echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pudo guardar los datos.</div>';
							}
						} else {
							echo "Ocurrio un error en los siguientes campos: ";
							foreach ($error as $er) {
								echo "</br><strong>$er</strong>";
							}
						}
					}
	
					if(isset($_GET['pesan']) == 'sukses'){
						echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Los datos han sido guardados con éxito.</div>';
					}
					?>
	
					<form class="form-horizontal" action="" method="post">
						<div class="form-group">
							<label class="col-sm-3 control-label">Apellido</label>
							<div class="col-sm-4">
								<input type="text" name="apellido" value="<?php echo $row ['apellido']; ?>" class="form-control" maxlength="50" placeholder="Apellido" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Nombre</label>
							<div class="col-sm-4">
								<input type="text" name="nombre" value="<?php echo $row ['nombre']; ?>" class="form-control" maxlength="50" placeholder="Nombre" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">CUIL</label>
							<div class="col-sm-4">
								<input type="text" name="cuil" value="<?php echo $row ['cuil']; ?>" class="form-control" maxlength="11" placeholder="Cuil" required><small id="emailHelp" class="form-text text-muted">Ingresar solo numeros, sin guiones, barras ni puntos.</small>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Correo Electrónico</label>
							<div class="col-sm-4">
								<input type="text" name="email" value="<?php echo $row ['email']; ?>" class="form-control" maxlength="50" placeholder="E-mail" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">DNI</label>
							<div class="col-sm-4">
								<input type="text" name="dni" value="<?php echo $row ['dni']; ?>" class="form-control" maxlength="8" placeholder="Dni" required><small id="emailHelp" class="form-text text-muted">Ingresar solo números, sin guiones, barras ni puntos.</small>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Teléfono</label>
							<div class="col-sm-3">
								<input type="text" name="telefono" value="<?php echo $row ['telefono']; ?>" class="form-control" maxlength="11" placeholder="Teléfono" required>
							</div>
						</div>
						<div class="form-group">
						<label class="col-sm-3 control-label">Rol:</label>
							<div class="col-sm-3">
							<select name="idRol" class="form-control">
									<?php  $datos = mysqli_query($conexion, "SELECT * FROM roles"); //muestra todos los roles
									while ($row2 = mysqli_fetch_assoc($datos)) { ?>
									<!-- Se selecciona automáticamente el rol actual del usuario -->
									<option value="<?php echo $row2['idRoles']; ?>" <?php if ($row['idRoles'] == $row2['idRoles']) { echo 'selected';}?>>
										<?php echo $row2['descripcion']; ?>
										</option>
									<?php } ?>
								</select>
							</div>
							
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Estado</label>
							<div class="col-sm-3">
								<select name="estado" class="form-control">
									<option disabled="disabled" hidden="hidden" value="">- Selecciona estado -</option>
									<option value="Activo" <?php if ($row ['estado']=='Activo'){echo "selected";} ?>>Activo</option>
									<option value="Inactivo" <?php if ($row ['estado']=='Inactivo'){echo "selected";} ?>>Inactivo</option>
									<option value="Pendiente" <?php if ($row ['estado']=='Pendiente'){echo "selected";} ?>>Pendiente</option>
								</select> 
							</div>
						
						</div>
					
						<div class="form-group">
							<label class="col-sm-3 control-label">&nbsp;</label>
							<div class="col-sm-6">
								<input type="submit" name="save" class="btn btn-sm btn-primary" value="Guardar datos">
								<a href="../listaUsuario.php" class="btn btn-sm btn-danger">Cancelar</a>
							</div>
						</div>
					</form>
					<?php
				}
			} else {
				echo '<div class="alert alert-danger alert-dismissable">Error: No se ha especificado el usuario a editar.</div>';
			}

			?>
		</div>
	</div>

  	<div class="corte">
    </div>
    <?php include('../template/footer.php'); ?>
    </body>
</html>