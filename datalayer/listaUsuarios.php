<?php
include '../clases/Usuario.php';
session_start();
if(isset($_SESSION['username'])){};

$conexion = new DataBase();    
$users = new Usuario();

?>
<!DOCTYPE html>
<html lang="es">  
    <?php include('../template/head.php'); ?>  
    <body>
        <?php 
            include('../template/nav.php');  
            include('../template/header.php'); ?>
                       
    <title>Consorcios del Valle - Lista de Usuarios</title>

        <div class="container">
    		<div class="content">
    			<h2>Lista de Usuarios</h2>
    			<hr />
            <?php
                $users::listarUsuarios();      
            ?>
    		</div>
    	</div>  
        <center>
        <div class="corte">
        </div>
        <?php include('../template/footer.php'); ?>
    </body>
 </html>