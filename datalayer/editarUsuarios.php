<?php
include '../model/Usuario.php';
session_start();
if(isset($_SESSION['username'])){};   
$user1 = new Usuario();

?>


<!DOCTYPE html>
<html lang="es">
    
<?php include('template/head.php'); ?>
    
<body>
    <?php 
        include('template/nav.php');  
        include('template/header.php'); ?>
        
                
<title>Consorcios del Valle - Editar Usuario</title>

    <div class="container">
		<div class="content">
			<h2>Datos del Usuario - Editar</h2>
			<hr />

		</div>
	</div>  
<?php
$user1::editarUsuarios();
            
?>     
    <center>
    <div class="corte">
    </div>
    <?php include('template/footer.php'); ?>
</body>

</html>