<?php
require_once '../../config/Conexion.php';
/*$host = '127.0.0.1';
     $user = 'root';
     $pass = '';
    $db = 'consorcio';
$conexion=mysqli_connect($host,$user,$pass,$db);*/
                   
                     $nombre=$_POST["nombreUsuario"];
                    $apellido=$_POST["apellidoUsuario"];
                   $cuilUsuario=$_POST["cuilUsuario"];
                     
 $email=$_POST["emailUsuario"];
$dni=$_POST["dniUsuario"];
$telUsuario=$_POST["telUsuario"];
$estado="Pendiente";
  $rol=1;
     $pass=$_POST["passUsuario"];
    $pass_md5 = md5($pass); //hashe*o de pass para que se guarde hasheada
                   
                  
                   
                    
                    
                    
                  
                   
                    $insertaUsuario = "insert into usuarios(nombre, apellido, cuil, email, dni, telefono,estado,idRol,pass) VALUES ('$nombre', '$apellido', '$cuilUsuario','$email','$dni',  '$telUsuario','$estado', '$rol', '$pass_md5')";

$resultado=mysqli_query($conexion,$insertaUsuario);

mysqli_close($conexion);



?>