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

$_SESSION['idUsuario'] = $row['idUsuarios'];

//Estado. Solo si es activo pasa.
if($row['estado'] == 'Activo'){

//Direccionamiento segun rol.

if($row['idRol'] == 4){
    $_SESSION['sinRol'] = $usuario;
    header("Location:../view/sinRol.php");  // Vista informando que no tiene Rol.  // se puede poner todo junto en un 404.php y con if() de rol y estado poner distintos mensajes
}
elseif($row['primeraVez'] == 1){
    $_SESSION['primeraVez'] = $usuario;
    header("Location:../view/abm/cambiarPass.php");
}
elseif($row['idRol'] == 1){
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
    $_SESSION['noActivo'] = $usuario;
    header("Location: ../view/estadoNoActivo.php"); // Vista informando que tiene estado inactivo o pendiente.
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
1 = Administrador
2 = Operador
3 = Propietario
4 = Sin Rol
*/ 
?>