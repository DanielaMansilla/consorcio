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

        <title>Consorcios del Valle - Agregar Proveedor</title>

        <div class="container">
		<div class="content">
			<h2>Datos del Proveedor &raquo; Agregar datos</h2>
			<hr />

			<?php
			if(isset($_POST['add'])){
                $cuit		     = mysqli_real_escape_string($conexion,(strip_tags($_POST["cuit"],ENT_QUOTES)));//Escanpando caracteres 
                $nombre		     = mysqli_real_escape_string($conexion,(strip_tags($_POST["nombre"],ENT_QUOTES)));//Escanpando caracteres 
				$nombre = ucfirst($nombre);
				$error = array();
				//Validaciones
				if(!(ctype_digit($cuit) && strlen($cuit) == 11)){
					$error[] = "Cuit debe tener 11 digitos sin guiones.";
				  }
				if(sizeof($error) == 0){
                //Realiza el Insert solo si no existe otro proveedor con el mismo CUIT
				$cek = mysqli_query($conexion, "SELECT * FROM proveedor WHERE cuit='$cuit'");
				if(mysqli_num_rows($cek) == 0){
                    $proveedor = new Proveedor();
				    $cuitValido = $proveedor::validarCuit($cuit);
                    if($cuitValido){
						$insert = mysqli_query($conexion, "INSERT INTO proveedor(cuit, nombre)
															VALUES('$cuit', '$nombre')") or die(mysqli_error($conexion));
						if($insert){
							echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Bien hecho! Los datos han sido guardados con éxito.</div>';
						}else{
							echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. No se pudo guardar los datos !</div>';
                        }
                    }else{
                        echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. El CUIT del proveedor no es valido.</div>';
                        }  
				}else{
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. El CUIT del proveedor ya existe!</div>';
				}
			}else{
				echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. No se pudo guardar los datos !</div>';
				foreach($error as $er){
                    echo "</br><strong>$er</strong>";
				  }
				}
			}
			?>

			<form class="form-horizontal" action="" method="post">
                <div class="form-group">
					<label class="col-sm-3 control-label">CUIT</label>
					<div class="col-sm-4">
						<input type="text" name="cuit" class="form-control" maxlength="11" placeholder="CUIT" required><small class="form-text text-muted">Ingresar solo numeros, sin guiones, barras ni puntos.</small>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Nombre</label>
					<div class="col-sm-4">
						<input type="text" name="nombre" class="form-control" maxlength="50" placeholder="Nombre" required>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-3 control-label">&nbsp;</label>
					<div class="col-sm-6">
						<input type="submit" name="add" class="btn btn-sm btn-primary" value="Guardar datos">
						<a href="../listaProveedor.php" class="btn btn-sm btn-danger">Cancelar</a>
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