<?php
session_start();
require_once 'Conexion.php'; 

$usuario = $_POST['emailUsuario'];
$pass = $_POST['passUsuario'];
$pass_sha1 = sha1($pass);



if(empty($usuario) || empty($pass)){
header("Location: ../view/index.php");
exit();
}
$sql = "SELECT * from usuarios where email='$usuario'";
$result = mysql_query($conexion,$sql);

if($row = mysql_fetch_array($result)){
if($row['pass'] == $pass_sha1){

$_SESSION['usuario'] = $usuario;
header("Location: ../view/home.php");
}else{
header("Location: ../view/index.php");
exit();
}
}else{
header("Location: ../view/index.php");
exit();
}

?>