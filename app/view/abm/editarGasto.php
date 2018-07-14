<?php
session_start();
//Si es Admin o Operador puede visualizar la pagina.
if(!isset($_SESSION['admin'])){
	if(!isset($_SESSION['operador'])){ //verificar si el operador necesita editar.
		header("Location: ../index.php");}} ?>

<!DOCTYPE html>
<html lang="es">
<?php include('../template/head.php'); ?>

    <body>
    <?php 
        include('../template/nav.php');  
        include('../template/header.php'); ?>

        <title>Consorcios del Valle - Editar Gasto</title>

        <div class="container">
		<div class="content">
			<h2>Datos del Gasto &raquo; Editar Datos</h2>
			<hr />

			<?php
			// escaping, additionally removing everything that could be (html/javascript-) code
			$nik = mysqli_real_escape_string($conexion,(strip_tags($_GET["nik"],ENT_QUOTES)));
			$sql = mysqli_query($conexion, "SELECT * FROM gasto WHERE idGasto='$nik'");
			if(mysqli_num_rows($sql) == 0){
				header("Location: ../index.php");
			}else{
				$row = mysqli_fetch_assoc($sql);
			}
			if(isset($_POST['save'])){ 
				$nroFactura 	= mysqli_real_escape_string($conexion, (strip_tags($_POST["nroFactura"], ENT_QUOTES)));
				$importe		= mysqli_real_escape_string($conexion, (strip_tags($_POST["importe"], ENT_QUOTES)));
				$concepto		= mysqli_real_escape_string($conexion, (strip_tags($_POST["concepto"], ENT_QUOTES)));
				$fecha			= mysqli_real_escape_string($conexion, (strip_tags($_POST["fecha"], ENT_QUOTES)));

                   $update = mysqli_query($conexion, "UPDATE gasto SET nroFactura='$nroFactura', importe='$importe', concepto='$concepto', fecha='$fecha' WHERE idGasto='$nik'") or die(mysqli_error($conexion));
                    if($update){
                        //header("Location: editarConsorcio.php?nik=".$nik."&pesan=sukses");
                        echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Bien hecho! Los datos han sido modificados con éxito.</div>';
                    }else{
                        echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pudo guardar los datos.</div>';
                    }
                 }

                if(isset($_GET['pesan']) == 'sukses'){
                    echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Los datos han sido guardados con éxito.</div>';
			} ?>
            
		<form class="form-horizontal" action="" method="post">      
        		<div class="form-group">
					<label class="col-sm-3 control-label">Importe</label>
					<div class="input-group col-sm-3">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">$</span>
					</div>
						<!-- TODO: Modificar tipo de dato en importe de gastos, para que sea un float -->
						<!-- <input type="number" name="importe" step="0.01" class="form-control" placeholder="Importe" required> -->
						<input type="number" value="<?php echo $row ['importe']; ?>" name="importe" min="0.00" max="9999999999.99" step="0.01" class="form-control" placeholder="Ingrese el importe..." required>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-3 control-label">Concepto</label>
					<div class="col-sm-3">
						<input type="text" value="<?php echo $row ['concepto']; ?>" name="concepto" class="form-control" placeholder="Ingrese un concepto..." maxlength=100 required>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-3 control-label">Nro. Factura</label>
					<div class="col-sm-3">
						<!-- TODO: Corregir tipo de datos de numero de factura y aumentar length  -->
						<input type="text" value="<?php echo $row ['nroFactura']; ?>" name="nroFactura" class="form-control" placeholder="Ingrese el nro. de la factura" maxlength=11 required>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-3 control-label">Fecha</label>
					<div class="col-sm-3">
						<input type="date" value="<?php echo $row ['fecha']; ?>" name="fecha" class="form-control" required>
					</div>
				</div>
				
			<div class="form-group">
				<label class="col-sm-3 control-label">&nbsp;</label>
				<div class="col-sm-6">
					<input type="submit" name="save" class="btn btn-sm btn-primary" value="Guardar datos">
					<a href="../listaGastos.php" class="btn btn-sm btn-danger">Cancelar</a>
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