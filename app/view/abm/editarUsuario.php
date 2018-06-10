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

        <title>Consorcios del Valle - Editar Usuario</title>

        <div class="container">
		<div class="content">
			<h2>Datos del usuario &raquo; Editar Datos</h2>
			<hr />
			
			<?php
			// escaping, additionally removing everything that could be (html/javascript-) code
			$nik = mysqli_real_escape_string($conexion,(strip_tags($_GET["nik"],ENT_QUOTES)));
			$sql = mysqli_query($conexion, "SELECT * FROM usuarios WHERE idUsuarios='$nik'");
			if(mysqli_num_rows($sql) == 0){
				header("Location: ../listaUsuario.php");
			}else{
				$row = mysqli_fetch_assoc($sql);
			}
			if(isset($_POST['save'])){
                $apellido		     = mysqli_real_escape_string($conexion,(strip_tags($_POST["apellido"],ENT_QUOTES)));//Escanpando caracteres 
                $nombre		     = mysqli_real_escape_string($conexion,(strip_tags($_POST["nombre"],ENT_QUOTES)));//Escanpando caracteres 
                $cuil		     = mysqli_real_escape_string($conexion,(strip_tags($_POST["cuil"],ENT_QUOTES)));//Escanpando caracteres     
                $email		     = mysqli_real_escape_string($conexion,(strip_tags($_POST["email"],ENT_QUOTES)));//Escanpando caracteres     
                $dni		     = mysqli_real_escape_string($conexion,(strip_tags($_POST["dni"],ENT_QUOTES)));//Escanpando caracteres 
				$telefono		 = mysqli_real_escape_string($conexion,(strip_tags($_POST["telefono"],ENT_QUOTES)));//Escanpando caracteres 
				$idRol          = mysqli_real_escape_string($conexion,(strip_tags($_POST["idRol"],ENT_QUOTES)));//Escanpando caracteres 
				$estado			 = mysqli_real_escape_string($conexion,(strip_tags($_POST["estado"],ENT_QUOTES)));//Escanpando caracteres 
				
				$update = mysqli_query($conexion, "UPDATE usuarios SET apellido='$apellido', nombre='$nombre', cuil='$cuil', email='$email', dni='$dni'  telefono='$telefono', idRol='$idRol', estado='$estado' WHERE idUsuarios='$nik'") /*or die(mysqli_error())*/;
				if($update){
					header("Location: editarUsuario.php?nik=".$nik."&pesan=sukses");
				}else{
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pudo guardar los datos.</div>';
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
						<input type="text" name="apellido" value="<?php echo $row ['apellido']; ?>" class="form-control" placeholder="Apellido" required>
					</div>
				</div>
                <div class="form-group">
					<label class="col-sm-3 control-label">Nombre</label>
					<div class="col-sm-4">
						<input type="text" name="nombre" value="<?php echo $row ['nombre']; ?>" class="form-control" placeholder="Nombre" required>
					</div>
				</div>
                <div class="form-group">
					<label class="col-sm-3 control-label">Cuil</label>
					<div class="col-sm-4">
						<input type="text" name="cuil" value="<?php echo $row ['cuil']; ?>" class="form-control" placeholder="Cuil" required>
					</div>
				</div>
                <div class="form-group">
					<label class="col-sm-3 control-label">Correo Electrónico</label>
					<div class="col-sm-4">
						<input type="text" name="email" value="<?php echo $row ['email']; ?>" class="form-control" placeholder="E-mail" required>
					</div>
				</div>
                <div class="form-group">
					<label class="col-sm-3 control-label">Dni</label>
					<div class="col-sm-4">
						<input type="text" name="dni" value="<?php echo $row ['dni']; ?>" class="form-control" placeholder="Dni" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Teléfono</label>
					<div class="col-sm-3">
						<input type="text" name="telefono" value="<?php echo $row ['telefono']; ?>" class="form-control" placeholder="Teléfono" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">idRol</label>
					<div class="col-sm-3">
						
						<input type="text" name="idRol" value="<?php echo $row ['idRol']; ?>" class="form-control" placeholder="idRol" required>
					</div>
                    
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Estado</label>
					<div class="col-sm-3">
						<select name="estado" class="form-control">
							<option value="">- Selecciona estado -</option>
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
		</div>
	</div>

  <!-- Incluir Footer - se superpone contra los botones y no funciona -->
    </body>

</html>