<?php
include '../clases/Proveedor.php';
session_start();
if(isset($_SESSION['username'])){};   
$proveedores = new Proveedor();

?>

<!DOCTYPE html>
<html lang="es">
    
<?php include('../template/head.php'); ?>
    
<body>
    <?php 
        include('../template/nav.php');  
        include('../template/header.php'); ?>
        
                
<title>Consorcios del Valle - Lista de Proveedores</title>

    <div class="container">
		<div class="content">
			<h2>Lista de proveedores</h2>
			<hr />
        <?php
        $proveedores::listarProveedores();
        ?>
		</div>
	</div>  

    <center>
    <div class="corte">
    </div>
    <?php include('../template/footer.php'); ?>
</body>

    </html>