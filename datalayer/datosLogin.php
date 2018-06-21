<?php
require_once '../clases/Conexion.php';
session_start();

$email=$_POST["emailUsuario"];
$pass=$_POST["passUsuario"];
$pass_sha1 = sha1($pass);


$busquedaUsuario = "SELECT * FROM usuarios where email='$email' and pass='$pass_sha1'";
$resultado=mysqli_query($conexion, $busquedaUsuario);  
//La manera de comprobarlo es que guardando el numero de columnas, si son mayor que 0 existe. 

if(mysqli_num_rows($resultado) == 0){
            echo "USUARIO INVALIDO"; 
            header("Location:../index.php");  
        } 
        else 
        { 
//Cuando el usuario ya existe creo otra varible donde compruebo el ROL de usuario que es
            
$busquedaRol= "SELECT idRol FROM usuarios WHERE email='$email'";
$rolUsuario=mysqli_query($conexion, $busquedaRol); 
            //Variable de sesion para usar mas adelante. 
            
$row = mysqli_fetch_array($rolUsuario);

    if ($row["idRol"] == 2) {
        header("Location:../layout/homeAdmin.php"); 
    }
    elseif ($row["idRol"] == 3) {
        header("Location:../layout/homeOper.php"); 
    }
    elseif ($row["idRol"] == 4) {
        header("Location:../layout/homeProp.php"); 
    }else{
        header("Location:../layout/homePendiente.php"); 
    }
}
            
mysql_close($conexion);


?>