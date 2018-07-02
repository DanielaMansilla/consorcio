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

        <title>Consorcios del Valle - Editar Usuario</title>

        <div class="container">
		<div class="content">
			<h2>Datos del usuario &raquo; Editar Datos</h2>
			<hr />

			<?php
			// escaping, additionally removing everything that could be (html/javascript-) code
			$nik = mysqli_real_escape_string($conexion,(strip_tags($_GET["nik"],ENT_QUOTES)));
            //quiera agregar nombre y apellido del usuario en esta vista.
            
			$busquedaNombre= "SELECT nombre, apellido FROM usuarios WHERE idUsuarios='$nik'";
			$nombreUsuario=mysqli_query($conexion, $busquedaNombre); 
            //Variable de sesion para usar mas adelante. 
            
			$row2 = mysqli_fetch_array($nombreUsuario);

			echo '<h3>', 'Apellido:  ', $row2["apellido"], '<br></h3>';
			echo '<h3>', 'Nombre:  ', $row2["nombre"], '<br></h3>';
			echo '<br>';        
            
			$sql = mysqli_query($conexion, "SELECT * FROM usuarios WHERE idUsuarios='$nik'");
			if(mysqli_num_rows($sql) == 0){
				header("Location: ../index.php");
			}else{
				$row = mysqli_fetch_assoc($sql);
			}
			if(isset($_POST['save'])){ 
				$idRol          = mysqli_real_escape_string($conexion,(strip_tags($_POST["idRol"],ENT_QUOTES)));//Escanpando caracteres 
				$estado			 = mysqli_real_escape_string($conexion,(strip_tags($_POST["estado"],ENT_QUOTES)));//Escanpando caracteres 
                
               $update = mysqli_query($conexion, "UPDATE usuarios SET idRol='$idRol', estado='$estado' WHERE idUsuarios='$nik'") or die(mysqli_error($conexion));
				if($update){
					//header("Location: editarRolyEstado.php?nik=".$nik."&pesan=sukses");
                if($idRol==3){//propietario
                    //header("Location: ../listaUf.php");
                }
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
				<label class="col-sm-3 control-label">Rol:</label>
				<div class="col-sm-3">

					<select name="idRol" class="form-control">
                            <?php  $datos = mysqli_query($conexion, "SELECT * FROM roles"); //muestra todos los roles
                             while ($row2 = mysqli_fetch_assoc($datos)) { ?>
                            <option value="<?php echo $row2['idRoles']; ?>">
                                <?php echo $row2['descripcion']; ?>
                                </option>
                            <?php } ?>
                        </select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Estado:</label>
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
					<a href="../homeAdmin.php" class="btn btn-sm btn-danger">Cancelar</a>
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