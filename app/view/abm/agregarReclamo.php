<?php
require_once '../../config/Conexion.php';
session_start();

// Permisos
if(!isset($_SESSION['admin']) && !isset($_SESSION['operador']) && !isset($_SESSION['propietario'])) {
	header("Location: ../index.php");
} 
?>

<!DOCTYPE html>
<html lang="es">
<?php include('../template/head.php'); ?>

    <body>
    <?php 
        include('../template/nav.php');  
        include('../template/header.php'); ?>

        <title>Consorcios del Valle - Iniciar Nuevo Reclamo</title>

        <div class="container">
		<div class="content">
			<h2>Reclamos &raquo; Iniciar Nuevo Reclamo</h2>
			<hr />
			
			<?php
			if(isset($_POST['add'])){
				$idPropiedad	= mysqli_real_escape_string($conexion, (strip_tags($_POST["idPropiedad"], ENT_QUOTES)));
				$descripcion	= mysqli_real_escape_string($conexion, (strip_tags($_POST["descripcion"], ENT_QUOTES)));
				// El Estado por default al iniciar reclamo es: Activo
				$estado			= mysqli_real_escape_string($conexion, (strip_tags("Activo", ENT_QUOTES)));
				
				// La fecha se setea desde MySQL a través de la funcion now()
				$insert = mysqli_query($conexion, "INSERT INTO reclamo(idPropiedad, descripcion, estado, fecha) VALUES('$idPropiedad', '$descripcion', '$estado', now())") or die(mysqli_error());
				
				if ($insert){
					echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Bien hecho! Se ha enviado el reclamo satisfactoriamente.</div>';
				} else {
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error: No se ha podido enviar el reclamo ingresado!</div>';
				}
			}
			?>

			<form class="form-horizontal" action="" method="post" id="reclamoForm">

				<div class="form-group">
					<label class="col-sm-3 control-label">Propiedad</label>
					<div class="col-sm-4">
						<select name="idPropiedad" class="form-control">
							<option disabled selected>Seleccione una propiedad...</option>
							<?php
								$idUsuario = $_SESSION['idUsuario'];
								$sql = mysqli_query($conexion, "SELECT * FROM propiedad WHERE idUsuarios='$idUsuario'");

								// TODO: Consultar si hay que actualizar query cuando este relacionado estos tipos de usuarios con los consorcios
								// TODO: Por ahora tienen acceso a todas las propiedades para poder reclamar...
								if (isset($_SESSION['admin']) || !isset($_SESSION['operador'])) {
									$sql = mysqli_query($conexion, "SELECT * FROM propiedad");
								}

								// TODO: No dejar que entre a esta pantalla si no tienen propiedades...
								// if (mysqli_num_rows($sql) == 0){
								// 	echo '<span>Usted no posee ninguna propiedad.</span>';
								// }

								// Lista propiedades asociadas al usuario actual
								while ($row = mysqli_fetch_assoc($sql)) { ?>
								<?php	echo '<option value="'.$row['idPropiedad'].'">Piso: '.$row['piso'].' - Deparamento: '.$row['departamento'].'</option>';
								}
							?>
						</select>
					</div>
				</div>				
			
                <div class="form-group">
					<label class="col-sm-3 control-label">Descripción</label>
					<div class="col">
						<textarea name="descripcion" form="reclamoForm" class="form-control" maxlength=100 required placeholder="Ingrese una descripción..."></textarea>
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-sm-6">
					<!-- TODO: Al tocar en cancelar ir al listado de reclamos o al home -->
						<a href="#" class="btn btn-sm btn-danger">Cancelar</a>
						<input type="submit" name="add" class="btn btn-sm btn-primary" value="Enviar Reclamo">
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