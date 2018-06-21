<?php
require_once 'Conexion.php'; 

$usuario = $_POST['emailUsuario'];
$pass = $_POST['passUsuario'];
$pass_sha1 = sha1($pass);

if(empty($usuario) || empty($pass)){
header("Location: ../index.php");
exit();
}
$sql = "SELECT * from usuarios where email='$usuario'";
$result = mysqli_query($conexion,$sql);

if($row = mysqli_fetch_array($result)){
if($row['pass'] == $pass_sha1){
session_start();
//COOKIE FUTURA
//setcookie('cookie',$usuario, time()+3600;
    
//Estado. Solo si es activo pasa.
if($row['estado'] == 'Activo'){

//Direccionamiento segun rol.

if($row['idRol'] == 0){
    $_SESSION['sinRol'] = $usuario;
    header("Location:../layout/sinRol.php");  // Vista informando que no tiene Rol.  // se puede poner todo junto en un 404.php y con if() de rol y estado poner distintos mensajes
}elseif($row['idRol'] == 1){
    $_SESSION['admin'] = $usuario;
    header("Location:../layout/homeAdmin.php");
}elseif($row['idRol'] == 2){
    $_SESSION['operador'] = $usuario;
    header("Location:../layout/homeOperador.php");
}elseif($row['idRol'] == 3){
    $_SESSION['propietario'] = $usuario;
    header("Location:../layout/homePropietario.php");
}
}else{
    $_SESSION['noActivo'] = $usuario;
    header("Location: ../layout/estadoNoActivo.php"); // Vista informando que tiene estado inactivo o pendiente.
}
}else{
header("Location: ../index.php");
exit();
}
}else{
header("Location: ../index.php");
exit();
}
/*ROLES
0 = Sin Rol
1 = Administrador
2 = Operador
3 = Propietario
*/ 
?>