<?php
require_once '../../config/Conexion.php'; 
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: ../index.php");} ?>

<!DOCTYPE html>
<html lang="es">
<?php include('../template/head.php'); ?>

    <body>
    <?php 
        include('../template/nav.php');  
        include('../template/header.php'); ?>

        <title>Consorcios del Valle - Pagar Expensa</title>

        <div class="container">
		<div class="content">
			<h2>Expensas &raquo; Pagar Expensa</h2>
			<hr />
			
			<?php

			// TODO: Mejorar control de errores
			if (!isset($_GET["id"]) || empty($_GET["id"]) ) {
				echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error: La expensa indicada no existe o no tiene acceso a ella.</div>';
			} else {
				// escaping, additionally removing everything that could be (html/javascript-) code
				$id = mysqli_real_escape_string($conexion,(strip_tags($_GET["id"],ENT_QUOTES)));

				if (isset($_SESSION['admin']) || !isset($_SESSION['operador'])) {
					$sql = mysqli_query($conexion, 
					"SELECT *
					FROM expensa 
					JOIN propiedad ON expensa.idPropiedad = propiedad.idPropiedad 
					WHERE expensa.idExpensa = '$id';") or die(mysqli_error($conexion));
				} else {
					$idUsuario = $_SESSION['idUsuario'];
					$sql = mysqli_query($conexion, 
					"SELECT *
					FROM expensa
					JOIN propiedad ON expensa.idPropiedad = propiedad.idPropiedad 
					WHERE propiedad.idUsuarios='$idUsuario'
					AND expensa.idExpensa = '$id';") or die(mysqli_error($conexion));
				}

				// No se encontró la expensa
				if (mysqli_num_rows($sql) == 0){
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error: La expensa indicada no existe o no tiene acceso a ella.</div>';
				} else {
					$expensa = mysqli_fetch_assoc($sql);
				}
			}

			?>

			<form class="form-horizontal" action="" method="post">
				<div class="form-group">
						<label class="col-sm-3 control-label"><b>Propiedad:</b></label>
						<div class="col-sm-4">
							<label class="col control-label">Piso: <?php echo $expensa['piso']; ?></label>
							<label class="col control-label">Departamento: <?php echo $expensa['departamento']; ?></label>
						</div>
				</div>

            	<div class="form-group">
					<label class="col-sm-3 control-label">Importe</label>
					<div class="col-sm-4">
						<input type="text" name="importeExpensa" disabled value="$ <?php echo $expensa['importe']; ?>" class="form-control" placeholder="Apellido" >
					</div>
				</div>

                <div class="form-group">
					<label class="col-sm-3 control-label">Fecha de Emisión</label>
					<div class="col-sm-4">
						<input type="date" name="fechaExpensa" disabled value="<?php echo $expensa['fecha']; ?>" class="form-control" placeholder="Nombre" >
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Fecha de Vencimiento</label>
					<div class="col-sm-4">
						<input type="date" name="vencimientoExpensa" disabled value="<?php echo $expensa['vencimiento']; ?>" class="form-control" placeholder="Cuil" >
					</div>
				</div>
				
                <div class="form-group">
					<label class="col-sm-3 control-label">Estado</label>
					<div class="col-sm-4">
						<input type="text" name="estadoExpensa" disabled value="<?php echo $expensa['estado']; ?>" class="form-control" placeholder="E-mail" >
					</div>
				</div>
				</div>

				<div class="form-group">
					<label class="col-sm-3 control-label">Medio de Pago</label>
					<div class="col-sm-4">
						<select name="idReclamo" class="form-control">
							<option disabled selected>Seleccione un medio de pago...</option>
							<?php
								$sql = mysqli_query($conexion, 
								"SELECT *
								FROM formasdepago
								ORDER BY formasdepago.descripcion ASC");

								// Lista todos los medios de pago disponibles
								while ($row = mysqli_fetch_assoc($sql)) {
									// Los propietarios no pueden pagar en Efectivo
									if ($row['descripcion'] == 'Efectivo' && !isset($_SESSION['propietario'])) {
										echo '<option value="'.$row['idFormaPago'].'">'.$row['descripcion'].'</option>';
									} else {
										echo '<option value="'.$row['idFormaPago'].'">'.$row['descripcion'].'</option>';
									}
								}
								?>
						</select>
					</div>
				</div>
			
				<div class="form-group">
					<label class="col-sm-3 control-label">&nbsp;</label>
					<div class="col-sm-6">
						<a href="../listaExpensas.php" class="btn btn-sm btn-danger">Cancelar</a>	
						<input type="submit" name="pagar" class="btn btn-sm btn-primary" value="Pagar">
					</div>
				</div>
			</form>
		</div>

		
	</div>

  	<div class="corte"></div>
    <?php include('../template/footer.php'); ?>
    </body>
</html>