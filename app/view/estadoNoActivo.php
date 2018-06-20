<?php
require_once '../config/Conexion.php'; 
session_start();
if(!isset($_SESSION['noActivo'])){  // verificar si un usuario sin Rol.
    header("Location: index.php");} ?>

<!DOCTYPE html>
<html lang="es">
<?php include('template/head.php'); ?>

    <body>
    <?php 
        include('template/header.php'); ?>
    
    <title>Consorcios del Valle - Estado Pendiente-Inactivo</title>
    <br>
    <h5 class="center-align">No puedes visualizar esta pagina porque tienes un estado "Pendiente" o "Inactivo". Ponte en contacto con un administrador.</h5>

    <div class="corte">
    </div>
    <?php include('template/footer.php'); ?>
    </body>
</html>