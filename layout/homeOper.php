<?php
require_once '../clases/Conexion.php'; 
require_once '../clases/Configurar.php'; 
include '../clases/Proveedor.php';
session_start();
if(isset($_SESSION['username'])){};
require_once '../clases/DataBase.php'; 
$conexion = new DataBase();    
$proveedores = new Proveedor();

?>

<!DOCTYPE html>
<html lang="es">
    
<?php include('../template/head.php'); ?>
    
<body>
    <?php 
        include('../template/nav.php');  
        include('../template/header.php'); ?>
        
                
<title>Consorcios del Valle - Operador</title>

    <div class="container">
		<div class="content">
			<h2>Lista de proveedores</h2>
			<hr />
<?php
$proveedores::listarProveedores();

?>
		</div>
	</div>  

        
        
        


    <div class="corte">
    </div>
    <?php include('../template/footer.php'); ?>
</body>

</html>