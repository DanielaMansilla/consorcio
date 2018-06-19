<?php
require_once '../config/Conexion.php'; 
session_start();
if(!isset($_SESSION['admin'])){  // verificar si es admin
    header("Location: index.php");} ?>

<!DOCTYPE html>
<html lang="es">
<?php include('template/head.php'); ?>

    <body>
    <?php 
        include('template/nav.php');  
        include('template/header.php'); ?>

        
        
    <?php
    //Prueba conexion
    echo "Hola " . $_SESSION['admin'];
 
    ?>



    <div class="corte">
    </div>
    <?php include('template/footer.php'); ?>
    </body>

</html>