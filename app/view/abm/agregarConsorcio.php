<?php
require_once '../../config/Conexion.php';
require_once '../../clases/Proveedor.php';
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: index.php");} ?>

<!DOCTYPE html>
<html lang="es">
<?php include('../template/head.php'); ?>

    <body>
    <?php 
        include('../template/nav.php');  
        include('../template/header.php'); ?>

        <title>Consorcios del Valle - Agregar Consorcio</title>

        <div class="container">
		<div class="content">
			<h2>Datos del Consorcio &raquo; Agregar datos</h2>
			<hr />

			<?php
			if(isset($_POST['add'])){
				$nombre		     = mysqli_real_escape_string($conexion,(strip_tags($_POST["nombre"],ENT_QUOTES)));//Escanpando caracteres 
				$nombre = ucfirst($nombre); 
                $cuit		     = mysqli_real_escape_string($conexion,(strip_tags($_POST["cuit"],ENT_QUOTES)));//Escanpando caracteres 
                $codigoPostal   = mysqli_real_escape_string($conexion,(strip_tags($_POST["codigoPostal"],ENT_QUOTES)));//Escanpando caracteres 
                $telefono   = mysqli_real_escape_string($conexion,(strip_tags($_POST["telefono"],ENT_QUOTES)));//Escanpando caracteres 
                $correo   = mysqli_real_escape_string($conexion,(strip_tags($_POST["correo"],ENT_QUOTES)));//Escanpando caracteres 
				$direccion   = mysqli_real_escape_string($conexion,(strip_tags($_POST["direccion"],ENT_QUOTES)));//Escanpando caracteres 
				
                $error = array();
				//Validaciones
				if(!(ctype_alpha($nombre) && strlen($nombre) <= 50)){
					$error[] = "Nombre debe tener como maximo 50 caracteres alfabéticos.";
				  }
				if(!(strlen($direccion) <= 70)){
					$error[] = "Dirección debe tener como maximo 70 caracteres.";
				  }
				  if(!(ctype_digit($telefono) && strlen($telefono) >= 8 && strlen($telefono) <= 11)){
					$error[] = "Teléfono debe tener entre 8 y 11 digitos sin guiones.";
				  }
				if(!(ctype_digit($codigoPostal) && strlen($codigoPostal) == 4)){
					$error[] = "Codigo postal debe tener 4 digitos sin guiones.";
				  }
				if(!(ctype_digit($cuit) && strlen($cuit) == 11)){
					$error[] = "Cuit debe tener 11 digitos sin guiones.";
				  }
                $proveedor = new Proveedor();
				$cuitValido = $proveedor::validarCuit($cuit);
				if(!$cuilValido){
					$error[] = "Cuil invalido.";
				  }

				if(!(filter_var($correo, FILTER_VALIDATE_EMAIL))){
					$error[] = "Email incorrecto";
				}
				$cek5 = mysqli_query($conexion, "SELECT * FROM usuarios WHERE email='$email' and idUsuarios<>'$nik'");
                if(!(mysqli_num_rows($cek5) == 0)){
                    $error[] = "Email está utilizado en otro usuario.";
				}
                if(sizeof($error) == 0){
                //Realiza el Insert solo si no existe otro consorcio con el mismo CUIT
				$cek = mysqli_query($conexion, "SELECT * FROM consorcio WHERE idConsorcio='$cuit'");
				if(mysqli_num_rows($cek) == 0){
						$insert = mysqli_query($conexion, "INSERT INTO consorcio(nombre, cuit, codigoPostal, telefono, correo, direccion)
															VALUES('$nombre', '$cuit', '$codigoPostal', '$telefono', '$correo', '$direccion')") or die(mysqli_error($conexion));
						if($insert){
							echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Bien hecho! Los datos han sido guardados con éxito.</div>';
						}else{
							echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. No se pudo guardar los datos !</div>';
                        }
                        
				}else{
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. El CUIL del Consorcio ya exite!</div>';
                }
            }else{
                echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. El CUIT del consorcio no es valido.</div>';
                }
			}
			?>

			<form class="form-horizontal" action="" method="post">
                <div class="form-group">
					<label class="col-sm-3 control-label">Nombre</label>
					<div class="col-sm-4">
						<input type="text" name="nombre" class="form-control" placeholder="Nombre" maxlength="50" required>
					</div>
				</div>
                <div class="form-group">
					<label class="col-sm-3 control-label">Cuit</label>
					<div class="col-sm-4">
						<input type="text" name="cuit" class="form-control" placeholder="CUIT" maxlength="11" required><small class="form-text text-muted">Ingresar solo numeros, sin guiones, barras ni puntos.</small>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Código Postal</label>
					<div class="col-sm-4">
						<input type="text" name="codigoPostal" class="form-control" placeholder="Código Postal" maxlength="4" required>
					</div>
				</div>
                <div class="form-group">
					<label class="col-sm-3 control-label">Teléfono</label>
					<div class="col-sm-4">
						<input type="text" name="telefono" class="form-control" placeholder="Teléfono" maxlength="8" required>
					</div>
				</div>
                <div class="form-group">
					<label class="col-sm-3 control-label">Correo Electrónico</label>
					<div class="col-sm-4">
						<input type="text" name="correo" class="form-control" placeholder="E-Mail" maxlength="50" required>
					</div>
				</div>
                <div class="form-group">
					<label class="col-sm-3 control-label">Dirección</label>
					<div class="col-sm-4">
						<input type="text" name="direccion" class="form-control" placeholder="Calle Numero,Localidad" maxlength="70" required>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-3 control-label">&nbsp;</label>
					<div class="col-sm-6">
						<input type="submit" name="add" class="btn btn-sm btn-primary" value="Guardar datos">
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