<?php
session_start();
require_once '../../librerias/Conexion.php';



$email=$_POST["emailUsuario"];
$pass=$_POST["passUsuario"];
$conexion = new Conexion();
$filas = $conexion->getLogin('usuarios', 'email', '$email', 'pass', '$pass'); 

if($filas == 1)
{
    $_SESSION['emailUsuario'] = $email;
    setcookie('cookie', $email, time()+3600);
    header('location: ../home.php');
}else{
    header('location: ../index.php');  
}

?>


