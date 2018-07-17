<?php
require_once '../config/Conexion.php'; 
session_start();
if(!isset($_SESSION['admin']) && !isset($_SESSION['operador']) && !isset($_SESSION['propietario'])) {
    header("Location: index.php");} ?>

<!DOCTYPE html>
<html lang="es">
<?php include('template/head.php'); ?>

    <body>
        <br><br><br>
        <title>Consorcios del Valle - Expensa Paga</title>

        <div class="container">
		<div class="content">
			<h2>Administración de Consorcios del Valle &raquo; Pago de Expensas</h2>
			<hr />


            
<?php
if (!isset($_GET["id"]) || empty($_GET["id"]) ) {
				echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error: La expensa indicada no existe o no tiene acceso a ella.</div>';
			} else {
				// escaping, additionally removing everything that could be (html/javascript-) code
				$idExpensa = mysqli_real_escape_string($conexion,(strip_tags($_GET["id"],ENT_QUOTES)));
            }
    
$sql = mysqli_query($conexion, 
					"SELECT *
					FROM expensa 
					INNER JOIN propiedad ON expensa.idPropiedad = propiedad.idPropiedad
                    INNER JOIN liquidacion ON liquidacion.idLiquidacion = expensa.idLiquidacion 
                    INNER JOIN ordenpago ON ordenpago.idExpensa = expensa.idExpensa 
                    INNER JOIN formasdepago ON formasdepago.idFormaPago = ordenpago.idFormaPago
					WHERE expensa.idExpensa = '$idExpensa';") or die(mysqli_error($conexion));
 $row = mysqli_fetch_assoc($sql);           
          echo '
<pre>PAGO APLICADO AL PERIODO '.date("m", strtotime($row['periodo'])).'/'.date("Y", strtotime($row['periodo'])).'
</pre>
<div class="col-xs-6 text-right">
            <div class="col-xs-6">
                <img alt="logo" width=160px  src="../../public/img/logo.jpg" >
            </div>
<h1>Comprobante de Pago realizado el '.date("d", strtotime($row['fecha'])).'-'.date("m", strtotime($row['fecha'])).'-'.date("Y", strtotime($row['fecha'])).'</h1>
<h4>•Nro. de Expensa : '.$idExpensa.' •--------------------- •Nro de Liquidacion : '.$row['idLiquidacion'].'•</h4>
</div>
</div>  
<div class="row">
<div class="col-xs-5">
<div class="panel panel-default">
<div class="panel-heading">
<h4>•Unidad Funcional: '.$row['unidadFuncionalLote'].' •--------------------- •Nro. de Consorcio: '.$row['idConsorcio'].'•</h4>
</div>
</div>
<hr />
<div class="indexder">
<div class="col-xs-5 col-xs-offset-2 text-right">
<div class="panel panel-default">
<div class="panel-heading">
<h1><small>Por un importe de: $'.$row['importe'].'.-</small></h1>
<small>Forma de Pago: '.$row['descripcion'].'</small>
</div>
<div class="panel-body"><b>Nro. de Control de Pago : '.$row['idOperacion'].'</b></div>
</div>
</div>
</div>
</div>
<pre>
';         
?>
            </div>
        </div>
        
    </body>

</html>