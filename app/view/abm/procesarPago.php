<?php
require_once '../../config/Conexion.php';
session_start();
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

        <title>Consorcios del Valle - Pagar Expensa</title>

        <div class="container">
		<div class="content">
			<h2>Expensas &raquo; Pagar Expensa</h2>
            <hr />
            <?php

            // Parametro external_reference de MercadoPago tiene una referencia al id de la expensa 
            if (!isset($_GET["collection_status"]) || empty($_GET["collection_status"]) || 
                !isset($_GET["external_reference"]) || empty($_GET["external_reference"]) ) {
                    echo '<div class="alert alert-danger alert-dismissable">Error: Su pago no pudo completarse correctamente!</div>';
            } else {
                // Forma de Pago siempre es MercadoPago si entra por aca
                $idExpensa = mysqli_real_escape_string($conexion,(strip_tags($_GET["external_reference"],ENT_QUOTES)));
                $estadoPago = mysqli_real_escape_string($conexion,(strip_tags($_GET["collection_status"],ENT_QUOTES)));
                // Id de forma de pago de MercadoPago
                $idFormaPago = "2"; 
                if ($estadoPago == "approved") {
                    // TODO: Obtener importe de la expensa por external_reference??
                    $selectImporteExpensa = mysqli_query($conexion, 
                    "SELECT importe, estado
                    FROM expensa
                    WHERE expensa.idExpensa = '$idExpensa';") or die(mysqli_error($conexion));

                    if (mysqli_num_rows($selectImporteExpensa) == 0){
                        echo '<div class="alert alert-danger alert-dismissable">Error: No se ha podido procesar el pago ya que la expensa no existe!</div>';
                    } else {
                        $expensa = mysqli_fetch_assoc($selectImporteExpensa);

                        // Si la expensa ya está paga no tengo que hacer nada
                        if ($expensa["estado"] == "Pago") {
                            echo '<div class="alert alert-warning alert-dismissable">Advertencia: La expensa ya fue pagada con anterioridad!</div>';
                        } else {
                            $importeExpensa = $expensa["importe"];

                            // Genero una nueva orden pago con un importe del 100%
                            $insertOrdenPago = mysqli_query($conexion, 
                            "INSERT INTO ordenpago(idExpensa, importe, fecha, idFormaPago) 
                            VALUES('$idExpensa', '$importeExpensa', now(), '$idFormaPago')") or die(mysqli_error($conexion));
                                        
                            if ($insertOrdenPago) {
                                $estadoExpensa = "Pago";
                                
                                // Actualizo el estado de la expensa
                                $updateExpensa = mysqli_query($conexion, "UPDATE expensa SET estado='$estadoExpensa' WHERE idExpensa='$idExpensa'") or die(mysqli_error($conexion));
                                if ($updateExpensa) {
                                    echo '<div class="alert alert-success alert-dismissable">Bien hecho! Se ha realizado el pago satisfactoriamente.</div>';
                                } else {
                                    echo '<div class="alert alert-danger alert-dismissable">Error: No se ha podido actualizar el estado de la expensa!</div>';
                                }
                            } else {
                                echo '<div class="alert alert-danger alert-dismissable">Error: No se ha podido procesar el pago!</div>';
                            }
                        }
                    }
                } else {
                    echo '<div class="alert alert-danger alert-dismissable">Error: Su pago no pudo completarse correctamente!</div>';
                }
            }

            ?>
        </div>

        <div class="form-group">
            <div class="col-sm-6">
                <a href="../listaExpensas.php" class="btn btn-sm btn-info">Volver</a>
            </div>
        </div>

  	<div class="corte"></div>
    <?php include('../template/footer.php'); ?>
    
    <?php
    // Para checkear el pago con MercadoPago...
    // require_once "../../lib/mercadopago.php";
    // //collection_id=3913128033&collection_status=approved&preference_id=334689624-ca17be46-8852-4e69-b798-52f57fda4eeb&external_reference=null&payment_type=credit_card&merchant_order_id=775825735
    // // Configuración de MercadoPago
    // $mp = new MP("426543208337217", "QvFA81UyiPK8pKl727ikvN43lraFFbmC");
    // $mp->sandbox_mode(TRUE);
    // // TODO: Validar que el pago se realizó verdaderamente, para validar los valores que vienen en los parámetros de la url
    // $filters = array (
    //     "status" => "approved",
    //     "external_reference"=> $idExpensa
    // );

    // $searchResult = $mp->search_payment ($filters, 0, 1);

    // print_r ($searchResult);
    // echo "<script>console.log( 'gastoTotalLiquidacion: " . json_encode($searchResult) . "' );</script>";

    ?>
    
	<!-- Cargar library JavaSCript de MercadoPago -->
	<!-- <script type="text/javascript">
	(function(){function $MPC_load(){window.$MPC_loaded !== true && (function(){var s = document.createElement("script");s.type = "text/javascript";s.async = true;s.src = document.location.protocol+"//secure.mlstatic.com/mptools/render.js";var x = document.getElementsByTagName('script')[0];x.parentNode.insertBefore(s, x);window.$MPC_loaded = true;})();}window.$MPC_loaded !== true ? (window.attachEvent ?window.attachEvent('onload', $MPC_load) : window.addEventListener('load', $MPC_load, false)) : null;})();
	</script> -->
    </body>
</html>