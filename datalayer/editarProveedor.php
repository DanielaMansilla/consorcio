<?php
//include 'C:/xampp/htdocs/consorcio/app/model/Proveedor.php';

//include '../../librerias/DataBase.php';
//echo dirname(__FILE__);
//echo __FILE__;
include '../clases/Proveedor.php';

session_start();
if(isset($_SESSION['username'])){};   
$proveedores3 = new Proveedor();

?>

<!DOCTYPE html>
<html lang="es">
    
<?php include('../template/head.php'); ?>
    
<body>
    <?php 
        include('../template/nav.php');  
        include('../template/header.php'); ?>
                
<title>Consorcios del Valle - Editar Proveedor</title>

    <div class="container">
		<div class="content">
			<h2>Datos de Proveedor - Editar</h2>
			<hr />

		</div>
	</div>  
<?php
$proveedores3::editarProveedores();
//$proveedores3::listarProveedores();
            
?>   
    <center>
    <div class="corte">
    </div>
    <?php include('../template/footer.php'); ?>
</body>

</html>