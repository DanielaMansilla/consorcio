<?php
require_once '../clases/Conexion.php'; 
session_start();
if(!isset($_SESSION['propietario'])){  // verificar si es propietario
    header("Location: ../index.php");} ?>

<!DOCTYPE html>
<html lang="es">
<?php include('../template/head.php'); ?>

    <body>
    <?php 
        include('../template/nav.php');  
        include('../template/header.php'); ?>
    
    <title>Consorcios del Valle - Propietario</title>
        
    <div class="corte">
    </div>
    <?php include('../template/footer.php'); ?>
    </body>
</html>