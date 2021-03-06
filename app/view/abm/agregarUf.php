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
                $departamento = strtoupper(mysqli_real_escape_string($conexion,(strip_tags($_POST["departamento"],ENT_QUOTES))));//Escanpando caracteres 
                $idConsorcio = mysqli_real_escape_string($conexion,(strip_tags($_POST["idConsorcio"],ENT_QUOTES)));//Escanpando caracteres 
                $unidadFuncionalLote = $piso."".$departamento."".$idConsorcio;
				$error = array();
				//Validacion
				if(!($unidadFuncionalLote <= 100 && $unidadFuncionalLote >= 1)){
					$error[] = "Unidad Funcional (Lote): debe ser mayor a 0 y menor a 100";
				  }
				
				// Obtengo el porcentaje de participación total actual del consorcio elegido
				$totalPorcentaje = mysqli_query($conexion, 
				"SELECT SUM(porcentajeParticipacion) as total
				FROM propiedad
				WHERE propiedad.idConsorcio = '$idConsorcio'"); 
                $row3 = mysqli_fetch_assoc($totalPorcentaje);
                 
                if($row3["total"] + $porcentajeParticipacion >100){
					$error[] = "Porcentaje: supera el limite disponible.";
				  }
				  
				  if(!(ctype_alpha($departamento) && strlen($departamento) == 1)){
					$error[] = "Departamento: Debe contener solo 1 Letra";
				  }
				  if(!($piso <= 100 && $piso >= 1)){
					$error[] = "Pisos: debe ser mayor a 0 y menor a 100";
				  }
				  if(!($porcentajeParticipacion <= 100 && $porcentajeParticipacion > 0)){
					$error[] = "Porcentaje: debe ser mayor a 0% y menor o igual a 100%";
				  }if(sizeof($error) == 0){

                //Realiza el Insert solo si no existe otro Unidad Funcional con el mismo N° unidadFuncionalLote.
				$cek = mysqli_query($conexion, "SELECT * FROM propiedad WHERE unidadFuncionalLote='$unidadFuncionalLote'");
				if(mysqli_num_rows($cek) == 0){
						$insert = mysqli_query($conexion, "INSERT INTO propiedad(porcentajeParticipacion, piso, departamento, unidadFuncionalLote, idConsorcio)
															VALUES('$porcentajeParticipacion', '$piso', '$departamento', '$unidadFuncionalLote', '$idConsorcio')") or die(mysqli_error($conexion));
						if($insert){
							echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Bien hecho! Los datos han sido guardados con éxito.</div>';
						}else{
							echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. No se pudo guardar los datos !</div>';
                        }
                        
				}else{
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. Ya se encuentra registrada una Unidad Funcional en el Departamento '.$departamento.' del Piso '.$piso.' del Consorcio seleccionado !</div>';
				}
			}else{
                echo "Ocurrio un error en los siguientes campos: ";
                foreach($error as $er){
                    echo "</br><strong>$er</strong>";
                  }
				}
		}
			?>

			<form class="form-horizontal" action="" method="post">
                <div class="form-group">
					<label class="col-sm-3 control-label">Porcentaje</label>
					<div class="col-sm-4">
					<!-- TODO: Agregar validación de porcentaje -->
						<input type="number" name="porcentajeParticipacion" class="form-control" max="100" placeholder="Porcentaje" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Piso</label>
					<div class="col-sm-4">
						<input type="number" name="piso" class="form-control" max="100" placeholder="Piso" required>
					</div>
				</div>
                <div class="form-group">
					<label class="col-sm-3 control-label">Departamento</label>
					<div class="col-sm-4">
						<input type="text" name="departamento" class="form-control" placeholder="Departamento" required>
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