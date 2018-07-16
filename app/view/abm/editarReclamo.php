<?php
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

        <title>Consorcios del Valle - Editar Consorcio</title>

        <div class="container">
		<div class="content">


			<?php
            
            $nik = mysqli_real_escape_string($conexion,(strip_tags($_GET["nik"],ENT_QUOTES)));
            echo '<h2>Datos del Reclamo Nro.  '.$nik.' &raquo; Editar Datos</h2>
			<hr />';
			// escaping, additionally removing everything that could be (html/javascript-) code
			
			$sql = mysqli_query($conexion, "SELECT * FROM reclamo LEFT JOIN propiedad ON reclamo.idPropiedad=propiedad.idPropiedad WHERE idReclamo='$nik'");
			if(mysqli_num_rows($sql) == 0){
				//header("Location: ../index.php");
			}else{
				$row = mysqli_fetch_assoc($sql);
			}

			if($row ['estado'] !='Resuelto'){

				if(isset($_POST['save'])){ 
					$descripcion		     = mysqli_real_escape_string($conexion,(strip_tags($_POST["descripcion"],ENT_QUOTES)));//Escanpando caracteres 
					$estado		     = mysqli_real_escape_string($conexion,(strip_tags($_POST["estado"],ENT_QUOTES)));//Escanpando caracteres 
					
					

					$update = mysqli_query($conexion, "UPDATE reclamo SET descripcion='$descripcion', estado='$estado' WHERE idReclamo='$nik'") or die(mysqli_error($conexion));
						if($update){
							//header("Location: editarConsorcio.php?nik=".$nik."&pesan=sukses");
							echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Bien hecho! Los datos han sido modificados con éxito.</div>';
						}else{
							echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pudo guardar los datos.</div>';
						}
					}
					if(isset($_GET['pesan']) == 'sukses'){
						echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Los datos han sido guardados con éxito.</div>';
				}
			}else{
				echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pueden editar reclamos resueltos.</div>';
			}
		
		
		?>
            
            <label class="col-sm-3 control-label">Nro. Reclamo: <?php echo $row ['idReclamo']; ?></label>
            <label class="col-sm-3 control-label">Fecha: <?php echo $row ['fecha']; ?></label>
            <br>
            <label class="col-sm-3 control-label">Piso: <?php echo $row ['piso']; ?></label>
            <label class="col-sm-3 control-label">Dpto: <?php echo $row ['departamento']; ?></label>
		<form class="form-horizontal" action="" method="post">      
            <div class="form-group">
				<label class="col-sm-3 control-label">Descripción:</label>
				<div class="col">
                     <textarea name="descripcion"  maxlength=100 class="form-control" placeholder="Ingrese una descripción..." required><?php echo $row ['descripcion']; ?></textarea>
				</div>
			</div>

            <div class="form-group">
					<label class="col-sm-3 control-label">Estado</label>
					<div class="col-sm-3">
						<select name="estado" class="form-control">
							<option disabled="disabled" hidden="hidden" value="">- Selecciona estado -</option>
                            <option value="Activo" <?php if ($row ['estado']=='Activo'){echo "selected";} ?>>Activo</option>
							<option value="Resuelto" <?php if ($row ['estado']=='Resuelto'){echo "selected";} ?>>Resuelto</option>
						</select> 
					</div>
                </div>
         
				
			<div class="form-group">
				<label class="col-sm-3 control-label">&nbsp;</label>
				<div class="col-sm-6">
					<input type="submit" name="save" class="btn btn-sm btn-primary" value="Guardar datos">
					<a href="../listaReclamos.php" class="btn btn-sm btn-danger">Cancelar</a>
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