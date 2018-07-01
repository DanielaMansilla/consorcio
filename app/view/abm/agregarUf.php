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

        <title>Consorcios del Valle - Agregar Unidad Funcional</title>

        <div class="container">
		<div class="content">
			<h2>Datos de la Unidad Funcional &raquo; Agregar datos</h2>
			<hr />

			<?php
			if(isset($_POST['add'])){

                $porcentajeParticipacion    = mysqli_real_escape_string($conexion,(strip_tags($_POST["porcentajeParticipacion"],ENT_QUOTES)));//Escanpando caracteres 
                $piso = mysqli_real_escape_string($conexion,(strip_tags($_POST["piso"],ENT_QUOTES)));//Escanpando caracteres 
                $departamento = mysqli_real_escape_string($conexion,(strip_tags($_POST["departamento"],ENT_QUOTES)));//Escanpando caracteres 
                $unidadFuncionalLote = mysqli_real_escape_string($conexion,(strip_tags($_POST["unidadFuncionalLote"],ENT_QUOTES)));//Escanpando caracteres 
                $idConsorcio = mysqli_real_escape_string($conexion,(strip_tags($_POST["idConsorcio"],ENT_QUOTES)));//Escanpando caracteres 

                //Realiza el Insert solo si no existe otro Unidad Funcional con el mismo N° unidadFuncionalLote.
				$cek = mysqli_query($conexion, "SELECT * FROM propiedad WHERE unidadFuncionalLote='$unidadFuncionalLote'");
				if(mysqli_num_rows($cek) == 0){
						$insert = mysqli_query($conexion, "INSERT INTO propiedad(porcentajeParticipacion, piso, departamento, unidadFuncionalLote, idConsorcio)
															VALUES('$porcentajeParticipacion', '$piso', '$departamento', '$unidadFuncionalLote', '$idConsorcio')") or die(mysqli_error());
						if($insert){
							echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Bien hecho! Los datos han sido guardados con éxito.</div>';
						}else{
							echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. No se pudo guardar los datos !</div>';
                        }
                        
				}else{
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. código de Unidad Funcional exite!</div>';
				}
			}
			?>

			<form class="form-horizontal" action="" method="post">
                <div class="form-group">
					<label class="col-sm-3 control-label">Porcentaje</label>
					<div class="col-sm-4">
						<input type="text" name="porcentajeParticipacion" class="form-control" placeholder="Porcentaje" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Piso</label>
					<div class="col-sm-4">
						<input type="text" name="piso" class="form-control" placeholder="Piso" required>
					</div>
				</div>
                <div class="form-group">
					<label class="col-sm-3 control-label">Departamento</label>
					<div class="col-sm-4">
						<input type="text" name="departamento" class="form-control" placeholder="Departamento" required>
					</div>
				</div>
                <div class="form-group">
					<label class="col-sm-3 control-label">Unidad Funcional</label>
					<div class="col-sm-4">
						<input type="text" name="unidadFuncionalLote" class="form-control" placeholder="Unidad Funcional" required>
					</div>
				</div>
                <div class="form-group">
					<label class="col-sm-3 control-label">Consorcios:</label>
					<div class="col-sm-3">
						<select name="idConsorcio" class="form-control">
                            <?php  $datos = mysqli_query($conexion, "SELECT * FROM consorcio"); //muestra todos los consorcios
                             while ($row2 = mysqli_fetch_assoc($datos)) { ?>
                            <option value="<?php echo $row2['idConsorcio']; ?>">
                                <?php echo $row2['nombre']; ?>
                                </option>
                            <?php } ?>
                        </select>
					</div>
                
				</div>


				<div class="form-group">
					<label class="col-sm-3 control-label">&nbsp;</label>
					<div class="col-sm-6">
						<input type="submit" name="add" class="btn btn-sm btn-primary" value="Guardar datos">
						<a href="listaUf.php" class="btn btn-sm btn-danger">Cancelar</a>
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