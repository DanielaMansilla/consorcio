<?php
require_once 'Conexion.php'; 

$usuario = $_POST['emailUsuario'];
$pass = $_POST['passUsuario'];
$pass_sha1 = sha1($pass);

if(empty($usuario) || empty($pass)){
header("Location: ../view/index.php");
exit();
}
$sql = "SELECT * from usuarios where email='$usuario'";
$result = mysqli_query($conexion,$sql);

if($row = mysqli_fetch_array($result)){
if($row['pass'] == $pass_sha1){
session_start();
//COOKIE FUTURA
//setcookie('cookie',$usuario, time()+3600;
    
//Direccionamiento segun rol.

if($row['idRol'] == 0){
    $_SESSION['sinRol'] = $usuario;
    header("Location:../view/sinRol.php");  // Vista informando que no tiene Rol.
}elseif($row['idRol'] == 1){
    $_SESSION['admin'] = $usuario;
    header("Location:../view/homeAdmin.php");
}elseif($row['idRol'] == 2){
    $_SESSION['operador'] = $usuario;
    header("Location:../view/homeOperador.php");
}elseif($row['idRol'] == 3){
    $_SESSION['propietario'] = $usuario;
    header("Location:../view/homePropietario.php");
}
}else{
header("Location: ../view/index.php");
exit();
}
}else{
header("Location: ../view/index.php");
exit();
}
/*ROLES
0 = Sin Rol
1 = Administrador
2 = Operador
3 = Propietario
*/ 
?>