<?php
require_once '../../config/Conexion.php'; 
require_once '../../clases/Proveedor.php';
session_start();
//Si es Admin o Operador puede visualizar la pagina.
if(!isset($_SESSION['admin'])){
	if(!isset($_SESSION['operador'])){ //verificar si el operador necesita editar.
		header("Location: ../index.php");}} ?>

<!DOCTYPE html>
<html lang="es">
<?php include('../template/head.php'); ?>

    <body>
    <?php 
        include('../template/nav.php');  
        include('../template/header.php'); ?>

        <title>Consorcios del Valle - Editar Proveedor</title>

        <div class="container">
		<div class="content">
			<h2>Datos del Proveedor &raquo; Editar Datos</h2>
			<hr />

			<?php
			// escaping, additionally removing everything that could be (html/javascript-) code
			$nik = mysqli_real_escape_string($conexion,(strip_tags($_GET["nik"],ENT_QUOTES)));
			$sql = mysqli_query($conexion, "SELECT * FROM proveedor WHERE idProveedor='$nik'");
			if(mysqli_num_rows($sql) == 0){
				header("Location: ../index.php");
			}else{
				$row = mysqli_fetch_assoc($sql);
			}
			if(isset($_POST['save'])){ 
				$cuit          = mysqli_real_escape_string($conexion,(strip_tags($_POST["cuit"],ENT_QUOTES)));//Escanpando caracteres 
				$nombre			 = mysqli_real_escape_string($conexion,(strip_tags($_POST["nombre"],ENT_QUOTES)));//Escanpando caracteres 
               
                
            $proveedor = new Proveedor();
            $cuitValido = $proveedor::validarCuit($cuit);
            if($cuitValido){
              $cek = mysqli_query($conexion, "SELECT * FROM proveedor WHERE cuit='$cuit' and idProveedor<>'$nik'");
              if(mysqli_num_rows($cek) == 0){
                $update = mysqli_query($conexion, "UPDATE proveedor SET cuit='$cuit', nombre='$nombre' WHERE idProveedor='$nik'") or die(mysqli_error($conexion));
				if($update){
					//header("Location: editarProveedor.php?nik=".$nik."&pesan=sukses");
					echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Bien hecho! Los datos han sido modificados con éxito.</div>';
                    }else{
                        echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pudo guardar los datos.</div>';
                    }
                }else{
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. El CUIT del proveedor ya esta registrado.</div>';
				    }
              }else{
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. El CUIT del proveedor no es valido.</div>';
				    }
			}
			
			if(isset($_GET['pesan']) == 'sukses'){
				echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Los datos han sido guardados con éxito.</div>';
			} ?>
            
		<form class="form-horizontal" action="" method="post">      
			<div class="form-group">
				<label class="col-sm-3 control-label">CUIT:</label>
				<div class="col-sm-3">

					<input type="text" name="cuit" value="<?php echo $row ['cuit']; ?>" class="form-control" placeholder="cuit" required><small class="form-text text-muted">Ingresar solo numeros, sin guiones, barras ni puntos.</small>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Nombre:</label>
				<div class="col-sm-3">
                     <input type="text" name="nombre" value="<?php echo $row ['nombre']; ?>" class="form-control" placeholder="Nombre" required>
				</div>
			</div>
				
			<div class="form-group">
				<label class="col-sm-3 control-label">&nbsp;</label>
				<div class="col-sm-6">
					<input type="submit" name="save" class="btn btn-sm btn-primary" value="Guardar datos">
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