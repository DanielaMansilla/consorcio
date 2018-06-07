<?php
include("../config/configurar.php");
session_start();
if(isset($_SESSION['username']))
{} ?>

<!DOCTYPE html>
<html>

<?php 
    include('template/head.php');   
    include ('template/header.php'); ?>  
    <body>
        <main> 
        </main> 
        <?php include('template/footer.php'); ?>
    </body>
</html>