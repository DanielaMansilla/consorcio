<?php /* Mostrar monto total de expensas impagas O mostrar lista de expensas pasadas de fecha*/
require_once '../config/Conexion.php'; 
session_start();
if (!isset($_SESSION['propietario'])) {
    header("Location: index.php");
} 
?>

<!DOCTYPE html>
<html lang="es">
<?php include('template/head.php'); ?>
    <body>
    <?php 
        include('template/nav.php');  
        include('template/header.php'); ?>
    
    <title>Consorcios del Valle - Deudas</title>











    <div class="corte">
    </div>
        <?php include('template/footer.php'); ?>
    </body>
</html>