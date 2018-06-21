<?php
session_start();
require_once '../clases/Conexion.php'; 
require_once '../clases/Usuario.php';

if(isset($_SESSION['username'])){} 
$user1 = new Usuario();
?>
<!DOCTYPE html>
<html lang="es">
<?php include('../template/head.php'); ?>
    


    <body>
    <?php 
        include('../template/nav.php');  
        include('../template/header.php'); ?>
        
 		<title>Consorcios del Valle - Administrador</title>

        <div class="container">
		<div class="content">
			<h2>Lista de usuarios pendientes</h2>
			<hr />
            
            
            
		</div>
	</div>  
		<?php
		$user1::listarUsuarios();
		            
?>     
    <div class="corte">
    </div>
    <?php include('../template/footer.php'); ?>
    </body>
</html>



       