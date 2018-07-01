<?php
require_once '../../config/Conexion.php'; 
session_start();
//Si es Admin o Operador puede visualizar la pagina.
if(!isset($_SESSION['admin'])){ //verificar si el operador necesita editar.
    header("Location: ../index.php");} ?> 

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
			if(mysqli_num_rows($sql) == 0){
				header("Location: ../index.php");
			}else{
				$row = mysqli_fetch_assoc($sql);
			}
			if(isset($_POST['save'])){ 
				$nombre		     = mysqli_real_escape_string($conexion,(strip_tags($_POST["nombre"],ENT_QUOTES)));//Escanpando caracteres 
                $cuit		     = mysqli_real_escape_string($conexion,(strip_tags($_POST["cuit"],ENT_QUOTES)));//Escanpando caracteres 
                $codigoPostal   = mysqli_real_escape_string($conexion,(strip_tags($_POST["codigoPostal"],ENT_QUOTES)));//Escanpando caracteres 
                $telefono   = mysqli_real_escape_string($conexion,(strip_tags($_POST["telefono"],ENT_QUOTES)));//Escanpando caracteres 
                $correo   = mysqli_real_escape_string($conexion,(strip_tags($_POST["correo"],ENT_QUOTES)));//Escanpando caracteres 
                $direccion   = mysqli_real_escape_string($conexion,(strip_tags($_POST["direccion"],ENT_QUOTES)));//Escanpando caracteres 

                $googlexy   = mysqli_real_escape_string($conexion,(strip_tags($_POST["googlexy"],ENT_QUOTES)));//CODIGO DE GOOGLE MAPS
                
               $update = mysqli_query($conexion, "UPDATE consorcio SET nombre='$nombre', cuit='$cuit', codigoPostal='$codigoPostal', telefono='$telefono', correo='$correo', direccion='$direccion', googlexy='$googlexy' WHERE idConsorcio='$nik'") or die(mysqli_error($conexion));
				if($update){
					header("Location: editarConsorcio.php?nik=".$nik."&pesan=sukses");
				}else{
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pudo guardar los datos.</div>';
				}
			}
			
			if(isset($_GET['pesan']) == 'sukses'){
				echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Los datos han sido guardados con éxito.</div>';
			} ?>
            
		<form class="form-horizontal" action="" method="post">      
            <div class="form-group">
				<label class="col-sm-3 control-label">Nombre:</label>
				<div class="col-sm-3">
                     <input type="text" name="nombre" value="<?php echo $row ['nombre']; ?>" class="form-control" placeholder="Nombre" required>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">CUIT:</label>
				<div class="col-sm-3">

					<input type="text" name="cuit" value="<?php echo $row ['cuit']; ?>" class="form-control" placeholder="cuit" required>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Código Postal:</label>
				<div class="col-sm-3">
                     <input type="text" name="codigoPostal" value="<?php echo $row ['codigoPostal']; ?>" class="form-control" placeholder="Código Postal" required>
				</div>
			</div>
            <div class="form-group">
				<label class="col-sm-3 control-label">Teléfono:</label>
				<div class="col-sm-3">

					<input type="text" name="telefono" value="<?php echo $row ['telefono']; ?>" class="form-control" placeholder="Teléfono" required>
				</div>
			</div>
            <div class="form-group">
				<label class="col-sm-3 control-label">Correo Electrónico:</label>
				<div class="col-sm-3">

					<input type="text" name="correo" value="<?php echo $row ['correo']; ?>" class="form-control" placeholder="Correo Electrónico" required>
				</div>
			</div>
            <div class="form-group">
				<label class="col-sm-3 control-label">Dirección:</label>
				<div class="col-sm-3">

					<input type="text" name="direccion" value="<?php echo $row ['direccion']; ?>" class="form-control" placeholder="Dirección" required>
				</div>
			</div>

            <!--  GOOGLE MAPS falta-->
            <!--
            <div class="form-group">
				<label class="col-sm-3 control-label">CUIT:</label>
				<div class="col-sm-3">

					<input type="text" name="googlexy" value="<?php// echo $row ['googlexy']; ?>" class="form-control" placeholder="GOOGLE MAPS" required>
				</div>
			</div>-->
				
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