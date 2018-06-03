<?php
include_once '../../librerias/DataBase.php'
session_start();


$email=$_POST["emailUsuario"];
$pass=$_POST["passUsuario"];
$conexion = new DataBase();
$filas = $conexion->getLogin('usuarios', 'email', '$email', 'pass', '$pass'); 

if($filas == 1)
{
    $_SESSION['emailUsuario'] = $email;
    setcookie('cookie', $email, time()+3600);
    header('location: home.php');
}else{
    header('location: index.php');  
}

?>


