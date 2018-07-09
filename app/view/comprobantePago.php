<?php
require_once '../config/Conexion.php'; 
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: index.php");} ?>

<!DOCTYPE html>
<html lang="es">
<?php include('template/head.php'); ?>

    <body>
        <br><br><br>
        <title>Consorcios del Valle - Expensa Paga</title>

        <div class="container">
		<div class="content">
			<h2>Consorcios del Valle &raquo; Pago de Expensas</h2>
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
                    INNER JOIN pago ON pago.idLiquidacion = liquidacion.idLiquidacion 
					WHERE expensa.idExpensa = '$idExpensa';") or die(mysqli_error($conexion));
 $row = mysqli_fetch_assoc($sql);           
          echo '
<pre>EL PAGO FUE APLICADO AL PERIODO '.$row['periodo'].'
</pre>
<div class="col-xs-6 text-right">
            <div class="col-xs-6">
                <img alt="logo" width=160px  src="../../public/img/logo.jpg" >
            </div>
<h1>Comprobante de Pago realizado el '.$row['fechaPago'].'</h1>
<h1><small>Expensa nro. '.$idExpensa.'</small></h1>
<div class="panel-body">Numero de Liquidacion : '.$row['idLiquidacion'].'</div>
</div>
</div>
 
<hr />
 
        
<div class="row">
<div class="col-xs-5">
<div class="panel panel-default">
<div class="panel-heading">
<h4>Unidad Funcional: '.$row['unidadFuncionalLote'].'</h4>
</div>
<div class="panel-body">Consorcio Numero: '.$row['idConsorcio'].'</div>
</div>
</div>
        <div class="medioindex">

        </div>
<div class="indexder">
<div class="col-xs-5 col-xs-offset-2 text-right">
<div class="panel panel-default">
<div class="panel-heading">
<h4>Por un importe de: $'.$row['importe'].'.-</h4>
</div>
<div class="panel-body"><b>Numero de Control de pago : '.$row['idPago'].'</b></div>
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