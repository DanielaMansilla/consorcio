<?php
include '../clases/Usuario.php';
session_start();
if(isset($_SESSION['username'])){};   
$user1 = new Usuario();

?>

<!DOCTYPE html>
<html lang="es">
    
<?php include('../template/head.php'); ?>
    
<body>
    <?php 
        include('../template/nav.php');  
        include('../template/header.php'); ?>
        
                
<title>Consorcios del Valle - Lista de Roles de usuarios</title>

    <div class="container">
		<div class="content">
			<h2>Lista de roles</h2>
			<hr />
        <?php
        $user1::mostrarRol();
        ?>
		</div>
	</div>  

    <center>
    <div class="corte">
    </div>
    <?php include('../template/footer.php'); ?>
</body>

    </html>