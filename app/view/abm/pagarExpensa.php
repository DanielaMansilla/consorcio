<?php
require_once '../../config/Conexion.php';
session_start();
if(!isset($_SESSION['admin']) && !isset($_SESSION['operador']) && !isset($_SESSION['propietario'])) {
	header("Location: ../index.php");
}

// MercadoPago:
// 
// Tarjetas de Crédito de Prueba: (Argentina)
// ------------------------------------------
// Visa: 4509 9535 6623 3704
// MasterCard: 5031 7557 3453 0604
// American Express: 3711 803032 57522

// Estados del Pago: (Poner en Nombre y Apellido)
// ----------------------------------------------
// APRO : Payment approved.
// CONT : Pending payment.
// CALL : Payment declined, call to authorize.
// FUND : Payment declined due to insufficient funds.
// SECU : Payment declined by security code.
// EXPI : Payment declined by expiration date.
// FORM : Payment declined due to error in form.
// OTHE : General decline.

// Usuario de Prueba: 
// usuario: test_user_48440768@testuser.com
// contraseña: qatest1408


require_once "../../lib/mercadopago.php";

// Configuración de MercadoPago
$mp = new MP("426543208337217", "QvFA81UyiPK8pKl727ikvN43lraFFbmC");
$mp->sandbox_mode(TRUE);
?>

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
				echo '<div class="alert alert-danger alert-dismissable">Error: La expensa indicada no existe o no tiene acceso a ella.</div>';
			} else {
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
					echo '<div class="alert alert-danger alert-dismissable">Error: La expensa indicada no existe o no tiene acceso a ella.</div>';
				} else {
					$expensa = mysqli_fetch_assoc($sql);

					// Configuracion para MercadoPago
					$preference_data = array(
						"items" => array(
							array(
								"id" => $idExpensa,
								"title" => "Pago de Expensa",
								"description" => "",
								"category_id" => "services",
								"currency_id" => "ARS",
								"quantity" => 1,
								"unit_price" => (float) $expensa["importe"]
							)
							),
							"back_urls" => array(
								// Si el pago fue exitoso:
								"success" => "http://localhost/consorcio/app/view/abm/procesarPago.php",
								// Si el pago falló:
								"failure" => "http://localhost/consorcio/app/view/procesarPago.php",
								// Si el pago esta pendiente:
								"pending" => "http://localhost/consorcio/app/view/procesarPago.php"
							),
							"external_reference" => $idExpensa
					);
					$preference = $mp->create_preference($preference_data);
					?>
				<?php
				}
			}

			// Si la expensa ya está paga no hacemos nada
			if (isset($_POST['pagar']) && $expensa["estado"] != 'Pago') {
				$importeExpensa = $expensa["importe"];
				if (isset($_POST["idFormaPago"])) {
					$idFormaPago = mysqli_real_escape_string($conexion, (strip_tags($_POST["idFormaPago"], ENT_QUOTES)));
					// Si es en efectivo
					if ($idFormaPago == "1") {
						// Genero una nueva orden pago con un importe del 100%
						$insertOrdenPago = mysqli_query($conexion, 
						"INSERT INTO ordenpago(idExpensa, importe, fecha, idFormaPago) 
						VALUES('$idExpensa', '$importeExpensa', now(), '$idFormaPago')") or die(mysqli_error($conexion));
						
						if ($insertOrdenPago) {
							$estadoExpensa = "Pago";
							
							// Actualizo el estado de la expensa
							$updateExpensa = mysqli_query($conexion, "UPDATE expensa SET estado='$estadoExpensa' WHERE idExpensa='$idExpensa'") or die(mysqli_error($conexion));
							if ($updateExpensa) {
								echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Bien hecho! Se ha realizado el pago satisfactoriamente.</div>';
							} else {
								echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error: No se ha podido actualizar el estado de la expensa!</div>';
							}
						} else {
							echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error: No se ha podido procesar el pago!</div>';
						}
					} else {
							echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error: No se ha podido procesar el pago!</div>';
					}
				} else {
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error: No se ha seleccionado ningun Medio de Pago!</div>';
				}
			}
			?>

		<?php
			if (isset($expensa)) {
				if ($expensa["estado"] == "Pago") {
					echo '<div class="alert alert-warning alert-dismissable">Aviso: Esta expensa ya ha sido pagada.</div>';
				}
		?>
			<form class="form-horizontal" action="" method="post">
				<div class="form-group">
						<label class="col-sm-3 control-label"><b>Propiedad:</b></label>
						<div class="col-sm-4">
							<label class="col control-label">Piso: <?php echo $expensa['piso']; ?></label>
							<label class="col control-label">Departamento: <?php echo $expensa['departamento']; ?></label>
							<label class="col control-label">Porcentaje de Participación: <?php echo $expensa['porcentajeParticipacion']; ?></label>
							<label class="col control-label">Lote Unidad Funcional: <?php echo $expensa['unidadFuncionalLote']; ?></label>
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
						<input type="text" name="estadoExpensa" readonly="readonly" style="color: <?php echo ($expensa['estado']) == "Impago" ? "red" : "green" ?>" value="<?php echo $expensa['estado']; ?>" class="form-control" >
					</div>
				</div>
				</div>

				<?php 
					if ($expensa["estado"] != 'Pago') {
						?>
						<div class="form-group">
							<label class="col-sm-3 control-label">Medio de Pago</label>
							<div class="col-sm-4">
								<select required name="idFormaPago" class="form-control" onchange="cambioFormaPago(this);">
									<option disabled selected>Seleccione un medio de pago...</option>
									<?php
										$sql = mysqli_query($conexion, 
										"SELECT *
										FROM formasdepago
										ORDER BY formasdepago.descripcion ASC");

										// Lista todos los medios de pago disponibles
										while ($row = mysqli_fetch_assoc($sql)) {
											// Los propietarios no pueden pagar en Efectivo
											if (isset($_SESSION['propietario']) && $row['descripcion'] == 'Efectivo') {
												// No agrego esta forma de pago
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

	<script type="text/javascript">
	function cambioFormaPago (value) {
		var botonPagar = document.getElementById("botonPagar");
		var botonMercadoPago = document.getElementById("botonMercadoPago");

		if (value.options[value.selectedIndex].text === 'MercadoPago') {
			botonMercadoPago.style.visibility = 'visible';
			botonPagar.style.visibility = 'collapse';
		} else {
			botonMercadoPago.style.visibility = 'collapse';
			botonPagar.style.visibility = 'visible';
		}
	}
	</script>
		<?php
			if ($expensa["estado"] != 'Pago') {
				?>
					<div class="form-group">
						<div class="col-sm-6">
							<a href="../listaExpensas.php" class="btn btn-sm btn-danger">Cancelar</a>
							<?php 
								if ($expensa["estado"] != 'Pago') {
									echo '<input type="submit" style="visibility: collapse;" name="pagar" id="botonPagar" class="btn btn-sm btn-primary" value="Pagar">';
								}
							?>
							<a href="<?php echo $preference["response"]["init_point"]; ?>" style="visibility: collapse;" mp-mode="modal" name="MP-Checkout" id="botonMercadoPago" class="btn btn-sm btn-primary">Pagar</a>
						</div>
					</div>
					<!-- Pagar con Código QR -->
					<div class="form-group">
						<div class="col-sm-6">
							<button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#pagarCodigoQr">Pagar con Código QR</button>
						</div>
					</div>
				</form>
			</div>
					<!-- Modal Pago con Código QR -->
					<div class="modal fade" id="pagarCodigoQr" tabindex="-1" role="dialog" aria-labelledby="pagarCodigoQr" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">MercadoPago - Pagar con Código QR</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<!-- <h3 class="text-center">Escaneá y pagá desde tu celular</h3> -->
							<div class="text-center">
								<!-- <img class="img-thumbnail" src="https://chart.googleapis.com/chart?chs=350x350&amp;cht=qr&amp;chl=00020101021143630016com.mercadolibre0139https%3A%2F%2Fmpago.la%2Fs%2Fqr%2F334686026%2Fdefault50150011200111111155204970053030325802AR5910XXXXX%20XXXX6004CABA63043B2E&amp;choe=UTF-8" alt="QR de Pago"> -->
								<img class="img-thumbnail" src="/consorcio/public/img/mercado-pago-qr.png" alt="QR de Pago">
							</div>
						</div>
						</div>
					</div>
					</div>
				<?php
			}
		}
		?>
	</div>

  	<div class="corte"></div>
	<?php include('../template/footer.php'); ?>

	<!-- Cargar library JavaSCript de MercadoPago -->
	<script type="text/javascript">
	(function(){function $MPC_load(){window.$MPC_loaded !== true && (function(){var s = document.createElement("script");s.type = "text/javascript";s.async = true;s.src = document.location.protocol+"//secure.mlstatic.com/mptools/render.js";var x = document.getElementsByTagName('script')[0];x.parentNode.insertBefore(s, x);window.$MPC_loaded = true;})();}window.$MPC_loaded !== true ? (window.attachEvent ?window.attachEvent('onload', $MPC_load) : window.addEventListener('load', $MPC_load, false)) : null;})();
	</script>
    </body>
</html>