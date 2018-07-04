<?php
require_once '../../config/Conexion.php';
session_start();

// Permisos
if(!isset($_SESSION['admin']) && !isset($_SESSION['operador'])) {
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

        <title>Consorcios del Valle - Agregar Nuevo Gasto</title>

        <div class="container">
		<div class="content">
			<h2>Gastos &raquo; Agregar Nuevo Gasto</h2>
			<hr />
			
			<?php
			if (isset($_POST['add'])) {
				$idReclamo		= mysqli_real_escape_string($conexion, (strip_tags($_POST["idReclamo"], ENT_QUOTES)));
				$idProveedor 	= mysqli_real_escape_string($conexion, (strip_tags($_POST["idProveedor"], ENT_QUOTES)));
				$nroFactura 	= mysqli_real_escape_string($conexion, (strip_tags($_POST["nroFactura"], ENT_QUOTES)));
				$importe		= mysqli_real_escape_string($conexion, (strip_tags($_POST["importe"], ENT_QUOTES)));
				$concepto		= mysqli_real_escape_string($conexion, (strip_tags($_POST["concepto"], ENT_QUOTES)));
				$fecha			= mysqli_real_escape_string($conexion, (strip_tags($_POST["fecha"], ENT_QUOTES)));
				
				// TODO: Ver que hacer con el estado inicial...
				$estado			= mysqli_real_escape_string($conexion, (strip_tags("Pago", ENT_QUOTES)));
				
				$insert = mysqli_query($conexion, 
				"INSERT INTO gasto(idReclamo, idProveedor, nroFactura, fecha, importe, concepto, estado) 
				VALUES('$idReclamo', '$idProveedor', '$nroFactura', '$fecha', '$importe', '$concepto', '$estado')") or die(mysqli_error($conexion));
				
				if ($insert) {
					$estadoReclamo = "Resuelto";
					// Luego de generar el gasto, ponemos el Reclamo como Resuelto
					$updateReclamo = mysqli_query($conexion, "UPDATE reclamo SET estado='$estadoReclamo' WHERE idReclamo='$idReclamo'") or die(mysqli_error($conexion));
					if ($updateReclamo) {
						echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Bien hecho! Se ha guardado el gasto satisfactoriamente.</div>';
					} else {
						echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error: No se ha podido actualizar el estado del reclamo seleccionado!</div>';
					}
				} else {
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error: No se ha podido enviar el gasto ingresado!</div>';
				}
			}
			?>

			<form class="form-horizontal" action="" method="post" id="reclamoForm">

				<div class="form-group">
					<label class="col-sm-3 control-label">Reclamo</label>
					<div class="col-sm-4">
						<select name="idReclamo" class="form-control">
							<option disabled selected>Seleccione un reclamo...</option>
							<?php
								$sql = mysqli_query($conexion, "SELECT * FROM reclamo JOIN propiedad ON reclamo.idPropiedad=propiedad.idPropiedad WHERE reclamo.estado <> 'Resuelto' ORDER BY reclamo.idReclamo DESC");

								//TODO: Debe estar la posibilidad de generar un gasto sin un reclamo asociado??
								// if (mysqli_num_rows($sql) == 0){
								// 	echo '<span>No hay reclamos disponibles.</span>';
								// }

								// Lista todos los reclamos disponibles
								while ($row = mysqli_fetch_assoc($sql)) { ?>
								<?php echo '<option value="'.$row['idReclamo'].'">'.$row['idReclamo'].' - Piso: '.$row['piso'].' - Dpto: '.$row['departamento'].' - '.substr($row['descripcion'], 0, 15).'...</option>';
								}
							?>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-3 control-label">Proveedor</label>
					<div class="col-sm-4">
						<select name="idProveedor" class="form-control">
							<option disabled selected>Seleccione un proveedor...</option>
							<?php
								$sql = mysqli_query($conexion, "SELECT * FROM proveedor ORDER BY nombre ASC");

								// if (mysqli_num_rows($sql) == 0){
								// 	echo '<span>No hay proveedores disponibles.</span>';
								// }

								// Lista todos los proveedores disponibles
								while ($row = mysqli_fetch_assoc($sql)) { ?>
								<?php echo '<option value="'.$row['idProveedor'].'">'.$row['nombre'].' - CUIT: '.$row['cuit'].'</option>';
								}
							?>
						</select>
					</div>
				</div>
			
				<div class="form-group">
					<label class="col-sm-3 control-label">Importe</label>
					<div class="col-sm-3">
						<!-- TODO: Modificar tipo de dato en importe de gastos, para que sea un float -->
						<!-- <input type="number" name="importe" step="0.01" class="form-control" placeholder="Importe" required> -->
						<input type="number" name="importe" step="1" min="0" class="form-control" placeholder="Ingrese el importe..." required>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-3 control-label">Concepto</label>
					<div class="col-sm-3">
						<input type="text" name="concepto" class="form-control" placeholder="Ingrese un concepto..." maxlength=100 required>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-3 control-label">Nro. Factura</label>
					<div class="col-sm-3">
						<!-- TODO: Corregir tipo de datos de numero de factura y aumentar length  -->
						<input type="text" name="nroFactura" class="form-control" placeholder="Ingrese el nro. de la factura" maxlength=11 required>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-3 control-label">Fecha</label>
					<div class="col-sm-3">
						<input type="date" name="fecha" class="form-control" required>
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-sm-6">
						<a href="../listaGastos.php" class="btn btn-sm btn-danger">Cancelar</a>
						<input type="submit" name="add" class="btn btn-sm btn-primary" value="Guardar Gasto">
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