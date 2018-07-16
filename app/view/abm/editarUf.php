<?php
require_once '../../config/Conexion.php'; 
session_start();
//Si es Admin o Operador puede visualizar la pagina.
if(!isset($_SESSION['admin'])){
	if(!isset($_SESSION['operador'])){
		header("Location: ../index.php");}} ?>

<!DOCTYPE html>
<html lang="es">
<?php include('../template/head.php'); ?>

    <body>
    <?php 
        include('../template/nav.php');  
        include('../template/header.php'); ?>

        <title>Consorcios del Valle - Unidades Funcionales</title>

        <div class="container">
		<div class="content">
			<h2>Datos de Unidades Funcionales &raquo; Editar Datos</h2>
			<hr />
            	<?php
			// escaping, additionally removing everything that could be (html/javascript-) code
			$nik = mysqli_real_escape_string($conexion,(strip_tags($_GET["nik"],ENT_QUOTES)));
			$sql = mysqli_query($conexion, "SELECT * FROM propiedad WHERE idPropiedad='$nik'");
			if(mysqli_num_rows($sql) == 0){
				header("Location: ../index.php");
			}else{
				$row = mysqli_fetch_assoc($sql);
			}
			if(isset($_POST['save'])){
				$idUsuarios		 = mysqli_real_escape_string($conexion,(strip_tags($_POST["idUsuarios"],ENT_QUOTES)));//Escanpando caracteres
				$update = mysqli_query($conexion, "UPDATE propiedad SET idUsuarios='$idUsuarios' WHERE idPropiedad='$nik'") or die(mysqli_error($conexion));
				if($update){
					echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Los datos han sido guardados con éxito.</div>';
					//header("Location: editarUf.php?nik=".$nik."&pesan=sukses");
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
					<label class="col-sm-3 control-label">Propietarios:</label>
					<div class="col-sm-3">
						<select name="idUsuarios" class="form-control">
                            <?php  $datos = mysqli_query($conexion, "SELECT * FROM usuarios WHERE idRol = 1 or idRol = 2 or idRol = 3"); //Un administrador Operador u Propietario Pueden tener una Unidad Funcional.
                             while ($row2 = mysqli_fetch_assoc($datos)) { ?>
                            <option value="<?php echo $row2['idUsuarios']; ?>">
                                <?php echo $row2['nombre']; ?>
                                <?php echo $row2['apellido']; ?>
                                </option>
                            <?php } ?>
                        </select>
					</div>
                
				</div>			
				<div class="form-group">
					<label class="col-sm-3 control-label">&nbsp;</label>
					<div class="col-sm-6">
						<input type="submit" name="save" class="btn btn-sm btn-primary" value="Guardar datos">
						<a href="../listaUf.php" class="btn btn-sm btn-danger">Cancelar</a>
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