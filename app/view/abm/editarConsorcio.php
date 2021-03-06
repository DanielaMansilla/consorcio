<?php
require_once '../../config/Conexion.php'; 
require_once '../../clases/Proveedor.php';
session_start();
//Si es Admin o Operador puede visualizar la pagina.
if (!isset($_SESSION['admin']) && !isset($_SESSION['operador'])) {
	header("Location: ../index.php");
} 
?>

<!DOCTYPE html>
<html lang="es">
<?php include('../template/head.php'); ?>

    <body>
    <?php 
        include('../template/nav.php');  
        include('../template/header.php'); ?>

        <title>Consorcios del Valle - Editar Consorcio</title>

        <div class="container">
		<div class="content">
			<h2>Datos del Consorcio &raquo; Editar Datos</h2>
			<hr />

			<?php
			// escaping, additionally removing everything that could be (html/javascript-) code
			$nik = mysqli_real_escape_string($conexion,(strip_tags($_GET["nik"],ENT_QUOTES)));
			$sql = mysqli_query($conexion, "SELECT * FROM consorcio WHERE idConsorcio='$nik'");
			// Si el consorcio no existe redirecciono al index
			if (mysqli_num_rows($sql) == 0) {
				header("Location: ../index.php");
			} else {
				$row = mysqli_fetch_assoc($sql);
			}
			if (isset($_POST['save'])) { 
				$nombre		    = mysqli_real_escape_string($conexion,(strip_tags($_POST["nombre"],ENT_QUOTES)));//Escanpando caracteres 
                $cuit		    = mysqli_real_escape_string($conexion,(strip_tags($_POST["cuit"],ENT_QUOTES)));//Escanpando caracteres 
                $codigoPostal   = mysqli_real_escape_string($conexion,(strip_tags($_POST["codigoPostal"],ENT_QUOTES)));//Escanpando caracteres 
                $telefono   	= mysqli_real_escape_string($conexion,(strip_tags($_POST["telefono"],ENT_QUOTES)));//Escanpando caracteres 
                $correo   		= mysqli_real_escape_string($conexion,(strip_tags($_POST["correo"],ENT_QUOTES)));//Escanpando caracteres 
				$direccion  	= mysqli_real_escape_string($conexion,(strip_tags($_POST["direccion"],ENT_QUOTES)));//Escanpando caracteres 
				
				$error = array();
				//Validaciones
				if(!(strlen($cuit) == 11 && ctype_digit($cuit))){
					$error[] = "El CUIT debe tener 11 dígitos sin guiones.";
				  }
				if(!(ctype_digit($codigoPostal) && strlen($codigoPostal) == 4)){
					$error[] = "El Código Postal debe tener 4 dígitos.";
				}
				if(!(ctype_digit($telefono) && strlen($telefono) >= 8 && strlen($telefono) <= 11)){
					$error[] = "El Teléfono debe tener entre 8 y 11 dígitos.";
				}
				if(!(strlen($direccion) <= 70)){
					$error[] = "La Dirección debe tener como máximo 70 caracteres.";
				}
				$proveedor = new Proveedor();
				$cuitValido = $proveedor::validarCuit($cuit);
				if(!$cuitValido){
					$error[] = "CUIT inválido.";
				}

				if(!(filter_var($correo, FILTER_VALIDATE_EMAIL))){
					$error[] = "Email incorrecto o inválido.";
				}

				$correoViejo = $row ['correo'];
				$cuitViejo = $row ['cuit'];
				
				//Correo
				$queryCorreoRepetido = mysqli_query($conexion, "SELECT * FROM consorcio WHERE correo = '$correo' AND idConsorcio <> '$nik'");
				if (mysqli_num_rows($queryCorreoRepetido) != 0){
					$error[] = "El Email está dado de alta en otro consorcio.";
				}

				//Cuit
				$queryCuitRepetido = mysqli_query($conexion, "SELECT * FROM consorcio WHERE cuit = '$cuit' AND idConsorcio <> '$nik'");
				if (mysqli_num_rows($queryCuitRepetido) != 0){
					$error[] = "El CUIT ya está dado de alta en otro consorcio.";
				}

                if (sizeof($error) == 0){
                   $update = mysqli_query($conexion, "UPDATE consorcio SET nombre='$nombre', cuit='$cuit', codigoPostal='$codigoPostal', telefono='$telefono', correo='$correo', direccion='$direccion' WHERE idConsorcio='$nik'") or die(mysqli_error($conexion));
                    if ($update) {
						// Busco nuevamente el consorcio para obtener los datos actualizados y mostrarlos en los controles
						$sql = mysqli_query($conexion, "SELECT * FROM consorcio WHERE idConsorcio='$nik'");
						$row = mysqli_fetch_assoc($sql);
                        echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Bien hecho! Los datos han sido modificados con éxito.</div>';
                    } else {
                        echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pudieron actualizar los datos.</div>';
                    }
                 } else {
					echo '<div class="alert alert-danger alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Errores:</strong>';
							foreach ($error as $er) {
								echo "<br>- $er";
							  }
						echo '</div>';
					}
                }

                 ?>
            
		<form class="form-horizontal" action="" method="post">      
            <div class="form-group">
				<label class="col-sm-3 control-label">Nombre:</label>
				<div class="col-sm-3">
                     <input type="text" name="nombre" value="<?php echo $row ['nombre']; ?>" class="form-control" maxlength="50" placeholder="Nombre" required>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">CUIT:</label>
				<div class="col-sm-3">

					<input type="text" name="cuit" value="<?php echo $row ['cuit']; ?>" class="form-control" maxlength="11" placeholder="cuit" required><small class="form-text text-muted">Ingresar solo numeros, sin guiones, barras ni puntos.</small>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Código Postal:</label>
				<div class="col-sm-3">
                     <input type="text" name="codigoPostal" value="<?php echo $row ['codigoPostal']; ?>" class="form-control" maxlength="4" placeholder="Código Postal" required>
				</div>
			</div>
            <div class="form-group">
				<label class="col-sm-3 control-label">Teléfono:</label>
				<div class="col-sm-3">

					<input type="text" name="telefono" value="<?php echo $row ['telefono']; ?>" class="form-control" maxlength="11" placeholder="Teléfono" required>
				</div>
			</div>
            <div class="form-group">
				<label class="col-sm-3 control-label">Correo Electrónico:</label>
				<div class="col-sm-3">

					<input type="text" name="correo" value="<?php echo $row ['correo']; ?>" class="form-control" maxlength="50" placeholder="Correo Electrónico" required>
				</div>
			</div>
            <div class="form-group">
				<label class="col-sm-3 control-label">Dirección:</label>
				<div class="col-sm-3">

					<input type="text" name="direccion" value="<?php echo $row ['direccion']; ?>" class="form-control" maxlength="70" placeholder="Dirección" required>
				</div>
			</div>
				
			<div class="form-group">
				<label class="col-sm-3 control-label">&nbsp;</label>
				<div class="col-sm-6">
					<input type="submit" name="save" class="btn btn-sm btn-primary" value="Guardar datos">
					<a href="../listaConsorcio.php" class="btn btn-sm btn-danger">Cancelar</a>
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