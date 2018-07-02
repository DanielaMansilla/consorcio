<?php
require_once '../../config/Conexion.php';
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
                $cuit		     = mysqli_real_escape_string($conexion,(strip_tags($_POST["cuit"],ENT_QUOTES)));//Escanpando caracteres 
                $codigoPostal   = mysqli_real_escape_string($conexion,(strip_tags($_POST["codigoPostal"],ENT_QUOTES)));//Escanpando caracteres 
                $telefono   = mysqli_real_escape_string($conexion,(strip_tags($_POST["telefono"],ENT_QUOTES)));//Escanpando caracteres 
                $correo   = mysqli_real_escape_string($conexion,(strip_tags($_POST["correo"],ENT_QUOTES)));//Escanpando caracteres 
                $direccion   = mysqli_real_escape_string($conexion,(strip_tags($_POST["direccion"],ENT_QUOTES)));//Escanpando caracteres 

                $googlexy   = mysqli_real_escape_string($conexion,(strip_tags($_POST["googlexy"],ENT_QUOTES)));//CODIGO DE GOOGLE MAPS


                //Realiza el Insert solo si no existe otro consorcio con el mismo CUIT
				$cek = mysqli_query($conexion, "SELECT * FROM consorcio WHERE idConsorcio='$cuit'");
				if(mysqli_num_rows($cek) == 0){
						$insert = mysqli_query($conexion, "INSERT INTO consorcio(nombre, cuit, codigoPostal, telefono, correo, direccion, googlexy)
															VALUES('$nombre', '$cuit', '$codigoPostal', '$telefono', '$correo', '$direccion', '$googlexy')") or die(mysqli_error());
						if($insert){
							echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Bien hecho! Los datos han sido guardados con éxito.</div>';
						}else{
							echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. No se pudo guardar los datos !</div>';
                        }
                        
				}else{
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. El CUIL del Consorcio ya exite!</div>';
				}
			}
			?>

			<form class="form-horizontal" action="" method="post">
                <div class="form-group">
					<label class="col-sm-3 control-label">Nombre</label>
					<div class="col-sm-4">
						<input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
					</div>
				</div>
                <div class="form-group">
					<label class="col-sm-3 control-label">Cuit</label>
					<div class="col-sm-4">
						<input type="text" name="cuit" class="form-control" placeholder="CUIT" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Código Postal</label>
					<div class="col-sm-4">
						<input type="text" name="codigoPostal" class="form-control" placeholder="Código Postal" required>
					</div>
				</div>
                <div class="form-group">
					<label class="col-sm-3 control-label">Teléfono</label>
					<div class="col-sm-4">
						<input type="text" name="telefono" class="form-control" placeholder="Teléfono" required>
					</div>
				</div>
                <div class="form-group">
					<label class="col-sm-3 control-label">Correo Electrónico</label>
					<div class="col-sm-4">
						<input type="text" name="correo" class="form-control" placeholder="E-Mail" required>
					</div>
				</div>
                <div class="form-group">
					<label class="col-sm-3 control-label">Dirección</label>
					<div class="col-sm-4">
						<input type="text" name="direccion" class="form-control" placeholder="Dirección" required>
					</div>
				</div>

                <!--  GOOGLE MAPS falta-->
                <!--
                <div class="form-group">
					<label class="col-sm-3 control-label">Ubicacion Google Maps</label>
					<div class="col-sm-4">
						<input type="text" name="googlexy" class="form-control" placeholder="GOOGLE MAPS" required>
					</div>
				</div>-->

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