<?php
require_once '../config/Conexion.php'; 
session_start();
if(isset($_SESSION['username'])){} ?>

<!DOCTYPE html>
<html lang="es">
<?php include('template/head.php'); ?>

    <body>
    <?php 
        include('template/nav.php');  
        include('template/header.php'); ?>

        


    <div class="corte">
    </div>
    <?php include('template/footer.php'); ?>
    </body>

</html>