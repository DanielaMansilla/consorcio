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
				$idExpensa = mysqli_real_escape_string($conexion,(strip_tags($_GET["id"],ENT_QUOTES)));

				if (isset($_SESSION['admin']) || !isset($_SESSION['operador'])) {
					$sql = mysqli_query($conexion, 
					"SELECT *
					FROM expensa 
					JOIN propiedad ON expensa.idPropiedad = propiedad.idPropiedad 
					WHERE expensa.idExpensa = '$idExpensa';") or die(mysqli_error($conexion));
				} else {
					$idUsuario = $_SESSION['idUsuario'];
					$sql = mysqli_query($conexion, 
					"SELECT *
					FROM expensa
					JOIN propiedad ON expensa.idPropiedad = propiedad.idPropiedad 
					WHERE propiedad.idUsuarios='$idUsuario'
					AND expensa.idExpensa = '$idExpensa';") or die(mysqli_error($conexion));
				}

				// No se encontró la expensa
				if (mysqli_num_rows($sql) == 0){
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error: La expensa indicada no existe o no tiene acceso a ella.</div>';
				} else {
					$expensa = mysqli_fetch_assoc($sql);
				}
			}

			// Si la expensa ya está paga no hacemos nada
			if (isset($_POST['pagar']) && $expensa["estado"] != 'Pago') {
				$importeExpensa = $expensa["importe"];
				if (isset($_POST["idFormaPago"])) {
					$idFormaPago = mysqli_real_escape_string($conexion, (strip_tags($_POST["idFormaPago"], ENT_QUOTES)));

					// Genero una nueva orden pago con un importe del 100%
					$insertOrdenPago = mysqli_query($conexion, 
					"INSERT INTO ordenpago(idExpensa, importe, fecha, idFormaPago) 
					VALUES('$idExpensa', '$importeExpensa', now(), '$idFormaPago')") or die(mysqli_error($conexion));
					
					if ($insertOrdenPago) {
						$estadoExpensa = "Pago";
						
						// Actualizo el estado de la expensa
						$updateReclamo = mysqli_query($conexion, "UPDATE expensa SET estado='$estadoExpensa' WHERE idExpensa='$idExpensa'") or die(mysqli_error($conexion));
						if ($updateReclamo) {
							echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Bien hecho! Se ha realizado el pago satisfactoriamente.</div>';
						} else {
							echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error: No se ha podido actualizar el estado de la expensa!</div>';
						}
					} else {
						echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error: No se ha podido procesar el pago!</div>';
					}
				} else {
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error: No se ha seleccionado ningun Medio de Pago!</div>';
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
						<input type="text" name="importeExpensa" readonly="readonly" value="$ <?php echo $expensa['importe']; ?>" class="form-control">
					</div>
				</div>

                <div class="form-group">
					<label class="col-sm-3 control-label">Fecha de Emisión</label>
					<div class="col-sm-4">
						<input type="date" name="fechaExpensa" readonly="readonly" value="<?php echo $expensa['fecha']; ?>" class="form-control">
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Fecha de Vencimiento</label>
					<div class="col-sm-4">
						<input type="date" name="vencimientoExpensa" readonly="readonly" value="<?php echo $expensa['vencimiento']; ?>" class="form-control">
					</div>
				</div>
				
                <div class="form-group">
					<label class="col-sm-3 control-label">Estado</label>
					<div class="col-sm-4">
						<input type="text" name="estadoExpensa" readonly="readonly" value="<?php echo $expensa['estado']; ?>" class="form-control" >
					</div>
				</div>
				</div>

				<?php 
					if ($expensa["estado"] != 'Pago') {
						?>
						<div class="form-group">
							<label class="col-sm-3 control-label">Medio de Pago</label>
							<div class="col-sm-4">
								<select required name="idFormaPago" class="form-control">
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
						<?php
					}
				?>

				<div class="form-group">
					<label class="col-sm-3 control-label">&nbsp;</label>
					<div class="col-sm-6">
						<a href="../listaExpensas.php" class="btn btn-sm btn-danger">Cancelar</a>
						<?php 
							if ($expensa["estado"] != 'Pago') {
								echo '<input type="submit" name="pagar" class="btn btn-sm btn-primary" value="Pagar">';
							}
						?>
					</div>
				</div>
			</form>
		</div>
		
	</div>

  	<div class="corte"></div>
    <?php include('../template/footer.php'); ?>
    </body>
</html>